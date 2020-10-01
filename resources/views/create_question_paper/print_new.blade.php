<style>
.regno {
    position: absolute;
   top: -56px;
    right: 0px;
}
.regno-container {
    position: relative;
}
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
.headersection {
    border: 1px solid;
    padding-right: 10px;
    height: 200px;
}
span.segregation_name {
    font-size: 19px;
}
.row.main-notes {
    margin-left: 10px;
}
p.parent_questions {
    margin-left: 34px;
}
p.text-center.operator {
    margin-left: 496px;
}
.marks {
    float: right;
}
.subject {
    text-align: center;
	text-transform: capitalize;
	padding-bottom: 10px;
}
p.exam-name {
    text-align: center;
    /* font-size: 18px; */
    text-transform: capitalize;
}
p.school-name {
    text-align: center;
    text-transform: capitalize;
}
p.exam_time {
    /* text-align: right; */
    padding-left: 10px;
}
.date {
    padding-left: 10px;
}


.rowsection{
	line-height:<?php echo $QuestionPaperUi->line_spacing."px;"  ?>
}

.questionname{
		line-height:<?php echo $QuestionPaperUi->question_spacing."px;";  ?>
}
.details{
	font-family:<?php echo $QuestionPaperUi->font_family.";";  ?>
	font-size:<?php  echo $QuestionPaperUi->font_size."px;"; ?>
} 
</style>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
						 <div class="table-responsive">
						 <div class="headersection">
						 <div class="row rowsection">
						 <div class="date">
						 <?php echo "Date:". date('d-m-Y'); ?>
						 </div>
                            <div class="col-md-4">
							<p class="school-name">New syllabus 2019</p>
                            </div>
						<div class="col-md-4">
					<div class="regno-container">
						<div class="regno text-right">
							<ul class="list-unstyled list-inline">
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
						
						
						 
						<p class="exam-name">{{ $PaperDetails->exam_name }}</p>
						
						 <div class="row rowsection">
						
						 <div class="subject">
						{{ $PaperDetails->subject }}
						 </div>
						 
						  <div class="marks">
						<label>Marks:</label>
						{{ $PaperDetails->marks }}
						 </div>
						
						<p class="exam_time">Time:
						{{ $PaperDetails->exam_time }}</p>
						
						 </div>
						  <div class="row main-notes rowsection">
						 <p>Main Note:  <?php echo strip_tags($PaperDetails->main_note); ?></p>
						
						 </div>
						 </div>
						 <hr>
						 @if($value == 1)
					<div class="questionsonly">	
					 @foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label>&nbsp (Note:<?php echo strip_tags($segregations['segregation_notes']); ?>)</p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="parent_questions">A <span>). </span>						
							<?php  echo strip_tags($questions['question_name']) ; ?></p>
							<p class="text-center operator">( {{$questions['type']}} )</p> 
									@foreach(unserialize($questions['parent_question_id']) as $parentQids)
									
									<?php 	$parentquestions=getParentQuestions($parentQids);?>
										@foreach($parentquestions as $parentkey=>$parentquestions)
										<?php  $alphabets=returnAlphabets(++$parentkey);?>
										<p class="questionname parent_questions">{{$alphabets}} ).					
							<?php  echo strip_tags($parentquestions['question_name']) ; ?></p>
							
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p class="questionname">{{++$qkey}} <span>). </span> 				
							<?php  echo strip_tags($questions['question_name']) ; ?></p>
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
					@endif
					 @if($value == 2)
					<div class="answerskey">
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
										<p class="questionname parent_questions">{{$alphabets}} )	
							<?php  //echo strip_tags($parentquestions['question_name']) ; ?>
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
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
					@endif
					@if($value == 3)
					<div class="Questionanswerskey">
					@foreach($ExamQuestions as $key=>$segregations)
						<div class="details">
						<hr>
						 <p class="segregation-name"><label> {{ $segregations['segregation'] }} :</label><div class="marks"style="float:right">{{ $segregations['count'] }} * {{ $segregations['question_type_id']}} = {{ $segregations['count'] * $segregations['question_type_id'] }}</div></p>
						 <hr>
							@foreach($segregations['questions'] as $qkey=>$questions)
							
							
							
							
								<?php if(!empty($questions['type'])) { ?>
								<p>{{++$qkey}} <span>). </span>
								
								<p class="questionname parent_questions">A <span>). </span>	
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
										<p class="questionname parent_questions">{{$alphabets}} ).	
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
								<p class="questionname">{{++$qkey}} <span>). </span> 			
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
					@endif
					@if($value == 4)
					<div class="questionsTopAnswersBottom">
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
										<p class="questionname parent_questions">{{$alphabets}} ).<?php  echo strip_tags($parentquestions['question_name']) ; ?>
								</p>
							
										@endforeach
									@endforeach
							<?php  ?>
								
								<?php } else {?>
								<p class="questionname">{{++$qkey}} <span>). </span> <?php  echo strip_tags($questions['question_name']) ; ?>
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
								
								<p class="questionname parent_questions">A <span>). </span>			
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
										<p class="questionname parent_questions">{{$alphabets}} )	
							<?php  //echo strip_tags($parentquestions['question_name']) ; ?>
							<?php foreach(unserialize($questions['answer']) as $keyanswer => $answer) {
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
					@endif	
						 <hr>
						 <label>Footer Note</label>
						 {!! $PaperDetails->footer_note !!}
						 
						
                        </div>
                        </div>
                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>
    </section>




