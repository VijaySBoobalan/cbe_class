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
                            <h1 class="custom-font"><strong>Exams</h1>
                            <ul class="controls">
                                    <li>
                                        <a href="{{ route('CreateExam',$id) }}"><i class="fa fa-plus mr-5"></i>Create Exam</a>
                                    </li>
                                </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
                                   
                                </div>
                            </div>
                            <div id="ClassHomework" class="tabcontent">
                                <div class="table-responsive">
                                    <table class="table table-custom" id="ExamsTable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Exam Name</th>
                                                <th>Total Questions</th>
                                                <th>Action</th>
                                                <th>Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Exams as $key=>$exam)
										<tr>
										<td>{{ ++$key }}</td>
										<td>{{ $exam->exam_name }}</td>
										<td>{{ $exam->question_count }}</td>
										<td><a href="{{ route('AllocateExam',$exam->id) }}"class="btn btn-primary">Allocate</a></td>
										
										<td><a href="{{ route('ViewExamReport',$exam->id) }}"class="btn btn-primary">Report</a></td>
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
        </div>
    </section>

<script>
  var ExamsTable= $('#ExamsTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
       
    });

    dataTable();
    function dataTable() {
        QuestionTable= $('#ExamsTable').DataTable({
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
</script>
@endsection


