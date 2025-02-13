<div class="d-flex justify-content-between mb-3">
    <button class="btn btn-success" id="agregarProducto">Agregar Producto</button>
    <button class="btn btn-primary" id="facturar">Facturar</button>
    <button class="btn btn-danger" id="eliminarCotizacion">Eliminar Cotización</button>
</div>

<table class="table table-striped mt-3" id="tablaProductos">
    <thead>
        <tr>
            <th>Nombre Producto</th>
            <th>Tipo Producto</th>
            <th>Descripción</th>
            <th>Proveedor</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <!-- Aquí se agregarán los productos dinámicamente -->
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $("#agregarProducto").click(function() {
            var nuevaFila = `
                <tr>
                    <td style="position: relative;">
                        <input type="text" class="form-control producto-input">
                        <div class="suggestions-box"></div>
                    </td>
                    <td><input type="text" class="form-control tipoProducto" readonly></td>
                    <td><input type="text" class="form-control descripcion" readonly></td>
                    <td><select class="form-control proveedorSelect"></select></td>
                    <option value=-1 >seleccione....</option>
                    <td><input type="number" class="form-control cantidad" value="1" min="1"></td>
                    <td><input type="number" class="form-control precio" readonly></td>
                    <td>
                        <button class="btn btn-danger btn-sm borrarFila">Eliminar</button>
                        <button class="btn btn-success btn-sm guardarFila">Guardar</button>
                    </td>
                </tr>
            `;
            $("#tablaProductos tbody").append(nuevaFila);
        });

        $(document).on("input", ".producto-input", function() {
            var inputProducto = $(this);
            var searchTerm = inputProducto.val();
            var fila = inputProducto.closest("td");
            var suggestionsBox = fila.find(".suggestions-box");

            if (searchTerm.length === 0) {
                suggestionsBox.empty().hide();
                return;
            }

            $.ajax({
                url: "indexServer.php?pid=<?= base64_encode('ajax/buscar_productos.php') ?>",
                type: "GET",
                data: {
                    searchTerm: searchTerm
                },
                success: function(response) {
                    var productos = response.productos;

                    if (!productos || productos.length === 0) {
                        suggestionsBox.empty().hide();
                        return;
                    }

                    var opciones = productos.map(p => `
                        <div class="suggestion-item" 
                            data-id="${p.id}" 
                            data-nombre="${p.nombre}" 
                            data-tipo="${p.tipo}" 
                            data-descripcion="${p.descripcion}">
                            ${p.nombre}
                        </div>
                    `).join("");

                    suggestionsBox.html(opciones).show();
                }
            });
        });

        $(document).on("click", ".suggestion-item", function() {
            var item = $(this);
            var fila = item.closest("tr");
            var idProducto = item.attr("data-id");

            fila.find(".producto-input").val(item.data("nombre"));
            fila.find(".producto-input").attr("data-id", idProducto);
            console.log($(".producto-input").attr("data-id"));
            fila.find(".tipoProducto").val(item.attr("data-tipo"));
            fila.find(".descripcion").val(item.attr("data-descripcion"));
            item.closest(".suggestions-box").empty().hide();

            $.ajax({
                url: "indexServer.php?pid=<?= base64_encode('ajax/buscar_proveedor.php') ?>",
                type: "GET",
                data: {
                    productoId: idProducto
                },
                success: function(response) {
                    var proveedores = response.proveedores;
                    var selectProveedor = fila.find(".proveedorSelect");
                    selectProveedor.empty();

                    if (!proveedores || proveedores.length === 0) {
                        selectProveedor.append('<option value="">No hay proveedores</option>');
                    } else {
                        proveedores.forEach(p => {
                            selectProveedor.append(`<option value="${p.proveedor.id}" data-precio="${p.precio}">${p.proveedor.nombre}</option>`);
                        });

                        // Si hay solo un proveedor, seleccionarlo y forzar el cambio
                        if (proveedores.length === 1) {
                            selectProveedor.prop("selectedIndex", 0).trigger("change");
                        }
                    }
                }
            });

        });

        $(document).on("change", ".proveedorSelect", function() {
            var selectedOption = $(this).find("option:selected");
            var precio = selectedOption.data("precio");
            var fila = $(this).closest("tr");
            fila.find(".precio").val(precio);
        });

        $(document).on("click", ".guardarFila", function() {
            var fila = $(this).closest("tr");
            var cantidad = fila.find(".cantidad").val();
            var idMueble = fila.find(".producto-input").attr("data-id"); // Asegurar que data-id se obtiene bien
            var idProveedor = fila.find(".proveedorSelect").val();
            var idCliente = $("#id_cliente").val();
            var idAsesor = $("#id_asesor").val();

            console.log("ID Mueble:", idMueble);
            console.log("ID Proveedor:", idProveedor);
            console.log("Cantidad:", cantidad);
            console.log("Cliente:", idCliente);
            console.log("Asesor:", idAsesor);

            if (!idMueble || idMueble === "undefined") {
                alert("Error: No se encontró el ID del mueble.");
                return;
            }

            $.ajax({
                url: "indexServer.php?pid=<?= base64_encode('ajax/guardar_pedido_proveedor.php') ?>",
                type: "POST",
                data: {
                    cantidad: cantidad,
                    idMueble: idMueble,
                    idProveedor: idProveedor,
                    cliente: idCliente,
                    asesor: idAsesor
                },
                success: function(response) {
                    console.log("Respuesta del servidor:", response);
                    alert("Pedido guardado exitosamente");
                },
                error: function() {
                    alert("Error al guardar el pedido");
                }
            });
        });


        $(document).on("click", ".borrarFila", function() {
            $(this).closest("tr").remove();
        });

        $("#facturar").click(function() {
            alert("Procesando facturación...");
        });

        $("#eliminarCotizacion").click(function() {
            if (confirm("¿Está seguro de eliminar la cotización?")) {
                $("#tablaProductos tbody").empty();
            }
        });
    });
</script>