<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\ClassListeningStudents;
use App\ClassSection;
use App\Staff;
use App\StaffAttendance;
use App\StaffScheduleClass;
use App\StaffScheduleSubjectDetails;
use App\StaffSubjectAssign;
use App\Student;
use App\StudentAttendence;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use phpDocumentor\Reflection\Types\Null_;
use Yajra\DataTables\Facades\DataTables;

class StudentAttendenceController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:student_view|student_create|student_attendance_view|staff_attendance_view', ['only' => ['StudentAttendence','StaffAttendence','EndStudentAttendence','StudentIndex','StaffIndex','StudentClassDetail','StaffClassDetail']]);
        // $this->middleware('permission:student_create', ['only' => ['create','store']]);
        // $this->middleware('permission:student_update', ['only' => ['edit','update']]);
        // $this->middleware('permission:student_delete', ['only' => ['destroy']]);
    }

    public function StudentAttendence(Request $request)
    {
        $StudentAttendence = new StudentAttendence;
        $StudentAttendence->student_id = auth()->user()->user_id;
        $StudentAttendence->class = auth()->user()->StudentDetails->student_class;
        $StudentAttendence->section_id = auth()->user()->StudentDetails->section_id;
        $StudentAttendence->subject_id = $request->subject_id;
        $StudentAttendence->subject_schedule_id = $request->subject_schedule_id;
        $StudentAttendence->date = date('Y/m/d');
        $StudentAttendence->from_time = now();
        $StudentAttendence->to_time = "";
        $StudentAttendence->save();
    }
	public function ClassListening(Request $request){
	  $student_details=array("student_id"=>auth()->user()->id,
            "student_name"=>auth()->user()->name,
            "schedule_id"=>$request->schedule_id,
            "status"=>$request->status);
			 event(new ClassListeningStudents($student_details));
	}
    public function StaffAttendence(Request $request)
    {
        $StaffAttendance = new StaffAttendance();
        $StaffAttendance->staff_id = auth()->user()->user_id;
        $StaffAttendance->class = $request->class_id;
        $StaffAttendance->section_id = $request->section_id;
        $StaffAttendance->subject_id = $request->subject_id;
        $StaffAttendance->subject_schedule_id = $request->scheduleclass_id;
        $StaffAttendance->date = date('Y/m/d');
        $StaffAttendance->from_time = date('Y-m-d H:i:s');
        $StaffAttendance->to_time = "";
        $StaffAttendance->save();
    }

    public function EndStudentAttendence(Request $request)
    {
        $StudentAttendence = new StudentAttendence;
        $StudentAttendence->student_id = auth()->user()->user_id;
        $StudentAttendence->class = auth()->user()->StudentDetails->student_class;
        $StudentAttendence->section_id = auth()->user()->StudentDetails->section_id;
        $StudentAttendence->subject_id = $request->subject_id;
        $StudentAttendence->date = date('Y/m/d');
        $StudentAttendence->from_time = now();
        $StudentAttendence->to_time = "";
        $StudentAttendence->save();
    }

    public function StudentList(Request $request)
    {
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        return $Students = Student::where([['student_class',$class_id],['section_id',$section_id]])->get();
    }
	public function getAllStudents(){
		 return $Student= Student::where([['users.user_type', 'Student']])
        ->leftJoin('users','students.id','users.user_id')
        ->leftJoin('class_sections','class_sections.id','students.section_id')
        ->get()
        ->toArray();
	} 
    public function StudentIndex(Request $request)
    {
        $data['StudentAttendences'] = StudentAttendence::get();
        $data['ClassSection'] = ClassSection::get()->unique('class');
        return view('attendance.student',$data);
    }

    public function ClassWiseAttendance(Request $request)
    {
        $data['StudentAttendences'] = StudentAttendence::get();
        $data['ClassSection'] = ClassSection::get()->unique('class');
        return view('attendance.class_wise',$data);
    }

    public function StaffIndex(Request $request)
    {
        $data['Staffs'] = Staff::get();
        $data['StaffAttendances'] = StaffAttendance::get();
        $data['ClassSection'] = ClassSection::get()->unique('class');
        return view('attendance.staff',$data);
    }

    public function ClassWiseDetail(Request $request)
    {
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $from_date = date('Y-m-d',strtotime($request->from_date));
        $to_date = date('Y-m-d',strtotime($request->to_date));

        $StaffScheduleSubjectDetails = StaffScheduleSubjectDetails::where([['staff_schedule_subject_details.class',$class_id],['staff_schedule_subject_details.section_id',$section_id]])->whereBetween('staff_schedule_subject_details.subject_day',[$from_date,$to_date])
        ->join("subjects",function($join){
            $join->on("subjects.id","=",'staff_schedule_subject_details.subject_id');
        })
        ->join("class_sections",function($join){
            $join->on("class_sections.id","=",'staff_schedule_subject_details.section_id');
        })
        ->join('staff_schedule_classes','staff_schedule_classes.id','staff_schedule_subject_details.staff_schedule_class_id')
        ->join('staff','staff.id','staff_schedule_classes.staff_id')
        ->select('staff_schedule_subject_details.*','staff_schedule_subject_details.id as subjectScheduleId','subjects.*','class_sections.*','staff_schedule_classes.*','staff.*')
        ->get();
        return DataTables::of($StaffScheduleSubjectDetails)
            ->addIndexColumn()
            ->addColumn('assign_time', function ($StaffScheduleSubjectDetails) {
                $totalTime = 0;
                $to = \Carbon\Carbon::createFromFormat('H:i', @$StaffScheduleSubjectDetails->to_time);
                $from = \Carbon\Carbon::createFromFormat('H:i', @$StaffScheduleSubjectDetails->from_time);
                $diff_in_minutes = $to->diffInMinutes($from);
                $diff_in_minutes = $to->diffInMinutes($from);
                $diff_in_hours = $to->diffInHours($from);
                $mins = $diff_in_minutes % 60;
                $totalTime = $diff_in_hours."hrs:".$mins."mins";
                return $totalTime;
            })
            ->addColumn('taken_time', function ($StaffScheduleSubjectDetails) {
                $taken_time = staffClassWiseTaken($StaffScheduleSubjectDetails);
                return $taken_time;
            })
            ->addColumn('Attended_count', function ($StaffScheduleSubjectDetails) {
                $Attended_count = StudentClassTime($StaffScheduleSubjectDetails);
                return $Attended_count;
            })
            ->make(true);
    }

    public function StudentWiseDetail(Request $request)
    {
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $student_name = $request->student_name;
        $from_date = date('Y-m-d',strtotime($request->from_date));
        $to_date = date('Y-m-d',strtotime($request->to_date));
        $TotalAttendTime = 0;
        $StaffScheduleSubjectDetails = StaffScheduleSubjectDetails::where([['staff_schedule_subject_details.class',$class_id],['staff_schedule_subject_details.section_id',$section_id]])->whereBetween('staff_schedule_subject_details.subject_day',[$from_date,$to_date])
        ->join("subjects",function($join){
            $join->on("subjects.id","=",'staff_schedule_subject_details.subject_id');
        })
        ->join("class_sections",function($join){
            $join->on("class_sections.id","=",'staff_schedule_subject_details.section_id');
        })
        ->join("students",function($join) use ($student_name){
            $join->where('students.id', $student_name)
            ->select('students.id as studentId','students.*');
        })
        ->join('staff_schedule_classes','staff_schedule_classes.id','staff_schedule_subject_details.staff_schedule_class_id')
        ->join('staff','staff.id','staff_schedule_classes.staff_id')
        ->select('students.id as studentId','subjects.*','class_sections.*','students.*','staff_schedule_classes.*','staff_schedule_subject_details.*','staff_schedule_subject_details.id as subjectScheduleId','staff.*')
        ->get();

        return DataTables::of($StaffScheduleSubjectDetails)
            ->addIndexColumn()
            ->addColumn('assign_time', function ($StaffScheduleSubjectDetails) {
                $totalTime = 0;
                $to = \Carbon\Carbon::createFromFormat('H:i', @$StaffScheduleSubjectDetails->to_time);
                $from = \Carbon\Carbon::createFromFormat('H:i', @$StaffScheduleSubjectDetails->from_time);
                $diff_in_minutes = $to->diffInMinutes($from);
                $diff_in_minutes = $to->diffInMinutes($from);
                $diff_in_hours = $to->diffInHours($from);
                $mins = $diff_in_minutes % 60;
                $totalTime = $diff_in_hours."hrs:".$mins."mins";
                return $totalTime;
            })
            ->addColumn('ForTotalAssignime', function ($StaffScheduleSubjectDetails) {
                $totalTime = 0;
                $to = \Carbon\Carbon::createFromFormat('H:i', @$StaffScheduleSubjectDetails->to_time);
                $from = \Carbon\Carbon::createFromFormat('H:i', @$StaffScheduleSubjectDetails->from_time);
                $diff_in_minutes = $to->diffInMinutes($from);
                $diff_in_minutes = $to->diffInMinutes($from);
                $diff_in_hours = $to->diffInHours($from);
                $mins = $diff_in_minutes % 60;
                $totalTime = $diff_in_hours.".".$mins;
                return $totalTime;
            })
            ->addColumn('taken_time', function ($StaffScheduleSubjectDetails) {
                $taken_time = AttendTime($StaffScheduleSubjectDetails)['ForTotalTakenTime'];
                return $taken_time;
            })
            ->addColumn('attend_time', function ($StaffScheduleSubjectDetails) {
                $taken_time = AttendTime($StaffScheduleSubjectDetails)['TakenTime'];
                return $taken_time;
            })
            ->addColumn('ForTotalAttendTime', function ($StaffScheduleSubjectDetails) {
                $taken_time = AttendTime($StaffScheduleSubjectDetails)['ForTotalAttendTime'];
                return $taken_time;
            })
            ->addColumn('status', function ($StaffScheduleSubjectDetails) {
                $status = AttendTime($StaffScheduleSubjectDetails)['staus'];
                return $status;
            })
            ->addColumn('PresentCount', function ($StaffScheduleSubjectDetails) {
                $PresentCount = 0;
                $PresentCount = AttendTime($StaffScheduleSubjectDetails)['PresentCount'];
                return $PresentCount;
            })
            ->addColumn('AbsentCount', function ($StaffScheduleSubjectDetails) {
                $AbsentCount = 0;
                $AbsentCount = AttendTime($StaffScheduleSubjectDetails)['AbsentCount'];
                return $AbsentCount;
            })
            ->with(['TotalAttendTime'=>$TotalAttendTime])
            ->make(true);
    }

    public function StaffClassDetail(Request $request)
    {
        $staff_id = $request->staff_id;
        $from_date = date('Y-m-d',strtotime($request->from_date));
        $to_date = date('Y-m-d',strtotime($request->to_date));
        if ($request->ajax()) {
            $StaffScedules = StaffScheduleSubjectDetails::where('staff_schedule_subject_details.staff_id',$staff_id)->whereBetween('staff_schedule_subject_details.subject_day',[$from_date,$to_date])
            // ->join('staff_schedule_classes','staff_schedule_classes.id','staff_schedule_subject_details.staff_schedule_class_id')
            ->join("class_sections", function ($join) {
                $join->on("class_sections.id", "=", 'staff_schedule_subject_details.section_id');
            })
            ->join("subjects",function($join){
                $join->on("subjects.id","=",'staff_schedule_subject_details.subject_id');
            })
            ->join('staff', 'staff.id', 'staff_schedule_subject_details.staff_id')
            ->orderBy('subject_day', 'asc')
            ->groupBy(['subject_day', 'staff_schedule_subject_details.section_id'])
            ->select('subjects.*','class_sections.*','staff.*','staff_schedule_subject_details.*','staff.id as StaffId','staff_schedule_subject_details.from_time as StaffFromTime','staff_schedule_subject_details.to_time  as StaffToTime','staff_schedule_subject_details.id as subjectScheduleId')
            ->get();
            $StafftotalTime = 0;
            $TotalMinutes = 0;
            $TotalHours = 0;
            if(!empty($StaffScedules)){
                foreach ($StaffScedules as $key => $value) {
                    $totime = \Carbon\Carbon::createFromFormat('H:i', $value->StaffToTime);
                    $fromtime = \Carbon\Carbon::createFromFormat('H:i', $value->StaffFromTime);
                    $diff_minutes = $totime->diffInMinutes($fromtime);
                    $diff_hours = $totime->diffInHours($fromtime);
                    $TotalMinutes += $diff_minutes;
                    $TotalHours += $diff_hours;
                }
                $mins = $TotalMinutes % 60;
                // $TotalHours = $TotalMinutes / 60;
                $StafftotalTime = StaffSubjectTotalAssignTime($StaffScedules);

            }

            // if(!empty($StaffScedules)){
            //     $TotalInHours = 0;
            //     $TotalInMinutes = 0;
            //     $Totalmins = 0;
            //     $totalInTime = 0;
            //     foreach ($StaffScedules as $key => $value) {
            //         $totime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->to_time);
            //         $fromtime = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->from_time);
            //         $diff_in_minutes = $totime->diffInMinutes($fromtime);
            //         $diff_in_hours = $totime->diffInHours($fromtime);
            //         $TotalInMinutes += $diff_in_minutes;
            //         $TotalInHours += $diff_in_hours;
            //     }
            //     $Totalmins = $TotalInMinutes % 60;
                $totalInTime = staffClassTakenTime($StaffScedules);
            // }
            $StaffSubjectAssignTime = 0;
            $staffClassTaken = 0;
            return DataTables::of($StaffScedules)
                ->addIndexColumn()
                ->addColumn('date', function ($StaffScedules) {
                    return $StaffScedules->subject_day;
                })
                ->addColumn('staff_id', function ($StaffScedules) {
                    return isset($StaffScedules) ? $StaffScedules->staff_name : "Admin";
                })
                ->addColumn('section_id', function ($StaffScedules) {
                    return $StaffScedules->section;
                })
                ->addColumn('subject_id', function ($StaffScedules) {
                    return $StaffScedules->subject_name;
                })
                ->addColumn('assign_time', function ($StaffScedules) {
                    return $StaffSubjectAssignTime = StaffSubjectAssignTime($StaffScedules);
                })
                ->addColumn('taken_time', function ($StaffScedules) {
                    return $staffClassTaken = staffClassTaken($StaffScedules);
                })
                ->addColumn('status', function ($StaffScedules) {
                    return StaffAttendanceStatus($StaffScedules);
                    // $totalTime = 0;
                    // $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffScedules->to_time);
                    // $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $StaffScedules->from_time);
                    // $diff_in_minutes = $to->diffInMinutes($from);
                    // $diff_in_hours = $to->diffInHours($from);
                    // $mins = $diff_in_minutes % 60;
                    // $totalTime = $diff_in_hours.":".$mins;
                    return "1";
                })
                ->with(['TotalTime' => $StafftotalTime,'TotalInTime' => $totalInTime])
                ->make(true);
        }
    }
}
