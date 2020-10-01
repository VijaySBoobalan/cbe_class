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
                            <h1 class="custom-font"><strong>Chapter Details  ( {{ $Subject->subject_name }} )</h1>
							 
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
					
                            <div class="table-responsive">
                                <table class="table table-custom" id="ChapterTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Chapter</th>
                                        <th>Question Count</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
								
									@php
                                          $loop = 1;
                                        @endphp
                                    <tbody>
                                        @foreach ($chapters as $key=>$chapter)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $chapter['unit_name'] }}</td>
                                                <td>{{ $chapter['count'] }}</td>
												<?php $chapterID=$chapter['id']; ?>
                                                <td>
												 <a href="{{ action('ManageQuestions\ChapterBasedQuestionController@ChapterQuestionDetails',[$chapterID,$class_id]) }}"><button class="btn btn-sm btn-primary"><i class="fa fa-eye"> Views</i></button></a>
												</td>
                                                                                                
                                            </tr>
                                            <?php $loop++; ?>
                                        @endforeach
                                   
									</tbody>
                                </table>
								<div class="demo-link"></div>
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

    // $(document).ready(function() {
    //     $('.chosen-select').chosen({
    //         placeholder_text_single: "Select Project/Initiative...",
    //         no_results_text: "Oops, nothing found!"
    //     });
    // });


</script>


@endsection

