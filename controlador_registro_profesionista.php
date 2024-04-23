<?php
session_start();
include("conexion_bd.php");
$con = connection();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    // Mostrar un mensaje de error y redirigir al usuario a la página de inicio de sesión
    echo "<script>alert('Debes iniciar sesión para acceder a esta página.'); window.location.href = 'login.php';</script>";
    exit(); // Finalizar el script para evitar que se siga ejecutando el código
}

// Obtener el UsuarioID desde la sesión
$usuario_id = $_SESSION['UsuarioID'];

if(isset($_POST['crear_profesionista'])) {
    // Verificar si el usuario ya tiene un perfil de profesionista asociado
    $sql_verificar = "SELECT ProfesionistaID FROM profesionistas WHERE UsuarioID = ?";
    $stmt_verificar = mysqli_prepare($con, $sql_verificar);
    mysqli_stmt_bind_param($stmt_verificar, "i", $usuario_id);
    mysqli_stmt_execute($stmt_verificar);
    $resultado_verificar = mysqli_stmt_get_result($stmt_verificar);

    if(mysqli_num_rows($resultado_verificar) > 0) {
        // El usuario ya tiene un perfil de profesionista asociado
        echo "<script>alert('Ya tienes un perfil de profesionista asociado.'); window.location.href = 'index.php';</script>";
        exit; // Salir del script
    }

    // Si el usuario no tiene un perfil de profesionista asociado, proceder con la creación del nuevo perfil
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $profesion = isset($_POST['profesion']) ? $_POST['profesion'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $costo = isset($_POST['costo']) ? $_POST['costo'] : NULL; // Nuevo campo para el costo del servicio

    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($nombre) && !empty($profesion) && !empty($descripcion) && isset($costo)) {
        // Verificar si se cargó una foto de perfil
        if (isset($_FILES['foto_perfil'])) {
            $foto_nombre = $_FILES['foto_perfil']['name'];
            $foto_temp = $_FILES['foto_perfil']['tmp_name'];
            $destino = 'fotos_perfil/' . $foto_nombre; // Ruta de destino para guardar la foto
            
            // Mover la foto de perfil al directorio de destino
            if (move_uploaded_file($foto_temp, $destino)) {
                // Insertar datos del profesionista y la foto de perfil en la base de datos
                $sql = "INSERT INTO profesionistas (UsuarioID, Nombre, Profesion, Descripcion, FotoPerfil, Costo) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($con, $sql);
                mysqli_stmt_bind_param($stmt, "issssd", $usuario_id, $nombre, $profesion, $descripcion, $destino, $costo);
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
        echo "<script>alert('Por favor, complete todos los campos del formulario y asegúrese de proporcionar el costo del servicio.');</script>";
    }
}
?>
