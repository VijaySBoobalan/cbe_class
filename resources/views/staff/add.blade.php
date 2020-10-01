@extends('layouts.master')

@section('add_staff')
active
@endsection

@section('staff_menu')
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
                            <h1 class="custom-font"><strong>Add Staff</h1>

                        </div>

                        <div class="tile-body">

                            @if(isset($Staffs))
                                {!! Form::model($Staffs,['url' => action('StaffController@update',$Staffs->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                            @else
                                {!! Form::open(['url' => action('StaffController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
                            @endif
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff id No') !!}
                                                {!! Form::text('staff_id_no', isset($staff_id) ? $staff_id : null, ['class' => 'form-control','placeholder'=>'Staff id No','id'=>'staff_id_no','required'=>'required','readonly']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff Name') !!}
                                                {!! Form::text('staff_name', null, ['class' => 'form-control','placeholder'=>'Staff Name','id'=>'staff_name','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Date of Birth') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('dob', null, ['class' => 'form-control','placeholder'=>'Date of Birth','id'=>'dob','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Qualification') !!}
                                                {!! Form::text('qualification', null, ['class' => 'form-control','placeholder'=>'Qualification','id'=>'qualification','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Mobile Number') !!}
                                                {!! Form::number('mobile_number', null, ['class' => 'form-control','placeholder'=>'Mobile Number','id'=>'mobile_number','required'=>'required','minlength'=>'10','maxlength'=>'11', 'oninput'=>"javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Email') !!}
                                                {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'Email','id'=>'email','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Roles') !!}
                                                {!! Form::select('roles[]',$roles->pluck('name','id'),"3", ['class' => 'form-control chosen-select','data-placeholder'=>'Roles','id'=>'email','required'=>'required','multiple'=>'multiple']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
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
        $(window).load(function(){
            $('#form2Submit').on('click', function(){
                $('#form2').submit();
            });
        });
    </script>
@endsection
