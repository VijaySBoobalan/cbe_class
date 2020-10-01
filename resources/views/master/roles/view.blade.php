@extends('layouts.master')

@section('view_roles')
active
@endsection

@section('master_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Roles</h1>
                            @can('roles_create')
                                <ul class="controls">
                                    <li>
                                        <a href="{{ action('master\RoleController@create') }}" role="button" tabindex="0" data-toggle="modal"><i class="fa fa-plus mr-5"></i>Add Roles</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-md-6"><div id="tableTools"></div></div>
                                    <div class="col-md-6"><div id="colVis"></div></div>
                                </div>
                                <table class="table table-custom" id="AddRoleTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <!-- /tile body -->
                        <meta name="csrf-token" content="{{ csrf_token() }}">
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

        var AddRoleTable= $('#AddRoleTable').DataTable({
            processing: true,
            serverSide: false,
            responsive: true,
            autoWidth: false,
            ajax: '{{ action('master\RoleController@index') }}',
            "columns": [
                { data: 'DT_RowIndex' },
                { data: 'name' },
                { data: 'action', orderable: false, searchable: false },
            ]
        });

        // $('#AddSubject').on('click', function(){
        //     $('#AddSubjectForm').valid();
        // });

        $.validator.setDefaults({
            errorElement: "span",
            errorClass: "help-block",
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
                else {
                    error.insertAfter(element);
                }
            }
        });

    </script>
@endsection
