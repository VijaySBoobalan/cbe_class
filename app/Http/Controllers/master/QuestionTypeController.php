<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\QuestionTypes;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class QuestionTypeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $QuestionTypes =  QuestionTypes::get();
            return DataTables::of($QuestionTypes)
                ->addIndexColumn()
                ->addColumn('action', function ($QuestionTypes) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('questions_type_update','questions_type_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('questions_type_update')){
                        $btn .= '<a href="#" class="btn EditQuestionTypes" id="'.$QuestionTypes->id.'" data-toggle="modal" data-target="#editQuestionTypesModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('questions_type_delete')){
                        if($QuestionTypes->is_default != 1){
                            $btn .= '<a href="#" id="'.$QuestionTypes->id.'" class="btn DeleteQuestionTypes" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                        }
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.questions_type.view');
    }

    public function create(Request $request)
    {

    }

    public function QuestionTypestore (Request $request){
        try{
            $QuestionTypes = new QuestionTypes;
            $QuestionTypes->question_type = $request->question_type;
            $QuestionTypes->is_default = 0;
            $QuestionTypes->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function QuestionTypeedit(Request $request){
        try {
            $Data['QuestionTypes'] = QuestionTypes::findorfail(request('question_type_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Question Type Not Found!']);
        }
    }

    public function QuestionTypeUpdate (Request $request)
    {
        try {
            $QuestionTypes = QuestionTypes::findorfail($request->question_type_id);
            $QuestionTypes->question_type = $request->question_type;
            $QuestionTypes->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function QuestionTypeDelete(Request $request){
        try {
            $QuestionTypes = QuestionTypes::findorfail($request->question_type_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
}
