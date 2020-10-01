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
                        <h1 class="custom-font"><strong>Fee Master</h1>
                    </div>
                    <div class="tile-body">

                        @if(isset($FeesGroup1))
                            {!! Form::model($FeesGroup1,['url' => action('FeesManagement\FeesAssignDepartmentController@update',$FeesGroup1->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @else
                            {!! Form::open(['url' => action('FeesManagement\FeesAssignDepartmentController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                        @endif
                        @csrf
                            <fieldset>
                                <div class="row">
                                    <input type="hidden" name="fee_group_id" value="{{ $FeesGroup->id }}">
                                    <input type="hidden" name="fee_id" value="{{ $FeesGroup->fee_type }}">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class_id',$ClassSections->pluck('class','class'),null, ['onchange'=>'getSection()','class' => 'form-control chosen-select class_id','data-placeholder'=>'select Class','id'=>'class_id']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section[]',[],null, ['class' => 'form-control chosen-select section','data-placeholder'=>'select Section','id'=>'section','multiple'=>'multiple']) !!}
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <div class="d-flex justify-content-end align-items-center text-center">
                                    <button type="submit" class="btn btn-primary">Save<i class="icon-paperplane ml-2"></i></button>
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
        $(document).ready(function() {
            getSection();
            var SelectSection = "";
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
                            $('.section').val(SelectSection).trigger("chosen:updated");
                        }
                    });
                }
            }
        });
    </script>
@endsection
