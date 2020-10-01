@extends('layouts.master')

@section('automatic_question_view')
active
@endsection

@section('automatic_question_menu')
active open
@endsection

@section('content')
<style>
.automaticdatas {
    overflow-x: auto;
}
</style>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Edit Blueprint</h1>
                        </div>
                        <!-- /tile header -->
<?php  foreach($Questions as $q){
	// $id= $q['id'];
	// $name= $q['name'];
	// $preparation_type= $q['preparation_type'];
}?>
                        <!-- tile body -->
                        <div class="tile-body">
                            {!! Form::model($AutomaticQuestions,['url' => route('AutomaticQuestionUpdate',$AutomaticQuestions->id),'method' => 'POST','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                @csrf
                {{-- {{ method_field('PUT') }} --}}
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'BluePrint Name') !!}
      							<input type="text"name="blue_print_name"class="form-control blue_print_name"value="{{ $AutomaticQuestions->name }}"id="blue_print_name"required>
							</div>
                        </div>
						<div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Class') !!}
      							<input type="text"name="class"class="form-control class"value="{{ $class }}"id="class"disabled>
							</div>
                        </div>
						<div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Subject') !!}
      							<input type="text"name="subject"class="form-control subject"value="{{ $subject->subject_name }}"id="subject"disabled>
							</div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Get Question From <span class="text-danger">*</span></label>
                                <div>
                                    <label>
                                        <input type="radio"  name="preparation_type" value="0" {{ $AutomaticQuestions->preparation_type == 0 ? "checked" : "" }} class="preparation_type" onchange="getQuestionDetails(this.value)" disabled>
                                        All
                                    </label>
                                </div>
                                @foreach ($PreparationTypes as $PreparationType)
                                    <div>
                                        <label>
                                            <input type="radio" name="preparation_type" value="{{ $PreparationType->id }}" {{ $AutomaticQuestions->preparation_type == $PreparationType->id ? "checked" : "" }} class="preparation_type" onchange="getQuestionDetails(this.value)" disabled>
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

                    {{-- <div class="appendQuestionDetails"></div> --}}

                    <div class="table-responsive automaticdatas">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th rowspan="2">Chapter Name</th>
                                    @foreach ($segregations as $key=>$segregation)
                                        <th colspan="{{ $PreparationTypeCount }}" class="text-center">{{ $segregation->segregation }}</th>
                                    @endforeach
                                    <th rowspan="2">Marks</th>
                                </tr>
                                <tr>
                                    @foreach ($segregations as $key=>$segregation)
                                        @foreach ($PreparationTypes as $key=>$PreparationType)
                                            <th class="text-center">{{ $PreparationType->preparation_type }}</th>
                                        @endforeach
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Questions as $Questionkey=>$Question)
                                <?php $totalQuestion = 0; $totalMark = 0;
                                 $ChaterDetail = getQuestionChaptrs($AutomaticQuestions->id,$Question->chapter_id);
                                ?>
                                    <tr>
                                        <td><input type="hidden" name="chapter[chapter_id][]" value="{{ isset($ChaterDetail) ? $ChaterDetail->id : Null }}">{{ $Question->Chapter->unit_name }}</td>
                                        @foreach ($segregations as $key=>$segregation)
                                            @foreach ($PreparationTypes as $key=>$PreparationType)
                                                <?php
                                                    $counts = getpreperationQuestionCount($Question->chapter_id,$segregation->id,$PreparationType->id);
                                                    $StoredCount = getpreperationAutomaticQuestionStoredCount($Question->chapter_id,$segregation->id,$PreparationType->id);
                                                    $totalMark += getQuestionTotal($counts,$segregation->QuestionTypes->question_type);
                                                    // $totalMark += 1
													// print_r($StoredCount);
                                                ?>
                                                <td class="gallery">
												   {{-- {{ isset($StoredCount) ? $StoredCount : 0 }} --}}
                                                    <input type="text"style="width:50px" value="{{ $counts }}" minlength="0" data-id="{{ $counts }}" data-mark="{{ $segregation->QuestionTypes->question_type }}" maxlength="{{ $counts }}"class="form-control"id="scheduledmark{{$Question->Chapter->id}}{{$segregation->id}}{{$PreparationType->id}}"disabled>
                                                    <input type="hidden"class="form-control" value="{{ isset($StoredCount) ? $StoredCount->id : "" }}" name="question[question_id][]" minlength="0" data-id="{{ $counts }}" data-mark="{{ $segregation->QuestionTypes->question_types }}" maxlength="{{ $counts }}">
                                                    &nbsp;<input type="number"style="width:50px" class="form-control countQuestionValue{{ $Questionkey }}" name="questions[{{ $Question->chapter_id }}][{{ $segregation->id }}][{{ $PreparationType->id }}]" value="{{ isset($StoredCount) ? $StoredCount->question_count : $counts }}" minlength="0" data-id="{{ $counts }}"data-chapter_name="{{$Question->Chapter->unit_name}}"data-chapter_id="{{$Question->Chapter->id}}"data-preperation_id="{{ $PreparationType->id }}"data-segregation_id="{{ $segregation->id }}" data-mark="{{ $segregation->QuestionTypes->question_type }}" maxlength="{{ $counts }}" required>
                                                    <span class="ErrorMessage" style="color: red"></span>
                                                </td>
                                                <?php $totalQuestion += $counts;?>
                                            @endforeach
                                        @endforeach
                                       <td><b>{{ $totalMark }}</b><br><br><span class="questionCount{{ $Question->Chapter->id }}"><b></b></span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </fieldset>
                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                    <button type="submit" class="btn btn-primary FormSubmit">Submit</button>
                </div>
            {!! Form::close() !!}
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
        $(".gallery input").on("keyup", function(){
			$('.all_segregation_counts').show();
            var chapter_name = $(this).data("chapter_name");            
            var chapter_id = $(this).data("chapter_id");  
		
            var segregation_id = $(this).data("segregation_id");
			var preperation_id = $(this).data("preperation_id");
            var dataId = $(this).attr("data-id");
            var dataMark = $(this).attr("data-mark");
            var currentValue = $(this).val();
            var questionCount = dataMark * currentValue;
			$('#scheduledmark'+chapter_id+segregation_id+preperation_id).val(questionCount);
			
            if(currentValue > dataId){
                $(this).next().text("This is crossed the Maximum value of "+dataId);
                $('.FormSubmit').hide();
            }else{
			var chaptersum = 0;
			var total_segregation = 0;
			$(".chapter_"+chapter_id).each(function(){
			chaptersum += parseFloat($(this).val());
			});
			$('.questionCount'+chapter_id).text(chaptersum);
            // $('.questionCount').html(questionCount);
			$(".input_segregation"+segregation_id).each(function(){
			total_segregation += parseFloat($(this).val());
			});
			
			$('.segregation_total_question'+segregation_id).text(total_segregation);
			$('.segregation_total_marks'+segregation_id).text(total_segregation * dataMark);
			var sum = 0;
			var get_segregation_id = "<?php  foreach ($segregations as $key=>$segregation) { $segregation_ids=$segregation->id ;$dynamic_data_marks=$segregation->QuestionTypes->question_type?>";
				dynamic_segregation_id = "<?php echo $segregation_ids; ?>";
				dynamic_data_marks = "<?php echo $dynamic_data_marks; ?>";
				var total_segregation = 0;
			$(".chapter_"+chapter_id).each(function(){
			sum += parseFloat($(this).val());
			});
			$(".input_segregation"+dynamic_segregation_id).each(function(){
			total_segregation += parseFloat($(this).val());
			});
			$('.segregation_total_question'+dynamic_segregation_id).text(total_segregation);
			$('.segregation_total_marks'+dynamic_segregation_id).text(total_segregation * dynamic_data_marks);
			get_segregation_id = "<?php } ?>" ;
			var grandTotal = 0;
			$(".segregationquestioncount").each(function(){
			grandTotal += parseFloat($(this).text());
			});
			$('.grandTotal_marks').text(grandTotal);
						
                $(this).next().text("");
                $('.FormSubmit').show();
            }
        });
    });
        </script>
@endsection

