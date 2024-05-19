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
    // Obtener los datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $profesion = isset($_POST['profesion']) ? $_POST['profesion'] : '';
    $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
    $costo = isset($_POST['costo']) ? $_POST['costo'] : NULL;
    $telefono = isset($_POST['telefono']) ? $_POST['telefono'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

    // Verificar si se proporcionaron todos los datos necesarios
    if (!empty($nombre) && !empty($profesion) && !empty($descripcion) && isset($costo) && !empty($telefono) && !empty($correo) && !empty($direccion)) {
        // Verificar si se cargó una foto de perfil
        if (isset($_FILES['foto_perfil'])) {
            $foto_nombre = $_FILES['foto_perfil']['name'];
            $foto_temp = $_FILES['foto_perfil']['tmp_name'];
            $destino = 'fotos_perfil/' . $foto_nombre; // Ruta de destino para guardar la foto
            
            // Mover la foto de perfil al directorio de destino
            if (move_uploaded_file($foto_temp, $destino)) {
                // Insertar datos del profesionista y la foto de perfil en la base de datos
                $sql_insert_profesionista = "INSERT INTO profesionistas (UsuarioID, Nombre, Profesion, Descripcion, FotoPerfil, Costo) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt_insert_profesionista = mysqli_prepare($con, $sql_insert_profesionista);
                mysqli_stmt_bind_param($stmt_insert_profesionista, "issssd", $usuario_id, $nombre, $profesion, $descripcion, $destino, $costo);
                
                // Insertar datos de contacto del profesionista en la base de datos
                $sql_insert_contacto = "INSERT INTO datoscontactoprofesionista (ProfesionistaID, Telefono, Correo, Direccion) VALUES (LAST_INSERT_ID(), ?, ?, ?)";
                $stmt_insert_contacto = mysqli_prepare($con, $sql_insert_contacto);
                mysqli_stmt_bind_param($stmt_insert_contacto, "sss", $telefono, $correo, $direccion);
                
                // Ejecutar ambas consultas dentro de una transacción
                mysqli_begin_transaction($con);
                $success = true;
                if (!mysqli_stmt_execute($stmt_insert_profesionista) || !mysqli_stmt_execute($stmt_insert_contacto)) {
                    $success = false;
                    mysqli_rollback($con); // Deshacer la transacción en caso de error
                }
                mysqli_commit($con); // Confirmar la transacción si no hubo errores

                if ($success) {
                    // Mostrar un mensaje de éxito y redirigir
                    echo "<script>alert('Profesionista registrado exitosamente.'); window.location.href = 'index.php';</script>";
                } else {
                    // Mostrar un mensaje de error
                    echo "<script>alert('Error al registrar el profesionista.');</script>";
                }
            } else {
                // Mostrar un mensaje de error
                echo "<script>alert('Error al subir la foto de perfil.');</script>";
            }
        } else {
            // Mostrar un mensaje de error
            echo "<script>alert('Por favor, seleccione una foto de perfil.');</script>";
        }
    } else {
        // Mostrar un mensaje de error
        echo "<script>alert('Por favor, complete todos los campos del formulario y asegúrese de proporcionar el costo del servicio y los datos de contacto.');</script>";
    }
}

?>
