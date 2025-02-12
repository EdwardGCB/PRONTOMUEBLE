<?php
session_start();
if (isset($_GET["CerrarSesion"])) {
    session_destroy();
}

require("logic/Persona.php");
require("logic/Administrador.php");
require("logic/Cliente.php");
require("logic/vendedor.php");
require("logic/Tipo.php");
require("logic/Mueble.php");
require("logic/PedidoProveedor.php");
require("logic/Telefono.php");
require("logic/Cotizacion.php");
require("logic/MueblePropiedad.php");
require("logic/Propiedad.php");
require("logic/Factura.php");
require("logic/DetalleFactura.php");
$pagesWithOutSession = array(
    "pages/LoginPage.php"
);

$pagesWithSession = array(
    "pages/Home.php",
    "pages/Users.php",
    "pages/Products.php"
);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontomueble</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="client/css/style.css">
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>

    <?php
    if (!isset($_GET["pid"])) {
        include("pages/LoginPage.php");
    } else {
        $pid = base64_decode($_GET["pid"]);
        if (in_array($pid, $pagesWithOutSession)) {
            include($pid);
        } else if (in_array($pid, $pagesWithSession)) {
            if (isset($_SESSION["id"])) {
                include($pid);
            } else {
                include("pages/LoginPage.php");
            }
        } else {
            echo "<h1>Error 404</h1>";
        }
    }
    ?>

</body>

</html>