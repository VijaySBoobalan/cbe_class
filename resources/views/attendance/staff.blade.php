@extends('layouts.master')

@section('staff_attandance')
active
@endsection

@section('attendance_menu')
active open
@endsection

@section('content')
<script src="{{ url('assets/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ url('assets/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Staff Attendance</h1>
                        </div>

                        <form action="#" id="StaffAttendanceForm" method="post" class="form-validate-jquery StaffAttendanceForm" data-parsley-validate name="form2" role="form">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            @csrf
                            <div class="tile-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Staff') !!}
                                            {!! Form::select('staff_id',$Staffs->pluck('staff_name','id') ,null, ['class' => 'form-control chosen-select staff_id','placeholder'=>'Select Staff','id'=>'staff_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'From Date') !!}
                                            <div class="input-group datepicker" data-format="L">
                                                {!! Form::text('from_date', date('m/d/Y'), ['class' => 'form-control from_date','placeholder'=>'From Date','id'=>'from_date','required'=>'required']) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'To Date') !!}
                                            <div class="input-group datepicker" data-format="L">
                                                {!! Form::text('to_date', date('m/d/Y'), ['class' => 'form-control to_date','placeholder'=>'To Date','id'=>'to_date','required'=>'required']) !!}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top text-center">
                                    <button type="button" class="btn btn-lightred FilterDetails text-center" id="FilterDetails">Filter</button>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Staff Attendance</h1>
                        </div>

                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table" id="Student_details">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Staff Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject</th>
                                        <th>Assign Time</th>
                                        <th>Taken Time</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6" style="text-align:right">Total:</th>
                                            <th class="TotalClassTime"></th>
                                            <th class="TotalInTime"></th>
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
        var SelectSubject = "0";
        var SelectSection = "0";

        $(function(){
            $.validator.setDefaults({
                errorElement: "span",
                errorClass: "help-block",
                ignore: ":hidden:not(select)",
                highlight: function (element, errorClass, validClass) {
                    // Only validation controls
                    if (!$(element).hasClass('novalidation')) {
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    }
                },
                unhighlight: function (element, errorClass, validClass) {
                    // Only validation controls
                    if (!$(element).hasClass('novalidation')) {
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                    }

                },
                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    }
                    else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                        error.insertAfter(element.parent().parent());
                    }
                    else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                        error.appendTo(element.parent().parent());
                    }
                    else if (element.is("select.chosen-select")) {
                        element.next("div.chosen-container").append(error);
                    }
                    else {
                        error.insertAfter(element);
                    }
                }
            });
        });

        var table = "";
        $(document).ready(function() {
            var tt = new $.extend($.fn.dataTable.defaults, {
                autoWidth: false,
                columnDefs: [{
                    // orderable: false,
                    width: 100,
                    targets: [3]
                }],
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
                language: {
                    search: '<span>Filter:</span> _INPUT_',
                    searchPlaceholder: 'Type to filter...',
                    lengthMenu: '<span>Show:</span> _MENU_',
                    paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                }
            });

            $.fn.dataTable.Api.register('sum()', function ( ) {
                return this.flatten().reduce( function ( a, b ) {
                    if ( typeof a === 'string' ) {
                        a = a.replace(/[^\d.-]/g, '') * 1;
                    }
                    if ( typeof b === 'string' ) {
                        b = b.replace(/[^\d.-]/g, '') * 1;
                    }

                    return a + b;
                }, 0 );
            } );

            $('.FilterDetails').on('click', function(e) {
                var form = $("#StaffAttendanceForm");
                form.validate();
                e.preventDefault();
                var checkValid = form.valid();
                if(checkValid == true){
                    if (table != "") {
                        table.ajax.reload();
                        $("#toggle_filter_card").click();
                    } else {
                        table = $('#Student_details').DataTable({
                            processing: true,
                            serverSide: false,
                            responsive: true,
                            autoWidth: false,
                            ajax: {
                                url: "{{ route("StaffClassDetail") }}",
                                "type": 'GET',
                                data: function (d) {
                                    d.staff_id = $("#staff_id").val();
                                    d.from_date = $("#from_date").val();
                                    d.to_date = $("#to_date").val();
                                },
                                "dataSrc": function ( json ) {
                                    console.log(json);
                                    if(json.status == '401'){
                                        window.href.location = '/login';
                                    }
                                    $('.TotalClassTime').html(json.TotalTime);
                                    $('.TotalInTime').html(json.TotalInTime);
                                    return json.data;
                                }
                            },
                            "columns": [
                                { "data": "DT_RowIndex" },
                                { "data": "date" },
                                { "data": "staff_id" },
                                { "data": "class" },
                                { "data": "section_id" },
                                { "data": "subject_id" },
                                { "data": "assign_time" },
                                { "data": "taken_time" },
                                { "data": "status" },
                            ],
                            // "footerCallback": function ( row, data, start, end, display ) {
                            //     var api = this.api(), data;
                            //     total = api.column( 7 ).data().sum();
                            //     console.log(total);
                            //     var hours = Math.floor(total / 60);
                            //     var minutes = total % 60;
                            //     $( api.column( 7 ).footer() ).html(
                            //         total +":"+minutes
                            //     );
                            // },
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
                                    className: 'btn btn-primary'
                                },
                                {
                                    extend: 'csv',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary'
                                },
                                {
                                    extend: 'excel',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary'
                                },
                                {
                                    extend: 'pdf',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary'
                                },
                                {
                                    extend: 'print',
                                    exportOptions: {
                                        columns: ':not(.no-print)'
                                    },
                                    className: 'btn btn-primary'
                                }
                            ],
                        });
                    }
                }
            });
        });

        function getSection(value) {
            var student_class = value;
            var selectHTML = "";
            if (student_class != '') {
                $.ajax({
                    type: "get",
                    url: '{{ route("getSection") }}',
                    data: { student_class: student_class },
                    success: function(data) {
                        for (var key in data) {
                            var row = data[key];
                            selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                        }
                        $('.section_id').html(selectHTML);
                        $('.section_id').val(SelectSection).trigger("chosen:updated");
                    }
                });
            }
        }

        function getSubjects(value) {
            var class_id = $('#class_id').val();
            var section_id = value;
            var selectHTML = "";
            if (class_id != "" && section_id != "") {
                axios.get("{{ action('StaffSubjectAssignController@create') }}", { params: { "class_id": class_id, "section_id": section_id } }).then(response => {
                    for (var key in response.data) {
                        var row = response.data[key];
                        selectHTML += "<option value=" + row.id + ">" + row.subject_name + "</option>";
                    }
                    $('.subject_details').html(selectHTML);
                    $('.subject_details').val(SelectSubject).trigger('chosen:updated');
                });
            }
        }

    </script>

@endsection
