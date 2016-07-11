<?php
include("../etc/session.php");
if($isAdmin) {
    if(isset($_POST["ip"]) and isset($_POST["port"]) and isset($_POST["username"]) and isset($_POST["password"]) and isset($_POST["server"]) and isset($_POST["database"]))
    {
        $fp = fopen('../etc/config.php', 'w+');
        fwrite($fp, "<?php\n");
        fwrite($fp, "define('STATION_IP','".$_POST["ip"]."');\n");
        fwrite($fp, "define('STATION_PORT',".$_POST["port"].");\n");
        fwrite($fp, "define('DB_USERNAME','".$_POST["username"]."');\n");
        fwrite($fp, "define('DB_PASSWORD','".$_POST["password"]."');\n");
        fwrite($fp, "define('DB_SERVER','".$_POST["server"]."');\n");
        fwrite($fp, "define('DB_DATABASE','".$_POST["database"]."');\n");
        fclose($fp);
    }
    header("Location: ../index.php");
} else {
     header("Location: ../index.php");
}
$conn->close();