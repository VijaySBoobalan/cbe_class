<div class="modal fade AddBatchModal" id="AddBatchModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="row">

                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Batch</h1>
                        </div>

                        <div class="tile-body">
                            <form action="{{ route('Batchstore') }}" id="AddBatchForm" method="post" class="form-validate-jquery AddBatchForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Batch Type') !!}
                                               <select class="form-control"name="batch_type"id="batch_type">
                                                <option>Select Batch Type</option>
                                                <option value="neet">NEET</option>
                                                <option value="school">School</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Batch Name') !!}
                                                {!! Form::text('batch_name', null, ['class' => 'form-control batch_name','placeholder'=>'Batch Name','id'=>'batch_name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                        <div class="schoolclass-sections">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('student_class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSections()','class' => 'form-control chosen-select','placeholder'=>'Class','id'=>'student_class','required'=>'required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Section') !!}
                                                {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Select Section','id'=>'section_id','required'=>'required']) !!}
                                            
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <a class="btn btn-primary get_students">Get Students</a>
                                            
                                                </div>
                                            </div>
										</div>
                                            <table class="table student_details">
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Class</th>
                                                    <th>Section</th>
                                                    <th>Select All &nbsp<input type="checkbox" id="selectall" class="css-checkbox selectall" name="selectall" autocomplete="off"></th>
                                                </tr>
                                                <tbody class="studentlist"></tbody>
                                                </table>
                                      
                                   
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred AddBatch" id="AddBatch">Save</button>
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
// $('#batch_type').on('change', function() {
 // var batch_type=$(this).val();

 // if(batch_type == "school"){
   
    // $(".schoolclass-sections").removeClass("hide");
 // }else{
	  // var everyStudents = "";
      // $.ajax({
                    // type: "get",
                    // url: '{{ route("getAllStudents") }}',
                    // data:{batch_type:batch_type},
                    // success: function(data) {
						// console.log(data);
                        // for (var key in data) {
                            // var row = data[key];
                             // everyStudents +="<tr><td>"+row.student_name+"</td><td>"+row.student_class+"</td><td>"+row.section+"</td><td> <input class='checkboxall' type='checkbox' name='sel_student[]' value="+row.id+"></td></tr>";  
                        // }
						// $('.student_details').removeClass('hide');
                        // $('.studentlist').html(everyStudents);
                        
                    // }
                // });
     // $(".schoolclass-sections").addClass("hide");
     
 // }
// });

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
        $('.get_students').click(function(){
        var class_id = $('#student_class').val();
        var section_id = $('#section_id').val();
        if(class_id == '' && section_id == ''){
            alert('Please Choose class and Section');
        }else{
            get_students(class_id,section_id);
        }
       
    });
    function get_students(class_id,section_id){
        var studentlist = "";
       
            $.ajax({
                    type: "post",
                    url: '{{ route("getStudent") }}',
                    data:{class_id:class_id,section_id:section_id},
                    success: function(data) {
                     console.log('students',data);
                     if(data .length === 0){
                        alert('No Students Found');
                     }else{
                     for (var key in data) {
                            var row = data[key];
                           
                            studentlist +="<tr><td>"+row.student_name+"</td><td>"+row.student_class+"</td><td>"+row.section_id+"</td><td> <input class='checkboxall' type='checkbox' name='sel_student[]' value="+row.id+"></td></tr>";  
                        }
						$('.student_details').removeClass('hide');
                        // $('.get_students').hide();
                        $('.set_homework').show();
                        $('.studentlist').html(studentlist);
                     }
                    }
                });
       
    }
    $(".selectall").click(function(){
        if(this.checked){
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', true);
            })
        }else{
            $('.checkboxall').each(function(){
                $(".checkboxall").prop('checked', false);
            })
        }
    });
</script>