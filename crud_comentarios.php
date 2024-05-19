<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();
?> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Comentarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" rel="stylesheet"> <!-- Agrega la biblioteca de iconos Bootstrap -->
</head>
<body>
<?php include('navbarcrood.php');?> 
<div class="container">
    <h1>CRUD Comentarios</h1>
    <!-- Formulario para crear comentario -->
    <form method="post" action="insert_comentario.php">
        <div class="mb-3">
            <label for="profesionista_id" class="form-label">ID del Profesionista:</label>
            <input type="text" class="form-control" id="profesionista_id" name="profesionista_id" required>
        </div>
        <div class="mb-3">
            <label for="usuario_id" class="form-label">ID del Usuario:</label>
            <input type="text" class="form-control" id="usuario_id" name="usuario_id" required>
        </div>
        <div class="mb-3">
            <label for="calificacion" class="form-label">Calificación:</label>
            <input type="number" class="form-control" id="calificacion" name="calificacion" min="1" max="5" required>
        </div>
        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario:</label>
            <textarea class="form-control" id="comentario" name="comentario" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="crear_comentario">Crear Comentario</button>
    </form>

    <!-- Tabla para mostrar comentarios -->
    <h2>Comentarios Actuales</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>ID del Profesionista</th>
                <th>ID del Usuario</th>
                <th>Calificación</th>
                <th>Comentario</th>
                <th>Fecha de Reseña</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            
            // Consulta para obtener comentarios
            $sql_comentarios = "SELECT * FROM resenas";
            $result_comentarios = $conexion->query($sql_comentarios);
            if ($result_comentarios->num_rows > 0) {
                while($row_comentario = $result_comentarios->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row_comentario['ResenaID'] . "</td>";
                    echo "<td>" . $row_comentario['ProfesionistaID'] . "</td>";
                    echo "<td>" . $row_comentario['UsuarioID'] . "</td>";
                    echo "<td>" . $row_comentario['Calificacion'] . "</td>";
                    echo "<td>" . $row_comentario['Comentario'] . "</td>";
                    echo "<td>" . $row_comentario['FechaResena'] . "</td>";
                    echo "<td>
                        <button type='button' class='btn btn-primary editar-comentario' data-id='" . $row_comentario['ResenaID'] . "' data-profesionista-id='" . $row_comentario['ProfesionistaID'] . "' data-usuario-id='" . $row_comentario['UsuarioID'] . "' data-calificacion='" . $row_comentario['Calificacion'] . "' data-comentario='" . $row_comentario['Comentario'] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar'><i class='bi bi-pencil'></i></button>
                        <button type='button' class='btn btn-danger eliminar-comentario' data-id='" . $row_comentario['ResenaID'] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar'><i class='bi bi-x'></i></button>
                    </td>";
                }
            } else {
                echo "<tr><td colspan='7'>No hay comentarios registrados</td></tr>";
            }
            ?>
          
        </tbody>
    </table>

    <!-- Formulario para editar comentario -->
    <form method="post" action="update_comentario.php" class="edit-form">
        <input type="hidden" name="resenaID" id="edit-resenaID">
        <div class="mb-3">
            <label for="edit-profesionista_id" class="form-label">ID del Profesionista:</label>
            <input type="text" class="form-control" id="edit-profesionista_id" name="profesionista_id" required>
        </div>
        <div class="mb-3">
            <label for="edit-usuario_id" class="form-label">ID del Usuario:</label>
            <input type="text" class="form-control" id="edit-usuario_id" name="usuario_id" required>
        </div>
        <div class="mb-3">
            <label for="edit-calificacion" class="form-label">Calificación:</label>
            <input type="number" class="form-control" id="edit-calificacion" name="calificacion" min="1" max="5" required>
        </div>
        <div class="mb-3">
            <label for="edit-comentario" class="form-label">Comentario:</label>
            <textarea class="form-control" id="edit-comentario" name="comentario" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="editar_comentario">Guardar Cambios</button>
        <button type="button" class="btn btn-secondary cancelar-edicion">Cancelar</button>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

<script>
    // Manejar edición de comentario al hacer clic en "Editar"
    $(".editar-comentario").click(function() {
        var idComentario = $(this).data('id');
        var profesionistaID = $(this).data('profesionista-id');
        var usuarioID = $(this).data('usuario-id');
        var calificacion = $(this).data('calificacion');
        var comentario = $(this).data('comentario');

        $("#edit-resenaID").val(idComentario);
        $("#edit-profesionista_id").val(profesionistaID);
        $("#edit-usuario_id").val(usuarioID);
        $("#edit-calificacion").val(calificacion);
        $("#edit-comentario").val(comentario);

        $(".edit-form").show();
    });

    // Manejar cancelar edición
    $(".cancelar-edicion").click(function() {
        $(".edit-form").hide();
    });

  


    $(".eliminar-comentario").click(function() {
        var confirmacion = confirm("¿Estás seguro de que quieres eliminar este comentario?");
        if (confirmacion) {
            var idComentario = $(this).data('id');
            // Realizar una petición AJAX para eliminar el profesionista
            $.ajax({
    type: "POST",
    url: "delete_comentario.php",
    data: { action: 'eliminar', resenaID: idComentario }, // Corregido
    success: function(response) {
        // Recargar la página para actualizar la tabla de profesionistas
        location.reload();
    },
    error: function(xhr, status, error) {
        console.error(error);
        alert("Error al eliminar el Comentario.");
    }
});

        }
    });
</script>

</body>
</html>
