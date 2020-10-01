<?php

namespace App\Http\Controllers\FeesManagement;

use App\FeesMaster;
use App\FeesType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeesTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fee_type_view|fee_type_create|fee_type_update|fee_type_delete', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:fee_type_view', ['only' => ['index']]);
        $this->middleware('permission:fee_type_create', ['only' => ['create','store']]);
        $this->middleware('permission:fee_type_update', ['only' => ['edit','update']]);
        $this->middleware('permission:fee_type_delete', ['only' => ['destroy']]);
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
            $data['fee_name'] = $request->fee_name;
            $fee_type = $request->fee_type;
            $fee_name = $request->fee_name;
            $data['FeesTypes'] = FeesType::
            when($fee_type, function ($q) use ($fee_type) {
                if ($fee_type!=null) {
                   $q->where('fee_type', $fee_type);
                }
                return $q;
            })
            ->when($fee_name, function ($q) use ($fee_name) {
                if ($fee_name!=null) {
                   $q->where('fee_name','LIKE', '%' . $fee_name . '%');
                }
                return $q;
            })
            ->get();
        }else{
            $data['fee_type'] = "";
            $data['fee_name'] = "";
            $data['FeesTypes'] = FeesType::get();
        }
        $data['FeesMaster'] = FeesMaster::get();
        return view('fees_management.fee_type.view',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['FeesMaster'] = FeesMaster::get();
        return view('fees_management.fee_type.add',$data);
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
            $FeesType = new FeesType;
            $FeesType->fee_type = $request->fee_type;
            $FeesType->fee_name = $request->fee_name;
            $FeesType->fee_code = $request->fee_code;
            $FeesType->scholarship = $request->scholarship;
            $FeesType->amount = $request->amount;
            $FeesType->save();
            DB::commit();
            return back()->with('success','Fees Type Added Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Type Cannot Be Added');
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
        $data['FeesType'] = FeesType::find($id);
        $data['FeesMaster'] = FeesMaster::get();
        return view('fees_management.fee_type.add',$data);
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
            $FeesType = FeesType::find($id);
            $FeesType->fee_type = $request->fee_type;
            $FeesType->fee_name = $request->fee_name;
            $FeesType->fee_code = $request->fee_code;
            $FeesType->scholarship = $request->scholarship;
            $FeesType->amount = $request->amount;
            $FeesType->save();
            DB::commit();
            return redirect('fee-type')->with('success','Fees Type Updated Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Type Cannot Be Updated');
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
            $FeesType = FeesType::find($id)->delete();
            DB::commit();
            return back()->with('success','Fees Type Deleted Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Type Cannot Be Deleted');
        }
    }
}
