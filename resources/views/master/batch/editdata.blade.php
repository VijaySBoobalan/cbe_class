          <form action='{{ route("BatchUpdate") }}' id="UpdateBatchForm" method="post" class="form-validate-jquery" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <input name="batch_id" id="batch_id" type="hidden"value="{{ $batch_id }}" class="batch_id">
                                <fieldset>
                                    <div class="row">
									 <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Batch Type') !!}
												<input type="text"name="batch_type"class="form-control batch_type"value="{{ $Batches->batch_type }}" id="batch_type"disabled>
                                              
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Batch Name') !!}
                                               
												<input type="text"name="batch_name"class="form-control batch_name"value="{{ $Batches->batch_name }}" id="batch_type">
                                              
											</div>
                                        </div>
										@if(!empty($Data['Batches']->class_id)){
										  <div class="schoolclass-sections ">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Class') !!}
													<input type="text"name="class_id"class="form-control class_id"id="class_id"disabled>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Section') !!}
                                                <input type="text"name="section_id"class="form-control section_id"id="section_id"disabled>
                                                </div>
                                            </div>
                                            
                                           
										</div>
										@endif
										<table class="table student_details">
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Class</th>
                                                    <th>Section</th>
                                                    <th>Select All &nbsp<input type="checkbox" id="selectall" class="css-checkbox selectall" name="selectall" autocomplete="off"></th>
                                                </tr>
                                                <tbody>
												<?php //print_R($Students); ?>
                                                @foreach($Students as $key=>$students)
													
													<tr>
													<td>{{ $students->student_name }}</td>
													<td>{{ $students->class }}</td>
													<td>{{ $students->section }}</td>
													
													<td><input type="checkbox"name="sel_student[]"value="{{ $students->u_id  }}" @foreach($allotedStudents as $akey=>$a_students)<?php if($a_students->student_id==$students->u_id) { echo "checked"; } ?>@endforeach ></td>
													
													</tr>
												@endforeach
												</tbody>
                                        </table>
                                        
                                    </div>
                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred UpdateBatch" id="UpdateBatch">Update</button>
                                </div>
                           </form>
						   <script>
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