<?php
    include('config.php');
    session_start();
    $user_check = $_SESSION['user_id'];
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
    $sql = "SELECT id FROM Users WHERE id = '$user_check' ";
    $result = $conn->query($sql);
    if ($result->num_rows == 0) {
        session_destroy();
        header('Location: index.php');
    } else {
	include('header_modifier.php');
    }
    $conn->close();
?>
