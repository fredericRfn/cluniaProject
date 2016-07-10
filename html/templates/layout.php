<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../assets/js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/global.css" rel="stylesheet">
    <script src="../assets/js/jquery/jquery-1.11.3.js"></script>
    <script src="../assets/js/bootstrap/js/bootstrap.min.js"></script>
    <script src="../assets/js/chart/Chart.min.js"></script>
    <script src="../assets/js/chart/moment.min.js"></script>
    <title>Clunia Viewer</title>
    <?php if ($isLogged) : ?>
        <script src="../assets/js/header_modifier.js"></script>
    <?php endif ?>

</head>
<body>
    <div class="container main">
        <nav class="navbar navbar-default navbar-fixed-top navbar" role="navigation">
            <div class="container-fluid">
                <a class="navbar-brand" style="display:inline-block" href="../index.php">Clunia Viewer</a>
                <div class="navbar-header" style="float:left">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-target">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-target">
                    <ul class = "nav navbar-nav items">
                        <li><a href = "../cms/about.php">Informaciones</a></li>
                        <li><a href = "../cms/contact.php">Contacto</a></li>
                    </ul>
                    <ul class = "nav navbar-nav navbar-right">
                        <li><img style="height:50px;" src="../assets/logoUZ.png"Clunia Viewer></li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container -->
        </nav>
        <?php if ($isAdmin) : ?>
            <?php include("../templates/admin_bar.php"); ?>
        <?php endif ?>
        <?php include("../templates/".$template); ?>

    </div>
</body>