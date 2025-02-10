<?php
if ($_SESSION["role"] == "A") {
    $persona = new Administrador($_SESSION["id"]);
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
        <h4>users Main</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="clientes">Clientes</button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="vendedores">Vendedores</button>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="proveedores">Proveedores</button>
            </div>
        </div>
        <div class="container">
            <div class="input-group mb-3 mt-3">
                <input type="text" class="form-control" id="search" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                <button class="btn btn btn-success" type="button" id="button-addon2"><span class="material-symbols-rounded">filter_alt</span></button>
                <button class="btn btn btn-primary" type="button" id="button-addon2"><span class="material-symbols-rounded">add</span></button>
            </div>
            <div class="container" id="datatable">
            </div>
        </div>
    </div>
    <script src="js/home.js"></script>
    <script>
        $(document).ready(function() {
            function cargarClientes(pagina = 1, filtro = '', tipo = 'clientes') {
                $.ajax({
                    url: 'indexServer.php',
                    type: 'GET',
                    data: {
                        pid: '<?= base64_encode("ajax/tablaUsuarios.php") ?>',
                        pagina: pagina,
                        filtro: filtro,
                        tipo: tipo // Pasamos el tipo como parámetro
                    },
                    success: function(response) {
                        $('#datatable').html(response);
                    }
                });
            }

            // Cargar clientes por defecto al cargar la página
            cargarClientes(1, '<?php echo $_GET['filtro'] ?? ""; ?>', 'clientes');

            // Manejo del evento click en los botones
            $('button[data-value]').on('click', function() {
                let tipo = $(this).data('value');
                cargarClientes(1, $('#search').val(), tipo);
            });

            // Búsqueda en tiempo real
            $('#search').keyup(function() {
                const filtro = $(this).val();
                if (filtro.length >= 3 || filtro.length == 0) {
                    let tipo = $('button[data-value].active').data('value') || 'clientes'; // Obtener el tipo seleccionado
                    cargarClientes(1, filtro, tipo);
                }
            });

            // Manejo de la paginación
            $(document).on('click', '.page-link', function(e) {
                e.preventDefault();
                let pagina = $(this).data('pagina');
                const filtro = $('#search').val();
                let tipo = $('button[data-value].active').data('value') || 'clientes';

                if (!$(this).parent().hasClass('disabled')) {
                    cargarClientes(pagina, filtro, tipo);
                }
            });
        });
    </script>
</body>