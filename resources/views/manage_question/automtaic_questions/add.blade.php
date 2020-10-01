@extends('layouts.master')

@section('automatic_question_view')
active
@endsection

@section('automatic_question_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add New Blueprint</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body"> 
                            <form action="#" id="automaticQuestionForm" method="get" class="form-validate-jquery automaticQuestionForm" data-parsley-validate name="form2" role="form">
                @csrf
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Blue Print Name') !!}
                                {!! Form::text('blue_print_name',null, ['class' => 'form-control blue_print_name','placeholder'=>'Blue Print Name','id'=>'blue_print_name','required'=>'required']) !!}
                            </div>
                        </div>
						  <div class="col-lg-4">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Class') !!}
                                                {!! Form::select('student_class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getclassSubjects(this.value)','class' => 'form-control chosen-select','placeholder'=>'Class','id'=>'student_class','required'=>'required']) !!}
                                            </div>
                                        </div>
						 <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Subject Name') !!}
                                        {!! Form::select('subject_details',[] ,null, ['onchange'=>'studentAttendanceDetails();','class' => 'form-control chosen-select subject_details','placeholder'=>'Select Subject','id'=>'subject_details','required'=>'required']) !!}
                                    </div>
                         </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Get Question From <span class="text-danger">*</span></label>
                                <div>
                                    <label>
                                        <input type="radio"  name="preparation_type_id" value="0" class="preparation_type_id"checked required>
                                        All
                                    </label>
                                </div>
                                @foreach ($PreparationTypes as $PreparationType)
                                    <div>
                                        <label>
                                            <input type="radio" name="preparation_type_id" value="{{ $PreparationType->id }}" class="preparation_type_id"  required>
                                            {{ $PreparationType->preparation_type }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Creating Type') !!}
                                {!! Form::text('creating_type' ,null, ['class' => 'form-control creating_type','placeholder'=>'Creating Type','id'=>'creating_type','required'=>'required']) !!}
                            </div>
                        </div>
                    </div>
					</fieldset>
                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                    <button type="submit" class="btn btn-primary GetAutomaticQuestions" >Submit</button>
                </div>
            {!! Form::close() !!}
                    <div class="appendQuestionDetails"></div>

                
                          
                        </div>
                        <!-- /tile body -->
                       
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    {{-- @include('manage_question.automtaic_questions.automatic_questionjs') --}}
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
				$('.GetAutomaticQuestions').on('click',function (e) {
			 var form = $( "#automaticQuestionForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
				 $.ajax({
                type: "get",
                url: '{{ route("getQuestionDetails") }}',
                data:$('#automaticQuestionForm').serialize(),
                // dataType: 'json',
                success: function(data) {
                    $('.appendQuestionDetails').html(data);
                }
				});
			}
			 });
          // getQuestionDetails();
          function getQuestionDetails(preparation_type_id=0){
       var preparation_type_id= $("input[type=radio][name='preperation_type']:checked").val();
        var selectHTML = "";
        if(preparation_type_id != ''){
            $.ajax({
                type: "get",
                url: '{{ route("getQuestionDetails") }}',
                data:{preparation_type_id:preparation_type_id},
                success: function(data) {
                    $('.appendQuestionDetails').html(data);
                }
            });
        }
    }
			$('input[type=radio][name=preperation_type]').on('change', function() {
                      var preparation_type_id = $(this).val();
                      getQuestionDetails(preparation_type_id);
            });
          });
		 var SelectSubject = '';
	function getclassSubjects(class_id){
		// alert(class_id);
		var selectHTML = "";
		// var SelectSection = "";
            if(class_id != ''){
                $.ajax({
                    type: "get",
                    url: '{{ route("getClasssubjects") }}',
                    data:{class_id:class_id},
                    success: function(data) {
						console.log(data);
                        for (var key in data) {
                            var row = data[key];
                            selectHTML += "<option value='" + row.id + "'>" + row.subject_name + "</option>";
                        }
							$('.subject_details').html(selectHTML);
                            $('.subject_details').val(SelectSubject).trigger('chosen:updated');
                        // $('#subject_id').html(selectHTML);
                        // $('#subject_id').val(selectHTML).trigger("chosen:updated");
                    }
                });
            }
	}
	
        </script>
		
@endsection

