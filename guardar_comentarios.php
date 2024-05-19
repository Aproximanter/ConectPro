<?php
session_start();
include 'conexion_bd.php';

if (!isset($_SESSION['UsuarioID'])) {
    // Si el usuario no está autenticado, redirigirlo a la página de inicio de sesión
    echo "Debes iniciar sesión primero.";
    exit; // Detener la ejecución del script
}

// Recibir los datos del formulario
$profesionistaId = $_POST['profesionistaId'];
$calificacion = $_POST['star'];
$comentario = $_POST['comentario'];
$usuarioId = $_SESSION['UsuarioID']; // Asegúrate de tener la sesión iniciada y el usuario autenticado

// Conexión a la base de datos
$con = connection();

// Consulta para verificar si el usuario ya ha comentado
$sql_verificar = "SELECT * FROM resenas WHERE ProfesionistaID = ? AND UsuarioID = ?";
$stmt_verificar = mysqli_prepare($con, $sql_verificar);
mysqli_stmt_bind_param($stmt_verificar, "ii", $profesionistaId, $usuarioId);
mysqli_stmt_execute($stmt_verificar);
$resultado_verificar = mysqli_stmt_get_result($stmt_verificar);

// Verificar si ya existe un comentario del usuario para el mismo profesionista
if(mysqli_num_rows($resultado_verificar) > 0) {
    echo "Ya has comentado para este profesionista.";
} else {
    // Preparar la consulta SQL para insertar el comentario
    $sql = "INSERT INTO resenas (ProfesionistaID, UsuarioID, Calificacion, Comentario) 
            VALUES (?, ?, ?, ?)";

    // Preparar la sentencia
    $stmt = mysqli_prepare($con, $sql);

    // Vincular los parámetros
    mysqli_stmt_bind_param($stmt, "iiis", $profesionistaId, $usuarioId, $calificacion, $comentario);

    // Ejecutar la sentencia
    if (mysqli_stmt_execute($stmt)) {
        // Comentario guardado correctamente
        echo "¡Comentario guardado correctamente!";
    } else {
        // Error al guardar el comentario
        echo "Error al guardar el comentario: " . mysqli_error($con);
    }

    // Cerrar la sentencia
    mysqli_stmt_close($stmt);
}

// Cerrar la conexión y liberar recursos
mysqli_close($con);
?>
