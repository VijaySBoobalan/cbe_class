@extends('layouts.master')

@section('onlinetest_view')
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
                            <h1 class="custom-font"><strong>Online Tests</h1>
                            @can('batch_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="Year" data-toggle="modal" data-target="#AddOnlineTestModal"><i class="fa fa-plus mr-5"></i> Add Schedule</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="OnlineTestTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Exam Name</th>
                                        <th>Class </th>
                                        <th>Section </th>
                                        <th>From Time </th>
                                        <th>To Time </th>
                                        <th>From Date </th>
                                        <th>To Date </th>
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
    @include('onlinetest.add')
    @include('onlinetest.edit')
@endsection

@section('script')
    @include('onlinetest.js')
@endsection

