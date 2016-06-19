<?php
   include('config.php');
   session_start();
   $user_check = $_SESSION['login_user'];
   $ses_sql = mysqli_query($db,"select username from admin where username = '$user_check' ");
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   $login_session = $row['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <title>Clunia Viewer</title>
</head>
<body>
    <div class="container">
    <?php
       include('header.php');
       if(!isset($_SESSION['login_user'])){
          include('signin.php');
       } else {
          include('home.php');
       }
       include('footer.php');
    ?>
    </div>
</body>
</html>
