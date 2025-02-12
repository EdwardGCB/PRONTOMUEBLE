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
                        <input type="number" class="form-control" id="identificacion" name="identificacion" aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="col-6">
                    <!-- image product-->
                    <div class="mb-3">
                        <label for="nombre" class="form-label">* Nombre Cliente</label>
                        <input type="text" class="form-control" name="image-product" aria-describedby="emailHelp" id="nombre_cliente" readonly>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <!-- name product -->
                    <div class="mb-3">
                        <label for="email" class="form-label">* Correo</label>
                        <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" id="correo_cliente" readonly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3">
                        <label for="product-Type" class="form-label">* Vendedor</label>
                        <select class="form-select" name="product-Type" aria-label="Default select example" id="vendedor">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
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
                    <select class="form-select" name="product-Type" aria-label="Default select example" id="selectProduct">
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="col-6">
                    <!-- name product -->
                    <div class="mb-3">
                        <label for="name-product" class="form-label">* Tipo Producto</label>
                        <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" id="tipoProducto" readonly>
                    </div>
                </div>
            </div>
            <!-- description product -->
            <div class="mb-3">
                <label for="description-product" class="form-label">* Product description</label>
                <input type="text" class="form-control" name="description-product" aria-describedby="emailHelp" readonly >
            </div>
            <div class="col-6">
                <!-- name product -->
                <div class="mb-3">
                    <label for="name-product" class="form-label">* Cantidad</label>
                    <input type="number" class="form-control" name="name-product" aria-describedby="emailHelp" id="cantidadProducto">
                </div>
                <div class="mb-3">
                    <label for="name-product" class="form-label">* Propiedades</label>
                    <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" id="propiedades" readonly>
                </div>
            </div>
            <button type="add-product" class="btn btn-danger">Borrar</button>
            <button type="add-product" class="btn btn-success">Agregar</button>
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
                        dataType: 'jsoN',
                        success: function(response) {
                            if (response.success) {
                                $('#nombre_cliente').val(response.nombres + " " + response.apellidos);
                                $('#correo_cliente').val(response.correo);
                            } else {
                                alert('Cliente no encontrado.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("Error AJAX:", xhr.responseText); // verifica el error exacto

                            alert('Error en la consultaaa.');

                        }
                    });
                }
            }
        });
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
            $('#tipoProducto').val('');
            $('#cantidadProducto').val('');
            $('#correo_cliente').val('');
            $('#selectprodut').val(0);
        });
    });
</script>