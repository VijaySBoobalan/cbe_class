<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\PreparationTypes;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PreparationTypesController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $PreparationTypes =  PreparationTypes::get();
            return DataTables::of($PreparationTypes)
                ->addIndexColumn()
                ->addColumn('action', function ($PreparationTypes) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('preparation_type_update','preparation_type_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('preparation_type_update')){
                        $btn .= '<a href="#" class="btn EditPreparationType" id="'.$PreparationTypes->id.'" data-toggle="modal" data-target="#editPreparationTypeModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('preparation_type_delete')){
                        $btn .= '<a href="#" id="'.$PreparationTypes->id.'" class="btn DeletePreparationType" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.preparation_type.view');
    }

    public function create(Request $request)
    {

    }

    public function PreparationTypestore (Request $request){
        try{
            $PreparationTypes = new PreparationTypes;
            $PreparationTypes->preparation_type = $request->preparation_type;
            $PreparationTypes->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function PreparationTypeedit(Request $request){
        try {
            $Data['PreparationTypes'] = PreparationTypes::findorfail(request('preparation_type_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Question Type Not Found!']);
        }
    }

    public function PreparationTypeUpdate (Request $request)
    {
        try {
            $PreparationTypes = PreparationTypes::findorfail($request->preparation_type_id);
            $PreparationTypes->preparation_type = $request->preparation_type;
            $PreparationTypes->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function PreparationTypeDelete(Request $request){
        try {
            $PreparationTypes = PreparationTypes::findorfail($request->preparation_type_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
}
