<?php
if (isset($_POST['cantidad'], $_POST['idMueble'], $_POST['idProveedor'], $_POST['asesor'], $_POST['cliente'])) {
    $cantidad = $_POST['cantidad'];
    $idMueble = $_POST['idMueble'];
    $idProveedor = $_POST['idProveedor'];
    $vendedor = $_POST['asesor'];
    $cliente = $_POST['cliente'];

    $cotizacion = new Cotizacion($cantidad, new Cliente($cliente), new Vendedor($vendedor), new Mueble($idMueble), new Proveedor($idProveedor));
    $cotizacion->guardar();
    echo json_encode([
        "success" => true,
        "cantidad" => $cantidad,
        "idMueble" => $idMueble,
        "idProveedor" => $idProveedor,
        "asesor" => $vendedor,
        "cliente" => $cliente
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Faltan datos en la solicitud"]);
}
