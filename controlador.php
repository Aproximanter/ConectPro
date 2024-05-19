<?php
// Iniciar sesión
session_start();

// Configuración de la conexión a la base de datos
$host = "localhost";
$usuario_db = "id21883336_admin";
$contrasena_db = "A1274J&/Conect";
$nombre_db = "id21883336_conectpro";

// Conexión a la base de datos
$conexion = new mysqli($host, $usuario_db, $contrasena_db, $nombre_db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Verificar si el formulario de registro fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registro'])) {
    // Obtener datos del formulario
    $usuario = $_POST["usuario"];
    $correo = $_POST["correo"];
    $contrasena = password_hash($_POST["contrasena"], PASSWORD_DEFAULT); // Hash de la contraseña
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];

    // Manejar la foto de perfil
    if (isset($_FILES['fotoPerfil'])) {
        $fotoNombre = $_FILES['fotoPerfil']['name'];
        $fotoTemp = $_FILES['fotoPerfil']['tmp_name'];
        $destino = 'fotos_perfil/' . $fotoNombre; 

        // Mover la foto de perfil al directorio de destino
        if (move_uploaded_file($fotoTemp, $destino)) {
            // Iniciar una transacción
            $conexion->begin_transaction();

            try {
                // Preparar la consulta SQL para insertar datos en la tabla usuarios
                $sql = "INSERT INTO usuarios (Usuario, Correo, Contrasena, Nombre, FotoPerfil) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conexion->prepare($sql);

                // Vincular parámetros
                $stmt->bind_param("sssss", $usuario, $correo, $contrasena, $nombre, $destino);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Obtener el ID del usuario insertado
                    $usuarioID = $stmt->insert_id;

                    // Preparar la consulta SQL para insertar datos en la tabla datoscontactousuario
                    $sql_contacto = "INSERT INTO datoscontactousuario (UsuarioID, Telefono, Correo, Direccion) VALUES (?, ?, ?, ?)";
                    $stmt_contacto = $conexion->prepare($sql_contacto);

                    // Vincular parámetros
                    $stmt_contacto->bind_param("isss", $usuarioID, $telefono, $correo, $direccion);

                    // Ejecutar la consulta
                    if ($stmt_contacto->execute()) {
                        // Confirmar la transacción
                        $conexion->commit();
                        echo "<script>alert('Registro de usuario exitoso'); window.location.href='index.php';</script>";
                    } else {
                        // Revertir la transacción en caso de error
                        $conexion->rollback();
                        echo "Error al registrar los datos de contacto del usuario: " . $stmt_contacto->error;
                    }

                    // Cerrar la consulta preparada para datos de contacto
                    $stmt_contacto->close();
                } else {
                    // Revertir la transacción en caso de error
                    $conexion->rollback();
                    echo "Error al registrar el usuario: " . $stmt->error;
                }

                // Cerrar la consulta preparada para usuarios
                $stmt->close();
            } catch (Exception $e) {
                // Revertir la transacción en caso de excepción
                $conexion->rollback();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Error al subir la foto de perfil.";
        }
    } else {
        echo "Por favor, seleccione una foto de perfil.";
    }
}

// Verificar si el formulario de inicio de sesión fue enviado
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inicio_sesion'])) {
    // Recuperar datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL preparada para verificar las credenciales
    $consulta = "SELECT UsuarioID, Contrasena FROM usuarios WHERE Usuario = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();

        if (password_verify($contrasena, $fila['Contrasena'])) {
            // Autenticación exitosa, iniciar sesión
            $_SESSION['UsuarioID'] = $fila['UsuarioID']; // Guardar el ID del usuario en la sesión
            $_SESSION['username'] = $usuario;
            header("Location: index.php"); // Redirigir a la página deseada
            exit(); // Salir del script
        } else {
            // Credenciales incorrectas
            echo "<script>alert('Usuario o contraseña incorrectos.'); window.location.href='login.php';</script>";
        }
    } else {
        // Credenciales incorrectas
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.location.href='login.php';</script>";
    }

    // Cerrar la consulta preparada
    $stmt->close();
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
