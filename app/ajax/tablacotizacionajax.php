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
                    <td></td>
                    <td><input type="number" class="form-control cantidad" value="1" min="1"></td>
                    <td><input type="number" class="form-control precio" readonly></td>
                    <td>
                        <button class="btn btn-danger btn-sm borrarFila">Eliminar</button>
                    </td>
                </tr>
            `;
            $("#tablaProductos tbody").append(nuevaFila);
        });

        // Evento cuando el usuario escribe en el campo de búsqueda
        $(document).on("input", ".producto-input", function() {
            var inputProducto = $(this);
            var searchTerm = inputProducto.val();
            var fila = inputProducto.closest("td");
            var suggestionsBox = fila.find(".suggestions-box");
            var proveedorSelect = fila.find(".product-provideer");

            if (searchTerm.length === 0) {
                suggestionsBox.empty().hide();
                return;
            }
            $.ajax({
                url: "indexServer.php?pid=<?= base64_encode("ajax/buscar_productos.php") ?>",
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
                            data-descripcion="${p.descripcion}"
                            >
                            ${p.nombre}
                        </div>
                    `).join("");
                    suggestionsBox.html(opciones).show();
                }


            });
        });

        // Seleccionar un producto de la lista
        $(document).on("click", ".suggestion-item", function() {
            var item = $(this);
            var fila = item.closest("td").closest("tr");
            var inputProducto = fila.find(".producto-input");
            var idProducto = item.attr("data-id");
            inputProducto.val(item.data("nombre"));
            fila.find(".tipoProducto").val(item.attr("data-tipo"));
            fila.find(".descripcion").val(item.attr("data-descripcion"));
            item.closest(".suggestions-box").empty().hide();
        });

        // Ocultar sugerencias si se hace clic fuera
        $(document).on("blur", ".producto-input", function() {
            setTimeout(() => {
                $(this).siblings(".suggestions-box").empty().hide();
            }, 200);
        });

        // Eliminar fila
        $(document).on("click", ".borrarFila", function() {
            $(this).closest("tr").remove();
        });

        // Facturación
        $("#facturar").click(function() {
            alert("Procesando facturación...");
        });

        // Eliminar toda la cotización
        $("#eliminarCotizacion").click(function() {
            if (confirm("¿Está seguro de eliminar la cotización?")) {
                $("#tablaProductos tbody").empty();
            }
        });
    });
</script>