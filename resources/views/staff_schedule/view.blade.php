@extends('layouts.master')

@section('staff_schedule')
active
@endsection

@section('schedule_open_menu')
active open
@endsection

@section('content')

    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Staff Schedule</h1>
                            @can('staff_schedule_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="StaffScheduleDetail" data-toggle="modal" data-target="#AddStaffScheduleModal" class="StaffScheduleDetail"><i class="fa fa-plus mr-5"></i>Staff Schedule</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>

                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6"><div id="tableTools"></div></div>
                                <div class="col-md-6"><div id="colVis"></div></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom" id="AssignStaffScheduleTable">
                                    <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Staff Name</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                        <th>subjects</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

    </section>

@endsection

@section('script')
    @include('staff_schedule.js')
@endsection

@section('Modal')
    @include('staff_schedule.add')
    @include('staff_schedule.edit')
@endsection

