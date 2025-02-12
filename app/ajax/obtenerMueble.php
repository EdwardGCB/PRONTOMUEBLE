
<?php

header('Content-Type: application/json');

if (isset($_POST["idMueble"])) {
    $idMueble = $_POST["idMueble"];
    $mueble = new Mueble($idMueble);
    if ($mueble->consultarPorId()) {
        echo json_encode([
            "success" => true,
            "nombre" => $mueble->getNombre(),
            "tipo" => $mueble->getTipo(),
            "descripcion" => $mueble->getDescripcio()
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Cliente no encontrado"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No se envió identificación"]);
}
?>
