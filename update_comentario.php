<?php
// Verificar si se ha enviado el formulario
if (isset($_POST['editar_comentario'])) {
    // Recuperar los datos del formulario
    $resenaID = $_POST['resenaID'];
    $profesionistaID = $_POST['profesionista_id'];
    $usuarioID = $_POST['usuario_id'];
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    // Aquí debes realizar la actualización del comentario en la base de datos
    include("conexion_bd.php");

    // Obtener la conexión a la base de datos
    $conexion = connection();

    // Preparar la consulta SQL
    $sql = "UPDATE resenas SET ProfesionistaID=?, UsuarioID=?, Calificacion=?, Comentario=? WHERE ResenaID=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iiisi", $profesionistaID, $usuarioID, $calificacion, $comentario, $resenaID);

    // Iniciar el almacenamiento en búfer de salida
    ob_start();

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Enviar una alerta y redirigir a crud_comentarios.php
        echo "<script>alert('Comentario actualizado exitosamente'); window.location.href = 'crud_comentarios.php';</script>";
    } else {
        // Enviar una alerta de error
        echo "<script>alert('Error al actualizar el comentario: " . $stmt->error . "'); window.history.back();</script>";
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
