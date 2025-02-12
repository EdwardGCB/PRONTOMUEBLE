<?php

header('Content-Type: application/json');

if (isset($_GET['idProducto'])) {
    $proveedor = new PedidoProveedor(cantidadPost: null, , null, null, null, null, new Mueble($_GET['idProducto']));
    $proveedores = $proveedor->buscarPorIdMueble();

    // Crear un array para almacenar los resultados
    $resultados = [];

    foreach ($proveedores as $proveedor) {
        $resultados[] = [
            "cantidad" => $proveedor->getCantidadPost(),
            "precio" => $proveedor->getPrecioFinal(),
            "proveedor" => [
                "id" => $proveedor->getProveedor()->getIdPersona(),
                "nombre" => $proveedor->getProveedor()->getNombres(),
            ]
        ];
    }

    // Convertir el array a JSON y enviarlo como respuesta
    echo json_encode([
        "success" => true,
        "proveedores" => $resultados,
    ]);
}else {
    echo json_encode([
        "error" => "No se ha proporcionado un término de búsqueda."
    ]);
}
?>
