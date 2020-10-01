<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
input.btn.btn-primary.storeautomaticQuestions {
    margin-top: 53px;
}
</style>
{{-- <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script> --}}
<meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
<div class="table-responsive">
{!! Form::open(['url' => route('AutomaticQuestionStore'),'method' => 'post','class'=>'form-validate-jquery','data-parsley-validate','name'=>'form2','role'=>'form','id'=>'form2']) !!}
<input type="hidden"name="blue_print_name"value="{{ $blue_print_name }}">
<input type="hidden"name="preparation_type_id"value="{{ $preparation_type_id }}">
<input type="hidden"name="class"value="{{ $class }}">
<input type="hidden"name="subject"value="{{ $subject_details }}">
<input type="hidden"name="creating_type"value="{{ $creating_type }}">
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
            <?php $totalQuestion = 0; $totalMark = 0; ?>
                <tr>
                    <td>{{ $Question->Chapter->unit_name }}</td>
                    @foreach ($segregations as $key=>$segregation)
					
                        @foreach ($PreparationTypes as $key=>$PreparationType)
                            <?php $counts = getpreperationQuestionCount($Question->chapter_id,$segregation->id,$PreparationType->id); ?>
                            <?php  $totalMark += getQuestionTotal($counts,$segregation->QuestionTypes->question_type); ?>
                            <td class="text-center Quention">
								<input type="hidden"value="{{ $counts * $segregation->QuestionTypes->question_type }}"class="form-control chapter_{{$Question->Chapter->id}}" id="scheduledmark{{$Question->Chapter->id}}{{$segregation->id}}{{$PreparationType->id}}">
                                <input type="number"style="width:50px"class="form-control" value="{{ $counts }}" minlength="0" data-id="{{ $counts }}" data-mark="{{ $segregation->QuestionTypes->question_type }}"  disabled>
                                &nbsp;<input type="number"style="width:50px" class="form-control qty1 countQuestionValue{{ $Questionkey }} input_segregation{{ $segregation->id }}" name="questions[{{ $Question->chapter_id }}][{{ $segregation->id }}][{{ $PreparationType->id }}]" value="{{ $counts }}"  data-id="{{ $counts }}"data-chapter_name="{{$Question->Chapter->unit_name}}"data-chapter_id="{{$Question->Chapter->id}}"data-preperation_id="{{ $PreparationType->id }}"data-segregation_id="{{ $segregation->id }}" data-mark="{{ $segregation->QuestionTypes->question_type }}" required>
                                <span class="ErrorMessage" style="color: red"></span>
                            </td>
                            <?php $totalQuestion += $counts;?>
                        @endforeach
                    @endforeach
                    <td><b>{{ $totalMark }}</b><br><br><span class="questionCount{{ $Question->Chapter->id }}"><b>{{ $totalMark }}</b></span></td>
                </tr>
            @endforeach
        </tbody>
    </table>
	<div class="row">
	<div class="col-md-6">
	 <table class="table table-custom">
	 <thead>
	 <tr>
	 <th>Type</th>
	 <th>Count</th>
	 <th>Mark</th>
	 </tr>
	 </thead>
	
	 <tbody class="all_segregation_counts"style="display:none">
	 @foreach ($segregations as $key=>$segregation)
	 <tr>
	 <td >{{ $segregation->segregation }}</td>
	 <td class="segregation_total_question{{ $segregation->id }}">0</td>
	 <td class="segregation_total_marks{{ $segregation->id }} segregationquestioncount">0</td>
	 
	  </tr>
	 @endforeach
	 <tr>
	 <td colspan="1">Total Marks</td><td></td><td class="grandTotal_marks">0</td>
	 </tr>
	 </tbody>
	 </table>
	 </div>
	  <div class="col-md-6">
	 <input type="submit"name="storeautomaticQuestions"class="btn btn-primary storeautomaticQuestions"value="StoreQuestions">
	 </div>
	 </div>
	 <div class="row">
	
	 </div>
	 </form>
</div>

{{-- <span><b>Total Questions : {{ $totalQuestion }}</b></span> --}}

<script>
    $(document).on("keyup", ".qty1", function() {
        var sum = 0;
        $('.qty1').each(function(){
			var dataMark = $(this).attr('data-mark');
            sum += parseFloat(this.value) * dataMark;
            // var CurrentValue = $('.qty1').val();
            
            console.log(parseFloat(this.value) * dataMark);
            // sum += parseFloat(dataMark) * parseFloat(CurrentValue);  // Or this.innerHTML, this.innerText
        });
        $('.questionCount').html(sum);
    });
    $(document).ready(function(){
        $(".Quention input").on("keyup", function(){
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
            $('.questionCount').html(questionCount);
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
</script>
