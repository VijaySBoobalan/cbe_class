<?php

namespace App\Http\Controllers\master;

use App\ClassSection;
use App\Http\Controllers\Controller;
use App\StaffScheduleSubjectDetails;
use App\StaffSubjectAssign;
use App\Subject;
use App\Chapter;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ClassSection'] = ClassSection::get()->unique('class');
        if (request()->ajax()) {
            $Subjects =  Subject::get();
            return DataTables::of($Subjects)
                ->addIndexColumn()
                ->addColumn('section_id', function ($Subjects) {
                    return $Subjects->ClassSection->section;
                })
                ->addColumn('action',
                    '<a href="#" class="btn EditSubject" id="{{ $id }}" data-toggle="modal" data-target="#editSubjectModal">
                        <i class="fa fa-pencil text-aqua"></i>
                    </a>
                    <a href="#" id="{{ $id }}" class="btn DeleteSubject" data-toggle="modal" data-target="#DeleteModel">
                        <i class="fa fa-trash-o" style="color:red;"></i>
                    </a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('master.subject.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function getClasssubjects(Request $request){
		  $Subject = Subject::where('class',$request->class_id)->get();
		 foreach($Subject as $key=>$sub){
			 $sub_id=$sub->id;
			 $Subject[$key]['chapter_count']=Chapter::where('subject_id',$sub_id)->count();
		 }
		 return $Subject;
	}
    public function create()
    {
        try {
            $Data['Subject'] = Subject::findorfail(request('subject_id'));
            $data['ClassSection'] = ClassSection::get()->unique('class');
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Subject Not Found!']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $Subject = new Subject;
            $Subject->class = $request->class;
            $Subject->section_id = $request->section_id;
            $Subject->subject_name = $request->subject_name;
            $Subject->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function UpdateSubject (Request $request)
    {
        try {
            $Subject = Subject::findorfail($request->subject_id);
            $Subject->class = $request->class;
            $Subject->section_id = $request->section_id;
            $Subject->subject_name = $request->subject_name;
            $Subject->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function DeleteSubject (Request $request)
    {
        try {
            $StaffSubjectAssign = StaffSubjectAssign::where('subjects',$request->section_id)->get();
            if (!empty($StaffSubjectAssign)) {
                $Data['status'] = 'error';
                return response()->json($Data);
            }
            $Subject = Subject::findorfail($request->subject_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
