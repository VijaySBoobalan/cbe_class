<?php

namespace App\Http\Controllers;

use App\Onlineclass;
use App\Record;
use App\Staff;
use App\StaffScheduleClass;
use App\StaffScheduleSubjectDetails;
use App\StaffSubjectAssign;
use App\Student;
use App\StudentAttendence;
use App\Subject;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Textlocal;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class RecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function test()
    {
        return StudentAttendence::where([['class','1'],['section_id','1'],['subject_id','1'],['to_time',NULL]])->with('Student')->get();
    }

    public function index()
    {
        if(auth()->user()->user_type == "Staff"){
            // $data['Staff'] = Staff::where('id',auth()->user()->user_id)->first();
            // $StaffClasses = StaffScheduleClass::where([['staff_id',$data['Staff']->id]])->pluck('id')->toArray();
            // $data['StaffScheduleSubjectDetails'] = StaffScheduleSubjectDetails::whereIn('staff_schedule_class_id',$StaffClasses)->get();

            // $data['recordDetails'] = Onlineclass::where('staff_id',Auth::id())->get();
            $data['staffSubjectAssign'] = StaffSubjectAssign::where('staff_id',auth()->user()->user_id)->get();
            // dd($data);
            return view('view_videos',$data);
        }else if(auth()->user()->user_type == "Student"){
            $student = User::find(Auth::id())->StudentDetails;
            // dd($student);
            $data['subjects'] = Subject::where([['class',$student->student_class],['section_id',$student->section_id]])->get();
            return view('student_view_videos',$data);
        }else{
            return back()->with('warning','your not a Staff');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('upload_videos');
    }
    function upload_classrecord(request $request){


    }

    public function validateVideo(Request $request){
        try{
            $fileName = explode(".",$request->fileName)[0];
            $isExists = Onlineclass::where('session_id',$fileName)->count();
            if($isExists == 0){
                $response = 1;
            }else{
                $response = 0;
            }
            return response()->json(["response"=>$response]);
        }catch(Exception $e){
            Log::debug($e->getMessage());
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
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
        try {
            // $input= $request->file('record_data');
            // $filename = auth()->user()->name.date('Ymdhis').".mp4";
            // move_uploaded_file($input,"uploads/" .$filename);
            // Storage::disk('do_spaces')->put($filename,$input);
            // Storage::cloud()->setVisibility($input, 'public');

            $Record=new Record;
            $Record->staff_id = isset(auth()->user()->user_id) ? auth()->user()->user_id : auth()->user()->id;
            $Record->class_id = $request->class_data;
            $Record->section_id = $request->section_data;
            $Record->subject_id = $request->subject_id;
            $Record->file = $request->filename;
            // $input = $request->file->store('/', 'do_spaces');
            // Storage::cloud()->setVisibility($input, 'public');
            $Record->save();
            $Data['status'] = "Success";
            return response()->json($Data);
        }catch (Exception $e){
            Log::debug($e->getMessage());
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }

    public function ViewerfilesUpload(Request $request)
    {
        $input= $request->file('file')->getPathName();
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = auth()->user()->name.date('Ymdhis').".".$extension;
        move_uploaded_file($input,"uploads/".$filename);
        $Record=new Record;
        $Record->staff_id=auth()->user()->id;
        $Record->file=$filename;
        $Record->save();
        // $Record = new Record;
        // $Record->file = $request->file->store('/', 'do_spaces');
        // Storage::cloud()->setVisibility($Record->file, 'public/viewer');
        // $Record->save();
    }

    public function ViewerimagesUpload(Request $request)
    {
        $input= $request->file('file')->getPathName();
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = auth()->user()->name.date('Ymdhis').".".$extension;
        move_uploaded_file($input,"uploads/".$filename);
        $Record=new Record;
        $Record->staff_id=auth()->user()->id;
        $Record->file=$filename;
        $Record->save();
        // $Record = new Record;
        // $Record->file = $request->file->store('/', 'do_spaces');
        // Storage::cloud()->setVisibility($Record->file, 'public/viewer');
        // $Record->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function show(Record $record)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function edit(Record $record)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Record $record)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Record  $record
     * @return \Illuminate\Http\Response
     */
    public function destroy(Record $record)
    {
        //
    }

    public function filterVideos(Request $request){
        $classId = $request->class;        
        $sectionId = $request->section_id;
        $subjectId = $request->subjects;
        // DB::enableQueryLog();
        $result = Onlineclass::where([['class_id',$classId],['section_id',$sectionId],['subject_id',$subjectId],['staff_id',Auth::id()]])->get();
        // print_r(DB::getQueryLog());
        return response()->json($result);
    }

    public function filterStudentVideos(Request $request){
        $student = User::find(Auth::id())->StudentDetails;
        $classId = $student->student_class;        
        $sectionId = $student->section_id;
        $subjectId = $request->subject_id;
        // DB::enableQueryLog();
        $result = Onlineclass::where([['class_id',$classId],['section_id',$sectionId],['subject_id',$subjectId],['staff_id',Auth::id()]])->get();
        // print_r(DB::getQueryLog());
        return response()->json($result);
    }
}
