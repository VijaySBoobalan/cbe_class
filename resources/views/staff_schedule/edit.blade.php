<div class="modal fade EditStaffScheduleModal" id="EditStaffScheduleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="row">
                <div class="col-md-12">

                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Staff Schedule</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="FilterStaffSubjectForm" method="post" class="form-validate-jquery FilterStaffSubjectForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff') !!}
                                                {!! Form::select('staff_id',$Staffs->pluck('staff_name','id') ,null, ['class' => 'form-control chosen-select staff_id','placeholder'=>'Select Staff','id'=>'staff_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSubjects(this.value);','class' => 'form-control chosen-select taken_class','placeholder'=>'Select Class','id'=>'class','required'=>'required']) !!}
                                            </div>
                                        </div>


                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>

                                    </div>
                                </fieldset>

                                <div class="modal-footer">
                                    <button class="btn btn-success btn-ef btn-ef-3 btn-ef-3c FilterStaffSubjectDetails" id="FilterStaffSubjectDetails"><i class="fa fa-arrow-right"></i>Filter</button>
                                    <button class="btn btn-lightred btn-ef btn-ef-4 btn-ef-4c" data-dismiss="modal"><i class="fa fa-arrow-left"></i> Cancel</button>
                                </div>
                            </div>
                            <div class="AppendStaffSchedule"></div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="DeleteStaffScheduleModel" role="dialog">
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
