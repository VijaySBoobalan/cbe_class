@extends('layouts.master')

@section('batch_view')
active
@endsection

@section('online_test_master_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>View Batch</h1>
                            @can('batch_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="Year" data-toggle="modal" data-target="#AddBatchModal"><i class="fa fa-plus mr-5"></i> Add Batch</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="BatchTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Batch Name</th>
                                        <th>No. Of Students </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
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

@section('Modal')
    @include('master.batch.add')
    @include('master.batch.edit')
@endsection

@section('script')
    @include('master.batch.js')
@endsection

