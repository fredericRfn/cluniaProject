<?php
// Data retriever

// Example of request:
// SELECT * FROM Data JOIN Datarows ON datarow_id=id WHERE sensor_id=1 AND measured_at BETWEEN '2016-01-01' AND '2016-05-01';
    include("config.php");
    session_start();
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    class Data { // for now, data are bidimensional
        var $x; // for now, x is a day
        var $y; // for now, y is a sensor
        function Data($datarow) {
            $this->x=$datarow['measured_at'];
            $this->y=$datarow['data'];
        }
    }
    $user_check = $_SESSION['user_id'];
    $sql = "SELECT id FROM Users WHERE id=".$user_check;
    $result = $conn->query($sql);
    $data = array();
    $sqlSensors = "SELECT * FROM Sensors";
    $resultSensors = $conn->query($sqlSensors);
    while ($sensorRow = $resultSensors->fetch_assoc()) {
        $data[$sensorRow['id']] = array();
    }
    if ($result->num_rows > 0) {
        $sqlData = "SELECT measured_at, sensor_id, data FROM Data JOIN Datarows ON datarow_id=id";
        $resultData = $conn->query($sqlData);
        while ($datarow = $resultData->fetch_assoc()) {
	        $datum = new Data($datarow);
            array_push($data[$datarow['sensor_id']], $datum);
        }
        echo(json_encode($data));
    } else {
        echo("Something bad occurred during the data recuperation"); 
     }
    $conn->close();
?>
