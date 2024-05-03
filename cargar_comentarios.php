<?php
include 'conexion_bd.php';

// Verificar si se ha recibido el ID del profesionista
if (isset($_POST['profesionista_id'])) {
    $profesionistaId = $_POST['profesionista_id'];
    
    // Realizar la consulta para obtener los comentarios anteriores
    // $sql = "SELECT * FROM comentarios WHERE ProfesionistaID = ?";
    // Ejecutar la consulta, obtener los resultados y mostrarlos
    
    // Por ejemplo:
    // $sql = "SELECT * FROM comentarios WHERE ProfesionistaID = ?";
    // Preparar la consulta, bindear parámetros, ejecutar la consulta, etc.
    // Mostrar los comentarios en el formato deseado
    
    // Si hay comentarios anteriores, puedes mostrarlos en formato HTML
    // echo '<div class="previous-comment">...</div>';
} else {
    // Si no se recibió el ID del profesionista, mostrar un mensaje de error
    echo "Error: No se recibió el ID del profesionista.";
}
?>
