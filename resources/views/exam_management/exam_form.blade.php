@extends('layouts.master')

@section('exam_management')
active
@endsection

@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
	
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Create Exam</h1>
                          
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
                                   <form action="#" id="GetExamQuestions" method="get" class="form-validate-jquery ChapterBasedQuestionForm" data-parsley-validate name="form2" role="form">
                @csrf
				<div class="row">
					<fieldset>
                    
                        <div class="col-lg-12">
                           
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
							<input type="hidden"name="id"value="{{ $id }}">
                                {!! Form::label('name', 'Exam Name') !!}
                                {!! Form::text('exam_name',null, ['class' => 'form-control exam_name','placeholder'=>'Exam Name','id'=>'exam_name','required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Preperation Type') !!}
                                <select class="form-control chosen-select preperations"name="preperation_type_id" multiple="multiple">
								@foreach($PreparationTypes as $preperation)
								<option value="{{ $preperation->id }}">{{ $preperation->preparation_type }}</option>
								@endforeach
								</select>
								</div>
                        </div>
						<div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Exam Time') !!}
								{!! Form::text('exam_time',null, ['class' => 'form-control exam_time','placeholder'=>'Exam Time','id'=>'exam_time','required'=>'required']) !!}
								</div>
                        </div>
						<div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Question From') !!}
								<select name="question_from"id="question_from"class="form-control question_from">
								<option>Select</option>
								<option value="subjects">Subjects</option>
								<option value="chapter">Chapters</option>
								<option value="Unit">Unit Wise</option>
								</select>
								</div>
                        </div>
						<div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Subjects') !!}
								@foreach($Subject as $subjects)
								<div class="checkbox">
								<label><input type="checkbox"class="subjects"name="subject[{{ $subjects->id }}]" value="{{ $subjects->id }}">{{ $subjects->subject_name }}</label>
								</div>
								@endforeach
							</div>
						</div>
						
                </fieldset>
				</div>
				<div class="row">
				<div class="chapters"></div>
				</div>
                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                    <button type="submit" class="btn btn-primary GetQuestions" >GetQuestions</button>
                </div>

               
            </form>
			
			<form action="#"method="get"id="storeExamQuestions">
			<div class="questions_list">
			</div>
			 
			</form>
                              
                            </div>
                        </div>

                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>
    </section>

<script>
// $(document).ready(function(){
 // $('.preperations').multiselect({
  // nonSelectedText: 'Select Preperations',
  // enableFiltering: true,
  // enableCaseInsensitiveFiltering: true,
  // buttonWidth:'400px'
 // });
 // });
$('#question_from').on('change', function() {
 var question_from=$(this).val();
		// alert(question_from);
		if(question_from == "subjects"){
			 $("input[name*='subject']").removeClass("subjects");
			 $("input[name*='subject']").addClass("subjectsonly");
			  // $('.subjects').removeClass('subjects');
			  // $('.subjects').addClass('subjectsonly');
		}
});

	$('.subjects').change(function () {
   
		var subject_id = $(this).val();
		if ($(this).is(':checked')) {
				$.ajax({
                    type: "get",
                    url: '{{ route("get_chapters") }}',
                    data:{subject_id:subject_id},
                    success: function(data) {
						$('.chapters').append(data);	
                    }
                });
		}else{
		$('.subject'+subject_id).remove();
		}
	});
	   $('.GetQuestions').on('click',function (e) {
				
            
            var form = $( "#GetExamQuestions" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "get",
                    url: "{{ route('getExamQuestions') }}",
                    data:$('#GetExamQuestions').serialize(),
                    success: function(data) {
						// alert(data);
                        $('.questions_list').html(data);
                    }
                });
            }
			
        });
				$('body').on('click','.StoreExam',function (e) {
            var form = $( "#storeExamQuestions" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route('storeExamQuestions') }}',
                    data:$('#storeExamQuestions').serialize(),
                    success: function(data) {
						if(data.status == 'error'){
							toastr.error(data.message);
						}else{
							toastr.success(data.message);
							var route='{{ url("exams") }}/'+data.id;
							window.location.href = route;
                        }
                    }
                });
            }
        });
</script>
@endsection


