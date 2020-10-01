@extends('layouts.master')

@section('view_assigned_department')
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
                        <h1 class="custom-font"><strong>Filter</h1>
                    </div>
                    <div class="tile-body">

                        {!! Form::open(['url' => action('FeesManagement\FeesAssignDepartmentController@index'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @csrf
                            <fieldset>
                                <div class="row">
                                    <input type="hidden" name="" id="section_id" value="{{ $section }}">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Types') !!}
                                            {!! Form::select('fee_type',$FeesMaster->pluck('fee_type','id'),$fee_type, ['class' => 'form-control chosen-select','placeholder'=>'Fee Types','id'=>'fee_type']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class_id',$ClassSection->pluck('class','class'),null, ['onchange'=>'getSection();','class' => 'form-control chosen-select class_id','data-placeholder'=>'select Class','id'=>'class_id']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section[]',[],null, ['class' => 'form-control chosen-select section','data-placeholder'=>'select Section','id'=>'section','multiple'=>'multiple']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" class="btn btn-primary ml-3">Filter <i class="icon-filter3 ml-2"></i></button>
                                </div>
                            </fieldset>
                        {!! Form::close() !!}
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="page page-forms-validate">
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Fee Assigned Classes</h1>
                    </div>
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table datatable-basic" id="mileage_Detail_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Fee Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        {{-- <th class="text-center">Actions</th> --}}
                                    </tr>
                                </thead>
                                <?php $count = 0; $total = 0;?>
                                @if (isset($FeesAssignDepartments))
                                    <tbody>
                                        @foreach ($FeesAssignDepartments as $key=>$FeesAssignDepartment)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $FeesAssignDepartment->FeeMaster->fee_type }}</td>
                                                <td>{{ $FeesAssignDepartment->getFeesType->fee_name }}</td>
                                                <td>{{ $FeesAssignDepartment->class_id }}</td>
                                                <td>{{ $FeesAssignDepartment->ClassSection->section }}</td>
                                                {{-- <td>
                                                    {!! Form::model($FeesMaster,['url' => action('FeesManagement\FeesGroupController@destroy',$FeesAssignDepartment->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                    <a href="{{ action('FeesManagement\FeesAssignDepartmentController@edit',$FeesAssignDepartment->id) }}" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class='list-icons-item text-danger-600 btn btn-sm'><i class='icon-trash'></i></button>
                                                    {!! Form::close() !!}
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                    <blockquote><p>No Data Available</p></blockquote>
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
        // $(document).ready(function() {
            getSection();
            // var section_id = $('#section_id').val();
            // if(section_id!=""){
            //     var SelectSection = section_id;
            // }else{
                var SelectSection = "";
            // }
            // console.log(SelectSection);
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
                            console.log(selectHTML);
                            $('.section').html(selectHTML);
                            // if(SelectSection!=""){
                            $('.section').val(SelectSection).trigger("chosen:updated");
                            // }else{
                            //     for (var key in SelectSection) {
                            //         var row = SelectSection[key];
                            //         selectHTML = row;
                            //         console.log(selectHTML);
                            //     }
                            // }
                        }
                    });
                }
            }
        // });
    </script>
@endsection
