<?php
include("../etc/session.php");
if($isLogged) {
    $template =  "dashboard_editor.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}