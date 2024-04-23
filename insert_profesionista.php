<?php
include("conexion_bd.php");
$con = connection();

if(isset($_POST['crear_profesionista'])) {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $profesion = isset($_POST['profesion']) ? $_POST['profesion'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $foto_perfil = isset($_POST['foto_perfil']) ? $_POST['foto_perfil'] : '';

    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($nombre) && !empty($profesion) && !empty($descripcion)) {
        $sql = "INSERT INTO profesionistas (Nombre, Profesion, Descripcion, FotoPerfil) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nombre, $profesion, $descripcion, $foto_perfil);
        
        try {
            $query = mysqli_stmt_execute($stmt);
            if($query){
                // Generar script JavaScript para mostrar una alerta y redireccionar
                echo "<script>alert('Profesionista creado exitosamente.'); window.location.href = 'crudprofesionista.php';</script>";
            } else {
                // Generar script JavaScript para mostrar una alerta
                echo "<script>alert('Error al crear el profesionista.');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            // Si se captura una excepción, significa que se intentó insertar un profesionista duplicado
            // Generar script JavaScript para mostrar una alerta y redireccionar
            echo "<script>alert('El nombre de profesionista ya está en uso.'); window.location.href = 'profesionistas.php';</script>";
        }
    } else {
        // Generar script JavaScript para mostrar una alerta
        echo "<script>alert('Por favor, complete todos los campos del formulario.'); window.location.href = 'profesionistas.php'; ;</script>";
    }
}
?>
