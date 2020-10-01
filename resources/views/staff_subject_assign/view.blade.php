@extends('layouts.master')

@section('staff_subject_assign')
active
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Filter</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="StaffSubjectForm" method="post" class="form-validate-jquery StaffSubjectForm" data-parsley-validate name="form2" role="form">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Staff') !!}
                                            {!! Form::select('staff_id', $Staffs->pluck('staff_name','id') , null, ['class' => 'form-control chosen-select staff_id','placeholder' => 'Select Staff','id'=>'staff_id', 'selected']) !!}
                                        </div>
                                    </div>
                                     <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class_id',!empty($ClassSection) ? $ClassSection->pluck('class','class') : [] , null, ['onchange'=>'getSection(this.value);','class' => 'form-control chosen-select class_id','placeholder'=>'Select Class','id'=>'class_id']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','data-placeholder'=>'Select Section','id'=>'section_id']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top text-center">
                                    <button type="submit" class="btn btn-lightred" id="FilterStaffSubjectDetails">Submit</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /tile header -->
                    </section>
                </div>
            </div>
        </div>

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Staff Subject Assign</h1>
                            @can('staff_schedule_assign_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="add-entry" data-toggle="modal" data-target="#AssignStaffSubjectModal" class="StaffSubjectDetail"><i class="fa fa-plus mr-5"></i>Assign Staff Subject</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6"><div id="tableTools"></div></div>
                                <div class="col-md-6"><div id="colVis"></div></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom table-responsive" id="AssignStaffSubjectTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Staff Name</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Subject Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('script')
    @include('staff_subject_assign.js')
@endsection

@section('Modal')
    @include('staff_subject_assign.add')
    @include('staff_subject_assign.edit')
@endsection

