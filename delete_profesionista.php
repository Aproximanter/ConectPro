<?php
include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();

// Manejar la acción de eliminación
if(isset($_POST['action']) && $_POST['action'] == 'eliminar') {
    $profesionistaID = $_POST['profesionistaID'];
    $sql = "DELETE FROM profesionistas WHERE ProfesionistaID = $profesionistaID";
    if ($conexion->query($sql) === TRUE) {
        echo "Profesionista eliminado correctamente.";
    } else {
        echo "Error al eliminar el profesionista: " . $conexion->error;
    }
    exit(); // Terminar la ejecución del script después de la eliminación
}
?>
