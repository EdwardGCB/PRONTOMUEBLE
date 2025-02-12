<?php
$tipoAgregacion = isset($_GET['tipo']) ? $_GET['tipo'] : ''; // Obtener el tipo desde GET
$tipo = new Tipo();
$tipos = $tipo->consultarTodos();

$campos = '';

if ($tipoAgregacion == 'productos') {
    $campos = "
        <div class='row'>
            <div class='col-6'>
                <div class='mb-3'>
                    <label for='name-product' class='form-label'>* Nombre del producto</label>
                    <input type='text' class='form-control' name='name-product' required>
                </div>
            </div>
            <div class='col-6'>
                <div class='mb-3'>
                    <label for='image-product' class='form-label'>Imagen del producto</label>
                    <input type='file' class='form-control' name='image-product'>
                </div>
            </div>
        </div>
        <div class='mb-3'>
            <label for='description-product' class='form-label'>* Descripción del producto</label>
            <input type='text' class='form-control' name='description-product' required>
        </div>
        <div class='mb-3'>
            <label for='product-Type' class='form-label'>* Tipo de producto</label>
            <select class='form-select' name='product-Type' required>
                <option value='-1'>Seleccione...</option>";
    foreach ($tipos as $tipoActual) {
        $campos .= '<option value=' . $tipoActual->getIdTipo() . '>' . $tipoActual->getNombre() . '</option>';
    }
    $campos .= "
            </select>
        </div>
        <div class='mb-3' id='extra-properties-container-1'></div>

        <!-- Sección de proveedor -->
        <h5>Proveedor</h5>
        <div id='proveedor-container'>
            <div class='proveedor-section' id='proveedor-principal'>
                <div class='row'>
                    <div class='col-4'>
                        <div class='mb-3'>
                            <label for='cantidadPost' class='form-label'>* Cantidad Post</label>
                            <input type='number' class='form-control' name='cantidadPost[]' required>
                        </div>
                    </div>
                    <div class='col-4'>
                        <div class='mb-3'>
                            <label for='cantidadPre' class='form-label'>* Cantidad Pre</label>
                            <input type='number' class='form-control' name='cantidadPre[]' required>
                        </div>
                    </div>
                    <div class='col-4'>
                        <div class='mb-3'>
                            <label for='precio' class='form-label'>* Precio</label>
                            <input type='number' step='0.01' class='form-control precio' name='precio[]' required>
                        </div>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-6'>
                        <div class='mb-3'>
                            <label for='ganancia' class='form-label'>% Ganancia</label>
                            <input type='number' step='0.01' class='form-control ganancia' name='ganancia[]' required>
                        </div>
                    </div>
                    <div class='col-6'>
                        <div class='mb-3'>
                            <label for='precioFinal' class='form-label'>Precio Final</label>
                            <input type='number' step='0.01' class='form-control precioFinal' name='precioFinal[]' readonly>
                        </div>
                    </div>
                </div>
                <div class='mb-3'>
                    <label for='proveedor' class='form-label'>* Proveedor</label>
                    <select class='form-select' name='proveedor[]' required>
                        <option value='-1'>Seleccione...</option>";
    $proveedor = new Proveedor();
    $proveedores = $proveedor->consultarTodos();
    foreach ($proveedores as $proveedorActual) {
        $campos .= '<option value=' . $proveedorActual->getIdProveedor() . '>' . $proveedorActual->getRazonSocial() . '</option>';
    }
    $campos .= "
                    </select>
                </div>
            </div>
        </div>
        <button type='button' class='btn btn-primary mb-3' id='add-proveedor'>Agregar un proveedor</button>
    ";
} else if ($tipoAgregacion == 'propiedades') {
    $campos = "
        <div class='row'>
            <!-- description product -->
            <div class='mb-3'>
                <label for='description-property' class='form-label'>* Descripcion de la propiedad</label>
                <input type='text' class='form-control' name='description-property' aria-describedby='emailHelp' required>
            </div>
            <div class='mb-3'>
                <label for='product-Type2' class='form-label'>* Tipo</label>
                <select class='form-select' name='product-Type2' aria-label='Default select example' required>
                    <option value='-1'>Seleccione...</option>
                ";
    foreach ($tipos as $tipoActual) {
        $campos .= '<option value=' . $tipoActual->getIdTipo() . '>' . $tipoActual->getNombre() . '</option>';
    }
    $campos .= "
                </select>
            </div>
        </div>
    ";
} else if ($tipoAgregacion == 'tipos') {
    $campos = "
        <div class='mb-3'>
            <label for='name-type' class='form-label'>* Nombre del tipo</label>
            <input type='text' class='form-control' name='name-type' aria-describedby='emailHelp' required>
        </div>
    ";
}

?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agregar <?= $tipoAgregacion ?></h5>
        <form id="add-product-form" method="post" action="?pid=<?= base64_encode("pages/Products.php") ?>" enctype="multipart/form-data">
            <div id="dynamic-fields">
                <?= $campos ?>
            </div>
            <button type="button" class="btn btn-danger" id="cancel-button">Cancelar</button>
            <button type="submit" class="btn btn-success" name="Add-<?= $tipoAgregacion ?>">Agregar</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Cargar propiedades adicionales al seleccionar un tipo de producto
        $('select[name="product-Type"]').on('change', function() {
            let selectedOption = $(this).val();

            $.ajax({
                url: 'indexServer.php',
                type: 'GET',
                data: {
                    pid: '<?= base64_encode("ajax/propiedadProductoAjax.php") ?>',
                    idTipo: selectedOption
                },
                success: function(response) {
                    $('#extra-properties-container-1').html(response);
                }
            });
        });

        // Manejo del botón de cancelar
        $('#cancel-button').on('click', function() {
            $.ajax({
                url: 'indexServer.php',
                type: 'GET',
                data: {
                    pid: '<?= base64_encode("ajax/tablaProductoAjax.php") ?>',
                    tipo: 'productos',
                    filtro: ''
                },
                success: function(response) {
                    $('#data-component').html(response);
                }
            });
        });

        //Modulo para agregar un nuevo proveedor en el producto
        $('#add-proveedor').on('click', function() {
            let nuevoProveedor = $('#proveedor-principal').clone();
            nuevoProveedor.removeAttr('id');
            nuevoProveedor.find('input').val('');
            nuevoProveedor.append('<button type="button" class="btn btn-danger remove-proveedor mb-3">Eliminar</button>');
            $('#proveedor-container').append(nuevoProveedor);
        });

        $(document).on('click', '.remove-proveedor', function() {
            $(this).closest('.proveedor-section').remove();
        });

        function actualizarPrecioFinal(elemento) {
            let precio = parseFloat($(elemento).closest('.proveedor-section').find('.precio').val()) || 0;
            let ganancia = parseFloat($(elemento).closest('.proveedor-section').find('.ganancia').val()) || 0;
            let precioFinal = precio + (precio * (ganancia / 100));
            $(elemento).closest('.proveedor-section').find('.precioFinal').val(precioFinal.toFixed(2));
        }

        $(document).on('input', '.precio, .ganancia', function() {
            actualizarPrecioFinal(this);
        });
    });
</script>