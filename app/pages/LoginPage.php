<?php
if (isset($_POST['sendButton'])) {
    $correo = $_POST["email"];
    $clave = md5($_POST["password"]);
    $person = new Administrador(null, null, null, null, null, $correo, $clave);
    if ($person->autenticar()) {
        $_SESSION["id"] = $person->getIdPersona();
        $_SESSION["role"] = "A";
        header("Location: ?pid=" . base64_encode("pages/Home.php"));
    } else {
        $person = new Vendedor(null, null, null, null, null, $correo, null, null,  $clave);
        if ($person->autenticar()) {
            $_SESSION["id"] = $person->getIdPersona();
            $_SESSION["role"] = "S";
            header("Location: ?pid=" . base64_encode("pages/Home.php"));
        } else {
            $error = true;
        }
    }
}
?>

<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <form method="post" action="?pid=<?= base64_encode("pages/LoginPage.php") ?>" class="needs-validation" novalidate="" autocomplete="on">
                            <h1 class="fs-4 card-title fw-bold mb-4">Inicio Sesion</h1>
                            <?php if (isset($error) && $error): ?>
                                <div class="alert alert-danger mt-3" role="alert" id="alertContainer">
                                    <p id="alert">Error en el inicio de sesión. Verifique credenciales</p>
                                </div>
                            <?php endif; ?>
                            <div class="mb-3">
                                <label class="mb-3 text-muted" for="email">Correo Electrónico</label>
                                <input name="email" type="email" class="form-control" required autofocus>
                            </div>
                            <label class="mb-3 text-muted" for="passwordInput">Contraseña</label>
                            <div class="input-group mb-3">
                                <input name="password" type="password" class="form-control">
                                <button class="btn btn-outline-secondary" type="button" id="seeButton">
                                    <span class="material-symbols-rounded" id="icon">visibility</span>
                                </button>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" name="sendButton" class="btn btn-primary max-width">
                                    Iniciar Sesion
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Footer -->
                <?php include("../app/components/footer.php") ?>
            </div>
        </div>
    </div>
</section>
<script>
    const btnPasswordInput = document.getElementById('seeButton');
    btnPasswordInput.addEventListener("click", () => {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('icon');
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';

        icon.textContent = passwordInput.type === 'password' ? 'visibility' : 'visibility_off';
    });
</script>