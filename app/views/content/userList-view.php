<div class="container is-fluid mb-6">
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Lista de usuarios</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <?php
        use app\controllers\userController;

        $insUsuario = new userController();

        // Pasar los parámetros correctos al controlador
        echo $insUsuario->listUserController($url[0]); // Asegúrate de que $url[1] y $url[0] estén definidos correctamente
    ?>
</div>
