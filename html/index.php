<?php
include("etc/config.php");
define('ROLE_USER', 0);
define('ROLE_ADMIN',1);

session_start();
$user_check = $_SESSION['user_id'];
$conn= new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
$sql = "SELECT role FROM Users WHERE id = '$user_check' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $isLogged = true;
} else {
    session_destroy();
    $isLogged = false;
}

if($isLogged) {
    header("Location: user/dashboard_editor.php");
} else {
    header("Location: user/signin.php");
}