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
    @if(auth()->user()->user_type != "Student")
        <div class="page page-forms-validate">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Filter</h1>
                        </div>
                        <div class="tile-body">
                            {!! Form::open(['url' => route('dateWiseFeeData',),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Date') !!}
                                                {!! Form::date('date',$date,['class' => 'form-control','placeholder'=>'Select Date','id'=>'date']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end align-items-center text-center">
                                        <button type="submit" id="add_btn" class="btn btn-primary ml-3">filter <i class="icon-paperplane ml-2"></i></button>
                                    </div>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    @endif

    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Student Details</h1>
                    </div>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table datatable-basic" id="mileage_Detail_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Student name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Amount</th>
                                        <th>Paid</th>
                                        <th>Discount</th>
                                        <th>Balance</th>
                                        {{-- @if(auth()->user()->hasAnyPermission(['fee_view','fee_collect']))
                                            <th class="text-center">Actions</th>
                                        @endif --}}
                                    </tr>
                                </thead>
                                <?php
                                    $count = 0;
                                    $TotalAmount = 0;
                                    $PaidAmount = 0;
                                    $TotalDiscount = 0;
                                    $balanceAmount = 0;
                                ?>
                                @if (isset($FeesCollection))
                                    <tbody>
                                        @foreach ($FeesCollection as $key=>$FeesCollect)
                                        <?php $class_id = $FeesCollect->class_id;  ?>
                                            <?php $feePayment = getStudentFeeAmountYearWise($FeesCollect->student_id,$class_id); ?>
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $FeesCollect->Student->student_name }}</td>
                                                <td>{{ $FeesCollect->class_id }}</td>
                                                <td>{{ $FeesCollect->ClassSection->section }}</td>
                                                <td>{{ $feePayment['FeeGroupTypeDetails'] }}</td>
                                                <td>{{ $feePayment['FeesCollectionAmount'] }}</td>
                                                <td>{{ $feePayment['FeesCollectionDiscount'] }}</td>
                                                <td>{{ $feePayment['FeeGroupTypeDetails'] - $feePayment['FeesCollectionDiscount'] - $feePayment['FeesCollectionAmount'] }}</td>
                                                {{-- <td class="text-center">
                                                    @if ($feePayment > 0)
                                                    {!! Form::open(['url' => action('FeesManagement\FeesCollectionController@show',[$FeesCollect->id,$class_id]),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                        <button type="submit" class='btn btn-primary btn-sm'>View Fee Details</button>
                                                    {!! Form::close() !!}
                                                    @else
                                                        <span style="color:red">No Fees Found</span>
                                                    @endif
                                                </td> --}}
                                            </tr>
                                            <?php
                                            $TotalAmount += $feePayment['FeeGroupTypeDetails'];
                                            $PaidAmount += $feePayment['FeesCollectionAmount'];
                                            $TotalDiscount += $feePayment['FeesCollectionDiscount'];
                                            ?>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>{{ $TotalAmount }}</td>
                                            <td>{{ $PaidAmount }}</td>
                                            <td>{{ $TotalDiscount }}</td>
                                            <td>{{ $TotalAmount - $TotalDiscount - $PaidAmount }}</td>
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>
        var Total = 0;
        $('.ErrorMessage').hide();
        function getBalanceAmountTotal() {
            var amount = $('.amount').val();
            var balanceAmount = $('.balanceAmount').val();
            Total = parseFloat(balanceAmount) - parseFloat(amount);
            if(amount!=0){
                if(Total >= 0){
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
        }

        var SelectSection = "";
        getSection();
        if($('#filter_section_id').val()!=""){
            SelectSection = $('#filter_section_id').val();
        }
        // $(document).ready(function() {
            function getSection() {
                var student_class = $('.class_id').val();
                var selectHTML = "";
                if (student_class != '') {
                    $.ajax({
                        type: "get",
                        url: '{{ route("getSection") }}',
                        data: { student_class: student_class },
                        success: function(data) {
                            for (var key in data) {
                                var row = data[key];
                                selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                            }
                            $('.section_id').html(selectHTML);
                            $('.section_id').val(SelectSection).trigger("chosen:updated");
                        }
                    });
                }
            }
        // });
    </script>
@endsection

