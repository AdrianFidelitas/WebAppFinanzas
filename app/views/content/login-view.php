<section class="hero is-fullheight has-background-dark">
  <div class="hero-body">
    <div class="container">
      <div class="box" style="max-width: 400px; margin: auto;">
        <h1 class="title has-text-centered has-text-white">Iniciar Sesión</h1>
        <form class="FormularioAjax" action="<?= APP_URL ?>ajax/loginAjax.php" method="POST" data-form="login">
          <input type="hidden" name="modulo_user" value="login">

          <div class="field">
            <label class="label has-text-white">Usuario</label>
            <div class="control">
              <input class="input" type="text" name="user_username" required>
            </div>
          </div>

          <div class="field">
            <label class="label has-text-white">Contraseña</label>
            <div class="control">
              <input class="input" type="password" name="user_password" required>
            </div>
          </div>

          <div class="field">
            <div class="control">
              <button type="submit" class="button is-link is-fullwidth">Ingresar</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
