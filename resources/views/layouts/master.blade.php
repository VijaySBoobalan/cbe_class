<!doctype html>
<html class="no-js" lang="">

    @include('layouts.headerscript')

    <body id="minovate" class="appWrapper">
{{-- oncontextmenu="return false" onkeydown="return false;" onmousedown="return false;" --}}
        <!-- ====================================================
        ================= Application Content ===================
        ===================================================== -->
        <div id="wrap" class="animsition">

            <!-- ===============================================
            ================= HEADER Content ===================
            ================================================ -->
            @include('layouts.topnav')
            <!--/ HEADER Content  -->

            <!-- =================================================
            ================= CONTROLS Content ===================
            ================================================== -->
            <div id="controls">

                <!-- ================================================
                ================= SIDEBAR Content ===================
                ================================================= -->
                @include('layouts.sidebar')
                <!--/ SIDEBAR Content -->

                <!-- =================================================
                ================= RIGHTBAR Content ===================
                ================================================== -->
                <aside id="rightbar">

                    <div role="tabpanel">

                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#users" aria-controls="users" role="tab" data-toggle="tab"><i class="fa fa-users"></i></a></li>
                            @if (auth()->user()->user_type != "Student")
                                <li role="presentation"><a href="#history" aria-controls="history" role="tab" data-toggle="tab"><i class="fa fa-youtube-play"></i></a></li>
                            @endif
                            <li role="presentation"><a href="#chats" aria-controls="chats" role="tab" data-toggle="tab"><i class='fa fa-comments-o'></i></a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
						    @if (auth()->user()->user_type != "Student")
                            <div role="tabpanel" class="tab-pane active" id="users">
                                <h6><strong>Listening</strong> Students &nbsp <span class="badge bg-lightgrey listening-count">0</span></h6>

                                <ul id="list">
									
                                </ul>
                            </div>                       
                                <div role="tabpanel" class="tab-pane" id="history">
                                    <h6><strong>Videos</strong>
                                        <a role="button" tabindex="0" data-toggle="modal" data-target="#video_upload_modal" ><i class="fa fa-upload pull-right" id="upload_file"></i></a>
                                        {{-- <input type="file" id="video_upload" name="file" style="display: none;"> --}}
                                    </h6>
                                    <!-- Progress bar -->

                                    <div class="progress" style="display: none">
                                        <div class="progress-bar"></div>
                                    </div>

                                    <div id="uploadStatus"></div>

                                    <ul>
                                        <li class="online">
                                            <div class="media">
                                                <div class="media-body">
                                                    <span class="videolist"></span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
								@endif
									<div role="tabpanel" class="tab-pane" id="chats">
							    <section class="tile widget-chat">

							        <!-- tile header -->
							        <div class="tile-header dvd dvd-btm">
							            <h1 class="custom-font">Chat</h1>
							        </div>
							        <div id="SessionChats"></div>
							        <div class="tile-footer live_chat_div">
							            <form action="#" id="SendMsgForm" class="SendMsgForm">
							                @csrf
							                <div class="chat-form">
							                    <input type="hidden" id="Chatsession_id" class="Chatsession_id" name="Chatsession_id">
							                    <div class="input-group">
							                        <input type="text" class="form-control" id="messagechat" name="messagechat"
							                            placeholder="Type your message here...">
							                        <span class="input-group-btn">
							                            <button class="btn btn-primary" id="send_message" type="submit"><i
							                                    class="fa fa-chevron-right"></i></button>
							                        </span>
							                    </div>
							                </div>
							            </form>
							        </div>
							    </section>
							</div>
                            </div>
                            
						
                        </div>

                   

                </aside>
                <!--/ RIGHTBAR Content -->

            </div>
            <!--/ CONTROLS Content -->

            <!-- ====================================================
            ================= CONTENT ===============================
            ===================================================== -->
            @include('layouts.errors')

            @yield('content')
            <!--/ CONTENT -->






        </div>
        <!--/ Application Content -->

        <!-- ============================================
        ============== Vendor JavaScripts ===============
        ============================================= -->

        @include('layouts.footerscript')

        <!-- ===============================================
        ============== Page Specific Scripts ===============
        ================================================ -->
        <!-- Modal -->
        <div id="video_upload_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Video Upload</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="AddFilesForm" method="post" class="form-validate-jquery AddSubjectForm" data-parsley-validate name="form2" role="form">
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 link_uploadDiv">
                                    <div class="form-group">
                                        {!! Form::label('name', 'Link') !!}
                                        {!! Form::text('link_upload', null, ['class' => 'form-control link_upload','placeholder'=>'Link','id'=>'link_upload']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="form-group text-center">
                                        <button type="submit" class="btn btn-greensea b-0 br-2 mr-5 Save_file">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Modal-->
        {{-- <script src="//malsup.github.com/jquery.form.js"></script> --}}
        <script type="text/javascript">
			$(document).ready(function(){
				 $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
				check_live_class()

				function get_messages(session_id){
				var Chatsession_id = $('#Chatsession_id').val();
				if(Chatsession_id == session_id){
				$.ajax({
					type : "POST",
					url: '{{ route("getChats") }}',
					data : {session_id:session_id,_token:"{{ csrf_token() }}"},
					dataType : "html",
					success : function(data)
					{
					$('#SessionChats').html(data);
					$('.comments-count').html(1);
					$('#comments').html('Received a Message');
					}
					});
				}
				}
	 	 $('#SendMsgForm').on('submit', function(e){
           e.preventDefault();
		 $('#send_message').attr('disabled', true);
		var Chatsession_id=$('#Chatsession_id').val();
		var messagechat=$('#messagechat').val();
		   $.ajax({
                    type: "post",
                    url: '{{ route("SendChatMessage") }}',
                    data:{Chatsession_id:Chatsession_id,messagechat:messagechat,_token:"{{ csrf_token() }}"},
                    dataType:'JSON',
                    success: function(data) {
                    console.log(data);
					if(data.status=='success'){
					$('#send_message').attr('disabled', false);
					$('#messagechat').val("");
					if(Chatsession_id == data.session_id){
					get_messages(data.session_id);
					}
					}
                    }
                });
			});
			get_message_function = null;
			Pusher.logToConsole = false;
			var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
			cluster: 'ap2'
			});
			var channel = pusher.subscribe('live-chat');
			channel.bind('live-chat-event', function(data) {
			var Chatsession_id=$('#Chatsession_id').val();
			if(Chatsession_id == data.session_id){
			get_message_function=get_messages(data.session_id);
			}
			});

			function check_live_class(){
				 var session_id = $('#Chatsession_id').val();
				if( session_id ==''){
				$('.live_chat_div').hide();
				}else{
					$('.live_chat_div').show();
					get_messages(session_id);
				}
			}
		});
            $('.Save_file').on('click', function (ev) {
                ev.preventDefault();
                console.log($('#AddFilesForm').serialize());
                // var file_type = document.querySelector('input[name="file_type"]:checked').value;
                // if(file_type == "link"){
                    $.ajax({
                        type: "post",
                        url: '{{ route('VideofilesUpload') }}',
                        data: $('#AddFilesForm').serialize(),
                        dataType: 'json',
                        success: function(data) {
                            if(data.status == 'error'){
                                $("#AddFilesForm").valid().showErrors(data.errors);
                            }else{
                                $('#video_upload_modal').modal('hide');
                                $("#AddFilesForm")[0].reset();
                                getVideoList();
                            }
                        }
                    });
                // }else{
                    // $('.progress').show();
                    // var bar = $('.bar');
                    // var percent = $('.percent');
                    // var status = $('#status');
                    // var name = document.getElementById("video_upload").files[0].name;
                    // var form_data = new FormData();
                    // var ext = name.split('.').pop().toLowerCase();
                    // if(jQuery.inArray(ext, ["mp4","avi",'mpeg','wmv']) != -1){
                    //     var oFReader = new FileReader();
                    //     oFReader.readAsDataURL(document.getElementById("video_upload").files[0]);
                    //     var f = document.getElementById("video_upload").files[0];
                    //     var fsize = f.size || f.fileSize;
                    //     if (fsize > 2048000000) {
                    //         alert("Video File Size is very big");
                    //     } else {
                    //         form_data.append("file", document.getElementById('video_upload').files[0]);
                    //         $.ajax({
                    //             xhr: function() {
                    //                 var xhr = new window.XMLHttpRequest();
                    //                 xhr.upload.addEventListener("progress", function(evt) {
                    //                     if (evt.lengthComputable) {
                    //                         var percentComplete = ((evt.loaded / evt.total) * 100);
                    //                         $(".progress-bar").width(percentComplete + '%');
                    //                         $(".progress-bar").html(percentComplete+'%');
                    //                     }
                    //                 }, false);
                    //                 return xhr;
                    //             },
                    //             url: '{{ route('VideofilesUpload') }}',
                    //             method: "POST",
                    //             data: form_data,
                    //             contentType: false,
                    //             cache: false,
                    //             processData: false,
                    //             beforeSend: function(){
                    //                 $(".progress-bar").width('0%');
                    //                 // $('#uploadStatus').html('<img src="assets/images/preloader.gif"/>');
                    //             },
                    //             error:function(){
                    //                 $('#uploadStatus').html('<p style="color:#EA4335;">File upload failed, please try again.</p>');
                    //             },
                    //             success: function(data){
                    //                 console.log(data);
                    //                 $('#uploadStatus').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                    //             }
                    //             // beforeSend: function () {
                    //             //     $('#uploading_video').html(
                    //             //         "<label class='text-success'>Video Uploading...</label>");
                    //             // },
                    //             // success: function (data) {
                    //             //     $('#uploading_video').html("<label class='text-success'>Success</label>");
                    //             //     if ($('#uploading_video').text("Success")) {
                    //             //         $('#uploading_video').hide();
                    //             //     }
                    //             // }
                    //         });
                    //     }
                    // } else {
                    //     alert('Invalid Video File');
                    // }
                // }
            });
            getVideoList();
            // $(window).on('load',function(){
            //     getVideoList();
            // });

            function getVideoList(){
                $.ajax({
                    type: "get",
                    url: '{{ action('ShareScreenFilesController@getVideoList') }}',
                    success: function (data) {
                        Imgs = "";
                        for (var key in data) {
                            var row = data[key];
                            Imgs += "<p><a href='#' class='VideoPlayer' data-toggle='modal' data-target='#video_file_playing_modal' onclick='VideoPlayer(this.text);' id='VideoPlayer'>" + row.file_name + "</a>&nbsp;&nbsp;&nbsp;<button class='btn btn-sm btn-danger DeleteVideo' data-toggle='modal' data-target='#DeleteModel' onclick=DeleteVideo("+row.id+");><i class='fa fa-trash'></i></button></p>";
                        }
                        $('.videolist').html(Imgs);
                    }
                });
            }

            function VideoPlayer(value){
                $('.toggle-right-sidebar').trigger('click');
                $('.AppendPlayVideo').html('<iframe id="youtubeVideo" width="560" height="315" src="' + value +'" frameborder="0"></iframe>');
            }

            function DeleteVideo(value) {
                $(".DeleteConfirmed").click(function(e) {
                    e.preventDefault();
                    if (value != '') {
                        $.ajax({
                            type: "delete",
                            url: '{{ action('ShareScreenFilesController@DeleteVideo') }}',
                            data: {value: value},
                            success: function (data) {
                                toastr.success(data.message);
                                getVideoList();
                            },
                        });
                    }
                });
            }

        </script>

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
        <div id="video_file_playing_modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Video</h4>
                    </div>
                    <div class="modal-body PlayVideo">
                        <span class="AppendPlayVideo"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Modal-->
    </body>
</html>
