<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "triggers.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}