<legend>Table of Log Values</legend>
<div class="row">
    <div class="col-md-4">
        <label>Select base:</label>
        <select id="base1" class="form-control">
            <option value="2">2</option>
            <option value="e">e</option>
            <option value="3">3</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="100">100</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="spacer">Round to<i>(decimal places)</i></label>
        <select id="roundTo" class="form-control">
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
        </select>
    </div>
    <div class="col-md-4">
        <label class="spacer">Max value</label>
        <select id="maxVal" class="form-control">
            <option value="1">1.99</option>
            <option value="2">2.99</option>
            <option value="3">3.99</option>
            <option value="4">4.99</option>
            <option value="5">5.99</option>
            <option value="6">6.99</option>
            <option value="7">7.99</option>
            <option value="8">8.99</option>
            <option value="9">9.99</option>
        </select>
    </div>
</div>
<h2>Log Table: Selected Base <span id="thisBase">2</span></h2>
<div class="log_div" id="log_div">
    <h2>Log Table: Base 2</h2>
</div>

<script>
    var dataSet = [];
    var logb = function(x, b, r) {
        return (Math.log(x) / Math.log(b)).toFixed(r);
    }
    var tabfn = function(round, max) {

        table = "<table id=\"logtable\" class='table table-bordered'>";
        for (i = 1; i < max; i++) {
            var tmp = [];
            if (i == 1) {
                table += "<thead><tr><th>N</th>";
                for (n = 0; n < 10; n++) {
                    table += "  <th>" + n + "</th>";
                }
                table += "</tr></thead><tbody>";
            }
            tmp.push((1 + (i - 1) / 10).toFixed(1));
            tmp.push(logb((1 + (i - 1) / 10), base1, round));
            table += "<tr><td>" + (1 + (i - 1) / 10).toFixed(1) + "</td><td>" + logb((1 + (i - 1) / 10), base1, round) + "</td>";
            for (j = 1; j < 10; j++) {
                tmp.push(logb(((1 + (i - 1) / 10) + j / 100), base1, round));
                table += "<td>" + logb(((1 + (i - 1) / 10) + j / 100), base1, round) + "</td>";
            }
            table += "</tr>";
            dataSet.push(tmp);
        }
        table += "</tbody>";
        table += "</table>";
        return table;

    }
    roundTo = parseInt(document.getElementById("roundTo").value);
    document.getElementById("roundTo").addEventListener("change", function() {
        roundTo = parseInt(document.getElementById("roundTo").value);
        document.getElementById("log_div").innerHTML = tabfn(roundTo, maxVal);
        drawDataTable()
    });
    maxVal = parseInt(10 * (document.getElementById("maxVal").value) + 1);
    document.getElementById("maxVal").addEventListener("change", function() {
        maxVal = parseInt(10 * (document.getElementById("maxVal").value) + 1);
        document.getElementById("log_div").innerHTML = tabfn(roundTo, maxVal);
        drawDataTable()
    });
    base1 = parseFloat(document.getElementById("base1").value);
    document.getElementById("log_div").innerHTML = tabfn(roundTo, maxVal);
    xtra = '';
    document.getElementById("base1").addEventListener("change", function() {
        if (document.getElementById("base1").value == "e") {
            base1 = Math.E;
            xtra = "e = ";
        } else {
            base1 = parseFloat(document.getElementById("base1").value);
        }
        document.getElementById("log_div").innerHTML = tabfn(roundTo, maxVal);
        document.getElementById("thisBase").innerHTML = xtra + base1;
        drawDataTable()
    });

    function drawDataTable() {
        $('#logtable').DataTable().destroy();
        $('#logtable').DataTable().draw();
    }
    var dTable = null;
    $(function() {
        dTable = $('#logtable').DataTable({
            // data: dataSet,
            // columns: [
            //     { title: "N" },
            //     { title: "0" },
            //     { title: "1" },
            //     { title: "2" },
            //     { title: "3" },
            //     { title: "4" },
            //     { title: "5" },
            //     { title: "6" },
            //     { title: "7" },
            //     { title: "8" },
            //     { title: "9" }
            // ]
        });

        $('#logtable tbody').on('click', 'tr', function() {
            if ($(this).hasClass('row_selected')) {
                $(this).removeClass('row_selected');
            } else {
                table.$('tr.row_selected').removeClass('row_selected');
                $(this).addClass('row_selected');
            }
        });
    })
    function manualLogCalculate(){
        var isValid = true;
        
        var logType = $("#log_type").val();
        var number = $("#manual_log_number").val();
        var base = $("#manual_log_base").val();
        var roundTo = $("#manual_log_roundTo").val();
        var result = $("#manual_log_result");
        var resHTML = ""
        if(number == ""){
            isValid = false;
            bootbox.alert("Please enter a valid number");
        }else if(number < 0 ){
            isValid = false;
            bootbox.alert("Please enter a valid number");
        }else if(isNaN(number)){
            isValid = false;
            bootbox.alert("Please enter a valid number");
        }
        if(isValid == true){
            if(logType == "log"){
                resHTML = (Math.log(number) / Math.log(base)).toFixed(roundTo);
            }else{
                resHTML = (Math.pow(base,number)).toFixed(roundTo);
            }
            result.html(resHTML);
        }
    }
</script>