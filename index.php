<?php
    require_once "./config/app.php";
    require_once "./autoload.php";
    require_once "./app/views/inc/session_start.php";

    if(isset($_GET['views'])){
        $url=explode("/",$_GET['views']);
    }
    else{
        $url=["login"];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php require_once "./app/views/inc/head.php";?>
</head>
<body>
    <?php 
        use app\controllers\viewsController;

        $viewsController=new viewsController();
        $view=$viewsController->getViewsController($url[0]);

        if($view=="login" || $view=="404"){
            require_once "./app/views/content/".$view."-view.php";
        }
        else{
            echo '<div class="container">';
            require_once "./app/views/inc/sidebar.php";
            require_once $view;
            echo '</div>';
        }

        require_once "./app/views/inc/script.php";
    ?>
</body>
</html>