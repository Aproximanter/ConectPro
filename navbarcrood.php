<?php
// Iniciar sesión si no está iniciada


// Función para cerrar sesión
function cerrarSesion() {
    // Destruir todas las variables de sesión
    session_unset();
    
    // Destruir la sesión
    session_destroy();
    
    // Redireccionar a la página de inicio después de cerrar sesión
    header("Location: index.php");
    exit;
}

// Verificar si se ha enviado el formulario para cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    cerrarSesion();
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #ffc107; /* Cambiar color de fondo del menú */
        }

        .navbar-brand {
            color: #343a40; /* Cambiar color del texto del logotipo */
            font-weight: bold; /* Aumentar grosor del texto del logotipo */
        }

        .navbar-nav .nav-link {
            color: #343a40; /* Cambiar color del texto del menú */
            font-weight: bold; /* Aumentar grosor del texto del menú */
            transition: color 0.3s; /* Agregar transición al color del texto */
        }

        .navbar-nav .nav-link:hover {
            color: #212529; /* Cambiar color del texto del menú al pasar el mouse */
        }

        .navbar-toggler {
            border-color: #343a40; /* Cambiar color del borde del botón de menú */
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(0,0,0,.55)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); /* Cambiar color del icono del botón de menú */
        }

        .navbar-toggler:hover .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='black' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); /* Cambiar color del icono del botón de menú al pasar el mouse */
        }

        .navbar-nav-scroll::-webkit-scrollbar {
            width: 8px; /* Ancho del scrollbar */
        }

        .navbar-nav-scroll::-webkit-scrollbar-track {
            background: transparent; /* Color de fondo del scrollbar */
        }

        .navbar-nav-scroll::-webkit-scrollbar-thumb {
            background-color: #343a40; /* Color del scrollbar */
            border-radius: 10px; /* Radio de borde del scrollbar */
        }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="admin.php">
            <img src="https://png.pngtree.com/png-clipart/20230418/original/pngtree-helmet-line-icon-png-image_9065256.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
            ConectaPro
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <?php if(isset($_SESSION['username'])): ?>
                        <span class="nav-link">Bienvenido, <?= $_SESSION['username'] ?></span>
                    <?php else: ?>
                        <a class="nav-link" href="login.php">Iniciar sesión</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="usuarios.php">Administrar Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crudprofesionistas.php">Administrar Profesionistas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crud_comentarios.php">Administrar Comentarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://drive.google.com/drive/folders/1TEbLgkqUP8iLjzK1KMEGVQlOWzgioEgK?usp=sharing">Documentacion y manuales</a>
                </li>
            </ul>
            <?php if(isset($_SESSION['username'])): ?>
                <form method="post" class="d-flex">
                    <button type="submit" name="cerrar_sesion" class="btn btn-link">Cerrar sesión</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>

</body>
</html>








