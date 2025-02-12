<?php
if ($_SESSION["role"] == "A") {
    $persona = new Administrador($_SESSION["id"]);
    $persona->consultarPorId();
} else if ($_SESSION["role"] == "S") {
    $persona = new Vendedor($_SESSION["id"]);
    $persona->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("pages/sinPermiso.php"));
}
?>

<body id="body-pd">
    <?php
    include("components/Menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4>Main Components</h4>
        <?/* Pedidos por proveedor*/ ?>
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Gráficos de Proveedores</h4>
                <div class="col-6" id="graficoBarras-proveedor" style="width: 600px; height: 400px;"></div>
                <div class="col-6" id="graficoPie-proveedor" style="width: 600px; height: 400px;"></div>
            </div>
        </div>
        <?/* Cliente con mas compras*/ ?>
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Gráficos de Clientes</h4>
                <div class="col-6" id="graficoPie-cliente" style="width: 600px; height: 400px;"></div>
                <div class="col-6" id="graficoBarras-cliente" style="width: 600px; height: 400px;"></div>
            </div>
        </div>
        <?/* Vendedor con mas ventas*/ ?>
        <div class="card mb-5">
            <div class="container row my-3 p-3">
                <h4>Gráficos de Vendedores</h4>
                <div class="col-6" id="graficoBarras-vendedor" style="width: 95%; height: 600px;"></div>
            </div>
            <div class="col-6" id="tabla-vendedor" style="width: 600px; height: 400px;"></div>
        </div>
    </div>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="js/home.js"></script>
    <script>
        $(document).ready(function() {
            google.charts.load("current", {
                packages: ["corechart", "bar", "table"]
            });
            google.charts.setOnLoadCallback(cargarDatosProveedor);
            google.charts.setOnLoadCallback(cargarDatosVendedor);
            google.charts.setOnLoadCallback(cargarDatosCliente);

            function cargarDatosProveedor() {
                <?php
                $proveedor = new Proveedor();
                $proveedores = $proveedor->cantidadPedidos();

                // Mapear el array para estructurarlo correctamente
                $proveedoresArray = array_map(function ($p) {
                    return [
                        "idProveedor" => $p->getIdProveedor(),
                        "razonSocial" => $p->getRazonSocial(),
                        "total_pedidos" => $p->getCantPedidos(),
                    ];
                }, $proveedores);
                ?>

                console.log(<?php echo json_encode($proveedoresArray); ?>);

                dibujarGraficoBarras(<?php echo json_encode($proveedoresArray); ?>, "proveedor");
                dibujarGraficoPie(<?php echo json_encode($proveedoresArray); ?>, "proveedor");
            }

            function cargarDatosVendedor() {
                <?php
                $vendedor = new Vendedor();
                $vendedores = $vendedor->ventasMensuales();
                $vendedoresArray = array_map(function ($p) {
                    return [
                        "idVendedor" => $p->getIdPersona(),
                        "nombre" => $p->getNombres(),
                        "total_ventas" => ($p->getCantVentas() == null) ? 0 : $p->getCantVentas(),
                    ];
                }, $vendedores);
                ?>

                console.log(<?php echo json_encode($vendedoresArray); ?>);

                dibujarGraficoBarras(<?php echo json_encode($vendedoresArray); ?>, "vendedor");
                dibujarTabla(<?php echo json_encode($vendedoresArray); ?>, "vendedor");
            }

            function cargarDatosCliente() {
                <?php
                $cliente = new Cliente();
                $clientes = $cliente->clienteMasCompras();
                $clientesArray = array_map(function ($p) {
                    return [
                        "idCliente" => $p->getIdPersona(),
                        "nombre" => $p->getNombres(),
                        "total_compras" => ($p->getTotalCompras() == null) ? 0 : $p->getTotalCompras(),
                    ];
                }, $clientes);
                ?>

                console.log(<?php echo json_encode($clientesArray); ?>);

                dibujarGraficoBarras(<?php echo json_encode($clientesArray); ?>, "cliente");
                dibujarGraficoPie(<?php echo json_encode($clientesArray); ?>, "cliente");
            }

            function dibujarGraficoBarras(datos, contenedor) {
                // Convertimos los datos en un formato adecuado para Google Charts
                let dataArray = [
                    [(contenedor == "proveedor") ? "Proveedor" : ((contenedor == "vendedor") ? "Vendedor" : "Cliente"), "Total de Pedidos"]
                ];

                datos.forEach(item => {
                    dataArray.push([(contenedor == "proveedor") ? item.razonSocial : item.nombre, (contenedor == "proveedor") ? parseInt(item.total_pedidos) : ((contenedor == "vendedor") ? parseInt(item.total_ventas) : parseInt(item.total_compras))]);
                });

                let data = google.visualization.arrayToDataTable(dataArray);

                let options = {
                    chart: {
                        title: (contenedor == "proveedor") ? "Top 5 Proveedores con Más Pedidos" : ((contenedor == "vendedor") ? "Vendedores con Más Ventas" : "Clientes con Más Compras"),
                        subtitle: "Cantidad total de pedidos",
                    },
                    bars: 'horizontal', // Hace que el gráfico sea de barras horizontales
                    hAxis: {
                        title: "Total de Pedidos",
                        minValue: 0
                    },
                    vAxis: {
                        title: (contenedor == "proveedor") ? "Proveedores" : ((contenedor == "vendedor") ? "Vendedores" : "Clientes")
                    }
                };

                let chart = new google.charts.Bar(document.getElementById("graficoBarras-" + contenedor));
                chart.draw(data, google.charts.Bar.convertOptions(options));
            }


            function dibujarGraficoPie(datos, contenedor) {
                let data = new google.visualization.DataTable();
                data.addColumn("string", "Proveedor");
                data.addColumn("number", "Pedidos");

                datos.forEach(item => {
                    data.addRow([(contenedor == "proveedor") ? item.razonSocial : item.nombre, (contenedor == "proveedor") ? parseInt(item.total_pedidos) : ((contenedor == "vendedor") ? parseInt(item.total_ventas) : parseInt(item.total_compras))]);
                });

                let options = {
                    title: "Distribución de Pedidos por Proveedor",
                    is3D: true
                };

                let chart = new google.visualization.PieChart(document.getElementById("graficoPie-" + contenedor));
                chart.draw(data, options);
            }

            function dibujarTabla(datos, contenedor) {
                let data = new google.visualization.DataTable();
                data.addColumn("string", "idVendedor");
                data.addColumn("string", "Nombre");
                data.addColumn("number", "Total");

                datos.forEach(item => {
                    data.addRow([String(item.idVendedor), item.nombre, {
                        v: parseInt(item.total_ventas),
                        f: item.total_ventas.toLocaleString()
                    }]);
                });

                let table = new google.visualization.Table(document.getElementById("tabla-" + contenedor));
                table.draw(data, {
                    showRowNumber: true,
                    width: '100%',
                    height: 'auto'
                });
            }
        });
    </script>
</body>