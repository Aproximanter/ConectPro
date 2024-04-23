<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

    <title>CRUD Usuarios</title>
    <style>
        .edit-form {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
            z-index: 9999;
        }
    </style>
</head>
<body>
<?php include('navbarcrood.php');?> 
<?php
include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();
?> 


<?php

// Verificar si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    // Mostrar un mensaje de error y redirigir al usuario a la página de inicio de sesión
    echo "<script>alert('Debes iniciar sesión para acceder a esta página.'); window.location.href = 'login.php';</script>";
    exit(); // Finalizar el script para evitar que se siga ejecutando el código
}

// Obtener el nivel del usuario actual desde la base de datos
$usuarioID = $_SESSION['UsuarioID'];
$sql = "SELECT Nivel FROM usuarios WHERE UsuarioID = '$usuarioID'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $nivel = $fila['Nivel'];

    // Almacenar el nivel del usuario en una variable de sesión
    $_SESSION['nivel'] = $nivel;
} else {
    // Mostrar un mensaje de error y redirigir al usuario a una página de error de usuario
    echo "<script>alert('Error: No se pudo encontrar la información del usuario.'); window.location.href = 'error_usuario.php';</script>";
    exit(); // Finalizar el script para evitar que se siga ejecutando el código
}

// Verificar si el usuario tiene nivel de administrador
if ($_SESSION['nivel'] !== 'admin') {
    // Mostrar un mensaje de error y redirigir al usuario a una página de acceso denegado
    echo "<script>alert('Acceso denegado: No tienes permiso para acceder a esta página.'); window.location.href = 'index.php';</script>";
    exit(); // Finalizar el script para evitar que se siga ejecutando el código
}
?>



<div class="container">
    <h1>CRUD Usuarios</h1>
    <!-- Formulario para crear usuario -->
    <form method="post" action="insert_user.php">
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuario:</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
        </div>
        <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña:</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <button type="submit" class="btn btn-primary" name="crear_usuario">Crear Usuario</button>
    </form>

    <!-- Formulario para editar usuario -->
    <form method="post" action="update_user.php" class="edit-form">
        <input type="hidden" name="usuarioID" id="edit-usuarioID">
        <div class="mb-3">
            <label for="edit-usuario" class="form-label">Usuario:</label>
            <input type="text" class="form-control" id="edit-usuario" name="usuario" required>
        </div>
        <div class="mb-3">
            <label for="edit-correo" class="form-label">Correo:</label>
            <input type="email" class="form-control" id="edit-correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="edit-nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
        </div>
        <button type="submit" class="btn btn-primary" name="editar_usuario">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary cancelar-edicion">Cancelar</button>
    </form>

    <!-- Tabla para mostrar usuarios actuales -->
    <h2>Usuarios Actuales</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Correo</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para obtener usuarios
            $sql = "SELECT * FROM usuarios";
            $result = $conexion->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['UsuarioID'] . "</td>";
                    echo "<td>" . $row['Usuario'] . "</td>";
                    echo "<td>" . $row['Correo'] . "</td>";
                    echo "<td>" . $row['Nombre'] . "</td>";
                    echo "<td>
                    <button type='button' class='btn btn-primary editar-usuario' data-id='" . $row['UsuarioID'] . "' data-usuario='" . $row['Usuario'] . "' data-correo='" . $row['Correo'] . "' data-nombre='" . $row['Nombre'] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar'><i class='bi bi-pencil'></i></button>
                    <button type='button' class='btn btn-danger eliminar-usuario' data-id='" . $row['UsuarioID'] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar'><i class='bi bi-x'></i></button>
                  </td>";

                  
                }
            } else {
                echo "<tr><td colspan='5'>No hay usuarios registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>

$(".eliminar-usuario").click(function() {
        var confirmacion = confirm("¿Estás seguro de que quieres eliminar este usuario?");
        if (confirmacion) {
            var idUsuario = $(this).data('id');
            // Realizar una petición AJAX para eliminar el usuario
            $.ajax({
                type: "POST",
                url: "delete_user.php",
                data: { action: 'eliminar', usuarioID: idUsuario },
                success: function(response) {
                    // Recargar la página para actualizar la tabla de usuarios
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("Error al eliminar el usuario.");
                }
            });
        }
    });

    // Manejar edición de usuario al hacer clic en "Editar"
    $(".editar-usuario").click(function() {
        var idUsuario = $(this).data('id');
        var usuario = $(this).data('usuario');
        var correo = $(this).data('correo');
        var nombre = $(this).data('nombre');

        $("#edit-usuarioID").val(idUsuario);
        $("#edit-usuario").val(usuario);
        $("#edit-correo").val(correo);
        $("#edit-nombre").val(nombre);

        $(".edit-form").show();
    });

    // Manejar cancelar edición
    $(".cancelar-edicion").click(function() {
        $(".edit-form").hide();
    });
</script>

</body>
</html>