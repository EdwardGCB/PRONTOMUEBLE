<?php

header('Content-Type: application/json');

if (isset($_POST["identificacion"])) {
    $identificacion = $_POST["identificacion"];
    $cliente = new Cliente(null, null, null, $identificacion);
    if ($cliente->consultarPorCedula()) {
        echo json_encode([
            "success" => true,
            "nombres" => $cliente->getNombres(),
            "apellidos" => $cliente->getApellidos(),
            "correo" => $cliente->getCorreo()
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Cliente no encontrado"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No se envió identificación"]);
}
?>
