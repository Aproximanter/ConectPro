<?php
include("conexion_bd.php");
$con = connection();

if(isset($_POST['crear_profesionista'])) {
    $nombre = $_POST['nombre'] ?? '';
    $profesion = $_POST['profesion'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $costo = $_POST['costo'] ?? '';
    
    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($nombre) && !empty($profesion) && !empty($descripcion) && isset($costo)) {
        if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
            $foto_nombre = $_FILES['foto_perfil']['name'];
            $foto_temp = $_FILES['foto_perfil']['tmp_name'];
            $destino = 'fotos_perfil/' . $foto_nombre; // Asegurarse de tener los permisos necesarios
            
            if (move_uploaded_file($foto_temp, $destino)) {
                $sql = "INSERT INTO profesionistas (Nombre, Profesion, Descripcion, Costo, FotoPerfil) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "sssds", $nombre, $profesion, $descripcion, $costo, $destino);
            } else {
                echo "<script>alert('Error al subir la foto de perfil.');</script>";
                $destino = ''; // O tratar de una manera adecuada
            }            
        } else {
            $destino = ''; // No se seleccionó una foto o hubo un error
            // Asegúrese de manejar esto de acuerdo a sus necesidades
        }

        // Ejecutar consulta para insertar el profesionista sin foto si no se proporcionó
        if(empty($destino)) {
            $sql = "INSERT INTO profesionistas (Nombre, Profesion, Descripcion, Costo) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "sssd", $nombre, $profesion, $descripcion, $costo);
        }

        // Intentar ejecutar la consulta preparada
        if(mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Profesionista creado exitosamente.'); window.location.href = 'crudprofesionistas.php';</script>";
        } else {
            echo "<script>alert('Error al crear el profesionista.'); window.location.href = 'profesionistas.php';</script>";
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos del formulario.'); window.location.href = 'profesionistas.php';</script>";
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($con);

?>
