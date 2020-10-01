@extends('layouts.master')

@section('class_attandance')
active
@endsection

@section('attendance_menu')
active open
@endsection

@section('content')


<script src="{{ url('assets/plugins/tables/datatables/datatables.min.js') }}"></script>
<script src="{{ url('assets/plugins/tables/datatables/extensions/buttons.min.js') }}"></script>
    <section id="content">
        <p>  </p>
        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Filter</h1>
                        </div>
                        <form action="#" id="StudentAttendanceForm" method="post" class="form-validate-jquery StudentAttendanceForm" data-parsley-validate name="form2" role="form">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            @csrf
                            <div class="tile-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSection(this.value);','class' => 'form-control chosen-select class_id','placeholder'=>'Select Class','id'=>'class_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'From Date') !!}
                                            {!! Form::date('from_date', date('Y-m-d'), ['onchange'=>'checkDate();','class' => 'form-control from_date','placeholder'=>'Email','id'=>'from_date','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            {!! Form::label('name', 'To Date') !!}
                                            {!! Form::date('to_date', date('Y-m-d'), ['onchange'=>'checkDate();','class' => 'form-control DateAttr to_date','placeholder'=>'Email','id'=>'to_date','required'=>'required']) !!}
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
                            <h1 class="custom-font"><strong>Class Attendance</h1>
                        </div>

                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table" id="Student_details">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Staff Name</th>
                                        <th>Subject</th>
                                        <th>Assign Time</th>
                                        <th>Taken Time</th>
                                        <th>Total Student Attended</th>
                                        {{-- @if(auth()->user()->can('student_update') || auth()->user()->can('student_delete') ) --}}
                                            {{-- <th>Action</th> --}}
                                        {{-- @endif --}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    {{-- <tfoot>
                                        <tr>
                                            <th colspan="7" style="text-align:right">Total:</th>
                                            <th class="TotalInTime"></th>
                                        </tr>
                                    </tfoot> --}}
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
        function checkDate() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            $(".DateAttr").attr({
                "min" : $('#from_date').val()
            });
        }

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

            $('.FilterDetails').on('click', function(e) {
                var form = $("#StudentAttendanceForm");
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
                                url: "{{ route("ClassWiseDetail") }}",
                                "type": 'GET',
                                data: function (d) {
                                    d.class_id = $("#class_id").val();
                                    d.section_id = $("#section_id").val();
                                    d.from_date = $("#from_date").val();
                                    d.to_date = $("#to_date").val();
                                },
                                "dataSrc": function ( json ) {
                                    $('.TotalInTime').html(json.TotalInTime);
                                    return json.data;
                                }
                            },
                            // initComplete: function (setting,response) {
                            //     $('.TotalClassTime').html(response.recordsTotal);
                            // },
                            "columns": [
                                { "data": "DT_RowIndex" },
                                { "data": "subject_day" },
                                { "data": "class" },
                                { "data": "section" },
                                { "data": "staff_name" },
                                { "data": "subject_name" },
                                { "data": "assign_time" },
                                { "data": "taken_time" },
                                { "data": "Attended_count" },
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
            var taken_class = $('.taken_class').val();
            var section_id = value;
            var selectHTML = "";
            if (taken_class != "" && section_id != "") {
                axios.get("{{ action('StaffSubjectAssignController@create') }}", { params: { "class_id": taken_class, "section_id": section_id } }).then(response => {
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

