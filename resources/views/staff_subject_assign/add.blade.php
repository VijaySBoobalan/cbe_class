<div class="modal fade AssignStaffSubjectModal" id="AssignStaffSubjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-12">

                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Staff Subject Assign</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="AddStaffSubjectForm" method="post" class="form-validate-jquery AddStaffSubjectForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff') !!}
                                                {!! Form::select('staff_id',$Staffs->pluck('staff_name','id') ,null, ['class' => 'form-control chosen-select staff_id','data-placeholder'=>'Select Staff','id'=>'staff_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSection(this.value);','class' => 'form-control chosen-select taken_class','data-placeholder'=>'Select Class','id'=>'class','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['onchange'=>'getSubjects(this.value);','class' => 'form-control chosen-select section_id','data-placeholder'=>'Select Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject Name') !!}
                                                {!! Form::select('subjects',[] ,null, ['class' => 'form-control chosen-select subject_details','data-placeholder'=>'Select Subject','id'=>'subject_details','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred AddStaffSubject" id="AddStaffSubject">Save</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
