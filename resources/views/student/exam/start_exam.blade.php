@extends('layouts.master')

@section('write_test')
active
@endsection

@section('content')
<style>
.questions {
    display: none;
}
.active {
    display: inherit;
}

.question_name {
    font-size: 20px;
    padding-bottom: 10px;
}
.colorDefinition {
    background: #ead9d9 !important;
    color: #FFFFFF !important;
    border-color: #F0068E !important;
}
.size_lg {
    font-size: 36px;

    color: black !important;
}
h2.question-title.color-green {
    padding-bottom: 10px;
    background: #d6d6f5;
    /* width: 100%; */
}
p.trueorfalseoptions {
    padding-left: 43px;
    padding-bottom: 10px;
    font-size: 20px;
}

a.GotoQuestion {
    padding-bottom: 1px;
    margin-top: 5px;
}
.row.controller {
    border: 1px solid #ccccd4;
    padding-top: 10px;
}
a.btn.btn-success  {
    color: white;
}
</style>
<script src="{{ url('assets/js/jquery.countdownTimer.js') }}"></script>

 <link rel="stylesheet" href="{{ url('assets/css/jquery.countdownTimer.css') }}">
    	
    <section id="content">
		<section  class="tile">
		 <div class="page page-tables-datatables">		
		  <div class="tile-body instructions">
		
		<p>
		Essay exams are a useful tool for finding out if you can sort through a large body of information, figure out what is important, and explain why it is important. Essay exams challenge you to come up with key course ideas and put them in your own words and to use the interpretive or analytical skills you’ve practiced in the course.
Instructors want to see whether:
<ul>
<li>You understand concepts that provide the basis for the course</li>
<li>You can use those concepts to interpret specific materials</li>
<li>You can make connections, see relationships, draw comparisons and contrasts</li>
<li>You can synthesize diverse information in support of an original assertion</li>
<li>You can justify your own evaluations based on appropriate criteria</li>
<li>You can argue your own opinions with convincing evidence</li>
<li>You can think critically and analytically about a subject</li>
</ul>
		</p>
		<input type="checkbox"name="accept"class="i-accept">I Accept
		<button class="btn btn-primary"id="start_exam">Start</button>
		
		</div>
		</div>
		</section>
        <div class="page page-tables-datatables hide startexam_contentdetails">
            <div class="row">
			 <div class="col-md-12">
			  <section class="tile">
			  <div class="col-md-4">
			  Exam From: {{ $Exam->from_date }}  - {{ $Exam->to_date }}
			
			  </div>
			  <div class="col-md-4">
			  Time: {{ $Exam->exam_time }} 
			  </div>
			 <span id="hms_timer"></span>
			  </section>
			</div>
			</div>
			
            <div class="row">
			 <div class="col-md-8">
                 <section class="tile">
				  <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam</h1>
                           
                        </div>
				  <div class="tile-body">
				@foreach($question as $key=>$que)
					<form class="OnlineTest-question" id="formsubmit{{$key}}">
					
					 <div class="question @if($key !=0) hidden @endif" data-question="{{++$key}}">
						 <div class="row">
                            <div class="col-xs-12">
                                <h2 class="question-title color-green">{{$key}} ). {{ strip_tags($que['question_name']) }}</h2>
                            </div><hr>
                        </div>
						<div class="row">
						<input type="text"name="segregation_id"id="segregation_id{{$key}}"class="segregation_id"value="{{$que['segregation_id']}}">
						<input type="hidden"name="Exam_id"class="exam_id"value="{{$Exam_id}}">
						<input type='hidden'name='question_id'class="question_id"id="question_id{{$key}}"value="{{ $que['q_id'] }}">
						<?php  $answered=checkAnswered($que['q_id'],$Exam_id);?>
						@if($que['segregation_id']==1)
							
			<p class="trueorfalseoptions"><input type="radio"name="answer"class="answer{{$key}}"id="answer{{$key}}"value="true"<?php if($answered['studentanswer']=="true"){echo "checked"; } ?> required >True &nbsp
			<input type="radio"name="trueorfalse"class="answer{{$key}}"id="answer{{$key}}"value="false"<?php if($answered['studentanswer']=="false"){echo "checked"; } ?> required >False</p>
			@endif
			<?php if(!empty($que['answer_option'])) {
				echo "<span class='answer_options'>";
				foreach(unserialize($que['answer_option']) as $key2 => $Que){ ?>
					<input type="radio"name="chooseanswer"class="answer{{$key}}"value="{{strip_tags($Que)}}"<?php if($answered['studentanswer']==strip_tags($Que)){echo "checked"; } ?> required >{{ strip_tags($Que)}}</p>
				<?php }
				echo "</p>";
			}elseif($que['segregation_id'] != 1 && $que['segregation_id'] != 2){ ?>
				<textarea class='summernote answer{{$key}}'id="answer{{$key}}"name='answer'required>{{ $answered['studentanswer'] }}</textarea>
			<?php } ?>
			
						</div>
					 </div>
					  </form>
				@endforeach
                  
                   

                    <input type="hidden" value="1" id="currentQuestionNumber" name="currentQuestionNumber" />
                    <input type="hidden" value="{{ count($question) }}" id="totalOfQuestion" name="totalOfQuestion" />
                    <input type="hidden" value="[]" id="markedQuestion" name="markedQuestions" />
					 
				<div class="row controller">
					<div class="col-md-3">
                        <a href="javascript:void(0);"  class="btn btn-success back_to_prev_question disabled ">
                            Back
                        </a>
					 </div>
					<div class="col-md-3">
                        <div class="mt-4">
                            <span id="current-question-number-label">1</span>
                            <span>Of <b>{{ count($question) }}</b></span>
                        </div>
                        <div class="mt-4">
                            Question Number
                        </div>
					</div>
                    <div class="col-md-3">
                        <a href="javascript:void(0);"row_id="0" class="btn btn-success go_to_next_question">
                            Next
                        </a>
					</div>
                    <div class="visible-xs">
                        <div class="clearfix"></div>
                        <div class="mt-50"></div>
                    </div>
                  
                     <!--div class="col-md-3">
                        <a href="javascript:void(0);" id="finishExams" class="btn btn-success disabled">
                            <b>Finish</b>
                        </a>
					 </div-->
				</div>
               
				  </div> 
				 </section>
            </div>
          
			<div class="col-md-4">
			 <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam</h1>
                            
                        </div>
                        <!-- /tile header -->
						<?php //echo "<pre>"; print_r($questions); echo "</pre>"; 
						//echo $questions[0]['question_id'];
						
						?>
						
						
                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
								@foreach($question as $key=>$Que)
								<?php //$keyno= ++$key ?>
								{{$Que['id'][0]}}
								
								<a href="#"class="btn btn-success GotoQuestion" data-question_row="{{ $key }}" id="{{$Que['question_id']}}">{{ ++$key }}</a>
								@endforeach	
                                </div>
								
                            </div><br>
							
						<?php  $Completed=getCompletedCount($Exam_id);?>	
						<ul>
							<li><a href=""class="btn btn-primary">Total Questions <span class="badge">{{ count($question) }}</span></a></li>
							<li><a href=""class="btn btn-success">Completed <span class="badge">{{ $Completed }}</span></a></li>
							<li><a href=""class="btn btn-danger">Pending<span class="badge">{{ count($question) - $Completed }}</span></a></li>
						</ul>
							<br>
							<div class="row">
								<div class="col-md-3">
									<button class="btn btn-primary finish_exam">Finish</button>
								</div>
							</div>
                        </div>

                        <!-- /tile body -->
						
           
               
                    </section>
			</div>
            <!-- Exmas Footer - Multi Step Pages Footer -->
			
			
			
		  <!-- Finsih Modal -->
        <div class="modal fade" id="finishExamsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                    <div class="modal-body">
                        <div>
                            <span>Total Of Answerd Quastion</span>
                            <span class="finishExams-total-answerd"></span>
                        </div>
                        <div>
                            <span>Total Of Marked Quastion</span>
                            <span class="finishExams-total-marked"></span>
                        </div>
                        <div>
                            <span>Total Of Remaining Quastion</span>
                            <span class="finishExams-total-remaining"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
             
				<input type="hidden"name="initialquestion_id"id="initialquestion_id"value="{{ $question[0]['question_id'] }}">
						<input type="hidden"name="Exam_id"id="Exam_id"value="{{ $Exam_id }}">
			
            </div>
          
        </div>
    </section>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>
<script>
$("#start_exam").on("click", function(){
	 $('.summernote').summernote({
                height: 200   //set editable area's height
            });
	if ($('.i-accept').not(':checked').length) {
  alert('You must accept to the insrtuctions to Start the Exam');
	}else{
	
		timer();
		$('.instructions').hide();
		// $('.start_exam_contents').show();
		$('.startexam_contentdetails').removeClass('hide');
		// var question_id = $('#initialquestion_id').val();
// TabtoQuestions(question_id);
	}
});
$(document).ready(function(){
	
// timer();
});

$(".GotoQuestion").on("click", function(){
	 var question_id =$(this).attr('id');
	});
	
	$('body').on('click','.finish_exam',function (e) {
	var Exam_id =$('#Exam_id').val();
	   $.ajax({
                    type: "get",
                    url: '{{ route("FinishExam") }}',
                    data:{Exam_id:Exam_id},
					dataType:'JSON',
                    success: function(data) {  
					console.log(data);
					
                       if(data.status == "success"){
						   toastr.success(data.message);
						   var route='{{ url("write_test") }}';
							window.location.href = route;
					   }
                    }
                });
	});


$('body').on('click','.go_to_next_question',function (e) {
			var keyno =$('#current-question-number-label').html();
			var current_key=keyno -1;
			
			$('.go_to_next_question').attr( 'row_id',current_key); // set attribute value to next btton
			var key = $(this).attr('row_id');
			var Exam_id =$('#Exam_id').val();
			var segregation_id =$('#segregation_id'+keyno).val();
			var question_id =$('#question_id'+keyno).val();
			if(segregation_id == 1 || segregation_id == 2){
				if(segregation_id == 1){
					var answer =$("input[name='trueorfalse']:checked").val();
				}else{
					var answer =$("input[name='chooseanswer']:checked").val();
				}
			}else{
			var answer =$('#answer'+keyno).code();
			}
 			
			
            e.preventDefault();
			 $.ajax({
                    type: "get",
                    url: "{{ route('submitAnswer') }}",
                    // data:form,
                    data:{Exam_id:Exam_id,question_id:question_id,answer:answer },
                    success: function(data) {
						// alert(data); 
                    }
                });
			});
function ckeditor(){
	 var base_url="{{ URL::to('/assets/js/')}}/";
	    CKEDITOR.replace( '.ckeditor', {
    filebrowserBrowseUrl: base_url+'ckeditor/kcfinder/browse.php?type=images',
	filebrowserImageBrowseUrl: base_url+'ckeditor/kcfinder/browse.php?type=Images',
	filebrowserImageUploadUrl : base_url+'ckeditor/kcfinder/upload.php?opener=ckeditor&type=images',
    filebrowserUploadUrl: base_url+'ckeditor/kcfinder/upload.php?type=images',
	extraPlugins : 'uicolor',
	height: '100px',
});
}
 function timer(){
                                    $('#hms_timer').countdowntimer({
                                        hours : '{{$Exam->exam_time}}',
                                        minutes :00,
                                        seconds : 00,
                                        size : "lg",
					pauseButton : "pauseBtnhms",
					stopButton : "stopBtnhms"
                                    });
                               }
</script>
  <script src="{{ url('assets/js/test.js') }}"></script>
		  <script>
            var examWizard = $.fn.examWizard({
                finishOption: {
                    enableModal: true,
                },
                quickAccessOption: {
                    quickAccessPagerItem: 9,
                },
            });
			
        </script>
@endsection


