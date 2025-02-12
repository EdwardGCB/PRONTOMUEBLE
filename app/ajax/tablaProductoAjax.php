<?php

$items = array();
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    if ($tipo == "productos") {
        $producto = new Mueble(null, $_GET['filtro']);
        $pedidoProveedor = new PedidoProveedor(null, null, null, null, null, null, $producto);
        $items = $pedidoProveedor->buscarNombreMueble();
    } else if ($tipo == "propiedades") {
        $propiedad = new Propiedad(null, $_GET['filtro']);
        $items = $propiedad->consultarPorNombre();
    } else {
        $tipo = new Tipo(null, $_GET['filtro']);
        $items = $tipo->consultarPorNombre();
    }
}

// Definir cantidad de eventos por página
$itemsPorPagina = 9;
$totalItems = count($items);
$paginas = ceil($totalItems / $itemsPorPagina);

// Obtener la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, min($paginaActual, $paginas));

// Obtener eventos de la página actual
$inicio = ($paginaActual - 1) * $itemsPorPagina;
$itemsPagina = array_slice($items, $inicio, $itemsPorPagina);
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th><?= ($tipo == "productos" || $tipo =="propiedades") ? "Tipo" : "" ?></th>
            <?= ($tipo == "productos") ? "<th>Cantidad Pre</th>" : "" ?>
            <?= ($tipo == "productos") ? "<th>Cantidad Post</th>" : "" ?>
            <?= ($tipo == "productos") ? "<th>Precio</th>" : "" ?>
            <?= ($tipo == "productos") ? "<th>Ganancia</th>" : "" ?>
            <?= ($tipo == "productos") ? "<th>Precion Final</th>" : "" ?>
            <?= ($tipo == "productos") ? "<th>Proveedores</th>" : "" ?>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itemsPagina as $itemActual) { ?>
            <tr>
                <td><?= ($tipo == "productos") ? $itemActual->getIdMueble() : (($tipo == "propiedades") ? $itemActual->getIdPropiedad() : $itemActual->getIdTipo()) ?></td>
                <td><?= ($tipo == "productos") ? $itemActual->getMueble()->getNombre() : $itemActual->getNombre() ?></td>
                <td><?= ($tipo == "productos" || $tipo =="propiedades") ? $itemActual->getTipo()->getNombre() : "" ?></td>
                <?= ($tipo == "productos") ? "<td>" . $itemActual->getCantidadPre() . "</td>" : "" ?>
                <?= ($tipo == "productos") ? "<td>" . $itemActual->getCantidadPost() . "</td>" : "" ?>
                <?= ($tipo == "productos") ? "<td>" . $itemActual->getPrecio() . "</td>" : "" ?>
                <?= ($tipo == "productos") ? "<td>" . $itemActual->getGanancias() . "</td>" : "" ?>
                <?= ($tipo == "productos") ? "<td>" . $itemActual->getPrecioFinal() . "</td>" : "" ?>
                <?= ($tipo == "productos") ? "<td>Proveedores</td>" : "" ?>
                <td>
                    <a href='?pid=<?= base64_encode("paginas/editEvento.php") ?>&id=<?= ($tipo == "productos") ? $itemActual->getIdMueble() : (($tipo == "propiedades") ? $itemActual->getIdPropiedad() : $itemActual->getIdTipo()) ?>' class='btn btn-success' style='color: white;'>
                        <span class='material-symbols-rounded'>edit</span>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-end">
        <li class="page-item <?= ($paginaActual <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="#" data-pagina="<?= $paginaActual - 1; ?>">&laquo;</a>
        </li>

        <?php for ($i = 1; $i <= $paginas; $i++) { ?>
            <li class="page-item <?= ($paginaActual == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="#" data-pagina="<?= $i; ?>"><?= $i; ?></a>
            </li>
        <?php } ?>

        <li class="page-item <?= ($paginaActual >= $paginas) ? 'disabled' : ''; ?>">
            <a class="page-link" href="#" data-pagina="<?= $paginaActual + 1; ?>">&raquo;</a>
        </li>
    </ul>
</nav>