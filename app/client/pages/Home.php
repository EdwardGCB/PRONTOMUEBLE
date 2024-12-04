<?php
if ($_SESSION["role"] == "A") {
    $person = new Administrator($_SESSION["id"]);
    $person->consultarPorId();
} else if ($_SESSION["role"] == "S") {
    $person = new Seller($_SESSION["id"]);
    $person->consultarPorId();
} else {
    header("Location: ?pid=" . base64_encode("client/pages/sinPermiso.php"));
}
?>

<body id="body-pd">
    <?php
    include("client/components/Menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4>Main Components</h4>
    </div>
    <script src="client/js/home.js"></script>
</body>