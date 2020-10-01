@extends('layouts.master')

@section('automatic_question_view')
active
@endsection

@section('automatic_question_menu')
active open
@endsection


@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Automatic Questions Details</h1>
							<ul class="controls">
                                    <li>
                                        <a href="{{ route('AddAutomaticQuestion') }}"role="button" tabindex="0"><i class="fa fa-plus mr-5"></i> Add Automatic Questions</a>
                                    </li>
                            </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="ViewquestionTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Class</th>
                                        <th>Subject</th>
                                        <th>Preperation Type</th>
                                        <th>Creative Type</th>
                                     
                                        <th>Action</th>
                                    </tr>
                                    </thead>
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

    var ViewQuestionTable= $('#ViewquestionTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: '{{ route("AutomaticQuestion") }}',
        "columns": [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            { data: 'class' },
            { data: 'subject_name' },
            { data: 'preperation_type' },
            { data: 'creating_type' },
            { data: 'action', orderable: false, searchable: false },
        ]
    });
   </script>   
@endsection

