@extends('layouts.master')

@section('chapeter_questions')
active
@endsection

@section('chapterbsed_question_menu')
active open
@endsection

@section('content')

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
            <form action="#" id="ChapterBasedQuestionForm" method="get" class="form-validate-jquery ChapterBasedQuestionForm" data-parsley-validate name="form2" role="form">
                @csrf
                <fieldset>
                    <div class="row">
                        <div class="col-lg-12">
                            <h4>Chapter Based Question for "{{ $Chapters->unit_name }}"</h4>
                        </div>
                        <div class="col-lg-4">
						<input type="hidden"class="class_id"id="class_id"name="class_id"value="{{$class_id}}">
                            <div class="form-group">
                                {!! Form::label('name', 'Pattern Prefix') !!}
                                {!! Form::text('pattern_prefix',null, ['class' => 'form-control pattern_prefix','placeholder'=>'Pattern Prefix','id'=>'pattern_prefix','required'=>'required']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>Question Type</th>
                                            <th>Available</th>
                                            <th>Allocation</th>
                                            <th>Mark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <input type="hidden" value="{{ $Chapters->id }}" name="chapter_id">
                                        @foreach ($Segregations as $Segregation)
                                        <?php $count = getChapterWiseSegregationCount($Chapters->id,$Segregation->id) ?>
                                            <tr>
                                                <td>{{ $Segregation->segregation }}</td>
                                                <td><input type="text" name="chapter_question[available][{{ $Segregation->id }}]" data-id="{{ $count }}" data-mark="{{ $Segregation->QuestionTypes->question_type }}" value="{{ $count }}" id="" class="form-control" readonly></td>
                                                <td class="text-center Quention">
                                                    <input type="text" name="chapter_question[allocation][{{ $Segregation->id }}]" data-id="{{ $count }}" data-mark="{{ $Segregation->QuestionTypes->question_type }}" value="0" id="" class="form-control CalculateTotal CurrentValue">
                                                    <span class="ErrorMessage" style="color: red"></span>
                                                </td>
                                                <td><input type="text" name="chapter_question[marks][{{ $Segregation->id }}]" id="" value="0" class="form-control CalculateTotal TotalSegregationMark" readonly></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <h5 class="text-right">Total Mark : <span class="TotalMark"></span></h5>
                    </div>
                </fieldset>
                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                    <button type="submit" class="btn btn-primary CreateQuestion" >Create</button>
                </div>

               
            {!! Form::close() !!}
			
			 
			 
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
        $('.CreateQuestion').on('click',function (e) {
            // $("#ChapterBasedQuestionForm")[0].reset();
            var form = $( "#ChapterBasedQuestionForm" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "get",
                    url: "{{ route('prepareQuestion') }}",
                    data:$('#ChapterBasedQuestionForm').serialize(),
                    success: function(data) {
                        $('.AppendQuestion').html(data);
                    }
                });
            }
        });
</script>
@endsection

