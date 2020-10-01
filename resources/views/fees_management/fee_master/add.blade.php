@extends('layouts.master')

@section('add_fees_master_details')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('content')

<section id="content">

    @can('fee_master_create')
        <div class="page page-forms-validate">

            <!-- row -->
            <div class="row">


                <div class="col-md-12">

                    <section class="tile">

                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Fee Master</h1>

                        </div>

                        <div class="tile-body">

                            @if(isset($FeesMaster))
                                {!! Form::model($FeesMaster,['url' => action('FeesManagement\FeesMasterController@update',$FeesMaster->id),'method' => 'put','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                            @else
                                {!! Form::open(['url' => action('FeesManagement\FeesMasterController@store'),'method' => 'post','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                            @endif
                                @csrf
                                <fieldset>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                {!! Form::label('name', 'Fee Type') !!}
                                                {!! Form::text('fee_type', null, ['class' => 'form-control','placeholder'=>'Fee Type','id'=>'fee_type']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button type="submit" id="add_btn" class="btn btn-primary ml-3">Save <i class="icon-paperplane ml-2"></i></button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </section>
                </div>
            </div>
        </div>
    @endcan

    @can('fee_master_view')
        @if(isset($FeesMasters))
            <div class="page page-tables-datatables">
                <div class="row">
                    <div class="col-md-12">
                        <section class="tile">
                            <div class="tile-header dvd dvd-btm">
                                <h1 class="custom-font"><strong>View Fee Master</h1>
                            </div>
                            <!-- /tile header -->

                            <!-- tile body -->
                            <div class="tile-body">
                                <div class="row">
                                    <div class="col-md-6"><div id="tableTools"></div></div>
                                    <div class="col-md-6"><div id="colVis"></div></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table datatable-basic" id="mess_menu_table">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Menu Name</th>
                                                @if(auth()->user()->hasAnyPermission(['fee_master_update','fee_master_delete']))
                                                    <th class="text-center">Actions</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($FeesMasters as $key=>$FeesMaster)
                                                <tr>
                                                    <th>{{ ++$key }}</th>
                                                    <th>{{ $FeesMaster->fee_type }}</th>
                                                    <th class="text-center">
                                                        {!! Form::model($FeesMaster,['url' => action('FeesManagement\FeesMasterController@destroy',$FeesMaster->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                        @can('fee_master_update')
                                                            <a href="{{ action('FeesManagement\FeesMasterController@edit',$FeesMaster->id) }}" class="btn btn-xs btn-primary text-center"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                                        @endcan
                                                        @can('fee_master_delete')
                                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class="btn btn-xs btn-danger delete_role_button text-center"><i class="glyphicon glyphicon-trash"></i> delete</button>
                                                        @endcan
                                                        {!! Form::close() !!}
                                                    </th>
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

        @endif
    @endcan
<script>
    $(window).load(function(){
        // Setting datatable defaults
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

        // Basic datatable
        var table = $('.datatable-basic').DataTable({
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
    });
</script>
</section>
@endsection
