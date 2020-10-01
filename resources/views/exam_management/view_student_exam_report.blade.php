@extends('layouts.master')

@section('exam_management')
active
@endsection

@section('content')
<style>

</style>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
               
					
                    <section class="tile">
					
					 <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Student Information</h1>
							
                            
                        </div>
						 <div class="tile-body">
						 <table class="table">
							<tr><th>Name:</th> <td>{{ $student_details->name }}</td></tr>
                            <tr><th>Email:</th><td>{{ $student_details->email }}</td></tr>
                            <tr><th>Class:</th><td>{{ $student_details->student_class }}</td></tr>
                            <tr><th>Section:</th><td>{{ $student_details->section }}</td></tr>
                            <tr><th>Exam Id:</th><td>{{ $exam_id }}</td></tr>
							</table>
						 </div>
					</section>
					
					<section class="tile">
					 <div class="card">
							<div class="card-header header-elements-inline">
								<h5 class="card-title">Student Answer Details</h5>
								
							</div>

							<div class="card-body">
								
								<div class="chart-container has-scroll text-center">
									<div class="d-inline-block" id="google-donut-rotate"></div>
								</div>
							</div>
						</div> 
					</section>
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Report</h1>
                            <ul class="controls">
                                    <li>
                       
                                    </li>
                                </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
								<form action="{{ route('submiteexamReport') }}"method="get">
								<input type="hidden"name="exam_id"value="{{ $exam_id }}">
								<input type="hidden"name="student_id"value="{{ $student_details->student_id }}">
                                <table class="table">
								<tr>
								<th>S.no</th>
								<th>Segregation</th>
								<th>Question</th>
								<th>Question answer</th>
								<th>Student answered</th>
								<th>Corrections</th>
								</tr>
								<tbody>
								
								@foreach($question as $key=>$value)
								<tr><td>{{ ++$key }}</td>
								<td>{{ $value->segregation }}</td>
								<td>{!! $value->question_name !!}</td>
								<td> @foreach(unserialize($value->answer) as $key =>$answer)
									{{ strip_tags($answer) }}
									@endforeach
								</td>
								<td> @if ($value->student_answer) {{ $value->student_answer[0]->studentanswer }}  @endif </td>
								<td><input type="hidden"name="question_id[]"value="{{ $value->id }}"><textarea name="answer_description[]"class="form-control">@if ($value->student_answer) {{ $value->student_answer[0]->answer_description }}  @endif</textarea></td>
								</tr>
								@endforeach
								</tbody>
								</table>
								<input type="submit"class="btn btn-primary"value="SendReport"name="sendreport">
								</form>
								<!--table class="table">
								<tr>
								<th>segragation</th>
								<th>Questions</th>
								<th>Answer</th>
								<th>Submitted Answer</th>
								<th>Corrections</th></tr>
								<tbody>
								@foreach($segregations as $key=>$segregation)
									<td><h4>{{ $segregation->segregation }} </h4></td>
									@foreach($question as $qkey=>$value)
									
									<tr>
									@if($segregation->id == $value->segregation_id )
									<td>
									
									
									{{++$qkey}} )	{{ strip_tags($value->question_name) }} 
									</td>
									<td>
										 
											@foreach(unserialize($value->answer) as $akey =>$answer)
											{{ strip_tags($answer) }}
											@endforeach
										
									</td>
								<td>
								
									{{ $value->student_answer[0]->studentanswer }} 
								
								</td>
									<td><textarea name="answer_description[]"class="form-control"></textarea></td>
								@endif
									</tr>
									
									
									@endforeach
								@endforeach
								</tbody>
								</table-->
                                </div>
                            </div>
                        </div>

                        <!-- /tile body -->

                    </section>
               
            </div>
        </div>
    </section>
<script>
						/* ------------------------------------------------------------------------------
 *
 *  # Google Visualization - rotated donut
 *
 *  Google Visualization rotated donut chart demonstration
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var GoogleDonutRotated = function() {


    //
    // Setup module components
    //

    // Rotated donut
    var _googleDonutRotated = function() {
        if (typeof google == 'undefined') {
            console.warn('Warning - Google Charts library is not loaded.');
            return;
        }

        // Initialize chart
        google.charts.load('current', {
            callback: function () {

                // Draw chart
                drawDonutRotated();

                // Resize on sidebar width change
                $(document).on('click', '.sidebar-control', drawDonutRotated);

                // Resize on window resize
                var resizeDonutRotated;
                $(window).on('resize', function() {
                    clearTimeout(resizeDonutRotated);
                    resizeDonutRotated = setTimeout(function () {
                        drawDonutRotated();
                    }, 200);
                });
            },
            packages: ['corechart']
        });

        // Chart settings
        function drawDonutRotated() {

            // Define charts element
            var donut_rotated_element = document.getElementById('google-donut-rotate');

            // Data
			var totalQuestions = " {{ count($question)}} ";
			// alert(totalQuestions);
			var attend = 5;
			var skipped = 0;
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Questions'],
                ['Total Questions ' + totalQuestions , + totalQuestions ],
                ['Skipped Questions ' + totalQuestions , + totalQuestions ] ,
                ['Attended ' + attend,    + attend] 
            ]);

            // Options
            var options_donut_rotate = {
                fontName: 'Roboto',
                pieHole: 0.55,
                pieStartAngle: 180,
                height: 300,
                width: 500,
                chartArea: {
                    left: 50,
                    width: '90%',
                    height: '90%'
                }
            };

            // Instantiate and draw our chart, passing in some options.
            var donut_rotate = new google.visualization.PieChart(donut_rotated_element);
            donut_rotate.draw(data, options_donut_rotate);
        }
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _googleDonutRotated();
        }
    }
}();


// Initialize module
// ------------------------------

GoogleDonutRotated.init();

						</script>
@endsection


