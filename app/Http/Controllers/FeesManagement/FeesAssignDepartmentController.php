<?php

namespace App\Http\Controllers\FeesManagement;

use App\ClassSection;
use App\FeesAssignDepartment;
use App\FeesGroup;
use App\FeesMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeesAssignDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->all())){
            $data['fee_type'] = $request->fee_type;
            $data['class_id'] = $request->class_id;
            $data['section'] = serialize($request->section);
            $fee_type = $request->fee_type;
            $class_id = $request->class_id;
            $section = $request->section;
            $data['FeesAssignDepartments'] = FeesAssignDepartment::
            when($fee_type, function ($q) use ($fee_type) {
                if ($fee_type!=null) {
                   $q->where('fee_id', $fee_type);
                }
                return $q;
            })
            ->when($class_id, function ($q) use ($class_id) {
                if ($class_id!=null) {
                   $q->where('class_id', $class_id);
                }
                return $q;
            })
            ->when($section, function ($q) use ($section) {
                if ($section!=null) {
                   $q->whereIn('section', $section);
                }
                return $q;
            })
            ->get();
        }else{
            $data['fee_type'] = "";
            $data['class_id'] = "";
            $data['section'] = "";
            $data['FeesAssignDepartments'] = FeesAssignDepartment::get();
        }
        $data['FeesMaster'] = FeesMaster::get();
        $data['ClassSection'] = ClassSection::get()->unique('class');
        return view('fees_management.fee_assigned_department.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            if(!empty($request->class_id)){
                if(!empty($request->section)){
                    foreach ($request->section as $key => $section) {
                        $FeesAssignDepartment = new FeesAssignDepartment;
                        $FeesAssignDepartment->fee_group_id = $request->fee_group_id;
                        $FeesAssignDepartment->fee_id = $request->fee_id;
                        $FeesAssignDepartment->class_id = $request->class_id;
                        $FeesAssignDepartment->section = $section;
                        $FeesAssignDepartment->save();
                    }
                }else{
                    return back()->with('error','Please Select Atleast One Section');
                }
            }else{
                return back()->with('error','Please Select Atleast One Class');
            }
            DB::commit();
            return back()->with('success','Fees Assigned Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Assigned Cannot Be Added');
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
        $data['FeesGroup'] = FeesGroup::find($id);
        $data['ClassSections'] = ClassSection::get()->unique('class');
        return view('fees_management.fee_assigned_department.add',$data);
    }


    public function getClassSection(Request $request)
    {
        $data['ClassSections'] = ClassSection::whereIn('class',)->unique('class');
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
