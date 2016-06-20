<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/global.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <title>Clunia Viewer</title>
</head>
<body>
<div class="container">
    <?php
           include('header.php');
    ?>
    <div class="row" id="login">
	<div class="logform" id="signup-form">
        <h1> Registrarse </h1>
        <form role="form" action = "register.php" method = "POST">
          <div class="form-group">
            <label>Nombre de usuario*</label>
            <input type ="text" class ="form-control" name="username">
          </div>
          <div class="form-group">
            <label>Correo electrónico*</label>
            <input type ="email" class ="form-control" name="email">
          </div>
          <div class="form-group">
            <label>Entidad</label>
            <input type ="text" class ="form-control" name="entity">
          </div>
          <div class="form-group">
            <label>Contraseña*</label>
            <input type ="password" class="form-control" name="password">
          </div>
          <div class="form-group">
            <label>Confirmación de contraseña*</label>
            <input type ="password" class="form-control" name="password-confirm">
          </div>
          <div class = "checkbox">
             <label><input type ="checkbox" name="role" value="1">Soy un investigador de la universidad</label>
          </div>
          <button type="submit" class="btn btn-default">Registrarse</button>
        </form>

        <p>*Los datos que provees no son colectados por fines lucrativos y no serán comunicados a entidades terceras.</p>
        <p>Si has indicado que eres un investigador de la Universidad de Zaragoza, tienes que dar tu correo electrónico de la Universidad. Eso te permitirá tener una libertad total sobre las visualisaciones que creas. Si los datos son erróneos, no podrás aceder a todas las funcionalidades del sitio.</p>
        </div>
    </div>
</div>
</body>
</html>
