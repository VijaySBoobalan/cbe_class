<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\Student;
use App\Subject;
use App\Homework;
use App\StudentHomeworkList;
use File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HomeworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->user_type=="Student"){
            $Student= Student::where('email', auth()->user()->email)->first();
            $class = $Student['student_class'];
            $section_id = $Student['section_id'];
			$ClassHomework = Homework::where([['homework.class_id',$class],['homework.section_id', $section_id],['homework.student_id',null]])
                ->leftJoin('users','users.id','=','homework.staff_id')
                ->leftJoin('subjects','subjects.id','=','homework.subject_id')
                ->select('homework.id as homework_id','homework.*','users.name as staff_name','subjects.*')
                ->get()
                ->toArray();
            $StudentsHomework = Homework::where([['homework.class_id',$class],['homework.section_id', $section_id],['homework.student_id',auth()->user()->id]])
                ->leftJoin('users','users.id','=','homework.staff_id')
                ->leftJoin('subjects','subjects.id','=','homework.subject_id')
                ->select('homework.id as homework_id','homework.*','users.name as staff_name','subjects.*')
                ->get()
                ->toArray();
                $Data['ClassHomework'] = array_merge($ClassHomework,$StudentsHomework);
            foreach($Data['ClassHomework'] as $key=>$value){
                $homework_id= $value['homework_id'];
                $Data['ClassHomework'][$key]['submitted'] =$this->checksubmitted($homework_id);
            }
            return view('student.homework.view',$Data);
        }else{
            $data['Subject'] = Subject::get();
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
                        <i class="fa fa-outdent"></i>
                        </a>
                        <a href="#" class="btn EditSubject" id="{{ $id }}" data-toggle="modal" data-target="#editSubjectModal">
                            <i class="fa fa-pencil text-aqua"></i>
                        </a>
                        <a href="#" id="{{ $id }}" class="btn DeleteSubject" data-toggle="modal" data-target="#DeleteModel">
                            <i class="fa fa-trash-o" style="color:red;"></i>
                        </a>'
                    )
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('homework.view',$data);
        }
    }
	public function checksubmitted($homework_id){
		return  $submittedhomeworks = StudentHomeworkList::where([['homework_id', $homework_id], ['student_id', auth()->user()->id]])
        ->get()->toArray();
    }

    public function classhomework(){
        if (request()->ajax()) {
            if(auth()->user()->user_type == 'Student'){
                $Student= Student::where('email', auth()->user()->email)->first();
                $class = $Student['student_class'];
                $section_id = $Student['section_id'];
                $ClassHomework = DB::table('homework')
                ->where([['homework.homework_type','class'],['homework.class_id',$class],['homework.section_id',$section_id]])
                ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
                ->leftJoin('users','users.id','=','homework.staff_id')
                ->leftJoin('subjects','subjects.id','=','homework.subject_id')
                ->select('homework.id as homework_id','homework.*','users.name','subjects.*','class_sections.*')
                ->get();
            }else if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'super_admin'){
                $ClassHomework = DB::table('homework')
                ->where([['homework.homework_type','class']])
                ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
                ->leftJoin('users','users.id','=','homework.staff_id')
                ->leftJoin('subjects','subjects.id','=','homework.subject_id')
                ->select('homework.id as homework_id','homework.*','users.name','subjects.*','class_sections.*')
                ->get();
            }else if(auth()->user()->user_type == 'Staff'){
                $ClassHomework = DB::table('homework')
                ->where([['homework.homework_type','class'],['homework.staff_id',auth()->user()->id]])
                ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
                ->leftJoin('users','users.id','=','homework.staff_id')
                ->leftJoin('subjects','subjects.id','=','homework.subject_id')
                ->select('homework.id as homework_id','homework.*','users.name','subjects.*','class_sections.*')
                ->get();
            }

            return DataTables::of($ClassHomework)
                ->addIndexColumn()
                ->addColumn('action',
                    '<a href="#" class="btn GetStudents" id="{{ $homework_id }}" data-toggle="modal"data-class_id="{{ $class_id }}"data-section_id="{{ $section_id }}" data-target="#showStudentListModal">
                    <i class="fa fa-outdent"></i>
                    </a>
                    <a href="#" class="btn EditClassHomework" id="{{ $homework_id }}" data-toggle="modal" data-target="#EditClassHomework">
                        <i class="fa fa-pencil text-aqua"></i>
                    </a>
                    <a href="#" id="{{ $homework_id }}" class="btn DeleteClassHomework" data-toggle="modal" data-target="#DeleteModel">
                        <i class="fa fa-trash-o" style="color:red;"></i>
                    </a>'
                )
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function save_homework(request $request)
    {
       try{
        $document ="";
        if (isset($request->attachment)) {
            $files = $request->file('attachment');
            $document = '/public/uploads/homeworks/'.$files->getClientOriginalName();
            $files->move(public_path().'/uploads/homeworks/',$document);
        }
        if($request->homework_type=='student'){
            $students=$request->sel_student;
            foreach($students as $key=>$value){

                $homeworkdata['homework_type']=$request->homework_type;
                $homeworkdata['class_id']=$request->class_id;
                $homeworkdata['section_id']=$request->stud_section_id;
                $homeworkdata['student_id']=$value;
                $homeworkdata['subject_id']=$request->stud_subject_id;
                $homeworkdata['staff_id']=auth()->user()->id;
                $homeworkdata['homework_date']=$request->stud_homework_date;
                $homeworkdata['submission_date']=$request->stud_submission_date;
                $homeworkdata['estimated_mark']=$request->estimated_mark;
                $homeworkdata['attachment']=$document;
                $homeworkdata['description']=$request->stud_description;
                $insert = DB::table('homework')->insert($homeworkdata);
                $Data['status'] = 'success';
				$Data['message'] = 'Homework Added Successfully';
            }
            return response()->json($Data);
        }else{
       $Homework=new Homework();
       $Homework->class_id=$request->student_class;
       $Homework->section_id=$request->section_id;
       $Homework->homework_type=$request->homework_type;
       $Homework->subject_id=$request->subject_id;
       $Homework->staff_id=auth()->user()->id;
       $Homework->homework_date=$request->homework_date;
       $Homework->submission_date=$request->submission_date;
	   $Homework->estimated_mark=$request->estimated_mark;
       $Homework->attachment=$document;
       $Homework->description=$request->description;
       $Homework->save();
       $Data['status'] = 'success';
       $Data['message'] = 'Homework Added Successfully';
       return response()->json($Data);
    }
    }catch (Exception $e){
        $Data['status'] = 'error';
        return response()->json($Data);
    }
    }
    public function edithomework(Request $request){
        try {
            $Data['Homework'] = Homework::findorfail(request('homework_id'));
            $Data['status'] = 'success';
			$Data['message'] = 'Homework Updated Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Homework Not Found!']);
        }
    }
    public function updatehomework(Request $request){
        try {
            $document ="";
        if (isset($request->update_attachment)) {
            $files = $request->file('update_attachment');
            $document = '/public/uploads/homeworks/'.$files->getClientOriginalName();
            $files->move(public_path().'/uploads/homeworks/',$document);
        }
        if($request->student_homework_id){
            $homeworkdata['subject_id']=$request->subject_id;
            $homeworkdata['staff_id']=auth()->user()->id;
            $homeworkdata['homework_date']=$request->stud_homework_date;
            $homeworkdata['submission_date']=$request->stud_submission_date;
            $homeworkdata['attachment']=$document;
            $homeworkdata['description']=$request->stud_description;
        $update=DB::table('homework')->where('id', $request->student_homework_id)->update($homeworkdata);
        $Data['status'] = 'success';
		$Data['message'] = 'Homework Updated Successfully';
        return response()->json($Data);
        }else{
            $Homeworkdata = Homework::findorfail($request->homework_id);
            $Homeworkdata->class_id = $request->edit_student_class;
            $Homeworkdata->section_id = $request->section_id;
            $Homeworkdata->subject_id = $request->subject_id;
            $Homeworkdata->homework_date = $request->homework_date;
            $Homeworkdata->submission_date = $request->submission_date;
            $Homeworkdata->attachment = $document;
            $Homeworkdata->description = $request->description;
            $Homeworkdata->save();
            $Data['status'] = 'success';
			$Data['message'] = 'Homework Updated Successfully';
            return response()->json($Data);
        }
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
    public function deletehomework(Request $request){
        try {
            $Subject = Homework::findorfail($request->homework_id)->delete();
            $Data['status'] = 'success';
			$Data['message'] = 'Homework Deleted Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }
    public function studenthomework(){
        if(auth()->user()->user_type == 'Student'){
            $Student= Student::where('email', auth()->user()->email)->first();
            $class = $Student['student_class'];
            $section_id = $Student['section_id'];
            $StudentHomework = DB::table('homework')
            ->where([['homework.homework_type','student'],['homework.student_id',auth()->user()->id],['homework.class_id',$class],['homework.section_id',$section_id]])
            ->leftJoin('student_homework_lists','student_homework_lists.homework_id','=','homework.id')
            ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
            ->leftJoin('users','users.id','=','homework.student_id')
            ->leftJoin('subjects','subjects.id','=','homework.subject_id')
            ->leftJoin('students','students.id','=','users.user_id')
            ->select('homework.id as assignedhomework_id','student_homework_lists.*','students.*','homework.*','users.name','users.id as student_id','subjects.*','class_sections.*')
            ->get();
        }else if(auth()->user()->user_type == 'Admin' || auth()->user()->user_type == 'super_admin'){
            $StudentHomework = DB::table('homework')
            ->where([['homework.homework_type','student']])
            ->leftJoin('student_homework_lists','student_homework_lists.homework_id','=','homework.id')
            ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
            ->leftJoin('users','users.id','=','homework.student_id')
            ->leftJoin('subjects','subjects.id','=','homework.subject_id')
            ->leftJoin('students','students.id','=','users.user_id')
            ->select('homework.id as assignedhomework_id','student_homework_lists.*','students.*','homework.*','users.name','users.id as student_id','subjects.*','class_sections.*')
            ->get();
        }else if(auth()->user()->user_type == 'Staff'){
            $StudentHomework = DB::table('homework')
            ->where([['homework.homework_type','student'],['homework.staff_id',auth()->user()->id]])
            ->leftJoin('student_homework_lists','student_homework_lists.homework_id','=','homework.id')
            ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
            ->leftJoin('users','users.id','=','homework.student_id')
            ->leftJoin('subjects','subjects.id','=','homework.subject_id')
            ->leftJoin('students','students.id','=','users.user_id')
            ->select('homework.id as assignedhomework_id','student_homework_lists.*','students.*','homework.*','users.name','users.id as student_id','subjects.*','class_sections.*')
            ->get();
        }
        return DataTables::of($StudentHomework)
        ->addIndexColumn()
        ->addColumn('action',
            '<a href="#" class="btn view_student_homework" id="{{ $student_id }}" data-toggle="modal"data-homework_id="{{ $assignedhomework_id }}"data-class_id="{{ $class_id  }}"data-section_id="{{ $section_id }}" data-target="#showStudentHomeworkSubmits">
            <i class="fa fa-outdent"></i>
            </a>
            <a href="#" class="btn EditStudentHomework" id="{{ $assignedhomework_id }}" data-toggle="modal" data-target="#editStudentHomeworkModal">
                <i class="fa fa-pencil text-aqua"></i>
            </a>
            <a href="#" id="{{ $assignedhomework_id }}" class="btn DeleteStudentHomework" data-toggle="modal" data-target="#DeleteStudentHomework">
                <i class="fa fa-trash-o" style="color:red;"></i>
            </a>'
        )
        ->rawColumns(['action'])
        ->make(true);
    }

    public function editstudenthomework(Request $request){
        try {
        $Data['Studenthomework'] = DB::table('homework')
        ->where('homework.id',request('homework_id'))
        ->leftJoin('users','users.id','=','homework.student_id')
        ->leftJoin('students','students.id','=','users.user_id')
        ->leftJoin('class_sections','class_sections.id','=','homework.section_id')
        ->select('users.*','homework.*','homework.id as homework_id','class_sections.*','students.*')
        ->get();
        $Data['status'] = 'success';
        return response()->json($Data);
        }catch (Exception $e){
        return response()->json(['error'=>'Homework Not Found!']);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getindividualstudenthomework(Request $request){
            $Data['Studenthomework'] = DB::table('student_homework_lists')
            ->where([['student_homework_lists.homework_id', $request->homework_id], ['student_homework_lists.student_id', $request->student_id]])
            ->select('student_homework_lists.*')
            ->get()->toArray();
            if(!empty($Data['Studenthomework'])){
            $homeworkdata['viewed']=1;
            DB::table('student_homework_lists')->where([['homework_id',$request->homework_id], ['student_id', $request->student_id]])->update($homeworkdata);
            $Data['status'] = 'success';
            return response()->json($Data);
           }else{
            $Data['status'] = 'error';
            return response()->json($Data);
           }

    }
    public function changehomeworkstatus(Request $request){
        try {
			$student_id=$request->student_id;
			$homework_id=$request->homework_id;
			 $Student= DB::table('student_homework_lists')->where([['homework_id', $homework_id], ['student_id', $student_id]])
        ->get()
        ->toArray();
		foreach($Student as $stud){
			 $imgWillDelete = public_path() . str_replace("/public/","/",$stud->homework_attachment);
			File::delete($imgWillDelete);
		}

			$upload_dir = "public/uploads/homeworks/";
			$img = $request->hidden_data;
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$file = $upload_dir . date('hms') . ".png";
			$success = file_put_contents($file, $data);
            $homeworkdata['status']=$request->status;
            $homeworkdata['remarks']=$request->remark;
            $homeworkdata['marks_obtained']=$request->marks_obtained;
            $homeworkdata['evaluated_on']=date('d/m/Y');
            $homeworkdata['homework_attachment']="/".$file;
            $homeworkdata['evaluated_by']=auth()->user()->user_id;
            $update=DB::table('student_homework_lists')->where([['homework_id', $homework_id], ['student_id', $student_id]])->update($homeworkdata);
            $Data['status'] = 'success';
            $Data['message'] = 'Homework Updated';
            return response()->json($Data);
            }catch (Exception $e){
            $Data['status'] = 'failed';
            $Data['message'] = 'Homework Not Updated';
            return response()->json($Data);
            }
    }

    public function store(Request $request)
    {
        //
    }
    public function getclasslist(){
       return $data['Classes'] = ClassSection::get()->unique('class');
    }
    public function getsectionlist(){
        return  $data['Sections'] =ClassSection::get()->unique('section');
    }
    public function getsubjectlist(){
        return  $data['Subjects'] = Subject::get()->unique('class');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $homework)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function edit(Homework $homework)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework $homework)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homework  $homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $homework)
    {
        //
    }
}
