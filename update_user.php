<?php
// Verificar si se ha enviado el formulario de edición de usuario
if(isset($_POST['editar_usuario'])) {
    // Verificar si se han recibido todos los datos necesarios
    if(isset($_POST['usuarioID']) && isset($_POST['usuario']) && isset($_POST['correo']) && isset($_POST['nombre'])) {
        // Obtener los datos del formulario
        $usuarioID = $_POST['usuarioID'];
        $usuario = $_POST['usuario'];
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];

        // Realizar la actualización en la base de datos
        include("conexion_bd.php"); // Incluir el archivo de conexión a la base de datos
        $conexion = connection(); // Obtener la conexión

        // Preparar la consulta SQL para actualizar el usuario
        $sql = "UPDATE usuarios SET Usuario = '$usuario', Correo = '$correo', Nombre = '$nombre' WHERE UsuarioID = '$usuarioID'";

        // Ejecutar la consulta y verificar si la actualización fue exitosa
        if($conexion->query($sql) === TRUE) {
            // Redirigir de vuelta a la página principal o mostrar un mensaje de éxito
            header("Location: usuarios.php"); 
            exit(); // Terminar el script después de redirigir
        } else {
            // Si hay un error, mostrar un mensaje de error
            echo "Error al actualizar el usuario: " . $conexion->error;
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
    } else {
        // Si faltan datos en el formulario, mostrar un mensaje de error
        echo "Por favor, complete todos los campos.";
    }
} else {
    // Si no se envió el formulario de edición de usuario, redirigir a la página principal o mostrar un mensaje de error
    header("Location: usuarios.php"); 
    exit(); // Terminar el script después de redirigir
}
?>
