<style>
.student_details {
    width: 100%;
}
</style>
<div class="modal fade" id="editStudentHomeworkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Student Homework</h1>
                        </div>

                        <div class="tile-body">
                         
                            <form action="#" id="UpdateStudentHomeworkForm" method="post"enctype="multipart/form-data" class="form-validate-jquery" data-parsley-validate name="form2" role="form">

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="student_homework_id" id="student_homework_id" type="text" class="student_homework_id">
                                <fieldset>
                                    <div class="row student_details">
                                        <div class="col-md-3">
                                        <p>Name:<b class="student_name"></b></p>
                                        </div>
                                        <div class="col-md-3">
                                        <p>Class:<b class="student_class"></b></p>
                                        </div>
                                        <div class="col-md-3">
                                        <p> Section:<b class="student_section"></b></p>
                                        </div>
                                        <div class="col-md-3">
                                        <p>Email:<b class="student_email"></b></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject') !!}                        
                                                <select name="subject_id"class="form-control subject_id"id="subject_id"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Homework Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('stud_homework_date', null, ['class' => 'form-control stud_homework_date','placeholder'=>'Homework Date','id'=>'stud_homework_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Submission Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('stud_submission_date', null, ['class' => 'form-control stud_submission_date','placeholder'=>'Submission Date','id'=>'stud_submission_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Attachment File') !!}
                                                {!! Form::file('update_attachment', null, ['class' => 'form-control','placeholder'=>'Attachment File','id'=>'update_attachment','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                               
                                    <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('name', 'Extra Notes') !!}
                                        {!! Form::textarea('stud_description', null, ['class' => 'form-control stud_description','placeholder'=>'Description','id'=>'stud_description','required'=>'required']) !!}
                                          
                                    </div>
                                    </div>
                                
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateStudentHomework" id="UpdateStudentHomework">Update</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteStudentHomework" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are You Sure ! You Want to Delete</h4>
            </div>
            <div class="modal-body">
                <form action="#">
                    <button type="submit" class="btn btn-danger DeleteStudentConfirmed" data-dismiss="modal">Delete </button>
                    <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
