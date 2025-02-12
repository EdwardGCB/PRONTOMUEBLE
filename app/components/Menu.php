<?php
$route = base64_decode($_GET['pid']);
?>

<header class="header" id="header">
    <div class="header_toggle" id="header-toggle">
        <span class="material-symbols-rounded">menu</span>
    </div>
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle d-flex align-items-center justify-content-center" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="header_img d-flex align-items-center">
                <img src="<?= ($persona->getImg() == "") ? "https://i.imgur.com/hczKIze.jpg" : "client/img/profiles/" . $persona->getImg() . "" ?>" alt="User Image" id="userImage" class="rounded-circle me-2" style="width: 40px; height: 40px;">
            </div>
            <p class="user-name m-0 ms-2 text-center"><?= $persona->getnombres() . " " . $persona->getApellidos() . " " ?></p>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton2">
            <li><a class="dropdown-item d-flex align-items-center justify-content-center" href="#">Perfil</a></li>
            <li><a class="dropdown-item d-flex align-items-center justify-content-center" href="#">Edit Perfil</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item d-flex align-items-center justify-content-center" href="#">Logout</a></li>
        </ul>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="?pid=<?= base64_encode("pages/Home.php") ?>" class="nav_logo">
                <span class="material-symbols-rounded nav_logo-icon">layers</span>
                <span class="nav_logo-name">BBBootstrap</span>
            </a>
            <div class="nav_list">
                <a href="?pid=<?= base64_encode("pages/Home.php") ?>" class="nav_link <?= ($route == "pages/Home.php") ? "active" : "" ?>">
                    <span class="material-symbols-rounded nav_icon">Home</span>
                    <span class="nav_name">Home</span>
                </a>
                <a href="?pid=<?= base64_encode("pages/Users.php") ?>" class="nav_link <?= ($route == "pages/Users.php") ? "active" : "" ?>">
                    <span class="material-symbols-rounded nav_icon">person</span>
                    <span class="nav_name">Users</span>
                </a>
                <a href="?pid=<?= base64_encode("pages/Products.php") ?>" class="nav_link <?= ($route == "pages/Products.php") ? "active" : "" ?>">
                    <span class="material-symbols-rounded nav_icon">inventory_2</span>
                    <span class="nav_name">Products</span>
                </a>
                <a href="?pid=<?= base64_encode("pages/Facturacion.php") ?>" class="nav_link <?= ($route == "pages/Facturacion.php") ? "active" : "" ?>">
                    <span class="material-symbols-rounded nav_icon">add_shopping_cart</span>
                    <span class="nav_name">Facturacion</span>
                </a>
                <a href="#" class="nav_link">
                    <span class="material-symbols-rounded nav_icon">folder</span>
                    <span class="nav_name">Files</span>
                </a>
                <a href="#" class="nav_link">
                    <span class="material-symbols-rounded nav_icon">bar_chart</span>
                    <span class="nav_name">Stats</span>
                </a>
            </div>
        </div>
        <a href="#" class="nav_link">

        </a>
    </nav>
</div>