@extends('layouts.master')

@section('add_scholarship')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('scholarship_open_menu')
open
@endsection

@section('scholarship_display')
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
                        <h1 class="custom-font"><strong>Scholar Acadamic Details</h1>
                    </div>
                    <div class="tile-body">
                        @if(isset($ScholarshipAcadamic))
                            {!! Form::model($ScholarshipAcadamic,['url' => action('FeesManagement\ScholarshipAcadamicController@update',$ScholarshipAcadamic->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @else
                            {!! Form::open(['url' => action('FeesManagement\ScholarshipAcadamicController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @endif
                        <?php $acadamic = isset($ScholarshipAcadamic) ? $ScholarshipAcadamic->fee_type == "acadamic" ? "inline" : "none" : "none" ?>
                        <?php $sports = isset($ScholarshipAcadamic) ? $ScholarshipAcadamic->fee_type == "sports" ? "inline" : "none" : "none" ?>
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Type') !!}
                                            {!! Form::select('fee_type',['acadamic'=>'Acadamic','sports'=>'Sports'],null, ['onchange'=>'GetScholarshipDetails(this.value);','class' => 'form-control chosen-select','placeholder'=>'Fee Type','id'=>'fee_type']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="AcadamicDiv" style="display:{{ $acadamic }};">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'ScholarShip Name') !!}
                                                {!! Form::text('acadamic_scholarship_name', null, ['class' => 'form-control','placeholder'=>'ScholarShip Name','id'=>'acadamic_scholarship_name']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Percentage From') !!}
                                                {!! Form::text('percentage_from', null, ['class' => 'form-control','placeholder'=>'Percentage From','id'=>'percentage_from']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Percentage To') !!}
                                                {!! Form::text('percentage_to', null, ['class' => 'form-control','placeholder'=>'Percentage To','id'=>'percentage_to']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Fees Cocertion') !!}
                                                {!! Form::text('acadamic_fees_concertion', null, ['class' => 'form-control','placeholder'=>'Fees Cocertion','id'=>'acadamic_fees_concertion']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', '% Should Maintain') !!}
                                                {!! Form::text('maintain_percentage', null, ['class' => 'form-control','placeholder'=>'% Should Maintain','id'=>'maintain_percentage']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ZonalDiv" style="display:{{ $sports }};">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'ScholarShip Name') !!}
                                                {!! Form::text('zonal_scholarship_name', null, ['class' => 'form-control','placeholder'=>'ScholarShip Name','id'=>'zonal_scholarship_name']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Particulars') !!}
                                                {!! Form::text('zonal_particulars', null, ['class' => 'form-control','placeholder'=>'Particulars','id'=>'zonal_particulars']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Fees Cocertion') !!}
                                                {!! Form::text('zonal_fees_concertion', null, ['class' => 'form-control','placeholder'=>'Fees Cocertion','id'=>'zonal_fees_concertion']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" id="add_btn" class="btn btn-primary ml-3">Save <i class="icon-paperplane ml-2"></i></button>
                            </div>
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
        function GetScholarshipDetails(value) {
            if(value == 'acadamic'){
                $('.AcadamicDiv').show();
                $('.ZonalDiv').hide();
                $('#zonal_scholarship_name').val("");
                $('#zonal_particulars').val("");
                $('#zonal_fees_concertion').val("");
            }else{
                $('.ZonalDiv').show();
                $('.AcadamicDiv').hide();
                $('#acadamic_scholarship_name').val("");
                $('#percentage_from').val("");
                $('#percentage_to').val("");
                $('#acadamic_fees_concertion').val("");
                $('#maintain_percentage').val("");
            }
        }
    </script>
@endsection
