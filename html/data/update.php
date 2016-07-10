<?php

include("../etc/session.php");
if($isAdmin) {
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if(isset($_POST["table"]) and isset($_POST["column"]) and isset($_POST["id"]) and isset($_POST["value"])) {
        $sql = "UPDATE " . $_POST["table"] . " SET " . $_POST["column"] . "='" . $_POST["value"] . "' WHERE id=" . $_POST["id"];
        $conn->query($sql);
        echo "Success: the query executed was:" . $sql;
    } else {
        echo("Failed to execute the query: " . $sql);
    }
} else {
    header("Location: ../index.php");
}