<?php
include("../etc/session.php");
if($isLogged) {
    $template = "profile.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}