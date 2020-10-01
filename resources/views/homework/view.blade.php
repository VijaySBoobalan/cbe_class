@extends('layouts.master')

@section('homework')
active
@endsection

@section('content')
<style>
    /* Style the tab */
    .tab {
      overflow: hidden;
      border: 1px solid #ccc;
      background-color: ##bfbdbd;
    }

    /* Style the buttons inside the tab */
    .tab button {
      background-color: inherit;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 14px 16px;
      transition: 0.3s;
      font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
      background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
      background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
      display: none;
      padding: 6px 12px;
      border: 1px solid #ccc;
      border-top: none;
    }
    </style>
    <section id="content">

        <div class="page page-tables-datatables">
            <div class="row">
                <div class="col-md-12">
                    <section class="tile">
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>View Homework</h1>
                            @can('homework_create')
                                <ul class="controls">
                                    <li>
                                        <a role="button" tabindex="0" id="classHomework" data-toggle="modal" data-target="#AddHomeworkModal"><i class="fa fa-plus mr-5"></i> Add Class Homework</a>
                                    </li>
                                    <li>
                                        <a role="button" tabindex="0" id="studentHomework" data-toggle="modal" data-target="#AddStudentHomeworkModal"><i class="fa fa-plus mr-5"></i> Add Student Homework</a>
                                    </li>
                                </ul>
                            @endcan
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="tab">
                                        <button class="tablinks defaulttab" onclick="openCity(event, 'ClassHomework')">ClassHomework</button>
                                        <button class="tablinks" onclick="openCity(event, 'StudentHomework')">StudentHomework</button>
                                    </div>
                                </div>
                            </div>
                            <div id="ClassHomework" class="tabcontent">
                                <div class="table-responsive">
                                    <table class="table table-custom" id="ClassHomeworkTable">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Class</th>
                                                <th>Section</th>
                                                <th>Subject</th>
                                                <th>Homework Date</th>
                                                <th>Submission Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>

                            <div id="StudentHomework" class="tabcontent">
                                <div class="table-responsive">
                                    <table class="table table-custom" id="StudentHomeworkTable">
                                        <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Subject</th>
                                            <th>Student</th>
                                            <th>Homework Date</th>
                                            <th>Submission Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
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
    @include('homework.add')
    @include('homework.edit')
    @include('homework.studenthomework')
    @include('homework.edit_student_homework')
    @include('homework.student_list')
@endsection

@section('script')
    @include('homework.js')

@endsection


