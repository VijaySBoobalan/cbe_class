@extends('layouts.master')

@section('add_student')
active
@endsection

@section('student_menu')
active open
@endsection

@section('content')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/6.4.0/adapter.min.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js">
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spin.js/2.3.2/spin.min.js"></script>
<link rel="stylesheet" href="{{ url('public/alertify/alertify.rtl.css') }}">
<link rel="stylesheet" href="{{ url('public/alertify/default.rtl.css') }}">
<script src="{{ url('public/alertify/alertify.js') }}"></script>
<link href="{{ asset('css/demo.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('js/janus.js') }}"></script>
<script src="{{ asset('js/audiobridgetest.js') }}"></script>
<section id="content">

    <div class="container page page-forms-validate">

        <!-- row -->
        <div class="row">


            <div class="col-md-12">

                <section class="tile">

                    <div class="tile-header dvd dvd-btm">
                        <h1 class="custom-font"><strong><button class="btn btn-default" style="display:block"
                                    autocomplete="off" id="start">start</button></h1>

                    </div>

                    <div class="container" id="details">
				
                    </div>
                    <div class="container hide" id="audiojoin">
                        <div class="row">
                            <span class="label label-info" id="you"></span>
                            <div class="col-md-12" id="controls">
                                <div class="input-group margin-bottom-md hide" id="registernow">
                                    <span class="input-group-addon">@</span>
                                    <input class="form-control" type="text" placeholder="Choose a display name" autocomplete="off" id="username" onkeypress="return checkEnter(this, event);" />
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" autocomplete="off" id="register">Join the room</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container hide" id="room">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Participants <span class="label label-info hide" id="participant"></span>
                                        <button class="btn-xs btn-danger hide pull-right" autocomplete="off" id="toggleaudio">Mute</button></h3>
                                    </div>
                                    <div class="panel-body">
                                        <ul id="list" class="list-group">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Mixed Audio</h3>
                                    </div>
                                    <!--div class="panel-body" id="mixedaudio"></div-->
                                </div>
                            </div>
                        </div>
                    </div>



                </section>

            </div>
        </div>
        <!-- /row -->




    </div>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
    <script>
      

      

      
    </script>
</section>
@endsection
