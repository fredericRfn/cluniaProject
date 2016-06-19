<?php
   include("config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $user_param = mysqli_real_escape_string($db,$_POST['username']);
      $pwd_param = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT id FROM Users WHERE username = '$user_param' and password = '$pwd_param'";
      $result = mysqli_query($db,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         session_register("myusername");
         $_SESSION['login_user'] = $user_param;
         header("Location: index.php");
      }else {
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
