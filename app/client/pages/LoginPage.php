<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="logo" width="100">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Inicio Sesion</h1>
                        <div class="alert alert-danger mt-3 d-none" role="alert" id="alertContainer">
                            <p id="alert"></p>
                        </div>
                        <div class="mb-3">
                            <label class="mb-3 text-muted" for="email">Correo Electrónico</label>
                            <input id="email" type="email" class="form-control" value="" required autofocus>
                        </div>
                        <label class="mb-3 text-muted" for="email">Contraseña</label>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="passwordInput">
                            <button class="btn btn-outline-secondary" type="button" id="seeButton">
                                <span class="material-symbols-rounded" id="icon">visibility</span>
                            </button>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary max-width" id="sendButton">
                                Iniciar Sesion
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <?php include("../app/client/components/footer.php") ?>
            </div>
        </div>
    </div>
</section>
<script>
    const btnPasswordInput = document.getElementById('seeButton');
    const btnForm = document.getElementById('sendButton');

    btnPasswordInput.addEventListener("click", () => {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('icon');
        passwordInput.type = passwordInput.type === 'password'? 'text' : 'password';

        icon.textContent = passwordInput.type === 'password'? 'visibility' : 'visibility_off';

    });

    btnForm.addEventListener("click", () => {
        autentication();
    });

    function autentication() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('passwordInput').value;
    const alertElement = document.getElementById('alert');
    const alertContent = document.getElementById('alertContainer');

    // Validación de campos vacíos
    if (email.trim() !== "" && password.trim() !== "") {
        const request = new XMLHttpRequest();
        request.open('POST', '../app/server/request/Rlogin.php', true);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        request.onreadystatechange = () => {
            if (request.readyState === 4) {
                if (request.status != 200) {
                    alertElement.textContent = "Correo o contraseña incorrectos.";
                    alertContent.classList.remove('d-none');
                    alertContent.classList.remove('alert-success');
                    alertContent.classList.add('alert-danger');
                }
            }
        };

        request.onerror = function() {
            alertElement.textContent = "No se pudo conectar al servidor.";
            alertContent.classList.remove('d-none');
            alertContent.classList.remove('alert-success');
            alertContent.classList.add('alert-danger');
        };

        // Enviar datos
        const data = `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`;
        request.send(data);
    } else {
        alertElement.textContent = "Por favor ingresa tanto el correo como la contraseña.";
        alertContent.classList.remove('d-none');
        alertContent.classList.remove('alert-success');
        alertContent.classList.add('alert-danger');
    }
}
</script>
