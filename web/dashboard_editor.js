var allJSONs = [];
var dashboardNumber = -1;
var chartTypes = ["Tabla"];
$(function() {
      importFromDatabase(); // Loading all dashboards of the logged user into allJSONs, sensors in the sensors var and chartTypes in chartTypes
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
        url: "import.php",
        success: function(data) {
            allJSONs = JSON.parse(data)["dashboards"];
            if (allJSONs.length == 0) { // If there is none
                console.log("No dashboards");
                dashboardNumber = -1;
                refreshDashboard(); 
            } else { // Else select the first one and display it. Soon, it should be the default one defined by the user
                dashboardNumber = 0;
                refreshDashboard(); 
            }
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
