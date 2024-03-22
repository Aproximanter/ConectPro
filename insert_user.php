<?php
include("conexion_bd.php");
$con = connection();

if(isset($_POST['crear_usuario'])) {
    $usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $contrasena = isset($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : ''; // Hash de la contraseña
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($usuario) && !empty($correo) && !empty($contrasena) && !empty($nombre)) {
        $sql = "INSERT INTO usuarios (Usuario, Correo, Contrasena, Nombre) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $usuario, $correo, $contrasena, $nombre);
        
        try {
            $query = mysqli_stmt_execute($stmt);
            if($query){
                // Generar script JavaScript para mostrar una alerta y redireccionar
                echo "<script>alert('Usuario creado exitosamente.'); window.location.href = 'usuarios.php';</script>";
            } else {
                // Generar script JavaScript para mostrar una alerta
                echo "<script>alert('Error al crear el usuario.');</script>";
            }
        } catch (mysqli_sql_exception $e) {
            // Si se captura una excepción, significa que se intentó insertar un usuario duplicado
            // Generar script JavaScript para mostrar una alerta y redireccionar
            echo "<script>alert('El nombre de usuario ya está en uso.'); window.location.href = 'usuarios.php';</script>";
        }
    } else {
        // Generar script JavaScript para mostrar una alerta
        echo "<script>alert('Por favor, complete todos los campos del formulario.'); window.location.href = 'usuarios.php'; ;</script>";
    }
}
?>
