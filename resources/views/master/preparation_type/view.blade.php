@extends('layouts.master')

@section('view_preparation_type')
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
                            <h1 class="custom-font"><strong>View Preparation Type</h1>
                            @can('preparation_type_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="PreparationType" data-toggle="modal" data-target="#AddPreparationTypeModal"><i class="fa fa-plus mr-5"></i> Add Preparation Type</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="PreparationTypeTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Preparation Type</th>
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
    @include('master.preparation_type.add')
    @include('master.preparation_type.edit')
@endsection

@section('script')
    @include('master.preparation_type.js')
@endsection

