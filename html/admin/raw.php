<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "raw.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}