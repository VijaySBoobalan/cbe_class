@extends('layouts.master')

@section('exam_management')
active
@endsection

@section('content')
<style>
.create_batch {
    float: right;
    margin-top: -8px;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
	
	<section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-8">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Packs</h1>
                          
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                    <div class="row">
                        <div class="col-sm-12">
						
						
                            <div class="form-group">
                                {!! Form::label('name', 'Batches') !!}
								@if($batches == null)
									<div class="alert alert-warning">
										<strong>Warning!</strong> Batch is Empty Create Batch First to Allocate  &nbsp <a href="{{ route('BatchIndex') }}"class="btn btn-danger create_batch">Create Batch</a>
									</div>
									
								@endif
								@foreach($batches as $batch)
								<div class="checkbox">
								<label><input type="checkbox"class="getbatches"name="batches[{{ $batch['id'] }}]" value="{{ $batch['id'] }}">{{ $batch['batch_name'] }}</label>
								</div>
								@endforeach
							</div>							
						
                        </div>
                    </div>
                           <form action="{{ Route('StoreAllocations') }}"method="get">
						   <input type="hidden"name="exam_id"value="{{ $exam_id }}">
                                <div class="table-responsive">
                                    <div class="batchmembers"></div>
                                </div>
								<input type="submit"name="storeallocations"class="btn btn-primary"value="Store">
							</form>

                           



                        </div>

                        <!-- /tile body -->

                    </section>
                </div>
				  <div class="col-md-4">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Details</h1>
                          
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
									<label><b>Exam Pack:</b> <?php if($ExamDetails->exam_name ==1){ echo "NEET"; } elseif($ExamDetails->exam_name ==2) { echo "BANKING"; }else { echo "SCHOOL"; } ?></label><br>	
									<label><b>Exam Name:</b> {{ $ExamDetails->exam_name }}</label><br>	
									<label><b>Exam Hours:</b> {{ $ExamDetails->exam_time }} Hrs</label>	
                                </div>
                            </div>
                            <div id="AllocateExam" class="tabcontent">
                                <div class="table-responsive">
                                    
                                </div>
                            </div>
                        </div>

                        <!-- /tile body -->

                    </section>
                </div>
            </div>
        </div>
    </section>
	<script>
	$('.getbatches').change(function () {
   
		var batch_id = $(this).val();
		
		if ($(this).is(':checked')) {
				$.ajax({
                    type: "get",
                    url: '{{ route("get_batch_students") }}',
                    data:{batch_id:batch_id},
                    success: function(data) {
						// console.log(data);
						$('.batchmembers').append(data);	
                    }
                });
		}else{
		$('.batchdetails'+batch_id).remove();
		}
	});
	</script>
@endsection




