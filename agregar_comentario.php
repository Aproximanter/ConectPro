<?php
session_start();
include("conexion_bd.php");
$con = connection();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    // Mostrar un mensaje de error y redirigir al usuario a la página de inicio de sesión
    echo "Debes iniciar sesión para acceder a esta página";
    exit(); // Finalizar el script para evitar que se siga ejecutando el código
}

// Obtener el UsuarioID desde la sesión
$usuario_id = $_SESSION['UsuarioID'];

if(isset($_POST['agregar_comentario'])) {
    $profesionista_id = isset($_POST['profesionista_id']) ? $_POST['profesionista_id'] : '';
    $calificacion = isset($_POST['calificacion']) ? $_POST['calificacion'] : '';
    $comentario = isset($_POST['comentario']) ? $_POST['comentario'] : '';

    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($profesionista_id) && !empty($calificacion) && !empty($comentario)) {
        // Insertar el comentario en la base de datos
        $sql = "INSERT INTO resenas (ProfesionistaID, UsuarioID, Calificacion, Comentario) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "iiis", $profesionista_id, $usuario_id, $calificacion, $comentario);
        if (mysqli_stmt_execute($stmt)) {
            // Redirigir a la página de inicio después de agregar el comentario
            header("Location: index.php");
            exit();
        } else {
            // Generar script JavaScript para mostrar una alerta
            echo "<script>alert('Error al agregar el comentario.');</script>";
        }
    } else {
        // Generar script JavaScript para mostrar una alerta
        echo "<script>alert('Por favor, complete todos los campos del formulario para agregar el comentario.');</script>";
    }
}
?>
