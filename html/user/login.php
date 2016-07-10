<?php
include("../etc/session.php");
if($isLogged) {
    header("Location: ../index.php");
} else {
    session_start();
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // username and password sent from form 
    $email_param = $_POST['email'];
    $pwd_param = $_POST['password']; 

    $sql = "SELECT * FROM Users WHERE email='".$email_param."' AND password='".$pwd_param."'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['id'];
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        header("Location: signin.php");
    } else {
        header("Location: signin.php?error=Informaciones erróneas");
        echo "error";
    }
    $conn->close();
}