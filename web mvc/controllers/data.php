<?php

 class DataContainer {
    var $x; // for now, x is a day
    var $y; // for now, y is a sensor
    function DataContainer($datarow) {
        $this->x=utf8_encode($datarow['measured_at']);
        $this->y=utf8_encode($datarow['data']);
    }
}

class Data extends Controller {
    public function retrieve() {
        if($this->isLogged) {
            ini_set('memory_limit', '-1');
            set_time_limit(0);
            session_start();
            $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $user_check = $_SESSION['user_id'];
            $data = array();
            $sqlSensors = "SELECT * FROM Sensors";
            $resultSensors = $conn->query($sqlSensors);
            while ($sensorRow = $resultSensors->fetch_assoc()) {
                $data[$sensorRow['id']] = array();
            }
            $sqlData = "SELECT measured_at, sensor_id, data FROM Data JOIN Datarows ON datarow_id=id";
            $resultData = $conn->query($sqlData);
            while ($datarow = $resultData->fetch_assoc()) {
                $datum = new DataContainer($datarow);
                array_push($data[$datarow['sensor_id']], $datum);
            }
            echo(json_encode($data));
            $conn->close();
        } else {
            header("Location: index.php");
        }
    }
}