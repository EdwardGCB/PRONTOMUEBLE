<?php
$items = array();
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    if ($tipo == "cotizaciones") {
        $cotizacion = new Cotizacion(null, new Cliente(null, $_GET['filtro']));
        $items = $cotizacion->buscarPorNombreCliente();
    }else{
        $factura = new Factura(null,null,null,null,null,null,null,null,new Cliente(null, $_GET['filtro']));
        $items = $factura->buscarPorNombreCliente();
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
            <th>nombre</th>
            <th>Identificacion</th>
            <th>Correo</th>
            <?= ($tipo != "cotizaciones") ? "<th>Fecha Creacion</th>" : "<th>Cantidad Articulos</th>" ?>
            <th>Asesor</th>
            <th>Telefonos</th>
            <?= ($tipo != "cotizaciones")? "<th>Cantidad</th>":""?>
            <?= ($tipo != "cotizaciones")? "<th>Valor Total</th>":""?>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itemsPagina as $itemActual) { ?>
            <tr>
                <th><?= $itemActual->getCliente()->getIdPersona()?></th>
                <th><?= $itemActual->getCliente()->getNombres() . " " . $itemActual->getCliente()->getApellidos() ?></th>
                <td><?= $itemActual->getCliente()->getIdentificacion() ?></td>
                <td><?= $itemActual->getCliente()->getCorreo()?></td>
                <?= ($tipo != "cotizaciones") ? "<td>".$itemActual->getCantidadTotal()."</td>" : "" ?>
                <?= ($tipo != "cotizaciones") ? "<td>".$itemActual->getFechaCreacion()." ". $itemActual->getHoraCreacion()."</td>" : "<td>".$itemActual->getCantidad()."</td>" ?>
                <?= "<td>" . $itemActual->getVendedor()->getIdPersona() . "-" .  $itemActual->getVendedor()->getNombres() . " " .  $itemActual->getvendedor()->getApellidos() . "</td>"?>
                <td>
                    <?php 
                    if(count($itemActual->getCliente()->getTelefonos())>0){
                        foreach($itemActual->getCliente()->getTelefonos() as $telefono){
                            echo $telefono."<br>";
                        }
                    }
                    ?>
                </td>
                <td>
                    <a href='?pid=<?= base64_encode("paginas/editClient.php") ?>&id=<?= ($tipo != "proveedores") ? $itemActual->getIdPersona() : $itemActual->getIdProveedor() ?>' class='btn btn-success' style='color: white;'>
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