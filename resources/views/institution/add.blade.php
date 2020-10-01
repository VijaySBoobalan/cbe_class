<div class="modal fade AddInstitutionModal" id="AddInstitutionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">


                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Institution</h1>

                        </div>

                        <div class="tile-body">

                            <form action="#" id="AddInstitutionForm" method="post" class="form-validate-jquery AddInstitutionForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Institution Name') !!}
                                                {!! Form::text('institution_name', null, ['class' => 'form-control','placeholder'=>'Institution Name','id'=>'institution_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Institution Address') !!}
                                                {!! Form::text('institution_address', null, ['class' => 'form-control','placeholder'=>'Institution Address','id'=>'institution_address','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Admin User Name') !!}
                                                {!! Form::text('user_name', null, ['class' => 'form-control','placeholder'=>'Admin User Name','id'=>'user_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Phone Number 1') !!}
                                                {!! Form::text('phone_number_1', null, ['class' => 'form-control','minlength'=>'10', 'maxlength'=>'11','placeholder'=>'Phone Number 1','id'=>'phone_number_1','onkeypress'=>'return validatenumber(event)','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Phone Number 2') !!}
                                                {!! Form::text('phone_number_2', null, ['class' => 'form-control','minlength'=>'10', 'maxlength'=>'11','placeholder'=>'Phone Number 2','id'=>'phone_number_2','onkeypress'=>'return validatenumber(event)','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'E-Mail Address') !!}
                                                {!! Form::email('email', null, ['class' => 'form-control','placeholder'=>'E-Mail Address','id'=>'email','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Password') !!}
                                                <div class="input-group">
                                                    {!! Form::password('password', ['class' => 'form-control','placeholder'=>'Password','id'=>'password','required'=>'required','data-toggle'=>'password']) !!}
                                                    <span class="input-group-addon">
                                                        <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Confirm Password') !!}
                                                <div class="input-group">
                                                    {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'Confirm Password','id'=>'password_confirmation','required'=>'required','data-toggle'=>'password']) !!}
                                                    <span class="input-group-addon">
                                                        <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password_confirmation"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Roles') !!}
                                                {!! Form::select('roles[]',$roles->pluck('name','id'),"2", ['class' => 'form-control chosen-select','data-placeholder'=>'Roles','id'=>'roles','required'=>'required','multiple'=>'multiple']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Application Fee for TTS') !!}
                                                {!! Form::text('tts_fee', null, ['class' => 'form-control tts_fee','placeholder'=>'Application Fee for TTS','id'=>'tts_fee','onkeypress'=>'return validatenumber(event)','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Application Fee for Institution') !!}
                                                {!! Form::text('school_fee', null, ['class' => 'form-control school_fee','placeholder'=>'Application Fee for Institution','id'=>'school_fee','onkeypress'=>'return validatenumber(event)','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div> --}}

                                    <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                        <button type="submit" class="btn btn-lightred AddInstitution" id="AddInstitution">Save</button>
                                    </div>
                                </fieldset>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
