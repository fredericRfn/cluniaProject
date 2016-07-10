<?php
include("etc/session.php");
if($isLogged) {
    header("Location: user/dashboard_editor.php");
} else {
    header("Location: user/signin.php");
}