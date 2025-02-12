<?php
$seller = new Vendedor();
$sellers = $seller->consultarTodos();

$mueble = new Mueble();
$muebles = $mueble->consultarTodos();

$campos = '';
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agregar Cotizacion</h5>
        <br>
        <div class="alert alert-danger" role="alert">
            * son obligatorios
        </div>
        <div>
            <div class="row">
                <div class="col-6">
                    <!-- name product -->
                    <div class="mb-3">
                        <label for="identificacion" class="form-label">* Identificacion</label>
                        <input type="number" class="form-control" id="identificacion" name="identificacion"
                            aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col-6">
                    <!-- image product-->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">* Nombre Cliente</label>
                        <input type="text" class="form-control" name="image-product" aria-describedby="emailHelp"
                            id="nombre_cliente" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <!-- name product -->
                    <div class="mb-3">
                        <label for="email" class="form-label">* Correo</label>
                        <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp"
                            id="correo_cliente" readonly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="product-Type" class="form-label">* Vendedor</label>
                        <select class="form-select" name="product-Type" aria-label="Default select example"
                            id="vendedor">
                            <option value='-1'>Seleccione...</option>
                            <?php
                            foreach ($sellers as $selleractual) {
                                $campos .= '<option value=' . $selleractual->getIdPersona() . '>' . $selleractual->getNombres() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <button type="add-product" class="btn btn-danger" id="borrarCliente">Borrar </button>
        </div>
        </br>
        </br>

        <div>
            <div class="row">
                <div class="col-6">
                    <label for="producto" class="form-label">* Seleccione un producto</label>
                    <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" id="producto" readonly>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="product-Type" class="form-label">* Proveedor</label>
                        <select class="form-select" name="product-Type" aria-label="Default select example"
                            id="proveedor">
                            <option value='-1'>Seleccione...</option>
                            <?php
                            foreach ($sellers as $selleractual) {
                                $campos .= '<option value=' . $selleractual->getIdPersona() . '>' . $selleractual->getNombres() . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- description product -->
            <div class="mb-3">
                <label for="description-product" class="form-label">* Product description</label>
                <input type="text" class="form-control" name="description-product" aria-describedby="emailHelp"
                    readonly>
            </div>
            <div class="row">
                <div class="col-6">
                    <label for="producto" class="form-label">* Cantidad</label>
                    <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" id="cantidadProducto" readonly>
                </div>
                <div class="col-6">
                    <label for="producto" class="form-label">* Tipo</label>
                    <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" id="tipoProducto" readonly>
                </div>
            </div>
            <div class="col-6">
                <label for="name-product" class="form-label">* Propiedades</label>
                <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp"
                    id="propiedades" readonly>
            </div>
            </br>
            </br>
            <button type="add-product" class="btn btn-danger" id="borrarProducto">Borrar</button>
            <button type="add-product" class="btn btn-success" id="agregarProducto">Agregar</button>
            </br>
            </br>
            <table class="table table-striped mt-3" id="tablaProductos">
                <thead>
                    <tr>
                        <th>Tipo Producto</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Propiedades</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí se agregarán las filas dinámicamente -->
                </tbody>
            </table>

        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#identificacion').on('keypress', function(event) {
            if (event.which === 13) { // Detecta la tecla Enter (código 13)
                event.preventDefault(); // Evita el envío del formulario si está dentro de uno
                let identificacion = $(this).val().trim();

                if (identificacion.length > 0) {
                    $.ajax({
                        url: 'indexServer.php?pid=<?= base64_encode("ajax/buscarCliente.php") ?>',
                        type: 'POST',
                        data: {
                            identificacion: identificacion
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#nombre_cliente').val(response.nombres + " " + response
                                    .apellidos);
                                $('#correo_cliente').val(response.correo);
                            } else {
                                alert('Cliente no encontrado.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Error AJAX:", xhr
                                .responseText); // verifica el error exacto

                            alert('Error en la consultaaa.');

                        }
                    });
                }
            }
        });
    });

    $(document).ready(function() {

        $('#selectProduct').on('keypress', function(event) {
            if (event.which === 13) { // Detecta la tecla Enter (código 13)
                event.preventDefault(); // Evita el envío del formulario si está dentro de uno
                var idMueble = $(this).val(); // Obtener el ID del mueble seleccionado

                if (idMueble.length > 0) {
                    $.ajax({
                        url: 'indexServer.php?pid=<?= base64_encode("ajax/obtenerMueble.php") ?>', // Archivo que obtiene los datos del mueble
                        type: "POST",
                        data: {
                            idMueble: idMueble
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data.success) {
                                $("#tipoProducto").val(data.tipo);
                                $("input[name='description-product']").val(data.descripcion);
                            } else {
                                alert("Error al obtener los datos del mueble.");
                            }
                        }
                    });
                } else {
                    // Limpiar los inputs si se selecciona "Seleccione..."
                    $("#tipoProducto").val("");
                    $("#propiedades").val("");
                    $("input[name='description-product']").val("");
                }
            }
        });
    });

    // Agregar producto a la tabla
    $("#agregarProducto").click(function(e) {
        e.preventDefault(); // Evita recargar la página

        var tipo = $("#tipoProducto").val();
        var descripcion = $("input[name='description-product']").val();
        var cantidad = $("#cantidadProducto").val();
        var propiedades = $("#propiedades").val();

        if (tipo && descripcion && cantidad && propiedades) {
            var nuevaFila = `
                <tr>
                    <td>${tipo}</td>
                    <td>${descripcion}</td>
                    <td>${cantidad}</td>
                    <td>${propiedades}</td>
                    <td>
                        <button class="btn btn-danger btn-sm borrarFila">Eliminar</button>
                    </td>
                </tr>
            `;
            $("#tablaProductos tbody").append(nuevaFila);

            // Limpiar los inputs después de agregar
            $("#tipoProducto").val("");
            $("input[name='description-product']").val("");
            $("#cantidadProducto").val("");
            $("#propiedades").val("");
        } else {
            alert("Por favor, complete todos los campos.");
        }
    });

    // Eliminar fila de la tabla
    $(document).on("click", ".borrarFila", function() {
        $(this).closest("tr").remove();
    });


    $(document).ready(function() {
        $('#borrarCliente').on('click', function() {
            $('#identificacion').val('');
            $('#nombre_cliente').val('');
            $('#correo_cliente').val('');
            $('#vendedor').val(0);
        });
    });

    $(document).ready(function() {
        $('#borrarProducto').on('click', function() {
            $('#producto').val('');
            $('#tipoProducto').val('');
            $('#cantidadProducto').val('');
            $('#propiedades').val('');

        });
    });
</script>