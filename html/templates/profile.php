<div class="row separator">Mi cuenta</div>
<div class="row" style="margin-left: auto; margin-right: auto; width: 80%">
        <h1> Mis datos </h1>
        <form role="form" action="../user/edit.php" method="POST">
            <div class="form-group">
                <label>Nombre*</label>
                <input type="text" class="form-control" name="first_name" value="<?php echo $user['first_name']?>">
            </div>
            <div class="form-group">
                <label>Apellido(s)*</label>
                <input type="text" class="form-control" name="last_name" value="<?php echo $user['last_name']?>">
            </div>
            <div class="form-group">
                <label>Correo electrónico*</label>
                <input type="email" class="form-control" name="email" value="<?php echo $user['email']?>">
            </div>
            <div class="form-group">
                <label>Entidad</label>
                <input type="text" class="form-control" name="entity" value="<?php echo $user['entity']?>">
            </div>
            <div class="form-group">
                <label>Contraseña*</label>
                <input type="password" class="form-control" name="password" value="<?php echo $user['password']?>">
            </div>
            <div class="form-group">
                <label>Confirmación de contraseña*</label>
                <input type="password" class="form-control" name="password-confirm" value="<?php echo $user['password']?>">
            </div>
            <button type="submit" class="btn btn-default">Aplicar Cambios</button>
            <button type="button" class="btn btn-default">Borrar cuenta</button>
        </form>

        <div style="font-size:11px; color:#cc0000; margin-top:10px"><?php echo $_GET["error"]; ?></div>

        <p>*Los datos que provees no son colectados por fines lucrativos y no serán comunicados a entidades
            terceras.</p>
    </div>
</div>