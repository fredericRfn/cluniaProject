<?php
include("../etc/config.php");
session_start();
$msg = "";
$conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if (!empty($_POST['first_name']) and strlen($_POST['first_name'])>0) {
    $fn_param = $_POST['first_name'];
} else {
    $msg = "Location: signup.php?error=Faltan datos";
}

if (!empty($_POST['last_name']) and strlen($_POST['last_name'])>0) {
    $ln_param = $_POST['last_name'];
} else {
    $msg = "Location: signup.php?error=Faltan datos";
}
  
if (!empty($_POST['password-confirm']) and strlen($_POST['password-confirm'])>7) {
    $pwd_confirm = $_POST['password-confirm'];
} else {
    $msg = "Location: signup.php?error=Problema con las contraseñas";
}

if (!empty($_POST['password']) and strlen($_POST['password'])>7 ) {
    $pwd_param = $_POST['password'];
} else {
    $msg = "Location: signup.php?error=Una contraseña de al menos 8 carácteres es requerida";
}

if (!empty($_POST['email']) and strlen($_POST['email'])>0) {
    $email_param = $_POST['email']; 
} else {
    $msg = "Location: signup.php?error=Un correo electrónico es requerido";
}
if (!empty($_POST['entity'])) {
    $entity_param = $_POST['entity'];
} else {
    $entity_param = "";
}

if ($msg == "") {
    $sql1 = "SELECT * FROM Users WHERE email = '$email_param'";

    if ($pwd_param!=$pwd_confirm) {
        $msg="Location: signup.php?error=Las contraseñas no correponden";
    }
    if (!filter_var($email_param,  FILTER_VALIDATE_EMAIL)) {
        $msg="Location: signup.php?error=El correo electrónico es inválido";
    }

    if ($msg == "") {
        $result = $conn->query($sql1);
        if ($result->num_rows > 0) {
            $msg = "Location: signup.php?error=Este correo electrónico ya está utilizado por alguien";
        } else {
            $sql = "INSERT INTO Users(first_name, last_name, password, email, entity, role) VALUES ('$fn_param', '$ln_param', '$pwd_param','$email_param','$entity_param',0)";
            $result = $conn->query($sql);
            $msg = "Location: signin.php?status=Cuenta creada con éxito";
        }
    }
}

header($msg);
$conn->close();