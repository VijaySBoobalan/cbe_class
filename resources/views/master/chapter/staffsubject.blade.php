@extends('layouts.master')

@section('add_chapter')
active
@endsection

@section('chapter_open_menu_display')
block
@endsection

@section('chapter_menu')
active open
@endsection

@section('content')
    <section id="content">
        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>View Staff Subject Details</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <input type="hidden" name="staff_id" value="{{ $staff_id }}" id="staff_id" class="staff_id">
                                <table class="table table-responsive" id="staffSubjectTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Subject</th>
                                            <th>Class</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script>

        dataTable();
        function dataTable() {
            var staff_id = $('.staff_id').val();
            staffSubjectTable= $('#staffSubjectTable').DataTable({
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                processing: true,
                serverSide: false,
                responsive: true,
                autoWidth: false,
                "bDestroy": true,
                ajax:{
                    url:"{{ url('staff_assigned_subject') }}",
                    data:{ staff_id : staff_id },
                },
                "columns": [
                    { data: 'DT_RowIndex' },
                    { data: 'subjects' },
                    { data: 'class' },
                    { data: 'action', orderable: false, searchable: false },
                ],
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

        // $( document ).ready(function() {
        //     $('#FilterStaffSubjectDetails').on('click',function (e) {
        //         e.preventDefault();
        //         var staff_id = $('.staff_id').val();
        //         dataTable({staff_id : staff_id });
        //     });
        // });

    </script>
@endsection
