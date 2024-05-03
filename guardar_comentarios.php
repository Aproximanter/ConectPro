<?php
include 'conexion_bd.php';

// Verificar si se han recibido los datos del formulario
if (isset($_POST['profesionista_id'], $_POST['stars'], $_POST['comment'])) {
    $profesionistaId = $_POST['profesionista_id'];
    $stars = $_POST['stars'];
    $comment = $_POST['comment'];
    
    // Insertar el comentario en la tabla 'comentarios'
    // Insertar la reseña en la tabla 'resenas'
    
    // Aquí debes escribir el código para insertar los datos en la base de datos
    
    // Por ejemplo:
    // $sql = "INSERT INTO comentarios (ProfesionistaID, UsuarioID, TextoComentario) VALUES (?, ?, ?)";
    // Preparar la consulta, bindear parámetros, ejecutar la consulta, etc.
    
    // Si la inserción fue exitosa, puedes enviar una respuesta de éxito al cliente
    // echo "Comentario guardado exitosamente.";
} else {
    // Si no se recibieron todos los datos necesarios, enviar un mensaje de error al cliente
    echo "Error: Todos los campos son obligatorios.";
}
?>
