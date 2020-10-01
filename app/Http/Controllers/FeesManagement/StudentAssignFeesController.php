<?php

namespace App\Http\Controllers\FeesManagement;

use App\ClassSection;
use App\FeesGroup;
use App\FeesMaster;
use App\Http\Controllers\Controller;
use App\Student;
use App\StudentAssignFees;
use App\StudentAssignFeesDetails;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentAssignFeesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:fee_assign_view|fee_assign_create|fee_assign_update|fee_assign_delete|fee_assign_student_list', ['only' => ['index','show','create','store','edit','update','destroy','SearchDepartment','showStudentList']]);
        $this->middleware('permission:fee_assign_view', ['only' => ['index']]);
        $this->middleware('permission:fee_assign_create', ['only' => ['create','store']]);
        $this->middleware('permission:fee_assign_update', ['only' => ['edit','update']]);
        $this->middleware('permission:fee_assign_delete', ['only' => ['destroy']]);
        $this->middleware('permission:fee_assign_student_list', ['only' => ['showStudentList']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->all()){
            $data['class_id'] = $request->class_id;
            $data['section_id'] = $request->section_id;
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $data['StudentAssignFees'] = StudentAssignFees::
                when($class_id, function ($q) use ($class_id) {
                    if ($class_id!=null) {
                        $q->where('class_id', $class_id);
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
            }else{
                $data['class_id'] = "";
                $data['section_id'] = "";
                $data['StudentAssignFees'] = StudentAssignFees::get();
            }
            $data['ClassSection'] = ClassSection::get();
        return view('fees_management.assign_fee.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!empty($request->all())){
            $data['fee_type'] = $request->fee_type;
            $fee_type = $request->fee_type;
            $data['FeesGroups'] = FeesGroup::
            when($fee_type, function ($q) use ($fee_type) {
                if ($fee_type!=null) {
                   $q->where('fee_type', $fee_type);
                }
                return $q;
            })
            ->get();
        }else{
            $data['fee_type'] = "";
            $data['FeesGroups'] = FeesGroup::get();
        }
        $data['FeesMaster'] = FeesMaster::get();
        return view('fees_management.assign_fee.add',$data);
    }

    public function SearchDepartment(Request $request)
    {
        $class_id = $request->class_id;
        $section_id = $request->section_id;
        $data['Students'] = Student::
            when($class_id, function ($q) use ($class_id) {
                if ($class_id!=null) {
                    $q->where('student_class', $class_id);
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
        return view('fees_management.assign_fee.student_details',$data)->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $StudentAssignFees = new StudentAssignFees;
            $StudentAssignFees->fee_group_id = $request->fee_group_id;
            $StudentAssignFees->class_id = $request->class_id;
            $StudentAssignFees->section_id = $request->section_id;
            $StudentAssignFees->save();
            if ($request->student['student_id']) {
                foreach ($request->student['student_id'] as $key => $student_id) {
                    $StudentAssignFeesDetails = new StudentAssignFeesDetails;
                    $StudentAssignFeesDetails->student_assign_fee_id = $StudentAssignFees->id;
                    $StudentAssignFeesDetails->student_id = $student_id;
                    $StudentAssignFeesDetails->fee_group_id = $request->fee_group_id;
                    $StudentAssignFeesDetails->save();
                }
            }
            DB::commit();
            return back()->with('success','Student Fees Added Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Student Fees Cannot Be Added');
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
        $data['FeesGroups'] = FeesGroup::find($id);
        $data['ClassSection'] = ClassSection::get();
        return view('fees_management.assign_fee.student_wise',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['StudentAssignFees'] = StudentAssignFees::find($id);
        // $data['StudentAssignFeesDetails'] = StudentAssignFeesDetails::where('student_assign_fee_id',$id)->get();
        $data['FeesGroups'] = FeesGroup::find($data['StudentAssignFees']->fee_group_id);
        $data['ClassSection'] = ClassSection::get();
        $student_class = $data['StudentAssignFees']->student_class;
        $section_id = $data['StudentAssignFees']->section_id;
        $data['Students'] = Student::
            when($student_class, function ($q) use ($student_class) {
                if ($student_class!=null) {
                    $q->where('student_class', $student_class);
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
        return view('fees_management.assign_fee.student_wise',$data);
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
        DB::beginTransaction();
        try{
            $StudentAssignFees = StudentAssignFees::find($id);
            $StudentAssignFees->fee_group_id = $request->fee_group_id;
            $StudentAssignFees->class_id = $request->class_id;
            $StudentAssignFees->section_id = $request->section_id;
            $StudentAssignFees->save();
            if ($request->student['student_id']) {
                $StudentAssignFeesDetails = StudentAssignFeesDetails::where("student_assign_fee_id", $id)->get();
                foreach ($StudentAssignFeesDetails->pluck("student_id") as $key => $value) {
                    if (in_array($value, $request->student['student_id'])) {
                        $StudentSectionDetail = StudentAssignFeesDetails::where('student_id',$value)->first();
                    }else{
                        $StudentAssignFeesDetailsdelete = StudentAssignFeesDetails::where('student_id',$value)->first()->delete();
                    }
                }
                foreach ($request->student['student_id'] as $key => $student_id) {
                    $StudentAssignFeesDetails = StudentAssignFeesDetails::where('student_id',$student_id)->first();
                    if(!isset($StudentAssignFeesDetails)){
                        $StudentAssignFeesDetails = new StudentAssignFeesDetails;
                    }
                    $StudentAssignFeesDetails->student_assign_fee_id = $StudentAssignFees->id;
                    $StudentAssignFeesDetails->student_id = $student_id;
                    $StudentAssignFeesDetails->fee_group_id = $request->fee_group_id;
                    $StudentAssignFeesDetails->save();
                }
            }
            DB::commit();
            return back()->with('success','Student Fees Updated Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Student Fees Cannot Be Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // try{
            $data['StudentAssignFeesDetails'] = StudentAssignFeesDetails::where('student_assign_fee_id',$id)->delete();
            $data['StudentAssignFees'] = StudentAssignFees::find($id)->delete();
            return back()->with('success','Assigned Fees Deleted Successfully');
        // }catch (Exception $e) {
        //     Log::debug($e->getMessage());
        //     DB::rollBack();
        //     return back()->with('warning','Assigned Fees Cannot Be Deleted');
        // }
    }

    public function showStudentList($id)
    {
        $data['StudentAssignFees'] = StudentAssignFees::find($id);
        $data['StudentAssignFeesDetails'] = StudentAssignFeesDetails::where('student_assign_fee_id',$id)->get();
        return view('fees_management.assign_fee.show',$data);
    }
}
