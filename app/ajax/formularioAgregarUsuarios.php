<?php
$tipoAgregacion = isset($_GET['tipo']) ? $_GET['tipo'] : ''; // Obtener el tipo desde GET
$asesor = new Vendedor();
$asesores = $asesor->consultarTodos();

$campos = '';

if ($tipoAgregacion == 'clientes') {
    $campos = "
        <div class='row'>
            <div class='col-4'>
                <!-- nombre -->
                <div class='mb-3'>
                    <label for='client-name' class='form-label'>* Nombres</label>
                    <input type='text' class='form-control' name='client-name' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-4'>
                <!-- apellido -->
                <div class='mb-3'>
                    <label for='client-lastname' class='form-label'>* Apellidos</label>
                    <input type='text' class='form-control' name='client-lastname' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-4'>
                <!-- Identificacion -->
                <div class='mb-3'>
                    <label for='identificacion' class='form-label'>* Identificacion</label>
                    <input type='number' class='form-control' name='identificacion' aria-describedby='emailHelp' required>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-6'>
                <!-- fecha creacion -->
                <div class='mb-3'>
                    <label for='product-Type' class='form-label'>* Asesor</label>
                    <select class='form-select' name='product-Type' aria-label='Default select example' required>
                    <option value='-1'>Seleccione...</option>";
    foreach ($asesores as $asesorActual) {
        $campos .= "<option value='" . $asesorActual->getIdPersona() . "'>" . $asesorActual->getNombres() . " " . $asesorActual->getApellidos() . "</option>";
    }
    $campos .= "
                    </select>
                </div>
            </div>
            <div class='col-6'>
                <!-- fecha creacion -->
                <div class='mb-3'>
                    <label for='correo' class='form-label'>* Correo</label>
                    <input type='text' class='form-control' name='correo' aria-describedby='emailHelp' required>
                </div>
            </div>
        </div>
    ";
} else if ($tipoAgregacion == 'proveedores') {
    $campos = "
        <div class='row'>
            <div class='col-3'>
                <!-- Razon Social -->
                <div class='mb-3'>
                    <label for='razon-social' class='form-label'>* Razon Social</label>
                    <input type='text' class='form-control' name='razon-social' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-3'>
                <!-- NIT -->
                <div class='mb-3'>
                    <label for='nit' class='form-label'>* NIT</label>
                    <input type='number' class='form-control' name='nit' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-3'>
                <!-- Direccion -->
                <div class='mb-3'>
                    <label for='direccion' class='form-label'>* Direccion</label>
                    <input type='text' class='form-control' name='direccion' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-3'>
                <!-- image Proveedor-->
                <div class='mb-3'>
                    <label for='image-product' class='form-label'>Imagen</label>
                    <input type='file' class='form-control' name='image-product' aria-describedby='emailHelp'>
                </div>
            </div>
        </div>
        <!-- persona contacto -->
        <div class='mb-3'>
            <label for='person-contact' class='form-label'>* Persona de contacto</label>
            <input type='text' class='form-control' name='person-contact' aria-describedby='emailHelp' required>
        </div>
    ";
} else if ($tipoAgregacion == 'vendedores') {
    $campos = "
        <div class='row'>
            <div class='col-4'>
                <!-- nombre -->
                <div class='mb-3'>
                    <label for='client-name' class='form-label'>* Nombres</label>
                    <input type='text' class='form-control' name='client-name' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-4'>
                <!-- apellido -->
                <div class='mb-3'>
                    <label for='client-lastname' class='form-label'>* Apellidos</label>
                    <input type='text' class='form-control' name='client-lastname' aria-describedby='emailHelp' required>
                </div>
            </div>
            <div class='col-4'>
                <!-- Identificacion -->
                <div class='mb-3'>
                    <label for='identificacion' class='form-label'>* Identificacion</label>
                    <input type='number' class='form-control' name='identificacion' aria-describedby='emailHelp' required>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-4'>
                <!-- fecha creacion -->
                <div class='mb-3'>
                    <label for='correo' class='form-label'>* Correo</label>
                    <input type='text' class='form-control' name='correo' aria-describedby='emailHelp'>
                </div>
            </div>
            <div class='col-4'>
                <!-- clave -->
                <div class='mb-3'>
                    <label for='clave' class='form-label'>* Contraseña</label>
                    <input type='text' class='form-control' name='clave' aria-describedby='emailHelp'>
                </div>
            </div>
            <div class='col-4'>
                <!-- administrador-->
                <div class='mb-3'>
                    <label for='file-seller' class='form-label'>Image</label>
                    <input type='file' class='form-control' name='file-seller' aria-describedby='emailHelp'>
                </div>
            </div>
        </div>
    ";
}

?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Agregar <?= $tipoAgregacion ?></h5>
        <form id="add-product-form" method="post" action="?pid=<?= base64_encode("pages/Users.php") ?>" enctype="multipart/form-data">
            <div id="dynamic-fields">
                <?= $campos ?>
                <!-- telefono contacto -->
                <div class='mb-3'>
                    <label for='numbers' class='form-label'>* Numero Telefono</label>
                    <input type='number' class='form-control' name='numbers[0][value]' required>
                </div>
                <div class='mb-3' id='extra-numbers'></div>

                <button type='button' class='btn btn-outline-primary my-2' id='add-number'>Agregar otro numero</button>
            </div>
            <button type="button" class="btn btn-danger" id="cancel-button">Cancelar</button>
            <button type="submit" class="btn btn-success" name="Add-<?= $tipoAgregacion ?>">Agregar</button>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        let propiedadIndex = 1;
        $('#add-number').on('click', function() {
            let newPropertyHtml = `
            <div class="extra-number-content mt-2">
                <div class="mb-3">
                    <label for="numbers" class="form-label">Numero Telefono</label>
                    <input type="number" class="form-control" name="numbers[${propiedadIndex}][value]" required>
                </div>
                <button type='button' class='btn btn-danger remove-number'>Eliminar</button>
            </div>
        `;

            $('#extra-numbers').append(newPropertyHtml);
            propiedadIndex++;
        });

        // Eliminar una propiedad agregada
        $(document).on('click', '.remove-number', function() {
            $(this).closest('.extra-number-content').remove();
        });

        // Manejo del botón de cancelar
        $('#cancel-button').on('click', function() {
            $.ajax({
                url: 'indexServer.php',
                type: 'GET',
                data: {
                    pid: '<?= base64_encode("ajax/tablaUsuarios.php") ?>',
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