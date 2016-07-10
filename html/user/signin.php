<?php
include("../etc/session.php");
if($isLogged) {
    header("Location: ../index.php");
} else {
    $template =  "login_form.php";
    include("../templates/layout.php");
}