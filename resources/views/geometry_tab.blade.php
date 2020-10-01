@include('layouts.headerscript')
@include('layouts.footerscript')
<section id="contents">
        <div class="hideMe" style="font-family:'Hobo'">.</div>
        <div class="hideMe" style="font-family:'segoePrint'">.</div>
        <div class="hideMe" style="font-family:'smileyMonster'">.</div>
        <div class="wrapper">
            <div class="container">
                <div class="canvas-container" id="canvascontainer">
                    <canvas id="canvas" width="1200" height="700" left="0" top="0" style="z-index:1"></canvas>
                </div>
            </div>
        </div>
    <!-- </div> -->
</section>
<link href="{{ url('public/css/geometry.css') }}" rel="stylesheet" type="text/css">
<style>

</style>
<script>
    var user = "guest";
    var personal = -1;

    var isTask = false;
    var hasCanvas = true;
    var mainCanvasFillStyle = '#FFC';
    var mainCanvasBorderWidth = 10;
    var cacheVersion = '200504';

    var scriptsToLoad = [
        "{{url('public/js/geometry/_drawMathsText.js')}}",
        "{{url('public/js/geometry/_mathsInput.js')}}",
        "{{url('public/js/geometry/_grid2.js')}}",
        "{{url('public/js/geometry/_keyboard.js')}}",
        "{{url('public/js/geometry/_text2.js')}}",
        "{{url('public/js/geometry/_draw.js')}}",
        "{{url('public/js/geometry/_draw2.js')}}",
        "{{url('public/js/geometry/_miscFuncs.js')}}",
        "{{url('public/js/geometry/Notifier.js')}}",
    ];
    var scriptsToLoad2 = [
        "{{url('public/js/geometry/construct.js')}}"
    ];
    var public_path = '{{ url("/") }}';
</script>
<script src="{{url('public/js/geometry/_holder2.js')}}"></script>