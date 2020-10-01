<div class="modal fade UploadHomework" id="UploadHomework" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Upload Homework</h1>
                        </div>
                        <div class="tile-body">
                            <form action="#"id="SubmitHomeworkForm" class="form-validate-jquery SubmitHomeworkForm"enctype="multipart/form-data" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input type="hidden"name="homework_id"id="homework_id">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Homework File') !!}
                                            <input type="file"name="homework_file"id="homework_file">
                                        </div>
                                    </div>
                                </div>
                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred SubmitHomeworks" id="SubmitHomework">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade UploadHomeworkStatus" id="UploadHomeworkStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Homework Status</h1>

                        </div>

                        <div class="tile-body">
						<p><b>Remarks:</b><span id="Remark"></span></p>
						<div class="homework_status"></div>
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
