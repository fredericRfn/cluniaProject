<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "data.php";
    $table = ucfirst($_GET["t"]);
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $sql = "SELECT * FROM ".$table;
    $result = $conn->query($sql);
    $editMode = false;
    $addMode = false;
    if ($table == "Triggers" or $table == "ChartTypes") {
        $addMode = true;
        $editMode = true;
    }
    if ($table == "Sensors" or $table == "Dataloggers") {
        $editMode = true;
    }
    $sql = "describe ".$table;
    $resultFields = $conn->query($sql);
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}