@extends('layouts.master')

@section('view_fee_type_details')
active
@endsection

@section('fees_master_open_menu')
open
@endsection

@section('fees_master_open_menu_display')
block
@endsection

@section('fee_type_details_open_menu')
open
@endsection

@section('fee_type_details_open_menu_disply')
block
@endsection

@section('content')

<section id="content">
    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Filter</h1>
                    </div>
                    <div class="tile-body">
                        {!! Form::open(['url' => action('FeesManagement\FeesTypeController@index'),'method' => 'get','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Fee Types') !!}
                                            {!! Form::select('fee_type',$FeesMaster->pluck('fee_type','id'),$fee_type, ['class' => 'form-control chosen-select select-search','placeholder'=>'Fee Types','id'=>'fee_type']) !!}
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {!! Form::label('name', 'Name of the Fee') !!}
                                            {!! Form::text('fee_name',$fee_name, ['class' => 'form-control','placeholder'=>'Name of the Fee','id'=>'fee_name']) !!}
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                            <div class="d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary ml-3">Filter <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="page page-forms-validate">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <section class="tile">
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>View Fee Type</h1>
                    </div>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-6"><div id="tableTools"></div></div>
                            <div class="col-md-6"><div id="colVis"></div></div>
                        </div>
                        <div class="table-responsive">
                            <table class="table datatable-basic" id="mileage_Detail_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Fee Type</th>
                                        <th>Fee Name</th>
                                        <th>Fee Code</th>
                                        <th>Scholarship</th>
                                        <th>Amount</th>
                                        @if(auth()->user()->hasAnyPermission(['fee_type_update','fee_type_delete']))
                                            <th class="text-center">Actions</th>
                                        @endif
                                    </tr>
                                </thead>
                                <?php $count = 0; ?>
                                @if (isset($FeesTypes))
                                    <tbody>
                                        @foreach ($FeesTypes as $key=>$FeesType)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $FeesType->getFeesMasterName->fee_type }}</td>
                                                <td>{{ $FeesType->fee_name }}</td>
                                                <td>{{ $FeesType->fee_code }}</td>
                                                <td>{{ $FeesType->scholarship }}</td>
                                                <td>{{ $FeesType->amount }}</td>
                                                <td  class="text-center">
                                                    {!! Form::model($FeesMaster,['url' => action('FeesManagement\FeesTypeController@destroy',$FeesType->id),'method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                    @can('fee_type_update')
                                                        <a href="{{ action('FeesManagement\FeesTypeController@edit',$FeesType->id) }}" class="btn btn-xs btn-primary text-center"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                                    @endcan

                                                    @can('fee_type_delete')
                                                        <button type="submit" onclick="return confirm('Are you sure you want to delete this Fees type?');" class="btn btn-xs btn-danger delete_role_button text-center"><i class="glyphicon glyphicon-trash"></i> delete</button>
                                                    @endcan
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
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
                search: '<span>Filter:</span> _INPUT_',
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
@endsection
