@extends('layouts.master')

@section('view_subject')
active
@endsection

@section('master_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>View Subject</h1>
                            @can('subject_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="add-entry" data-toggle="modal" data-target="#AddSubjectsModal"><i class="fa fa-plus mr-5"></i> Add Subjects</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-md-6"><div id="tableTools"></div></div>
                                    <div class="col-md-6"><div id="colVis"></div></div>
                                </div>
                                <table class="table table-custom" id="SubjectTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>Subject Name</th>
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
    @include('master.subject.add')
    @include('master.subject.edit')
@endsection

