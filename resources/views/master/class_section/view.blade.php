@extends('layouts.master')

@section('view_class_section')
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
                            <h1 class="custom-font"><strong>View Class/Section</h1>
                            {{-- @can('class_section_create') --}}
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="ClassSection" data-toggle="modal" data-target="#AddClassSectionModal"><i class="fa fa-plus mr-5"></i> Add Class/Section</a>
                                    </li>
                                </ul>
                            {{-- @endcan --}}
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="table-responsive">
                                <div class="row">
                                    <div class="col-md-6"><div id="tableTools"></div></div>
                                    <div class="col-md-6"><div id="colVis"></div></div>
                                </div>
                                <table class="table table-custom" id="ClassSectionTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Class</th>
                                        <th>Section</th>
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
    @include('master.class_section.add')
    @include('master.class_section.edit')
@endsection

@section('script')
    @include('master.class_section.js')
@endsection

