<?php
include("../etc/session.php");
if ($isAdmin) {
    $template = "chart_types.php";
    include("../templates/chart.php");
} else {
    header("Location: ../index.php");
}