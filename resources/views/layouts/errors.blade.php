<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options.closeButton = true;
    toastr.options.newestOnTop = true;
    toastr.options.progressBar = true;
    toastr.options.timeOut = '2000';
</script>
@if(count($errors))

    @foreach($errors->all() as $error)
          <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach

@endif

@if(Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}');
    </script>
@endif

@if(Session::has('error'))
    <script>
        toastr.error('{{ Session::get('error') }}!');
    </script>
@endif

@if(Session::has('warning'))
    <script>
        toastr.warning('{{ Session::get('warning') }}!');
    </script>
@endif

