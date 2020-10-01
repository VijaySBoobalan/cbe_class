@extends('layouts.master')

@section('chapeter_questions')
active
@endsection

@section('chapterbsed_question_menu')
active open
@endsection

@section('content')
<style>
.question_details{
	clear: both
}
</style>
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
           
                <fieldset>
                    <div class="row">
                       
                       
                        <div class="col-lg-12">
                           <?php //echo "<pre>";print_r($chapterQuestions);echo "</pre>"; ?>
						   @foreach($chapterQuestions as $key=>$questions)
						  <div class="question_details"> <span>{{ ++$key }} ) {{ strip_tags($questions->question_name) }} </span>
							<span style="float:right">
							<a ="#" data-chapter_id="{{ $questions->chapter_id }}"data-chapterQuestionsid="{{ $questions->chapter_based_question_id }}"data-row_id="{{ $questions->row_id }}"data-segregation_id="{{ $questions->segregation_id }}"data-question_id="{{ $questions->question_id }}"data-toggle="modal" data-target="#QuestionsList"class="btn btn-sm btn-primary add_question">Add</a>
							<a ="#" data-chapter_id="{{ $questions->chapter_id }}"data-chapterQuestionsid="{{ $questions->chapter_based_question_id }}"data-row_id="{{ $questions->row_id }}"data-segregation_id="{{ $questions->segregation_id }}"data-question_id="{{ $questions->question_id }}"data-toggle="modal" data-target="#QuestionsList"class="btn btn-sm btn-success change_question">Change</a>
							</span>
						  </div>
						  <hr>
						   @endforeach
						 
                        </div>
                    </div>
                   
                </fieldset>
               
			
			 
			 
                        </div>
						
                        <!-- /tile body -->
						<div class="AppendQuestion"></div>
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
						if(data.questions.length === 0){
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
$('body').on('change','.replace_question',function (e) {
						 // $('.dynamic_questions').remove();
						 // $(".dynsegregations").html("");
						
                      var question_id = $(this).val();
                      var removing_question_id = $(this).data('row_id');
                      var chapter_based_id = $(this).data('chapter_based_id');
                      var chapter_id = $(this).data('chapter_id');
					  
					  $.ajax({
                    type: "get",	
                    url: '{{ route('replaceQuestion') }}',
                    data:{question_id:question_id , removing_question_id:removing_question_id,chapter_id:chapter_id,chapter_based_id:chapter_based_id},
                    success: function(data) {
					// console.log(data);
					// alert(data);
					$('.message').text("Question Replaced Successfully");
					toastr.success("Question Replaced Successfully");
					window.location.reload();
                    }
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
						if(data.questions.length === 0){
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
                      var question_id = $(this).val();
                     
                      var chapter_based_id = $(this).data('chapter_based_id');
                      var chapter_id = $(this).data('chapter_id');
                      var segregation_id = $(this).data('segregation_id');
					 
					  $.ajax({
                    type: "get",	
                    url: '{{ route('addQuestion') }}',
                    data:{question_id:question_id ,segregation_id:segregation_id,chapter_id:chapter_id,chapter_based_id:chapter_based_id},
                    success: function(data) {
					// console.log(data);
					// alert(data);
					$('.message').text("Question Added Successfully");
					toastr.success("Question Added Successfully");
					window.location.reload();
                    }
                });
            });
</script>
     <script>
  $(document).ready(function(){
           
        });
      
</script>
@endsection

