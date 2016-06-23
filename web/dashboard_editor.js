var allJSONs = [];
var dashboardNumber = -1; // -1 means the display is the message inviting to create a new dashboard
var currentChart = -1; // Same logic: -1 = no graph selected 
var chartTypes = []
var sensors = []; //JSON containing the sensors and its information
var data_collection = JSON.parse("{}"); // JSON containing the actual data, creating entries only for data actually requested by changing the sensor field

$(function() {
      fetchData(); // Loading all dashboards of the logged user into allJSONs, sensors in the sensors var and chartTypes in chartTypes
});
function exportToDatabase(redirect) {
    $.ajax({
        type: "POST",
        dataType: "text",
        url: "store_dashboard.php", //Relative or absolute path to response.php file
        data : 'json=' + JSON.stringify(allJSONs[dashboardNumber]),
        success: function(msg) {
            importFromDatabase(redirect);
        }
    });      
}

function removeFromDatabase() {
    var r=confirm("Eliminar un dashboard es definitivo. ¿ Eliminar el dashboard " + allJSONs[dashboardNumber]["title"] + " ?" );
    if (r == true) {
 
      $.ajax({
        type: "POST",
        dataType: "text",
        url: "remove_dashboard.php", //Relative or absolute path to response.php file
        data : 'dashboard_id=' + allJSONs[dashboardNumber]["id"],
        success: function(msg) {
            importFromDatabase(true);
        }
        }); 
    }
}

// Creates a new empty dashboard and instantly store it in db
function newDashboard() {
    var newDashboard = JSON.parse("{\"id\":0, \"title\":\"Dashboard " + (allJSONs.length + 1) + "\",\"description\":\"\",\"is_default\":0,\"charts\":[]}");
    dashboardNumber = allJSONs.length;
    allJSONs.push(newDashboard);
    $("#dashboard_selector").val(dashboardNumber);
    exportToDatabase(true);
}

function switchDashboardFromSelector() { // By clicking on the dropdown list
        exportToDatabase(false);
        switchDashboard($("#dashboard_selector").val());
}

function switchChartFromSelector() { // By clicking on the dropdown list
        currentChart=$("#chart_selector").val();       
        refreshParameters();
}

function switchDashboard(value) {
    dashboardNumber = value; // Obtained thanks to the id of the item selected
    if (dashboardNumber < 0) {
        currentChart = -1;
    }
    else {
            if(allJSONs[dashboardNumber]["charts"].length == 0) {    
                currentChart = -1;
            } else {
                currentChart = 0;
            }
    }
    refreshSelectors();
    refreshChartsSelectors();
    refreshParameters();
    refreshDashboard();
}

function importFromDatabase(redirect) {
    $.ajax({
        type: "POST",
        url: "import.php",
        success: function(data2) {    
            allJSONs = JSON.parse(data2)["dashboards"];
            chartTypes = JSON.parse(data2)["chartTypes"];
            sensors = JSON.parse(data2)["sensors"];
            if (redirect) {
                dashboardNumber = allJSONs.length - 1;
                switchDashboard(dashboardNumber);
            }
        }
    });
}

function fetchData() {
        $.ajax({
            type: "POST",
            url: "collect_data.php",
            success: function(data) {
                data_collection = JSON.parse(data);
                importFromDatabase(true);
            }
        });
}

function refreshSelectors() {
    $("#dashboard_selector").empty();
    for (i = 0; i < allJSONs.length; i++) { 
        $("#dashboard_selector").append("<option value=" + i + ">"+ allJSONs[i]["title"] +"</option>");
    }
    $("#dashboard_selector").val(dashboardNumber);
    $("#sensor_selector").empty();
    for (i = 0; i < sensors.length; i++) {
        $("#sensor_selector").append("<option value=" + (i+1) + ">"+ sensors[i]["name"] +"</option>");
    }
    $("#chartType_selector").empty();
    for (i = 0; i < chartTypes.length; i++) { 
        $("#chartType_selector").append("<option value=" + (i+1) + ">"+ chartTypes[i]["name"] +"</option>");
    }
    if (currentChart<0) {
        $("#chartType_selector").prop('disabled', true);
        $("#chartType_selector").val(1);
        $("#sensor_selector").prop('disabled', true);
        $("#remove_chart").prop('disabled', true);
    } else {
        $("#chartType_selector").prop('disabled', false);
        $("#sensor_selector").prop('disabled', false);
        $("#remove_chart").prop('disabled', false);
        $("#sensor_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["sensor_id"]);
        $("#chartType_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["type"]);
    }
}

function refreshChartsSelectors() {
    $("#chart_selector").empty();    
    if (dashboardNumber<0) {
        $("#remove_dashboard").prop('disabled', true);
        $("#save_dashboard").prop('disabled', true);
        $("#chart_selector").empty();
        $("#chart_selector").prop('disabled', true);
        $("#add_chart").prop('disabled', true);
    } else {
        for (i = 0; i < allJSONs[dashboardNumber]["charts"].length; i++) { 
            $("#chart_selector").append("<option value=" + i + ">"+ allJSONs[dashboardNumber]["charts"][i]["title"] +"</option>");
        }
        $("#add_chart").prop('disabled', false);
        $("#remove_dashboard").prop('disabled', false);
        $("#save_dashboard").prop('disabled', false);
        if (currentChart<0) {        
            $("#chart_selector").prop('disabled', true);
        } else {
            $("#chart_selector").prop('disabled', false);
        }
    }
}

function refreshParameters() {
    if (dashboardNumber<0) {
        $("#dashboard_title").empty();
        $("#dashboard_description").empty();
        $("#dashboard_default").empty();
        $("#dashboard_title").prop('disabled', true);
        $("#dashboard_description").prop('disabled', true);
        $("#dashboard_default").prop('disabled', true);
    } else {
        $("#dashboard_title").prop('disabled', false);
        $("#dashboard_description").prop('disabled', false);
        $("#dashboard_default").prop('disabled', false);

        $("#dashboard_title").empty().val(allJSONs[dashboardNumber]["title"]);
        $("#dashboard_description").empty().val(allJSONs[dashboardNumber]["description"]);
    }
    if (currentChart<0) {
            $("#chart_title").val("");
            $("#chart_description").val("");
            $("#chart_row").val(0);
            $("#chart_column").val(0);
            $("#chart_height").val(0);
            $("#chart_width").val(0);
            $("#chart_from").val("");
            $("#chart_to").val("");
            $("#chart_title").prop('disabled', true);
            $("#chart_description").prop('disabled', true);
            $("#chart_row").prop('disabled', true);
            $("#chart_column").prop('disabled', true);
            $("#chart_height").prop('disabled', true);
            $("#chart_width").prop('disabled', true);
            $("#chart_from").prop('disabled', true);
            $("#chart_to").prop('disabled', true);
    } else {
        $("#chart_title").prop('disabled', false);
        $("#chart_description").prop('disabled', false);
        $("#chart_row").prop('disabled', false);
        $("#chart_column").prop('disabled', false);
        $("#chart_height").prop('disabled', false);
        $("#chart_width").prop('disabled', false);
        $("#chart_from").prop('disabled', false);
        $("#chart_to").prop('disabled', false);

        $("#chart_title").val(allJSONs[dashboardNumber]["charts"][currentChart]["title"]);
        $("#chart_description").val(allJSONs[dashboardNumber]["charts"][currentChart]["description"]);
        $("#chart_row").val(allJSONs[dashboardNumber]["charts"][currentChart]["row"]);
        $("#chart_column").val(allJSONs[dashboardNumber]["charts"][currentChart]["column"]);
        $("#chart_height").val(allJSONs[dashboardNumber]["charts"][currentChart]["height"]);
        $("#chart_width").val(allJSONs[dashboardNumber]["charts"][currentChart]["width"]);
        $("#chart_from").val(allJSONs[dashboardNumber]["charts"][currentChart]["from"]);
        $("#chart_to").val(allJSONs[dashboardNumber]["charts"][currentChart]["to"]);
        $("#sensor_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["sensor_id"]);
        $("#chartType_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["type"]);
    }
}

// FUNCTIONS USED TO TAKE INTO ACCOUNT IN REAL TIME THE MANUAL CHANGES IN INPUTS
function refreshDashboardTitle() {
    allJSONs[dashboardNumber]["title"] = $("#dashboard_title").val();
    $("#dashboard_selector").empty();
    for (i = 0; i < allJSONs.length; i++) { 
        $("#dashboard_selector").append("<option value=" + i + ">"+ allJSONs[i]["title"] +"</option>");
    }
    $("#dashboard_selector").val(dashboardNumber);
    refreshDashboard();
}
function refreshDashboardParam(attribute, selector) {
    allJSONs[dashboardNumber][attribute] = $(selector).val();
    refreshDashboard();
}
function refreshChartTitle() {
    allJSONs[dashboardNumber]["charts"][currentChart]["title"] = $("#chart_title").val();
    $("#chart_selector").empty();
    for (i = 0; i < allJSONs[dashboardNumber]["charts"].length; i++) { 
        $("#chart_selector").append("<option value=" + i + ">"+ allJSONs[dashboardNumber]["charts"][i]["title"] +"</option>");
    }
    $("#chart_selector").val(currentChart);
    refreshDashboard();
}
function refreshChartParam(attribute, selector) {
    allJSONs[dashboardNumber]["charts"][currentChart][attribute] = $(selector).val();
    refreshDashboard();
}

function add_chart() {
    allJSONs[dashboardNumber]["charts"].push(JSON.parse("{\"title\":\"Nueva Gráfica\",\"description\":\"Comenta tu gráfica\",\"row\":1,\"column\":1,\"width\":12,\"height\":100, \"from\":\"2015-01-01\",\"to\":\"2016-01-01\",\"type\":1, \"sensor_id\":1}"));
    currentChart = allJSONs[dashboardNumber]["charts"].length - 1;
    switchDashboard(dashboardNumber);
}

function remove_chart() {
    alert(JSON.stringify(allJSONs[dashboardNumber]["charts"].splice(currentChart,1)));
    currentChart = allJSONs[dashboardNumber]["charts"].length - 1;  
    switchDashboard(dashboardNumber);
}

function setChartSensor() {
    allJSONs[dashboardNumber]["charts"][currentChart]["sensor_id"] = $("#sensor_selector").val();
    refreshDashboard();
}

// FUNCTIONS USED TO DISPLAY THE DASHBOARD AND CONVERT JSON TO HTML

function renderChart(chart, index) {
    var graph_html="graph content powered by chartjs";
    // Compute limiters: index of min date, index of max date
    //STEP 1: Iterate until find the min thanks to the Dates objects
    //STEP 2: Iterate until find the max
    //STEP 3: Put a limitation to the number of points plotted spacing the points regularly
    // (up to 50-100 points per graph would be nice)
    if(chart["sensor_id"]>0) {  
        if(chart["type"]==1) {
            graph_html="<div><table><tr><th>Fecha</th><th>"+ sensors[chart['sensor_id']-1]['name'] + "</th></tr></table></div>";
            graph_html=graph_html + "<div style='overflow:auto;height:"+chart["height"]+"px'><table>";           
            data_sensor=data_collection[chart['sensor_id']];

            //Limiters:
            //STEP 1: Iterate until find the min thanks to the Dates objects
            //STEP 2: Iterate until find the max
            //STEP 3: Put a limitation to the number of points plotted spacing the points regularly, that the user can adjust
            // (up to 50-100 points per graph would be nice)
            for(i = 0; i < 50; i++) {        
                graph_html = graph_html + "<tr><td>" + data_sensor[i]['x'];
                graph_html = graph_html + "</td><td>" + data_sensor[i]['y'] + "</td></tr>";
            }
            graph_html = graph_html + "</table></div>";
        }
        if(chart["type"]==2) {
           $("#dashboard").append("<canvas id='chart" + index +"' width='450' height='200'></canvas>");
          // Get the context of the canvas element we want to select
          var datachart = {
            labels: ["January", "February", "March", "April", "May", "June", "July"],
            datasets: [
              {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 80, 81, 56, 55, 40]
              },
              {
                label: "My Second dataset",
                fillColor: "rgba(151,187,205,0.2)",
                strokeColor: "rgba(151,187,205,1)",
                pointColor: "rgba(151,187,205,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 86, 27, 90]
              }
            ]
          };
          var ctx = document.getElementById("chart").getContext("2d");
          // Instantiate a new chart using 'data' (defined below)
          var chart = new Chart(ctx).Line(datachart);
          graph_html=document.getElementById("chart" + index).prop('outerHTML');
          $("#dashboard").empty();
        }
    }
    var result = "<div class='graphbox' style='height:" + chart["height"] + "px'>\n";
    result = result + "<div class='title'>\n" + chart["title"] + "</div>\n";
    result = result + "<div class='description'>\n" + chart["description"] + "</div>\n";
    result = result + "<div class='graph'>\n" + graph_html + "</div>\n";
    result = result + "</div>";
    return result;
}
function refreshDashboard() {
    $("#dashboard").empty();
    var html = "";
    if (dashboardNumber < 0) {
            html = "<h4 style='margin-top: 40px; text-align: center;'> Parece que no tienes ningun dashboard creado, create uno haciendo clic en el boton nuevo de la sección Dashboards del menu lateral</h4>";
    } else {
        var currentJSON = allJSONs[dashboardNumber];
        html=  "<div class='row' id='title'>\n" + currentJSON["title"] + "\n</div>\n";
        html= html + "<div class='row' id='description'>\n" + currentJSON["description"] + "\n</div>\n\n";  
        $("#dashboard").append(html);
        var charts = currentJSON["charts"];
        var arrayLength = charts.length;
        for (var i = 0; i < 12; i++) {  
            $("#dashboard").append("<div class='row"+i+"'>\n</div>");
        }
        if (arrayLength>0) {
            for (var i = 0; i < arrayLength; i++) {                 
                if($(charts[i]["column"]).length==0) {
                    html= "<div class='col-md-" + charts[i]["width"] + "' id='r"+charts[i]["row"] +"c" +charts[i]["column"] +"'>\n</div>";
                    $("#row"+charts[i]["row"]+"\"").append(html);  
                }
                html = renderChart(charts[i],i);
	 	$("#r"+charts[i]["row"] +"c" +charts[i]["column"]+"\"").append(html);
            }
        }
    }
}   
