@extends('layouts.master')

@section('create_question_paper')
active
@endsection

@section('question_paper_management')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Create Question Paper</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
               
                <form id="GetExamQuestions" method="get" class="form-validate-jquery GetExamQuestions" data-parsley-validate name="form2" role="form">
				@csrf
                <fieldset>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Exam Question Paper') !!}
                                {!! Form::text('exam_qp_name',null, ['class' => 'form-control exam_qp_name','placeholder'=>'Exam Question Paper Name','id'=>'exam_qp_name','required'=>'required']) !!}
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Get Question Type <span class="text-danger">*</span></label>
                               <select class="form-control get_ques_type"name="selected_type"id="selected_type">
                               <option value="manual">Manual</option>
                               <option value="auto">Automatic</option>
							   </select>
                              
                            </div>
                        </div>
						 <div class="col-lg-4">
                            <div class="form-group">
                                <label>Get Question From <span class="text-danger">*</span></label>
                                <div>
                                    <label>
                                        <input type="radio"  name="preperation_type" value="0" class="preperation_type"checked required>
                                        All
                                    </label>
                                </div>
                                @foreach ($PreparationTypes as $PreparationType)
                                    <div>
                                        <label>
                                            <input type="radio" name="preperation_type" value="{{ $PreparationType->id }}" class="preparation_type"  required>
                                            {{ $PreparationType->preparation_type }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
						 </div>
						  <div class="row">
						  <div class="col-lg-4 blueprints hide">
                            <div class="form-group">
                                <label>Blue Print Name<span class="text-danger">*</span></label>
                               <select class="form-control"name="blue_print_name">
							    <option></option>
                               @foreach($AutomaticQuestion as $key=>$blueprints)
							   <option value="{{ $blueprints->id }}">{{ $blueprints->name }}</option>
							   @endforeach
							   </select>
                              
                            </div>
                        </div>
						 <div class="col-lg-4">
                            <div class="form-group">
                                <label>Segregations Question Type <span class="text-danger">*</span></label>
								@foreach($QuestionTypes as $key=>$que)
								<div class="checkbox">
								<label><input type="checkbox"name="question_types[{{ $que->id }}]"id="segregation_id{{ $que->id }}"onclick="one_mark_type({{ $que->id }})" value="{{ $que->id }}"checked>{{ $que->question_name }}</label>
								</div>
								<div class="marks_{{ $que->id }} hide">
								@foreach($que->segregations as $segkey=>$seg)
								<div class="checkbox segregations">
								<label style="margin-left:50px"><input type="checkbox"class="questionmarks[{{ $que->id }}]"name="segregations[{{ $seg->id }}]" value="{{ $seg->id }}"checked>{{ $seg->segregation }}</label>
								</div>
								@endforeach
								</div>
                              @endforeach
                            </div>
                        </div>
                        </div>
						<div class="col-lg-4">
                        <table class="table">
                        <thead>
                        <tr>
                        <th><label><input id="all"type="checkbox"checked>All</label></th>
                        <th>Chapter Name</th>
						</tr>
						</thead>
						<tbody>
						@foreach($chapters as $key=>$chapter)
						<tr>
						<td><label><input type="checkbox"name="chapters[{{ $chapter->id }}]"value="{{ $chapter->id }}"class="chapters_list"checked></label></td>
						<td>{{ $chapter->unit_name }}</td>
						</tr>
						@endforeach
						</tbody>
						</table>
						</div>
                    

                    

                </fieldset>
                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                    <button type="submit" class="btn btn-primary GetQuestions" >Get Questions</button>
                </div>
            {!! Form::close() !!}
                         <div class="appendQuestionDetails"></div> 
                        </div>
                        <!-- /tile body -->
                       
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
   
    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
         
		});
		    $('.GetQuestions').on('click',function (e) {
				
            if($('#selected_type').val()=="auto"){
			var	route="{{ route('GetAutomaticQuestions') }}";
			}else{
			var	route="{{ route('GetManualQuestions') }}";
			}
            var form = $( "#GetExamQuestions" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "get",
                    url: route,
                    data:$('#GetExamQuestions').serialize(),
                    success: function(data) {
						console.log(data);
						// alert(data);
                        // $('.appendQuestionDetails').html(data);
						 if(data.status == 'error'){
							toastr.error(data.message);        
                        }else{
							toastr.success(data.message);
							var route='{{ url("question-paper-store") }}/'+data.id;
							window.location.href = route;
                          
                        }
                    }
                });
            }
			
        });
			// $('.StoreQuestions').on('click',function (e) {
		$('body').on('click','.StoreQuestions',function (e) {
            var form = $( "#StoreQuestions" );
            form.validate();
            e.preventDefault();
            var checkValid = form.valid();
            if(checkValid == true){
                $.ajax({
                    type: "post",
                    url: '{{ route('ShowQuestions') }}',
                    data:$('#StoreQuestions').serialize(),
                    success: function(data) {
						 if(data.status == 'error'){
							toastr.error(data.message);
                           
                        }else{
							toastr.success(data.message);
				// var route = 'question-paper-preview';
				var route='{{ url("question-paper-store") }}/'+data.id;

                window.location.href = route;
                          
                        }
                    }
                });
            }
        });
		function one_mark_type(mrk_value)
	{
		if($('#segregation_id'+mrk_value).is(':checked'))
		{
			$('.marks_'+mrk_value).removeClass("hide");
			// $("input:checkbox"+".questionmarks"+mrk_value).prop('checked',this.checked);
		}
		else
		{
			$('.marks_'+mrk_value).addClass('hide');
		}	
	}
	
		$('.get_ques_type').on('change', function (e) {
		var value = $(this).val();
		if(value == 'manual')
			{
				$('.blueprints').addClass('hide');
			}
			else
			{
				$('.blueprints').removeClass("hide");
			}	
		});
		$("#all").change(function () {
		$("input:checkbox.chapters_list").prop('checked',this.checked);
		});
		
		function valthis() {
			var checkBoxes = document.getElementsByClassName( 'chapters_list' );
			var isChecked = false;
				for (var i = 0; i < checkBoxes.length; i++) {
				if ( checkBoxes[i].checked ) {
					isChecked = true;
				};
				};
			if (!isChecked ) {
        alert( 'Please, Select any one Chapter!' );
        } else {
          return true; 
        }   
}
        </script>
		
@endsection

