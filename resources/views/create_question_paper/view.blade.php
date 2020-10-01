@extends('layouts.master')

@section('question_paper_views')
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
                            <h1 class="custom-font"><strong>Chapter Details</h1>
							<ul class="controls">
                                    <li>
                                       <a href="{{ route('CreateQuestionPaper') }}"><i class="fa fa-plus mr-5"></i>Create Question Paper</a>
                                    </li>
                            </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="ChapterTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Exam Question Paper</th>
                                        <th>Action</th>
                                        <th>Created On</th>
										
                                    </tr>
                                    </thead>
                                      
                                    <tbody>
                                    @foreach($QuestionPapers as $key=>$exams)
									<tr>
									<td>{{ ++$key }}</td>
									<td>{{ $exams->exam_name }}</td>
									<td>
									<a href="#" class="previewPaper" data-exam_id="{{ $exams->id }}"><i class="fa fa-print text-aqua"></i></a>
									<a href="{{ action('QuestionPaperManage\CreateQuestionPaperController@exam_questionpreview',[$exams->id]) }}"><i class="fa fa-eye text-aqua"></i></a>
									<a href="{{ action('QuestionPaperManage\CreateQuestionPaperController@exam_questionedit',[$exams->id]) }}"><i class="fa fa-pencil text-aqua"></i></a>
									<a href="{{ action('QuestionPaperManage\CreateQuestionPaperController@exam_questiondelete',[$exams->id]) }}"><i class="fa fa-trash-o" style="color:red;"> </i></a>
									</td>
									<td>{{ $exams->created_at }}</td>
									</tr>
									@endforeach									  
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

   $(".previewPaper").on("click", function(){
	 var exam_id = $(this).data("exam_id");
	
	   $.ajax({
                    type: "get",				
                    url: '{{ route('QuestionPaperprint') }}',
                    data:{exam_id:exam_id},
					
                    success: function(data) {
						Popup(data);
						
					}
                });
	  });
	  
		function Popup(data)
    {

        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";

        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
//Create a new HTML document.
        frameDoc.document.write('<html>');
        frameDoc.document.write('<head>');
        frameDoc.document.write('<title></title>');
// frameDoc.document.write('<link rel="stylesheet" href="' + base_url + 'backend/dist/css/idcard.css">');

        frameDoc.document.write('</head>');
        frameDoc.document.write('<body>');
        frameDoc.document.write(data);
        frameDoc.document.write('</body>');
        frameDoc.document.write('</html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);


        return true;
    }


</script>


@endsection

