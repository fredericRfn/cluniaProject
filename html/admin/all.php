<?php
include("../etc/session.php");
ini_set('memory_limit', '-1');
set_time_limit(0);
if ($isAdmin) {
    $template = "all.php";
    if(isset($_POST["d"])) {
        $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
        $data = array();
        $sensors = array();
        $sqlSensors = "SELECT * FROM Sensors WHERE datalogger_id=".$_POST["d"];
        $resultSensors = $conn->query($sqlSensors);
        while ($sensorRow = $resultSensors->fetch_assoc()) {
            $sensors[$sensorRow["id"]] = $sensorRow["name"];
        }
        $sqlData = "SELECT measured_at, sensor_id, data FROM Data JOIN Datarows ON datarow_id=id WHERE datalogger_id=".$_POST["d"];
        $resultData = $conn->query($sqlData);
        while ($datarow = $resultData->fetch_assoc()) {
            $data[$datarow["measured_at"]][$datarow["sensor_id"]] = $datarow["data"];
        }
        echo json_encode(array("sensors"=>$sensors,"data"=>$data));
    }
} else {
    header("Location: ../index.php");
}