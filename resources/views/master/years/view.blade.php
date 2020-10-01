@extends('layouts.master')

@section('view_years')
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
                            <h1 class="custom-font"><strong>View Year</h1>
                            @can('years_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="Year" data-toggle="modal" data-target="#AddYearModal"><i class="fa fa-plus mr-5"></i> Add Year</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="YearTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Year</th>
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
    @include('master.years.add')
    @include('master.years.edit')
@endsection

@section('script')
    @include('master.years.js')
@endsection

