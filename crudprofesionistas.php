<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <title>CRUD Profesionistas</title>
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

<div class="container">
    <h1>CRUD Profesionistas</h1>
    <!-- Formulario para crear profesionista -->
    <form method="post" action="insert_profesionista.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="profesion" class="form-label">Profesión:</label>
            <input type="text" class="form-control" id="profesion" name="profesion" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
        </div>

         <div class="mb-3">
        <label for="costo" class="form-label">Costo:</label>
        <input type="number" step="0.01" class="form-control" id="costo" name="costo" required>
    </div>

    
        <div class="mb-3">
        <label for="foto_perfil" class="form-label">Foto de Perfil:</label>
        <input type="file" class="form-control" id="foto_perfil" name="foto_perfil">
    </div>

        
        
         <button type="submit" class="btn btn-primary" name="crear_profesionista">Crear Profesionista</button>

    </form>

    <!-- Formulario para editar profesionista -->
<form method="post" action="update_profesionista.php" class="edit-form" enctype="multipart/form-data">
    <input type="hidden" name="profesionistaID" id="edit-profesionistaID">
    <div class="mb-3">
        <label for="edit-nombre" class="form-label">Nombre:</label>
        <input type="text" class="form-control" id="edit-nombre" name="nombre" required>
    </div>
    <div class="mb-3">
        <label for="edit-profesion" class="form-label">Profesión:</label>
        <input type="text" class="form-control" id="edit-profesion" name="profesion" required>
    </div>
    <div class="mb-3">
        <label for="edit-costo" class="form-label">Costo:</label>
        <input type="text" class="form-control" id="edit-costo" name="costo" required>
    </div>
    <div class="mb-3">
        <label for="edit-descripcion" class="form-label">Descripción:</label>
        <textarea class="form-control" id="edit-descripcion" name="descripcion" required></textarea>
    </div>
    <div class="mb-3">
        <label for="edit-foto_perfil" class="form-label">Foto de Perfil:</label>
        <input type="file" class="form-control" id="edit-foto_perfil" name="foto_perfil">
        <!-- La vista previa de la foto de perfil se manejará mediante JavaScript -->
        <img id="edit-foto_perfil-preview" src="" alt="Vista previa de la foto de perfil" style="max-width: 100px; max-height: 100px;">
    </div>
    <button type="submit" class="btn btn-primary" name="editar_profesionista">Guardar Cambios</button>
    <button type="button" class="btn btn-secondary cancelar-edicion">Cancelar</button>
</form>

   <!-- Tabla para mostrar profesionistas actuales -->
<h2>Profesionistas Actuales</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Profesión</th>
            <th>Descripción</th>
            <th>Foto de Perfil</th>
            <th>Costo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Consulta para obtener profesionistas
        $sql = "SELECT * FROM profesionistas";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ProfesionistaID'] . "</td>";
                echo "<td>" . $row['Nombre'] . "</td>";
                echo "<td>" . $row['Profesion'] . "</td>";
                echo "<td>" . $row['Descripcion'] . "</td>";
                // Mostrar la foto de perfil como imagen
                echo "<td><img src='" . $row['FotoPerfil'] . "' alt='Foto de Perfil' style='max-width: 100px; max-height: 100px;'></td>";
                // Mostrar el costo
                echo "<td>$" . $row['Costo'] . "</td>";
                echo "<td>
                <button type='button' class='btn btn-primary editar-profesionista' data-id='" . $row['ProfesionistaID'] . "' data-nombre='" . $row['Nombre'] . "' data-profesion='" . $row['Profesion'] . "' data-descripcion='" . $row['Descripcion'] . "' data-foto_perfil='" . $row['FotoPerfil'] . "' data-costo='" . $row['Costo'] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Editar'><i class='bi bi-pencil'></i></button>
                <button type='button' class='btn btn-danger eliminar-profesionista' data-id='" . $row['ProfesionistaID'] . "' data-bs-toggle='tooltip' data-bs-placement='top' title='Eliminar'><i class='bi bi-x'></i></button>
              </td>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay profesionistas registrados</td></tr>";
        }
        ?>
    </tbody>
</table>
</table>
</div>

<script>

$(".eliminar-profesionista").click(function() {
        var confirmacion = confirm("¿Estás seguro de que quieres eliminar este profesionista?");
        if (confirmacion) {
            var idProfesionista = $(this).data('id');
            // Realizar una petición AJAX para eliminar el profesionista
            $.ajax({
                type: "POST",
                url: "delete_profesionista.php",
                data: { action: 'eliminar', profesionistaID: idProfesionista },
                success: function(response) {
                    // Recargar la página para actualizar la tabla de profesionistas
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert("Error al eliminar el profesionista.");
                }
            });
        }
    });

  

    // Manejar cancelar edición
   
</script>
<script>
// Manejar edición de profesionista al hacer clic en "Editar"
$(".editar-profesionista").click(function() {
    var idProfesionista = $(this).data('id');
    var nombre = $(this).data('nombre');
    var profesion = $(this).data('profesion');
    var descripcion = $(this).data('descripcion');
    var costo = $(this).data('costo');
    var foto_perfil = $(this).data('foto_perfil');

    $("#edit-profesionistaID").val(idProfesionista);
    $("#edit-nombre").val(nombre);
    $("#edit-profesion").val(profesion);
    $("#edit-costo").val(costo);
    $("#edit-descripcion").val(descripcion);

    // Mostrar la vista previa de la imagen actual
    $("#edit-foto_perfil-preview").attr("src", foto_perfil);

    $(".edit-form").show();
    
     $(".cancelar-edicion").click(function() {
        $(".edit-form").hide();
    });
});
</script>
</body>
</html>
