<!doctype html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Virtual Class - Triotend</title>
        <link rel="icon" type="image/ico" href="{{ url('assets/images/favicon.ico') }}"/>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <link rel="stylesheet" href="{{ url('assets/css/vendor/bootstrap.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/vendor/animate.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/vendor/font-awesome.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/js/vendor/animsition/css/animsition.min.css') }}">

        <!-- project main css files -->
        <link rel="stylesheet" href="{{ url('assets/css/main.css') }}">

        <script src="{{ url('assets/js/vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="{{ url('assets/js/vendor/bootstrap/bootstrap.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/jRespond/jRespond.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/sparkline/jquery.sparkline.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/animsition/js/jquery.animsition.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/screenfull/screenfull.min.js') }}"></script>

        <script src="{{ url('assets/js/main.js') }}"></script>

    </head>

    <body id="minovate" class="appWrapper">

        <div id="wrap" class="animsition">

            <div class="page page-core page-login">

                <div class="text-center"><h3 class="text-light text-white">Virtual Class</h3></div>

                <div class="container w-420 p-15 bg-white mt-40 text-center">


                    <h2 class="text-light text-greensea">Student Log In</h2>

                    <form method="POST" action="{{ route('student.login.submit') }}">
                        @csrf

                        @include('errors')

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="text" class="form-control underline-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email / Phone Number" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control underline-input @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group text-left mt-20">
                            {{-- <label class="checkbox checkbox-custom-alt checkbox-custom-sm inline-block">
                                <input type="checkbox"><i></i> Remember me
                            </label> --}}
                            <button type="submit" class="btn btn-greensea b-0 br-2 mr-5">Login</button>
                            {{-- <a href="forgotpass.html" class="pull-right mt-10">Forgot Password?</a> --}}
                        </div>

                    </form>

                </div>

            </div>

        </div>

    </body>
</html>
