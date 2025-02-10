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
    <div class="container mt-4" id="container">
        <div class="nav-bar">
            <nav class="navbar navbar-light">
                <div class="col-10">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" id="search">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-secondary"><span
                            class="material-symbols-rounded">filter_alt</span></button>
                    <button type="button" class="btn btn-success" id="add"><span
                            class="material-symbols-rounded">add</span></button>
                </div>  
            </nav>
        </div>
        <div class="container">
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th scope="col">
                                <label class="control control--checkbox">
                                    <input type="checkbox" class="js-check-all">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <th scope="col">Order</th>
                            <th scope="col">Sales</th>
                            <th scope="col">Description</th>
                            <th scope="col">Support</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label class="control control--checkbox">
                                    <input type="checkbox">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <td>
                                1392
                            </td>
                            <td>Sales Pitch - 2019</td>
                            <td>
                                Far far away, behind the word mountains
                                <small class="d-block">Far far away, behind the word mountains</small>
                            </td>
                            <td>+63 983 0962 971</td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="control control--checkbox">
                                    <input type="checkbox">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <td>4616</td>
                            <td>Social Media Planner</td>
                            <td>
                                Far far away, behind the word mountains
                                <small class="d-block">Far far away, behind the word mountains</small>
                            </td>
                            <td>+02 020 3994 929</td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="control control--checkbox">
                                    <input type="checkbox">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <td>9841</td>
                            <td>Website Agreement</td>
                            <td>
                                Far far away, behind the word mountains
                                <small class="d-block">Far far away, behind the word mountains</small>
                            </td>
                            <td>+01 352 1125 0192</td>
                            <td>

                            </td>
                        </tr>

                        <tr>
                            <th scope="row">
                                <label class="control control--checkbox">
                                    <input type="checkbox">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <td>
                                1392
                            </td>
                            <td>Sales Pitch - 2019</td>
                            <td>
                                Far far away, behind the word mountains
                                <small class="d-block">Far far away, behind the word mountains</small>
                            </td>
                            <td>+63 983 0962 971</td>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="control control--checkbox">
                                    <input type="checkbox">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <td>4616</td>
                            <td>Social Media Planner</td>
                            <td>
                                Far far away, behind the word mountains
                                <small class="d-block">Far far away, behind the word mountains</small>
                            </td>
                            <td>+02 020 3994 929</td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label class="control control--checkbox">
                                    <input type="checkbox">
                                    <div class="control__indicator"></div>
                                </label>
                            </th>
                            <td>9841</td>
                            <td>Website Agreement</td>
                            <td>
                                Far far away, behind the word mountains
                                <small class="d-block">Far far away, behind the word mountains</small>
                            </td>
                            <td>+01 352 1125 0192</td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="client/js/home.js"></script>
    <script>
        $(document).ready(function () {
            $("#search").keyup(function () {
                if ($("#search").val().length >= 3) {
                    console.log($("#search").val());
                    //url = "indexServer.php?pid=<?php /*= base64_encode("server/ajax/buscarProducto.php") . "&Search="*/ ?>" + $("#search").val();
                    //$("#table-responsive").load(url);
                }
            });

            $('#add').click(function () {
                console.log('click');
                url = "indexServer.php?pid=<?= base64_encode("server/ajax/agregarProducto.php");?>";
                console.log(url);
                $("#container").load(url);
            });
        });
    </script>
</body>