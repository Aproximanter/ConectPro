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

// Verificar si se recibió el ID del profesionista
if (isset($_POST['profesionistaID'])) {
    $profesionistaID = $_POST['profesionistaID'];
    $userID = $_SESSION['UsuarioID'];

    $conexion = connection();

    // Eliminar la contratación de la base de datos
    $sql_eliminar = "DELETE FROM contrataciones WHERE UsuarioID = $userID AND ProfesionistaID = $profesionistaID";
    if (mysqli_query($conexion, $sql_eliminar)) {
        // Redirigir al perfil del usuario con un mensaje de éxito
        mysqli_close($conexion);
        header("Location: perfil.php?mensaje=Contratación eliminada correctamente");
        exit();
    } else {
        // Redirigir al perfil del usuario con un mensaje de error
        mysqli_close($conexion);
        header("Location: perfil.php?mensaje=Error al eliminar la contratación");
        exit();
    }
} else {
    // Redirigir al perfil del usuario si no se recibió el ID del profesionista
    header("Location: perfil.php");
    exit();
}
?>
