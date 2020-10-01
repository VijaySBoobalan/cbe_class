@extends('layouts.master')

@section('add_student')
active
@endsection

@section('student_menu')
active open
@endsection

@section('content')
<style>
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
</style>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/6.4.0/adapter.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<link href="{{ url('public/css/demo.css') }}" rel="stylesheet" type="text/css">
	<script src="{{ url('public/js/janus.js') }}" ></script>
	<script src="{{ url('public/js/screensharingtest.js') }}" ></script>

    <section id="content">

        <div class="page page-forms-validate">

            <!-- row -->
            <div class="row">
<video id="videoElement" autoplay muted style="display:none"></video>

                <div class="col-md-12">

                    <section class="tile">
                    			<?php //print_r($class); ?>

                        <div class="tile-header dvd dvd-btm">
                        		<div class="col-md-3">
                    				<select name="class"id="class_id"class="form-control">
                    				@foreach($class as $classlist)
                    					<option value="{{$classlist}}" {{$classlist == $id ? "selected" : ""}} >{{$classlist}}</option>
                    			    @endforeach
                    				</select>
                    			</div>
                            <h1 class="custom-font"><strong><button class="btn btn-default" autocomplete="off" id="start">Start</button></h1><br>
                          <button id="startBtn" disabled>Start Recording</button>
    <button id="stopBtn" disabled>Stop Capture</button>
    <br>
    <input type="checkbox" id="audioToggle" />
    <label for="audioToggle">Capture Audio from Desktop</label>
    <input type="checkbox" id="micAudioToggle"checked />
    <label for="micAudioToggle">Capture Audio from Microphone</label>
    <a id="download" href="#" style="display: none;">Download</a>
                        </div>
						<input type="hidden"name="session_id"id="session_id">
                        <div class="row">
                        <div class="tile-body">
						<div class="col-md-12">

						</div>
						</div>
						</div>
                        <div class="tile-body">
						<div class="container hide" id="screenmenu">
						<div class="row">
						<div class="col-md-3">
						<div class="input-group margin-bottom-md hide" id="createnow">
						<span class="input-group-addon"><i class="fa fa-users fa-1"></i></span>
						<input class="form-control" type="text" placeholder="Insert a title for the session" autocomplete="off" id="desc" onkeypress="return checkEnterShare(this, event);" />
						<span class="input-group-btn">
							<button class="btn btn-success" autocomplete="off"onclick="get_media()" id="create">Share</button>
						</span>
						</div>
						</div>
						</div>
						</div>
                        <div class="container hide" id="room">
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">

							</div>
							<!--div class="panel-body" id="screencapture"></div-->

						</div>
					</div>
				</div>
			</div>
			<div id="mydiv">
				<div id="videodiv">
				<video autoplay width="200px"height="200px"></video>
				</div>
            </div>
                        </div>



                    </section>

                </div>
            </div>
            <!-- /row -->




        </div>

    </section>
@endsection
@section('script')
<script>
	function get_media()
	{
		const constraints = {
		video: {
		mediaSource:'video'
		},
		audio: true
		};
		const video = document.querySelector('video');
		navigator.mediaDevices.getUserMedia(constraints).
		then((stream) =>
		{video.srcObject = stream});
    }
</script>
<script>

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});


	function send_notify(){
	var session=$('#session_id').val();
	var class_id=$('#class_id').val();

	  $.ajax({
	  url:"{{URL::to('send-live-notification')}}",
	  method:"POST",
	  data:{"_token": $('meta[name="csrf-token"]').attr('content'),session:session,class_id:class_id},
	  dataType:"json",
	  success:function(data)
	     {
		  // console.log(data);
		 }
		});
	}
	function stop_live(){

    var session_id = $('#session_id').val();
    // alert(session_id);
    $.ajax
    ({
        url:"{{URL::to('stop-live')}}",
        data: {"session_id": session_id},
        type: 'post',
        success: function(result)
        {

        }
    });
	}

</script>
<script>
//Make the DIV element draggagle:
dragElement(document.getElementById("mydiv"));

function dragElement(elmnt) {
  var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
  if (document.getElementById(elmnt.id + "header")) {
    /* if present, the header is where you move the DIV from:*/
    document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
  } else {
    /* otherwise, move the DIV from anywhere inside the DIV:*/
    elmnt.onmousedown = dragMouseDown;
  }

  function dragMouseDown(e) {
    e = e || window.event;
    e.preventDefault();
    // get the mouse cursor position at startup:
    pos3 = e.clientX;
    pos4 = e.clientY;
    document.onmouseup = closeDragElement;
    // call a function whenever the cursor moves:
    document.onmousemove = elementDrag;
  }

  function elementDrag(e) {
    e = e || window.event;
    e.preventDefault();
    // calculate the new cursor position:
    pos1 = pos3 - e.clientX;
    pos2 = pos4 - e.clientY;
    pos3 = e.clientX;
    pos4 = e.clientY;
    // set the element's new position:
    elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
    elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
  }

  function closeDragElement() {
    /* stop moving when mouse button is released:*/
    document.onmouseup = null;
    document.onmousemove = null;
  }
}
</script>
<script>



window.onload = () => {
  const warningEl = document.getElementById('warning');
  const videoElement = document.getElementById('videoElement');
  const captureBtn = document.getElementById('create');
  const startBtn = document.getElementById('startBtn');
  const stopBtn = document.getElementById('stopBtn');
  const download = document.getElementById('download');
  // const upload = document.getElementById('upload');
  const audioToggle = document.getElementById('audioToggle');
  const micAudioToggle = document.getElementById('micAudioToggle');

  // if('getDisplayMedia' in navigator.mediaDevices) warningEl.style.display = 'none';

  let blobs;
  let blob;
  let rec;
  let stream;
  let voiceStream;
  let desktopStream;

  const mergeAudioStreams = (desktopStream, voiceStream) => {
    const context = new AudioContext();
    const destination = context.createMediaStreamDestination();
    let hasDesktop = false;
    let hasVoice = false;
    if (desktopStream && desktopStream.getAudioTracks().length > 0) {
      // If you don't want to share Audio from the desktop it should still work with just the voice.
      const source1 = context.createMediaStreamSource(desktopStream);
      const desktopGain = context.createGain();
      desktopGain.gain.value = 0.7;
      source1.connect(desktopGain).connect(destination);
      hasDesktop = true;
    }

    if (voiceStream && voiceStream.getAudioTracks().length > 0) {
      const source2 = context.createMediaStreamSource(voiceStream);
      const voiceGain = context.createGain();
      voiceGain.gain.value = 0.7;
      source2.connect(voiceGain).connect(destination);
      hasVoice = true;
    }

    return (hasDesktop || hasVoice) ? destination.stream.getAudioTracks() : [];
  };

  captureBtn.onclick = async () => {
    download.style.display = 'none';
    const audio = audioToggle.checked || false;
    const mic = micAudioToggle.checked || false;

    desktopStream = await navigator.mediaDevices.getDisplayMedia({ video:true, audio: audio });

    if (mic === true) {
      voiceStream = await navigator.mediaDevices.getUserMedia({ video: false, audio: mic });
    }

    const tracks = [
      ...desktopStream.getVideoTracks(),
      ...mergeAudioStreams(desktopStream, voiceStream)
    ];

    console.log('Tracks to add to stream', tracks);
    stream = new MediaStream(tracks);
    console.log('Stream', stream)
    videoElement.srcObject = stream;
    videoElement.muted = true;

    blobs = [];

    rec = new MediaRecorder(stream, {mimeType: 'video/webm; codecs=vp8,opus'});
    rec.ondataavailable = (e) => blobs.push(e.data);
    rec.onstop = async () => {

      //blobs.push(MediaRecorder.requestData());
      blob = new Blob(blobs, {type: 'video/webm'});
      let url = window.URL.createObjectURL(blob);
	  createDownloadLink(blob);
      // upload.name = url;
      download.href = url;
      download.download = 'test.webm';
      download.style.display = 'block';
      // upload.style.display = 'block';
    };
    startBtn.disabled = false;
    captureBtn.disabled = true;
    audioToggle.disabled = true;
    micAudioToggle.disabled = true;
  };

  startBtn.onclick = () => {
    startBtn.disabled = true;
    stopBtn.disabled = false;
    rec.start();
  };

  stopBtn.onclick = () => {
    captureBtn.disabled = false;
    audioToggle.disabled = false;
    micAudioToggle.disabled = false;
    startBtn.disabled = true;
    stopBtn.disabled = true;

    rec.stop();

    stream.getTracks().forEach(s=>s.stop())
    videoElement.srcObject = null
    stream = null;
  };
};

function createDownloadLink(blob) {

	var url = URL.createObjectURL(blob);
	// alert(url);
	var x = location.origin;
	// alert(x);
	var post_to=x + "/virtualclass/upload_record";
	// var au = document.createElement('audio');
	// var li = document.createElement('li');
	var link = document.createElement('a');

	//name of .wav file to use during upload and download (without extendion)
	var filename = new Date().toISOString();

	//add controls to the <audio> element


	//save to disk link
	link.href = url;
	link.download = filename+".wav"; //download forces the browser to donwload the file using the  filename
	link.innerHTML = "Save to disk";
	// var csrf_token = $('meta[name="csrf-token"]').attr('content');
	 var csrf_token ="{{ csrf_token() }}";
	 var posturi = "{{ URL::to('upload_record') }}";
// alert(csrf_token);

	var upload = document.createElement('a');

		  var xhr=new XMLHttpRequest();
		  xhr.onload=function(e) {
		      if(this.readyState === 4) {
		          console.log("Server returned: ",e.target.responseText);
		      }
		  };

		  var fd=new FormData();
		  console.log(blob);

		  fd.append("record_data",blob, filename);
		   // var newdata=['rubesh','berry'];
		  // fd.append("record_data",newdata);
		  // xhr.open("POST",url,true);



		xhr.open("POST", posturi, true);

		xhr.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'))
		xhr.send(fd);


		  // xhr.send(fd);

}
</script>

@endsection
