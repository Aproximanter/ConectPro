<?php
// Verificar si se ha enviado el formulario de edición de profesionista
if(isset($_POST['editar_profesionista'])) {
    // Verificar si se han recibido todos los datos necesarios
    if(isset($_POST['profesionistaID']) && isset($_POST['nombre']) && isset($_POST['profesion']) && isset($_POST['descripcion'])) {
        // Obtener los datos del formulario
        $profesionistaID = $_POST['profesionistaID'];
        $nombre = $_POST['nombre'];
        $profesion = $_POST['profesion'];
        $descripcion = $_POST['descripcion'];
        $foto_perfil = isset($_POST['foto_perfil']) ? $_POST['foto_perfil'] : null; // Verificar si se ha enviado la foto de perfil

        // Realizar la actualización en la base de datos
        include("conexion_bd.php"); // Incluir el archivo de conexión a la base de datos
        $conexion = connection(); // Obtener la conexión

        // Preparar la consulta SQL para actualizar el profesionista
        $sql = "UPDATE profesionistas SET Nombre = '$nombre', Profesion = '$profesion', Descripcion = '$descripcion'";
        if ($foto_perfil !== null) {
            $sql .= ", FotoPerfil = '$foto_perfil'";
        }
        $sql .= " WHERE ProfesionistaID = '$profesionistaID'";

        // Ejecutar la consulta y verificar si la actualización fue exitosa
        if($conexion->query($sql) === TRUE) {
            // Redirigir de vuelta a la página principal o mostrar un mensaje de éxito
            header("Location: crudprofesionistas.php"); 
            exit(); // Terminar el script después de redirigir
        } else {
            // Si hay un error, mostrar un mensaje de error
            echo "Error al actualizar el profesionista: " . $conexion->error;
        }

        // Cerrar la conexión a la base de datos
        $conexion->close();
    } else {
        // Si faltan datos en el formulario, mostrar un mensaje de error
        echo "Por favor, complete todos los campos.";
    }
} else {
    // Si no se envió el formulario de edición de profesionista, redirigir a la página principal o mostrar un mensaje de error
    header("Location: crudprofesionistas.php"); 
    exit(); // Terminar el script después de redirigir
}
?>
