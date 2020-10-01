@extends('layouts.master')

@section('add_fee_type_group')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('fee_type_group_open_menu')
open
@endsection

@section('fee_type_group_open_menu_display')
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
                        <h1 class="custom-font"><strong>Add Fee Type</h1>
                    </div>
                    <div class="tile-body">

                        @if(isset($FeesGroup))
                            {!! Form::model($FeesGroup,['url' => action('FeesManagement\FeesGroupController@update',$FeesGroup->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @else
                            {!! Form::open(['url' => action('FeesManagement\FeesGroupController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @endif
                        @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Types') !!}
                                            {!! Form::select('fee_type',$FeesMaster->pluck('fee_type','id'),null, ['onchange'=>'FeeGroupDetails(this.value);','class' => 'form-control chosen-select','placeholder'=>'Fee Types','id'=>'fee_type']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="FeeGroupDetailsAppendDiv">
                                    @if (isset($FeesTypes))
                                        <div class="card">
                                            <div class="card-header header-elements-inline">
                                                <h5 class="card-title">Fee Details</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="card card-table table-responsive shadow-0 mb-0">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Fee Names</th>
                                                                <th>Checked</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($FeesTypes as $key=>$FeesType)
                                                                <tr>
                                                                    <td>{{ ++$key }}</td>
                                                                    <td>
                                                                        {{ $FeesType->fee_name }}
                                                                    </td>
                                                                    <td colspan="2">
                                                                        <div class="form-group">
                                                                            <div class="custom-control custom-checkbox">
                                                                                <input type="checkbox" class="custom-control-input feeGroup" id="custom_checkbox_stacked_unchecked{{ $key }}" value="{{ $FeesType->id }}" {{ (!empty(getFeeGroupedDetails($FeesGroup->id,$FeesType->id))) ? $FeesType->id == getFeeGroupedDetails($FeesGroup->id,$FeesType->id)->fee_name_id ? "checked" : "" : "" }} data-on-value="{{ $FeesType->amount }}" onclick="gettotalAmount(this);" name="fee_group[fee_name_id][]">
                                                                                <label class="custom-control-label" for="custom_checkbox_stacked_unchecked{{ $key }}"></label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            <tr>
                                                                <th class="text-right" colspan="2">Total :</th>
                                                                <th><span class="TotalValue"></span></th>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                                @if (in_array('yes',$FeesTypes->pluck('scholarship')->toArray()))
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label>ScholarShip?<span class="text-danger">*</span></label>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                    <input type="radio" name="scholarship_for" value="acadamics" class="form-input-styled" {{ isset($FeesGroup) ? $FeesGroup->scholarship_for == "acadamics" ? "checked" : "" : "" }} data-fouc required>Acadamics</label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                    <input type="radio" name="scholarship_for" value="sports" class="form-input-styled" {{ isset($FeesGroup) ? $FeesGroup->scholarship_for == "sports" ? "checked" : "" : "" }} data-fouc required>Sports</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            {!! Form::label('name', 'Due Date') !!}
                                                            {!! Form::text('due_date',null, ['class' => 'form-control pickadate due_date','placeholder'=>'Due Date','id'=>'due_date']) !!}
                                                        </div>
                                                    </div>

                                                    {{-- <div class="col-lg-6">
                                                        <div class="form-group">
                                                            {!! Form::label('name', 'Fine per day') !!}
                                                            {!! Form::text('fine_per_day',null, ['class' => 'form-control fine_per_day','placeholder'=>'Fine per day','id'=>'fine_per_day']) !!}
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
    <script>
        var TotalValue = 0;
        function FeeGroupDetails(value) {
            $.ajax({
                url: "{{ route('FeeGroupDetails') }}",
                type: 'get',
                data: {
                    fee_type: value,
                },
                success: function(data) {
                    console.log(data);
                    $('.FeeGroupDetailsAppendDiv').html(data);
                }
            });
        // return new Promise(resolve => {
        //     axios.get("/FeeGroupDetails",{params: { "fee_type": value } }).then(response => {
        //         console.log(response);
        //         $('.FeeGroupDetailsAppendDiv').html(response.data);
        //         resolve(1)
        //     }).catch(error => {
        //         console.log(error);
        //     })
        // })
    }

    $("input[name='fee_group[fee_name_id][]']:checked").each(function ()
    {
        TotalValue = parseFloat(TotalValue) + parseFloat($(this).attr("data-on-value"));
    });
    $('.TotalValue').html(TotalValue);

    function gettotalAmount(elem){
        if(elem.checked == true){
            TotalValue = parseFloat(TotalValue) + parseFloat($(elem).attr("data-on-value"));
        }else{
            TotalValue = parseFloat(TotalValue) - parseFloat($(elem).attr("data-on-value"));
        }
        $('.TotalValue').html(TotalValue);
    }
    </script>
@endsection
