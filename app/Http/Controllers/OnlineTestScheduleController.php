<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\OnlineTestSchedule;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class OnlineTestScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $tests =  OnlineTestSchedule::leftJoin('class_sections','class_sections.id','=','online_test_schedules.section_id')
            ->select('online_test_schedules.id as test_id','online_test_schedules.*','class_sections.*')
            ->get();
            return DataTables::of($tests)
                ->addIndexColumn()
                ->addColumn('action', function ($test) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('batch_update','batch_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('batch_update')){
                        $btn .= '<a href="#" class="btn EditOnlineTest" id="'.$test->test_id.'" data-toggle="modal" data-target="#editOnlineTestModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('batch_delete')){
                        $btn .= '<a href="#" id="'.$test->test_id.'" class="btn DeleteOnlineTest" data-toggle="modal" data-target="#DeleteModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['ClassSection'] = ClassSection::get()->unique('class');
        return view('onlinetest.view', $data);
    }
	public function getExamEvents(Request $request){
	if(!empty($request->class_id) || !empty($request->section_id)){
		$events= OnlineTestSchedule::where([['class_id',$request->class_id],['section_id',$request->section_id]])
		-> leftJoin('class_sections','class_sections.id','=','online_test_schedules.section_id')
		->select('online_test_schedules.id','exam_name','from_date','to_date','class_sections.id as cl_id','class_sections.*')
		->get();
	}else{
		 $events= OnlineTestSchedule:: leftJoin('class_sections','class_sections.id','=','online_test_schedules.section_id')
		->select('online_test_schedules.id','exam_name','from_date','to_date','class_sections.id as cl_id','class_sections.*')
		->get();
	}
		foreach($events as $key=>$event){
			 $data[] = array(
							'id' => $event->id,
							'title' => $event->exam_name."(".$event->class.')('.$event->section.')',
							'start' => $event->from_date,
							'end' => $event->to_date."T24:00:00"
   );
   
		}
		 echo json_encode($data);
	} 
    public function create()
    {
        //
    }

    public function OnlineTeststore(Request $request){
        try{   
            $OnlineTest = new OnlineTestSchedule;
            $OnlineTest->exam_name  = $request->exam_name;
            $OnlineTest->class_id   = $request->student_class;
            $OnlineTest->section_id = $request->section_id;
            $OnlineTest->from_time  = $request->from_time;
            $OnlineTest->to_time    = $request->to_time;
            $OnlineTest->from_date  = date('Y-m-d', strtotime($request->from_date));
            $OnlineTest->to_date    = date('Y-m-d', strtotime($request->to_date));
            $OnlineTest->topic      = $request->topic;
            $OnlineTest->save();
            $Data['status'] = 'success';
            $Data['message'] = 'Online Test Added Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            $Data['message'] = 'Something Went Wrong ! Please Try Again.';
            return response()->json($Data);
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function OnlineTestedit(Request $request){
        try {
            $Data['OnlineTests'] = OnlineTestSchedule::findorfail(request('test_id'));
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            return response()->json(['error'=>'Online Test Schedule Not Found!']);
        }
    }

    public function OnlineTestUpdate (Request $request)
    {
        try {
            $OnlineTest = OnlineTestSchedule::findorfail($request->test_id);
            $OnlineTest->exam_name  = $request->edit_exam_name;
            $OnlineTest->class_id   = $request->edit_student_class;
            $OnlineTest->section_id = $request->edit_section_id;
            $OnlineTest->from_time  = $request->edit_from_time;
            $OnlineTest->to_time    = $request->edit_to_time;
            $OnlineTest->from_date  = date('Y-m-d', strtotime($request->edit_from_date));
            $OnlineTest->to_date    = date('Y-m-d', strtotime($request->edit_to_date));
            $OnlineTest->topic      = $request->edit_topic;
            $OnlineTest->save();
            $Data['status'] = 'success';
            $Data['message'] = 'Online Test Schedule Updated Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            $Data['message'] = 'Something Went Wrong !';
            return response()->json($Data);
        }
    }

    public function OnlineTestDelete(Request $request){
        try {
            $Years = OnlineTestSchedule::findorfail($request->testId)->delete();
            $Data['status'] = 'success';
            $Data['message'] = 'OnlineTest Schedule Deleted Successfully';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            $Data['message'] = 'Something Went Wrong !';
            return response()->json($Data);
        }
    }

    public function show(OnlineTestSchedule $onlineTestSchedule)
    {
        //
    }

    public function edit(OnlineTestSchedule $onlineTestSchedule)
    {
        //
    }

    public function update(Request $request, OnlineTestSchedule $onlineTestSchedule)
    {
        //
    }

    public function destroy(OnlineTestSchedule $onlineTestSchedule)
    {
        //
    }
}
