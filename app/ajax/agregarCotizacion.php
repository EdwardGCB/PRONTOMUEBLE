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
                <div class="col-5">
                    <div class="mb-3">
                        <label for="identificacion" class="form-label">* Identificacion</label>
                        <input type="number" class="form-control" id="identificacion" name="identificacion" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col-2">
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">ID Cliente</label>
                        <input type="text" class="form-control" id="id_cliente" name="id_cliente" readonly>
                    </div>
                </div>
                <div class="col-5">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">* Nombre Cliente</label>
                        <input type="text" class="form-control" id="nombre_cliente" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="mb-3">
                        <label for="email" class="form-label">* Correo</label>
                        <input type="text" class="form-control" id="correo_cliente" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="mb-3">
                        <label for="id_asesor" class="form-label">ID Asesor</label>
                        <input type="text" class="form-control" id="id_asesor" name="id_asesor" readonly>
                    </div>
                </div>
                <div class="col-5">
                    <div class="mb-3">
                        <label for="asesor" class="form-label">* Asesor</label>
                        <input type="text" class="form-control" id="asesor" readonly>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger" id="borrarCliente">Limpiar</button>
        </div>
        <br>
        <div class="container" id="tablaCotizacionContainer"></div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#identificacion').on('keypress', function(event) {
            if (event.which === 13) {
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
                                $('#nombre_cliente').val(response.nombres + " " + response.apellidos);
                                $('#correo_cliente').val(response.correo);
                                $('#asesor').val(response.asesorId + "-" + response.asesorNombre);
                                $('#id_cliente').val(response.id_cliente);
                                $('#id_asesor').val(response.asesorId);
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

        $('#borrarCliente').on('click', function() {
            $('#identificacion').val('');
            $('#nombre_cliente').val('');
            $('#correo_cliente').val('');
            $('#asesor').val('');
            $('#id_cliente').val('');
            $('#id_asesor').val('');
            $("#tablaCotizacionContainer").html('');
        });

        function cargarTablaCotizacion() {
            const url = "indexServer.php?pid=<?= base64_encode("ajax/tablacotizacionajax.php") ?>";
            $("#tablaCotizacionContainer").load(url);
        }
    });
</script>