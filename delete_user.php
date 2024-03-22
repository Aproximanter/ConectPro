<?php
include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();

// Manejar la acción de eliminación
if(isset($_POST['action']) && $_POST['action'] == 'eliminar') {
    $usuarioID = $_POST['usuarioID'];
    $sql = "DELETE FROM usuarios WHERE UsuarioID = $usuarioID";
    if ($conexion->query($sql) === TRUE) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $conexion->error;
    }
    exit(); // Terminar la ejecución del script después de la eliminación
}
?>
