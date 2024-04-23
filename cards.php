<?php
include 'conexion_bd.php';

// Obtenemos la conexión a la base de datos
$con = connection();

// Consulta SQL para obtener todos los profesionistas
$sql = "SELECT p.*, p.FotoPerfil 
        FROM profesionistas p";

$resultado = mysqli_query($con, $sql);

if (mysqli_num_rows($resultado) > 0) {
    // Mostramos una tarjeta para cada profesionista
    while ($fila = mysqli_fetch_assoc($resultado)) {
        // Añadimos un atributo data-profesion con la información de la profesión
        echo '<div class="container professional-card" data-profesion="' . $fila["Profesion"] . '">';
        echo '<div class="card border-dark mb-2">';
        echo '<div class="card-body d-flex">';
        echo '<div class="mr-3">';
        // Verifica si hay una foto de perfil disponible
        if (!empty($fila["FotoPerfil"])) {
            echo '<img class="rounded-circle img-fluid" src="' . $fila["FotoPerfil"] . '" alt="Foto de perfil" style="max-width: 150px; max-height: 150px;">';
        } else {
            echo '<img class="rounded-circle img-fluid" src="https://definicion.de/wp-content/uploads/2019/07/perfil-de-usuario.png" alt="Foto de perfil por defecto" style="max-width: 150px; max-height: 150px;">';
        }
        echo '</div>';
        echo '<div class="ml-3">';
        echo '<h5 class="card-title">' . $fila["Nombre"] . '</h5>';
        echo '<h6 class="card-subtitle mb-2 text-muted">' . $fila["Profesion"] . '</h6>';
        echo '<p class="card-text">' . $fila["Descripcion"] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<div class="d-flex justify-content-center mb-2">';
        // Asegúrate de pasar la profesión al botón "Contratar"
       // Asegúrate de pasar el ID del profesionista al botón "Contratar"
echo '<button class="btn btn-primary btn-contratar" data-toggle="modal" data-target="#myModal" data-profesionista-id="' . $fila["ProfesionistaID"] . '">Contratar</button>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "No hay profesionistas en la base de datos.";
}

// Cerramos la conexión
mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>

        img:hover{

          transform: scale(1.6);
          transition: 1s;
        }

        .click-to-zoom {
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }

        .click-to-zoom.enlarged {
            transform: scale(1.5); /* Ajusta el factor de escala según tu preferencia */
        }
    </style>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" rel="stylesheet"> <!-- Agrega la biblioteca de iconos Bootstrap -->
</head>
<body>

<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Detalles del Profesionista</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body" id="profesionistaDetails">
                <!-- Aquí se cargarán los detalles del profesionista mediante AJAX -->
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" >Pagar con PayPal</button>
            </div>

        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Manejar el clic en el botón "Contratar"
    $('.btn-contratar').click(function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del botón

        // Obtener el ID del profesionista
        var profesionistaId = $(this).data('profesionista-id');

        // Realizar la solicitud AJAX para obtener los datos del profesionista
        $.ajax({
            url: 'obtener_datos_profesionista.php',
            type: 'POST',
            data: { profesionista_id: profesionistaId },
            success: function(response) {
                // Manejar la respuesta del servidor (por ejemplo, mostrar los datos en un modal)
                $('#profesionistaDetails').html(response);
                $('#myModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});


</script>

</body>
</html>
