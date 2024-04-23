<?php
// Iniciar sesión
session_start();

// Configuración de la conexión a la base de datos
$host = "localhost";
$usuario_db = "root";
$contrasena_db = "";
$nombre_db = "conectpro";

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

    // Manejar la foto de perfil
    if (isset($_FILES['fotoPerfil'])) {
        $fotoNombre = $_FILES['fotoPerfil']['name'];
        $fotoTemp = $_FILES['fotoPerfil']['tmp_name'];
        $destino = '/fotos_perfil' . $fotoNombre; 

        // Mover la foto de perfil al directorio de destino
        if (move_uploaded_file($fotoTemp, $destino)) {
            // Preparar la consulta SQL para insertar datos en la tabla usuarios
            $sql = "INSERT INTO usuarios (Usuario, Correo, Contrasena, Nombre, FotoPerfil) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conexion->prepare($sql);

            // Vincular parámetros
            $stmt->bind_param("sssss", $usuario, $correo, $contrasena, $nombre, $destino);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "<script>alert('Registro de usuario exitoso'); window.location.href='index.php';</script>";
            } else {
                echo "Error al registrar el usuario: " . $stmt->error;
            }

            // Cerrar la conexión y liberar recursos
            $stmt->close();
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
?>
