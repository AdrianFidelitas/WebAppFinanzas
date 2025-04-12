<section class="hero is-fullheight has-background-dark">
  <div class="hero-body">
    <div class="container">
      <div class="box" style="max-width: 500px; margin: auto;">
        <h1 class="title has-text-centered has-text-white">Registro de Usuario</h1>
        <form class="FormularioAjax" action="<?= APP_URL ?>ajax/userAjax.php" method="POST" data-form="save">
          <input type="hidden" name="modulo_user" value="register">

          <div class="field">
            <label class="label has-text-white">Nombre</label>
            <div class="control">
              <input class="input" type="text" name="user_first_name" required>
            </div>
          </div>

          <div class="field">
            <label class="label has-text-white">Apellido</label>
            <div class="control">
              <input class="input" type="text" name="user_last_name" required>
            </div>
          </div>

          <div class="field">
            <label class="label has-text-white">Usuario</label>
            <div class="control">
              <input class="input" type="text" name="user_username" required>
            </div>
          </div>

          <div class="field">
            <label class="label has-text-white">Correo electrónico</label>
            <div class="control">
              <input class="input" type="email" name="user_email">
            </div>
          </div>

          <div class="field">
            <label class="label has-text-white">Contraseña</label>
            <div class="control">
              <input class="input" type="password" name="user_password_1" required>
            </div>
          </div>

          <div class="field">
            <label class="label has-text-white">Repetir contraseña</label>
            <div class="control">
              <input class="input" type="password" name="user_password_2" required>
            </div>
          </div>

          <div class="field">
            <div class="control">
              <button type="submit" class="button is-link is-fullwidth">Registrar</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
