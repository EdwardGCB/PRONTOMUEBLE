<?php
$tipoAgregacion = isset($_GET['tipo']) ? $_GET['tipo'] : ''; // Obtener el tipo desde GET
$tipo = new Tipo();
$tipos = $tipo->consultarTodos();

$campos = '';

if ($tipoAgregacion == 'productos') {
    $campos = "
        <div class='row'>
            <div class='col-6'>
                <!-- name product -->
                <div class='mb-3'>
                    <label for='name-product' class='form-label'>* Nombre del producto</label>
                    <input type='text' class='form-control' name='name-product' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-6'>
                <!-- image product-->
                <div class='mb-3'>
                    <label for='image-product' class='form-label'>Imagen del producto</label>
                    <input type='file' class='form-control' name='image-product' aria-describedby='emailHelp'>
                </div>
            </div>
        </div>
        <!-- description product -->
        <div class='mb-3'>
            <label for='description-product' class='form-label'>* Descripcion del producto</label>
            <input type='text' class='form-control' name='description-product' aria-describedby='emailHelp' required>
        </div>
        <div class='mb-3'>
            <label for='product-Type' class='form-label'>* Tipo de producto</label>
            <select class='form-select' name='product-Type' aria-label='Default select example' required>
                <option value='-1'>Seleccione...</option>
                ";
    foreach ($tipos as $tipoActual) {
        $campos .= '<option value=' . $tipoActual->getIdTipo() . '>' . $tipoActual->getNombre() . '</option>';
    }
    $campos .= "
            </select>
        </div>
        <div class='mb-3' id='extra-properties-container-1'></div>
    ";
}else if($tipoAgregacion == 'propiedades'){
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
}else if($tipoAgregacion == 'tipos'){
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
            <button type="submit" class="btn btn-success" name="Add-<?=$tipoAgregacion?>">Agregar</button>
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
    });
</script>