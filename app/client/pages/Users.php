<?php
if ($_SESSION["role"] == "A") {
    $person = new Administrator($_SESSION["id"]);
    $person->consultarPorId();
}else{
    header("Location: ?pid=" . base64_encode("client/pages/sinPermiso.php"));
}
?>

<body id="body-pd">
    <?php
    include("client/components/Menu.php");
    ?>
    <!--Container Main-->
    <div class="container">
        <h4>users Main</h4>
    </div>
    <script src="client/js/home.js"></script>
</body>