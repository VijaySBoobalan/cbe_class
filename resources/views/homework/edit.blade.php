<div class="modal fade" id="EditClassHomework" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit ClassHomework</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="UpdateClassHomeworkForm" enctype="multipart/form-data"method="post" class="form-validate-jquery" data-parsley-validate name="form2" role="form">

                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="homework_id" id="homework_id" type="hidden" class="homework_id">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                           <select name="edit_student_class"class="form-control edit_student_class"id="edit_student_class"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                               <select name="section_id"class="form-control section_id"id="section_id"></select>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject') !!}
                                               
                                                <select name="subject_id"class="form-control subject_id"id="subject_id"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Homework Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('homework_date', null, ['class' => 'form-control homework_date','placeholder'=>'Homework Date','id'=>'homework_date','required'=>'required']) !!}
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
                                                    {!! Form::text('submission_date', null, ['class' => 'form-control submission_date','placeholder'=>'Submission Date','id'=>'submission_date','required'=>'required']) !!}
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
                                        {!! Form::textarea('description', null, ['class' => 'form-control description','placeholder'=>'Description','id'=>'description','required'=>'required']) !!}
                                          
                                    </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateClassHomework" id="UpdateClassHomework">Update</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="DeleteModel" role="dialog">
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
<script>
    if($('#editSectio_id').val() != ""){
          var SelectSection = $('#editSectio_id').val();
      }else{
          $('#student_class').trigger("chosen:updated");
          var SelectSection = "";
      }
   
   function geteditSections(){
          var student_class = $('#edit_student_class').val();
          var selectHTML = "";
          
          if(student_class != ''){
              $.ajax({
                  type: "get",
                  url: '{{ route("getSection") }}',
                  data:{student_class:student_class},
                  success: function(data) {
                    
                      console.log(data);
                      for (var key in data) {
                          var row = data[key];
                          selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                      }
                      $('.section_id').html(selectHTML);
                      $('.section_id').val(SelectSection).trigger("chosen:updated");
                  }
              });
          }
      }
  </script>