
<html>
  <head>
  <script>
    function submitloginForm() {
      var loginForm = document.forms.loginForm;
           loginForm.submit();
    }
  </script>
  </head>
  {{-- onload="submitloginForm()" --}}
  <body onload="submitloginForm()">
      Processing.....
      <form action="{{ route('student.login.submit') }}" method="post" name="loginForm"><br />
        @csrf
        <input id="email" type="hidden" class="form-control underline-input @error('email') is-invalid @enderror" name="email" value="{{ $Student->mobile_number }}" placeholder="Email / Phone Number" required autocomplete="email" autofocus>
        <input type="submit" value="Submit" style="display: none;">
    </form>
  </body>
</html>
