<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "importation.php";
    include("../templates/layout.php");
} else {
    header("Location: ../index.php");
}