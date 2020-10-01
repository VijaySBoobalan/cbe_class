<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\QuestionTypes;
use App\Segregation;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SegregationController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $Segregation =  Segregation::get();
            return DataTables::of($Segregation)
                ->addIndexColumn()
                ->editColumn('question_type', function ($Segregation) {
                    return $Segregation->QuestionTypes->question_name;
                })
                ->addColumn('action', function ($Segregation) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('segregation_update','segregation_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('segregation_update')){
                        $btn .= '<a href="#" class="btn EditSegregation" id="'.$Segregation->id.'" data-toggle="modal" data-target="#editSegregationModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('segregation_delete')){
                        if($Segregation->is_default != 1){
                            $btn .= '<a href="#" id="'.$Segregation->id.'" class="btn DeleteSegregation" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['QuestionTypes'] =  QuestionTypes::get();
        return view('master.segregation.view',$data);
    }

    public function create(Request $request)
    {

    }

    public function Segregationstore (Request $request){
        try{
            $Segregation = new Segregation;
            $Segregation->question_type_id = $request->question_type_id;
            $Segregation->segregation = $request->segregation;
            $Segregation->is_default = 0;
            $Segregation->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function Segregationedit(Request $request){
        try {
            $data['QuestionTypes'] =  QuestionTypes::get();
            $Data['Segregation'] = Segregation::findorfail(request('segregation_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Question Type Not Found!']);
        }
    }

    public function SegregationUpdate (Request $request)
    {
        try {
            $Segregation = Segregation::findorfail($request->segregation_id);
            $Segregation->question_type_id = $request->question_type_id;
            $Segregation->segregation = $request->segregation;
            $Segregation->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function SegregationDelete(Request $request){
        try {
            $Segregation = Segregation::findorfail($request->segregation_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
}
