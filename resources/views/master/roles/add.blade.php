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
                            <form action="{{ action('master\RoleController@store') }}" method="post" class="form-validate-jquery AddRoleForm" data-parsley-validate name="form2" role="form">
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Staff') !!}
                                                {!! Form::text('name',null, ['class' => 'form-control name','placeholder'=>'Enter Role','id'=>'name','required'=>'required']) !!}
                                            </div>
                                        </div>
                                    </div>

                                    @foreach ($Permissions as $key=>$Permission)
                                        <div class="row check_group">
                                            <div class="col-lg-2">
                                                <h4>{{ $key }}</h4>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" class="check_all input-icheck"><i></i> Select All
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                @foreach ($Permission as $key1=>$PermissionDetail)
                                                <div class="col-lg-12">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" class="input-icheck" name="permissions[]" value="{{ $PermissionDetail->name }}"><i></i> {{ $PermissionDetail->slug_name }}
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
