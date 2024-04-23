<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Agrega Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
</head>
<body>
    <?php include('navbar.php') ?>

    <div class="container">
        <div class="container text-center"><img src="https://cdn-icons-png.flaticon.com/512/618/618631.png" alt="logo inicio o vector de coso" class="img-fluid mx-auto" style="max-width: 10%"></div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form id="login-form" class="mt-5" method="post" action="controlador.php" onsubmit="return validarFormulario()">
                    <div class="form-group">
                        <label for="usuario">Nombre de usuario:</label>
                        <input type="text" id="usuario" name="usuario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="contrasena">Contraseña:</label>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                    </div>
                    <input type="hidden" name="inicio_sesion" value="1">
                    <button type="submit" class="btn btn-primary" name="btningresar">Iniciar sesión</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='registro.php'">Registrarse</button>
                </form>
            </div>
        </div>
        
    </div>

    <script>
        function validarFormulario() {
            var usuario = document.getElementById('usuario').value;
            var contrasena = document.getElementById('contrasena').value;

            if (usuario === "" || contrasena === "") {
                alert("Por favor, complete todos los campos.");
                return false;
            } else {
                // No es necesario mostrar alerta aquí, se manejará en PHP
                return true;
            }
        }
    </script>
</body>
</html>