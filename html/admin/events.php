<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "events.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}