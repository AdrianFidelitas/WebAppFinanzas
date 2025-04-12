if ($_POST['modulo_user'] == "login") {
    require_once "../controllers/userController.php";
    $insLogin = new userController();
    echo $insLogin->loginUserController();
}
