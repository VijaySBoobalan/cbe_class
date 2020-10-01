<?php

namespace App\Http\Controllers\FeesManagement;

use App\FeesMaster;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FeesMasterController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:fee_master_view|fee_master_create|fee_master_update|fee_master_delete', ['only' => ['index','show','create','store','edit','update','destroy']]);
        $this->middleware('permission:fee_master_view', ['only' => ['index']]);
        $this->middleware('permission:fee_master_create', ['only' => ['create','store']]);
        $this->middleware('permission:fee_master_update', ['only' => ['edit','update']]);
        $this->middleware('permission:fee_master_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['FeesMasters'] = FeesMaster::get();
        return view('fees_management.fee_master.add',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['FeesMasters'] = FeesMaster::get();
        return view('fees_management.fee_master.add',$data);
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
            $FeesMaster = new FeesMaster();
            $FeesMaster->fee_type = $request->fee_type;
            $FeesMaster->save();
            DB::commit();
            return back()->with('success','Fees Master Added Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Master Cannot Be Added');
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
        $data['FeesMaster'] = FeesMaster::find($id);
        return view('fees_management.fee_master.add',$data);
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
            $FeesMaster = FeesMaster::find($id);
            $FeesMaster->fee_type = $request->fee_type;
            $FeesMaster->save();
            DB::commit();
            return redirect('fee-masters')->with('success','Fees Master Updated Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Master Cannot Be Updated');
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
            $FeesMaster = FeesMaster::find($id)->delete();
            DB::commit();
            return back()->with('success','Fees Type Deleted Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Type Cannot Be Deleted');
        }
    }
}
