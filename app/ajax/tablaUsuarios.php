<?php
$items = array();
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
    if ($tipo == "clientes") {
        $cliente = new Cliente(null, $_GET['filtro']);
        $items = $cliente->consultarPorNombre();
    }else if ($tipo == "vendedores"){
        $vendedor = new Vendedor(null, $_GET['filtro']);
        $items = $vendedor->consultarPorNombre();
    }else{
        $proveedor = new Proveedor(null, $_GET['filtro']);
        $items = $proveedor->consultarPorRazonSocial();
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
            <?= ($tipo != "proveedores") ? "<th>nombre</th>" : "<th>Razon social</th>" ?>
            <?= ($tipo != "proveedores") ? "<th>Identificacion</th>" : "<th>Nit</th>" ?>
            <?= ($tipo != "proveedores") ? "<th>Correo</th>" : "<th>Persona Contacto</th>" ?>
            <?= ($tipo == "clientes") ? "<th>Fecha Creacion</th>" : (($tipo == "vendedores") ? "" : "<th>Direccion</th>") ?>
            <?= ($tipo == "clientes") ? "<th>Asesor</th>" : "" ?>
            <th>Telefonos</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($itemsPagina as $itemActual) { ?>
            <tr>
                <th><?= ($tipo != "proveedores") ?  $itemActual->getIdPersona() :  $itemActual->getIdProveedor() ?></th>
                <th><?= ($tipo != "proveedores") ? $itemActual->getNombres() . " " . $itemActual->getApellidos() : $itemActual->getRazonSocial() ?></th>
                <td><?= ($tipo != "proveedores") ? $itemActual->getIdentificacion() : $itemActual->getNit() ?></td>
                <td><?= ($tipo != "proveedores") ? $itemActual->getCorreo() : $itemActual->getPersonaContacto() ?></td>
                <?= ($tipo == "clientes") ? "<td>".$itemActual->getFecha_ini()."</td>" : (($tipo == "vendedores") ? "" : "<td>".$itemActual->getDireccion()."</td>") ?>
                <?php if ($tipo == "clientes") {
                    echo "<td>" . $itemActual->getAsesor()->getIdPersona() . "-" .  $itemActual->getAsesor()->getNombres() . " " .  $itemActual->getAsesor()->getApellidos() . "</td>";
                } else {
                    echo "";
                }  ?>
                <td>
                    <?php 
                    if(count($itemActual->getTelefonos())>0){
                        foreach($itemActual->getTelefonos() as $telefono){
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