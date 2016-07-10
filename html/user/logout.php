 <?php
include("../etc/session.php");
 if($isLogged) {
    session_start();
    unset($_SESSION['user_id']);
    unset($_SESSION["email"]);
    if(session_destroy()) {
        header("Location: ../index.php");
    }
} else {
    header("Location: ../index.php");
}