<?php

header('Content-Type: application/json');

if (isset($_GET['productoId'])) {
    $proveedor = new PedidoProveedor(null, null, null, null, 
    null, null, new Mueble($_GET['productoId']));
    $proveedores = $proveedor->buscarPorIdMueble();

    // Crear un array para almacenar los resultados
    $resultados = [];

    foreach ($proveedores as $proveedor) {
        $resultados[] = [
            "cantidad" => $proveedor->getCantidadPost(),
            "precio" => $proveedor->getPrecioFinal(),
            "proveedor" => [
                "id" => $proveedor->getProveedor()->getIdProveedor(),
                "nombre" => $proveedor->getProveedor()->getRazonSocial(),
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
