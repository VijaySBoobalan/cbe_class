<?php

namespace App\Http\Controllers;

use App\FeesCollection;
use App\OnlineFeePayDetail;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PayuMoneyController extends Controller
{
    public function SubscribProcess(Request $request){
        $data['datas'] = $request->all();
        $data['student_id'] = $request->student_id;
        $data['fee_group_id'] = $request->fee_group_id;
        $data['Student'] = Student::find($request->student_id);
        return view('payment.payumoney',$data);
    }

    public function Feeamount(Request $request){
        $data['student_id'] = $request->student_id;
        $data['fee_group_id'] = $request->fee_group_id;
        $data['Student'] = Student::find($request->student_id);
        return view('payment.payfee',$data);
    }

    public function SubscribeResponse(Request $request){
        // dd(request()->all());
        $student_id = unserialize(request('productinfo'))['student_id'];
        $fee_group_id = unserialize(request('productinfo'))['fee_group_id'];
        $studentDetail = Student::find($student_id);
        // dd(request()->all());
        $FeesCollection = new FeesCollection();
        $FeesCollection->date = date('d/m/Y');
        $FeesCollection->student_id = $student_id;
        $FeesCollection->class_id = $studentDetail->student_class;
        $FeesCollection->section_id = $studentDetail->section_id;
        $FeesCollection->fee_group_id = $fee_group_id;
        $FeesCollection->amount = $request->net_amount_debit;
        // $FeesCollection->balance = $request->balance;
        $FeesCollection->discount_amount = $request->discount;
        $FeesCollection->payment_method = "";
        // $FeesCollection->payment_given_type = $request->payment_given_type;
        $FeesCollection->payment_type = 'online';
        // $FeesCollection->bank_name = $request->bank_name;
        // $FeesCollection->cheque_number = $request->cheque_number;
        // $FeesCollection->dd_number = $request->dd_number;
        // $FeesCollection->note = $request->note;
        $FeesCollection->save();
        $OnlineFeePayDetail = new OnlineFeePayDetail();
        $OnlineFeePayDetail->fees_collection_id = $FeesCollection->id;
        $OnlineFeePayDetail->student_id = $student_id;
        $OnlineFeePayDetail->class_id = $studentDetail->student_class;
        $OnlineFeePayDetail->section_id = $studentDetail->section_id;
        $OnlineFeePayDetail->fee_group_id = $fee_group_id;
        $OnlineFeePayDetail->mihpayid = $request->mihpayid;
        $OnlineFeePayDetail->txnid = $request->txnid;
        $OnlineFeePayDetail->hash = $request->hash;
        $OnlineFeePayDetail->encryptedPaymentId = $request->encryptedPaymentId;
        $OnlineFeePayDetail->payment_data = serialize($request->all());
        $OnlineFeePayDetail->status = $request->status;
        $OnlineFeePayDetail->save();
        // dd(request()->all());
        // dd('Payment Successfully done!');
        return redirect(URL::to('/').'/fee-collection/create')->with('success','Fees Added Successfully');
    }

    public function SubscribeCancel(){
        dd('Payment Cancel!');
    }

}
