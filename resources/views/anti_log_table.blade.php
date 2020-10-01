<legend>Table of Anti Log Values</legend>
<div class="row">
    <div class="col-md-4">
<label>Select base:</label>
<select id="anti_log_base1" class="form-control">
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
<select id="anti_log_roundTo" class="form-control">
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
<select id="anti_log_maxVal" class="form-control">
    <option value="1">0.09</option>
    <option value="2">0.19</option>
    <option value="3">0.29</option>
    <option value="4">0.39</option>
    <option value="5">0.49</option>
    <option value="6">0.59</option>
    <option value="7">0.69</option>
    <option value="8">0.79</option>
    <option value="9">0.89</option>
    <option value="10">0.99</option>
</select>
</div>
</div>
<h2>Log Table: Selected Base <span id="anti_log_base">2</span></h2>
<div class="log_div" id="anti_log_div">
    <h2>Log Table: Base 2</h2>
</div>

<script>
    var antiLogb = function (x, b, r) {
        return (Math.pow(b,x)).toFixed(r);
    }
    var antiTabFn = function (round, max) {
        
		table = "<table id=\"anti_log_table\" class='table table-bordered'>";
        for (i = 1; i < max; i++) {
            if (i == 1) {
                table += "<thead><tr><th>N</th>";
                for (n = 0; n < 10; n++) {
                    table += "  <th>" + n + "</th>";
                }
                table += "</tr></thead><tbody>";
            }
            // alert((1 + (i - 1) / 10).toFixed(1))
            // alert(antiLogb((1 + (i - 1) / 10), anti_log_base1, round))
            table += "<tr><td>" + ((i - 1) / 100).toFixed(2) + "</td><td>" + antiLogb(((i - 1) / 100), anti_log_base1, round) + "</td>";
            for (j = 1; j < 10; j++) {
                // alert(antiLogb(((1 + (i - 1) / 10) + j / 100), anti_log_base1, round))
                table += "<td>" + antiLogb((((i - 1) / 100) + j / 1000), anti_log_base1, round) + "</td>";
            }
            table += "</tr>";
        }
        table += "</tbody>";
        table += "</table>";
        return table;
        
    }
    anti_log_roundTo = parseInt(document.getElementById("anti_log_roundTo").value);
    document.getElementById("anti_log_roundTo").addEventListener("change", function () {
        anti_log_roundTo = parseInt(document.getElementById("anti_log_roundTo").value);
        document.getElementById("anti_log_div").innerHTML = antiTabFn(anti_log_roundTo, anti_log_maxVal);
        drawAntiLogTable()
    });
    anti_log_maxVal = parseInt(10 * (document.getElementById("anti_log_maxVal").value) + 1);
    document.getElementById("anti_log_maxVal").addEventListener("change", function () {
        anti_log_maxVal = parseInt(10 * (document.getElementById("anti_log_maxVal").value) + 1);
        document.getElementById("anti_log_div").innerHTML = antiTabFn(anti_log_roundTo, anti_log_maxVal);
        drawAntiLogTable()
    });
	 anti_log_base1 = parseFloat(document.getElementById("anti_log_base1").value);
    document.getElementById("anti_log_div").innerHTML = antiTabFn(anti_log_roundTo, anti_log_maxVal);
	 anti_log_xtra='';
    document.getElementById("anti_log_base1").addEventListener("change", function () {
	   if (document.getElementById("anti_log_base1").value == "e") {
		  anti_log_base1 = Math.E;
		  xtra = "e = ";
	   } else {
		  anti_log_base1 = parseFloat(document.getElementById("anti_log_base1").value );
       }
	   document.getElementById("anti_log_div").innerHTML = antiTabFn(anti_log_roundTo, anti_log_maxVal);
        document.getElementById("anti_log_base").innerHTML = anti_log_xtra+anti_log_base1;
        drawAntiLogTable()
   });

   function drawAntiLogTable(){
    $('#anti_log_table').DataTable().destroy();
    $('#anti_log_table').DataTable().draw();
   }
   $(function(){
       $('#anti_log_table').DataTable();
   })
</script>