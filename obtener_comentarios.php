<?php
// Incluir el archivo de conexión a la base de datos
include 'conexion_bd.php';

// Obtener el ID del profesionista enviado por AJAX
$profesionistaId = $_POST['profesionista_id'];

// Establecer una conexión a la base de datos
$con = connection();

// Consulta SQL para obtener los comentarios y calificaciones del profesionista
$sql = "SELECT * FROM resenas WHERE ProfesionistaID = ?";
$stmt = mysqli_prepare($con, $sql);

// Vincular el parámetro (ID del profesionista)
mysqli_stmt_bind_param($stmt, "i", $profesionistaId);

// Ejecutar la consulta
mysqli_stmt_execute($stmt);

// Obtener el resultado de la consulta
$resultado = mysqli_stmt_get_result($stmt);

// Comprobar si se encontraron comentarios y calificaciones
if (mysqli_num_rows($resultado) > 0) {
    // Inicializar una variable para almacenar el HTML de los comentarios y calificaciones
    $html = '<div class="container">';

    // Recorrer los resultados y construir el HTML
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Aquí puedes construir el HTML para mostrar cada comentario y calificación
        $html .= '<div class="card mb-3">';
        $html .= '<div class="card-body">';
        $html .= '<h5 class="card-title">Calificación: ' . $fila['Calificacion'] . '</h5>';
        $html .= '<p class="card-text">' . $fila['Comentario'] . '</p>';
        $html .= '</div>';
        $html .= '</div>';
    }

    $html .= '</div>';

    // Devolver el HTML generado
    echo $html;
} else {
    // Si no se encontraron comentarios y calificaciones, mostrar un mensaje
    echo '<p>No hay comentarios disponibles para este profesionista.</p>';
}

// Cerrar la conexión y liberar los recursos
mysqli_stmt_close($stmt);
mysqli_close($con);
?>
