<div class="row" id="login">
  <div class="logform" id="signup-form">
        <h1> Registrarse </h1>
        <form role="form" action = "user/register" method = "POST">
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