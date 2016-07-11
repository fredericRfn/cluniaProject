<div class="row separator">Connections Configuration</div>
<form style="text-align: center" action="../admin/write_configuration.php" method="post">
    <div class="row header-panel">Station</div>
    <div class="row panel">
        <div class="row">
            <label class="admin-lbl">IP</label><input type="text" value="<?php echo STATION_IP ?>" name="ip">
        </div>
        <div class="row">
            <label class="admin-lbl">Port</label><input type="number" name="port" value="<?php echo STATION_PORT ?>">
        </div>
    </div>
    <div class="row header-panel">Database configuration</div>
    <div class="row panel">
        <div class="row">
            <label class="admin-lbl">MySQL Username</label><input type="text" name="username" value="<?php echo DB_USERNAME ?>">
        </div>
        <div class="row">
            <label class="admin-lbl">MySQL Password</label><input type="password" name="password" value="<?php echo DB_PASSWORD ?>">
        </div>
        <div class="row">
            <label class="admin-lbl">MYSQL Server</label><input type="text" name="server" value="<?php echo DB_SERVER ?>">
        </div>
        <div class="row">
            <label class="admin-lbl">MySQL Database</label><input type="text" name="database" value="<?php echo DB_DATABASE ?>">
        </div>
    </div>
    <button type="submit" class="btn btn-default">Aplicar Cambios</button>
</form>