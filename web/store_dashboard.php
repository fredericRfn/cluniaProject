<?php
    include("dao.php");
    include("config.php");

    session_start();
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user_check = $_SESSION['user_id'];
    $sql = "SELECT id FROM Users WHERE id =".$user_check;
    $result = $conn->query($sql);
    $msg="";
    if ($result->num_rows > 0) {
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
    } else {
         $msg = 0;
    }    
    $conn->close();
    echo($msg);
?>
