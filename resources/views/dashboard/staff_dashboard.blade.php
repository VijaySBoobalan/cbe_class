@extends('layouts.master')

@section('dashboard')
active
@endsection

@section('content')

@if (auth()->user()->is_password_changed == 0)

    <div class="modal fade ChangePasswordModal" id="ChangePasswordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="row">
                    <div class="col-md-12">
                        <section class="tile">
                            <div class="tile-header dvd dvd-btm">
                                <h1 class="custom-font"><strong>Change Your Password</h1>
                            </div>

                            <div class="tile-body">

                                <form action="{{ route("passwordReset") }}" id="ChangePasswordForm" method="post" class="form-validate-jquery ChangePasswordForm" data-parsley-validate name="form2" role="form">
                                    @csrf
                                    <fieldset>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Password') !!}
                                                    {!! Form::password('password', ['onkeyup'=>'checkpassword();','class' => 'form-control','placeholder'=>'Enter Your New Password','id'=>'password','required'=>'required']) !!}
                                                    <span id="PasswordLength" style="color:red;"></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    {!! Form::label('name', 'Conform Password') !!}
                                                    {!! Form::password('conform_password', ['onkeyup'=>'checkpassword();','class' => 'form-control','placeholder'=>'Enter Your New Confirm-Password','id'=>'conform_password','required'=>'required']) !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6" id="PasswordMatch" style="color:green;">
                                            </div>
                                            <div class="col-lg-6" id="PasswordDonnotMatch" style="color:red;">
                                            </div>
                                        </div>
                                    </fieldset>

                                    <div class="tile-footer text-right bg-tr-black lter dvd dvd-top">
                                        <button type="submit" class="btn btn-lightred ChangePassword" id="ChangePassword" disabled>Save</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script type="text/javascript" src="https://www.technicalkeeda.com/js/javascripts/plugin/jquery.js"></script>
    <script type="text/javascript" src="https://www.technicalkeeda.com/js/javascripts/plugin/jquery.validate.js"></script> --}}
    <script>
        $(window).load(function() {
            $("#ChangePasswordModal").modal('show');
        });

        function checkpassword() {
            var password = $("#password").val();
            var confirmPassword = $("#conform_password").val();
                if(password.length >=6){
                    $('#PasswordLength').hide();
                    if (password == confirmPassword){
                        if(password!=""){
                            $('.ChangePassword').prop('disabled',false);
                            $('#PasswordMatch').show();
                            $('#PasswordMatch').html('Password is Match');
                            $('#PasswordDonnotMatch').hide();
                        }
                    }else{
                        if(confirmPassword!=""){
                            $('.ChangePassword').prop('disabled',true);
                            $('#PasswordDonnotMatch').show();
                            $('#PasswordDonnotMatch').html('Password Does not Match');
                            $('#PasswordMatch').hide();
                        }
                    }
            }else{
                $('#PasswordMatch').hide();
                $('#PasswordDonnotMatch').hide();
                $('#PasswordLength').show();
                $('#PasswordLength').html('Min 6 Charectors');
            }
        }

        function passwordCheck(password){
        //regular expression for password
            var pattern = /^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%&]).*$/;
            if(pattern.test(password)){
                return true;
            }else{
                return false;
            }
        }

    </script>

@endif

<section id="content">

    <div class="page page-dashboard">

        <div class="pageheader">

            <h2>Staff <span></span></h2>

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
        <!-- row -->
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

                    <!-- tile body -->
                    <div class="tile-body">

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
                                            <td><small class="text-primary"><?php echo date('h:i:s a', strtotime($value->from_time)); ?> -<?php echo date('h:i:s a', strtotime($value->to_time)); ?></small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /tile body -->

                </section>
                <!-- /tile -->
            </div>
            <!-- /col -->


            <div class="col-md-4">
                <!-- tile -->
                <section class="tile">

                    <!-- tile header -->
                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong>Tomorrow </strong>Class</h1> &nbsp ( {{ date("m/d/Y", time() + 86400) }} )

                    </div>
                    <div class="tile-body">

                        <div class="table-responsive">
                            <table class="table table-custom table-responsive" id="tomorrow-class">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Subject</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($Tomorrows_class as $key=>$value)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $value->subject_name }}</td>
                                            <td><small class="text-primary"><?php echo date('h:i:s a', strtotime($value->from_time)); ?> -<?php echo date('h:i:s a', strtotime($value->to_time)); ?></small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </section>
                <!-- /tile -->
            </div>

            <div class="col-lg-4">
                <!-- tile -->
                <section class="tile">

                    <!-- tile header -->
                    <div class="tile-header bg-blue dvd dvd-btm">
                        <h1 class="custom-font"><strong>Attendance </strong></h1>
                    </div>
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'From Date') !!}
                                    {!! Form::date('from_date', date('Y-m-d'), ['onchange'=>'getAttendanceDetails();','class' => 'form-control from_date','placeholder'=>'Email','id'=>'from_date','required'=>'required']) !!}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    {!! Form::label('name', 'To Date') !!}
                                    {!! Form::date('to_date', date('Y-m-d'), ['onchange'=>'getAttendanceDetails();','class' => 'form-control DateAttr to_date','placeholder'=>'Email','id'=>'to_date','required'=>'required']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-responsive" id="attendance">
                                <thead>
                                    <tr>
                                        <th>S.no</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                </tbody> --}}
                            </table>
                        </div>
                    </div>

                </section>
                <!-- /tile -->
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')

    <script>
        var attendance = "";
        var data = [];

        dataTable(data);

        function dataTable(data) {
            attendance= $('#attendance').DataTable({
                dom: '<"datatable-header"><"datatable-scroll-wrap"t><"datatable-footer">',
                "bDestroy": true,
                // "scrollY":        "200px",
                "scrollCollapse": true,
                responsive: true,
                autoWidth: false,
                ajax:{
                    url:"{{ route('StaffClassDetail') }}",
                    data:data,
                },
                "columns": [
                    { data: 'DT_RowIndex' },
                    { data: 'date' },
                    { data: 'status' },
                ],
            });
        }
        // getAttendanceDetails();
        function getAttendanceDetails(){
            var staff_id = '{{ auth()->user()->user_id }}';
            var from_date = $('.from_date').val();
            var to_date = $('.to_date').val();
            dataTable({staff_id : staff_id ,from_date : from_date ,to_date : to_date });
        }

        $( document ).ready(function() {
            var todayclass = $('#today-class').DataTable({
                dom: '<"datatable-header"><"datatable-scroll-wrap"tp><"datatable-footer">',
                "scrollY":        "200px",
                "scrollCollapse": true,
                responsive: true,
                autoWidth: false,
            });

            var tomorowClass = $('#tomorrow-class').DataTable({
                dom: '<"datatable-header"><"datatable-scroll-wrap"tp><"datatable-footer">',
                "scrollY":        "200px",
                "scrollCollapse": true,
                responsive: true,
                autoWidth: false,
            });
        });

        $(window).load(function(){
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
    </script>
@endsection
