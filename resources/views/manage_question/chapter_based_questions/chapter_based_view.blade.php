@extends('layouts.master')

@section('chapter_based_questions')
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
                            <h1 class="custom-font"><strong>Chapter Details</h1>
							 
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
						<div class="row">
							<div class="col-lg-4">
                                            <div class="form-group">
                                               
                                                {!! Form::select('class_id',$ClassSection->pluck('class','class') ,null, ['class' => 'form-control chosen-select class_id','placeholder'=>'Select Class','id'=>'class_id','required'=>'required']) !!}
                                            </div>
							</div>
						
						
							<div class="col-lg-4">
							
                            <button class="btn btn-primary getSubjects">Get Subjects</button>
							</div>
						</div>
						 </section>
						 <section class="tile">
                            <div class="table-responsive sub_details_table hide">
                                <table class="table table-custom" id="ChapterTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Subject</th>
                                        <th>Chapter Count</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="subject_details">    
                                    </tbody>    
                                </table>
								
                            </div>
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

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	 $('.getSubjects').on('click', function(event){
		
		var class_id=$('.class_id').val();
		var subjectHTML = "";
		if(class_id){
			$.ajax({
                    type: "get",
                    url: '{{ route("getClasssubjects") }}',
                    data:{class_id:class_id},
                    success: function(data) {
						console.log(data);
                        for(i=0; i<data.length; i++){
                            var rowno = i + 1;
							var route='{{ url("subject-chapter-list") }}/'+data[i].id + '/'+class_id ;
							var link='<a href="'+route+'"><i class="fa fa-eye"></i></a>';
							
                            subjectHTML += "<tr><td>"+ rowno +"</td><td>"+data[i].subject_name+"</td><td>"+data[i].chapter_count+"</td><td>"+link+"</td></tr>";
                        }
						$('.sub_details_table').removeClass('hide');
						$('.subject_details').html(subjectHTML);	
                       
                    }
                });
		}else{
			alert("Choose Class");
		}
	 });
    var ChapterTable= $('#ChapterTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
       
    });

    dataTable();
    function dataTable() {
        QuestionTable= $('#ChapterTable').DataTable({
            dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
            processing: true,
            serverSide: false,
            responsive: true,
            autoWidth: false,
            "bDestroy": true,
            buttons: [
                {
                    extend: 'copy',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'excel',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: [':visible:not(:last-child)']
                    },
                    className: 'btn btn-primary'
                }
            ],
        });
    }

    // $(document).ready(function() {
    //     $('.chosen-select').chosen({
    //         placeholder_text_single: "Select Project/Initiative...",
    //         no_results_text: "Oops, nothing found!"
    //     });
    // });


</script>


@endsection

