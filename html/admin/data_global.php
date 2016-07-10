<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "big_data.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}