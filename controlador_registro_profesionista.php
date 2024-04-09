<?php
include("conexion_bd.php");
$con = connection();

if(isset($_POST['crear_profesionista'])) {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $profesion = isset($_POST['profesion']) ? $_POST['profesion'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';

    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($nombre) && !empty($profesion) && !empty($descripcion)) {
        // Verificar si se cargó una foto de perfil
        if (isset($_FILES['foto_perfil'])) {
            $foto_nombre = $_FILES['foto_perfil']['name'];
            $foto_temp = $_FILES['foto_perfil']['tmp_name'];
            $destino = 'fotos_perfil/' . $foto_nombre; // Ruta de destino para guardar la foto
            
            // Mover la foto de perfil al directorio de destino
            if (move_uploaded_file($foto_temp, $destino)) {
                // Insertar datos del profesionista y la foto de perfil en la base de datos
                $sql = "INSERT INTO profesionistas (Nombre, Profesion, Descripcion, FotoPerfil) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "ssss", $nombre, $profesion, $descripcion, $destino);
                if (mysqli_stmt_execute($stmt)) {
                    // Generar script JavaScript para mostrar una alerta y redireccionar
                    echo "<script>alert('Profesionista registrado exitosamente.'); window.location.href = 'index.php';</script>";
                } else {
                    // Generar script JavaScript para mostrar una alerta
                    echo "<script>alert('Error al registrar el profesionista.');</script>";
                }
            } else {
                // Generar script JavaScript para mostrar una alerta
                echo "<script>alert('Error al subir la foto de perfil.');</script>";
            }
        } else {
            // Generar script JavaScript para mostrar una alerta
            echo "<script>alert('Por favor, seleccione una foto de perfil.');</script>";
        }
    } else {
        // Generar script JavaScript para mostrar una alerta
        echo "<script>alert('Por favor, complete todos los campos del formulario.');</script>";
    }
}
?>
