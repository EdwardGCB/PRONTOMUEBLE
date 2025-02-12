<?php
if ($_SESSION["role"] == "A") {
    $persona = new Administrador($_SESSION["id"]);
    $persona->consultarPorId();
} else if ($_SESSION["role"] == "S") {
    $persona = new Vendedor($_SESSION["id"]);
    $persona->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("pages/sinPermiso.php"));
}
?>

<body id="body-pd">
    <?php
    include("components/Menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4>Facturacion Main</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="Cotizacion">Cotizacion</button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="Facturas">Facturas</button>
            </div>
        </div>
        <div class="container">
            <div class="input-group mb-3 mt-3">
                <input type="text" class="form-control" id="search" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn btn-success" type="button" id="button-addon2"><span class="material-symbols-rounded">filter_alt</span></button>
                <button class="btn btn btn-primary" type="button" id="add"><span class="material-symbols-rounded">add</span></button>
            </div>
            <div class="container" id="container">
                <div id="datatable">

                </div>
            </div>

        </div>
    </div>
    <script src="js/home.js"></script>}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js">
    </script>
    <script>
        $(document).ready(function() {

            //Agregar Cotizacion
            $('#add').click(function() {
                console.log('click');
                url = "indexServer.php?pid=<?= base64_encode("ajax/agregarCotizacion.php"); ?>";
                console.log(url);
                $("#container").load(url);
            });
        });



    </script>
</body>