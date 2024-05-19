<?php include('navbar.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Agrega Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <div class="text-center mt-5">
            <img src="https://cdn-icons-png.flaticon.com/512/618/618631.png" alt="Logo" class="img-fluid" style="max-width: 10%;">
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <form id="login-form" method="post" action="controlador.php" onsubmit="return validarFormulario()">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Nombre de usuario:</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                    </div>
                    <input type="hidden" name="inicio_sesion" value="1">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" name="btningresar">Iniciar sesión</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='registro.php'">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function validarFormulario() {
            const usuario = document.getElementById('usuario').value;
            const contrasena = document.getElementById('contrasena').value;

            if (!usuario || !contrasena) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, complete todos los campos.'
                });
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
