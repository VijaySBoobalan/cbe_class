<div class="modal fade" id="editOnlineTestModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Online Test Edit</h1>
                        </div>

                        <div class="tile-body">
                            
                            <form action="#" id="UpdateOnlineTestForm" method="post" class="form-validate-jquery" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="test_id" id="test_id" type="hidden" class="test_id">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Exam Name') !!}
                                                {!! Form::text('edit_exam_name', null, ['class' => 'form-control edit_exam_name','placeholder'=>'Exam Name','id'=>'edit_exam_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('edit_student_class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'geteditSections()','class' => 'form-control chosen-select','placeholder'=>'Class','id'=>'edit_student_class','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('edit_section_id',[],null, ['class' => 'form-control chosen-select edit_section_id','data-placeholder'=>'Section','id'=>'edit_section_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            {!! Form::label('name', 'From Time') !!}
                                            <div class='input-group datepicker' data-format="LT">
                                                {!! Form::text('edit_from_time', null, ['class' => 'form-control edit_from_time','placeholder'=>'From Time','id'=>'edit_from_time','required'=>'required']) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            {!! Form::label('name', 'To Time') !!}
                                            <div class='input-group datepicker' data-format="LT">
                                                {!! Form::text('edit_to_time', null, ['class' => 'form-control edit_to_time','placeholder'=>'From Time','id'=>'edit_to_time','required'=>'required']) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'From Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('edit_from_date', null , ['class' => 'form-control edit_from_date','placeholder'=>'Day','id'=>'edit_from_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'To Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('edit_to_date', null , ['class' => 'form-control edit_to_date','placeholder'=>'Day','id'=>'edit_to_date','required'=>'required']) !!}
                                                    <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>  
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Topic') !!}
                                                {!! Form::text('edit_topic', null, ['class' => 'form-control edit_topic','placeholder'=>'Batch Name','id'=>'edit_topic','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateOnlineTest" id="UpdateOnlineTest">Update</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
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
                    <button type="button" class="btn btn-danger DeleteConfirmed" data-dismiss="modal">Delete </button>
                    <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    if($('#section_id').val() != ""){
          var SelectSection = $('#edit_section_id').val();
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
                      $('.edit_section_id').html(selectHTML);
                      $('.edit_section_id').val(SelectSection).trigger("chosen:updated");
                  }
              });
          }
      }
  </script>
  