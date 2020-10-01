<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\QuestionModel;
use App\QuestionTypes;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class QuestionModelController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $QuestionModel =  QuestionModel::get();
            return DataTables::of($QuestionModel)
                ->addIndexColumn()
                ->addColumn('action', function ($QuestionModel) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('questions_model_update','questions_model_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('questions_model_update')){
                        $btn .= '<a href="#" class="btn EditQuestionModel" id="'.$QuestionModel->id.'" data-toggle="modal" data-target="#editQuestionModelModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('questions_model_delete')){
                        $btn .= '<a href="#" id="'.$QuestionModel->id.'" class="btn DeleteQuestionModel" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['QuestionTypes'] =  QuestionTypes::get();
        return view('master.questions_model.view',$data);
    }

    public function create(Request $request)
    {

    }

    public function QuestionModelstore (Request $request){
        try{
            $QuestionModel = new QuestionModel;
            $QuestionModel->question_model = $request->question_model;
            $QuestionModel->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function QuestionModeledit(Request $request){
        try {
            $data['QuestionTypes'] =  QuestionTypes::get();
            $Data['QuestionModel'] = QuestionModel::findorfail(request('question_model_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Question Type Not Found!']);
        }
    }

    public function QuestionModelUpdate (Request $request)
    {
        try {
            $QuestionModel = QuestionModel::findorfail($request->question_model_id);
            $QuestionModel->question_model = $request->question_model;
            $QuestionModel->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function QuestionModelDelete(Request $request){
        try {
            $QuestionModel = QuestionModel::findorfail($request->question_model_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
}
