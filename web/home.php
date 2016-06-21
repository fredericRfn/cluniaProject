<?php
     include("redirect.php");
?>

<script>
    var allJSONs = [];
    var dashboardNumber = -1;
    var chartTypes = ["Tabla"];
    $(function() {
          importFromDatabase(); // Loading all dashboards of the logged user into allJSONs
          console.log("Data received");
          console.log(allJSONs);
          if (allJSONs.length == 0) { // If there is none
            console.log("No dashboards");
            dashboardNumber = -1;
            refreshDashboard(); 
          } else { // Else select the first one and display it. Soon, it should be the default one defined by the user
            dashboardNumber = 0;
            refreshDashboard(); 
          }
    });
    function exportToDatabase() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "store_dashboard.php", //Relative or absolute path to response.php file
            data : 'json=' + JSON.stringify(allJSONs[dashboardNumber]) + '&dashboard_num=' + dashboardNumber,
            success: function(msg) {
                alert(msg);
            }
        });      
    }
    
    // Creates a new empty dashboard and instantly store it in db
    function newDashboard() {
        var newDashboard = JSON.parse("{\"title\":\"Dashboard sin titulo\",\"description\":\"Tu nuevo dashboard! No olvides guardarlo\",\"charts\":[]}");
        dashboardNumber = allJSONs.length;
        allJSONs.push(newDashboard);
        //exportToDatabase();
        $("#dashboard_selector").append("<option>"+ allJSONs[dashboardNumber]["title"] +"</option>")
        $("#dashboard_title").empty().val(allJSONs[dashboardNumber]["title"])
        $("#dashboard_description").empty().val(allJSONs[dashboardNumber]["description"])
        refreshDashboard();
    }

    function switchDashboard() {
        exportToDatabase();
        var dashboardNumber = 0; // Obtained thanks to the id of the item selected
        refreshDashboard();
    }
    function importFromDatabase() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "get_dashboard.php", //Relative or absolute path to response.php file
            success: function(data) {
                allJSONs = JSON.parse(data);
            }
        });   
    }
    function renderChart(chart) {
        console.log(chart);
        var result = "<div class='graphbox' style='height:" + chart["height"] + "%'>\n";
        result = result + "<div class='title'>\n" + chart["title"] + "</div>\n";
        result = result + "<div class='description'>\n" + chart["description"] + "</div>\n";
        result = result + "<div class='graph'>\n" + "graph content powered by chartjs" + "</div>\n";
        result = result + "</div>";
        console.log(result);
        return result;
    }
    function refreshDashboard() {
        $("#dashboard").empty();
        var html = "";
        if (allJSONs.length == 0) {
                html = "<h4 style='margin-top: 40px; text-align: center;'> Parece que no tienes ningun dashboard creado, create uno haciendo clic en el boton nuevo de la sección Dashboards del menu lateral</h4>";
        } else {
            var currentJSON = allJSONs[dashboardNumber];
            html=  "<div class='row' id='title'>\n" + currentJSON["title"] + "\n</div>\n";
            html= html + "<div class='row' id='description'>\n" + currentJSON["description"] + "\n</div>\n\n";  
            var charts = currentJSON["charts"];
            console.log(html);
            var arrayLength = charts.length;
            if (arrayLength>0) {
                var currentRow = 0;
                var currentColumn = 0;
                for (var i = 0; i < arrayLength; i++) {
                    // charts contains the charts of the dashboard, sorted by row number then by column
                    if(currentRow!=charts[i]["row"]) {
                        currentColumn = 0;
                        currentRow = charts[i]["row"];
                        html = html + "</div>\n";
                        html= html + "<div class='row'>\n";
                    }
                    if(currentColumn!=charts[i]["column"]) {
                        currentColumn = charts[i]["column"];
                        html = html + "</div>\n";
                        html= html + "<div class='col-md-" + charts[i]["width"] + "'>\n";
                    }
                    html = html + renderChart(charts[i]);
                }
                html = html + "</div>\n";
                html = html + "</div>\n"; 
                console.log(html);
            } else {
                html = html + "<h6 style='margin-top: 40px; text-align: center;> Este dashboard no contiene ninguna gráfica. Añade una graciás al botón 'Añadir gráfica'</h6>";            
            }
        }
        $("#dashboard").append(html);
    }
</script>

<div class="container" style="padding-left:0px; padding-right:0px; padding-top: 50px;">
    <div class="row base">
		<div class="col-md-3" id="properties">
            <div class="row separator">
                <label> Dashboard </label> 
            </div> 		    
            <div class="row" id="dashboard-bar">
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default" onclick="newDashboard()">Añadir</button>
                </div>
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default" onclick="exportToDatabase()">Guardar</button>
                </div>
                <div class="col-md-4 inlined">
                    <button class="btn btn-block btn-default">Eliminar</button> 
                </div>
            </div>
            <div class="row">
                <label>Ver el dashboard: </label><select class="form-control" id="dashboard_selector"></select>  
            </div>
            <div class="row">
                <label><input type ="checkbox" name="role" value="1">Dashboard por defecto</label>  
            </div>
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Titulo</label>
                    <label>Descripción</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="text" class ="form-control" name="title" id="dashboard_title">
                    <input type ="text" class ="form-control" name="description" id="dashboard_description">
                </div>
            </div>	    
            <div class="row separator">
                <label> Gráfica </label>  
            </div>
            <div class="row" id="graphics-bar">
                <button class="btn btn-default">Añadir gráfica</button>
                <button class="btn btn-default">Eliminar esta gráfica</button>  
            </div>
            <div class="row">
                <label>Gráficas del dashboard:</label><select class="form-control"></select>  
            </div>
            <div class="row bordered"></div> 
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Titulo</label>
                    <label>Descripción</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="text" class ="form-control" name="grtitle">
                    <input type ="text" class ="form-control" name="grdescription">
                </div>
            </div> 
            <div class="row">
                <div class="col-md-4 inlined">
                     <label>Tipo</label>
                </div>
                <div class="col-md-8 inlined">
                     <select class="form-control"></select>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 inlined">
                    <label>Fila</label>
                    <label>Anchura</label>
                </div>
                <div class="col-md-3 inlined">
                    <input type ="number" class ="form-control" name="fila">
                    <input type ="number" class ="form-control" name="anchura">
                </div>
                <div class="col-md-3 inlined">
                    <label>Columna</label>
                    <label>Altura</label>
                </div>
                <div class="col-md-3 inlined">
                    <input type ="number" class ="form-control" name="fila">
                    <input type ="number" class ="form-control" name="anchura">
                </div>
            </div>
            <div class="row bordered"></div> 
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Desde</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="number" class ="form-control" name="from">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 inlined">
                    <label>Hasta</label>
                </div>
                <div class="col-md-8 inlined">
                    <input type ="number" class ="form-control" name="to">
                </div>
            </div> 
           <div class="row">
                <label>Sensor del cual imprimir datos:</label><select class="form-control"></select>
           </div>
		</div>
		<div class="col-md-9" id="dashboard"> 
		</div>
    </div>
</div>
