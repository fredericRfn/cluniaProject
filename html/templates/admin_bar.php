<div class="row admin-bar">
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-admin" type="button" id="menu1" data-toggle="dropdown">Configuration
            <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="../admin/connections.php">Connections</a></li>
            <li><a href="../admin/importation.php">Importation</a></li>
            <li><a href="../admin/backup.php">Backup</a></li>
            <li><a href="../admin/security.php">Security</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-admin" type="button" data-toggle="dropdown">Monitoring
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li><a href="../admin/data.php?t=events">Events</a></li>
            <li><a href="../admin/data.php?t=triggers">Triggers</a></li>
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-default dropdown-toggle btn-admin" type="button" id="menu3" data-toggle="dropdown">Data
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            <li class="dropdown-header">Measurements</li>
            <li><a href="../admin/data.php?t=dataloggers">Dataloggers</a></li>
            <li><a href="../admin/data.php?t=sensors">Sensors</a></li>
            <li><a href="../admin/data_global.php">Show All Data</a></li>
            <li class="dropdown-header">User Activity</li>
            <li><a href="../admin/data.php?t=users">Users</a></li>
            <li><a href="../admin/data.php?t=dashboards">Dashboards</a></li>
            <li><a href="../admin/data.php?t=charts">Charts</a></li>
        </ul>
    </div>
    <a class="btn btn-default btn-admin" href='../admin/data.php?t=chartTypes'>Chart Types</a>
    <a class="btn btn-default btn-admin" href='../user/dashboard_editor.php'>Dashboard editor</a>
</div>