<?php
// Incluir el archivo de conexión a la base de datos
include('conexion_bd.php');

// Verificar si el usuario está logueado
session_start();
if (!isset($_SESSION['username'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está logueado
    header("Location: login.php");
    exit();
}

// Obtener el ID del usuario actualmente logueado

$usuario_id = $_SESSION['usuario_id'];

// Consultar los datos del usuario en la base de datos
$sql = "SELECT * FROM usuarios WHERE UsuarioID = $usuario_id";

$resultado = $conexion->query($sql);

// Verificar si se encontraron resultados
if ($resultado->num_rows > 0) {
    // Obtener los datos del usuario
    $usuario = $resultado->fetch_assoc();
} else {
    echo "No se encontraron datos de usuario.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <?php include('navbar.php') ?>

    <div class="container mt-5">
        <h1 class="mb-4">Perfil de Usuario</h1>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Datos Personales
                    </div>
                    <div class="card-body">
                        <p><strong>Usuario:</strong> <?php echo $usuario['Usuario']; ?></p>
                        <p><strong>Correo:</strong> <?php echo $usuario['Correo']; ?></p>
                        <p><strong>Nombre:</strong> <?php echo $usuario['Nombre']; ?></p>
                        <!-- Agregar más datos personales si es necesario -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
