@extends('layouts.master')

@section('dashboard')
active
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/7.4.0/adapter.min.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<script src="{{ url('public/js/janus.js') }}"></script>
<script src="{{ url('public/js/screensharingtest.js') }}"></script>
<style>
.screenplayvideo{
    width: 90%;
}
#joinnow{
    width:90%;
}
.mic-control{
    width:90%;
}
</style>
<section id="content">

    <div class="container page page-forms-validate">

        <!-- row -->
        <div class="row">


            <div class="col-md-12">

                <section class="tile">

                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong><button class="btn btn-default" style="display:none"
                                    autocomplete="off" id="start">start</button></h1>
                    </div>
					<input type="hidden"name="myaudioid"id="myaudioid">
					 @if(auth()->user()->user_type=="Student")
                    <input type="hidden" name="" id="student_class" value="{{ auth()->user()->StudentDetails->student_class }}">
                    <input type="hidden" name="" id="section_id" value="{{ auth()->user()->StudentDetails->section_id }}">
					@endif
                    <input type="hidden" name="" id="subject_id" value="{{ $class_details[0]->subject_id }}">
                    <input type="hidden" name="" id="subject_schedule_id" value="{{ $class_details[0]->scheduleclass_id }}">
                    <div class="tile-body">
                        <div class="container hide" id="screenmenu">
                            <div class="row">
                                <div class="col-md-3">
                                     <div class="audioinput" style="display:none">
                                        <div class="container hide" id="audiojoin">
                                            <div class="row">
                                                <span class="label label-info" id="you"></span>
                                                <div class="col-md-12" id="controls">
                                                    <div class="input-group margin-bottom-md hide" id="registernow">
                                                <input type="hidden"name="student_id"id="student_id"value="{{ auth()->user()->id }}">
                                                        <input class="form-control" type="text"
                                                            placeholder="Choose a display name"
                                                            value="{{ auth()->user()->name }}" autocomplete="off"
                                                            id="studentname"
                                                            />

													<input class="form-control" type="text" placeholder="Join the audio room"value="{{ $class_details[0]->audioroom_id }}" id="joinroomaudioid" />
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-success" autocomplete="off" id="joinclass">Join the roomid</button>
                                                        </span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-group margin-bottom-md" id="joinnow">

                                        <input class="form-control" type="hidden" autocomplete="off"value="{{ $class_details[0]->session_id }}" id="roomid"
                                            onkeypress="return checkEnterJoin(this, event);" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" autocomplete="off" onclick="enableaudio()"
                                                id="join">Join the class</button>

                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="container hide" id="room">

                                 {{-- AUDIO --}}
                                <div class="row">
                                     <div class="col-md-6  mic-control"style="display:block">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    <button class="btn-xs btn-danger  pull-right"
                                                        id="toggleaudio">Unmute</button></h3>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6" style="display:none">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">Mixed Audio</h3>
                                            </div>
                                            <div class="panel-body" id="mixedaudio"></div>
                                        </div>
                                    </div>
                                </div>
                         {{-- AUDIO --}}


                        </div>
                        <div class="panel-body" id="screencapture"></div>
                    </div>

                </section>

            </div>
        </div>
        <!-- /row -->

    </div>

    <script type="text/javascript">
		$(window).on("beforeunload", function () {
			// var status = "left";
            // ListiningStudents(status);
			var user_type = '{{auth()->user()->user_type}}';
			if( user_type == 'Student'){
				 studentAttendenceEnd();
			}

        });
		 
		 
        // var class_id = $('#student_class').val();
        // var section_id = $('#section_id').val();
        // var subject_id = $('#subject_id').val();

        // var testObject = { class_id: class_id, section_id: section_id, subject_id: subject_id };

        // // Put the object into storage
        // localStorage.setItem('testObject', JSON.stringify(testObject));

        // // Retrieve the object from storage
        // var retrievedObject = localStorage.getItem('testObject');
        // var data = JSON.parse(retrievedObject);
        // console.log(data)

    </script>

    <script>

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("document").ready(function () {

                $("#start").trigger('click');


        });

        //  RAISE THE QUESTION FUNCTIONALITIES START
        $(document).ready(function () {
            const time = '{{ env('SESSION_LIFETIME') }}';  // 900000 ms = 15 minutes
            const timeout = (time) * (1000 * 50);
            var idleTimer = null;
            $('*').bind('mousemove click mouseup mousedown keydown keypress keyup submit change mouseenter scroll resize dblclick', function () {
                // debugger;
                clearTimeout(idleTimer);

                idleTimer = setTimeout(function () {
                    var subject_id = $('#subject_id').val();
                    var subject_schedule_id = $('#subject_schedule_id').val();
                    $.ajax({
                        type: "POST",
                        url: '{{ route('studentAttendenceEnd') }}',
                        data : { subject_id : subject_id, subject_schedule_id : subject_schedule_id},
                        success: function (data) {
                            // console.log(data);
                            // alert('Your Session was ended');
                        }
                    });
                }, timeout);
            });
            $("body").trigger("mousemove");
        });

        //  RAISE THE QUESTION FUNCTIONALITIES END
		 // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;
        var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
            cluster: 'ap2'
        });
        var channel = pusher.subscribe('raise-question');
        channel.bind('raise-question-event', function(data) {
        var logged_id = $('#myaudioid').val();
            if( logged_id == data.user_id ){
                // $('.mic-control').show();
                $("#toggleaudio").trigger('click');
            }
        });
	    $(function () {
            $("#start").click(function () {
                join_class();
            });
        });

        function enableaudio() {
			var chat_session_id="{{ $class_details[0]->scheduleclass_id }}";
			$('.Chatsession_id').val(chat_session_id);
			$('.live_chat_div').show();
            var user_type='{{auth()->user()->user_type}}';
			if(user_type=='Student'){
                AddStudentAttendence();
			}
			// var status = "Joined";
			// ListiningStudents(status);
            $("#joinclass").trigger('click');
        }

		function join_class() {

            // $("#joinclass").trigger('click');

        }

        function AddStudentAttendence() {
            var subject_id = $('#subject_id').val();
            var subject_schedule_id = $('#subject_schedule_id').val();
            $.ajax({
                type: "POST",
                url: '{{ route('StudentAttendence') }}',
                data : { subject_id : subject_id, subject_schedule_id : subject_schedule_id},
                success: function (data) {
                    console.log(data);
                }
            });
        }
		// function ListiningStudents(status){
		// var schedule_id = $('#subject_schedule_id').val();
			  // $.ajax({
                // type: "POST",
                // url: "{{ route('ClassListening') }}",
                // data : { schedule_id:schedule_id,status : status},
                // success: function (data) {
                    // console.log(data);
                // }
            // });
        // }

        function studentAttendenceEnd() {
            var subject_id = $('#subject_id').val();
            var subject_schedule_id = $('#subject_schedule_id').val();
            $.ajax({
                type: "POST",
                url: '{{ route('studentAttendenceEnd') }}',
                data : { subject_id : subject_id, subject_schedule_id : subject_schedule_id},
                success: function (data) {
                    console.log(data);
                }
            });
        }

    </script>
</section>
@endsection
