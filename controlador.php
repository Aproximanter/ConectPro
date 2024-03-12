<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$usuario_db = "usuariodb"; 
$contrasena_db = "9.)39qg_ZZQ0t*T(";
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

   

    // Fin Foto de Perfil

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
            
            header("Refresh: 2; url=elecciondeusuario.php");
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
