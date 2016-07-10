var dashboards = [];
var activeDashboard = -1; // -1 means the display is the message inviting to create a new dashboard
var activeChart = -1; // Same logic: -1 = no graph selected 
var chartTypes = [];
var sensors = []; //Array containing the sensors and its data, in the JSON format

// The data collection stores all the data in an array, sorted by sensor_id and by timestamp
// Structure _
/*    [
         sensor 0: [x,y], [x,y], [x,y]...
         ...
        ]
*/
var data_collection = JSON.parse("{}"); 

//The first thing is to load everything
$(function() {
    buildDashboardGlobalLayout();
    $.ajax({
        type: "POST",
        url: "../data/retrieve.php",
        success: function(data) {
            data_collection = JSON.parse(data);
            importFromDatabase(true);
        }
    });
});


//This function is responsible for importing all the dashboards and
//refreshes the view
function importFromDatabase(switchAndSaveDashboard) {
    $.ajax({
        type: "POST",
        url: "../dashboard/import.php",
        success: function(data2) {    
            dashboards = JSON.parse(data2)["dashboards"];
            chartTypes = JSON.parse(data2)["chartTypes"];
            sensors = JSON.parse(data2)["sensors"];
            if (switchAndSaveDashboard) {
                activeDashboard = dashboards.length - 1;
                switchDashboard(activeDashboard);
            }
        }
    });
}

// Saves the active dashboard, and refresh dashboards data
function exportToDatabase(redirect) {
    $.ajax({
        type: "POST",
        dataType: "text",
        url: "../dashboard/store.php",
        data : 'json=' + JSON.stringify(dashboards[activeDashboard]),
        success: function(msg) {
            importFromDatabase(redirect);
        }
    });      
}

// Function que permite eliminar un dashboard
function removeFromDatabase() {
    var r=confirm("Eliminar un dashboard es definitivo. ¿ Eliminar el dashboard " + dashboards[activeDashboard]["title"] + " ?" );
    if (r == true) {
      $.ajax({
        type: "POST",
        dataType: "text",
        url: "../dashboard/remove.php",
        data : 'dashboard_id=' + dashboards[activeDashboard]["id"],
        success: function(msg) {
            importFromDatabase(true);
        }
        }); 
    }
}

// Creates a new empty dashboard and instantly store it in db
function newDashboard() {
    var newDashboard = JSON.parse("{\"id\":0, \"title\":\"Informe " + (dashboards.length + 1) + "\",\"description\":\"\",\"is_default\":0,\"charts\":[]}");
    activeDashboard = dashboards.length;
    dashboards.push(newDashboard);
    $("#dashboard_selector").val(activeDashboard);
    exportToDatabase(true);
}

function switchDashboardFromSelector() { // By clicking on the dropdown list
    exportToDatabase(false);
    switchDashboard($("#dashboard_selector").val());
}

function switchChartFromSelector() { // By clicking on the dropdown list
    activeChart=$("#chart_selector").val();
    refreshParameters();
}

function switchDashboard(value) {
    activeDashboard = value; // Obtained thanks to the id of the item selected
    if (activeDashboard < 0) {
        activeChart = -1;
    }
    else {
        if(dashboards[activeDashboard]["charts"].length == 0) {
            activeChart = -1;
        } else {
            activeChart = 0;
        }
    }
    refreshSelectors();
    refreshChartsSelectors();
    refreshParameters();
    refreshDashboardContent();
    renderCharts();
}

function refreshSelectors() {
    $("#dashboard_selector").empty();
    for (i = 0; i < dashboards.length; i++) { 
        $("#dashboard_selector").append("<option value=" + i + ">"+ dashboards[i]["title"] +"</option>");
    }
    $("#dashboard_selector").val(activeDashboard);
    $("#sensor_selector").empty();
    for (i = 0; i < sensors.length; i++) {
        $("#sensor_selector").append("<option value=" + (i+1) + ">"+ sensors[i]["name"] +"</option>");
    }
    $("#chartType_selector").empty();
    for (i = 0; i < chartTypes.length; i++) { 
        $("#chartType_selector").append("<option value=" + (i+1) + ">"+ chartTypes[i]["name"] +"</option>");
    }
    if (activeChart<0) {
        $("#chartType_selector").prop('disabled', true);
        $("#chartType_selector").val(1);
        $("#sensor_selector").prop('disabled', true);
        $("#remove_chart").prop('disabled', true);
    } else {
        $("#chartType_selector").prop('disabled', false);
        $("#sensor_selector").prop('disabled', false);
        $("#remove_chart").prop('disabled', false);
        $("#sensor_selector").val(dashboards[activeDashboard]["charts"][activeChart]["sensor_id"]);
        $("#chartType_selector").val(dashboards[activeDashboard]["charts"][activeChart]["type"]);
    }
}

function refreshChartsSelectors() {
    $("#chart_selector").empty();    
    if (activeDashboard<0) {
        $("#remove_dashboard").prop('disabled', true);
        $("#save_dashboard").prop('disabled', true);
        $("#chart_selector").empty();
        $("#chart_selector").prop('disabled', true);
        $("#add_chart").prop('disabled', true);
    } else {
        for (i = 0; i < dashboards[activeDashboard]["charts"].length; i++) { 
            $("#chart_selector").append("<option value=" + i + ">"+ dashboards[activeDashboard]["charts"][i]["title"] +"</option>");
        }
        $("#add_chart").prop('disabled', false);
        $("#remove_dashboard").prop('disabled', false);
        $("#save_dashboard").prop('disabled', false);
        if (activeChart<0) {        
            $("#chart_selector").prop('disabled', true);
        } else {
            $("#chart_selector").prop('disabled', false);
        }
    }
}

function refreshParameters() {
    if (activeDashboard<0) {
        $(".form-dashboard").empty();
        $(".form-dashboard").prop('disabled', true);
    } else {
        $(".form-dashboard").prop('disabled', false);
        $("#dashboard_title").empty().val(dashboards[activeDashboard]["title"]);
        $("#dashboard_description").empty().val(dashboards[activeDashboard]["description"]);
    }
    if (activeChart<0) {
            $("#chart_title").val("");
            $("#chart_description").val("");
            $("#chart_row").val(0);
            $("#chart_column").val(0);
            $("#chart_height").val(0);
            $("#chart_width").val(0);
            $("#chart_from").val("");
            $("#chart_to").val("");
            $("#chart_accuracy").val(0);
            $(".form-chart").prop('disabled', true);
    } else {
        $(".form-chart").prop('disabled', false);
        $("#chart_title").val(dashboards[activeDashboard]["charts"][activeChart]["title"]);
        $("#chart_description").val(dashboards[activeDashboard]["charts"][activeChart]["description"]);
        $("#chart_row").val(dashboards[activeDashboard]["charts"][activeChart]["row"]);
        $("#chart_column").val(dashboards[activeDashboard]["charts"][activeChart]["column"]);
        $("#chart_height").val(dashboards[activeDashboard]["charts"][activeChart]["height"]);
        $("#chart_width").val(dashboards[activeDashboard]["charts"][activeChart]["width"]);
        $("#chart_from").val(dashboards[activeDashboard]["charts"][activeChart]["from"]);
        $("#chart_to").val(dashboards[activeDashboard]["charts"][activeChart]["to"]);
        $("#chart_accuracy").val(dashboards[activeDashboard]["charts"][activeChart]["accuracy"]);
        $("#sensor_selector").val(dashboards[activeDashboard]["charts"][activeChart]["sensor_id"]);
        $("#chartType_selector").val(dashboards[activeDashboard]["charts"][activeChart]["type"]);
    }
}

// FUNCTIONS USED TO TAKE INTO ACCOUNT IN REAL TIME THE MANUAL CHANGES IN INPUTS
function refreshDashboardTitle() {
    dashboards[activeDashboard]["title"] = $("#dashboard_title").val();
    $("#dashboard_selector").empty();
    for (i = 0; i < dashboards.length; i++) { 
        $("#dashboard_selector").append("<option value=" + i + ">"+ dashboards[i]["title"] +"</option>");
    }
    $("#dashboard_selector").val(activeDashboard);
    $("#title").text(dashboards[activeDashboard]["title"]);
}
function refreshDashboardParam(attribute) {
    dashboards[activeDashboard][attribute] = $("#dashboard_"+attribute).val();
    $("#"+attribute).text(dashboards[activeDashboard][attribute]);
}
function refreshChartTitle() {
    dashboards[activeDashboard]["charts"][activeChart]["title"] = $("#chart_title").val();
    $("#chart_selector").empty();
    for (i = 0; i < dashboards[activeDashboard]["charts"].length; i++) { 
        $("#chart_selector").append("<option value=" + i + ">"+ dashboards[activeDashboard]["charts"][i]["title"] +"</option>");
    }
    $("#chart_selector").val(activeChart);
    renderCharts();
}
function refreshChartParam(attribute, selector) {
    dashboards[activeDashboard]["charts"][activeChart][attribute] = $(selector).val();
    renderCharts();
}

function add_chart() {
    dashboards[activeDashboard]["charts"].push(JSON.parse("{\"title\":\"Nuevo\",\"description\":\"Un comentario\",\"row\":1,\"column\":1,\"width\":2,\"height\":2, \"from\":\"2015-01-01\",\"to\":\"2016-01-01\",\"type\":1, \"sensor_id\":1, \"accuracy\":50}"));
    activeChart = dashboards[activeDashboard]["charts"].length - 1;
    switchDashboard(activeDashboard);
}

function remove_chart() {
    alert(dashboards[activeDashboard]["charts"].splice(activeChart,1));
    activeChart = dashboards[activeDashboard]["charts"].length - 1;  
    switchDashboard(activeDashboard);
}

function setChartSensor() {
    dashboards[activeDashboard]["charts"][activeChart]["sensor_id"] = $("#sensor_selector").val();
    renderCharts();
}

function setChartType() {
    dashboards[activeDashboard]["charts"][activeChart]["type"] = $("#chartType_selector").val();
    renderCharts();
}

// FUNCTIONS USED TO DISPLAY THE DASHBOARD AND CONVERT JSON TO HTML
function refreshDashboardContent() {
    if (activeDashboard < 0) {
        $("#description").text("Parece que no tienes ningun informe creado," +
            "create uno haciendo clic en el boton nuevo de la sección Informes" +
        "del menu lateral");
    } else {
        var currentJSON = dashboards[activeDashboard];
        $("#title").text(currentJSON["title"]);
        $("#description").text(currentJSON["description"]);
    }
}

function buildDashboardGlobalLayout() {
    $("#dashboard").empty();
    $("#dashboard").append("<div class='row' id='title'></div>");
    $("#dashboard").append("<div class='row' style='flex-wrap: wrap;' id='description'></div>");
    for (var i = 0; i < 6; i++) {
        $("#dashboard").append("<div class='row charts-row' id='row"+i.toString()+"'>\n</div>");
    }
}

function renderCharts() {
    $(".charts-row").empty();
    var currentJSON = dashboards[activeDashboard];
    var charts = currentJSON["charts"];
    var arrayLength = charts.length;
    for (var i = 0; i < arrayLength; i++) {
        var idrc = "r"+charts[i]["row"].toString() +"c" +charts[i]["column"].toString();
        if($("#"+idrc).length==0) {
            var rowId = "#row"+charts[i]["row"].toString();
            var column_width = (charts[i]["width"]*6).toString();
            $(rowId).append("<div class='col-md-"+column_width+ "' id='"+ idrc +"'></div>");
        }
    }
    for (var i = 0; i < arrayLength; i++) {
        renderChart(i);
    }
}

function renderChart(index) {
    var chart=dashboards[activeDashboard]["charts"][index];
    var idrc = "r"+chart["row"].toString() +"c" +chart["column"].toString();
    $("#" + idrc).append("<div class='graphbox'><div class='title'>\n" + chart["title"] + "</div><div class='description'>\n" + chart["description"] + "</div>\n");
    //   result = result + "<div class='graph'>\n" + graph_html + "</div>\n";

    if(chart["sensor_id"]>0) {
        //COMPUTE POINTS TO BE DISPLAYED
        var data_sensor=data_collection[chart['sensor_id']];
        var indexMin = 0;
        var indexMax = 0;
        var from = moment(new Date(chart["from"]));
        var to = moment(new Date(chart["to"]));
        for(var i = 0; i < data_sensor.length; i++) {
            if(indexMin==0 && moment(new Date(data_sensor[i]["x"])).isAfter(from)) {
                indexMin = i;
            }
            if(indexMax==0 && moment(new Date(data_sensor[i]["x"])).isAfter(to)) {
                indexMax = i;
            }
        }
        if(indexMax==0) { indexMax = data_sensor.length -1; }
        var spacing = (indexMax-indexMin)/chart["accuracy"];
        var x = [];
        var y = [];
        for(var i = 0; i < chart["accuracy"]; i++) {
            x[i] = data_sensor[Math.floor(i*spacing) + indexMin]['x'];
            y[i] = data_sensor[Math.floor(i*spacing) + indexMin]['y'];
        }
        if(chart["type"]==1) {
            graph_html="<div><table><tr><th>Fecha</th><th>"+ sensors[chart['sensor_id']-1]['name'] + "</th></tr></table></div>";
            graph_html=graph_html + "<div style='overflow:auto;height:"+chart["height"]*100+"px'><table>";
            for(i = 0; i < chart["accuracy"]; i++) {
                graph_html = graph_html + "<tr><td>" + x[i];
                graph_html = graph_html + "</td><td>" + y[i] + "</td></tr>";
            }
            graph_html = graph_html + "</table></div>";
            $("#" + idrc).append(graph_html);
        }
        if(chart["type"]==2) {
            $("#" + idrc).append("<canvas id='chart" + index.toString() +"'></canvas>");
            // Get the context of the canvas element we want to select
            var datachart = {
                labels: x,
                datasets: [
                    {
                        label: sensors[chart['sensor_id']-1]['name'],
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: y
                    }
                ]
            };
            var ctx = document.getElementById("chart"+index.toString()).getContext("2d");
            ctx.canvas.height = chart["height"]*50;
            // Instantiate a new chart using 'data' (defined below)
            var chartgr =new Chart(ctx , { type: "line", data: datachart });
            $("#chart" + index.toString()).prop('outerHTML');
        }
        if(chart["type"]==3) {
            $("#" + idrc).append("<canvas id='chart" + index.toString() +"'></canvas>");
            // Get the context of the canvas element we want to select
            var datachart = {
                labels: x,
                datasets: [
                    {
                        label: sensors[chart['sensor_id']-1]['name'],
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: y
                    }
                ]
            };
            var ctx = document.getElementById("chart"+index.toString()).getContext("2d");
            ctx.canvas.height = chart["height"]*50;
            // Instantiate a new chart using 'data' (defined below)
            var chartgr =new Chart(ctx , { type: "bar", data: datachart });
            $("#chart" + index.toString()).prop('outerHTML');
        }
    }
    $("#" + idrc).append("</div>");
}
