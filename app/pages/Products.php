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

if (isset($_POST['Add-productos'])) { 

    // Validar que los datos requeridos están presentes
    if (isset($_POST['name-product'], $_POST['description-product'], $_POST['product-Type'])) {

        $nombre = $_POST['name-product'];
        $descripcion = $_POST['description-product'];
        $tipoProducto = $_POST['product-Type'];
        $imagen = null;

        // Manejar la subida de imagen si se proporciona
        if (!empty($_FILES['image-product']['name'])) {
            $directorio = "../../uploads/";
            $nombreArchivo = time() . "_" . basename($_FILES["image-product"]["name"]);
            $rutaArchivo = $directorio . $nombreArchivo;

            if (move_uploaded_file($_FILES["image-product"]["tmp_name"], $rutaArchivo)) {
                $imagen = $nombreArchivo;
            }
        }

        // Crear una instancia de Producto y guardarlo en la base de datos
        $producto = new Mueble(null, $nombre, $descripcion, $imagen,$tipoProducto, null, $persona->getIdPersona());

        $productoGuardado = $producto->guardar();

        if ($producto) {
            if (isset($_POST['properties']) && is_array($_POST['properties'])) {
                foreach ($_POST['properties'] as $propiedad) {
                    if (!empty($propiedad['name']) && !empty($propiedad['value'])) {
                        $propiedadMueble = new MueblePropiedad($propiedad['value'], $producto, new Propiedad($propiedad['name']));
                        $propiedadMueble->guardar();
                    }
                }
            }
        }

        if (isset($_POST['cantidadPost'], $_POST['cantidadPre'], $_POST['precio'], $_POST['ganancia'], $_POST['precioFinal'], $_POST['proveedor'])) {
            $cantidadPosts = $_POST['cantidadPost'];
            $cantidadPres = $_POST['cantidadPre'];
            $precios = $_POST['precio'];
            $ganancias = $_POST['ganancia'];
            $preciosFinales = $_POST['precioFinal'];
            $proveedores = $_POST['proveedor'];

            foreach ($proveedores as $index => $proveedorId) {
                if ($proveedorId != '-1') {
                    $cantidadPost = $cantidadPosts[$index];
                    $cantidadPre = $cantidadPres[$index];
                    $precio = $precios[$index];
                    $ganancia = $ganancias[$index];
                    $precioFinal = $preciosFinales[$index];

                    $proveedorProducto = new PedidoProveedor($cantidadPost, $cantidadPre, $precio, $ganancia, $precioFinal, 
                    new Proveedor($proveedorId) ,$producto);
                    $proveedorProducto->guardar();
                }
            }
        }
    }
}else if(isset($_POST['Add-propiedades'])){
    if(isset($_POST['description-property'], $_POST['product-Type2'])){
        $descripcion = $_POST['description-property'];
        $tipoProducto = $_POST['product-Type2'];

        $newPropiedad = new Propiedad(null, $descripcion, $tipoProducto);
        $newPropiedad->guardar();
    }
}else if (isset($_POST['Add-tipos'])){
    if(isset($_POST['name-type'])){
        $newTipo = new Tipo(null, $_POST['name-type']);
        $newTipo->guardar();
    }
}
?>

<body id="body-pd">
    <?php
    include("components/Menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4>Productos</h4>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="productos">Productos</button>
            </div>
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="propiedades">Propiedades</button>
            </div>
            <br>
            <div class="col-1">
                <button type="button" class="btn btn-outline-primary" data-value="tipos">Tipos</button>
            </div>
        </div>


        <div class="row mt-2">
            <div class="container">
                <div class="input-group mb-3 mt-3">
                    <input type="text" class="form-control" id="search" placeholder="Buscar" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn btn-success" type="button" id="button-addon"><span class="material-symbols-rounded">filter_alt</span></button>
                    <button class="btn btn btn-primary" type="button" id="button-addon2"><span class="material-symbols-rounded">add</span></button>
                </div>
                <div class="container" id="data-component">
                </div>
            </div>
        </div>

        <script src="js/home.js"></script>
        <script>
            $(document).ready(function() {
                function cargarProductos(pagina = 1, filtro = '', tipo = 'productos') {
                    $.ajax({
                        url: 'indexServer.php',
                        type: 'GET',
                        data: {
                            pid: '<?= base64_encode("ajax/tablaProductoAjax.php") ?>',
                            pagina: pagina,
                            filtro: filtro,
                            tipo: tipo // Pasamos el tipo como parámetro
                        },
                        success: function(response) {
                            $('#data-component').html(response);
                        }
                    });
                }

                // Cargar clientes por defecto al cargar la página
                cargarProductos(1, '<?php echo $_GET['filtro'] ?? ""; ?>', 'productos');

                // Manejo del evento click en los botones
                $('button[data-value]').on('click', function() {
                    let tipo = $(this).data('value');
                    $('button[data-value]').removeClass('active');
                    $(this).addClass('active');
                    cargarProductos(1, $('#search').val(), tipo);
                });

                // Búsqueda en tiempo real
                $('#search').keyup(function() {
                    const filtro = $(this).val();
                    if (filtro.length >= 3 || filtro.length == 0) {
                        let tipo = $('button[data-value].active').data('value') || 'productos'; // Obtener el tipo seleccionado
                        cargarProductos(1, filtro, tipo);
                    }
                });

                // Manejo de la paginación
                $(document).on('click', '.page-link', function(e) {
                    e.preventDefault();
                    let pagina = $(this).data('pagina');
                    const filtro = $('#search').val();
                    let tipo = $('button[data-value].active').data('value') || 'productos';

                    if (!$(this).parent().hasClass('disabled')) {
                        cargarProductos(pagina, filtro, tipo);
                    }
                });

                // Manejo del botón agregar
                $('#button-addon2').on('click', function() {
                    console.log("Clicked");
                    let tipo = $('button[data-value].active').data('value') || 'productos';
                    let url = 'indexServer.php?pid=<?= base64_encode("ajax/formularioAgregar.php") ?>&tipo=' + tipo;
                    $('#data-component').load(url);
                });
            });
        </script>
</body>