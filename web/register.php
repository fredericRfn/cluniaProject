<?php
    include("config.php");
    session_start();
    $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    if (!empty($_POST['username'])) {
        $user_param = $_POST['username']; 
    } else {
        header("Location: signup.php?error=Missing parameter");
    }
    if (!empty($_POST['password'])) {
        $pwd_param = $_POST['password'];
    } else {
        header("Location: signup.php?error=Missing parameter");
    }
      
    if (!empty($_POST['password-confirm'])) {
        $pwd_confirm = $_POST['password-confirm'];
    } else {
        header("Location: signup.php?error=Missing parameter");
    }
    if (!empty($_POST['email'])) {
        $email_param = $_POST['email']; 
    } else {
        header("Location: signup.php?error=Missing parameter");
    }
    if (!empty($_POST['entity'])) {
        $entity_param = $_POST['entity'];
    } else {
        $entity_param = "";
    }
    if (!empty($_POST['role'])) {
        $role=0;
    } else {
        $role=1;
    }

    $sql1 = "SELECT * FROM Users WHERE username = '$user_param'";
    $sql2 = "SELECT * FROM Users WHERE email = '$email_param'";

    if ($pwd_param!=$pwd_confirm) {
        header("Location: signup.php?error=Password mismatch");
    }
    if (!filter_var($email_param,  FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Password mismatch");
    }

    $result = $conn->query($sql1);
    if ($result->num_rows > 0) {
        header("Location: signup.php?error=Username already in use");
    }
    $result = $conn->query($sql2);
    if ($result->num_rows > 0) {
        header("Location: signup.php?error=Email already in use");
    } else {
        $sql = "INSERT INTO Users(username, password, email, entity, role) VALUES ('$user_param', '$pwd_param','$email_param','$entity_param',$role)";
        $result = $conn->query($sql);
        header("Location: index.php?status=Cuenta creada con exito");
    }
    $conn->close();
?>
