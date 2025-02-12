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
                        <label for="asesor" class="form-label">* Asesor</label>
                        <input type="text" class="form-control" name="asesor" aria-describedby="emailHelp"
                            id="asesor" readonly>
                    </div>
                </div>
            </div>

            <button type="add-product" class="btn btn-danger" id="borrarCliente">Limpiar </button>
        </div>
        </br>

        <div class="container" id="tablaCotizacionContainer"></div>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('#identificacion').on('keypress', function(event) {
            if (event.which === 13) { // Detecta Enter
                event.preventDefault();
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
                                console.log(response);
                                // Asignar valores correctamente
                                $('#nombre_cliente').val(response.nombres + " " + response.apellidos);
                                $('#correo_cliente').val(response.correo);
                                $('#asesor').val(response.asesorId + "-" + response.asesorNombre);

                                // Llamar a la función para cargar la tabla cuando se actualice el asesor
                                cargarTablaCotizacion();
                            } else {
                                alert('Cliente no encontrado.');
                            }
                        },
                        error: function(xhr) {
                            console.error("Error AJAX:", xhr.responseText);
                            alert('Error en la consulta.');
                        }
                    });
                }
            }
        });

        // Función para limpiar los campos del cliente
        $('#borrarCliente').on('click', function() {
            $('#identificacion').val('');
            $('#nombre_cliente').val('');
            $('#correo_cliente').val('');
            $('#asesor').val('');
            $("#tablaCotizacionContainer").html(''); // Limpiar la tabla cuando se borra el cliente
        });

        // Función para cargar la tabla de cotizaciones
        function cargarTablaCotizacion() {
            const url = "indexServer.php?pid=<?= base64_encode("ajax/tablacotizacionajax.php") ?>";
            $("#tablaCotizacionContainer").load(url);

        }
    });
</script>