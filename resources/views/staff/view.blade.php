@extends('layouts.master')

@section('view_staff')
active
@endsection

@section('staff_menu')
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
                            <h1 class="custom-font"><strong>Staff View</h1>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6"><div id="tableTools"></div></div>
                                <div class="col-md-6"><div id="colVis"></div></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom" id="advanced-usage">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Staff Name</th>
                                        <th>Qualification</th>
                                        <th>DOB</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                        @if(auth()->user()->hasAnyPermission(['staff_update','staff_delete']))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Staffs as $key=>$Staff)
                                            <tr>
                                                <td>{{ $Staff->staff_id_no }}</td>
                                                <td>{{ $Staff->staff_name }}</td>
                                                <td>{{ $Staff->qualification }}</td>
                                                <td>{{ date('d/m/Y',strtotime($Staff->dob)) }}</td>
                                                <td>{{ $Staff->mobile_number }}</td>
                                                <td>{{ $Staff->email }}</td>
                                                <td>
                                                    {!! Form::model($Staff,['url' => action('StaffController@destroy',$Staff->id),'id' => 'deleteData','method' => 'delete','enctype'=>'multipart/form-data','class'=>'form-validate-jquery']) !!}
                                                        @can('staff_update')
                                                            <a href="{{ action('StaffController@edit',$Staff->id) }}"><i class="fa fa-pencil mr-10"></i></a>
                                                        @endcan
                                                        @can('staff_delete')
                                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this Staff');" class='list-icons-item text-danger-600 btn btn-sm btn-danger'><i class='fa fa-trash'></i></button>
                                                        @endcan
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                        @endforeach
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
@endsection

@section('script')

    <script>
        $( document ).ready(function() {

            var table = $('#advanced-usage').DataTable({
                // dom: 'RlBfrtip',
                dom: '<"datatable-header"fBl><"datatable-scroll-wrap"t><"datatable-footer"ip>',
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
            });
        });
    </script>
@endsection
