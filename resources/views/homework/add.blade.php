<div class="modal fade AddHomeworkModal" id="AddHomeworkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Class Homework</h1>

                        </div>

                        <div class="tile-body">

                            <form action="#" id="AddClassHomeworkForm" class="form-validate-jquery AddClassHomeworkForm"enctype="multipart/form-data" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input type="hidden"name="homework_type"id="homework_type"value="class">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('student_class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSections()','class' => 'form-control chosen-select','placeholder'=>'Class','id'=>'student_class','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Select Section','id'=>'section_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Subject') !!}
                                                {!! Form::select('subject_id',$Subject->pluck('subject_name','id') ,null, ['class' => 'form-control chosen-select','placeholder'=>'Select Subject','id'=>'subject_id','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Homework Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    {!! Form::text('homework_date', null, ['class' => 'form-control','placeholder'=>'Homework Date','id'=>'homework_date','required'=>'required']) !!}
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
                                                    {!! Form::text('submission_date', null, ['class' => 'form-control','placeholder'=>'Submission Date','id'=>'submission_date','required'=>'required']) !!}
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
                                        {!! Form::textarea('description', null, ['class' => 'form-control','placeholder'=>'Description','id'=>'description','required'=>'required']) !!}

                                    </div>
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred SubmitClassHomework" id="SubmitClassHomeworkForm">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
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

     function getSections(){
            var student_class = $('#student_class').val();
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
                        $('.section_id').html(selectHTML);
                        $('.section_id').val(SelectSection).trigger("chosen:updated");
                    }
                });
            }
        }

    </script>
