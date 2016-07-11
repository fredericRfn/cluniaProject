<div class="row" id="login">
    <div class="logform" id="signup-form">
        <h1> Registrarse </h1>
        <form role="form" action="register.php" method="POST">
            <div class="form-group">
                <label>Nombre*</label>
                <input type="text" class="form-control" name="first_name">
            </div>
            <div class="form-group">
                <label>Apellido(s)*</label>
                <input type="text" class="form-control" name="last_name">
            </div>
            <div class="form-group">
                <label>Correo electrónico*</label>
                <input type="email" class="form-control" name="email">
            </div>
            <div class="form-group">
                <label>Entidad</label>
                <input type="text" class="form-control" name="entity">
            </div>
            <div class="form-group">
                <label>Contraseña*</label>
                <input type="password" class="form-control" name="password">
            </div>
            <div class="form-group">
                <label>Confirmación de contraseña*</label>
                <input type="password" class="form-control" name="password-confirm">
            </div>
            <button type="submit" class="btn btn-default">Registrarse</button>
        </form>

        <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $_GET["error"]; ?></div>

        <p>*Los datos que provees no son colectados por fines lucrativos y no serán comunicados a entidades
            terceras.</p>
    </div>
</div>