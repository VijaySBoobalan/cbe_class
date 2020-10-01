<?php namespace App\Http\Controllers;

use App\Events\Onlineclass;
use App\Events\RaiseQuestion;
use App\StaffAttendance;
use Illuminate\Http\Request;
use App\Student;
use App\StudentAttendence;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller {

    //
    function sendnotify(Request $request) {
        $post=array("staff_id"=>auth()->user()->id,
            "staff_name"=>auth()->user()->name,
            "session_id"=>$request->session,
            "audioroom_id"=>$request->audioroom_id,
            "scheduleclass_id"=>$request->scheduleclass_id,
            "class_id"=>$request->class_id,
            "section_id"=>$request->section_id,
            "subject_id"=>$request->subject_id,
            "date"=>date('m/d/Y'),
            "created_at"=>now(),
            "updated_at"=>now(),
            "count"=>1);

            $notify = DB::table('onlineclass')->insert($post);
            event(new Onlineclass($post));
    }

    function new_notify() {
        // echo auth()->user()->email;
        $Student= Student::where('email', auth()->user()->email)->first();
        $class = $Student['student_class'];
        $section_id = $Student['section_id'];
        $classdata = DB::table('onlineclass')->where([['status', 1], ['class_id', $class], ['section_id', $section_id]])->orderBy('id', 'desc')->get()->take(1)->toArray();

        // echo $classdata;
        if(empty($classdata)) {
            $data=array("status"=>0,
                "count"=>0,
                "message"=>"<p class='text-danger text-center'>Empty</p>",
                "session_id"=>''
            );
        }

        else {
            foreach($classdata as $class) {
                $data=array("status"=>$class->status,
                    "count"=>1,
                    "message"=>$class->staff_name ." Onlive",
                    "session_id"=>$class->session_id);
            }
        }

        return json_encode($data);
    }

    function upload_classrecord(request $request) {

        $input=$request->file('record_data')->getPathName();

        $filename=auth()->user()->name.date('Ymdhis').".wav";
        move_uploaded_file($input, "uploads/".$filename);

    }

    function stop_online(request $request) {
        try{
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $session_id=$request->session_id;
            $subject_id=$request->subject_id;
            $scheduleclass_id=$request->scheduleclass_id;
            $update=DB::update('update onlineclass set status = ? where session_id = ?', [0, $session_id]);

            $StaffAttendance = StaffAttendance::where([['staff_id',auth()->user()->user_id],['class',$class_id],['section_id',$section_id],['subject_id',$subject_id],['subject_schedule_id',$scheduleclass_id]])->latest('created_at')->first();
            $StaffAttendance->to_time = date('Y-m-d H:i:s');;
            $StaffAttendance->save();

            $StudentAttendences = StudentAttendence::where([['class',$class_id],['section_id',$section_id],['subject_id',$subject_id],['subject_schedule_id',$scheduleclass_id],['to_time','=',""]])->get();
            foreach ($StudentAttendences as $key => $value) {
                $StudentAttendence = StudentAttendence::find($value->id);
                $StudentAttendence->to_time = date('Y-m-d H:i:s');;
                $StudentAttendence->save();
            }
            $Data['status'] = "success";
            return response()->json($Data);
        } catch (Exception $e) {
            DB::rollBack();
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function studentAttendenceEnd(Request $request)
    {
        $subject_id=$request->subject_id;
        $subject_schedule_id=$request->subject_schedule_id;
        $StudentAttendences = StudentAttendence::where([['student_id',auth()->user()->user_id],['class',auth()->user()->StudentDetails->student_class],['section_id',auth()->user()->StudentDetails->section_id],['subject_id',$subject_id],['subject_schedule_id',$subject_schedule_id],['to_time','=',""]])->get();
        foreach ($StudentAttendences as $key => $value) {
            $StudentAttendence = StudentAttendence::find($value->id);
            $StudentAttendence->to_time = date('Y-m-d H:i:s');;
            $StudentAttendence->save();
        }
        return "Student Attendance Close";
    }

	public function raise_question(Request $request){
		$data=array();
        $user_details['user_id']=$request->user_id;
        $user_details['staff_id']=$request->staff_id;
        $user_details['user_name']=$request->user_name;
        $user_details['message']=$request->message;
		event(new RaiseQuestion($user_details));
	}

}
