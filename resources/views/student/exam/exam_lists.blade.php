@extends('layouts.master')

@section('write_test')
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
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       @foreach($Exams as $key=>$exam)
									   <tr>
									   <td>{{ ++$key }}</td>
									   <td>{{ $exam->exam_name }}</td>
									   <td>
									   <?php if($exam->status==1){ ?>
									    <a href="{{ action('Student\StudentExamController@viewMyExamReport',[$exam->exam_id]) }}"id="{{ $exam->allocted_exam_batche_id }}" class="btn btn-info">Report</a>		   
										<?php } else{ ?>
									   <a href="#"id="{{ $exam->allocted_exam_batche_id }}" class="btn btn-info examdetails" data-toggle="modal" data-target="#Password">Write Exam</a>
									   <?php } ?>
									   </td>
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
@section('Modal')
    @include('student.exam.password')

@endsection
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


