<div class="row"  id="login">
  <div class="logform" id="login-form">
            <h1> Sign in </h1>
            <form role="form" action = "../user/login.php" method = "POST">
              <div class="form-group">
                <label>Correo Electrónico</label>
                <input type ="text" class ="form-control" name="email">
              </div>
              <div class="form-group">
                <label>Contraseña</label>
                <input type ="password" class="form-control" name="password">
              </div>
              <button type="submit" class="btn btn-default">Entrar</button>
            </form>

            <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $_GET["error"]; ?></div>
            <div style = "font-size:15px; color:#008800; margin-top:10px"><?php echo $_GET["status"]; ?></div>

            <p>¿No tienes cuenta? Create una <a href="../user/signup.php">aquí</a> para disfrutar de todas
         las funcionalidades que proponemos, es gratis y rápido. </p>
        </div>
  </div>
</div>