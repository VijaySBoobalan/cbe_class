@extends('layouts.master')

@section('view_student')
active
@endsection

@section('student_menu')
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
                            <h1 class="custom-font"><strong>Filter</h1>
                        </div>

                        <div class="tile-body">
                            <form action="#" id="StaffAttendanceForm" method="post" class="form-validate-jquery StaffAttendanceForm" data-parsley-validate name="form2" role="form">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Class') !!}
                                            {!! Form::select('class_id',!empty($StaffSubjectAssign) ? $StaffSubjectAssign->pluck('class','class') : [] , null, ['onchange'=>'getSection(this.value);','class' => 'form-control chosen-select class_id','placeholder'=>'Class','id'=>'class_id','required'=>'required']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Section') !!}
                                            {!! Form::select('section_id',[],null, ['class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top text-center">
                                    <button type="submit" class="btn btn-lightred" id="FilterStudentDetails">Submit</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Student View</h1>
                        </div>

                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="StudentData">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Student Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>DOB</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                        @if(auth()->user()->can('student_update') || auth()->user()->can('student_delete') )
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /tile body -->
                    </section>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="DeleteModel" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are You Sure ! You Want to Delete</h4>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <button type="submit" class="btn btn-danger DeleteConfirmed" data-dismiss="modal">Delete </button>
                        <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        
        var SelectSection = 0;
        var StudentData = "";
        function getSection(value) {
            var selectHTML = "";
            $.ajax({
                type: "post",
                url: '{{ route('getStaffSection') }}',
                data:{ class : value },
                dataType: 'json',
                success: function(data) {
                    for (var key in data) {
                        var row = data[key];
                        selectHTML += "<option value='" + row.section_id + "'>" + row.class_section['section'] + "</option>";
                    }
                    $('.section_id').html(selectHTML);
                    $('.section_id').val(SelectSection).trigger("chosen:updated");
                }
            });
        }

        var StudentId = "";
        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            autoWidth: false,
            columnDefs: [{
                orderable: false,
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

        $( document ).ready(function() {
            $('#FilterStudentDetails').on('click',function (e) {
                var form = $("#StaffAttendanceForm");
                form.validate();
                e.preventDefault();
                var checkValid = form.valid();
                if(checkValid == true){
                    if (StudentData != "") {
                        StudentData.ajax.reload();
                        $("#toggle_filter_card").click();
                    } else {
                        StudentData= $('#StudentData').DataTable({
                            processing: true,
                            serverSide: false,
                            responsive: true,
                            autoWidth: false,
                            // dom: 'RlBfrtip',
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
                            "ajax": {
                                url: '{{ action('StudentController@index') }}',
                                data: function (d) {
                                    d.class_id = $("#class_id").val();
                                    d.section_id = $("#section_id").val();
                                },
                            },
                            "columns": [
                                { data: 'DT_RowIndex' },
                                { data: 'student_name' },
                                { data: 'student_class' },
                                { data: 'section_id' },
                                { data: 'dob' },
                                { data: 'mobile_number' },
                                { data: 'email' },
                                { data: 'action', orderable: false, searchable: false },
                            ],
                        });
                    }
                }
            });

            $('body').on('click','.DeleteStudent',function () {
                var student_id = $(this).attr('id')
                StudentId = student_id;
            });

            $(".DeleteConfirmed").click(function(e) {
                e.preventDefault();
                if (StudentId != '') {
                    $.ajax({
                        type: "delete",
                        url: '{{ route('Studentdelete') }}',
                        data: {student_id: StudentId},
                        success: function (data) {
                            if(data.status == 'error'){
                                StudentData.ajax.reload();
                            }else{
                                toastr.success(data.message);
                                $('#DeleteModel').modal('hide');
                                StudentData.ajax.reload();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
