
<!doctype html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Virtual Class - Register</title>
        <link rel="icon" type="image/ico" href="{{ url('assets/images/favicon.ico') }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ url('assets/css/vendor/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/vendor/animate.css') }}">
        <link rel="stylesheet" href="{{ url('assets/css/vendor/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ url('assets/js/vendor/animsition/css/animsition.min.css') }}">

        <link rel="stylesheet" href="{{ url('assets/css/main.css') }}">

        <script src="{{ url('assets/js/vendor/modernizr/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>

    </head>

    <body id="minovate" class="appWrapper">

        {{-- <div id="wrap" class="animsition"> --}}

            <div class="page" style="background-color: #3f4e62 ">

                <div class="container w-420 p-15 bg-white mt-40 text-center">

                    <h2 class="text-light text-greensea">Sign Up</h2>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="instution_name" class="col-md-4 col-form-label text-md-right">{{ __('Instution Name') }}</label>

                            <div class="col-md-6">
                                <input id="instution_name" type="text" class="form-control underline-input @error('instution_name') is-invalid @enderror" name="instution_name" value="{{ old('instution_name') }}" required autocomplete="instution_name" autofocus>

                                @error('instution_name')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instution_address" class="col-md-4 col-form-label text-md-right">{{ __('Instution Address') }}</label>

                            <div class="col-md-6">
                                <textarea id="instution_address" type="text" class="form-control underline-input @error('instution_address') is-invalid @enderror" name="instution_address" required autocomplete="instution_address" autofocus>{{ old('instution_address') }}</textarea>

                                @error('instution_address')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="user_name" class="col-md-4 col-form-label text-md-right">{{ __('Admin User Name') }}</label>

                            <div class="col-md-6">
                                <input id="user_name" type="text" class="form-control underline-input @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name" autofocus>

                                @error('user_name')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number_1" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number 1') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number_1" type="text" class="form-control underline-input @error('phone_number_1') is-invalid @enderror" name="phone_number_1" value="{{ old('phone_number_1') }}" required autocomplete="phone_number_1" autofocus>

                                @error('phone_number_1')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="phone_number_2" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number 2') }}</label>

                            <div class="col-md-6">
                                <input id="phone_number_2" type="text" class="form-control underline-input @error('phone_number_2') is-invalid @enderror" name="phone_number_2" value="{{ old('phone_number_2') }}" required autocomplete="phone_number_2" autofocus>

                                @error('phone_number_2')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control underline-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control underline-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control underline-input"  name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="bg-slategray lt wrap-reset mt-20 text-left">
                            <p class="m-0">
                                <button type="submit" class="btn btn-greensea b-0 text-uppercase pull-right">Submit</button>
                                <a href="{{ route('login') }}" class="btn btn-lightred b-0 text-uppercase">Back</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        {{-- </div> --}}

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="{{ url('assets/js/vendor/bootstrap/bootstrap.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/jRespond/jRespond.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/sparkline/jquery.sparkline.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/slimscroll/jquery.slimscroll.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/animsition/js/jquery.animsition.min.js') }}"></script>

        <script src="{{ url('assets/js/vendor/screenfull/screenfull.min.js') }}"></script>

        <script src="{{ url('assets/js/main.js') }}"></script>

        <script>
            $(window).load(function(){
            });
        </script>
    </body>
</html>

