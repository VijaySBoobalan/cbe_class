@extends('layouts.master')

@section('view_chapter')
active
@endsection

@section('chapter_open_menu_display')
block
@endsection

@section('chapter_menu')
active open
@endsection

<script src="{{ asset('js/main_pages/viewstaffsubject.js') }}"></script>

@section('content')

<section id="content">
    <style>
        @media print {
        body * {
            visibility: hidden;
        }
        #section-to-print, #section-to-print * {
            visibility: visible;
        }
        #section-to-print {
            position: absolute;
            left: 0;
            top: 0;
        }
        }
    </style>
    <div class="page page-tables-datatables">
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Chapter Details</h1>
                        <ul class="controls">
                            <li>
                                <a role="button" onclick="window.print()"><i class="fa fa-print mr-5"></i>Print</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /tile header -->

                    <!-- tile body -->
                    <div class="tile-body">
                        <div class="table-responsive">
                            <input type="hidden" name="staff_id" value="{{ $id }}" id="staff_id" class="staff_id">
                            <table class="table datatable-basic staff_subject_table" id="viewChapter">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Chapter Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Chapters as $key=>$Chapter)
                                        <tr>
                                            <td><span style="color: red; font-size:25px;">{{ $Chapter->unit_number }}</span></td>
                                            <td><span style="color: red; font-size:25px;">{{ $Chapter->unit_name }}</span></td>
                                            <tbody>
                                                @foreach ($Chapter->getChapterDetails as $key1=>$ChapterDetails)
                                                    <tr>
                                                        <td>{{ $ChapterDetails->chapter_number }}</td>
                                                        <td>{{ $ChapterDetails->chapter_name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- @section('script')

    <script>
        dataTable();
        function dataTable() {
            viewChapter= $('#viewChapter').DataTable({
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

@endsection --}}
