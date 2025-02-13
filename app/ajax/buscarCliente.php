<?php

header('Content-Type: application/json');

if (isset($_POST["identificacion"])) {
    $identificacion = $_POST["identificacion"];
    $cliente = new Cliente(null, null, null, $identificacion);
    if($cliente->validarCotizacion()){
        echo json_encode(["success" => false, "message" => "El cliente ya cuenta con una cotizacion"]);
    }else{
        if ($cliente->consultarPorCedula()) {
            echo json_encode([
                "success" => true,
                "id_cliente" => $cliente->getIdPersona(),
                "nombres" => $cliente->getNombres(),
                "apellidos" => $cliente->getApellidos(),
                "correo" => $cliente->getCorreo(),
                "asesorId" => $cliente->getAsesor()->getIdPersona(),
                "asesorNombre" =>  $cliente->getAsesor()->getNombres(),
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Cliente no encontrado"]);
        }
    }
} else {
    echo json_encode(["success" => false, "message" => "No se envió identificación"]);
}
?>
