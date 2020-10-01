@extends('layouts.master')

@section('staff_schedule')
active
@endsection

@section('content')

<style>
    .mhov {
        background-color: #f1f442;
    }

    #mctable tbody tr td:hover {
        background-color: #42f45f;
    }

    .log_table tbody tr td:hover {
        background-color: #42f45f;
    }

    #mydiv {
        position: absolute;
        z-index: 9;

        text-align: center;

    }

    #videodiv {
        padding: 10px;
        cursor: move;
        z-index: 10;

        color: #fff;
    }

    .toggle.btn {
        min-width: 47px;
        min-height: 25px;
        float: right !important;
        margin-top: -26px;
    }

    li.listening_list {
        border: 1px solid #3a3838;
    }

    .media-heading.student_name {
        color: #ffdfdf;
        font-size: 16px;
        text-transform: capitalize;
    }
</style>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/7.4.0/adapter.min.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js">
</script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>


<script src="{{ url('public/js/janus.js') }}"></script>
<script src="{{ url('public/js/screensharingtest.js') }}"></script>
<section id="content">
    <div class="row">
        <div class="main-fullscreen">
            <div class="page page-forms-validate">
                <!-- row -->
                <div class="row">
                    <div class="col-md-3">
                        <button class="btn btn-primary" autocomplete="off" id="start" style="display: none;">Share Screen</button>
                    </div>

                    <div class="col-md-3">
                        <select id="allowed_mic_list" class="form-control" style="display:none">
                            <option>--Disallow Mics</option>
                        </select>
                    </div>
                    <div class="col-md-1" style="float:right" data-action="fullscreen">
                        <button class="btn btn-primary" autocomplete="off" id="start">FullScreen</button>
                    </div>
                </div>

                <div style="display:none">
                    <video id="videoElement" autoplay muted style="display:none"></video>
                    <button id="startBtn" class="btn btn-primary" style="display: none;" disabled>Start Recording</button>
                    <button id="stopBtn" class="btn btn-danger" style="display: none;" disabled>Stop Recording</button>

                    <input type="checkbox" id="audioToggle" />
                    <label for="audioToggle">Capture Audio from Desktop</label>
                    <input type="checkbox" id="micAudioToggle" checked />
                    <label for="micAudioToggle">Capture Audio from Microphone</label>
                </div>


                {{-- <div class="col-md-2 pull-right text-right">
                <li class="toggle-right-sidebar" style="display:inline;">
                    <!-- <a href="#">
                        <span class="label bg-red">Live</span>
                    </a> -->

        <button class="link-effect link-effect-2 " autocomplete="off"><span class="bg-red"
                data-hover="LIVE">LIVE</span></button>
        </li>
    </div> --}}

            </div>
            <br>
            <div class="row">
                <div class="audioinput" style="display:none">
                    <div class="container hide" id="screenmenu">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="input-group margin-bottom-md hide" id="createnow">
                                    <span class="input-group-addon"><i class="fa fa-users fa-1"></i></span>
                                    <input class="form-control" type="text" placeholder="Insert a title for the session" autocomplete="off" id="desc" value="{{ $class_id }}" onkeypress="return checkEnterShare(this, event);" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" autocomplete="off" id="create">Share</button>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                {{-- MIC START --}}
                <div class="audioinput" style="display:none">
                    <div class="container hide" id="audiojoin">
                        <div class="row">
                            <span class="label label-info" id="you"></span>
                            <div class="col-md-12" id="controls">
                                <div class="input-group margin-bottom-md hide" id="registernow">
                                    <span class="input-group-addon">@</span>
                                    <input class="form-control" type="text" value="{{ auth()->user()->name }}" placeholder="Choose a display name" autocomplete="off" id="username" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" autocomplete="off" id="register">Share mic
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- MIC END --}}
                <div class="container hide" id="room">
                    <div class="row">
                        <div class="col-md-6" style="display:none">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Mixed Audio</h3>
                                </div>
                                <div class="panel-body" id="mixedaudio"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php
                    $InTime = date('H:i');
                    $StaffScheduleSubjectDetails = App\StaffScheduleSubjectDetails::where('id',$scheduleclass_id)->first();
                    $totime = \Carbon\Carbon::createFromFormat('H:i', $StaffScheduleSubjectDetails->to_time);
                    $fromtime = \Carbon\Carbon::createFromFormat('H:i', $StaffScheduleSubjectDetails->from_time);
                    $ExitTime = $totime->diffInMinutes($fromtime);
                    $ScreenShareTime = $fromtime->diffInMinutes($InTime);
                    $ScreenShareButtonEnableTime = $ScreenShareTime - 1;
                    $IntimationTime = $ExitTime - 5;
                ?>

                <!-- col -->
                <div class="col-md-6">

                    <!-- tile -->
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Document Viewer </strong></h1>
                            <ul class="controls">
                                <li class="remove"><a role="button" tabindex="0" onclick="document.getElementById('common_upload').click();"><i class="fa fa-upload" id="upload_file"></i></a></li>
                                <input type="file" id="common_upload" name="file" style="display: none;">
                                <span id="uploading_file"></span>
                                <input type="hidden" name="class" id="class_id" value="{{ $class_id }}">
                                <input type="hidden" name="section_id" id="section_id" value="{{ $section_id }}">
                                <input type="hidden" name="subject_id" id="subject_id" value="{{ $subject_id }}">
                                <input type="hidden" name="scheduleclass_id" id="scheduleclass_id" value="{{ $scheduleclass_id }}">
                                <li class="remove"><a role="button" tabindex="0" data-toggle="modal" data-target="#common_files_modal" id="getDocumentList"><i class="fa fa-list"></i></a>
                                </li>
                                <li class="remove"><a role="button" tabindex="0" data-action="fullscreen" id="Documentfullscreen"><i class="fa fa-expand"></i></a></li>
                            </ul>

                        </div>

                        <!-- tile body -->
                        <div class="tile-body">
                            <span class="AppendDocs"></span>
                        </div>
                        <!-- /tile body -->

                    </section>

                    <!-- /tile -->
                </div>

                <!-- col -->
                <div class="col-md-6">

                    <!-- tile -->
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm">
                            <h1 class="custom-font"><strong>Image Viewer </strong></h1>
                            <ul class="controls">
                                <li class="remove"><a role="button" tabindex="0" onclick="document.getElementById('image_upload').click();"><i class="fa fa-upload"></i></a></li>
                                <input type="file" id="image_upload" style="display: none;">
                                <span id="uploading_image"></span>
                                <li class="remove"><a role="button" tabindex="0" data-toggle="modal" data-target="#image_files_modal" id="getImageList"><i class="fa fa-list"></i></a>
                                </li>
                                <li class="remove"><a role="button" tabindex="0" data-action="fullscreen"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                        <!-- /tile header -->

                        <!-- tile body -->
                        <div class="tile-body ">
                            {{-- <div class="AppendImage text-center"> --}}
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators carouselimageList">
                                    </ol>

                                    <div class="carousel-inner sliderimageList" role="listbox">
                                    </div>
                                    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            {{-- </div> --}}
                        </div>
                        <!-- /tile body -->
                    </section>

                    <!-- /tile -->
                </div>
                <!-- /col -->
            </div>
            <!-- /row -->
            <!-- row -->
            <div class="row">
                <!-- col -->
                <div class="col-md-12">

                    <!-- tile -->
                    <section class="tile">

                        <!-- tile header -->
                        <div class="tile-header dvd dvd-btm" style="padding:0 !important">
                            <!-- <h1 class="custom-font"><strong>Editor </strong></h1> -->
                            <ul class="nav nav-tabs">
                                <li role="presentation" class="active"><a href="#drawing_board" role="tab" data-toggle="tab">White Board</a></li>
                                <li role="presentation"><a href="#summernote_editor" role="tab" data-toggle="tab">Editor</a>
                                </li>
                                <li role="presentation"><a target="_blank" href="http://visualmatheditor.equatheque.net/VisualMathEditor.html">Maths Editor</a>

                                </li>
                                <li role="presentation"><a href="#calc_tab" role="tab" data-toggle="tab">Calculator</a></li>
                                <li role="presentation"><a href="{{ url('/graphingTool') }}" target="_blank">Graph</a></li>
                                <li role="presentation"><a target="_blank" href="{{ url('/geometry_tab') }}">Geometry</a></li>
                                <li role="presentation"><a href="#periodic_table" role="tab" data-toggle="tab">PeriodicTable</a></li>
                                <link id="original" rel="stylesheet" type="text/css" href="">
                                <li role="presentation"><a href="#tables" role="tab" data-toggle="tab">Tables</a></li>
                                <li role="presentation"><a href="#logbook" role="tab" data-toggle="tab">Log Book</a></li>

                                <!-- <li role="presentation"><a href="#">Messages</a></li> -->
                            </ul>
                            <ul class="controls">
                                <li class="remove"><a role="button" tabindex="0" data-action="fullscreen"><i class="fa fa-expand"></i></a></li>
                            </ul>
                        </div>
                        <!-- /tile header -->

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="drawing_board" style="overflow:auto;">
                                <div id="drawingboard"></div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="summernote_editor" style="overflow:auto;">
                                <div id="summernote">Hello.....</div>
                            </div>

                            <div role="tabpanel" class="tab-pane" id="calc_tab" style="overflow:auto;">
                                <div class="calc-main">
                                    <div class="calc-display">
                                        <span>0</span>
                                        <div class="calc-rad">Rad</div>
                                        <div class="calc-hold"></div>
                                        <div class="calc-buttons">
                                            <div class="calc-info">?</div>
                                            <div class="calc-smaller">&gt;</div>
                                            <div class="calc-ln">.</div>
                                        </div>
                                    </div>
                                    <div class="calc-left">
                                        <div>
                                            <div>2nd</div>
                                        </div>
                                        <div>
                                            <div>(</div>
                                        </div>
                                        <div>
                                            <div>)</div>
                                        </div>
                                        <div>
                                            <div>%</div>
                                        </div>
                                        <div>
                                            <div>1/x</div>
                                        </div>
                                        <div>
                                            <div>x<sup>2</sup></div>
                                        </div>
                                        <div>
                                            <div>x<sup>3</sup></div>
                                        </div>
                                        <div>
                                            <div>y<sup>x</sup></div>
                                        </div>
                                        <div>
                                            <div>x!</div>
                                        </div>
                                        <div>
                                            <div>&radic;</div>
                                        </div>
                                        <div>
                                            <div class="calc-radxy">
                                                <sup>x</sup><em>&radic;</em><span>y</span>
                                            </div>
                                        </div>
                                        <div>
                                            <div>log</div>
                                        </div>
                                        <div>
                                            <div>sin</div>
                                        </div>
                                        <div>
                                            <div>cos</div>
                                        </div>
                                        <div>
                                            <div>tan</div>
                                        </div>
                                        <div>
                                            <div>ln</div>
                                        </div>
                                        <div>
                                            <div>sinh</div>
                                        </div>
                                        <div>
                                            <div>cosh</div>
                                        </div>
                                        <div>
                                            <div>tanh</div>
                                        </div>
                                        <div>
                                            <div>e<sup>x</sup></div>
                                        </div>
                                        <div>
                                            <div>Deg</div>
                                        </div>
                                        <div>
                                            <div>&pi;</div>
                                        </div>
                                        <div>
                                            <div>EE</div>
                                        </div>
                                        <div>
                                            <div>Rand</div>
                                        </div>
                                    </div>
                                    <div class="calc-right">
                                        <div>
                                            <div>mc</div>
                                        </div>
                                        <div>
                                            <div>m+</div>
                                        </div>
                                        <div>
                                            <div>m-</div>
                                        </div>
                                        <div>
                                            <div>mr</div>
                                        </div>
                                        <div class="calc-brown">
                                            <div>AC</div>
                                        </div>
                                        <div class="calc-brown">
                                            <div>+/&#8211;</div>
                                        </div>
                                        <div class="calc-brown calc-f19">
                                            <div>&divide;</div>
                                        </div>
                                        <div class="calc-brown calc-f21">
                                            <div>&times;</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>7</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>8</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>9</div>
                                        </div>
                                        <div class="calc-brown calc-f18">
                                            <div>&#8211;</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>4</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>5</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>6</div>
                                        </div>
                                        <div class="calc-brown calc-f18">
                                            <div>+</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>1</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>2</div>
                                        </div>
                                        <div class="calc-black">
                                            <div>3</div>
                                        </div>
                                        <div class="calc-blank" style="display:none"><textarea></textarea></div>
                                        <div class="calc-orange calc-eq calc-f17" style="left: 175px;">
                                            <div>
                                                <div class="calc-down">=</div>
                                            </div>
                                        </div>
                                        <div class="calc-black calc-zero">
                                            <div>
                                                <span>0</span>
                                            </div>
                                        </div>
                                        <div class="calc-black calc-f21">
                                            <div>.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div role="tabpanel" class="tab-pane" id="graph_tab">

                    </div> -->
                            <!-- <div role="tabpanel" class="tab-pane" id="geometry_tab" style="overflow:auto;">

                        </div> -->
                            <div role="tabpanel" class="tab-pane" id="periodic_table" style="overflow:auto;">
                                <main>
                                    <div id="Elements">
                                        <p>
                                            The JSON is good, but my parsing script is broken.
                                        </p>
                                    </div>
                                </main>
                                <div id="Dialog" aria-labelledby="DialogName" role="periodic_dialog" tabindex="-1" hidden>
                                    <div role="document">
                                        <!-- For VO bug -->
                                        <h2 id="DialogName">Element Detail</h2>
                                        <button type="button" id="DialogClose">Close</button>
                                        <!-- Need a region role becase this has a tabindex so keyboard users can scroll the box -->
                                        <div id="ElementDetail" tabindex="0" role="region" aria-labelledby="DialogName">
                                            The JSON is good, but my parsing script is broken.
                                        </div>
                                    </div>
                                </div>

                                <div id="Overlay"></div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="tables" style="overflow:auto;">
                                @include('tables')
                            </div>
                            <div role="tabpanel" class="tab-pane" id="logbook" style="overflow:auto;">
                                <ul class="nav nav-tabs">
                                    <li role="presentation"><a href="#algorithms" role="tab" data-toggle="tab">Log Table</a></li>
                                    <li role="presentation"><a href="#anti_log_tab" role="tab" data-toggle="tab">Anti-Log Table</a></li>
                                    <li role="presentation"><a href="#quick_log_calculator" role="tab" data-toggle="tab">Manual Log Calc</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane" id="algorithms" style="overflow:auto;">
                                        @include('logbook')
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="anti_log_tab" style="overflow:auto;">
                                        @include('anti_log_table')
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="quick_log_calculator" style="overflow:auto;">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Logarithm Type:</label>
                                                <select id="log_type" class="form-control">
                                                    <option value="log">Log</option>
                                                    <option value="anti_log">Anti-Log</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Number:</label>
                                                <input type="text" class="form-control" id="manual_log_number">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Select base:</label>
                                                <select id="manual_log_base" class="form-control">
                                                    <option value="2">2</option>
                                                    <option value="e">e</option>
                                                    <option value="3">3</option>
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="20">20</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="spacer">Round to<i>(decimal places)</i></label>
                                                <select id="manual_log_roundTo" class="form-control">
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <button type="button" onclick="manualLogCalculate()" class="btn btn-primary">Calculate</button>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <legend>Result <span id="manual_log_result"></span></legend>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /tile -->

                </div>
                <!-- /col -->
            </div>

            <!-- /row -->
        </div>
</section>
</div>
</div>

<!--/ RIGHTBAR Content -->

@endsection

@section('script')
<script>
    $('.carousel').carousel({
        interval: false,
    });

    const ScreenShareButtonEnableTime = "{{ $ScreenShareButtonEnableTime }}"; // Exit Time
    const ScreenShareButtonTime = (ScreenShareButtonEnableTime) * (1000 * 60);
    setTimeout(function() {
        // alert('hai');
        $('#start').show();
    }, ScreenShareButtonTime);

    const ExitTime = "{{ $ExitTime }}"; // Exit Time
    const ExitTimeout = (ExitTime) * (1000 * 60);
    setTimeout(function() {
        stop_live();
    }, ExitTimeout);

    const IntimationTime = "{{ $IntimationTime }}"; // Exit Time
    const IntimationTimeout = (IntimationTime) * (1000 * 60);
    setTimeout(function() {
        alert('Your Class is going to end after 5 minutes');
    }, IntimationTimeout);

</script>

<script type="text/javascript">
    $('#common_upload').on('change', function(ev) {
        var name = document.getElementById("common_upload").files[0].name;
        var class_id = document.getElementById("class_id").value;
        var section_id = document.getElementById("section_id").value;
        var subject_id = document.getElementById("subject_id").value;
        var form_data = new FormData();
        var ext = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(ext, ["doc", "pdf", 'docx', 'xlsx']) != -1) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("common_upload").files[0]);
            var f = document.getElementById("common_upload").files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 2000000) {
                alert("Document File Size is very big");
            } else {
                form_data.append("file", document.getElementById('common_upload').files[0]);
                form_data.append("class_id", document.getElementById('class_id').value);
                form_data.append("section_id", document.getElementById('section_id').value);
                form_data.append("subject_id", document.getElementById('subject_id').value);
                $.ajax({
                    url: "{{route('ViewerfilesUpload') }}",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#uploading_file').html(
                            "<label class='text-success'>File Uploading...</label>");
                    },
                    success: function(data) {
                        $('#uploading_file').html("<label class='text-success'>Success</label>");
                        if ($('#uploading_file').text("Success")) {
                            toastr.success("File successfully Uploaded");
                            $('#uploading_file').hide();
                        }
                    }
                });
            }
        } else {
            alert('Invalid Document File');
        }
    });


    $('#image_upload').on('change', function(ev) {
        var name = document.getElementById("image_upload").files[0].name;
        var class_id = document.getElementById("class_id").value;
        var section_id = document.getElementById("section_id").value;
        var subject_id = document.getElementById("subject_id").value;
        var form_data = new FormData();
        var ext = name.split('.').pop().toLowerCase();
        if (jQuery.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) != -1) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("image_upload").files[0]);
            var f = document.getElementById("image_upload").files[0];
            var fsize = f.size || f.fileSize;
            if (fsize > 2000000) {
                alert("Image File Size is very big");
            } else {
                form_data.append("file", document.getElementById('image_upload').files[0]);
                form_data.append("class_id", document.getElementById('class_id').value);
                form_data.append("section_id", document.getElementById('section_id').value);
                form_data.append("subject_id", document.getElementById('subject_id').value);
                $.ajax({
                    url: "{{ route('ViewerimagesUpload') }}",
                    method: "POST",
                    data: form_data,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('#uploading_image').html(
                            "<label class='text-success'>Image Uploading...</label>");
                    },
                    success: function(data) {
                        $('#uploading_image').html("<label class='text-success'>Success</label>");
                        if ($('#uploading_image').text("Success")) {
                            toastr.success("image successfully Uploaded");
                            $('#uploading_image').hide();
                        }
                    }
                });
            }
        } else {
            alert("Invalid Image File");
        }
    });
</script>

<script>
    $('#getDocumentList').on('click', function() {
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        $.ajax({
            type: "get",
            data: {
                class_id: class_id,
                section_id: section_id,
                subject_id: subject_id
            },
            url: "{{ action('ShareScreenFilesController@getDocumentList') }}",
            success: function(data) {
                Docs = "";
                for (var key in data) {
                    var row = data[key];
                    Docs += "<p><a href='#' class='docsview' onclick=hideDocModal();>" + row
                        .file_name + "</a>&nbsp;&nbsp;&nbsp;<button class='btn btn-sm btn-danger pull-right DeleteDocument' data-toggle='modal' data-target='#DeleteModel' onclick=DeleteDocument(" + row.id + ");><i class='fa fa-trash'></i></button></p>";
                }
                $('.AppendDocumentList').html(Docs);
            }
        });
    });

    function hideDocModal() {
        $('#common_files_modal').modal('toggle');
    }
    var imagecount = 0;
    $('#getImageList').on('click', function() {
        imagecount = 0;
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        $.ajax({
            type: "get",
            data: {
                class_id: class_id,
                section_id: section_id,
                subject_id: subject_id
            },
            url: "{{ action('ShareScreenFilesController@getImageList') }}",
            success: function(data) {
                Imgs = "";
                for (var key in data) {
                    var row = data[key];
                    Imgs += "<p><a href='#' class='imgview' onclick=hideImgModal();>" + row
                        .file_name + "</a>&nbsp;&nbsp;&nbsp;<button class='btn btn-sm btn-danger pull-right DeleteImage' data-toggle='modal' data-target='#DeleteModel' onclick=DeleteImage(" + row.id + ");><i class='fa fa-trash'></i></button></p>";
                }
                $('.AppendImageList').html(Imgs);
            }
        });
    });

    function DeleteDocument(value) {
        $('#common_files_modal').modal('toggle');
        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (value != '') {
                $.ajax({
                    type: "delete",
                    url: "{{ action('ShareScreenFilesController@DeleteDocument') }}",
                    data: {
                        value: value
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    },
                });
            }
        });
    }

    function DeleteImage(value) {
        $('#image_files_modal').modal('toggle');
        $(".DeleteConfirmed").click(function(e) {
            e.preventDefault();
            if (value != '') {
                $.ajax({
                    type: "delete",
                    url: "{{ action('ShareScreenFilesController@DeleteImage') }}",
                    data: {
                        value: value
                    },
                    success: function(data) {
                        toastr.success(data.message);
                    },
                });
            }
        });
    }

    function hideImgModal() {
        $('#image_files_modal').modal('toggle');
    }

    function reloadIFrame() {
        var iframe = document.getElementById("iframeID");
        // console.log(iframe.contentDocument.URL); //work control
        if (iframe.contentDocument.URL == "about:blank") {
            iframe.src = iframe.src;
        }
    }
    $(document).ready(function() {
        $('body').on('click', '.docsview', function() {
            var text = $(this).text();
            var te = "{{ url('public/uploads/document') }}/" + text;
            te = "https://docs.google.com/gview?url=" + te + "&embedded=true";
            $('.AppendDocs').html('<iframe width="100%" id="iframeID" height="285" frameborder="0" ></iframe>');
            document.getElementById("iframeID").src = te;
            var timerId = setInterval("reloadIFrame();", 2000);
            var dialog = bootbox.dialog({
                message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> Loading...</div>',
                closeButton: false
            })
            $('#iframeID').on('load', function() {
                clearInterval(timerId);
                dialog.modal('hide');
                console.log("Finally Loaded");
            });
        });

        $('body').on('click', '.imgview', function() {
            var element = "";
            var carouselelement = "";
            var count = "";
            var display = "";
            var loop = 1;
            var text = $(this).text();
            var class_id = $('#class_id').val();
            var section_id = $('#section_id').val();
            var subject_id = $('#subject_id').val();
            $.ajax({
                type: "get",
                data: {
                    class_id: class_id,
                    section_id: section_id,
                    subject_id: subject_id
                },
                url: "{{action('ShareScreenFilesController@getImageList') }}",
                success: function(data) {

                    $('.back').hide();
                    $('.next').hide();
                    imagecount = parseInt(data.length);
                    for (var key in data) {
                        var row = data[key];
                        if(text == row.file_name){
                            var te = "{{ url('public/uploads/images') }}/" + text;
                            display ="active";
                            count = key;
                        }else{
                            var te = "{{ url('public/uploads/images') }}/" + row.file_name;
                            display ="";
                        }

                        carouselelement +='<li data-target="#carousel-example-generic" data-slide-to="'+key+'" class="'+display+'"></li>';
                        element += '<div class="item '+display+'">'+
                           ' <img data-src="" alt="'+loop+' slide [900x500]" src="'+te+'" data-holder-rendered="true" class="'+display+'">'+
                        '</div>';
                        loop++;
                    }
                    $('.carouselimageList').html(carouselelement);
                    $('.sliderimageList').html(element);
                }
            });
        });
    });

    $("#Documentfullscreen").css("max-height", $(window).height() - 50);

    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject_id = $('#subject_id').val();
    var testObject = {
        class_id: class_id,
        section_id: section_id,
        subject_id: subject_id
    };


    // Put the object into storage
    localStorage.setItem('testObject', JSON.stringify(testObject));

    // Retrieve the object from storage
    var retrievedObject = localStorage.getItem('testObject');
    var data = JSON.parse(retrievedObject);
    // console.log(data)
</script>
<style>
    .content {
       display: none;
   }
   .back {
       display: none;
   }
   .next {
       margin-left: 50px;
   }
   .end {
       display: none;
   }
</style>
<style>
    #drawingboard {
        width: 100%;
        height: 1650px;
    }
</style>
<script src="{{ url('public/js/drawingboard.min.js') }}"></script>
<link rel="stylesheet" href="{{ url('public/css/drawingboard.min.css') }}">
<link rel="stylesheet" href="{{  url('public/css/periodictable.css') }}">
<!-- <script src="assets/js/vendor/summernote/summernote.min.js"></script> -->
<!-- <link rel="stylesheet" href="assets/js/vendor/summernote/summernote.css"> -->
<link rel="stylesheet" href="{{ url('public/css/CalcSS3.css') }}">

<style>
    /** Calculator css starts */

    .calc-main {
        /* center / center */
        /* position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -170px;
        margin-left: -250px; */
        width: 50%;
    }

    /* .calc-small {
        margin-left: -130px;
    } */

    /** Calculator css ends */

    /** FullScreeen CSS */
    .tile.fixed-top {
        overflow: auto;
        max-height: 100%;
    }

    .fixed-top {
        position: fixed;
        top: 0px;
        right: 0px;
        left: 0px;
        z-index: 1030;
    }

    .h-100 {
        height: 100% !important;
    }

    .main-fullscreen {
        background: #fff;
        overflow-y: auto;
        padding: 30px;
    }

    /** End FullScreen */
</style>
<script>
    $(window).load(function() {

        _cardActionFullscreen();
        $(window).scrollTop() + $(window).height() >= $(document).height()
        // load wysiwyg editor
        $('#summernote').summernote({
            height: 200 //set editable area's height
        });
        //*load wysiwyg editor


        var imageBoard = new DrawingBoard.Board('drawingboard', {
            // controls: false,
            background: 'bower_components/drawingboard.js/example/drawingboardjs.png',
            color: '#ff0',
            webStorage: false,
            controls: [
                'Color',
                'Size',
                'DrawingMode',
                'Navigation',
                'Download'
            ],
            enlargeYourContainer: true
        });

        $('#mctable tbody tr td').hover(function() {
            var ro = $(this).closest('tr').index() + 1;
            var col = $(this).index();
            ncol = col + 1;
            pcol = col - 1;
            nro = ro + 1;
            pro = ro - 1;
            $(this).siblings().removeClass('mhov').removeClass('chov');
            $('#mctable tr:eq(' + ro + ')').find('td:lt(' + ncol + ')').siblings().removeClass('mhov');

            $('#mctable tr:eq(' + ro + ')').find('td:lt(' + ncol + ')').addClass('mhov');

            $('#mctable tr:lt(' + ro + ')').find('td:lt(' + ncol + ')').removeClass('mhov');
            $('#mctable tr:lt(' + ro + ')').find('td:gt(' + col + ')').removeClass('mhov');
            $('#mctable tr:gt(' + ro + ')').find('td:lt(' + ncol + ')').removeClass('mhov');
            $('#mctable tr:gt(' + ro + ')').find('td:gt(' + ncol + ')').removeClass('mhov');

            $('td:eq(' + col + ')', 'tr:lt(' + nro + ')').toggleClass('mhov');
        });
        $('#mctable tbody tr td').click(function() {
            // $(this).addClass('mhov')
            var ro = $(this).closest('tr').index() + 1;
            var col = $(this).index();
            ncol = col + 1;
            pcol = col - 1;
            nro = ro + 1;
            pro = ro - 1;
            $(this).siblings().removeClass('mhov').removeClass('chov');
            $('#mctable tr:eq(' + ro + ')').find('td:lt(' + ncol + ')').siblings().removeClass('mhov');

            $('#mctable tr:eq(' + ro + ')').find('td:lt(' + ncol + ')').addClass('mhov');

            $('#mctable tr:lt(' + ro + ')').find('td:lt(' + ncol + ')').removeClass('mhov');
            $('#mctable tr:lt(' + ro + ')').find('td:gt(' + col + ')').removeClass('mhov');
            $('#mctable tr:gt(' + ro + ')').find('td:lt(' + ncol + ')').removeClass('mhov');
            $('#mctable tr:gt(' + ro + ')').find('td:gt(' + ncol + ')').removeClass('mhov');

            $('td:eq(' + col + ')', 'tr:lt(' + nro + ')').toggleClass('mhov');
        });
        // $('.log_table tbody tr td').hover(function() {
        //     var ro = $(this).closest('tr').index() + 1;
        //     var col = $(this).index();
        //     ncol = col + 1;
        //     pcol = col - 1;
        //     nro = ro + 1;
        //     pro = ro - 1;
        //     $(this).siblings().removeClass('mhov').removeClass('chov');
        //     $('.log_table tr:eq(' + ro + ')').find('td:lt(' + ncol + ')').siblings().removeClass('mhov');

        //     $('.log_table tr:eq(' + ro + ')').find('td:lt(' + ncol + ')').addClass('mhov');

        //     $('.log_table tr:lt(' + ro + ')').find('td:lt(' + ncol + ')').removeClass('mhov');
        //     $('.log_table tr:lt(' + ro + ')').find('td:gt(' + col + ')').removeClass('mhov');
        //     $('.log_table tr:gt(' + ro + ')').find('td:lt(' + ncol + ')').removeClass('mhov');
        //     $('.log_table tr:gt(' + ro + ')').find('td:gt(' + ncol + ')').removeClass('mhov');

        //     $('td:eq(' + col + ')', 'tr:lt(' + nro + ')').toggleClass('mhov');
        // });
        $("#drawing_board").css("max-height", $(window).height() - 50);
        $("#summernote_editor").css("max-height", $(window).height() - 50);
        $("#logbook").css("max-height", $(window).height() - 50);
        $("#periodic_tab").css("max-height", $(window).height() - 50);
        $("#periodic_table").css("max-height", $(window).height() - 50);
    });
</script>
<script src="{{ url('public/js/CalcSS3.js') }}"></script>

<script src="{{ url('public/js/periodictable.js') }}"></script>


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // function studentAttendenceEnd() {
    //     var subject_id = $('#subject_id').val();
    //     console.log(subject_id).
    //     $.ajax({
    //         type: "POST",
    //         url: "{{route('studentAttendenceEnd') }}",
    //         data : { subject_id : subject_id},
    //         success: function (data) {
    //             console.log(data);
    //         }
    //     });
    // }

    function StaffAttendence() {
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        var scheduleclass_id = $('#scheduleclass_id').val();
        console.log(subject_id)
        $.ajax({
            type: "POST",
            data: {
                class_id: class_id,
                section_id: section_id,
                subject_id: subject_id,
                scheduleclass_id: scheduleclass_id,
            },
            url: "{{ route('StaffAttendence') }}",
            success: function(data) {
                console.log("staff_attendance " + data);
            }
        });
    }

    function send_notify() {
        var session = $('#session_id').val();
        var audioroom_id = $('#audioroom_id').val();   
        var scheduleclass_id = $('#scheduleclass_id').val();
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        $('.Chatsession_id').val(scheduleclass_id);
        $('.live_chat_div').show();

        $.ajax({
            url: "{{ URL::to('send-live-notification') }}",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                session: session,
                audioroom_id: audioroom_id,
                scheduleclass_id: scheduleclass_id,
                class_id: class_id,
                section_id: section_id,
                subject_id: subject_id,
            },
            dataType: "json",
            success: function(data) {
                // console.log(data);
            }
        });
    }

    $(window).on("beforeunload", function() {
        stop_live();
    });

    $(document).ready(function() {
        const time = "{{env('SESSION_LIFETIME') }}"; // 900000 ms = 15 minutes
        const timeout = (time) * (1000 * 50);
        var idleTimer = null;
        $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function() {
            clearTimeout(idleTimer);
			var session_id = $('#session_id').val();
			 if (session_id != '') {
            idleTimer = setTimeout(function() {
                $("#stopBtn").trigger('click');
                var class_id = $('#class_id').val();
                var section_id = $('#section_id').val();
                var subject_id = $('#subject_id').val();
                var scheduleclass_id = $('#scheduleclass_id').val();
				alert('vijay post');
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('stop-live') }}",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "session_id": session_id,
                        class_id: class_id,
                        section_id: section_id,
                        subject_id: subject_id,
                        scheduleclass_id: scheduleclass_id,
                    },
                    success: function(result) {
                        if (result.status == "success") {
                        bootbox.alert("Your session expired due to inactivity", function() {
                            location.href = "{{ url('/login') }}";
                        })
                        }
                    }
                });
            }, timeout);
			}
        });
        $("body").trigger("mousemove");
    });

    function stop_live() {
        $("#stopBtn").trigger('click');
        var session_id = $('#session_id').val();
        var class_id = $('#class_id').val();
        var section_id = $('#section_id').val();
        var subject_id = $('#subject_id').val();
        var scheduleclass_id = $('#scheduleclass_id').val();
        if (session_id != '') {
            $.ajax({
                url: "{{ URL::to('stop-live') }}",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "session_id": session_id,
                    class_id: class_id,
                    section_id: section_id,
                    subject_id: subject_id,
                    scheduleclass_id: scheduleclass_id,
                },
                type: 'post',
                success: function(result) {
                    alert('Your Session is ended');
                }
            });
        }
    }

    var _cardActionFullscreen = function() {
        $('.tile [data-action=fullscreen]').on('click', function(e) {
            debugger;
            e.preventDefault();
            // Define vars
            var $target = $(this),
                cardFullscreen = $target.closest('.tile'),
                overflowHiddenClass = 'overflow-hidden',
                collapsedClass = 'collapsed-in-fullscreen',
                fullscreenAttr = 'data-fullscreen';

            // Toggle classes on card
            cardFullscreen.toggleClass('fixed-top h-100 rounded-0');

            // Configure
            if (!cardFullscreen.hasClass('fixed-top')) {
                $target.removeAttr(fullscreenAttr);
                cardFullscreen.children('.' + collapsedClass).removeClass('show');
                $('body').removeClass(overflowHiddenClass);
                $("#sidebar").css("z-index", "22");
                $("#header").css("z-index", "1002");
                $("iframe").attr("height", "285");
                $(".AppendImage").attr("height", "285");
                // $("#server_images").addClass("img-responsive");
            } else {
                $target.attr(fullscreenAttr, 'active');
                cardFullscreen.removeAttr('style').children('.collapse:not(.show)').addClass('show ' +
                    collapsedClass);
                $('body').addClass(overflowHiddenClass);
                $("#sidebar").css("z-index", "1");
                $("#header").css("z-index", "1");
                $("iframe").attr("height", "700");
                $(".AppendImage").attr("height", "700");
                // $("#server_images").removeClass("img-responsive");
            }
        });
        $('.main-fullscreen [data-action=fullscreen]').on('click', function(e) {
            e.preventDefault();
            // Define vars
            var $target = $(this),
                mainCardFullscreen = $target.closest('.main-fullscreen'),
                mainOverflowHiddenClass = 'overflow-hidden',
                mainCollapsedClass = 'collapsed-in-fullscreen',
                mainFullscreenAttr = 'data-fullscreen';

            // Toggle classes on card
            mainCardFullscreen.toggleClass('fixed-top h-100 rounded-0');

            // Configure
            if (!mainCardFullscreen.hasClass('fixed-top')) {
                $target.removeAttr(fullscreenAttr);
                mainCardFullscreen.children('.' + mainCollapsedClass).removeClass('show');
                $('body').removeClass(mainOverflowHiddenClass);
                $("#sidebar").css("z-index", "21");
                $("#header").css("z-index", "1001");
                // $("iframe").attr("height","285");
                // $(".AppendImage").attr("height","285");
                // $("#server_images").addClass("img-responsive");
            } else {
                $target.attr(mainFullscreenAttr, 'active');
                mainCardFullscreen.removeAttr('style').children('.collapse:not(.show)').addClass('show ' +
                    mainCollapsedClass);
                $('body').addClass(mainOverflowHiddenClass);
                $("#sidebar").css("z-index", "1");
                $("#header").css("z-index", "1");
                // $(".AppendImage").attr("height","700");
                // $("#server_images").removeClass("img-responsive");
            }
        });
    };
</script>

<script>
    var recorderBlob = null;

    function janus_stream(stream) {
        const videoElement = document.getElementById('videoElement');
        const captureBtn = document.getElementById('create');
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const audioToggle = document.getElementById('audioToggle');
        const micAudioToggle = document.getElementById('micAudioToggle');
        let blobs;
        let blob;
        let rec;
        // captureBtn.onclick = async () => {
        console.log('Streammanual', stream)
        videoElement.srcObject = stream;
        videoElement.muted = true;
        blobs = [];
        rec = new MediaRecorder(stream, {
            mimeType: 'video/webm; codecs=vp8,opus'
        });
        rec.ondataavailable = (e) => blobs.push(e.data);
        rec.onstop = async () => {
            //blobs.push(MediaRecorder.requestData());
            blob = new Blob(blobs, {
                type: 'video/webm'
            });
            let url = window.URL.createObjectURL(blob);
            recorderBlob = blob;
            // createDownloadLink(blob);
        };
            startBtn.disabled = false;
            captureBtn.disabled = true;
            audioToggle.disabled = true;
            micAudioToggle.disabled = true;
            startBtn.disabled = true;
            stopBtn.disabled = false;
            rec.start();
            stopBtn.onclick = () => {
                captureBtn.disabled = false;
                audioToggle.disabled = false;
                micAudioToggle.disabled = false;
                startBtn.disabled = true;
                stopBtn.disabled = true;
                rec.stop();
                stream.getTracks().forEach(s => s.stop())
                videoElement.srcObject = null
                stream = null;
            };

    }


    function localDownload(blob) {
        // return new Promise((resolve, reject) => {
        // storeVideoDetails(blob).then(function(){

        var a = document.createElement("a");
        document.body.appendChild(a);
        a.style = "display: none";
        // return function (blob) {
        // var json = JSON.stringify(recorderBlob),
        // blob = new Blob([json], {type: "octet/stream"}),
        url = window.URL.createObjectURL(blob);
        a.href = url;
        a.download = $('#session_id').val() + ".mp4";
        a.click();
        console.log("a", a);
        window.URL.revokeObjectURL(url);
        // };
        // resolve(1);
        //    })
        // })
    }

    function storeVideoDetails(blob) {
        return new Promise((resolve, reject) => {

            var url = URL.createObjectURL(blob);

            var filename = new Date().toISOString();
            var class_id = $('#class_id').val();
            var section_id = $('#section_id').val();
            var subject_id = $('#subject_id').val();
            //save to disk link
            var classdata = [class_id];
            var csrf_token = "{{ csrf_token() }}";
            var posturi = "{{ URL::to('video_records') }}";
            var classdata = [class_id];
            var sectiondata = [section_id];
            var subject_id = [subject_id];

            var fd = new FormData();
            console.log(blob);
            // fd.append("record_data", blob, filename);
            fd.append("filename", filename);
            fd.append("class_data", classdata);
            fd.append("section_data", sectiondata);
            fd.append("subject_id", subject_id);
            $.ajax({
                url: posturi,
                data: fd,
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData: false,
                contentType: false,
            }).done(function(data) {
                console.log("Success");
                resolve(1);
            }).fail(function(data) {
                console.log("Failed")
            })
        });

    }
    //  RAISE THE QUESTION FUNCTIONALITIES START
    // Enable pusher logging - don't include this in production
    $('body').on('change', '.micstatus', function() {
        if ($(this).prop("checked") == true) {
            var user_id = $(this).data('user_id');
            var student_name = $(this).data('student_name');
            var user_name = "{{ auth()->user()->name }}";
            var status = "accept";
            var message = user_name + " Enabled your mic";
        }
        if ($(this).prop("checked") == false) {
            var user_id = $(this).data('user_id');
            var student_name = $(this).data('student_name');
            var user_name = "{{ auth()->user()->name }}";
            var status = "rejected";
            var message = user_name + " rejected your mic";
        }
        $.ajax({
            url: "{{ URL::to('raise_question') }}",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "user_id": user_id,
                "user_name": user_name,
                "status": status,
                "message": message
            },
            type: 'post',
            success: function(result) {
                console.log(result);
            }
        });
    });
    //  RAISE THE QUESTION FUNCTIONALITIES END
</script>

@endsection

@section('Modal')


<div class="modal fade" id="DeleteModel" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are You Sure ! You Want to Delete</h4>
            </div>
            <div class="modal-body">
                <form action="#">
                    <button type="submit" class="btn btn-danger DeleteConfirmed" data-dismiss="modal">Delete </button>
                    <button type="button" style="float: right;" class="btn btn-default" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="common_files_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Common Files</h4>
            </div>
            <div class="modal-body DocumentList">
                <span class="AppendDocumentList"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- End Modal-->

<!-- Modal -->
<div id="image_files_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Images</h4>
            </div>
            <div class="modal-body ImageList">
                <span class="AppendImageList"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<!-- End Modal-->
@endsection
