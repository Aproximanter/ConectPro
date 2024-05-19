<?php
// Verificar si se ha enviado el formulario de edición de profesionista
if(isset($_POST['editar_profesionista'])) {
    // Verificar si se han recibido todos los datos necesarios
    if(isset($_POST['profesionistaID']) && isset($_POST['nombre']) && isset($_POST['profesion']) && isset($_POST['descripcion']) && isset($_POST['costo'])) {
        // Obtener los datos del formulario
        $profesionistaID = $_POST['profesionistaID'];
        $nombre = $_POST['nombre'];
        $profesion = $_POST['profesion'];
        $descripcion = $_POST['descripcion'];
        $costo = $_POST['costo'];

        // Conectar a la base de datos
        include("conexion_bd.php");
        $conexion = connection();

        // Inicializar la consulta SQL
        $sql = "UPDATE profesionistas SET Nombre = ?, Profesion = ?, Descripcion = ?, Costo = ?";

        // Comprobar si se ha cargado un archivo para la foto de perfil
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
            $foto_nombre = $_FILES['foto_perfil']['name'];
            $foto_temp = $_FILES['foto_perfil']['tmp_name'];
            $destino = 'fotos_perfil/' . $foto_nombre; // Asegúrate de que esta carpeta tenga los permisos correctos
            
            // Intentar mover el archivo subido a la carpeta destino
            if (move_uploaded_file($foto_temp, $destino)) {
                // Foto de perfil movida exitosamente, agregar al SQL
                $sql .= ", FotoPerfil = ?";
            } else {
                // Error al mover la foto de perfil
                echo "Error al subir la foto de perfil.";
                exit();
            }
        }

        $sql .= " WHERE ProfesionistaID = ?";

        // Preparar la consulta SQL
        $stmt = $conexion->prepare($sql);

        // Foto de perfil fue actualizada
        if(isset($destino)) {
            $stmt->bind_param("sssdsi", $nombre, $profesion, $descripcion, $costo, $destino, $profesionistaID);
        } else {
            // Foto de perfil no se actualiza
            $stmt->bind_param("sssdi", $nombre, $profesion, $descripcion, $costo, $profesionistaID);
        }

        // Ejecutar la consulta
        if($stmt->execute()) {
            // Redirigir de vuelta a la página principal o mostrar un mensaje de éxito
            header("Location: crudprofesionistas.php");
            exit();
        } else {
            // Si hay un error, mostrar un mensaje de error
            echo "Error al actualizar el profesionista: " . $stmt->error;
        }

        // Cerrar la conexión a la base de datos
        $stmt->close();
        $conexion->close();
    } else {
        // Si faltan datos en el formulario, mostrar un mensaje de error
        echo "Por favor, complete todos los campos.";
    }
} else {
    // Si no se envió el formulario de edición de profesionista, redirigir a la página principal
    header("Location: crudprofesionista.php"); 
exit();
}
?>