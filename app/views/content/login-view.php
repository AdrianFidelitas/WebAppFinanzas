<?php
use app\controllers\userController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new userController();
    $respuesta = json_decode($controller->loginUserController(), true);

    if ($respuesta['type'] === 'redirect') {
        header("Location: " . $respuesta['url']);
        exit;
    }

    $mensaje = $respuesta['text'];
}
?>

<section class="hero is-fullheight" style="background-color: #1e1e2f;">
  <div class="hero-body">
    <div class="container">
      <div class="box" style="max-width: 400px; margin: auto; background-color: #26263a; border-radius: 8px; padding: 30px;">
        <h1 class="title has-text-centered" style="color: #00aaff;">Iniciar Sesión</h1>

        <?php if (!empty($mensaje)): ?>
          <div class="notification is-danger" style="margin-bottom: 1rem;">
            <?= htmlspecialchars($mensaje) ?>
          </div>
        <?php endif; ?>

        <form action="" method="POST" autocomplete="off">
          <div class="field">
            <label class="label" style="color: #ccc;">Usuario</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="text" name="user_username" required>
            </div>
          </div>

          <div class="field">
            <label class="label" style="color: #ccc;">Contraseña</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="password" name="user_password" required>
            </div>
          </div>

          <div class="field mt-4">
            <div class="control">
              <button type="submit" class="button is-link is-fullwidth" style="background-color: #00aaff; border: none;">
                Ingresar
              </button>
            </div>
          </div>
        </form>

        <div class="has-text-centered mt-4">
          <a href="<?= APP_URL ?>register/" class="button is-small" style="background-color: #151521; color: #00aaff; border: none;">
            ¿No tienes cuenta? Regístrate
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
