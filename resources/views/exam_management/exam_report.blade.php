@extends('layouts.master')

@section('exam_management')
active
@endsection

@section('content')

    <section id="content">
		
        <div class="page page-tables-datatables">
            <div class="row">
			
                <div class="col-md-12">
                    <section class="tile">
						<div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Name ( {{ $Exams[0]->exam_name }} )</h1>
                          
                        </div>
					<table class="table">	
					<tr><th>Exam Name:</th><td>{{ $Exams[0]->exam_name }}</td></tr>
					<tr><th>Exam Hours:</th><td>{{ $Exams[0]->exam_hours }}</td></tr>
					<tr><th>Batch:</th><td>{{ $Exams[0]->batch_name }}</td></tr>
					</table>	
					</section>
					<div class="row">
				
				<div class="col-md-6">
				 <section class="tile">
					 <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Batch Students ( {{ $Exams[0]->batch_name }} )</h1>
                          
                        </div>
				
				<table class="table">
				<tr>
				<th>S.No</th>
				<th>Student Name</th>
				</tr>
				<tbody>
				@foreach($Exams as $key=>$details)
					@foreach($details->batch_students as $key=>$student_details)
					<tr>
						<td>{{ ++$key }}</td>
						<td>{{ $student_details->name }}</td>
					</tr>
					@endforeach
				@endforeach
				</tbody>
				
				</table>
				</section>
				</div>
				
				
				 
				
				<div class="col-md-6">
				<section class="tile">
					 <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam details</h1>
                          
                        </div>
					
					<table class="table">
				<tr>
				<th>S.No</th>
				<th>Student Name</th>
				<th>Status</th>
				</tr>
				<tbody>
					@foreach($Exams as $key=>$details)
					@foreach($details->batch_students as $key=>$student_details)
					
				<?php  //echo $student_details->student_id;
				$attended_students =getAttendedStudentList($student_details->student_id,$details->exam_id);
				
				// print_r($notAttendedStudents); 
				?>
						
							<tr>
								<td>{{ ++$key }}</td>
								<td><a href ="{{ action('Student\StudentExamController@Viewstudent_answer',[ $details->exam_id ,  $student_details->student_id ]) }}">{{ $student_details->name }}</a></td>
								<td>
								{{ $attended_students }}
								</td>
							</tr>
						
					@endforeach
				@endforeach
				</tbody>
				</table>
				</div>
				</section>
				</div>
				</div>
					
					<section class="tile">
						<div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Report</h1>
                          
                        </div>
					</section>
                </div>
            </div>
        </div>
    </section>

<script>

</script>
@endsection


