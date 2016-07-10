<?php
include("../etc/session.php");
if($isLogged) {
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
    header("Location: ../index.php");
}