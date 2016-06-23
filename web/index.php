<?php
    include('config.php');
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="lib/moment.min.js"></script>
    <script src="lib/Chart.min.js"></script>
    <title>Clunia Viewer</title>
</head>
<body>
    <?php
        include('header.php');
        if(!isset($_SESSION['user_id'])){
            include('signin.php');
        } else {
            $user_check = $_SESSION['user_id'];
            $conn=new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
            $sql = "SELECT id FROM Users WHERE id = '$user_check' ";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                include('home.php');
            } else {
                session_destroy();
                include('signin.php');
            }
        }

    ?>
</body>
</html>
