@extends('layouts.master')

@section('total_schedule')
active
@endsection

@section('schedule_open_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Filter</h1>
                        </div>
                        <div class="tile-body">
                            <form action="#" id="TotalScheduleForm" method="post" class="form-validate-jquery TotalScheduleForm" data-parsley-validate name="form2" role="form1">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'From Date') !!}
                                            {!! Form::date('from_date', date('Y-m-d'), ['class' => 'form-control from_date','placeholder'=>'Email','id'=>'from_date','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'To Date') !!}
                                            {!! Form::date('to_date', date('Y-m-d'), ['class' => 'form-control DateAttr to_date','placeholder'=>'Email','id'=>'to_date','required'=>'required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top text-center">
                                    <button type="button" class="btn btn-lightred FilterDetails text-center" id="FilterDetails">Filter</button>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="TotalScheduleTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Assign Time</th>
                                        <th>Taken Time</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total Assigned Time</th>
                                            <th class="TotalAssignedTime"></th>
                                            <th style="display: none;"></th>
                                            <th>Total Taken Time</th>
                                            <th class="TotalTakenTime"></th>

                                        </tr>
                                    </tfoot>
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
        $( document ).ready(function() {
            var table = "";
            var tt = new $.extend($.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    // orderable: false,
                    width: 100,
                    targets: [3]
                }],
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Search:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });

            $('.FilterDetails').on('click',function (e) {
                var form = $("#TotalScheduleForm");
                form.validate();
                e.preventDefault();
                var checkValid = form.valid();
                if(checkValid == true){
                    if (table != "") {
                        table.ajax.reload();
                        $("#toggle_filter_card").click();
                    } else {
                        table = $('#TotalScheduleTable').DataTable({
                            processing: true,
                            serverSide: false,
                            responsive: true,
                            autoWidth: false,
                            ajax: {
                                url: "{{ route("TotalScheduleList") }}",
                                "type": 'GET',
                                data: function (d) {
                                    d.from_date = $("#from_date").val();
                                    d.to_date = $("#to_date").val();
                                },
                                "dataSrc": function ( json ) {
                                    var TotalAssignedTime = 0;
                                    var TotalTakenTime = 0;
                                    for (var key in json.data) {
                                        var row = json.data[key];
                                        TotalAssignedTime = parseFloat(TotalAssignedTime) + parseFloat(row.Total_assign_time);
                                        TotalTakenTime = parseFloat(TotalTakenTime) + parseFloat(row.TotalTakentime);
                                    }
                                    $('.TotalAssignedTime').html(TotalAssignedTime.toFixed(2));
                                    $('.TotalTakenTime').html(TotalTakenTime.toFixed(2));
                                    return json.data;
                                }
                            },
                            "columns": [
                                { "data": "DT_RowIndex" },
                                { "data": "subject_day" },
                                { "data": "class" },
                                { "data": "section" },
                                { "data": "assign_time" },
                                { "data": "taken_time" },
                            ],
                            "aoColumnDefs": [
                                { 'bSortable': false, 'aTargets': [ "no-sort" ] }
                            ],
                            columnDefs: [
                                {
                                    targets: -1,
                                    className: 'noVis'
                                }
                            ],
                            "buttons": [
                                {
                                    extend: 'copy',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary',
                                    footer: true,
                                },
                                {
                                    extend: 'csv',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary',
                                    footer: true,
                                },
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary',
                                    footer: true,
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary',
                                    footer: true,
                                },
                                {
                                    extend: 'print',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary',
                                    footer: true,
                                }
                            ],
                        });
                    }
                }
            });
        });
    </script>
@endsection
