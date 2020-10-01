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

{{-- <script src="{{ asset('js/main_pages/syllabus.js') }}"></script> --}}

@section('content')
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>View Staff Details</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table datatable-basic" id="StaffDetailsTable">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Staff Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
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
        var data = [];
        dataTable(data);

        function dataTable(data) {
            StaffDetailsTable= $('#StaffDetailsTable').DataTable({
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                processing: true,
                serverSide: false,
                responsive: true,
                autoWidth: false,
                "bDestroy": true,
                ajax:{
                    url:"{{ url('chapter') }}",
                    data:data,
                },
                "columns": [
                    { data: 'DT_RowIndex' },
                    { data: 'staff_name' },
                    { data: 'mobile_number' },
                    { data: 'email' },
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

        $( document ).ready(function() {
            $('#FilterStaffSubjectDetails').on('click',function (e) {
                e.preventDefault();
                var staff_id = $('.staff_id').val();
                dataTable({staff_id : staff_id });
            });
        });

    </script>
@endsection
