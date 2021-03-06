<!doctype html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Virtual Class - Triotend</title>
        <link rel="icon" type="image/ico" href="assets/images/favicon.ico" />
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="cache-control" content="private, max-age=0, no-cache">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="expires" content="0">
        <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">

        <link rel="stylesheet" href="assets/css/vendor/animate.css">

        <link rel="stylesheet" href="assets/css/vendor/font-awesome.min.css">

        <link rel="stylesheet" href="assets/js/vendor/animsition/css/animsition.min.css">

        <!-- project main css files -->
        <link rel="stylesheet" href="assets/css/main.css">

        <script src="assets/js/vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="assets/js/vendor/bootstrap/bootstrap.min.js"></script>

        <script src="assets/js/vendor/jRespond/jRespond.min.js"></script>

        <script src="assets/js/vendor/sparkline/jquery.sparkline.min.js"></script>

        <script src="assets/js/vendor/slimscroll/jquery.slimscroll.min.js"></script>

        <script src="assets/js/vendor/animsition/js/jquery.animsition.min.js"></script>

        <script src="assets/js/vendor/screenfull/screenfull.min.js"></script>

        <script src="assets/js/main.js"></script>

    </head>

    <body id="minovate" class="appWrapper">

        <div id="wrap" class="animsition">

            <div class="page page-core page-login">

                <div class="text-center"><h3 class="text-light text-white">Virtual Class</h3></div>

                <div class="container w-420 p-15 bg-white mt-40 text-center">

                    <h2 class="text-light text-greensea">OTP</h2>

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('submitCodeForm') }}">
                        {{ csrf_field() }}

                        @include('errors')

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="code" type="text" class="form-control underline-input @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" placeholder="Enter Your Code" required autofocus>

                                @if ($errors->has('code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-greensea b-0 br-2 mr-5">Submit Code</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>

        </div>
    </body>
</html>
