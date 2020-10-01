@extends('layouts.master')

@section('add_fee_type_details')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('fee_type_details_open_menu')
open
@endsection

@section('fee_type_details_open_menu_disply')
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
                        <h1 class="custom-font"><strong>Fee Master</h1>
                    </div>
                    <div class="tile-body">
                        @if(isset($FeesType))
                            {!! Form::model($FeesType,['url' => action('FeesManagement\FeesTypeController@update',$FeesType->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @else
                            {!! Form::open(['url' => action('FeesManagement\FeesTypeController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @endif
                        @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Master') !!}
                                            {!! Form::select('fee_type',$FeesMaster->pluck('fee_type','id'),null, ['class' => 'form-control chosen-select','placeholder'=>'Fee Master','id'=>'fee_type']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Name of the Fee') !!}
                                            {!! Form::text('fee_name',null, ['class' => 'form-control','placeholder'=>'Name of the Fee','id'=>'fee_name']) !!}
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Code') !!}
                                            {!! Form::text('fee_code',null, ['class' => 'form-control','placeholder'=>'Fee Code','id'=>'fee_code']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'ScholarShip?') !!}
                                            <label class="checkbox checkbox-custom-alt">
                                                {!! Form::radio('scholarship', 'yes',true) !!}<i></i> Yes
                                            </label>
                                            <label class="checkbox checkbox-custom-alt">
                                                {!! Form::radio('scholarship', 'no',true) !!}<i></i> No
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Amount') !!}
                                            {!! Form::text('amount',null, ['class' => 'form-control amount','placeholder'=>'Amount','id'=>'amount']) !!}
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

{{-- @include('fees_management.fee_type.js') --}}

@endsection
