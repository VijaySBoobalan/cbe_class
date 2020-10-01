<?php

namespace App\Http\Controllers\FeesManagement;

use App\FeeGroupTypeDetails;
use App\FeesGroup;
use App\FeesMaster;
use App\FeesType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeesGroupController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:fee_type_group_view|fee_type_group_create|fee_type_group_update|fee_type_group_delete|fee_type_assign_class', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:fee_type_group_view', ['only' => ['index']]);
        $this->middleware('permission:fee_type_group_create', ['only' => ['create','store']]);
        $this->middleware('permission:fee_type_group_update', ['only' => ['edit','update']]);
        $this->middleware('permission:fee_type_group_delete', ['only' => ['destroy']]);
    }

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
        return view('fees_management.fee_type_group.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['FeesMaster'] = FeesMaster::get();
        return view('fees_management.fee_type_group.add',$data);
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
            $FeesGroup = new FeesGroup();
            $FeesGroup->fee_type = $request->fee_type;
            $FeesGroup->scholarship_for = $request->scholarship_for;
            $FeesGroup->due_date = $request->due_date;
            $FeesGroup->fine_per_day = $request->fine_per_day;
            $FeesGroup->save();
            if(!empty($request->fee_group)){
                foreach ($request->fee_group['fee_name_id'] as $key => $value) {
                    $FeeGroupTypeDetails = new FeeGroupTypeDetails();
                    $FeeGroupTypeDetails->fee_group_type_id = $FeesGroup->id;
                    $FeeGroupTypeDetails->fee_name_id = $value;
                    $FeeGroupTypeDetails->save();
                }
                DB::commit();
                return back()->with('success','Fee Group Added Successfully');
            }
            return back()->with('warning','Please Check atleast One Fee Group');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fee Group Cannot Be Added');
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
        return 1;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['FeesMaster'] = FeesMaster::get();
        $data['FeesGroup'] = FeesGroup::find($id);
        $data['FeesTypes'] = FeesType::where('fee_type',$data['FeesGroup']->fee_type)->get();
        return view('fees_management.fee_type_group.add',$data);
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
            $FeesGroup = FeesGroup::find($id);
            $FeesGroup->fee_type = $request->fee_type;
            $FeesGroup->scholarship_for = $request->scholarship_for;
            $FeesGroup->due_date = $request->due_date;
            $FeesGroup->fine_per_day = $request->fine_per_day;
            $FeesGroup->save();
            if(!empty($request->fee_group)){
                $FeeGroupTypeDetails = FeeGroupTypeDetails::where("fee_group_type_id", $id)->get();
                foreach ($FeeGroupTypeDetails->pluck("fee_name_id") as $key => $value) {
                    if (in_array($value, $request->fee_group['fee_name_id'])) {
                        $StudentSectionDetail = FeeGroupTypeDetails::where('fee_name_id',$value)->first();
                    }else{
                        $FeeGroupTypeDetailsdelete = FeeGroupTypeDetails::where([['fee_name_id',$value],["fee_group_type_id", $id]])->first()->delete();
                    }
                }
                foreach ($request->fee_group['fee_name_id'] as $key => $value) {
                    $FeeGroupTypeDetails = FeeGroupTypeDetails::where([['fee_name_id',$value],["fee_group_type_id", $id]])->first();
                    if(!isset($FeeGroupTypeDetails)){
                        $FeeGroupTypeDetails = new FeeGroupTypeDetails;
                    }
                    $FeeGroupTypeDetails->fee_group_type_id = $FeesGroup->id;
                    $FeeGroupTypeDetails->fee_name_id = $value;
                    $FeeGroupTypeDetails->save();
                }
                DB::commit();
                return back()->with('success','Fee Group Updated Successfully');
            }
            return back()->with('warning','Please Check atleast One Fee Group');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fee Group Cannot Be Updated');
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
            $FeesGroup = FeesGroup::find($id)->delete();
            $FeeGroupTypeDetails = FeeGroupTypeDetails::where("fee_group_type_id", $id)->get();
            return back()->with('success','Fee Group Deleted Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fee Group Cannot Be Deleted');
        }
    }

    public function FeeGroupDetails(Request $request)
    {
        $data['FeesTypes'] = FeesType::where('fee_type',$request->fee_type)->get();
        return view('fees_management.fee_type_group.feeAdd',$data)->render();
    }
}
