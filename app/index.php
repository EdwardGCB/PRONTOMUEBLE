<?php
session_start();
if (isset($_GET["CerrarSesion"])) {
    session_destroy();
}

require("server/logic/Person.php");
require("server/logic/Administrator.php");
//require("server/logic/Client.php");
//require("server/logic/Phone.php");
//require("server/logic/Pre-Sale.php");
//require("server/logic/Product.php");
//require("server/logic/ProductProperty.php");
//require("server/logic/ProductSupplier.php");
//require("server/logic/Property.php");
//require("server/logic/Sale.php");
//require("server/logic/SaleDetail.php");
//require("server/logic/Seller.php");

$paginasSinSesion = array(
    "client/pages/LoginPage.php"
);

$paginasConSesion = array();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prontomueble</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="client/css/style.css">
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
    </script>
</head>

<body>

    <?php
    if (!isset($_GET["pid"])) {
        include("client/pages/LoginPage.php");
    } else {
        $pid = base64_decode($_GET["pid"]);
        if (in_array($pid, $paginasSinSesion)) {
            include($pid);
        } else if (in_array($pid, $paginasConSesion)) {
            if (isset($_SESSION["id"])) {
                include($pid);
            } else {
                include("client/pages/LoginPage.php");
            }
        } else {
            echo "<h1>Error 404</h1>";
        }
    }
    ?>

</body>

</html>