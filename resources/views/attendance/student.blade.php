@extends('layouts.master')

@section('student_attandance')
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
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'getSection(this.value);','class' => 'form-control chosen-select class_id','placeholder'=>'Select Class','id'=>'class_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section_id',[],null, ['onchange'=>'getStudent(this.value);','class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Student Name') !!}
                                            {!! Form::select('student_name',[],null, ['class' => 'form-control chosen-select student_name','placeholder'=>'Select Student','id'=>'student_name','required'=>'required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'From Date') !!}
                                            {!! Form::date('from_date', date('Y-m-d'), ['onchange'=>'checkDate();','class' => 'form-control from_date','placeholder'=>'Email','id'=>'from_date','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
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
                            <h1 class="custom-font"><strong>Student Attendance</h1>
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
                                            <th>Attend Time</th>
                                            <th>Status</th>
                                            {{-- @if(auth()->user()->can('student_update') || auth()->user()->can('student_delete') ) --}}
                                                {{-- <th>Action</th> --}}
                                            {{-- @endif --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">Total Hrs: </th>
                                            <th class="TotalInTime"></th>
                                            <th class="text-center">Total Attend Time: </th>
                                            <th class="TotalAttendTime"></th>
                                            <th class="text-center">No.of Present Day: </th>
                                            <th class="TotalPresentDay"></th>
                                            <th colspan="1" class="text-center">No.of Absent Day: </th>
                                            <th class="TotalAbsentDay"></th>
                                            <th style="display: none"></th>
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
        function checkDate() {
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            $(".DateAttr").attr({
                "min" : $('#from_date').val()
            });
        }

        var SelectStudent = "0";
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
                                url: "{{ route("StudentWiseDetail") }}",
                                "type": 'GET',
                                data: function (d) {
                                    d.class_id = $("#class_id").val();
                                    d.section_id = $("#section_id").val();
                                    d.from_date = $("#from_date").val();
                                    d.to_date = $("#to_date").val();
                                    d.student_name = $("#student_name").val();
                                },
                                "dataSrc": function ( json ) {
                                    var TotalInTime = 0;
                                    var TotalAttendTime = 0;
                                    var TotalPresentDay = 0;
                                    var TotalAbsentDay = 0;
                                    for (var key in json.data) {
                                        var row = json.data[key];
                                        TotalPresentDay = parseFloat(TotalPresentDay) + parseFloat(row.PresentCount);
                                        TotalAbsentDay = parseFloat(TotalAbsentDay) + parseFloat(row.AbsentCount);
                                        TotalInTime = parseFloat(TotalInTime) + parseFloat(row.ForTotalAssignime);
                                        TotalAttendTime = parseFloat(TotalAttendTime) + parseFloat(row.ForTotalAttendTime);
                                    }
                                    $('.TotalInTime').html(TotalInTime.toFixed(2));
                                    $('.TotalAttendTime').html(TotalAttendTime.toFixed(2));
                                    $('.TotalPresentDay').html(TotalPresentDay);
                                    $('.TotalAbsentDay').html(TotalAbsentDay);
                                    return json.data;
                                }
                            },
                            "columns": [
                                { "data": "DT_RowIndex" },
                                { "data": "subject_day" },
                                { "data": "class" },
                                { "data": "section" },
                                { "data": "staff_name" },
                                { "data": "subject_name" },
                                { "data": "assign_time" },
                                { "data": "taken_time" },
                                { "data": "attend_time" },
                                { "data": "status" },
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

        function getStudent(value) {
            var class_id = $('.class_id').val();
            var section_id = value;
            var selectHTML = "";
            if (class_id != "" && section_id != "") {
                axios.get("{{ action('StudentAttendenceController@StudentList') }}", { params: { "class_id": class_id, "section_id": section_id } }).then(response => {
                    for (var key in response.data) {
                        var row = response.data[key];
                        selectHTML += "<option value=" + row.id + ">" + row.student_name + "</option>";
                    }
                    $('.student_name').html(selectHTML);
                    $('.student_name').val(SelectStudent).trigger('chosen:updated');
                });
            }
        }

    </script>

@endsection

