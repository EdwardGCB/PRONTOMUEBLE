<?php

header('Content-Type: application/json');

if (isset($_GET['searchTerm'])) {
    $mueble = new Mueble(null, $_GET['searchTerm']);
    $muebles = $mueble->buscarPorNombre();

    // Crear un array para almacenar los resultados
    $resultados = [];

    foreach ($muebles as $mueble) {
        $resultados[] = [
            "id" => $mueble->getIdMueble(),
            "nombre" => $mueble->getNombre(),
            "tipo" => $mueble->getTipo()->getNombre(),
            "descripcion" => $mueble->getDescripcio()
        ];
    }

    // Convertir el array a JSON y enviarlo como respuesta
    echo json_encode([
        "success" => true,
        "productos" => $resultados,
    ]);
}else {
    echo json_encode([
        "error" => "No se ha proporcionado un término de búsqueda."
    ]);
}
?>
