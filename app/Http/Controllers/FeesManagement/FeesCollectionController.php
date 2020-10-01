<?php

namespace App\Http\Controllers\FeesManagement;

use App\ClassSection;
use App\FeesGroup;
use App\FeesCollection;
use App\Http\Controllers\Controller;
use App\Student;
use App\StudentAssignFees;
use App\StudentAssignFeesDetails;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class FeesCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:fee_view|fee_collect|student_pay_fee', ['only' => ['index','show','create','store','edit','update','destroy','AddFees']]);
        // $this->middleware('permission:fee_collect', ['only' => ['index','show','create','store','edit','update','destroy','AddFees']]);
        // $this->middleware('permission:fee_view', ['only' => ['create']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!empty($request->all())){
            $data['class_id'] = $request->class_id;
            $data['section_id'] = $request->section_id;
            $data['student_name'] = $request->student_name;
            $class_id = $request->class_id;
            $section_id = $request->section_id;
            $student_name = $request->student_name;
            $data['StudentFeesDetails'] = Student::
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
            ->when($student_name, function ($q) use ($student_name) {
                if ($student_name!=null) {
                   $q->where('student_name','LIKE', '%' . $student_name . '%');
                }
                return $q;
            })
            ->get();
        }else{
            $data['class_id'] = "";
            $data['section_id'] = "1";
            $data['student_name'] = "";
            if(auth()->user()->user_type != "Student"){
                $data['StudentFeesDetails'] = Student::get();
            }else{
                $data['StudentFeesDetails'] = Student::where('id',auth()->user()->user_id)->get();
            }
        }
        $data['ClassSection'] = ClassSection::get();
        return view('fees_management.fee_collection.add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return URL::to('/');
        DB::beginTransaction();
        try{
            $FeesCollection = new FeesCollection;
            $FeesCollection->date = $request->date;
            $FeesCollection->student_id = $request->student_id;
            $FeesCollection->class_id = $request->class_id;
            $FeesCollection->section_id = $request->section_id;
            $FeesCollection->fee_group_id = $request->fee_group_id;
            $FeesCollection->amount = $request->amount;
            $FeesCollection->balance = $request->balance;
            $FeesCollection->discount_group = $request->discount_group;
            $FeesCollection->discount_amount = $request->discount_amount;
            $FeesCollection->fine = $request->fine;
            $FeesCollection->payment_method = $request->payment_method;
            $FeesCollection->payment_given_type = $request->payment_given_type;
            $FeesCollection->payment_type = "direct";
            $FeesCollection->bank_name = $request->bank_name;
            $FeesCollection->cheque_number = $request->cheque_number;
            $FeesCollection->dd_number = $request->dd_number;
            $FeesCollection->note = $request->note;
            $FeesCollection->save();
            DB::commit();
            return redirect(URL::to('/').'/fee-collection/create?_token=YzMLf5JTGxEcwouOE2kGw6bKd7cFMz6BuKg1nmC7&class_id='.$request->class_id.'&section_id='.$request->section_id.'&student_name=')->with('success','Fees Collection Created Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Collection Cannot Be Added');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$StudentId,$class_id)
    {
        try{
            $data['Students'] = Student::find($StudentId);
            $data['class_id'] = $class_id;
            $data['StudentAssignFeesDetails'] = StudentAssignFeesDetails::where([['student_id',$StudentId]])
            ->JOIN('fees_groups','student_assign_fees_details.fee_group_id','fees_groups.id')
            ->JOIN('fees_masters','fees_groups.fee_type','fees_masters.id')
            ->select('fees_masters.*','fees_groups.*','fees_groups.id as feesgroup_id','student_assign_fees_details.*')
            ->get();
            return view('fees_management.fee_collection.student_fee_details',$data);
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect(URL::to('/').'/fee-collection/create')->with('warning','Fees Collection Cannot Be Show');
        }
    }

    public function AddFees(Request $request,$StudentId,$year,$FeesGroup){
        try{
            $data['Students'] = Student::find($StudentId);
            $data['class_id'] = $data['Students']->student_class;
            $data['FeesGroup'] = FeesGroup::find($FeesGroup);
            return view('fees_management.fee_collection.collect_fee',$data);
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect(URL::to('/').'/fee-collection/create')->with('warning','Fees Cannot Be Added');
        }
    }

    public function multipleprint(Request $request,$StudentId,$FeesGroup){
        try{
            $data['Students'] = Student::find($StudentId);
            $data['FeesCollections'] = FeesCollection::where([['student_id',$data['Students']->id],['class_id',$data['Students']->student_class],['section_id',$data['Students']->section_id],['fee_group_id',$FeesGroup]])->get();
            return view('fees_management.fee_collection.print',$data);
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            // return back()->with('warning','Fees Cannot Be Added');
            return redirect(URL::to('/').'/fee-collection/create')->with('warning','Fees Cannot Be Added');
        }
    }

    public function singleprint($FeesGroup){
        try{
            $FeesCollection = FeesCollection::find($FeesGroup);
            $data['Students'] = Student::where('id',$FeesCollection->student_id)->first()   ;
            $data['FeesCollections'] = FeesCollection::where([['id',$FeesGroup]])->get();
            return view('fees_management.fee_collection.print',$data);
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect(URL::to('/').'/fee-collection/create')->with('warning','Fees Cannot Be Added');
        }
    }


    public function edit($id)
    {
        $data['FeesCollection'] = FeesCollection::find($id);
        $data['Students'] = Student::find($data['FeesCollection']->student_id);
        $data['class_id'] = $data['Students']->student_class;
        $data['FeesGroup'] = FeesGroup::find($data['FeesCollection']->fee_group_id);
        return view('fees_management.fee_collection.collect_fee',$data);
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
        // return $request->all();
        DB::beginTransaction();
        try{
            $FeesCollection = FeesCollection::find($id);
            $FeesCollection->date = $request->date;
            $FeesCollection->amount = $request->amount;
            $FeesCollection->balance = $request->balance;
            $FeesCollection->discount_group = $request->discount_group;
            $FeesCollection->discount_amount = $request->discount_amount;
            $FeesCollection->fine = $request->fine;
            $FeesCollection->payment_method = $request->payment_method;
            $FeesCollection->payment_given_type = $request->payment_given_type;
            $FeesCollection->payment_type = "direct";
            $FeesCollection->bank_name = $request->bank_name;
            $FeesCollection->cheque_number = $request->cheque_number;
            $FeesCollection->dd_number = $request->dd_number;
            $FeesCollection->note = $request->note;
            $FeesCollection->save();
            DB::commit();
            return redirect(URL::to('/').'/fee-collection/create?_token=YzMLf5JTGxEcwouOE2kGw6bKd7cFMz6BuKg1nmC7&class_id='.$request->class_id.'&section_id='.$request->section_id.'&student_name=')->with('success','Fees Collection Updated Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Collection Cannot Be Updated');
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
            $data['FeesCollection'] = FeesCollection::find($id);
            $data['class_id'] = $data['FeesCollection']->class_id;
            $data['section_id'] = $data['FeesCollection']->section_id;
            $data['FeesCollection']->delete();
            DB::commit();
            return redirect(URL::to('/').'/fee-collection/create?_token=YzMLf5JTGxEcwouOE2kGw6bKd7cFMz6BuKg1nmC7&class_id='.$data['class_id'].'&section_id='.$data['section_id'].'&student_name=')->with('success','Fees Collection Deleted Successfully');
        }catch (Exception $e) {
            Log::debug($e->getMessage());
            DB::rollBack();
            return back()->with('warning','Fees Collection Cannot Be Updated');
        }
    }

    public function dateWiseFeeData(Request $request)
    {
        if(empty($request->all())){
            $data['date'] = date('Y-m-d');
            $data['FeesCollection'] = FeesCollection::where('date',date('d/m/Y'))->get();
        }else{
            $data['date'] = $request->date;
            $data['FeesCollection'] = FeesCollection::where('date',date('d/m/Y',strtotime($request->date)))->get();
        }
        return view('fees_management.fee_collection.date_wise_fee',$data);
    }
}
