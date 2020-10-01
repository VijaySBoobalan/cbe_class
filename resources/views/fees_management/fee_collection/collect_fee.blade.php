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
                        <h1 class="custom-font"><strong>Filter</h1>
                    </div>
                    <div class="tile-body">
                        @if(isset($FeesCollection))
                            {!! Form::model($FeesCollection,['url' => action('FeesManagement\FeesCollectionController@update',$FeesCollection->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @else
                            {!! Form::open(['url' => action('FeesManagement\FeesCollectionController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @endif
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Date') !!}
                                            {!! Form::text('date',date('d/m/Y'), ['class' => 'form-control date','placeholder'=>'Date','id'=>'date','readonly'=>'readonly']) !!}
                                            {!! Form::hidden('class_id',$class_id, ['class' => 'form-control','placeholder'=>'Date','id'=>'date','readonly'=>'readonly']) !!}
                                            {!! Form::hidden('section_id',$Students->section_id, ['class' => 'form-control','placeholder'=>'Date','id'=>'date','readonly'=>'readonly']) !!}
                                            {!! Form::hidden('student_id',$Students->id, ['class' => 'form-control','placeholder'=>'Date','id'=>'date','readonly'=>'readonly']) !!}
                                            {!! Form::hidden('fee_group_id',$FeesGroup->id, ['class' => 'form-control','placeholder'=>'Date','id'=>'date','readonly'=>'readonly']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Total Amount') !!}
                                            {!! Form::number('',!isset($FeesCollection) ? getFeesGroupAmount($Students->id,$class_id,$FeesGroup->id) : EditFeesGroupAmount($Students->id,$class_id,$FeesGroup->id), ['class' => 'form-control amount','placeholder'=>'Amount','id'=>'amount','disabled'=>'disabled']) !!}
                                            {!! Form::hidden(null,!isset($FeesCollection) ? getFeesGroupAmount($Students->id,$class_id,$FeesGroup->id) : EditFeesGroupAmount($Students->id,$class_id,$FeesGroup->id), ['class' => 'form-control ','placeholder'=>'Amount','id'=>'']) !!}
                                        </div>
                                    </div>

                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Discount Group ') !!}
                                            {!! Form::select('discount_group',[],null, ['class' => 'form-control chosen-select discount_group','placeholder'=>'Discount Group','id'=>'discount_group']) !!}
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Amount') !!}
                                            {!! Form::number('amount',!isset($FeesCollection) ? getFeesGroupAmount($Students->id,$class_id,$FeesGroup->id) : null, ['onkeyup'=>'getBalanceAmountTotal()','class' => 'form-control given_amount','placeholder'=>'Amount Pay','id'=>'given_amount']) !!}
                                            <span class="ErrorMessage" style="color:red;">This is too much amount of this fees</span>
                                            {!! Form::hidden(null,!isset($FeesCollection) ? getFeesGroupAmount($Students->id,$class_id,$FeesGroup->id) : EditFeesGroupAmount($Students->id,$class_id,$FeesGroup->id), ['class' => 'form-control balanceAmount','placeholder'=>'Amount','id'=>'balanceAmount']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Discount_amount') !!}
                                            {!! Form::number('discount_amount',null, ['onkeyup'=>'getBalanceAmountTotal()','class' => 'form-control discount_amount','placeholder'=>'Discount Amount','id'=>'discount_amount','min'=>'0']) !!}
                                        </div>
                                    </div>
                                </div>
                                    {{-- <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fine') !!}
                                            {!! Form::text('fine',null, ['class' => 'form-control fine','placeholder'=>'Fine','id'=>'fine']) !!}
                                        </div>
                                    </div> --}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Payment Mode') !!}
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" onclick="paymentType(this.value);" name="payment_method" value="cash" class="form-input-styled" {{ isset($FeesType) ? $FeesType->payment_method == "yes" ? "checked" : "" : "" }} data-fouc checked>Cash</label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" onclick="paymentType(this.value);" name="payment_method" value="cheque" class="form-input-styled" {{ isset($FeesType) ? $FeesType->payment_method == "no" ? "checked" : "" : "" }} data-fouc>Cheque</label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" onclick="paymentType(this.value);" name="payment_method" value="dd" class="form-input-styled" {{ isset($FeesType) ? $FeesType->payment_method == "no" ? "checked" : "" : "" }} data-fouc>DD</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Note') !!}
                                            {!! Form::textarea('note',null, ['class' => 'form-control note','placeholder'=>'Note','id'=>'note','rows'=>'2']) !!}
                                        </div>
                                    </div>

                                </div>

                                <div class="row ChequeDiv">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Bank Name') !!}
                                            {!! Form::text('bank_name',null, ['class' => 'form-control bank_name','placeholder'=>'Bank Name','id'=>'bank_name']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6 ChequeNumberDiv">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Cheque Number') !!}
                                            {!! Form::text('cheque_number',null, ['class' => 'form-control cheque_number','placeholder'=>'Cheque Number','id'=>'cheque_number']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6 DDNumberDiv">
                                        <div class="form-group">
                                            {!! Form::label('name', 'DD Number') !!}
                                            {!! Form::text('dd_number',null, ['class' => 'form-control dd_number','placeholder'=>'DD Number','id'=>'dd_number']) !!}
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary ml-3 SaveButton">Save <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>
        paymentType('cash');
        function paymentType(value) {
            if(value == 'cash'){
                $('.ChequeDiv').hide();
                $('.bank_name').val("");
                $('.cheque_number').val("");
                $('.dd_number').val("");
            }
            if(value == 'cheque'){
                $('.ChequeDiv').show();
                $('.ChequeNumberDiv').show();
                $('.DDNumberDiv').hide();
                $('.dd_number').val("");
            }
            if(value == 'dd'){
                $('.ChequeDiv').show();
                $('.ChequeNumberDiv').hide();
                $('.DDNumberDiv').show();
                $('.cheque_number').val("");
            }
        }

        var Total = 0;
        $('.ErrorMessage').hide();
        function getBalanceAmountTotal() {
            var amount = $('.amount').val();
            var given_amount = $('.given_amount').val();
            var discount_amount = $('.discount_amount').val();
            if(given_amount == ''){ given_amount = 0;  }
            if(discount_amount == ''){ discount_amount = 0;  }
            console.log(given_amount,discount_amount)
            TotalGivenValue = parseFloat(given_amount) + parseFloat(discount_amount);
            Total = parseFloat(amount) - TotalGivenValue;
            console.log(Total)
            if(given_amount!=0){
                if(Total >=0 && TotalGivenValue <=amount){
                    $('.ErrorMessage').hide();
                    $('.SaveButton').show();
                }else{
                    $('.ErrorMessage').show();
                    $('.SaveButton').hide();
                }
            }else{
                $('.ErrorMessage').show();
                $('.SaveButton').hide();
            }
            // if(given_amount==0){
            //     $('.discount_amount').prop('reqired',true);
            // }
        }

    </script>
@endsection

