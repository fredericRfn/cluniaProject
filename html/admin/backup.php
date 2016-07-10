<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "backup.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}