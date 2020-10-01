<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\Staff;
use App\StaffScheduleClass;
use App\StaffScheduleSubjectDetails;
use App\StaffSubjectAssign;
use App\Subject;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:staff_schedule_view|staff_schedule_create|staff_schedule_update|staff_schedule_delete', ['only' => ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']]);
        $this->middleware('permission:staff_schedule_view', ['only' => ['index']]);
        $this->middleware('permission:staff_schedule_create', ['only' => ['create', 'store']]);
        $this->middleware('permission:staff_schedule_update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:staff_schedule_delete', ['only' => ['destroy']]);
    }

    public function StaffScheduleIndex()
    {
        $data['Staffs'] = Staff::get();
        $data['Subjects'] = Subject::get()->unique('class');
        $data['ClassSection'] = ClassSection::get()->unique('class');
        if (request()->ajax()) {
            if (@auth()->user()->user_type == 'Staff') {
                $StaffScheduleClass = StaffScheduleClass::where('staff_id', auth()->user()->user_id)->get();
            } else {
                $StaffScheduleClass = StaffScheduleClass::get();
            }
            return DataTables::of($StaffScheduleClass)
                ->addIndexColumn()
                ->addColumn('staff_id', function ($StaffScheduleClass) {
                    return $StaffScheduleClass->Staff->staff_name;
                })
                ->addColumn('section_id', function ($StaffScheduleClass) {
                    return $StaffScheduleClass->ClassSection->section;
                })
                ->addColumn('subjects', function ($StaffScheduleClass) {
                    date_default_timezone_set('Asia/Kolkata');
                    $SubjectsDetails = getSubjectDetails($StaffScheduleClass->id);
                    $newTime = strtotime('-30 minutes');
                    $options = '';
                    foreach ($SubjectsDetails as $key => $SubjectsDetail) {
                        $live = "";
                        if(auth()->user()->user_type != "super_admin" && auth()->user()->user_type != "Admin" ){
                            if(date('Y-m-d') == $SubjectsDetail['subject_day']){
                                if(date('H:i') >= DATE("H:i", STRTOTIME(($SubjectsDetail['from_time'].'-30 minutes'))) && date('H:i') <= $SubjectsDetail['to_time']){
                                    $live .= '&nbsp;&nbsp;&nbsp;<a href="' . action('StaffController@screenshare', [$SubjectsDetail['scheduleclass_id'],$StaffScheduleClass->class,$StaffScheduleClass->section_id,$SubjectsDetail['subject_id']]) . '" class="btn btn-lightred btn-sm mt-10">Go Live</button></a>';
                                }
                            }
                        }
						 if(auth()->user()->user_type == "super_admin" || auth()->user()->user_type == "Admin" ){
						$session_id = '';
                        $Class_name = 'Not Started';
						$link ="#";
						   if(date('Y-m-d') == $SubjectsDetail['subject_day']){
                                    if(date('H:i') >= DATE("H:i", STRTOTIME(($SubjectsDetail['to_time'])))){
									$Class_name = 'Class Ended';
									$link ="#";
									}
									if($SubjectsDetail['live']){
										$session_id = $SubjectsDetail['live'][0]['session_id'];
										$Class_name = "Started";
										$link = action('StudentController@viewscreenshare', [$session_id]);
									}
									$live .= '&nbsp;&nbsp;&nbsp;<a href="' . $link . '" class="btn btn-lightred btn-sm mt-10">'.$Class_name.'</button></a>';
                            }
                        }
                        $options .= $SubjectsDetail['subject_name'] . " - " . date('d/m/Y', strtotime($SubjectsDetail['subject_day'])) . " - " . DATE("g:i a", STRTOTIME($SubjectsDetail['from_time'])) . " - " . DATE("g:i a", STRTOTIME($SubjectsDetail['to_time'])) . "-" . $live . ",";
                    }
                    return $options;
                })
                ->addColumn('action', function ($StaffScheduleClass) {
                    $btn = "";
                    if (!auth()->user()->hasAnyPermission('staff_schedule_update', 'staff_schedule_delete')) {
                        $btn .= '<p>-</p>';
                    }
                    if (auth()->user()->hasPermissionTo('staff_schedule_update')) {
                        $btn .= '<a href="#" class="btn EditStaffSchedule" id="' . $StaffScheduleClass->id . '" data-toggle="modal" data-target="#EditStaffScheduleModal">
                            <i class="fa fa-pencil text-aqua"></i>
                        </a>';
                    }
                    if (auth()->user()->hasPermissionTo('staff_schedule_delete')) {
                        $btn .= '<a href="#" id="' . $StaffScheduleClass->id . '" class="btn DeleteStaffSchedule" data-toggle="modal" data-target="#DeleteStaffScheduleModel">
                            <i class="fa fa-trash-o" style="color:red;"></i>
                        </a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'subjects'])
                ->make(true);
        }
        return view('staff_schedule.view', $data);
    }

    public function StaffScheduleCreate(Request $request)
    {
        $data['staff_id'] = $request->staff_id;
        $data['class'] = $request->taken_class;
        $data['section_id'] = $request->section_id;
        $data['StaffSubjectAssigns'] = StaffSubjectAssign::where([['staff_id', $request->staff_id], ['class', $request->taken_class], ['section_id', $request->section_id]])->get();
        return view('staff_schedule.subject_details', $data)->render();
    }

    public function TotalSchedule(Request $request)
    {
        return view('staff_schedule.total_schedule');
    }

    public function TotalScheduleList(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        // DB::enableQueryLog();
        $StaffScheduleSubjectDetails = StaffScheduleSubjectDetails::whereBetween('staff_schedule_subject_details.subject_day', [$from_date, $to_date])
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
        $scheduleDetails = StaffScheduleSubjectDetails::whereDate('staff_schedule_subject_details.subject_day', $currentRowDate)
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

    public function StaffScheduleRender(Request $request)
    {
        $data['StaffScheduleClass'] = StaffScheduleClass::find($request->staff_schedule_id);
        $data['staff_id'] = $data['StaffScheduleClass']->staff_id;
        $data['class'] = $data['StaffScheduleClass']->class;
        $data['section_id'] = $data['StaffScheduleClass']->section_id;
        $data['StaffSubjectAssigns'] = StaffSubjectAssign::where([['staff_id', $data['StaffScheduleClass']->staff_id], ['class', $data['StaffScheduleClass']->class], ['section_id', $data['StaffScheduleClass']->section_id]])->get();
        $data['StaffScheduleSubjectDetails'] = StaffScheduleSubjectDetails::where('staff_schedule_class_id', $request->staff_schedule_id)->get();
        return view('staff_schedule.subject_details', $data)->render();
    }

    public function StaffScheduleStore(Request $request)
    {
        $Staffidcount = 1;
        $Staffidval = 0;

        $Staffclasscount = 1;
        $Staffclassval = 0;

        $staffidscheck = true;
        $staffclasscheck = true;

        $StaffIdchecks = StaffScheduleClass::where([['staff_schedule_classes.staff_id', $request->staff_id]])->join('staff_schedule_subject_details', 'staff_schedule_subject_details.staff_schedule_class_id', 'staff_schedule_classes.id')->get();
        $StaffScheduleClasschecks = StaffScheduleClass::where([['staff_schedule_classes.class', $request->class], ['staff_schedule_classes.section_id', $request->section_id]])->join('staff_schedule_subject_details', 'staff_schedule_subject_details.staff_schedule_class_id', 'staff_schedule_classes.id')->get();
        if (!empty($StaffIdchecks)) {
            foreach ($request->staff_schedule['subject_id'] as $key => $value) {
                $Staffidval = $Staffidcount++;
                $ft = date('H:i', STRTOTIME($request->staff_schedule['from_time'][$key]));
                $tt = date('H:i', STRTOTIME($request->staff_schedule['to_time'][$key]));
                foreach ($StaffIdchecks->pluck('subject_day')->toArray() as $dateKey => $date) {
                    if (in_array($date, array(date('Y-m-d',strtotime($request->staff_schedule['subject_day'][$key]))))) {
                        foreach ($StaffIdchecks->where('subject_day', $date)->pluck('from_time', 'to_time') as $to_time => $from_time) {
                            if ($ft >= $from_time && $tt >= $from_time && $ft >= $to_time && $tt >= $to_time || $ft <= $from_time && $tt <= $from_time && $ft <= $to_time && $tt <= $to_time) {
                                $staffidscheck = true;
                            } else {
                                $Data['status'] = 'error';
                                $Data['message'] = 'This Staff already added for another class';
                                return response()->json($Data);
                            }
                        }
                    } else {
                        $staffidscheck = true;
                    }
                }
            }
        }

        if (!empty($StaffScheduleClasschecks)) {
            foreach ($request->staff_schedule['subject_id'] as $key => $value) {
                $Staffclassval = $Staffclasscount++;
                $ft = date('H:i', STRTOTIME($request->staff_schedule['from_time'][$key]));
                $tt = date('H:i', STRTOTIME($request->staff_schedule['to_time'][$key]));
                foreach ($StaffScheduleClasschecks->pluck('subject_day')->toArray() as $dateKey => $date) {
                    if (in_array($date, array(date('Y-m-d',strtotime($request->staff_schedule['subject_day'][$key]))))) {
                        foreach ($StaffScheduleClasschecks->where('subject_day', $date)->pluck('from_time', 'to_time') as $to_time => $from_time) {
                            if ($ft >= $from_time && $tt >= $from_time && $ft >= $to_time && $tt >= $to_time || $ft <= $from_time && $tt <= $from_time && $ft <= $to_time && $tt <= $to_time) {
                                $staffclasscheck = true;
                            } else {
                                $Data['status'] = 'error';
                                $Data['message'] = 'This class alresdy added for another subject for this time';
                                return response()->json($Data);
                            }
                        }
                    } else {
                        $staffclasscheck = true;
                    }
                }
            }
        }
        // return 1;
        if ($staffidscheck == true && $staffclasscheck == true) {
            DB::beginTransaction();
            try {
                $StaffScheduleClass = new StaffScheduleClass;
                $StaffScheduleClass->staff_id = $request->staff_id;
                $StaffScheduleClass->class = $request->class;
                $StaffScheduleClass->section_id = $request->section_id;
                $StaffScheduleClass->save();
                if (!empty($request->staff_schedule)) {
                    foreach ($request->staff_schedule['subject_id'] as $key => $value) {
                        $StaffScheduleSubjectDetails = new StaffScheduleSubjectDetails;
                        $StaffScheduleSubjectDetails->staff_schedule_class_id = $StaffScheduleClass->id;
                        $StaffScheduleSubjectDetails->class = $request->class;
                        $StaffScheduleSubjectDetails->section_id = $request->section_id;
                        $StaffScheduleSubjectDetails->staff_id = $request->staff_id;
                        $StaffScheduleSubjectDetails->subject_id = $request->staff_schedule['subject_id'][$key];
                        $StaffScheduleSubjectDetails->subject_day = \Carbon\Carbon::createFromFormat("m/d/Y", $request->staff_schedule['subject_day'][$key])->format('Y-m-d');
                        $StaffScheduleSubjectDetails->from_time = date('H:i', STRTOTIME($request->staff_schedule['from_time'][$key]));
                        $StaffScheduleSubjectDetails->to_time = date('H:i', STRTOTIME($request->staff_schedule['to_time'][$key]));
                        $StaffScheduleSubjectDetails->save();
                    }
                }
                DB::commit();
                $Data['status'] = 'success';
                $Data['message'] = 'Staff Schedule Assigned';
                return response()->json($Data);
            } catch (Exception $e) {
                DB::rollBack();
                $Data['status'] = 'error' . $e;
                return response()->json($Data);
            }
        }
    }

    public function StaffScheduleEdit(Request $request)
    {
        try {
            $Data['StaffScheduleClass'] = StaffScheduleClass::find($request->staff_schedule_id);
            $Data['StaffScheduleSubjectDetails'] = StaffScheduleSubjectDetails::where('staff_schedule_class_id', $request->staff_schedule_id)->get();
            $Data['status'] = 'success';
            return response()->json($Data);
        } catch (Exception $e) {
            return response()->json(['error' => 'Subject Not Found!']);
        }
    }

    public function StaffScheduleUpdate(Request $request)
    {
        // return $request->all();
        $Staffidcount = 1;
        $Staffidval = 0;

        $Staffclasscount = 1;
        $Staffclassval = 0;

        $staffidscheck = true;
        $staffclasscheck = true;
        // return $request->staff_schedule['id'];
        $StaffIdchecks = StaffScheduleClass::where([['staff_schedule_classes.staff_id', $request->staff_id]])->join('staff_schedule_subject_details', 'staff_schedule_subject_details.staff_schedule_class_id', 'staff_schedule_classes.id')->whereNotIn('staff_schedule_subject_details.id', $request->staff_schedule['id'])->get();
        $StaffScheduleClasschecks = StaffScheduleClass::where([['staff_schedule_classes.class', $request->class], ['staff_schedule_classes.section_id', $request->section_id]])->join('staff_schedule_subject_details', 'staff_schedule_subject_details.staff_schedule_class_id', 'staff_schedule_classes.id')->whereNotIn('staff_schedule_subject_details.id', $request->staff_schedule['id'])->get();
        if (!empty($StaffIdchecks)) {
            foreach ($request->staff_schedule['subject_id'] as $key => $value) {
                $Staffidval = $Staffidcount++;
                $ft = date('H:i', STRTOTIME($request->staff_schedule['from_time'][$key]));
                $tt = date('H:i', STRTOTIME($request->staff_schedule['to_time'][$key]));
                foreach ($StaffIdchecks->pluck('subject_day')->toArray() as $dateKey => $date) {
                    if (in_array($date, array(date('Y-m-d',strtotime($request->staff_schedule['subject_day'][$key]))))) {
                        foreach ($StaffIdchecks->where('subject_day', $date)->pluck('from_time', 'to_time') as $to_time => $from_time) {
                            if ($ft >= $from_time && $tt >= $from_time && $ft >= $to_time && $tt >= $to_time || $ft <= $from_time && $tt <= $from_time && $ft <= $to_time && $tt <= $to_time) {
                                $staffidscheck = true;
                            } else {
                                return back()->with('error', 'This Staff already added for another class')->withInput();
                            }
                        }
                    } else {
                        $staffidscheck = true;
                    }
                }
            }
        }

        if (!empty($StaffScheduleClasschecks)) {
            foreach ($request->staff_schedule['subject_id'] as $key => $value) {
                $Staffclassval = $Staffclasscount++;
                $ft = date('H:i', STRTOTIME($request->staff_schedule['from_time'][$key]));
                $tt = date('H:i', STRTOTIME($request->staff_schedule['to_time'][$key]));
                foreach ($StaffScheduleClasschecks->pluck('subject_day')->toArray() as $dateKey => $date) {
                    if (in_array($date, array(date('Y-m-d',strtotime($request->staff_schedule['subject_day'][$key]))))) {
                        foreach ($StaffScheduleClasschecks->where('subject_day', $date)->pluck('from_time', 'to_time') as $to_time => $from_time) {
                            if ($ft >= $from_time && $tt >= $from_time && $ft >= $to_time && $tt >= $to_time || $ft <= $from_time && $tt <= $from_time && $ft <= $to_time && $tt <= $to_time) {
                                $staffclasscheck = true;
                            } else {
                                return back()->with('error', 'This class alresdy added for another subject for this time')->withInput();
                            }
                        }
                    } else {
                        $staffclasscheck = true;
                    }
                }
            }
        }
        if ($staffidscheck == true && $staffclasscheck == true) {
            DB::beginTransaction();
            try {
                if (!empty($request->staff_schedule)) {
                    $StaffScheduleSubjectDetails = StaffScheduleSubjectDetails::where('staff_schedule_class_id', $request->staff_schedule_id)->get();
                    foreach ($StaffScheduleSubjectDetails->pluck("id") as $key => $value) {
                        if (in_array($value, $request->staff_schedule['id'])) {
                            $StudentSectionDetail = StaffScheduleSubjectDetails::where('id', $value)->first();
                        } else {
                            $StaffScheduleSubjectDetailsdelete = StaffScheduleSubjectDetails::where('id', $value)->first()->delete();
                        }
                    }
                    foreach ($request->staff_schedule['subject_id'] as $key1 => $value) {
                        if (isset($request->staff_schedule['id'][$key1])) {
                            $StaffScheduleSubjectDetails = StaffScheduleSubjectDetails::find($request->staff_schedule['id'][$key1]);
                        } else {
                            $StaffScheduleSubjectDetails = new StaffScheduleSubjectDetails;
                        }
                        $StaffScheduleSubjectDetails->staff_schedule_class_id = $request->staff_schedule_id;
                        $StaffScheduleSubjectDetails->class = $request->class;
                        $StaffScheduleSubjectDetails->section_id = $request->section_id;
                        $StaffScheduleSubjectDetails->staff_id = $request->staff_id;
                        $StaffScheduleSubjectDetails->subject_id = $request->staff_schedule['subject_id'][$key1];
                        $StaffScheduleSubjectDetails->subject_day = \Carbon\Carbon::createFromFormat("m/d/Y", $request->staff_schedule['subject_day'][$key1])->format('Y-m-d');
                        $StaffScheduleSubjectDetails->from_time = date('H:i', STRTOTIME($request->staff_schedule['from_time'][$key1]));
                        $StaffScheduleSubjectDetails->to_time = date('H:i', STRTOTIME($request->staff_schedule['to_time'][$key1]));
                        $StaffScheduleSubjectDetails->save();
                    }
                }
                DB::commit();
                return back()->with('success', 'Staff Schedule Updated Successfully');
            } catch (Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Staff cannot be Updated');
            }
        } else {
            return back()->with('error', 'Staff Schedule cannot be Updated');
        }
    }

    public function StaffScheduleDelete(Request $request)
    {
        try {
            $Data['StaffScheduleSubjectDetails'] = StaffScheduleSubjectDetails::where('staff_schedule_class_id', $request->staff_schedule_id)->delete();
            $Data['StaffScheduleClass'] = StaffScheduleClass::find($request->staff_schedule_id)->delete();
            $Data['status'] = 'success';
            return response()->json($Data);
        } catch (Exception $e) {
            return response()->json(['error' => 'Subject Cannot be Deleted!']);
        }
    }
}
