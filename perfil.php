<?php
session_start(); // Iniciar sesión si no está iniciada

// Verificar si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include 'conexion_bd.php';

// Función para obtener los datos del usuario
function obtenerUsuario($userID) {
    $conexion = connection();

    $sql = "SELECT * FROM usuarios WHERE UsuarioID = $userID";
    $resultado = mysqli_query($conexion, $sql);

    // Verificar si se encontraron resultados
    if (mysqli_num_rows($resultado) > 0) {
        // Obtener los datos del usuario
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_close($conexion); // Cerrar la conexión
        return $usuario;
    } else {
        mysqli_close($conexion); // Cerrar la conexión
        return false; // Usuario no encontrado
    }
}

// Obtener el ID de usuario de la sesión actual
$userID = $_SESSION['UsuarioID'];

// Obtener los datos del usuario actual
$usuario = obtenerUsuario($userID);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- Estilos personalizados -->
    <!-- Bootstrap JS y jQuery -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="js/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
          
        }
        .profile-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .profile-card h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333333;
        }
        .profile-card p {
            font-size: 18px;
            margin-bottom: 15px;
            color: #666666;
        }
        .profile-card strong {
            font-weight: bold;
            color: #333333;
        }
    </style>
</head>
<body>

<?php include('navbar.php')?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile-card">
                <h1>Perfil de Usuario</h1>
                <p><strong>Nombre de usuario:</strong> <?php echo $usuario['Usuario']; ?></p>
                <p><strong>Correo electrónico:</strong> <?php echo $usuario['Correo']; ?></p>
                <p><strong>Nombre:</strong> <?php echo $usuario['Nombre']; ?></p>

                <!-- Agrega más campos según sea necesario -->
            </div>
        </div>
    </div>
</div>


</body>
</html>
