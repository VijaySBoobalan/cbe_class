@extends('layouts.master')

@section('add_assign_fee')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('assign_fee_open_menu')
open
@endsection

@section('assign_fee_open_menu_display')
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
                        @if(isset($StudentAssignFees))
                            {!! Form::model($StudentAssignFees,['url' => action('FeesManagement\StudentAssignFeesController@update',$StudentAssignFees->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @else
                            {!! Form::open(['url' => action('FeesManagement\StudentAssignFeesController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @endif
                        @csrf
                            <fieldset>
                                <div class="row">
                                    <input type="hidden" name="fee_group_id" id="fee_group_id" value="{{ $FeesGroups->id }}">
                                    <input type="hidden" name="filter_section_id" id="filter_section_id" value="{{ isset($StudentAssignFees) ? $StudentAssignFees->section_id : "" }}">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class_id',$ClassSection->pluck('class','class'),null, ['onchange'=>'getSection()','class' => 'form-control chosen-select class_id','placeholder'=>'Class','id'=>'class_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="button" class="btn btn-primary SearchDept" onclick="SearchDepartment();">Filter<i class="icon-paperplane ml-2"></i></button>
                                </div>

                                <div class="AppendStudentDetails">
                                    @if (isset($StudentAssignFees))
                                        <hr>
                                        <div class="card">
                                            <div class="card-header header-elements-inline">
                                                <h5 class="card-title">Student Details</h5>
                                            </div>

                                            <div class="card-body">
                                                <div class="card card-table table-responsive shadow-0 mb-0">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No</th>
                                                                <th>Student Name</th>
                                                                <th>Class</th>
                                                                <th>Section</th>
                                                                <th>
                                                                    <div class="form-group">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input feeGroup" onchange="checkAll(this)" id="custom_checkbox_stacked_unchecked">
                                                                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">checkAll</label>
                                                                        </div>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($Students))
                                                                @foreach ($Students as $key=>$Student)
                                                                    <tr>
                                                                        <td>{{ ++$key }}</td>
                                                                        <td>{{ $Student->student_name }}</td>
                                                                        <td>{{ $Student->student_class }}</td>
                                                                        <td>{{ $Student->ClassSection->section }}</td>
                                                                        <td colspan="2">
                                                                            <div class="form-group">
                                                                                <div class="custom-control custom-checkbox">
                                                                                    <input type="checkbox" class="custom-control-input feeGroup" id="custom_checkbox_stacked_unchecked{{ $key }}" value="{{ $Student->id }}" {{ getAssignedStudentFees($Student->id,$FeesGroups->id)!="" ? $Student->id == getAssignedStudentFees($Student->id,$FeesGroups->id)->student_id ? "checked" : "" : "" }} name="student[student_id][]" required>
                                                                                    <label class="custom-control-label" for="custom_checkbox_stacked_unchecked{{ $key }}"></label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
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
                            if(SelectSection!=""){
                                // SearchDepartment();
                            }
                        }
                    });
                }
            }

            function SearchDepartment() {
                $(".form-validate-jquery").valid();
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                if(class_id!="" && section_id!=""){
                    $.ajax({
                        type: "get",
                        url: '{{ route("SearchDepartment") }}',
                        data: { "class_id": class_id , "section_id": section_id },
                        success: function(data) {
                            $('.AppendStudentDetails').html(data);
                        }
                    });
                }
            }

            function checkAll(ele) {
                var checkboxes = document.getElementsByTagName('input');
                if (ele.checked) {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = true;
                        }
                    }
                } else {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = false;
                        }
                    }
                }
            }
        // });
    </script>
@endsection
