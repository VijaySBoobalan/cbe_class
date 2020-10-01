<?php

namespace App\Http\Controllers;

use App\ClassSection;
use App\Staff;
use App\StaffScheduleClass;
use App\StaffScheduleSubjectDetails;
use App\StaffSubjectAssign;
use App\Subject;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\Facades\DataTables;

class StaffSubjectAssignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(auth()->user()->user_type == 'Staff'){
            $data['Staffs'] = Staff::where('id',auth()->user()->user_id)->get();
        }else{
            $data['Staffs'] = Staff::get();
        }
        $data['ClassSection'] = ClassSection::get()->unique('class');
        $data['Subjects'] = Subject::get()->unique('class');
        if (request()->ajax()) {
            if(auth()->user()->user_type == 'Staff'){
                $StaffSubjectAssign = StaffSubjectAssign::where('staff_id',auth()->user()->user_id)->get();
            }else{
                $staff_id = $request->staff_id;
                $class_id = $request->class_id;
                $section_id = $request->section_id;
                $StaffSubjectAssign = StaffSubjectAssign::
                when($staff_id, function ($q) use ($staff_id) {
                    if ($staff_id!=null) {
                       $q->where('staff_id', $staff_id);
                    }
                    return $q;
                })
                ->when($class_id, function ($q) use ($class_id) {
                    if ($class_id!=null) {
                       $q->where('class', $class_id);
                    }
                    return $q;
                })
                ->when($section_id, function ($q) use ($section_id) {
                    if ($section_id!=null) {
                       $q->where('section_id', $section_id);
                    }
                    return $q;
                })
                ->get();
            }
            return DataTables::of($StaffSubjectAssign)
                ->addIndexColumn()
                ->addColumn('subject_id', function ($StaffSubjectAssign) {
                    return $StaffSubjectAssign->StaffSubject->subject_name;
                })
                ->addColumn('section_id', function ($StaffSubjectAssign) {
                    return $StaffSubjectAssign->ClassSection->section;
                })
                ->addColumn('staff_id', function ($StaffSubjectAssign) {
                    return $StaffSubjectAssign->Staff->staff_name;
                })
                ->addColumn('action', function ($StaffScheduleClass) {
                    $btn = "";
                    if(!auth()->user()->hasAnyPermission('staff_schedule_assign_update','staff_schedule_assign_delete')){
                        $btn .= '<p>-</p>';
                    }
                    if(auth()->user()->hasPermissionTo('staff_schedule_assign_update')){
                        $btn .= '<a href="#" class="btn EditStaffSubject" id="'.$StaffScheduleClass->id.'" data-toggle="modal" data-target="#EditStaffSubjectModal"><i class="fa fa-pencil text-aqua"></i></a>';
                    }
                    if(auth()->user()->hasPermissionTo('staff_schedule_assign_delete')){
                        $btn .= '<a href="#" id="'.$StaffScheduleClass->id.'" class="btn DeleteStaffSubject" data-toggle="modal" data-target="#DeleteStaffSubjectModel"><i class="fa fa-trash-o" style="color:red;"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return View('staff_subject_assign.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Subject::where([['class',$request->class_id],['section_id',$request->section_id]])->get();
    }

    public function EditStaffSubject (Request $request)
    {
        try {
            $Data['ClassSection'] = ClassSection::get()->unique('class');
            $Data['StaffSubjectAssign'] = StaffSubjectAssign::findorfail($request->staff_subject_id);
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
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
        $StaffSubjectAssigns = StaffSubjectAssign::where([['class',$request->class],['section_id',$request->section_id],['subjects',$request->subjects]]);
        try{
            if($StaffSubjectAssigns->count()>0){
                $Data['data'] = 'error';
                return response()->json($Data);
            }
            $StaffSubjectAssign = new StaffSubjectAssign;
            $StaffSubjectAssign->staff_id = $request->staff_id;
            $StaffSubjectAssign->class = $request->class;
            $StaffSubjectAssign->section_id = $request->section_id;
            $StaffSubjectAssign->subjects = $request->subjects;
            $StaffSubjectAssign->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error'.$e;
            return response()->json($Data);
        }
    }


    public function UpdateStaffSubject (Request $request)
    {
        try {
            $StaffSubjectAssign = StaffSubjectAssign::findorfail($request->staff_subject_id);
            $StaffSubjectAssign->staff_id = $request->staff_id;
            $StaffSubjectAssign->class = $request->class;
            $StaffSubjectAssign->section_id = $request->section_id;
            $StaffSubjectAssign->subjects = $request->subjects;
            $StaffSubjectAssign->save();
            $Data['status'] = 'success';
            return response()->json($Data);
        }catch (Exception $e){
            $Data['status'] = 'error';
            return response()->json($Data);
        }
    }

    public function DeleteStaffSubject (Request $request)
    {
        try {
            $StaffSubjectAssigns = StaffSubjectAssign::findorfail($request->staff_subject_id);
            $count = StaffScheduleSubjectDetails::where([['staff_id',$StaffSubjectAssigns->staff_id],['class',$StaffSubjectAssigns->class],['section_id',$StaffSubjectAssigns->section_id],['subject_id',$StaffSubjectAssigns->subjects]])->count();
            $StaffScheduleClass = StaffScheduleClass::where([['staff_id',$StaffSubjectAssigns->staff_id],['class',$StaffSubjectAssigns->class],['section_id',$StaffSubjectAssigns->section_id]])->get();
            if ($count<=0) {
                $StaffSubjectAssign = StaffSubjectAssign::findorfail($request->staff_subject_id)->delete();
                $Data['status'] = 'success';
                return response()->json($Data);
            }else{
                $Data['status'] = 'warning';
                return response()->json($Data);
            }
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
