<?php
include("config.php");
session_start();
$conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// username and password sent from form 
$user_param = $_POST['username']; 
$pwd_param = $_POST['password']; 

$sql = "SELECT * FROM Users WHERE username = '$user_param' and password = '$pwd_param'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$_SESSION['user_id'] = $row['id'];
	$_SESSION["username"] = $row['username'];
	echo("Success-id\n");	
	echo($row['id']);
	header("Location: index.php");
} else {
   	header("Location: index.php?error=Invalid credentials");
}
$conn->close();
?>
