@extends('layouts.master')

@section('view_roles')
active
@endsection

@section('master_menu')
active open
@endsection

@section('content')
    <section id="content">
        <div class="page page-forms-validate">
            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Add Role</h1>
                        </div>

                        <div class="tile-body">
                            <form action="{{ action('master\RoleController@update',$role->id) }}" method="post" class="form-validate-jquery AddRoleForm" data-parsley-validate name="form2" role="form">
                                @csrf
                                {{ method_field('PUT') }}
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff') !!}
                                                {!! Form::text('name',$role->name, ['class' => 'form-control name','placeholder'=>'Enter Role','id'=>'name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="row check_group">
                                        <div class="col-md-2">
                                            <h4>Student</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="check_all input-icheck"><i></i> Select All
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="student_view" {{ in_array('student_view',$rolePermissions) ? "checked" : "" }}><i></i> View
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="student_create" {{ in_array('student_create',$rolePermissions) ? "checked" : "" }}><i></i> Create
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="student_update" {{ in_array('student_update',$rolePermissions) ? "checked" : "" }}><i></i> Update
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="student_delete" {{ in_array('student_delete',$rolePermissions) ? "checked" : "" }}><i></i> Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row check_group">
                                        <div class="col-md-2">
                                            <h4>Staff</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="check_all input-icheck"><i></i> Select All
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="staff_view" {{ in_array('staff_view',$rolePermissions) ? "checked" : "" }}><i></i> View
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="staff_create" {{ in_array('staff_create',$rolePermissions) ? "checked" : "" }}><i></i> Create
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="staff_update" {{ in_array('staff_update',$rolePermissions) ? "checked" : "" }}><i></i> Update
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="staff_delete" {{ in_array('staff_delete',$rolePermissions) ? "checked" : "" }}><i></i> Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row check_group">
                                        <div class="col-md-2">
                                            <h4>Roles</h4>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="check_all input-icheck"><i></i> Select All
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="roles_view" {{ in_array('roles_view',$rolePermissions) ? "checked" : "" }}><i></i> View
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="roles_create" {{ in_array('roles_create',$rolePermissions) ? "checked" : "" }}><i></i> Create
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="roles_update" {{ in_array('roles_update',$rolePermissions) ? "checked" : "" }}><i></i> Update
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="input-icheck" name="permissions[]" value="roles_delete" {{ in_array('roles_delete',$rolePermissions) ? "checked" : "" }}><i></i> Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}

                                    @foreach ($Permissions as $key=>$Permission)
                                    <?php $count = 0; ?>
                                        <div class="row check_group">
                                            <div class="col-md-2">
                                                @if ($count == 0)
                                                    <h4>{{ $key }}</h4>
                                                @endif
                                            </div>
                                            <div class="col-md-3">
                                                <div class="checkbox">
                                                    <label>
                                                        @if ($count == 0)
                                                            <input type="checkbox" class="check_all input-icheck"><i></i> Select All
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                @foreach (getPermissionDetails($Permission) as $key1=>$PermissionDetail)
                                                <div class="col-md-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="input-icheck" name="permissions[]" value="{{ $PermissionDetail->name }}" {{ in_array($PermissionDetail->name , $rolePermissions) ? "checked" : "" }}><i></i> {{ $PermissionDetail->slug_name }}
                                                        </label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                </fieldset>

                                <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                    <button type="submit" class="btn btn-lightred">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>

                    </section>

                </div>
            </div>
            <!-- /row -->
        </div>

    </section>
@endsection

@section('script')
<script src="{{ url('public/js/icheck.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('public/js/skins/all.css') }}">
    <script>
        // $(function(){
            $('input[type="checkbox"].input-icheck, input[type="radio"].input-icheck').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
            });
        // })
        $(document).on('ifChecked', '.check_all', function() {
            $(this)
                .closest('.check_group')
                .find('.input-icheck')
                .each(function() {
                    $(this).iCheck('check');
                });
        });
        $(document).on('ifUnchecked', '.check_all', function() {
            $(this)
                .closest('.check_group')
                .find('.input-icheck')
                .each(function() {
                    $(this).iCheck('uncheck');
                });
        });
        $('.check_all').each(function() {
            var length = 0;
            var checked_length = 0;
            $(this)
                .closest('.check_group')
                .find('.input-icheck')
                .each(function() {
                    length += 1;
                    if ($(this).iCheck('update')[0].checked) {
                        checked_length += 1;
                    }
                });
            length = length - 1;
            if (checked_length != 0 && length == checked_length) {
                $(this).iCheck('check');
            }
        });
    </script>
@endsection
