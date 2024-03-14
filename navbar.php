<?php
session_start();

// Función para cerrar sesión
function cerrarSesion() {
    // Destruir todas las variables de sesión
    session_unset();
    
    // Destruir la sesión
    session_destroy();
    
    // Redireccionar a la página de inicio o a donde desees después de cerrar sesión
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <style>
    
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="index.php">
      <img src="https://png.pngtree.com/png-clipart/20230418/original/pngtree-helmet-line-icon-png-image_9065256.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      ConectaPro
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link" href="login.php">Vender Servicios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="perfil.php">Perfil</a>
        </li>
        <li class="nav-item">
          <?php if(isset($_SESSION['username'])): ?>
              <span class="nav-link">Bienvenido, <?= $_SESSION['username'] ?></span>
          <?php else: ?>
              <a class="nav-link" href="login.php">Iniciar sesión</a>
          <?php endif; ?>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Profesionistas</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Conductor</a></li>
            <li><hr class="dropdown-divider"></li>
            <!-- Agrega más opciones si es necesario -->
          </ul>
        </li>
      </ul>
      <?php if(isset($_SESSION['username'])): ?>
        <form method="post" class="d-flex">
            <button type="submit" name="cerrar_sesion" class="btn btn-link">Cerrar sesión</button>
        </form>
      <?php endif; ?>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Buscar Usuario" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Buscar</button>
      </form>
    </div>
  </div>
</nav>

</body>
</html>
