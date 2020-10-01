<div class="modal fade AddStudentHomeworkModal" id="AddStudentHomeworkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">


                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Subject</h1>

                        </div>

                        <div class="tile-body">

                            <form action="#"method="post"id="AddStudentHomeworkForm" class="form-validate-jquery AddStudentHomeworkForm"enctype="multipart/form-data" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input type="hidden"name="homework_type"id="homework_type"value="student">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('class_id',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSection()','class' => 'form-control chosen-select','placeholder'=>'Class','id'=>'class_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('stud_section_id',[],null, ['class' => 'form-control chosen-select stud_section_id','placeholder'=>'Section','id'=>'stud_section_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject') !!}
                                                {!! Form::select('stud_subject_id',$Subject->pluck('subject_name','id') ,null, ['class' => 'form-control chosen-select','placeholder'=>'Subject','id'=>'stud_subject_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <a class="btn btn-primary get_students">Get Students</a>
                                  
                                    <table class="table">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Select All &nbsp<input type="checkbox" id="selectall" class="css-checkbox selectall" name="selectall" autocomplete="off"></th>
                                    </tr>
                                    <tbody class="studentlist"></tbody>
                                    </table>
                                    <a class="btn btn-primary set_homework"style="display:none">Set Homework</a>
                                    <div class="homeworkdetails"style="display:none">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Homework Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('stud_homework_date', null, ['class' => 'form-control','placeholder'=>'Homework Date','id'=>'stud_homework_date','required'=>'required']) !!}
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
                                                    {!! Form::text('stud_submission_date', null, ['class' => 'form-control','placeholder'=>'Submission Date','id'=>'stud_submission_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Attachment File') !!}
                                                {!! Form::file('attachment', null, ['class' => 'form-control','placeholder'=>'Attachment File','id'=>'attachment','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
									<div class="row">
                                   <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Estimated Mark') !!}
                                                {!! Form::text('estimated_mark', null, ['class' => 'form-control','placeholder'=>'Estimated Mark','id'=>'estimated_mark','required'=>'required']) !!}
                                            </div>
                                   </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::label('name', 'Extra Notes') !!}
                                        {!! Form::textarea('stud_description', null, ['class' => 'form-control','placeholder'=>'Description','id'=>'stud_description','required'=>'required']) !!}
                                          
                                    </div>
                                    </div>
                               
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred SubmitStudentHomeworkForm" id="SubmitStudentHomeworkForm">Save</button>
                                </div>
								 </div>
                            </div>
                        {!! Form::close() !!}
                       
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    if($('#editSectio_id').val() != ""){
          var SelectSection = $('#editSectio_id').val();
      }else{
          $('#student_class').trigger("chosen:updated");
          var SelectSection = "";
      }
   
   function getSection(){
     
          var student_class = $('#class_id').val();
          var selectHTML = "";
          if(student_class != ''){
              $.ajax({
                  type: "get",
                  url: '{{ route("getSection") }}',
                  data:{student_class:student_class},
                  success: function(data) {
                   
                      for (var key in data) {
                          var row = data[key];
                          selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                      }
                      $('.stud_section_id').html(selectHTML);
                      $('.stud_section_id').val(SelectSection).trigger("chosen:updated");
                  }
              });
          }
      }
  </script>