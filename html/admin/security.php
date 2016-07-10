<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "security.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}