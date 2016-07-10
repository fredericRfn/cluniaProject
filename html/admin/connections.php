<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "connections.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}