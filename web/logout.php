<?php
   session_start();
   unset($_SESSION["user"]);
   
   echo 'You have cleaned session';
   if(session_destroy()) {
      header("Location: index.php");
   }
?>
