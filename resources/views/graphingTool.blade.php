    <link rel="stylesheet" type="text/css" href="{{ url('public/css/graph.css' )}}">
    <div id="hideMe" style="font-family:'Hobo'">.</div>
    <div class="wrapper">
        <div class="container">
            <div class="canvas-container" id="canvascontainer">
                <canvas id="canvas" width="1200" height="700" left="0" top="0" style="z-index:1"></canvas>
                <canvas class="holderButton" id="holderPrevButton" width="210" height="68" left="0" top="0"></canvas>
                <canvas class="holderButton" id="holderReloadButton" width="190" height="68" left="0" top="0"></canvas>
                <canvas class="holderButton" id="holderNextButton" width="210" height="68" left="0" top="0"></canvas>
                <canvas class="holderButton" id="holderHomeButton" width="74" height="68" left="0" top="0"></canvas>
                <canvas class="holderButton" id="holderQuestionNum" width="66" height="68" left="0" top="0"></canvas>
                <canvas id="inactiveBox" width="400" height="120" left="0" top="0"></canvas>
                <canvas id="userInfoText" width="343" height="62" left="0" top="0"></canvas>
                <canvas class="holderButton" id="penColourBlack" width="65" height="60" left="0" top="0"></canvas>
                <canvas class="holderButton" id="penColourBlue" width="65" height="60" left="0" top="0"></canvas>
                <canvas class="holderButton" id="penColourRed" width="65" height="60" left="0" top="0"></canvas>
                <canvas class="holderButton" id="penColourGreen" width="65" height="60" left="0" top="0"></canvas>
                <canvas class="holderButton" id="penOff" width="65" height="60" left="0" top="0"></canvas>
                <canvas class="holderButton" id="penClear" width="65" height="60" left="0" top="0"></canvas>

            </div>
        </div>
    </div>
    <script>
        
        var task = ['jxx']; // tasks that appear in this holder - the array entries must match the filenames
        var finalOutputLevel = 30 // a number corresponding to the difficulty of the tasks, which will determine points earned
        var holderTaskId = 138; //taskId for database
        var taskName = "Graphing Tool"; // taskName for database
        var taskOrTool = 'tool';
        var taskPen = [];
        var taskKey = [];

        var public_path = '{{ url("/") }}';
    </script>
    <script src="{{ url('public/js/Graph/holder.js') }}"></script>