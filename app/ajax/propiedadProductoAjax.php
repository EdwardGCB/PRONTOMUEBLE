<?php
if (isset($_GET['idTipo']) && !empty($_GET['idTipo'])) {
    $idTipo = $_GET['idTipo'];
    $propiedad = new Propiedad(null, null, new Tipo($idTipo));
    $propiedades = $propiedad->consultarPorTipo();
?>

    <div class="row mt-2">
        <div class="col-6">
            <div class="mb-3">
                <label for="product-Type" class="form-label">* Tipo de producto</label>
                <select class="form-select" name="properties[0][name]" required>
                    <option value="-1">Seleccione...</option>
                    <?php
                    foreach ($propiedades as $propiedadActual) {
                        echo "<option value='" . $propiedadActual->getIdPropiedad() . "'>" . $propiedadActual->getNombre() . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="mb-3">
                <label for="description-product" class="form-label">* Descripción</label>
                <input type="text" class="form-control" name="properties[0][value]" required>
            </div>
        </div>
    </div>

    <div class="mb-3" id="extra-properties-container-2"></div> <!-- Contenedor de nuevas propiedades -->

    <button type="button" class="btn btn-outline-primary" id="add-property">Agregar otra propiedad</button>

    <script>
    $(document).ready(function() {
        let propiedadIndex = 1;
        $('#add-property').on('click', function() {
            let newPropertyHtml = `
                <div class="row extra-property mt-2">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="product-Type" class="form-label">* Tipo de producto</label>
                            <select class="form-select" name="properties[{propiedadIndex}][name]" required>
                                <option value="-1">Seleccione...</option>
                                <?php
                                foreach ($propiedades as $propiedadActual) {
                                    echo "<option value='" . $propiedadActual->getIdPropiedad() . "'>" . $propiedadActual->getNombre() . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="description-product" class="form-label">* Descripción</label>
                            <input type="text" class="form-control" name="properties[${propiedadIndex}][value]" required>
                        </div>
                    </div>
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-danger remove-property">Eliminar</button>
                    </div>
                </div>
            `;

            $('#extra-properties-container-2').append(newPropertyHtml);
            propiedadIndex++;
        });

        // Eliminar una propiedad agregada
        $(document).on('click', '.remove-property', function() {
            $(this).closest('.extra-property').remove();
        });
    });
</script>


<?php
}
?>