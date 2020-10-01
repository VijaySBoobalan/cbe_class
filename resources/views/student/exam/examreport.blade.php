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
								
								
                                <table class="table">
								<tr>
								<th>S.no</th>
								<th>Segregation</th>
								<th>Question</th>
								<th>Question answer</th>
								<th>Your answer</th>
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
								<td> {{ $value->student_answer[0]->studentanswer }} </td>
								<td> {{ $value->student_answer[0]->answer_description }} </textarea></td>
								</tr>
								@endforeach
								</tbody>
								</table>
								
								
                                </div>
                            </div>
                        </div>

                        <!-- /tile body -->

                    </section>
               
            </div>
        </div>
    </section>
<script>

						</script>
@endsection


