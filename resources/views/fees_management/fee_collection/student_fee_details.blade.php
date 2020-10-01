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
                        <h1 class="custom-font"><strong>Student Fee List</h1>
                    </div>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table datatable-basic">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Fee Name</th>
                                        <th>Payment id</th>
                                        <th>Date</th>
                                        <th>Discount Amount</th>
                                        <th>Fine</th>
                                        <th>Paid Amount</th>
                                        <th>Balance Amount</th>
                                        <th>Status</th>
                                        @can(['fee_collect'])
                                            <th>Digital Payment</th>
                                        @endcan
                                        @if(auth()->user()->hasAnypermission(['fee_collect','student_pay_fee']))
                                            <th class="text-center" style="width: 150px;">Actions</th>
                                        @endif
                                    </tr>
                                </thead>

                                <?php $TotalBalance = 0; $TotalDiscount = 0; $TotalFine = 0; $TotalPaidAmount = 0;?>
                                @if (isset($StudentAssignFeesDetails))
                                    <tbody>
                                        @foreach ($StudentAssignFeesDetails as $key=>$FeesGroup)
                                        <?php
                                            $FeePaidDetails = getFeesGroupPaidDetails($Students->id,$class_id,$FeesGroup->feesgroup_id);
                                            $BalanceAmount = getFeesGroupAmount($Students->id,$class_id,$FeesGroup->feesgroup_id);
                                        ?>
                                        <?php $total = 0;?>
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $FeesGroup->getFeesMasterName->fee_type }}</td>
                                                <td>
                                                    @foreach ($FeesGroup->getGroupDetails as $item)
                                                        {{ $item->getFeesTypeDetails->fee_name }} - {{ $item->getFeesTypeDetails->fee_code }} - {{ $item->getFeesTypeDetails->amount }} <br>
                                                        <?php $total = $total + $item->getFeesTypeDetails->amount; ?>
                                                    @endforeach
                                                    <?php echo "Total :$total" ; ?>
                                                </td>
                                                <td>-</td>
                                                <?php $TotalBalance = $TotalBalance + $BalanceAmount; ?>
                                                <th>-</th>
                                                <th>0.00</th>
                                                <th>0.00</th>
                                                <th>0.00</th>
                                                <td>{{ $BalanceAmount }}</td>
                                                @if (!$FeePaidDetails->isEmpty())
                                                    @if ($BalanceAmount == 0)
                                                        <th><span style="width: 100px; height:20px; font-size:14px;" class="badge bg-success badge-pill ml-auto">{{ "Paid" }}</span></th>
                                                        <th></th>
                                                        {{-- @if (auth()->user()->user_type == "Student")
                                                            @can(['fee_collect'])
                                                                <td>
                                                                    {!! Form::open(['url' => route('Feeamount'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                        <input type="hidden" name="student_id" value="{{ $Students->id }}" id="">
                                                                        <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->feesgroup_id }}" id="">
                                                                        <button type="submit" class="btn btn-xs btn-primary text-center"> Pay Collect</button>
                                                                    {!! Form::close() !!}
                                                                </td>
                                                            @endcan
                                                        @else
                                                            @can(['fee_collect'])
                                                                <td class="text-center">
                                                                    @can(['fee_collect'])
                                                                        {!! Form::open(['url' => route('Feeamount'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                            <input type="hidden" name="student_id" value="{{ $Students->id }}" id="">
                                                                            <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->feesgroup_id }}" id="">
                                                                            <button type="submit" class="btn btn-xs btn-primary text-center"> Pay Collect</button>
                                                                        {!! Form::close() !!}
                                                                    @endcan
                                                                </td>
                                                            @endcan
                                                        @endif --}}

                                                        <td><a href="{{ route('multipleprint',[$Students->id,$FeesGroup->feesgroup_id]) }}" class="btn btn-xs btn-primary text-center">print</a></td>
                                                    @else
                                                        <th><span style="width: 100px; height:20px; font-size:14px;" class="badge bg-info badge-pill ml-auto">{{ "partially Paid" }}</span></th>
                                                        @if (auth()->user()->user_type == "Student")
                                                            @can(['student_pay_fee'])
                                                                <td class="text-center">
                                                                    {!! Form::open(['url' => route('Feeamount'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                        <input type="hidden" name="student_id" value="{{ $Students->id }}" id="">
                                                                        <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->feesgroup_id }}" id="">
                                                                        <button type="submit" class="btn btn-xs btn-primary text-center"> Pay Fees</button>
                                                                    {!! Form::close() !!}
                                                                </td>
                                                            @endcan
                                                        @else
                                                            @can(['fee_collect'])
                                                                <td class="text-center">
                                                                    {!! Form::open(['url' => route('Feeamount'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                        <input type="hidden" name="student_id" value="{{ $Students->id }}" id="">
                                                                        <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->feesgroup_id }}" id="">
                                                                        <button type="submit" class="btn btn-xs btn-primary text-center"> Pay Fees</button>
                                                                    {!! Form::close() !!}
                                                                </td>
                                                                <td class="text-center">
                                                                    {!! Form::open(['url' => action('FeesManagement\FeesCollectionController@AddFees',[$Students->id,$class_id,$FeesGroup->feesgroup_id]),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                        <button type="submit" class="btn btn-xs btn-primary text-center"> Collect Fees</button>
                                                                        <a href="{{ route('multipleprint',[$Students->id,$FeesGroup->feesgroup_id]) }}" class="btn btn-xs btn-primary text-center">print</a>
                                                                    {!! Form::close() !!}
                                                                </td>
                                                            @endcan
                                                        @endif
                                                    @endif
                                                @else
                                                    <th><span style="width: 100px; height:20px; font-size:14px;" class="badge bg-danger badge-pill ml-auto">{{ "UnPaid" }}</span></th>
                                                    @if (auth()->user()->user_type == "Student")
                                                        @can(['student_pay_fee'])
                                                            <td class="text-center">
                                                                {!! Form::open(['url' => route('Feeamount'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                    <input type="hidden" name="student_id" value="{{ $Students->id }}" id="">
                                                                    <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->feesgroup_id }}" id="">
                                                                    <button type="submit" class="btn btn-xs btn-primary text-center"> Pay Fees</button>
                                                                {!! Form::close() !!}
                                                            </td>
                                                        @endcan
                                                    @else
                                                        <td class="text-center">
                                                            @can(['fee_collect'])
                                                                {!! Form::open(['url' => route('Feeamount'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                    <input type="hidden" name="student_id" value="{{ $Students->id }}" id="">
                                                                    <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->feesgroup_id }}" id="">
                                                                    <button type="submit" class="btn btn-xs btn-primary text-center"> Pay Collect</button>
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </td>
                                                    @endif
                                                    @can(['fee_collect'])
                                                        <td class="text-center">
                                                            {!! Form::open(['url' => action('FeesManagement\FeesCollectionController@AddFees',[$Students->id,$class_id,$FeesGroup->feesgroup_id]),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                <button type="submit" class="btn btn-xs btn-primary text-center"> Collect Fees</button>
                                                            {!! Form::close() !!}
                                                        </td>
                                                    @endcan
                                                @endif
                                            </tr>
                                            @if (!empty($FeePaidDetails))
                                            <?php $count = 0;?>
                                            @foreach ($FeePaidDetails as $key1=>$FeePaidDetail)
                                                    <tr>
                                                        <td colspan="3"></td>
                                                        <td style="display: none"></td>
                                                        <td style="display: none"></td>
                                                        <td style="display: none"></td>
                                                        <td>{{ ++$key1 }}</td>
                                                        <td style="display: none"></td>
                                                        <td style="display: none"></td>
                                                        <td style="display: none"></td>
                                                        <td><span><i class="icon-forward">&nbsp;&nbsp;&nbsp;{{ $FeePaidDetail->date }}</i></span></td>
                                                        <td>{{ isset($FeePaidDetail->discount_amount) ? $FeePaidDetail->discount_amount : "0.00" }}</td>
                                                        <td>{{ ($FeePaidDetail->fine > 0) ? $FeePaidDetail->fine : "0.00" }}</td>
                                                        <td>{{ isset($FeePaidDetail->amount) ? $FeePaidDetail->amount : "0.00" }}</td>
                                                        <td></td>
                                                        <td></td>
                                                        @can(['fee_collect'])
                                                            <td></td>
                                                        @endcan
                                                        <td colspan="3">
                                                            @can(['fee_collect'])
                                                                {!! Form::open(['url' => action('FeesManagement\FeesCollectionController@destroy',$FeePaidDetail->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                                    <input type="hidden" name="year" id="" value="{{ $class_id }}">
                                                                    <a href="{{ route('singleprint',$FeePaidDetail->id) }}" class="btn btn-xs btn-primary text-center">Print</a>
                                                                    <a href="{{ action('FeesManagement\FeesCollectionController@edit',$FeePaidDetail->id) }}" class="btn btn-xs btn-primary text-center"> Edit</a>
                                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class="btn btn-xs btn-primary text-center"> Delete</button>
                                                                {!! Form::close() !!}
                                                            @endcan
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        $TotalDiscount = $TotalDiscount + $FeePaidDetail->discount_amount;
                                                        $TotalFine = $TotalFine + $FeePaidDetail->fine;
                                                        $TotalPaidAmount = $TotalPaidAmount + $FeePaidDetail->amount;
                                                    ?>
                                                @endforeach
                                            @endif
                                        @endforeach
                                        <tr>
                                            <th colspan="5">Grand Total :</th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                            <th>{{ $TotalDiscount }}</th>
                                            <th>{{ $TotalFine }}</th>
                                            <th>{{ $TotalPaidAmount }}</th>
                                            <th  colspan="4">{{ $TotalBalance }}</th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                            <th style="display: none;"></th>
                                        </tr>
                                    </tbody>
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
        $( document ).ready(function() {
            // var table = $('.datatable-basic').DataTable({
            // });
        });
    </script>
@endsection
