<section id="header">
    <header class="clearfix">

        <!-- Branding -->
        <div class="branding">
            <a class="brand" href="{{ url('/home') }}">
                <span><strong>TTS-VLE</span>
            </a>
            <a role="button" tabindex="0" class="offcanvas-toggle visible-xs-inline"><i class="fa fa-bars"></i></a>
        </div>
        <!-- Branding end -->



        <!-- Left-side navigation -->
        <ul class="nav-left pull-left list-unstyled list-inline">
            <li class="sidebar-collapse divided-right">
                <a role="button" tabindex="0" class="collapse-sidebar">
                    <i class="fa fa-outdent"></i>
                </a>
            </li>
            <!--li class="dropdown divided-right settings">
                <a role="button" tabindex="0" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-cog"></i>
                </a>
                <ul class="dropdown-menu with-arrow animated littleFadeInUp" role="menu">
                    <li>

                        <ul class="color-schemes list-inline">
                            <li class="title">Header Color:</li>
                            <li><a role="button" tabindex="0" class="scheme-drank header-scheme" data-scheme="scheme-default"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-black header-scheme" data-scheme="scheme-black"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-greensea header-scheme" data-scheme="scheme-greensea"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-cyan header-scheme" data-scheme="scheme-cyan"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-lightred header-scheme" data-scheme="scheme-lightred"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-light header-scheme" data-scheme="scheme-light"></a></li>
                            <li class="title">Branding Color:</li>
                            <li><a role="button" tabindex="0" class="scheme-drank branding-scheme" data-scheme="scheme-default"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-black branding-scheme" data-scheme="scheme-black"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-greensea branding-scheme" data-scheme="scheme-greensea"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-cyan branding-scheme" data-scheme="scheme-cyan"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-lightred branding-scheme" data-scheme="scheme-lightred"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-light branding-scheme" data-scheme="scheme-light"></a></li>
                            <li class="title">Sidebar Color:</li>
                            <li><a role="button" tabindex="0" class="scheme-drank sidebar-scheme" data-scheme="scheme-default"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-black sidebar-scheme" data-scheme="scheme-black"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-greensea sidebar-scheme" data-scheme="scheme-greensea"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-cyan sidebar-scheme" data-scheme="scheme-cyan"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-lightred sidebar-scheme" data-scheme="scheme-lightred"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-light sidebar-scheme" data-scheme="scheme-light"></a></li>
                            <li class="title">Active Color:</li>
                            <li><a role="button" tabindex="0" class="scheme-drank color-scheme" data-scheme="drank-scheme-color"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-black color-scheme" data-scheme="black-scheme-color"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-greensea color-scheme" data-scheme="greensea-scheme-color"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-cyan color-scheme" data-scheme="cyan-scheme-color"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-lightred color-scheme" data-scheme="lightred-scheme-color"></a></li>
                            <li><a role="button" tabindex="0" class="scheme-light color-scheme" data-scheme="light-scheme-color"></a></li>
                        </ul>

                    </li>

                    <li>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-8 control-label">Fixed header</label>
                                <div class="col-xs-4 control-label">
                                    <div class="onoffswitch lightred small">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="fixed-header" checked="">
                                        <label class="onoffswitch-label" for="fixed-header">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-8 control-label">Fixed aside</label>
                                <div class="col-xs-4 control-label">
                                    <div class="onoffswitch lightred small">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="fixed-aside" checked="">
                                        <label class="onoffswitch-label" for="fixed-aside">
                                            <span class="onoffswitch-inner"></span>
                                            <span class="onoffswitch-switch"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </li-->
        </ul>
        <!-- Left-side navigation end -->




        <!-- Search>
        <div class="search" id="main-search">
            <input type="text" class="form-control underline-input" placeholder="Search...">
        </div>
        <!-- Search end -->




        <!-- Right-side navigation -->
        <ul class="nav-right pull-right list-inline">
			<li class="dropdown notifications">

                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-comments-o"></i>
                    <span class="badge bg-lightred comments-count">0</span>
                </a>

                <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInLeft">

                    <div class="panel-heading">
                        <input type="hidden" name="session_id" id="session_id">
                        <input type="hidden" name="audioroom_id" id="audioroom_id">
                        You have <strong class="comments-count">0</strong> notifications
                    </div>

                    <ul class="list-group">

                        <li class="list-group-item">

                           <div id="comments">Empty</div>
                        </li>
                    </ul>

                    <div class="panel-footer">

                    </div>

                </div>

            </li>
            <li class="dropdown users">

                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-user"></i>
                    <span class="badge bg-lightred count_raise_question">0</span>
                </a>

                <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInUp" role="menu">

                    <div class="panel-heading">
                        You have <strong class="count_raise_question">0</strong> requests
                    </div>

                    <ul class="list-group">
                        <div class="raise_question_lists">
                        </div>
                    </ul>

                    <div class="panel-footer">
                        <a role="button" tabindex="0">Show all requests <i class="fa fa-angle-right pull-right"></i></a>
                    </div>

                </div>

            </li>



            <li class="dropdown notifications">

                <a class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell"></i>
                    <span class="badge bg-lightred live-class-count"></span>
                </a>

                <div class="dropdown-menu pull-right with-arrow panel panel-default animated littleFadeInLeft">

                    <div class="panel-heading">
                        <input type="hidden" name="session_id" id="session_id">
                        You have <strong class="live-class-count"></strong> notifications
                    </div>

                    <ul class="list-group">

                        <li class="list-group-item">

                           <div id="notificatons"></div>
                        </li>
                    </ul>

                    <div class="panel-footer">
                        <a role="button" tabindex="0">Show all notifications <i class="fa fa-angle-right pull-right"></i></a>
                    </div>

                </div>

            </li>

            <li class="dropdown nav-profile">

                <a href class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ url('assets/images/profile-photo.jpg') }}" alt="" class="img-circle size-30x30">
                    <span>{{ auth()->user()->name }}  <i class="fa fa-angle-down"></i></span>
                </a>

                <ul class="dropdown-menu animated pull-right littleFadeInLeft" role="menu">

                    {{-- <li>
                        <a role="button" tabindex="0">
                            <span class="badge bg-greensea pull-right">86%</span>
                            <i class="fa fa-user"></i>Profile
                        </a>
                    </li>
                    <li>
                        <a role="button" tabindex="0">
                            <span class="label bg-lightred pull-right">new</span>
                            <i class="fa fa-check"></i>Tasks
                        </a>
                    </li>

                    <li>
                        <a role="button" tabindex="0" data-toggle="modal" data-target="#ChangePasswordModal">
                            <span class="label bg-lightred pull-right">new</span>
                            <i class="fa fa-check"></i>Reset Password
                        </a>
                    </li> --}}

                    <li class="divider"></li>

                    <li>
                        <a type="button"  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i>Logout
                        </a>
                    </li>
                </ul>
                @if(auth()->user()->user_type == "Student")
                    <form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endif
            </li>

            <li class="toggle-right-sidebar">
                <a role="button" tabindex="0">
                    <i class="fa fa-youtube-play"></i>
                </a>
            </li>
        </ul>
        <!-- Right-side navigation end -->
    </header>
</section>


<?php $currenturl=Request::segment(1);  ?>
<script src="https://js.pusher.com/6.0/pusher.min.js"></script>
  <script>
        $(document).ready(function() {
            new_get_notification();
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = false;
    var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('online-class');
    channel.bind('class-event', function(data) {
	console.log(data);
	if(data != ''){
	new_get_notification();
	}
    });


      function new_get_notification(){

          $.ajax({
      url:"{{URL::to('receivenew-live-notification')}}",
      method:"get",
      data:{"_token": $('meta[name="csrf-token"]').attr('content')},
      dataType:"json",
      success:function(data)
         {
          console.log(data);
          $('.live-class-count').html(data.count);
           $("#notificatons").html(data.message);
           $('.viewsession_id').val(data.session_id);
          if(data.status==1){

            var segment_url="<?php echo $currenturl; ?>";
            if(segment_url=="viewscreenshare"){

            }else{
				// alert(data.session_id);
				var route='{{ url("viewscreenshare") }}/'+data.session_id;

                window.location.href = route;
            }
            // alert(window.location.href);

          }else{
            $("#notificatons").html(data.message);
          }

         }
    });
      }

});
  </script>

  @section('Modal')

  @endsection
