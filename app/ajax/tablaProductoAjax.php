<?php
$producto = new Mueble(null, $_GET['search']);
$pedidoProveedor = new PedidoProveedor();
$productos = $pedidoProveedor->buscarNombreMueble();
$productosPorPagina = $_GET['limit'];
$totalProductos = count($productos);
$paginas = ceil($totalProductos / $productosPorPagina);

// Obtener la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, min($paginaActual, $paginas));

// Obtener eventos de la página actual
$inicio = ($paginaActual - 1) * $eventosPorPagina;
$productosPagina = array_slice($productos, $inicio, $productosPorPagina);
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Proveedores</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($eventosPagina as $eventoActual) { ?>
            <tr>
                <th><?= $eventoActual->getIdEvento() ?></th>
                <td><?= $eventoActual->getNombre() ?></td>
                <td><?= $eventoActual->getFechaEvento() ?><br><?= $eventoActual->getHoraEvento() ?></td>
                <td><?= $eventoActual->getCiudad()->getNombre() ?></td>
                <td><?= $eventoActual->getCategoria()->getNombre() ?></td>
                <td>
                    <a href='?pid=<?= base64_encode("paginas/editEvento.php") ?>&id=<?= $eventoActual->getIdEvento() ?>' class='btn btn-success' style='color: white;'>
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