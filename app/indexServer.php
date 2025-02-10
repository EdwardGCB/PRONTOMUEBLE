<?php

require("logic/Persona.php");
require("logic/Administrador.php");
require("logic/Cliente.php");
require("logic/vendedor.php");
require("logic/Mueble.php");
require("logic/PedidoProveedor.php");
require("logic/Telefono.php");
require("logic/Cotizacion.php");
require("logic/MueblePropiedad.php");
require("logic/Propiedad.php");
require("logic/Factura.php");
require("logic/DetalleFactura.php");
$pid = base64_decode($_GET["pid"]);
include($pid);
?>