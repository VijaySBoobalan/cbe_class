@extends('layouts.master')

@section('view_segregation')
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
                            <h1 class="custom-font"><strong>View Segregation</h1>
                            @can('segregation_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="Segregation" data-toggle="modal" data-target="#AddSegregationModal"><i class="fa fa-plus mr-5"></i> Add Segregation</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="SegregationTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Question Type</th>
                                        <th>Segregation</th>
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
    @include('master.segregation.add')
    @include('master.segregation.edit')
@endsection

@section('script')
    @include('master.segregation.js')
@endsection

