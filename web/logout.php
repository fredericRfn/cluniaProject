<?php
   session_start();
   unset($_SESSION['user_id']);
   unset($_SESSION["username"]);
   
   echo 'You have cleaned session';
   if(session_destroy()) {
      header("Location: index.php");
   }
?>
