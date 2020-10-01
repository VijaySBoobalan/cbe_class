<style>

.list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
}
.list-inline>li {
    display: inline-block;
    padding-right: 5px;
    padding-left: 5px;
}
.regno li {
    border: 1px solid #333;
    margin-right: -4px;
    height: 30px;
    width: 30px;
}
p.parent_questions {
    margin-left: 34px;
}
b.text-center.operator {
    margin-left: 496px;
}
p.segregation-name {
    font-size: 26px;
    margin-bottom: -30px;
    background: #f3e2e2;
}
p.text-center.submit-btns {
    padding-top: 22px;
	position: -webkit-sticky; /* Safari & IE */
position: sticky;
top: 30px;
}
.marks {
    padding-right: 22px;
   
}
a.btn.btn-sm.btn-primary.addnewQuestion {
    height: 27px;
    width: 53px;
}
a.btn.btn-sm.btn-danger.ReplaceQuestion {
    height: 27px;
    width: 53px;
}
span.question-btns {
    padding-right: 15px;
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


    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: ##bfbdbd;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
      background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
	
	button.tablinks {
    font-size: smaller;
}
.row.toptabs {
    margin-top: 10px;
}
p.topQuestionanswrs {
    font-size: xx-large;
    text-align: center;
}
input.btn.btn-primary.and {
    background: #51445f;
	border-radius: 50px !important;
}

input.btn.btn-success.or {
    background: #bdc3c2;
	border-radius: 50px !important;
}
input.btn.btn-danger.reset {
    background: black;
	border-radius: 50px !important;
}
.header_section {
    border: 1px solid black;
    height: 117px;
}



.rowsection{
	line-height:<?php echo $QuestionPaperUi->line_spacing."px;"  ?>
}

.questionname{
		line-height:<?php echo $QuestionPaperUi->question_spacing."px;";  ?>
}
.everydetails{
	font-family:<?php echo $QuestionPaperUi->font_family.";";  ?>
	font-size:<?php  echo $QuestionPaperUi->font_size."px;"; ?>
} 
</style>      

	  <div class="tile-body everydetails">
				<div class="table-responsive">
					<div class="header_section">
						 <div class="row rowsection">
							<div class="col-md-4">
							</div>
                            <div class="col-md-4 exam_name">
							<label class="<?php echo $QuestionPaperUi->hideexamname;?>">{{ $PaperDetails->exam_name }}</label>
							
                            </div>
							<div class="col-md-4 marks">
							<label class="<?php echo $QuestionPaperUi->hidemarks;  ?>"style="float:right">Marks: {{ $PaperDetails->marks }} </label>
							</div>
						 </div>
						
						 <div class="row rowsection">
							<input type="hidden"name="blueprint_id"value="{{$PaperDetails->blue_print_name}}"id="blueprint_id">
							<input type="hidden"name="question_paper_id"value="{{$PaperDetails->id}}"id="question_paper_id">
							<div class="col-md-4 time">
								<label class="<?php echo $QuestionPaperUi->hidedate;  ?>">Exam Time: {{ $PaperDetails->exam_time }}</label>
								
							</div>
							<div class="col-md-4 subject">
								<label class="<?php echo $QuestionPaperUi->hidesubject;  ?>">Subject: {{ $PaperDetails->subject }}</label>
							</div>
							<div class="col-md-4 regno">
								<div class="regno-container">
									<div class="regno text-right">
										<ul class="list-unstyled list-inline <?php echo $QuestionPaperUi->hideregno;  ?>">
											Reg.No. :
											<li>&nbsp;</li>
											<li>&nbsp;</li>
											<li>&nbsp;</li>
											<li>&nbsp;</li>
											<li>&nbsp;</li>
											<li>&nbsp;</li>
										</ul>
									</div>
								</div>
							</div>
							
						  </div>
				</div>
	

					
						 
							
							  
							 <div id="Questions"style="display: block;" class="tabcontent">
							 <button onclick="printDiv(1)" class="btn btn-default float:right">Print</button>
			<form action="{{ route('Previewedit') }}" id="GetExamQuestions" method="get" class="form-validate-jquery" data-parsley-validate name="form2" role="form">
					<p class="text-center submit-btns"><input type="submit"value="AND"name="submit"class="btn btn-primary and">&nbsp <input type="submit"value="OR"name="submit"class="btn btn-success or">&nbsp <input type="submit"value="RESET"name="submit"class="btn btn-danger reset"></p>
					<input type="hidden"id="paper_id"name="paper_id"value="{{ $PaperDetails->id }}">
						@foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label><div class="marks"style="float:right">{{ $segregations['count'] }} * {{ $segregations['question_type_id']}} = {{ $segregations['count'] * $segregations['question_type_id'] }}</div></p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="questionname parent_questions">A <span>). </span>	<input type="checkbox"class="mark_question"name="row_id[{{$questions['row_id']}}]"value="{{$questions['row_id']}}">							
							<?php  echo strip_tags($questions['question_name']) ; ?>
							<span class="question-btns"style="float:right"> <a href="#"class="btn btn-sm btn-danger ReplaceQuestion" data-toggle="modal" data-target="#QuestionsList" data-chapter_id="{{$questions['chapter_id']}}" data-segrigation_id="{{$questions['segregation_id']}}" data-question_id="{{ $questions['question_id'] }}" data-row_id="{{ $questions['row_id'] }}">Replace</a></span>
							</p>
							<p class="text-center operator">( {{$questions['type']}} )</p> 
									@foreach(unserialize($questions['parent_question_id']) as $parentQids)
									
									<?php 	$parentquestions=getParentQuestions($parentQids);?>
										@foreach($parentquestions as $parentkey=>$parentquestions)
										<?php  $alphabets=returnAlphabets(++$parentkey);?>
										<p class="questionname parent_questions">{{$alphabets}} ).<input type="checkbox"class="mark_question"name="parent_row_id[{{$questions['row_id']}}]"value="{{$questions['row_id']}}">						
							<?php  echo strip_tags($parentquestions['question_name']) ; ?>
								<span class="question-btns"style="float:right"><a href="#"class="btn btn-sm btn-danger ReplaceQuestion" data-toggle="modal" data-target="#QuestionsList" data-chapter_id="{{$parentquestions['chapter_id']}}" data-segrigation_id="{{$parentquestions['segregation_id']}}" data-question_id="{{ $parentquestions['id'] }}" data-row_id="{{ $questions['row_id'] }}">Replace</a></span>
							</p>
							
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p class="questionname">{{++$qkey}} <span>). </span> 	<input type="checkbox"class="mark_question"name="row_id[{{$questions['row_id']}}]"value="{{$questions['row_id']}}">							
							<?php  echo strip_tags($questions['question_name']) ; ?>
							<span class="question-btns"style="float:right"><a href="#"class="btn btn-sm btn-primary addnewQuestion"data-toggle="modal" data-target="#QuestionsList"data-chapter_id="{{$questions['chapter_id']}}" data-row_id="{{ $questions['row_id'] }}" data-Qid="{{$questions['question_id']}}" data-segrigation_id="{{ $segregations['id'] }}">Add</a> <a href="#"class="btn btn-sm btn-danger ReplaceQuestion" data-toggle="modal" data-target="#QuestionsList" data-row_id="{{ $questions['row_id'] }}" data-chapter_id="{{$questions['chapter_id']}}" data-question_id="{{ $questions['question_id'] }}" data-segrigation_id="{{ $segregations['id'] }}">Replace</a></span>
							</p>
								<?php } ?>

							<?php 
								if(!empty($questions['answer_option'])) {
								foreach(unserialize($questions['answer_option']) as $key2 => $Que){ ?>
								<span style="margin-left:50px">  {{++$key2}} ).</span>         <?php echo strip_tags($Que) ;
									} 
								}
									?> 
			 					
							@endforeach
						</div>
						 @endforeach
						
						</form>
						 </div> <!-- tab1 close -->
						 
						 
						 <div id="AnswerKey" class="tabcontent">
						  <button onclick="printDiv(2)" class="btn btn-default float:right">Print</button>
							@foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label><div class="marks"style="float:right">{{ $segregations['count'] }} * {{ $segregations['question_type_id']}} = {{ $segregations['count'] * $segregations['question_type_id'] }}</div></p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="parent_questions">A <span>). </span>			
							<?php  //echo strip_tags($questions['question_name']) ; ?>
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
							<p class="text-center operator">( {{$questions['type']}} )</p> 
									@foreach(unserialize($questions['parent_question_id']) as $parentQids)
									
									<?php 	$parentquestions=getParentQuestions($parentQids);?>
										@foreach($parentquestions as $parentkey=>$parentquestions)
										<?php  $alphabets=returnAlphabets(++$parentkey);?>
										<p class="parent_questions">{{$alphabets}} )	
							<?php  //echo strip_tags($parentquestions['question_name']) ; ?>
							<?php foreach(unserialize($parentquestions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
								</p>
							
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p>{{++$qkey}} <span>). </span> 	
							<?php // echo strip_tags($questions['question_name']) ; ?>
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
								<?php } ?>

							
			 					
							@endforeach
						</div>
						 @endforeach
							 </div>
							 
							 
							 <div id="QuestionWithAnswers" class="tabcontent">
							  <button onclick="printDiv(3)" class="btn btn-default float:right">Print</button>
							@foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label><div class="marks"style="float:right">{{ $segregations['count'] }} * {{ $segregations['question_type_id']}} = {{ $segregations['count'] * $segregations['question_type_id'] }}</div></p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="parent_questions">A <span>). </span>	
								<?php  echo strip_tags($questions['question_name']) ; ?>
							</p>
							<p>Answer:
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
							<p class="text-center operator">( {{$questions['type']}} )</p> 
									@foreach(unserialize($questions['parent_question_id']) as $parentQids)
									
									<?php 	$parentquestions=getParentQuestions($parentQids);?>
										@foreach($parentquestions as $parentkey=>$parentquestions)
										<?php  $alphabets=returnAlphabets(++$parentkey);?>
										<p class="parent_questions">{{$alphabets}} ).	
							<?php  echo strip_tags($parentquestions['question_name']) ; ?>
								</p>
							<p>Answer:
							<?php foreach(unserialize($parentquestions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p>{{++$qkey}} <span>). </span> 			
							<?php  echo strip_tags($questions['question_name']) ; ?>
							</p>
							<p>Answer:
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
								<?php } ?>

							<?php 
								if(!empty($questions['answer_option'])) {
								foreach(unserialize($questions['answer_option']) as $key2 => $Que){ ?>
								<span style="margin-left:50px">  {{++$key2}} ).</span>         <?php echo strip_tags($Que) ;
									} 
								}
									?> 
			 					
							@endforeach
						</div>
						 @endforeach
							 </div>
							 <div id="QuestionWithAnswersInFinal" class="tabcontent">
							  <button onclick="printDiv(4)"class="btn btn-default float:right">Print</button>
						<p class="topQuestionanswrs">Questions</p>
						@foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label><div class="marks"style="float:right">{{ $segregations['count'] }} * {{ $segregations['question_type_id']}} = {{ $segregations['count'] * $segregations['question_type_id'] }}</div></p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="parent_questions">A <span>). </span>	<?php  echo strip_tags($questions['question_name']) ; ?>
							</p>
							<p class="text-center operator">( {{$questions['type']}} )</p> 
									@foreach(unserialize($questions['parent_question_id']) as $parentQids)
									
									<?php 	$parentquestions=getParentQuestions($parentQids);?>
										@foreach($parentquestions as $parentkey=>$parentquestions)
										<?php  $alphabets=returnAlphabets(++$parentkey);?>
										<p class="parent_questions">{{$alphabets}} ).<?php  echo strip_tags($parentquestions['question_name']) ; ?>
								</p>
							
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p>{{++$qkey}} <span>). </span> <?php  echo strip_tags($questions['question_name']) ; ?>
							</p>
								<?php } ?>

							<?php 
								if(!empty($questions['answer_option'])) {
								foreach(unserialize($questions['answer_option']) as $key2 => $Que){ ?>
								<span style="margin-left:50px">  {{++$key2}} ).</span>         <?php echo strip_tags($Que) ;
									} 
								}
									?> 
			 					
							@endforeach
						</div>
						 @endforeach
						<p class="topQuestionanswrs">Answers</p>
							@foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label><div class="marks"style="float:right">{{ $segregations['count'] }} * {{ $segregations['question_type_id']}} = {{ $segregations['count'] * $segregations['question_type_id'] }}</div></p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="parent_questions">A <span>). </span>			
							<?php  //echo strip_tags($questions['question_name']) ; ?>
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
							<p class="text-center operator">( {{$questions['type']}} )</p> 
									@foreach(unserialize($questions['parent_question_id']) as $parentQids)
									
									<?php 	$parentquestions=getParentQuestions($parentQids);?>
										@foreach($parentquestions as $parentkey=>$parentquestions)
										<?php  $alphabets=returnAlphabets(++$parentkey);?>
										<p class="parent_questions">{{$alphabets}} )	
							<?php  //echo strip_tags($parentquestions['question_name']) ; ?>
							<?php foreach(unserialize($parentquestions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
								</p>
							
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p>{{++$qkey}} <span>). </span> 	
							<?php // echo strip_tags($questions['question_name']) ; ?>
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
									echo strip_tags($answer) ;
									 
									 } ?> 
							</p>
								<?php } ?>

							
			 					
							@endforeach
						</div>
						 @endforeach
							 </div>
                        </div>
                        </div>
                        <!-- /tile body -->