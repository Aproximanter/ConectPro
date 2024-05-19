<?php
session_start(); // Iniciar sesión si no está iniciada

// Verificar si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit();
}

// Incluir el archivo de conexión a la base de datos
include 'conexion_bd.php';

// Función para obtener los datos del usuario
function obtenerUsuario($userID) {
    $conexion = connection();

    $sql = "SELECT * FROM usuarios WHERE UsuarioID = $userID";
    $resultado = mysqli_query($conexion, $sql);

    // Verificar si se encontraron resultados
    if ($resultado && mysqli_num_rows($resultado) > 0) {
        // Obtener los datos del usuario
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_close($conexion); // Cerrar la conexión
        return $usuario;
    } else {
        mysqli_close($conexion); // Cerrar la conexión
        return false; // Usuario no encontrado
    }
}

// Obtener el ID de usuario de la sesión actual
$userID = $_SESSION['UsuarioID'];

// Obtener los datos del usuario actual
$usuario = obtenerUsuario($userID);

// Verificar si la consulta fue exitosa
if (!$usuario) {
    // Manejar el caso en el que no se pudo obtener los datos del usuario
    echo "Error: No se pudieron obtener los datos del usuario.";
    exit();
}

// Consultar las reseñas sobre el usuario actual
$conexion = connection();
$sql_resenas = "SELECT r.Calificacion, r.Comentario, r.FechaResena, u.Nombre
                              FROM resenas r
                              INNER JOIN usuarios u ON r.UsuarioID = u.UsuarioID
                              WHERE r.ProfesionistaID = (SELECT ProfesionistaID FROM profesionistas WHERE UsuarioID=$userID)";
$resultado_resenas = mysqli_query($conexion, $sql_resenas);

// Verificar si la consulta de reseñas fue exitosa
if (!$resultado_resenas) {
    // Manejar el caso en el que no se pudieron obtener las reseñas
    echo "Error: No se pudieron obtener las reseñas.";
    mysqli_close($conexion);
    exit();
}

// Consultar los profesionistas contratados por el usuario actual y sus datos de contacto
$sql_contrataciones = "SELECT p.Nombre, p.Profesion, p.Costo, c.Correo, c.Telefono, p.ProfesionistaID
                        FROM contrataciones con
                        INNER JOIN profesionistas p ON con.ProfesionistaID = p.ProfesionistaID
                        INNER JOIN datoscontactoprofesionista c ON p.ProfesionistaID = c.ProfesionistaID
                        WHERE con.UsuarioID = $userID";
$resultado_contrataciones = mysqli_query($conexion, $sql_contrataciones);

// Consultar los usuarios que han contratado al profesionista vinculado al usuario en la sesión
$sql_usuarios_contrataron = "SELECT u.Nombre, u.Correo, dcu.Telefono, dcu.Direccion
                             FROM contrataciones co
                             INNER JOIN usuarios u ON co.UsuarioID = u.UsuarioID
                             INNER JOIN datoscontactousuario dcu ON u.UsuarioID = dcu.UsuarioID
                             WHERE co.ProfesionistaID = (SELECT ProfesionistaID FROM profesionistas WHERE UsuarioID=$userID)";
$resultado_usuarios_contrataron = mysqli_query($conexion, $sql_usuarios_contrataron);


// Verificar si la consulta de contrataciones fue exitosa
if (!$resultado_contrataciones) {
    // Manejar el caso en el que no se pudieron obtener las contrataciones
    echo "Error: No se pudieron obtener las contrataciones.";
    mysqli_close($conexion);
    exit();
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap JS y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            padding-top: 20px;
        }
        .profile-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            border-left: 10px solid #007bff;
        }
        .profile-card h1 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #007bff;
        }
        .profile-card p {
            font-size: 18px;
            margin-bottom: 15px;
            color: #666666;
        }
        .profile-card strong {
            font-weight: bold;
            color: #333333;
        }
        .profile-picture {
            max-width: 200px;
            border-radius: 50%;
            display: block;
            margin: 0 auto 20px auto;
        }
        .reseñas {
            margin-top: 30px;
        }
        .reseñas h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #007bff;
        }
        .reseña {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }
        .reseña p {
            margin-bottom: 10px;
        }
        .stars {
            color: #FFD700;
        }
        .contrataciones {
            margin-top: 30px;
        }
        .contrataciones h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #007bff;
        }
        .card {
            margin-bottom: 20px;
            border-left: 5px solid #007bff;
        }
        .card-body {
            position: relative;
        }
        .btn-eliminar {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004080;
        }
        .btn-danger {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
        .btn-danger:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }
    </style>
</head>
<body>
    <?php include('navbar.php')?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="profile-card">
                    <h1>Perfil de Usuario</h1>
                    <?php if ($usuario['FotoPerfil']) : ?>
                        <img src="<?php echo $usuario['FotoPerfil']; ?>" alt="Foto de perfil" class="profile-picture">
                    <?php else : ?>
                        <p><strong>Foto de perfil:</strong> No hay foto de perfil disponible.</p>
                    <?php endif; ?>                
                    <p><strong>Nombre de usuario:</strong> <?php echo $usuario['Usuario']; ?></p>
                    <p><strong>Correo electrónico:</strong> <?php echo $usuario['Correo']; ?></p>
                    <p><strong>Nombre:</strong> <?php echo $usuario['Nombre']; ?></p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Mostrar reseñas -->
                <div class="reseñas">
                    <h2>Reseñas</h2>
                    <?php
                    if (mysqli_num_rows($resultado_resenas) > 0) {
                        while ($resena = mysqli_fetch_assoc($resultado_resenas)) {
                            echo "<div class='card'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>Calificación: ";
                            for ($i = 0; $i < $resena['Calificacion']; $i++) {
                                echo "★"; // Mostrar estrella
                            }
                            echo "</h5>";
                            echo "<p class='card-text'>Comentario: " . $resena['Comentario'] . "</p>";
                            echo "<p class='card-text'>Fecha de reseña: " . $resena['FechaResena'] . "</p>";
                            echo "</div></div>";
                        }
                    } else {
                        echo "<p>No hay reseñas disponibles.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
                    <!-- Mostrar usuarios que han contratado al profesionista -->
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2>Usuarios que han contratado este profesionista</h2>
                <?php
                if (mysqli_num_rows($resultado_usuarios_contrataron) > 0) {
                    while ($contratacion = mysqli_fetch_assoc($resultado_usuarios_contrataron)) {
                        echo "<div class='card'>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>Nombre: {$contratacion['Nombre']}</h5>";
                        echo "<p class='card-text'>Correo: {$contratacion['Correo']}</p>";
                        echo "<p class='card-text'>Teléfono: {$contratacion['Telefono']}</p>";
                        echo "<p class='card-text'>Dirección: {$contratacion['Direccion']}</p>";
                        echo "</div></div>";
                    }
                } else {
                    echo "<p>No hay usuarios que hayan contratado a este profesionista.</p>";
                }
                ?>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Mostrar profesionistas contratados -->
                <div class="contrataciones">
                    <h2>Profesionistas contratados</h2>
                    <?php
                    if (mysqli_num_rows($resultado_contrataciones) > 0) {
                        while ($contratacion = mysqli_fetch_assoc($resultado_contrataciones)) {
                            echo "<div class='card'>";
                            echo "<div class='card-body'>";
                            echo "<h5 class='card-title'>Nombre: {$contratacion['Nombre']}</h5>";
                            echo "<p class='card-text'>Profesión: {$contratacion['Profesion']}</p>";
                            echo "<p class='card-text'>Costo: $ {$contratacion['Costo']}</p>";
                            echo "<p class='card-text'>Correo: {$contratacion['Correo']}</p>";
                            echo "<p class='card-text'>Teléfono: {$contratacion['Telefono']}</p>";
                            // Formulario para eliminar contratación
                            echo "<form method='post' action='eliminar_contratacion.php' class='btn-eliminar'>";
                            echo "<input type='hidden' name='profesionistaID' value='{$contratacion['ProfesionistaID']}'>";
                            echo "<button type='submit' class='btn btn-danger btn-sm'>Eliminar contratación</button>";
                            echo "</form>";
                            echo "</div></div>";
                        }
                    } else {
                        echo "<p>No has contratado a ningún profesionista.</p>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
