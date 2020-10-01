@extends('layouts.master')

@section('view_institution')
active
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>View Institution</h1>
                            <ul class="controls">
                                <li>
                                    <a role="button" tabindex="0" id="add-entry" data-toggle="modal" data-target="#AddInstitutionModal"><i class="fa fa-plus mr-5"></i> Add Institution</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6"><div id="tableTools"></div></div>
                                <div class="col-md-6"><div id="colVis"></div></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom" id="InstitutionTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>E-mail</th>
                                        <th>Mobile Number</th>
                                        <th>Admin Name</th>
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
    @include('institution.add')
    @include('institution.edit')
@endsection

@section('script')
    @include('institution.js')
@endsection
