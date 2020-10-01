<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use App\ClassSection;
use App\Subject;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ClassSectionController extends Controller
{
    public function __construct()
    {
        if(env('APP_ENV') == 'production'){
            $this->middleware('auth');
            $this->middleware('permission:class_section_view|class_section_create|class_section_update|class_section_delete', ['only' => ['index','show','create','store','edit','update','destroy']]);
            $this->middleware('permission:class_section_view', ['only' => ['index']]);
            $this->middleware('permission:class_section_create', ['only' => ['create','store']]);
            $this->middleware('permission:class_section_update', ['only' => ['edit','update']]);
            $this->middleware('permission:class_section_delete', ['only' => ['destroy']]);
        }
    }

    public function index()
    {
        if (request()->ajax()) {
            $ClassSection =  ClassSection::get();
            return DataTables::of($ClassSection)
                ->addIndexColumn()
                ->addColumn('action',
                    '<a href="#" class="btn EditSection" id="{{ $id }}" data-toggle="modal" data-target="#editSectionModal">
                        <i class="fa fa-pencil text-aqua"></i>
                    </a>
                    <a href="#" id="{{ $id }}" class="btn DeleteSection" data-toggle="modal" data-target="#DeleteModel">
                        <i class="fa fa-trash-o" style="color:red;"></i>
                    </a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.class_section.view');
    }

    public function create(Request $request)
    {

    }

    public function storeSection (Request $request){
        try{
            $Class_sections = new ClassSection;
            $Class_sections->class = $request->class;
            $Class_sections->section = $request->section;
            $Class_sections->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function editSection(Request $request){
        try {
            $Data['Section'] = ClassSection::findorfail(request('section_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Section Not Found!']);
        }
    }

    public function UpdateSection (Request $request)
    {
        try {
            $ClassSection = ClassSection::findorfail($request->section_id);
            $ClassSection->class = $request->class;
            $ClassSection->section = $request->section;
            $ClassSection->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function DeleteSection(Request $request){
        try {
            $Subject = Subject::where('section_id',$request->section_id)->get();
            if (!empty($Subject)) {
                $Data['status'] = 'error';
                return response()->json($Data);
            }
            $ClassSection = ClassSection::findorfail($request->section_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function getSection(Request $request)
    {
        return ClassSection::where('class',$request->student_class)->get();
    }
}
