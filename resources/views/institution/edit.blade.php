<div class="modal fade" id="editInstitutionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Institution</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="UpdateInstitutionForm" method="post" class="form-validate-jquery" data-parsley-validate name="form2" role="form">

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="institution_id" id="institution_id" type="hidden" class="institution_id">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Institution Name') !!}
                                                {!! Form::text('institution_name', null, ['class' => 'form-control institution_name','placeholder'=>'Institution Name','id'=>'institution_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Institution Address') !!}
                                                {!! Form::text('institution_address', null, ['class' => 'form-control institution_address','placeholder'=>'Institution Address','id'=>'institution_address','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Admin User Name') !!}
                                                {!! Form::text('user_name', null, ['class' => 'form-control user_name','placeholder'=>'Admin User Name','id'=>'user_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Phone Number 1') !!}
                                                {!! Form::text('phone_number_1', null, ['class' => 'form-control phone_number_1','minlength'=>'10', 'maxlength'=>'10','placeholder'=>'Phone Number 1','id'=>'phone_number_1','onkeypress'=>'return validatenumber(event)','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Phone Number 2') !!}
                                                {!! Form::text('phone_number_2', null, ['class' => 'form-control phone_number_2','minlength'=>'10', 'maxlength'=>'10','placeholder'=>'Phone Number 2','id'=>'phone_number_2','onkeypress'=>'return validatenumber(event)','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'E-Mail Address') !!}
                                                {!! Form::email('email', null, ['class' => 'form-control email','placeholder'=>'E-Mail Address','id'=>'email','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Password') !!}
                                                <div class="input-group">
                                                    {!! Form::password('password', ['class' => 'form-control','placeholder'=>'Password','id'=>'password']) !!}
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
                                                    {!! Form::password('password_confirmation', ['class' => 'form-control','placeholder'=>'Confirm Password','id'=>'password_confirmation']) !!}
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
                                                {!! Form::select('roles[]',$roles->pluck('name','id'),null, ['class' => 'form-control roles chosen-select','data-placeholder'=>'Roles','id'=>'roles','required'=>'required','multiple'=>'multiple']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Application Fee for TTS') !!}
                                                {!! Form::text('tts_fee', null, ['class' => 'form-control tts_fee','placeholder'=>'Application Fee for TTS','id'=>'tts_fee','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Application Fee for Institution') !!}
                                                {!! Form::text('school_fee', null, ['class' => 'form-control school_fee','placeholder'=>'E-Mail Address','id'=>'school_fee','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div> --}}

                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateInstitution" id="UpdateInstitution">Update</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="InstitudeDeleteModel" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are You Sure ! You Want to Delete</h4>
            </div>
            <div class="modal-body">
                <form action="#">
                    <button type="submit" class="btn btn-danger DeleteConfirmed" data-dismiss="modal">Delete </button>
                    <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
