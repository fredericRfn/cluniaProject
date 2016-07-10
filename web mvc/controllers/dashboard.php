<?php

include(__DIR__ . "/etc/dao.php");

class Dashboard extends Controller {
    public function import() {
        if($this->isLogged) {
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
            header("Location: index.php");
        }
    }

    public function store() {
        if($this->isLogged) {
            $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $user_check = $_SESSION['user_id'];
            $msg="";
            if (!empty($_POST['json'])) {
                    $dashboard_data=json_decode($_POST['json'],true); 
                    $sql = "SELECT * FROM Dashboards WHERE id=".$dashboard_data['id'];
                    $result = $conn->query($sql);
                    $dashboard_data=json_decode($_POST['json'],true);                
                    if ($result->num_rows == 0) {
                        $sqlDashboard = "INSERT INTO Dashboards(user_id, title, description, is_default) VALUES (".$user_check.",'".$dashboard_data["title"]."','".$dashboard_data["description"]."',". $dashboard_data["is_default"].")";
                        $conn->query($sqlDashboard);
                        $sql = "SELECT * FROM Dashboards WHERE id=".$dashboard_data['id'];
                        $result = $conn->query($sql);
                        $dashboard_row=$result->fetch_assoc();
                        $dashboard_id=$dashboard_row['id'];
                    } else {
                        $dashboard_row=$result->fetch_assoc();
                        $dashboard_id=$dashboard_row['id'];
                        $sqlDashboard = "UPDATE Dashboards SET title='".$dashboard_data["title"]."', description='".$dashboard_data["description"]."', is_default=".$dashboard_data["is_default"]." WHERE id=".$dashboard_id;
                        $conn->query($sqlDashboard);
                    }

                    // Insert Charts
                    $charts=$dashboard_data["charts"];
                    $sqlCharts1 = "DELETE FROM Charts WHERE dashboard_id=".$dashboard_id;
                    $result = $conn->query($sqlCharts1);                
                    for ($i = 0 ; $i < count($charts); $i++) {
                        $c = $charts[$i];
                        $sqlCharts2 = "INSERT INTO Charts(dashboard_id,title,description,row_num,column_num,height,width,data_from,data_to,sensor_id,type) VALUES (".$dashboard_id.",'".$c['title']."','".$c['description']."',".$c['row'].",".$c['column'].",".$c['height'].",".$c['width'].",'".$c['to']."','".$c['from']."',".$c['sensor_id'].",".$c['type'].")";
                        $result = $conn->query($sqlCharts2);
                    }
                    $msg=$sqlCharts2;
            } else {
                $msg = 0;
            }    
            $conn->close();
            echo($msg);
        } else {
            header("Location: index.php");
        }
    }

    public function remove() {
        if($this->isLogged) {
            session_start();
            $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $user_check = $_SESSION['user_id'];
            $msg="";
            if (isset($_POST['dashboard_id'])) {
                $dashboard_id = $_POST['dashboard_id'];
                $sql = "SELECT * FROM Dashboards WHERE user_id=".$user_check." AND id=".$dashboard_id;
                $result = $conn->query($sql);             
                if ($result->num_rows < 1) {
                    $msg="Nothing to remove".$sql;
                } else {
                  // DELETE CHARTS of the Dashboards
                  $sql = "DELETE FROM Charts WHERE dashboard_id=".$dashboard_id;
                  $result = $conn->query($sql);
                  // DELETE the dashboard
                  $sql = "DELETE FROM Dashboards WHERE id=".$dashboard_id;
                  $result = $conn->query($sql); 
                  $msg = "El dashboard ha sido eliminado con éxito".$sql;   
                }
            } else {     
                $msg = "Un error ha occurido, imposible de recuperar el numero de dashboards que eliminar...";
            }
            $conn->close();
            echo($msg);
        } else {
            header("Location: index.php");
        }
    }
}