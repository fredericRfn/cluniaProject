<?php
include("../etc/session.php");
if($isLogged) {
    $sql = "SELECT * FROM Users WHERE id = '$user_check' ";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    $template = "profile.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}