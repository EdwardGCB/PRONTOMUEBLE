<?php
$items = array();
if(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];
    if($tipo == "clientes"){
        $cliente = new Cliente(null, $_GET['filtro']);
        $arreglo = $cliente->consultarPorNombre();
    }
}

// Definir cantidad de eventos por página
$itemsPorPagina = 10;
$totalItems = count($items);
$paginas = ceil($totalItems / $itemsPorPagina);

// Obtener la página actual
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$paginaActual = max(1, min($paginaActual, $paginas));

// Obtener eventos de la página actual
$inicio = ($paginaActual - 1) * $itemsPorPagina;
$clientesPagina = array_slice($items, $inicio, $itemsPorPagina);
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <?= ($tipo != "proveedores")? "<th>nombre</th>" : "<th>Razon social</th>" ?>
            <?= ($tipo != "proveedores")? "<th>Identificacion</th>" : "<th>Nit</th>" ?>
            <th>Fecha Creacion</th>
            <th>Asesor</th>
            <th>Telefonos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clientesPagina as $clienteActual) { ?>
            <tr>
                <th><?= $clienteActual->getIdPersona() ?></th>
                <th><?= $clienteActual->getNombres() . " " . $clienteActual->getApellidos() ?></th>
                <td><?= $clienteActual->getIdentificacion() ?></td>
                <td><?= $clienteActual->getFecha_ini() ?></td>
                <td><?= $clienteActual->getAsesor()->getIdPersona() . "-" .  $clienteActual->getAsesor()->getNombres() . " " .  $clienteActual->getAsesor()->getApellidos() ?></td>
                <td>
                </td>
                <td>
                    <a href='?pid=<?= base64_encode("paginas/editClient.php") ?>&id=<?= $clienteActual->getIdPersona() ?>' class='btn btn-success' style='color: white;'>
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