<style>
.segregations{
	font-size:24px;
}
</style>

<div class="col-md-12">
<div class="questions">
<input type="hidden"name="id"value="{{ $id }}">
<input type="hidden"name="exam_name"value="{{ $exam_name }}">
<input type="hidden"name="preperation_type_id"value="{{ $preperation_type_id }}">
<input type="hidden"name="question_from"value="{{ $question_from }}">
<input type="hidden"name="exam_time"value="{{ $exam_time }}">
	@foreach($SegregationQuestions as $key=>$Segregations)
		<input type="hidden"name="segregation[]"value="{{ $Segregations->id }}">
	<p class="segregations">{{$Segregations->segregation}}</p>
		@foreach($Segregations->questions as $key=>$questions)
		
		<p class="question_name"> &nbsp <label><input type="checkbox"name="questions[]"value="{{ $questions->id }}"></label> {{ strip_tags($questions->question_name) }}</p>
		@endforeach
	@endforeach
</div>
<div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                    <button type="submit" class="btn btn-primary StoreExam" >Store Exam</button>
                </div>
</div>