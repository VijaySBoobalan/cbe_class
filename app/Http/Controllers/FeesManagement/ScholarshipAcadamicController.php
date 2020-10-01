<?php

namespace App\Http\Controllers\FeesManagement;

use App\Http\Controllers\Controller;
use App\ScholarshipAcadamic;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScholarshipAcadamicController extends Controller
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
            $fee_type = $request->fee_type;
            $data['ScholarshipAcadamics'] = ScholarshipAcadamic::
            when($fee_type, function ($q) use ($fee_type) {
                if ($fee_type!=null) {
                   $q->where('fee_type', $fee_type);
                }
                return $q;
            })
            ->get();
        }else{
            $data['fee_type'] = "acadamic";
            $data['ScholarshipAcadamics'] = ScholarshipAcadamic::where('fee_type',"acadamic")->get();
        }
        return view('fees_management.scholarship_acadamic.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fees_management.scholarship_acadamic.add');
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
            $ScholarshipAcadamic = new ScholarshipAcadamic;
            $ScholarshipAcadamic->fee_type = $request->fee_type;
            $ScholarshipAcadamic->acadamic_scholarship_name = $request->acadamic_scholarship_name;
            $ScholarshipAcadamic->percentage_from = $request->percentage_from;
            $ScholarshipAcadamic->percentage_to = $request->percentage_to;
            $ScholarshipAcadamic->acadamic_fees_concertion = $request->acadamic_fees_concertion;
            $ScholarshipAcadamic->maintain_percentage = $request->maintain_percentage;
            $ScholarshipAcadamic->zonal_scholarship_name = $request->zonal_scholarship_name;
            $ScholarshipAcadamic->zonal_particulars = $request->zonal_particulars;
            $ScholarshipAcadamic->zonal_fees_concertion = $request->zonal_fees_concertion;
            $ScholarshipAcadamic->save();
            DB::commit();
            return back()->with('success','Scholarship Details Added Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Scholarship Details Cannot Be Added');
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
        $data['ScholarshipAcadamic'] = ScholarshipAcadamic::find($id);
        return view('fees_management.scholarship_acadamic.add',$data);
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
            $ScholarshipAcadamic = ScholarshipAcadamic::find($id);
            $ScholarshipAcadamic->fee_type = $request->fee_type;
            $ScholarshipAcadamic->acadamic_scholarship_name = $request->acadamic_scholarship_name;
            $ScholarshipAcadamic->percentage_from = $request->percentage_from;
            $ScholarshipAcadamic->percentage_to = $request->percentage_to;
            $ScholarshipAcadamic->acadamic_fees_concertion = $request->acadamic_fees_concertion;
            $ScholarshipAcadamic->maintain_percentage = $request->maintain_percentage;
            $ScholarshipAcadamic->zonal_scholarship_name = $request->zonal_scholarship_name;
            $ScholarshipAcadamic->zonal_particulars = $request->zonal_particulars;
            $ScholarshipAcadamic->zonal_fees_concertion = $request->zonal_fees_concertion;
            $ScholarshipAcadamic->save();
            DB::commit();
            return back()->with('success','Scholarship Details Updated Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Scholarship Details Cannot Be Updated');
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
        DB::beginTransaction();
        try{
            $ScholarshipAcadamic = ScholarshipAcadamic::find($id)->delete();
            DB::commit();
            return back()->with('success','Scholarship Acadamic Deleted Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Scholarship Acadamic Cannot Be Deleted');
        }
    }
}
