<?php
include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();

// Manejar la acción de eliminación
if(isset($_POST['action']) && $_POST['action'] == 'eliminar') {
    $resenaID = $_POST['resenaID'];
    $sql = "DELETE FROM resenas WHERE ResenaID = $resenaID";
    if ($conexion->query($sql) === TRUE) {
        echo "Comentario eliminado correctamente.";
    } else {
        echo "Error al eliminar el comentario: " . $conexion->error;
    }
    exit(); // Terminar la ejecución del script después de la eliminación
}
?>
