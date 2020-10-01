@extends('layouts.master')

@section('view_scholarship')
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
                        <h1 class="custom-font"><strong>Filter</h1>
                    </div>
                    <div class="tile-body">
                        {!! Form::open(['url' => action('FeesManagement\ScholarshipAcadamicController@index'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Type') !!}
                                            {!! Form::select('fee_type',['acadamic'=>'Acadamic','sports'=>'Sports'],$fee_type, ['class' => 'form-control chosen-select','placeholder'=>'Fee Type','id'=>'fee_type']) !!}
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" id="add_btn" class="btn btn-primary ml-3">Filter <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Filter</h1>
                    </div>
                    <div class="tile-body">
                        <table class="table datatable-basic" id="mess_menu_table">
                            @if ($fee_type == "acadamic")
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Scholarship Name</th>
                                        <th>Percentage From</th>
                                        <th>Percentage To</th>
                                        <th>Fee Concertion</th>
                                        <th>% Maintain</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($ScholarshipAcadamics)
                                        @foreach ($ScholarshipAcadamics as $key=>$ScholarshipAcadamic)
                                            <tr>
                                                <th>{{ ++$key }}</th>
                                                <th>{{ $ScholarshipAcadamic->fee_type }}</th>
                                                <th>{{ $ScholarshipAcadamic->acadamic_scholarship_name }}</th>
                                                <th>{{ $ScholarshipAcadamic->percentage_from }}</th>
                                                <th>{{ $ScholarshipAcadamic->percentage_to }}</th>
                                                <th>{{ $ScholarshipAcadamic->acadamic_fees_concertion }}</th>
                                                <th>{{ $ScholarshipAcadamic->maintain_percentage }}</th>
                                                <th>
                                                    {!! Form::model($ScholarshipAcadamic,['url' => action('FeesManagement\ScholarshipAcadamicController@destroy',$ScholarshipAcadamic->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                        <a href="{{ action('FeesManagement\ScholarshipAcadamicController@edit',$ScholarshipAcadamic->id) }}" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class='list-icons-item text-danger-600 btn btn-sm'><i class='icon-trash'></i></button>
                                                    {!! Form::close() !!}
                                                </th>
                                            </tr>
                                        @endforeach
                                    @else
                                        <blockquote><p>No Data for Acadamic</p></blockquote>
                                    @endif
                                </tbody>
                            @endif
                            @if ($fee_type == "sports")
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Scholarship Name</th>
                                        <th>Particulars</th>
                                        <th>Fee Concertion</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($ScholarshipAcadamics)
                                        @foreach ($ScholarshipAcadamics as $key=>$ScholarshipAcadamic)
                                            <tr>
                                                <th>{{ ++$key }}</th>
                                                <th>{{ $ScholarshipAcadamic->fee_type }}</th>
                                                <th>{{ $ScholarshipAcadamic->zonal_scholarship_name }}</th>
                                                <th>{{ $ScholarshipAcadamic->zonal_particulars }}</th>
                                                <th>{{ $ScholarshipAcadamic->zonal_fees_concertion }}</th>
                                                <th>
                                                    {!! Form::model($ScholarshipAcadamic,['url' => action('FeesManagement\ScholarshipAcadamicController@destroy',$ScholarshipAcadamic->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                        <a href="{{ action('FeesManagement\ScholarshipAcadamicController@edit',$ScholarshipAcadamic->id) }}" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class='list-icons-item text-danger-600 btn btn-sm'><i class='icon-trash'></i></button>
                                                    {!! Form::close() !!}
                                                </th>
                                            </tr>
                                        @endforeach
                                    @else
                                        <blockquote><p>No Data for Sports</p></blockquote>
                                    @endif
                                </tbody>
                            @endif
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection
