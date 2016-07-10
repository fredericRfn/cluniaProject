<?php
include("../etc/session.php");
include("../etc/dao.php");

if($isLogged) {
    ini_set('memory_limit', '-1');
    set_time_limit(0);
    session_start();
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $user_check = $_SESSION['user_id'];
    $dashboards = array();
    $sensors = array();
    $chartTypes = array();

    $sqlDashboard = "SELECT * FROM Dashboards WHERE user_id=".$user_check ;
    $resultDashboard = $conn->query($sqlDashboard);
    while ($dashboardRow = $resultDashboard->fetch_assoc()) {
        $sqlCharts = "SELECT * FROM Charts WHERE dashboard_id=".$dashboardRow['id'];
        $resultCharts = $conn->query($sqlCharts);
        $dashboard = new Dashboard($dashboardRow, $resultCharts);
        array_push($dashboards, $dashboard);
    }
    
    $sqlSensors = "SELECT * FROM Sensors";
    $resultSensors = $conn->query($sqlSensors);
    while ($sensorRow = $resultSensors->fetch_assoc()) {
    $sensor = new Sensor($sensorRow);
        array_push($sensors, $sensor);
    }
    
    $sqlChartTypes = "SELECT * FROM ChartTypes";
    $resultChartType = $conn->query($sqlChartTypes);
    while ($chartTypeRow = $resultChartType->fetch_assoc()) {
    $chartType = new ChartType($chartTypeRow);
        array_push($chartTypes, $chartType);
    }
    
    $msg=json_encode(array("sensors"=>$sensors, "chartTypes"=>$chartTypes, "dashboards"=>$dashboards));
    $conn->close();
    echo($msg);
} else {
    header("Location: ../index.php");
}