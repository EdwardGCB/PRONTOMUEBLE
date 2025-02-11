<?php
$tipo = new Tipo();
$tipos = $tipo->consultarTodos();
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agregar <?= $_GET['tipo'] ?></h5>
        <br>
        <div class="alert alert-danger" role="alert">
            * son obligatorios
        </div>
        <form>
            <div class="row">
                <div class="col-6">
                    <!-- name product -->
                    <div class="mb-3">
                        <label for="name-product" class="form-label">* Nombre del producto</label>
                        <input type="text" class="form-control" name="name-product" aria-describedby="emailHelp" required>
                    </div>
                </div>
                <div class="col-6">
                    <!-- image product-->
                    <div class="mb-3">
                        <label for="image-product" class="form-label">Imagen del producto</label>
                        <input type="file" class="form-control" name="image-product" aria-describedby="emailHelp">
                    </div>
                </div>
            </div>
            <!-- description product -->
            <div class="mb-3">
                <label for="description-product" class="form-label">* Descripcion del producto</label>
                <input type="text" class="form-control" name="description-product" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label for="product-Type" class="form-label">* Tipo de producto</label>
                <select class="form-select" name="product-Type" aria-label="Default select example" required>
                    <?php
                    foreach ($tipos as $tipoActual) {
                        echo "<option value=" . $tipoActual->getIdTipo() . ">" . $tipoActual->getNombre() . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3" id="extra-select-container"></div>
            <button type="add-product" class="btn btn-danger">Cancelar</button>
            <button type="add-product" class="btn btn-success">Agregar</button>
        </form>
    </div>
</div>
</div>
<script>
    $(document).on('change', 'select[name="product-Type"]', function() {
        let container = $('#extra-select-container');
        container.empty();

        let newSelect = '<div class="mb-3" id="extra-select">' +
            '<label for="extra-option" class="form-label">Propiedades</label>' +
            '<select class="form-select" name="extra-option">' +
            '<option value="opcion1">Opción 1</option>' +
            '<option value="opcion2">Opción 2</option>' +
            '<option value="opcion3">Opción 3</option>' +
            '</select>' +
            '<button type="button" class="btn btn-info mt-2" id="extra-button">Acción Extra</button>' +
            '</div>';

        container.append(newSelect);
    });
</script>