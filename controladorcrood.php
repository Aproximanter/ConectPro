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

    // Manejar la foto de perfil (guardar en la base de datos o servidor, dependiendo de tus necesidades)

    // Preparar la consulta SQL para insertar datos en la tabla usuarios
    $sql = "INSERT INTO usuarios (Usuario, Correo, Contrasena, Nombre) VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    // Vincular parámetros
    $stmt->bind_param("ssss", $usuario, $correo, $contrasena, $nombre);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "<script>alert('Registro de usuario exitoso'); window.location.href='elecciondeusuario.php';</script>";
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
}

// Verificar si el formulario de inicio de sesión fue enviado
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['inicio_sesion'])) {
    // Recuperar datos del formulario
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta SQL para verificar las credenciales
    $consulta = "SELECT * FROM usuarios WHERE Usuario='$usuario'";
    $resultado = $conexion->query($consulta);

    // Verificar si se encontró un usuario con las credenciales proporcionadas
    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();

        if (password_verify($contrasena, $fila['Contrasena'])) {
            // Autenticación exitosa, iniciar sesión
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['username'] = $usuario; // Guardar el ID del usuario en la sesión
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
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
