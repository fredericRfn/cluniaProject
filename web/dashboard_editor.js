var allJSONs = [];
var dashboardNumber = -1; // -1 means the display is the message inviting to create a new dashboard
var currentChart = -1; // Same logic: -1 = no graph selected 
var chartTypes = [];
var sensors = [];

$(function() {
      importFromDatabase(true); // Loading all dashboards of the logged user into allJSONs, sensors in the sensors var and chartTypes in chartTypes
});
function exportToDatabase(redirect) {
    $.ajax({
        type: "POST",
        dataType: "text",
        url: "store_dashboard.php", //Relative or absolute path to response.php file
        data : 'json=' + JSON.stringify(allJSONs[dashboardNumber]),
        success: function(msg) {
            console.log(msg);
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
            alert(msg);
            importFromDatabase(true);
        }
        }); 
    }
}

// Creates a new empty dashboard and instantly store it in db
function newDashboard() {
    var newDashboard = JSON.parse("{\"id\":0, \"title\":\"Dashboard " + (allJSONs.length + 1) + "\",\"description\":\"Tu nuevo dashboard está creado\",\"is_default\":0,\"charts\":[]}");
    dashboardNumber = allJSONs.length;
    allJSONs.push(newDashboard);
    $("#dashboard_selector").val(dashboardNumber);
    exportToDatabase(true);
}

function switchDashboardFromSelector() { // By clicking on the dropdown list
        exportToDatabase(false);
        switchDashboard($("#dashboard_selector").val());
}

function switchDashboard(value) {
    dashboardNumber = value; // Obtained thanks to the id of the item selected
    if (dashboardNumber < 0) {
        currentChart = -1;
    }
    else {
        if (allJSONs[dashboardNumber]["charts"].length <= currentChart) {
            currentChart = -1;
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
        success: function(data) {
            allJSONs = JSON.parse(data)["dashboards"];
            chartTypes = JSON.parse(data)["chartTypes"];
            sensors = JSON.parse(data)["sensors"];
            if (redirect) {
                dashboardNumber = allJSONs.length - 1;
                switchDashboard(dashboardNumber);
            }
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
        $("#sensor_selector").append("<option value=" + i + ">"+ sensors[i]["name"] +"</option>");
    }
    $("#chartType_selector").empty();
    for (i = 0; i < chartTypes.length; i++) { 
        $("#chartType_selector").append("<option value=" + i + ">"+ chartTypes[i]["name"] +"</option>");
    }
    if (currentChart<0) {
        $("#chartType_selector").prop('disabled', true);
        $("#sensor_selector").prop('disabled', true);
        $("#remove_chart").prop('disabled', true);
    } else {
        $("#chartType_selector").prop('disabled', false);
        $("#sensor_selector").prop('disabled', false);
        $("#remove_chart").prop('disabled', false);
        $("#sensor_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["sensor_id"]-1);
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
        $("#sensor_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["sensor_id"]-1);
        $("#chartType_selector").val(allJSONs[dashboardNumber]["charts"][currentChart]["type"] - 1);
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

function refreshChartParam(attribute, selector) {
    allJSONs[dashboardNumber]["charts"][currentChart][attribute] = $(selector).val();
    refreshDashboard();
}

function add_chart() {
    allJSONs[dashboardNumber]["charts"].push(JSON.parse("{\"title\":\"Nueva Gráfica\",\"description\":\"Comenta tu gráfica\",\"row\":1,\"column\":1,\"width\":12,\"height\":5, \"from\":\"2015-01-01\",\"to\":\"2016-01-01\",\"type\":1, \"sensor_id\":1}"));
    currentChart = allJSONs[dashboardNumber]["charts"].length - 1;  
    switchDashboard(dashboardNumber);
}

function remove_chart() {
    alert(JSON.stringify(allJSONs[dashboardNumber]["charts"].splice(currentChart,1)));
    currentChart = allJSONs[dashboardNumber]["charts"].length - 1;  
    switchDashboard(dashboardNumber);
}



// FUNCTIONS USED TO DISPLAY THE DASHBOARD AND CONVERT JSON TO HTML

function renderChart(chart) {
    var result = "<div class='graphbox' style='height:" + chart["height"] + "%'>\n";
    result = result + "<div class='title'>\n" + chart["title"] + "</div>\n";
    result = result + "<div class='description'>\n" + chart["description"] + "</div>\n";
    result = result + "<div class='graph'>\n" + "graph content powered by chartjs" + "</div>\n";
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
        var charts = currentJSON["charts"];
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
            //console.log(html);
        } else {
            html = html + "<h6 style='margin-top: 40px; text-align: center;> Este dashboard no contiene ninguna gráfica. Añade una graciás al botón 'Añadir gráfica'</h6>";            
        }
    }
    $("#dashboard").append(html);
}
