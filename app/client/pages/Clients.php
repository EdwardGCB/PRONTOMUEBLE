<?php
if ($_SESSION["role"] == "A") {
    $person = new Administrator($_SESSION["id"]);
    $person->consultarPorId();
} else if ($_SESSION["role"] == "S") {
    $person = new Seller($_SESSION["id"]);
    $person->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("client/pages/sinPermiso.php"));
}
?>

<body id="body-pd">
    <?php
    include("client/components/Menu.php");
    ?>
    <!--Container Main-->
    <div class="container mt-4">
        <div class="nav-bar">
            <nav class="navbar navbar-light">
                <div class="row">
                    <div class="col-10">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-outline-success"><span class="material-symbols-rounded">filter_alt</span></button>
                    </div>
                </div>
            </nav>
        </div>
        <div id="table-responsive">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <label class="control control--checkbox">
                                    <input type="checkbox" class="js-check-all">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Identificacion</th>
                            <th scope="col">Fecha Creacion</th>
                            <th scope="col">Vendedor Creo</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php include '<server/ajax/cargar_clientes.php'; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>