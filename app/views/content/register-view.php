<?php
use app\controllers\userController;

$registroExitoso = false;
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new userController();

    $respuesta = json_decode($controller->registerUserController(), true);

    if ($respuesta['type'] === 'reload' || $respuesta['type'] === 'redirect') {
        $registroExitoso = true;
        header("Location: " . APP_URL . "login/");
        exit;
    }

    $mensaje = $respuesta['text'];
}
?>

<section class="hero is-fullheight" style="background-color: #1e1e2f;">
  <div class="hero-body">
    <div class="container">
      <div class="box" style="max-width: 500px; margin: auto; background-color: #26263a; color: #fff; border-radius: 8px; padding: 30px;">
        <h1 class="title has-text-centered" style="color: #00aaff;">Registro de Usuario</h1>

        <?php if (!empty($mensaje)): ?>
          <div style="margin-bottom: 1rem;" class="notification <?= $registroExitoso ? 'is-success' : 'is-danger' ?>">
              <?= htmlspecialchars($mensaje) ?>
          </div>
        <?php endif; ?>

        <form action="" method="POST" autocomplete="off">
          <div class="field">
            <label class="label" style="color: #ccc;">Nombre</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="text" name="user_first_name" required>
            </div>
          </div>

          <div class="field">
            <label class="label" style="color: #ccc;">Apellido</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="text" name="user_last_name" required>
            </div>
          </div>

          <div class="field">
            <label class="label" style="color: #ccc;">Usuario</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="text" name="user_username" required>
            </div>
          </div>

          <div class="field">
            <label class="label" style="color: #ccc;">Contraseña</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="password" name="user_password_1" required>
            </div>
          </div>

          <div class="field">
            <label class="label" style="color: #ccc;">Repetir Contraseña</label>
            <div class="control">
              <input class="input" style="background-color: #2e2e48; color: #fff;" type="password" name="user_password_2" required>
            </div>
          </div>

          <div class="field mt-4">
            <div class="control">
              <button type="submit" class="button is-link is-fullwidth" style="background-color: #00aaff; border: none;">
                Registrar
              </button>
            </div>
          </div>
        </form>

        <div class="has-text-centered mt-4">
          <a href="<?= APP_URL ?>login/" class="button is-small" style="background-color: #151521; color: #00aaff; border: none;">
            Ya tengo una cuenta
          </a>
        </div>
      </div>
    </div>
  </div>
</section>
