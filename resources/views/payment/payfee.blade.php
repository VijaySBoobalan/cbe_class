@extends('layouts.master')

@section('add_fee_collection')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('fee_collection_open_menu')
open
@endsection

@section('fee_collection_display')
block
@endsection

@section('content')

<section id="content">
    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Student Fee</h1>
                    </div>
                    <div class="tile-body">
                        <form action="{{ route('SubscribProcess') }}" method="get"><br />
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="">Amount</label>
                                    <input type="text" class="form-control" name="amount" value="" /><br />
                                </div>
                            </div>
                            {{-- <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" /><br />
                            <input type="hidden" name="hash" value="<?php echo $hash ?>"/><br />
                            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" /><br /> --}}
                            <input type="hidden" name="student_id" id="student_id" value="{{ $student_id }}" /><br />
                            <input type="hidden" name="firstname" id="firstname" value="{{ $Student->student_name }}" /><br />
                            <input type="hidden" name="email" id="email" value="{{ $Student->email }}" /><br />
                            <input type="hidden" name="phone" id="phone" value="{{ $Student->mobile_number }}" /><br />
                            <input type="hidden" name="productinfo" value="{{ serialize(array('student_id'=>$student_id,'fee_group_id'=>$fee_group_id)) }}"><br />
                            <input type="hidden" name="surl" value="{{ URL::to('/api')."/subscribe-response" }}" /><br />
                            <input type="hidden" name="furl" value="{{ URL::to('/api')."/subscribe-cancel" }}" /><br />
                            <input type="hidden" name="service_provider" value="payu_paisa"  /><br />
                            <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                <button type="submit" class="btn btn-lightred" id="form2Submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

