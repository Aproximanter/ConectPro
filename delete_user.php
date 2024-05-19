<?php
include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();

if (isset($_POST['action']) && $_POST['action'] == 'eliminar') {
    $usuarioID = $_POST['usuarioID'];

    // Agregar depuración para verificar que se recibe el ID
    if (empty($usuarioID)) {
        echo "Error: UsuarioID no recibido.";
        exit();
    }

    $sql = "DELETE FROM usuarios WHERE UsuarioID = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuarioID);

    if ($stmt->execute()) {
        echo "Usuario eliminado correctamente.";
    } else {
        echo "Error al eliminar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
    exit();
} else {
    echo "Acción no válida.";
}
?>
