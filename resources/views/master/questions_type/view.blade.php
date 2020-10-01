@extends('layouts.master')

@section('view_questions_type')
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
                            <h1 class="custom-font"><strong>View Question Types</h1>
                            @can('questions_type_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="QuestionTypes" data-toggle="modal" data-target="#AddQuestionTypesModal"><i class="fa fa-plus mr-5"></i> Add Question Types</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <table class="table table-custom" id="QuestionTypesTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Question Types</th>
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
    @include('master.questions_type.add')
    @include('master.questions_type.edit')
@endsection

@section('script')
    @include('master.questions_type.js')
@endsection

