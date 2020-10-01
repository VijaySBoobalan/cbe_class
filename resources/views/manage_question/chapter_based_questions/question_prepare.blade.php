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
.dynamic_questions {
    width: 90%;
}
.header_sections {
    width: 90%;
}
</style>

<?php $loop = 1; 
use App\ChapterBasedQuestion;
use App\ChapterBasedQuestionDetails;
$ChapterBasedQuestions =new ChapterBasedQuestion;
		$ChapterBasedQuestions->pattern_prefix =$pattern_prefix;
		$ChapterBasedQuestions->class_id =$class_id;
		$ChapterBasedQuestions->chapter_id =$chapter_id;
		
		$ChapterBasedQuestions->save();

?>
<div class="container">
<div class="col-md-12">
		

				<form id="Question_instructions">
				<div class="header_sections">
				<div class="row">
				<div class="col-md-4">
				</div>
				<div class="col-md-4 schoolname">
                            <div class="form-group">
							 {!! Form::label('name', 'School Name') !!}
                               <input type="hidden"name="chapter_question_id"id="chapter_question_id"value="{{ $ChapterBasedQuestions->id }}">
                                {!! Form::text('schoolname',null, ['class' => 'form-control schoolname','placeholder'=>'School Name','id'=>'schoolname','required'=>'required']) !!}
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
                                                    <input type="text"name="date"class="form-control"value="">  
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
                                {!! Form::text('hours',null, ['class' => 'form-control hours','placeholder'=>'hours','id'=>'hours','required'=>'required']) !!}
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-4 marks">
                            <div class="form-group">
                                  {!! Form::label('name', 'Marks') !!}
                                {!! Form::text('marks',null, ['class' => 'form-control marks','placeholder'=>'Marks','id'=>'marks','required'=>'required']) !!}
                            </div>
                        </div>
						<div class="col-md-4">
						</div>
						<div class="col-md-4 class">
                                            <div class="form-group">
                                                 {!! Form::label('name', 'Class') !!}
                                                <select class="form-control chosen-select"name="class_id"id="class_id">
												@foreach($ClassSection as $class)
											<option value="{{ $class['class'] }}">{{ $class['class'] }}</option>
											@endforeach
                                            </select>
											</div>
                        </div>
						
						
					</div>
					<div class="row">
						<div class="col-md-4 instructions">
                            <div class="form-group">
                                {!! Form::label('name', 'Instructions') !!}
								<textarea class="form-control"placeholder="Instructions"name="instructions"id="instructions"></textarea>
							  </div>
                        </div>
						
                        </div>
                
				
				</div>
				

		
	
<div class="dynamic_questions">
@foreach ($chapter_questions['available'] as $key=>$chapter_question)
<div class="dynsegregations">
    @if($chapter_questions['allocation'][$key] != 0)
        <?php $Question = getChapterBasedQuestion($chapter_question,$chapter_questions['allocation'][$key],$chapter_id,$key); ?>
		
	   <h4>{{ $Question['Segregation']->segregation }}</h4><hr>
	<?php	$segregation_id=$Question['Segregation']->id ;?>
        @foreach ($Question['questionNumbers'] as $keys => $value)
            @foreach($Question['Questions'] as $key1 => $Ques)
                @if($value == $key1)
					<?php 
				$ChapterBasedQuestionDetails =new ChapterBasedQuestionDetails;
		$ChapterBasedQuestionDetails->chapter_based_question_id =$ChapterBasedQuestions->id;
		$ChapterBasedQuestionDetails->question_id =$Ques->id;
		$ChapterBasedQuestionDetails->segregation_id =$segregation_id;
		$ChapterBasedQuestionDetails->order_by =1;		
		$ChapterBasedQuestionDetails->save();
				?>
				
				<a data-chapter_id="{{ $chapter_id }}"data-chapterQuestionsid="{{ $ChapterBasedQuestions->id }}"data-row_id="{{ $ChapterBasedQuestionDetails->id }}"data-segregation_id="{{ $segregation_id }}"data-question_id="{{ $Ques->id }}"data-toggle="modal" data-target="#QuestionsList"class="btn btn-sm btn-success change_question"style="float:right">Change</a>
                    <P>{!! $Ques->question_name !!}</P>
					
					 
                    @isset($Ques->answer_option)
                        @foreach(unserialize($Ques->answer_option) as $key2 => $Que)
                            <span>{{!! ++$key2 !!}}.</span> {!! $Que !!}
                        @endforeach
                    @endisset
                @endif
            @endforeach
        @endforeach
    @endif
	</div>
@endforeach
	</div>
	<div class="newdyn">
	</div>
	<div class="row">
	<div class="col-md-4">
	</div>
	<div class="col-md-4">
                            <div class="form-group">
							<button type="submit" class="btn btn-primary FormSubmit">Submit</button>
							</div>
    </div>
    </div>
	</form>
	</div>
	</div>
<script>
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
					 $('.dynsegregations').remove();
					$('.newdyn').html(data);
                    }
                });
            });
</script>
