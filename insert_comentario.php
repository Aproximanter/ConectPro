<?php
// Verificar si se ha enviado el formulario
if(isset($_POST['crear_comentario'])) {
    // Recuperar los datos del formulario
    $profesionistaID = $_POST['profesionista_id'];
    $usuarioID = $_POST['usuario_id'];
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    // Aquí debes realizar la inserción del comentario en la base de datos
    include("conexion_bd.php");
    
    // Obtener la conexión a la base de datos
    $conexion = connection();

    // Preparar la consulta SQL
    $sql = "INSERT INTO resenas (ProfesionistaID, UsuarioID, Calificacion, Comentario) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiis", $profesionistaID, $usuarioID, $calificacion, $comentario);

    // Iniciar el almacenamiento en búfer de salida
    ob_start();

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Enviar una alerta y redirigir a crud_comentarios.php
        echo "<script>alert('Comentario creado exitosamente'); window.location.href = 'crud_comentarios.php';</script>";
    } else {
        // Enviar una alerta de error
        echo "<script>alert('Error al crear el comentario: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Cerrar la conexión
    $stmt->close();
    $conexion->close();

    // Limpiar el búfer de salida y desactivar el almacenamiento en búfer
    ob_end_flush();

    // Detener el script después de la salida
    exit();
}
?>
