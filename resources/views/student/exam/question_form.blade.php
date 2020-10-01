
          
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
						<input type="hidden"name="Exam_id"value="{{$Exam_id}}">
						<input type='hidden'name='question_id'id="question_id"value="{{ $que['q_id'] }}">
						<?php  $answered=checkAnswered($que['q_id'],$Exam_id); ?>
                        
                        @if($que['segregation_id']==1)
							
			<p class="trueorfalseoptions"><input type="radio"name="answer"class="answer"value="true"<?php if($answered['studentanswer']=="true"){echo "checked"; } ?> required >True &nbsp
			<input type="radio"name="answer"class="answer"value="false"<?php if($answered['studentanswer']=="false"){echo "checked"; } ?> required >False</p>
			@endif
			<?php if(!empty($que['answer_option'])) {
				foreach(unserialize($que['answer_option']) as $key2 => $Que){
					echo "<p>".$key2.")".$Que."</p>";
				}
			}elseif($que['segregation_id'] != 1 && $que['segregation_id'] != 2){ ?>
				<p class="submitanswer"><textarea class='ckeditor'class="answer"name='answer'required></textarea></p>
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

        <!-- Footer -->
		
		 