<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "overview.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}