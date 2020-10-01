<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\FeesCollection;
use App\Record;
use App\Staff;
use App\StaffScheduleClass;
use App\StaffScheduleSubjectDetails;
use App\Student;
use App\StudentAttendence;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        // $this->middleware(['auth','verified']);
        // $this->middleware('auth:student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if(auth()->user()->user_type=="Admin" || auth()->user()->user_type=="super_admin"){
            $data['students'] = Student::get()->count();
            $data['staffs'] = Staff::get()->count();

            $data['Todays_class'] = DB::table('staff_schedule_subject_details')
            ->where([['staff_schedule_subject_details.subject_day',date('Y-m-d')]])
            ->Join('class_sections','class_sections.id','=','staff_schedule_subject_details.section_id')
            ->Join('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            ->Join('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            ->Join('staff','staff.id','=','staff_schedule_classes.staff_id')
            ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*','staff.*')
            ->get();

            $tomorrow = date('Y-m-d',strtotime(date('Y-m-d').'+1 day'));

            $data['Tomorrows_class'] = DB::table('staff_schedule_subject_details')
            ->where([['staff_schedule_subject_details.subject_day',$tomorrow]])
            ->Join('class_sections','class_sections.id','=','staff_schedule_subject_details.section_id')
            ->Join('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            ->Join('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            ->Join('staff','staff.id','=','staff_schedule_classes.staff_id')
            ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*','staff.*')
            ->get();

            $data['onlineClass'] = DB::table('onlineclass')
            ->where([['date',date('m/d/Y')],['status',1]])
            ->Join('users','users.id','=','onlineclass.staff_id')
            ->Join('class_sections','class_sections.id','=','onlineclass.section_id')
            ->get();
            // $data['Todays_class']=DB::table('staff_schedule_subject_details')
            // ->where([['staff_schedule_classes.staff_id',auth()->user()->user_id],['staff_schedule_subject_details.subject_day',date('m/d/Y')]])
            // ->leftJoin('class_sections','class_sections.id','=','staff_schedule_subject_details.class')
            // ->leftJoin('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            // ->leftJoin('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            // ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*')
            // ->get()->toArray();
            $data['ClassSection'] = ClassSection::get()->unique('class');
            $data['todayFeeCollection'] = FeesCollection::where('date',date('d/m/Y'))->sum('amount');
            $StudentFeesDetails = Student::get();
            $count = 0;
            $TotalAmount = 0;
            $PaidAmount = 0;
            $TotalDiscount = 0;
            $balanceAmount = 0;
            foreach ($StudentFeesDetails as $key=>$StudentDetail){
                $feePayment = getStudentFeeAmountYearWise($StudentDetail->id,$StudentDetail->student_class);
                $TotalAmount += $feePayment['FeeGroupTypeDetails'];
                $PaidAmount += $feePayment['FeesCollectionAmount'];
                $TotalDiscount += $feePayment['FeesCollectionDiscount'];
            }
            $data['balanceAmount'] = $TotalAmount - $TotalDiscount - $PaidAmount;
            return view('dashboard.admin_dashboard',$data);
        }
        if(auth()->user()->user_type=="Staff"){

            $data['Staff'] = Staff::where('id',auth()->user()->user_id)->first();

            $StaffClasses = StaffScheduleClass::where([['staff_id',$data['Staff']->id]])->pluck('id')->toArray();
            $data['StaffScheduleSubjectDetails'] = StaffScheduleSubjectDetails::whereIn('staff_schedule_class_id',$StaffClasses)->get();
			$data['Todays_class']=DB::table('staff_schedule_subject_details')
            ->where([['staff_schedule_classes.staff_id',auth()->user()->user_id],['staff_schedule_subject_details.subject_day',date('Y-m-d')]])
            ->leftJoin('class_sections','class_sections.id','=','staff_schedule_subject_details.class')
            ->leftJoin('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            ->leftJoin('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*')
            ->get()->toArray();
            ;

			$data['Tomorrows_class']=DB::table('staff_schedule_subject_details')
            ->where([['staff_schedule_classes.staff_id',auth()->user()->user_id],['staff_schedule_subject_details.subject_day',date("Y-m-d", time() + 86400)]])
            ->leftJoin('class_sections','class_sections.id','=','staff_schedule_subject_details.class')
            ->leftJoin('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            ->leftJoin('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*')
            ->get()->toArray();
            ;;
            return view('dashboard.staff_dashboard',$data);
        }
        if(auth()->user()->user_type=="Student"){
            $data['Student'] = Student::where('id',auth()->user()->user_id)->first();

            // $data['StudentClasses'] = StaffScheduleClass::where([['class',$data['Student']->student_class],['section_id',$data['Student']->section_id]])->get();

            $data['Todays_class'] = StaffScheduleSubjectDetails::
            where([['staff_schedule_subject_details.class',$data['Student']->student_class],['staff_schedule_subject_details.section_id',$data['Student']->section_id],['staff_schedule_subject_details.subject_day',date("Y-m-d")]])
            ->Join('class_sections','class_sections.id','=','staff_schedule_subject_details.section_id')
            ->Join('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            ->Join('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            ->Join('staff','staff.id','=','staff_schedule_classes.staff_id')
            ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*','staff.*')
            ->get();

            $tomorrow = date('Y-m-d',strtotime(date('Y-m-d').'+1 day'));

            $data['Tomorrows_class'] = StaffScheduleSubjectDetails::
            where([['staff_schedule_subject_details.class',$data['Student']->student_class],['staff_schedule_subject_details.section_id',$data['Student']->section_id],['staff_schedule_subject_details.subject_day',$tomorrow]])
            ->leftJoin('class_sections','class_sections.id','=','staff_schedule_subject_details.class')
            ->leftJoin('subjects','subjects.id','=','staff_schedule_subject_details.subject_id')
            ->leftJoin('staff_schedule_classes','staff_schedule_classes.id','=','staff_schedule_subject_details.staff_schedule_class_id')
            ->Join('staff','staff.id','=','staff_schedule_classes.staff_id')
            ->select('staff_schedule_subject_details.*','staff_schedule_classes.*','class_sections.*','subjects.*','staff.*')
            ->get();
            // print_r($data['todays_online']);

            return view('dashboard.student_dashboard',$data);
        }
    }

    public function TotalScheduleListforStaff(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        // DB::enableQueryLog();
        $StaffScheduleSubjectDetails = StaffScheduleSubjectDetails::whereBetween('staff_schedule_subject_details.subject_day', [$from_date, $to_date])->where('staff_id',auth()->user()->user_id)
            ->join("class_sections", function ($join) {
                $join->on("class_sections.id", "=", 'staff_schedule_subject_details.section_id');
            })
            ->join('staff_schedule_classes', 'staff_schedule_classes.id', 'staff_schedule_subject_details.staff_schedule_class_id')
            ->join('staff', 'staff.id', 'staff_schedule_classes.staff_id')
            ->orderBy('subject_day', 'asc')
            ->groupBy(['subject_day', 'staff_schedule_subject_details.section_id'])
            ->get();

        // dd(DB::getQueryLog());
        return DataTables::of($StaffScheduleSubjectDetails)
            ->addIndexColumn()
            ->addColumn('assign_time', function ($StaffScheduleSubjectDetails) {
                return $this->calculateAssignTime($StaffScheduleSubjectDetails);
            })
            ->addColumn('date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d', $data->subject_day)->format('d/m/Y');
            })
            ->addColumn('taken_time', function ($StaffScheduleSubjectDetails) {
                return $taken_time = totalScheduleTakenTime($StaffScheduleSubjectDetails)['TakenTime'];
            })
            ->addColumn('Total_assign_time', function ($staffScheduleSubjectDetails) {

                $mins = $this->totalAssignTime[sizeof($this->totalAssignTime) - 1] % 60;
                if ($mins <= 9) {
                    $mins = "0" . $mins;
                }
                $hrs = floor(($this->totalAssignTime[sizeof($this->totalAssignTime) - 1]) / 60);

                $str = strlen((string) $mins);
                if ($str == 1) {
                    $totalAssignedTime = $hrs . "." . $mins;
                } else {
                    $totalAssignedTime = $hrs . "." . $mins;
                }
                return $totalAssignedTime;
            })
            ->addColumn('TotalTakentime', function ($StaffScheduleSubjectDetails) {
                return $TotalTakentime = totalScheduleTakenTime($StaffScheduleSubjectDetails)['TotalTakentime'];
            })
            ->make(true);
    }

    function calculateAssignTime($staffScheduleSubjectDetails)
    {
        $currentRowDate = $staffScheduleSubjectDetails->subject_day;
        // DB::enableQueryLog();
        $scheduleDetails = StaffScheduleSubjectDetails::whereDate('staff_schedule_subject_details.subject_day', $currentRowDate)->where('staff_id',auth()->user()->user_id)
            ->where('staff_schedule_subject_details.class', $staffScheduleSubjectDetails->class)
            ->where('staff_schedule_subject_details.section_id', $staffScheduleSubjectDetails->section_id)
            ->join("class_sections", function ($join) {
                $join->on("class_sections.id", "=", 'staff_schedule_subject_details.section_id');
            })
            ->join('staff_schedule_classes', 'staff_schedule_classes.id', 'staff_schedule_subject_details.staff_schedule_class_id')
            ->join('staff', 'staff.id', 'staff_schedule_classes.staff_id')
            ->orderBy('subject_day', 'asc')->get();
        // dd(DB::getQueryLog());
        $totalAssignedTime = 0;
        $tmpArray = array();
        foreach ($scheduleDetails as $val) {
            $from = \Carbon\Carbon::createFromFormat('H:i', $val->from_time);
            $to = \Carbon\Carbon::createFromFormat('H:i', $val->to_time);
            $minutes = $to->diffInMinutes($from);
            $tmpArray[] = $minutes;
        }
        $totalMinutes = array_sum($tmpArray);
        $this->totalAssignTime[] = $totalMinutes;
        $mins = $totalMinutes % 60;
        $hrs = floor($totalMinutes / 60);

        $str = strlen((string) $mins);
        if ($str == 1) {
            $totalAssignedTime = $hrs . "hrs:0" . $mins . "mins";
        } else {
            $totalAssignedTime = $hrs . "hrs:" . $mins . "mins";
        }
        return $totalAssignedTime;
    }

    public function getStudentAttendanceDetails(Request $request)
    {
        $TotalInHours = 0;
        $TotalInMinutes = 0;
        $TakenTime = 0;
        $Totalmins = 0;
        $from_date = date('Y/m/d',strtotime($request->from_date));
        $to_date =date('Y/m/d',strtotime( $request->to_date));
        $StudentAttendences = StudentAttendence::where([['student_id',auth()->user()->user_id]])
        ->whereBetween('date',[$from_date,$to_date])
        ->get()
        ->unique('date');
        return DataTables::of($StudentAttendences)
            ->addIndexColumn()
            ->addColumn('date', function ($StudentAttendences) {
                return date('d/m/Y',strtotime($StudentAttendences->date));
            })
            ->addColumn('attend_time', function ($StudentAttendences) {
                return $taken_time = StudentAttendance($StudentAttendences)['ForTotalAttendTime'];
            })
            ->addColumn('status', function ($StudentAttendences) {
                return $taken_time = StudentAttendance($StudentAttendences)['status'];
            })
            ->make(true);
    }

    public function getStudentDetails(Request $request)
    {
        if($request->date == date('Y-m-d')){
            $data['AttendedStudent'] = StudentAttendence::where([['class',$request->taken_class],['section_id',$request->section_id],['subject_id',$request->subject_details],['date',date('Y/m/d',strtotime($request->date))],['to_time','!=',""]])->get()->unique('student_id')->count();
            $data['LiveStudent'] = StudentAttendence::where([['class',$request->taken_class],['section_id',$request->section_id],['subject_id',$request->subject_details],['date',date('Y/m/d',strtotime($request->date))],['to_time','=',""]])->get()->unique('student_id')->count();
        }else{
            $data['LiveStudent'] = 0;
            $data['AttendedStudent'] = StudentAttendence::where([['class',$request->taken_class],['section_id',$request->section_id],['subject_id',$request->subject_details],['date',date('Y/m/d',strtotime($request->date))]])->get()->unique('student_id')->count();
        }
        abs(123);
        $data['ClassSection'] = ClassSection::findorfail($request->section_id);
        $data['StudentCount'] = Student::where('section_id',$request->section_id)->get()->count();
        return $data;
    }

    public function FormElements()
    {
        return view('form_elements');
    }

    public function upload()
    {
        $data['photos'] = Record::all();
        return view('upload',$data);
    }

    public function store(Request $request)
    {
        $Record = new Record;
        $Record->file = $request->staff_id_no->store('/', 'do_spaces');
        Storage::cloud()->setVisibility($Record->file, 'public');
        $Record->save();
        return redirect()->route('upload');
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
