<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="row">
<div class="container">
<div class="col-md-12">
<h1 class="text-center"style="text-transform: capitalize;">{{ $QuestionInstructions['school_name'] }}</h1>
<p>Class: {{ $QuestionInstructions['class_id'] }}</p>
<p class="text-right">Date: {{ $QuestionInstructions['date'] }}</p>
<p class="text-right">Marks: {{ $QuestionInstructions['marks'] }}</p>
<p class="text-right">Hours: {{ $QuestionInstructions['hours'] }}</p>
<b>Instructions: {{ $QuestionInstructions['instructions'] }}</b>
<hr>
@foreach($chapterQuestions as $key=>$value)
		<?php $segregation_id= $value->segregation_id; ?>
			 <h3> {{ $segregation_name= $value->segregation }}</h3> 
			<hr>
			<?php $questions= getpreperationQuestionStored($id,$segregation_id) ; ?>
			@foreach($questions as $qkey=>$q)
				
				<p> {!! $q->question_name !!}</p>
				@if($q->answer_option)
				@foreach(unserialize($q->answer_option) as $key2 => $Que)
                          <span> <b>(*)</b> {{ $Que }} </span>
				@endforeach
				@endif
			@endforeach
			<hr>
		@endforeach
</div>
</div>
</div>
