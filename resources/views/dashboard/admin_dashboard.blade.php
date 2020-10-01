@extends('layouts.master')

@section('dashboard')
active
@endsection

@section('content')

    <section id="content">

        <div class="page page-dashboard">

            <div class="pageheader">

                <h2>Dashboard <span></span></h2>
                <div class="page-bar">

                    <ul class="page-breadcrumb">
                        <li>
                            <a href="{{ url("/") }}"><i class="fa fa-home"></i> TTSVLE</a>
                        </li>
                        <li>
                            <a href="{{ url("/home") }}">Dashboard</a>
                        </li>
                    </ul>
                    <div class="page-toolbar">
                        {{-- <a role="button" tabindex="0" class="btn btn-lightred no-border pickDate">
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span></span>&nbsp;&nbsp;<i class="fa fa-angle-down"></i>
                        </a> --}}
                    </div>

                </div>

            </div>

            <!-- cards row -->
            <div class="row">

                <!-- col -->
                <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                    <div class="card">
                        <div class="front bg-greensea">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-4">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-8">
                                    <p class="text-elg text-strong mb-0">{{ $students }}</p>
                                    <span>Total Students</span>
                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                        <div class="back bg-greensea">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-12">
                                    <a href={{ action('StudentController@index') }}><i class="fa fa-eye fa-2x"></i> View Student</a>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-cog fa-2x"></i> Settings</a>
                                </div> --}}
                                <!-- /col -->
                                <!-- col -->
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
                                </div> --}}
                                <!-- /col -->
                                <!-- col -->
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-ellipsis-h fa-2x"></i> More</a>
                                </div> --}}
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                    </div>
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                    <div class="card">
                        <div class="front bg-lightred">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-4">
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-8">
                                    <p class="text-elg text-strong mb-0">{{ $staffs }}</p>
                                    <span>Total Staff</span>
                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                        <div class="back bg-lightred">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-12">
                                    <a href="{{ action('StaffController@index') }}"><i class="fa fa-eye fa-2x"></i> View Staff</a>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
                                </div> --}}
                                <!-- /col -->
                                <!-- col -->
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-ellipsis-h fa-2x"></i> More</a>
                                </div> --}}
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                    </div>
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                    <div class="card">
                        <div class="front bg-blue">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-4">
                                    <i class="fa fa-money fa-4x"></i>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-8">
                                    <p class="text-elg text-strong mb-0">{{ $todayFeeCollection }}</p>
                                    <span>Today Fee Collection</span>
                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                        <div class="back bg-blue">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-12">
                                    <a href="{{ route('dateWiseFeeData') }}"><i class="fa fa-eye fa-2x"></i> View Fee Detail</a>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-cog fa-2x"></i> Settings</a>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-4">
                                    <a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-4">
                                    <a href=#><i class="fa fa-ellipsis-h fa-2x"></i> More</a>
                                </div> --}}
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                    </div>
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="card-container col-lg-3 col-sm-6 col-sm-12">
                    <div class="card">
                        <div class="front bg-slategray">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-4">
                                    <i class="fa fa-money fa-4x"></i>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-8">
                                    <p class="text-elg text-strong mb-0">{{ $balanceAmount }}</p>
                                    <span>Balance Fees</span>
                                </div>
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                        <div class="back bg-slategray">

                            <!-- row -->
                            <div class="row">
                                <!-- col -->
                                <div class="col-xs-12">
                                    <a href="{{ action('FeesManagement\FeesCollectionController@create') }}"><i class="fa fa-eye fa-2x"></i> View Fee Balance</a>
                                </div>
                                {{-- <div class="col-xs-4">
                                    <a href=#><i class="fa fa-cog fa-2x"></i> Settings</a>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-4">
                                    <a href=#><i class="fa fa-chain-broken fa-2x"></i> Content</a>
                                </div>
                                <!-- /col -->
                                <!-- col -->
                                <div class="col-xs-4">
                                    <a href=#><i class="fa fa-ellipsis-h fa-2x"></i> More</a>
                                </div> --}}
                                <!-- /col -->
                            </div>
                            <!-- /row -->

                        </div>
                    </div>
                </div>
                <!-- /col -->

            </div>
            <!-- /row -->

            <div class="row">
                <!-- col -->
                <div class="col-md-4">
                    <!-- tile -->
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Today </strong>class</h1> &nbsp ({{ date('m/d/Y') }})

                        </div>
                        <!-- /tile header -->
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6"><div id="tableTools"></div></div>
                                <div class="col-md-6"><div id="colVis"></div></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom table-responsive" id="today-class">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Subject</th>
                                            <th>Time</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($Todays_class as $key=>$value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->subject_name }}</td>
                                                <td><small class="text-primary"><?php echo date('h:i a', strtotime($value->from_time)); ?> - <?php echo date('h:i a', strtotime($value->to_time)); ?></small></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- /col -->

				<div class="col-md-4">
                    <!-- tile -->
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Tomorrow </strong>Class</h1> &nbsp ( {{ date("m/d/Y", time() + 86400) }} )

                        </div>
                      <div class="tile-body table-custom">

                            <div class="table-responsive">
                                <table class="table table-custom" id="tomorrow-class">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Time</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                        @if(empty($Tomorrows_class))
                                            <tr><td>No Class</td></tr>
                                        @endif
                                        @foreach($Tomorrows_class as $key=>$value)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $value->subject_name }}</td>
                                                <td><small class="text-primary"><?php echo date('h:i a', strtotime($value->from_time)); ?> -<?php echo date('h:i a', strtotime($value->to_time)); ?></small></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </section>
                    <!-- /tile -->
                </div>


                <!-- col -->
                <div class="col-md-4">
                    <!-- tile -->
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Staff Live Classes</strong></h1>

                        </div>
                        <!-- /tile header -->

                       <div class="tile-body table-custom">
                           <div class="table-responsive">
                               <table class="table table-custom" id="staff-live-class">
                                   <thead>
                                       <tr>
                                           <th>ID</th>
                                           <th>Staff</th>
                                           <th>Class</th>
                                       </tr>
                                   </thead>
                                   <tbody>
                                       @if (!empty($onlineClass))
                                            @foreach ($onlineClass as $key=>$item)
                                                <tr>
                                                    <td>1</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td><small class="text-primary">{{ $item->class }} ({{ $item->section }})</small></td>
                                                </tr>
                                            @endforeach
                                       @else
                                        <tr>
                                            <td colspan="3">
                                                No Staffs on live
                                            </td>
                                        </tr>
                                       @endif
                                   </tbody>
                               </table>
                           </div>
                       </div>
                    </section>
                    <!-- /tile -->
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->

            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-md-6">
                    <!-- tile -->
                    <section class="tile widget-message">

                        <!-- tile header -->
                        <div class="tile-header bg-blue dvd dvd-btm">
                            <h1 class="custom-font"><strong>Live Users</strong></h1>
                        </div>

                        <!-- tile body -->
                        <div class="tile-body table-custom">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Class') !!}
                                        {!! Form::select('class',$ClassSection->pluck('class','class') ,null, ['onchange'=>'studentAttendanceDetails();','class' => 'form-control chosen-select taken_class','placeholder'=>'Select Class','id'=>'class','required'=>'required']) !!}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Section') !!}
                                        {!! Form::select('section_id',[],null, ['onchange'=>'studentAttendanceDetails();','class' => 'form-control chosen-select section_id','placeholder'=>'Section','id'=>'section_id','required'=>'required']) !!}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Subject Name') !!}
                                        {!! Form::select('subjects',[] ,null, ['onchange'=>'studentAttendanceDetails();','class' => 'form-control chosen-select subject_details','placeholder'=>'Select Subject','id'=>'subject_details','required'=>'required']) !!}
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Date') !!}
                                        {!! Form::date('date' ,null, ['onchange'=>'studentAttendanceDetails();','class' => 'form-control date_id','placeholder'=>'Select Date','id'=>'date_id','required'=>'required']) !!}
                                        {{-- <div class="input-group datepicker" data-format="L">
                                            {!! Form::text('date', null, ['class' => 'form-control date_id','placeholder'=>'Date','id'=>'date_id','required'=>'required']) !!}
                                            <span class="input-group-addon" onclick='studentAttendanceDetails();'>
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-custom" id="project-progress">
                                    <thead>
                                        <tr>
                                            <th>Class</th>
                                            <th>Section</th>
                                            <th>Live Student</th>
                                            {{-- <th>Atteded Student</th> --}}
                                            <th>Total Student</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="Class"></td>
                                            <td class="Section"></td>
                                            <td class="LiveStudent"></td>
                                            {{-- <td class="AttendedStudent"></td> --}}
                                            <td class="TotalStudent"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /tile body -->

                    </section>
                    <!-- /tile -->
                </div>
                <!-- /col -->

                <!-- col -->
                <div class="col-md-6">
                    <!-- tile -->
                    <section class="tile bg-greensea widget-appointments">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Online Exam Details</strong></h1>

                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                       <div class="tile-body table-custom">

                            <div class="table-responsive">
                                <h1>On Processing...</h1>
                            </div>

                        </div>

                    </section>
                    <!-- /tile -->
                </div>
                <!-- /col -->



                <!-- col -->
                {{-- <div class="col-md-4">
                    <!-- tile -->
                    <section class="tile widget-chat">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font">Chats</h1>
                            <ul class="controls">
                                <li class="dropdown">

                                    <a role="button" tabindex="0" class="dropdown-toggle" data-toggle="dropdown">John Douey <i class="fa fa-angle-down ml-5"></i></a>

                                    <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                        <li>
                                            <a role="button" tabindex="0">Imrich Kamarell</a>
                                        </li>
                                        <li>
                                            <a role="button" tabindex="0">Arnold Schwarz</a>
                                        </li>
                                        <li>
                                            <a role="button" tabindex="0">Deel McApple</a>
                                        </li>

                                    </ul>

                                </li>
                                <li class="dropdown">

                                    <a role="button" tabindex="0" class="dropdown-toggle settings" data-toggle="dropdown">
                                        <i class="fa fa-cog"></i>
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </a>

                                    <ul class="dropdown-menu pull-right with-arrow animated littleFadeInUp">
                                        <li>
                                            <a role="button" tabindex="0" class="tile-toggle">
                                                <span class="minimize"><i class="fa fa-angle-down"></i>&nbsp;&nbsp;&nbsp;Minimize</span>
                                                <span class="expand"><i class="fa fa-angle-up"></i>&nbsp;&nbsp;&nbsp;Expand</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a role="button" tabindex="0" class="tile-refresh">
                                                <i class="fa fa-refresh"></i> Refresh
                                            </a>
                                        </li>
                                        <li>
                                            <a role="button" tabindex="0" class="tile-fullscreen">
                                                <i class="fa fa-expand"></i> Fullscreen
                                            </a>
                                        </li>
                                    </ul>

                                </li>
                                <li class="remove"><a role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>
                            </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div id="scrollDiv"class="tile-body slim-scroll" style="max-height: 320px;overflow:auto;">

                            <ul class="chats p-0">
                                <li class="in">
                                    <div class="media">
                                        <div class="pull-left thumb thumb-sm">
                                            <img class="media-object img-circle" src="assets/images/random-avatar2.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name">John Douey </a><span class="datetime">at 12.10.2014</span></p>
                                            <span class="body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="out">
                                    <div class="media">
                                        <div class="pull-right thumb thumb-sm">
                                            <img class="media-object img-circle" src="assets/images/random-avatar1.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name">You </a><span class="datetime">2 hours ago</span></p>
                                            <span class="body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="in">
                                    <div class="media">
                                        <div class="pull-left thumb thumb-sm">
                                            <img class="media-object img-circle" src="assets/images/random-avatar2.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name">John Douey </a><span class="datetime">2 hours ago</span></p>
                                            <span class="body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="out">
                                    <div class="media">
                                        <div class="pull-right thumb thumb-sm">
                                            <img class="media-object img-circle" src="assets/images/random-avatar1.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name">You </a><span class="datetime">1 hours ago</span></p>
                                            <span class="body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="in">
                                    <div class="media">
                                        <div class="pull-left thumb thumb-sm">
                                            <img class="media-object img-circle" src="assets/images/random-avatar2.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name">John Douey </a><span class="datetime">53 minutes ago</span></p>
                                            <span class="body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="out">
                                    <div class="media">
                                        <div class="pull-right thumb thumb-sm">
                                            <img class="media-object img-circle" src="assets/images/random-avatar1.jpg" alt="">
                                        </div>
                                        <div class="media-body">
                                            <p class="media-heading"><a role="button" tabindex="0" class="name">You </a><span class="datetime">40 minutes ago</span></p>
                                            <span class="body">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>


                        </div>
                        <!-- /tile footer -->

                    </section>
                    <!-- /tile -->
                </div> --}}
                <!-- /col -->

                <!-- col -->
                {{-- <div class="col-md-4">
                    <!-- tile -->
                    <section class="tile bg-greensea widget-appointments">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Exam Results</strong></h1>

                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                       <div class="tile-body table-custom">

                            <div class="table-responsive">
                                <table class="table table-custom" id="project-progress">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Project</th>
                                        <th>Priority</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Email server backup</td>
                                            <td><small class="text-warning">Normal Priority</small></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /tile body -->

                        <!-- tile footer -->
                        <div class="tile-footer dvd dvd-top mt-20">



                        </div>
                        <!-- /tile footer -->

                    </section>
                    <!-- /tile -->
                </div> --}}
                <!-- /col -->

            </div>
            <!-- /row -->

        </div>

        </div>

    </section>

@endsection

@section('script')

    <script>
        $( document ).ready(function() {
            var table = $('#today-class').DataTable({
                dom: '<"datatable-header"><"datatable-scroll-wrap"t><"datatable-footer">',
                "scrollY":        "200px",
                "scrollCollapse": true,
                responsive: true,
                autoWidth: false,
            });

            var table = $('#tomorrow-class').DataTable({
                dom: '<"datatable-header"><"datatable-scroll-wrap"t><"datatable-footer">',
                "scrollY":        "200px",
                "scrollCollapse": true,
                responsive: true,
                autoWidth: false,
            });

            var table = $('#staff-live-class').DataTable({
                dom: '<"datatable-header"><"datatable-scroll-wrap"t><"datatable-footer">',
                "scrollY":        "200px",
                "scrollCollapse": true,
                responsive: true,
                autoWidth: false,
            });
        });
    </script>

    <script>
        var SelectSection = 0;
        var SelectSubject = 0;
        $(window).load(function(){
			 $(document).ready(function(){
		 scrollchat();
		 function scrollchat(){

            $("#scrolldiv").scrollTop(2000);
		 }
         });
            // Initialize Statistics chart
            var data = [{
                data: [[1,15],[2,40],[3,35],[4,39],[5,42],[6,50],[7,46],[8,49],[9,59],[10,60],[11,58],[12,74]],
                label: 'Unique Visits',
                points: {
                    show: true,
                    radius: 4
                },
                splines: {
                    show: true,
                    tension: 0.45,
                    lineWidth: 4,
                    fill: 0
                }
            }, {
                data: [[1,50],[2,80],[3,90],[4,85],[5,99],[6,125],[7,114],[8,96],[9,130],[10,145],[11,139],[12,160]],
                label: 'Page Views',
                bars: {
                    show: true,
                    barWidth: 0.6,
                    lineWidth: 0,
                    fillColor: { colors: [{ opacity: 0.3 }, { opacity: 0.8}] }
                }
            }];

            var options = {
                colors: ['#e05d6f','#61c8b8'],
                series: {
                    shadowSize: 0
                },
                legend: {
                    backgroundOpacity: 0,
                    margin: -7,
                    position: 'ne',
                    noColumns: 2
                },
                xaxis: {
                    tickLength: 0,
                    font: {
                        color: '#fff'
                    },
                    position: 'bottom',
                    ticks: [
                        [ 1, 'JAN' ], [ 2, 'FEB' ], [ 3, 'MAR' ], [ 4, 'APR' ], [ 5, 'MAY' ], [ 6, 'JUN' ], [ 7, 'JUL' ], [ 8, 'AUG' ], [ 9, 'SEP' ], [ 10, 'OCT' ], [ 11, 'NOV' ], [ 12, 'DEC' ]
                    ]
                },
                yaxis: {
                    tickLength: 0,
                    font: {
                        color: '#fff'
                    }
                },
                grid: {
                    borderWidth: {
                        top: 0,
                        right: 0,
                        bottom: 1,
                        left: 1
                    },
                    borderColor: 'rgba(255,255,255,.3)',
                    margin:0,
                    minBorderMargin:0,
                    labelMargin:20,
                    hoverable: true,
                    clickable: true,
                    mouseActiveRadius:6
                },
                tooltip: true,
                tooltipOpts: {
                    content: '%s: %y',
                    defaultTheme: false,
                    shifts: {
                        x: 0,
                        y: 20
                    }
                }
            };

            var plot = $.plot($("#statistics-chart"), data, options);

            $(window).resize(function() {
                // redraw the graph in the correctly sized div
                plot.resize();
                plot.setupGrid();
                plot.draw();
            });
            // * Initialize Statistics chart

            //Initialize morris chart
            Morris.Donut({
                element: 'browser-usage',
                data: [
                    {label: 'Chrome', value: 25, color: '#00a3d8'},
                    {label: 'Safari', value: 20, color: '#2fbbe8'},
                    {label: 'Firefox', value: 15, color: '#72cae7'},
                    {label: 'Opera', value: 5, color: '#d9544f'},
                    {label: 'Internet Explorer', value: 10, color: '#ffc100'},
                    {label: 'Other', value: 25, color: '#1693A5'}
                ],
                resize: true
            });
            //*Initialize morris chart


            // Initialize owl carousels
            $('#todo-carousel, #feed-carousel, #notes-carousel').owlCarousel({
                autoPlay: 5000,
                stopOnHover: true,
                slideSpeed : 300,
                paginationSpeed : 400,
                singleItem : true,
                responsive: true
            });

            $('#appointments-carousel').owlCarousel({
                autoPlay: 5000,
                stopOnHover: true,
                slideSpeed : 300,
                paginationSpeed : 400,
                navigation: true,
                navigationText : ['<i class=\'fa fa-chevron-left\'></i>','<i class=\'fa fa-chevron-right\'></i>'],
                singleItem : true
            });
            //* Initialize owl carousels


            // Initialize rickshaw chart
            var graph;

            var seriesData = [ [], []];
            var random = new Rickshaw.Fixtures.RandomData(50);

            for (var i = 0; i < 50; i++) {
                random.addData(seriesData);
            }

            graph = new Rickshaw.Graph( {
                element: document.querySelector("#realtime-rickshaw"),
                renderer: 'area',
                height: 133,
                series: [{
                    name: 'Series 1',
                    color: 'steelblue',
                    data: seriesData[0]
                }, {
                    name: 'Series 2',
                    color: 'lightblue',
                    data: seriesData[1]
                }]
            });

            var hoverDetail = new Rickshaw.Graph.HoverDetail( {
                graph: graph,
            });

            graph.render();

            setInterval( function() {
                random.removeData(seriesData);
                random.addData(seriesData);
                graph.update();

            },1000);
            //* Initialize rickshaw chart

            //Initialize mini calendar datepicker
            $('#mini-calendar').datetimepicker({
                inline: true
            });
            //*Initialize mini calendar datepicker


            //todo's
            $('.widget-todo .todo-list li .checkbox').on('change', function() {
                var todo = $(this).parents('li');

                if (todo.hasClass('completed')) {
                    todo.removeClass('completed');
                } else {
                    todo.addClass('completed');
                }
            });
            //* todo's


            //initialize datatable
            $('#project-progress').DataTable({
                "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ "no-sort" ] }
                ],
            });
            //*initialize datatable

            //load wysiwyg editor
            $('#summernote').summernote({
                toolbar: [
                    //['style', ['style']], // no style button
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    //['insert', ['picture', 'link']], // no insert buttons
                    //['table', ['table']], // no table button
                    //['help', ['help']] //no help button
                ],
                height: 143   //set editable area's height
            });
            //*load wysiwyg editor
        });

        $(document).on('ready',function(){
            $('.taken_class').on('change',function(){
                var student_class = $('.taken_class').val();
                var selectHTML = "";
                if(student_class != ''){
                    $.ajax({
                        type: "get",
                        url: '{{ route("getSection") }}',
                        data:{student_class:student_class},
                        success: function(data) {
                            for (var key in data) {
                                var row = data[key];
                                selectHTML += "<option value='" + row.id + "'>" + row.section + "</option>";
                            }
                            $('.section_id').html(selectHTML);
                            $('.section_id').val(SelectSection).trigger("chosen:updated");
                            if(SelectSection =="0"){
                                SelectSection = "";
                            }
                        }
                    });
                }
            })

            $('.section_id').on('change',function(){
                return new Promise(resolve => {
                    var taken_class = $('.taken_class').val();
                    var section_id = $('.section_id').val();
                    var selectHTML = "";
                    if(taken_class!="" && section_id!="" ){
                        axios.get("{{ action('StaffSubjectAssignController@create') }}",{params: {"class_id": taken_class , "section_id": section_id } }).then(response => {
                            for (var key in response.data) {
                                var row = response.data[key];
                                selectHTML += "<option value=" + row.id + ">" + row.subject_name + "</option>";
                            }
                            $('.subject_details').html(selectHTML);
                            $('.subject_details').val(SelectSubject).trigger('chosen:updated');
                            resolve(1)
                        }).catch(error => {
                            console.log(error);
                        })
                    }
                })
            });
        });

        function studentAttendanceDetails() {
            var taken_class = $('.taken_class').val();
            var section_id = $('.section_id').val();
            var subject_details = $('.subject_details').val();
            var date = $('.date_id').val();
            if(taken_class!="" && section_id!="" && subject_details!=""&& date!=""){
                $.ajax({
                    type: "get",
                    url: '{{ url("/getStudentDetails") }}',
                    data:{taken_class : taken_class , section_id : section_id , subject_details : subject_details , date : date } ,
                    success: function(data) {
                        $('.Class').html(taken_class);
                        $('.Section').html(data.ClassSection.section);
                        $('.LiveStudent').html(data.LiveStudent);
                        $('.AttendedStudent').html(data.AttendedStudent);
                        $('.TotalStudent').html(data.StudentCount);
                    }
                });
                console.log(taken_class,section_id,subject_details);
            }
        }
    </script>
@endsection
