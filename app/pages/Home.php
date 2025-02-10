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
    </div>
    <script src="js/home.js"></script>
</body>