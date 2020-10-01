@extends('layouts.master')

@section('settings')
active
@endsection

@section('settings_menu')
active open
@endsection

@section('content')

<section id="content">

    <div class="page page-forms-validate">

        <!-- row -->
        <div class="row">


            <div class="col-md-12">

                <section class="tile">

                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Settings</h1>
                    </div>

                    <div class="tile-body">
                        {!! Form::open(['url' => action('SettingsController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-horizontal','form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                        @csrf
                        <div class="form-group">
                            {!! Form::label('name', 'Application Fee for Institution', ['class' => 'col-sm-3','control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('application_fee_for_institution', isset($data) ? $data->application_fee_for_institution : '', ['class' => 'form-control','id'=>'application_fee_for_institution','required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Staff Grace Time (in minutes)', ['class' => 'col-sm-3','control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('staff_grace_time', isset($data) ? $data->staff_grace_time : '', ['class' => 'form-control','id'=>'staff_grace_time','required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('name', 'Student Grace Time (in minutes)', ['class' => 'col-sm-3','control-label']) !!}
                            <div class="col-sm-8">
                                {!! Form::text('student_grace_time', isset($data) ? $data->student_grace_time : '', ['class' => 'form-control','id'=>'student_grace_time','required'=>'required']) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                    <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                        <button type="submit" class="btn btn-lightred" id="form2Submit">Submit</button>
                    </div>

                </section>

            </div>
        </div>
        <!-- /row -->




    </div>

</section>

@endsection

@section('script')
<script>
    $(window).load(function() {
        $('#form2Submit').on('click', function() {
            $('#form2').submit();
            // bootbox.alert('Settings Saved Successfully!');
        });
    });
</script>
@endsection