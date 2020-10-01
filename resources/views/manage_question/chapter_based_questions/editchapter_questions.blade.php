@extends('layouts.master')

@section('chapeter_questions')
active
@endsection

@section('question_menu')
active open
@endsection

@section('content')
<style>
.dynsegregations {
    border: #4c2f2f;
    border: 1px solid #e2cece;
    margin-left: 15px;
}

.newchanged {
    border: #4c2f2f;
    border: 1px solid #e2cece;
    margin-left: 15px;
}
a.btn.btn-sm.btn-success.change_question {
    margin-top: -7px;
    padding: 3px 1px 5px 0px;
    margin-right: 21px;
}
a.btn.btn-sm.btn-primary.add_question {
    padding: 1px 6px 7px 10px;
}
.modal-backdrop.in {
    filter: alpha(opacity=50);
    opacity: .0 !important;
}
.modal-backdrop {
    /* position: fixed; */
    /* top: 0; */
    /* right: 0; */
    /* bottom: 0; */
    /* left: 0; */
    /* z-index: 1040; */
    /* background-color: #000; */
}
</style>
<?php
use  App\ChapterBasedQuestionDetails;
 ?>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Question Details</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                               <!-- tile body -->
            {{-- {!! Form::open(['url' => route('AutomaticQuestionStore'),'method' => 'post','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!} --}}
            <form action="{{ action('ManageQuestions\ChapterBasedQuestionController@UpdateChapterbaseddetails') }}" id="ChapterBasedQuestionForm" method="post" class="form-validate-jquery ChapterBasedQuestionForm" data-parsley-validate name="form2" role="form">
                @csrf
                <fieldset>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Chapter Based Question </h4>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
							<input type="hidden"value="{{ $ChapterBasedQuestion->id }}"name="id">
                                {!! Form::label('name', 'Pattern Prefix') !!}
                                <input type="text"class="form-control pattern_prefix"value="{{ $ChapterBasedQuestion->pattern_prefix }}"id="pattern_prefix"name="pattern_prefix"required>
							</div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                               
                            </div>
                        </div>
                    </div>
                  
                </fieldset>
              

               
          
			
			 
			 
                        </div>
				<div class="header_sections">
				<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-4 schoolname">
                            <div class="form-group">
							 {!! Form::label('name', 'School Name') !!}
                               <input type="text"name="chapter_question_id"id="chapter_question_id"value="{{ $ChapterBasedQuestion->id }}">
                                  <input type="text" value="{{ $QuestionInstructions['school_name'] }}"name="schoolname"id="schoolname"class="form-control">
                            </div>
                        </div>
				<div class="col-md-4">
				</div>
				</div>
					<div class="row">
						<div class="col-md-4 Date">
						<div class="form-group">
                                                {!! Form::label('name', 'Date') !!}
                                                <div class="input-group datepicker" data-format="L">
                                                    <input type="text"name="date"class="form-control"value="{{ $QuestionInstructions['date'] }}">  
												   <span class="input-group-addon">
                                                        <span class="fa fa-calendar"></span>
                                                    </span>
                                                </div>
                            </div>
							
                        </div>
						<div class="col-md-4">
                           
                        </div>
						
						<div class="col-md-4 hours">
                             <div class="form-group">
                                {!! Form::label('name', 'Hours') !!}
                                <input type="text" value="{{ $QuestionInstructions['hours'] }}"name="hours"id="hours" value=""class="form-control"></div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-4 marks">
                            <div class="form-group">
                                  {!! Form::label('name', 'Marks') !!}
                                <input type="text" value="{{ $QuestionInstructions['marks'] }}"name="marks"id="marks" value=""class="form-control">
                            </div>
                        </div>
						<div class="col-md-4">
						</div>
						<div class="col-md-4 class">
                                            <div class="form-group">
                                               {!! Form::label('name', 'Class') !!}
                                                <select class="form-control chosen-select"name="class_id"id="class_id">
												@foreach($ClassSection as $class)
											<option value="{{ $class['class'] }}" <?php if($class['class']==$QuestionInstructions['class_id']){ echo "selected"; } ?>>{{ $class['class'] }}</option>
											@endforeach
                                            </select>
											</div>
                        </div>
						
						
					</div>
					<div class="row">
						<div class="col-md-4 instructions">
                            <div class="form-group">
                                {!! Form::label('name', 'Instructions') !!}
								<textarea class="form-control"placeholder="Instructions"name="instructions"id="instructions">{{ $QuestionInstructions['instructions'] }}</textarea>
							 </div>
                        </div>
						
                        </div>
                
				
				</div>			
		
	
			
					<div class="row">
					
						<div class="col-md-3">
                            <div class="form-group">
							<button type="submit" class="btn btn-primary FormSubmit" >Update</button>
							</div>
                        </div>
					</div>
				</form>
		
						
                        <!-- /tile body >
						<div class="AppendQuestion"></div-->
                    </section>
					
                </div>
				
            </div>
        </div>
    </section>
	<div id="QuestionsList" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4><div class="message"></div><div class="Errormessage"></div>
      </div>
      <div class="modal-body">
	  <table class="table">
	  <thead>
	  <tr>
	  <th>Questions</th>
	  <th>Select</th>
	  </tr>
	  </thead>
	  <tbody class="questions">
	  
	  </tbody>
	  </table>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('script')
<script>
  $(document).ready(function () {
  // $(document).on("click", ".change_question", function() {
	  $('body').on('click','.change_question',function (e) {
		  
	  var question_id = $(this).data("question_id");
	  var segregation_id = $(this).data("segregation_id");
	  var chapter_id = $(this).data("chapter_id");
	  var row_id = $(this).data("row_id");
	  var chapterQuestionsid = $(this).data("chapterquestionsid");
	    $.ajax({
                    type: "get",
					
                    url: '{{ route('changeQuestion') }}',
                    data:{question_id:question_id , segregation_id:segregation_id,chapter_id:chapter_id,row_id:row_id,chapterQuestionsid:chapterQuestionsid},
					dataType:'JSON',
                    success: function(data) {
						console.log(data);
						var questions = '';
						var i;
						if(data.questions.length === null){
							$('.Errormessage').text("No More Questions");
						}else{
					 for(i=0; i<data.questions.length; i++){
						
						 questions += '<tr>'+
		                  		'<td>'+data.questions[i].question_name+'</td>'+
		                  		'<td><input type="radio"class="replace_question"data-chapter_id="'+chapter_id+'"name="replace_question"data-chapter_based_id="'+chapterQuestionsid+'"data-row_id="'+data.row_id+'"value='+data.questions[i].id+'></td>'+
		                        '</tr>';
					 }
					  $('.questions').html(questions);					  
                    }
					}
                });		
});
			  });
			  	  $('body').on('click','.add_question',function (e) {
		  
	  var question_id = $(this).data("question_id");
	  var segregation_id = $(this).data("segregation_id");
	  var chapter_id = $(this).data("chapter_id");
	  var row_id = $(this).data("row_id");
	  var chapterQuestionsid = $(this).data("chapterquestionsid");
		
	    $.ajax({
                    type: "get",
					
                    url: '{{ route('changeQuestion') }}',
                    data:{question_id:question_id , segregation_id:segregation_id,chapter_id:chapter_id,row_id:row_id,chapterQuestionsid:chapterQuestionsid},
					dataType:'JSON',
                    success: function(data) {
						console.log(data);
						var questions = '';
						var i;
						if(data.questions.length === null){
							$('.Errormessage').text("No More Questions");
						}else{
					 for(i=0; i<data.questions.length; i++){
						
						 questions += '<tr>'+
		                  		'<td>'+data.questions[i].question_name+'</td>'+
		                  		'<td><input type="radio"class="add_to_list"data-chapter_id="'+chapter_id+'"name="add_to_list"data-chapter_based_id="'+chapterQuestionsid+'"data-segregation_id="'+data.questions[i].segregation_id+'"value='+data.questions[i].id+'></td>'+
		                        '</tr>';
					 }
					  $('.questions').html(questions);					  
                    }
					}
                });		
});
			  $('body').on('change','.add_to_list',function (e) {
						 // $('.dynamic_questions').remove();
						 // $(".dynsegregations").html("");
						
                      var question_id = $(this).val();
                     
                      var chapter_based_id = $(this).data('chapter_based_id');
                      var chapter_id = $(this).data('chapter_id');
                      var segregation_id = $(this).data('segregation_id');
					  alert(segregation_id);
					  $.ajax({
                    type: "get",	
                    url: '{{ route('addQuestion') }}',
                    data:{question_id:question_id ,segregation_id:segregation_id,chapter_id:chapter_id,chapter_based_id:chapter_based_id},
                    success: function(data) {
					// console.log(data);
					// alert(data);
					$('.message').text("Question Replaced Successfully");
					 $('.newchanged').remove();
					$('.newchangeds').html(data);
                    }
                });
            });
   $('body').on('submit','#Question_instructions',function (e) {
  // $('#Question_instructions').on('submit', function(event){
            // console.log($('#Question_instructions').serialize());
            var form = $( "#Question_instructions" );
            form.validate();
            event.preventDefault();
          
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route("Question_instructions") }}',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                    console.log(data); 
						// if(data.status == "success"){
							alert('Saved Successfully');
							window.location.reload();
						// }
                    }
                });
            }
        });
</script>
     <script>
  $(document).ready(function(){
            var questionCount = 0;
            $(".Quention input").on("keyup", function(){
                var dataId = $(this).attr("data-id");
                var dataMark = $(this).attr("data-mark");
                var currentValue = $(this).val();
                // questionCount = dataMark * currentValue;
                if(currentValue > dataId){
                    $(this).next().text("This is crossed the Maximum value of "+dataId);
                    $('.CreateQuestion').hide();
                }else{
                    $(this).next().text("");
                    $('.CreateQuestion').show();
                }
            });
        });
        $(".CurrentValue").on("keyup", function(){
            var $tr = $(this).closest('tr');
            var val1 = $(this).data("mark");
            var val2 = $tr.find('td:eq(2) input').val();
            $tr.find('td:eq(3) input').val(val1*val2);
            calc_total();
        });
        function calc_total(){
            var sum = 0;
            $(".TotalSegregationMark").each(function(){
                if(!isNaN($(this).val()) && $(this).val()!=='') {
                    sum += parseFloat($(this).val());
                }
            });
            $('.TotalMark').html(sum);
        }
       
</script>
@endsection

