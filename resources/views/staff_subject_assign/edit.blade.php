<div class="modal fade EditStaffSubjectModal" id="EditStaffSubjectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Staff Subject Assign</h1>
                        </div>

                        <div class="tile-body">

                            <form action="#" id="UpdateStaffSubjectForm" method="post" class="form-validate-jquery UpdateStaffSubjectForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <input name="staff_subject_id" id="staff_subject_id" type="hidden" class="staff_subject_id">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff') !!}
                                                {!! Form::select('staff_id',$Staffs->pluck('staff_name','id') ,null, ['class' => 'form-control chosen-select staff_id','placeholder'=>'Select Staff','id'=>'staff_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSection(this.value);','class' => 'form-control chosen-select taken_class','placeholder'=>'Select Class','id'=>'class','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['onchange'=>'getSubjects(this.value);','class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject Name') !!}
                                                {!! Form::select('subjects',[] ,null, ['class' => 'form-control chosen-select subject_details','placeholder'=>'Select Subject','id'=>'subject_details','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateStaffSubject" id="UpdateStaffSubject">Save</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="DeleteStaffSubjectModel" role="dialog">
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
