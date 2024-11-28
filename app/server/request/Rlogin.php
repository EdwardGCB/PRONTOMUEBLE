<?php
require_once(__DIR__ . '/../logic/Administrator.php');
require_once(__DIR__ . '/../logic/Seller.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    // Autenticar como Administrador
    $person = new Administrator(null, null, null, $email, $password);
    if ($person->autenticar()) {
        $_SESSION["id"] = $person->getIdPerson();
        $_SESSION["role"] = "Administrador";
        header("Location: ../../client/pages/Home.php");
        exit;
    }

    // Autenticar como Vendedor
    $person = new Seller(null, null, null, $email, $password);
    if ($person->autenticar()) {
        $_SESSION["id"] = $person->getIdPerson();
        $_SESSION["role"] = "Vendedor";
        header("Location: ../../client/pages/Home.php");
        exit;
    }

    // Si la autenticación falla
    header("Location: ../../client/pages/Login.php?error=1");
    exit;
} else {
    // Manejo de acceso directo a la página sin enviar el formulario
    header("Location: ../../client/pages/Login.php");
    exit;
}
?>