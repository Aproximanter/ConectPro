<?php
// Función para generar el HTML de las estrellas de calificación
function generarEstrella($calificacion) {
    // Si la calificación es menor o igual a 0, no mostrar ninguna estrella
    if ($calificacion <= 0) {   
        return '';
    }

    // Si la calificación es mayor que 5, establecerla en 5
    if ($calificacion > 5) {
        $calificacion = 5;
    }

    $html = '<div class="rating">';
    // Generar estrellas según la calificación
    for ($i = 1; $i <= $calificacion; $i++) {
        $html .= '<i class="bi bi-star-fill" style="color: yellow;"></i>'; // Icono de estrella llena
    }
    $html .= '</div>';
    return $html;
}

include 'conexion_bd.php';

// Obtenemos la conexión a la base de datos
$con = connection();

// Consulta SQL para obtener todos los profesionistas con su calificación promedio, ordenados por la calificación promedio de mayor a menor
$sql = "SELECT p.*, p.FotoPerfil, AVG(r.Calificacion) AS CalificacionPromedio
        FROM profesionistas p
        LEFT JOIN resenas r ON p.ProfesionistaID = r.ProfesionistaID
        GROUP BY p.ProfesionistaID
        ORDER BY CalificacionPromedio DESC";

$resultado = mysqli_query($con, $sql);

if (mysqli_num_rows($resultado) > 0) {
    // Mostramos una tarjeta para cada profesionista
    while ($fila = mysqli_fetch_assoc($resultado)) {
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
        // Mostrar las estrellas de calificación
        echo generarEstrella($fila["CalificacionPromedio"]);
        // Mostrar la calificación en número al lado de las estrellas
        echo '<span class="ml-2">' . number_format($fila["CalificacionPromedio"], 1) . '</span>';
        echo '</div>';
        echo '</div>';
        echo '<div class="d-flex justify-content-center mb-2">';
        echo '<button class="btn btn-success btn-contratar mr-2 ml-2"  data-toggle="modal" data-target="#myModal" data-profesionista-id="' . $fila["ProfesionistaID"] . '">Contratar</button>';

        echo '<button class="btn btn-primary btn-agregar-comentario mr-2" data-toggle="modal" data-target="#modalAgregarComentario" data-profesionista-id="' . $fila["ProfesionistaID"] . '">Agregar Comentario</button>';
        echo '<button class="btn btn-primary btn-ver-comentario mr-2" data-toggle="modal" data-target="#modalComentarios" data-profesionista-id="' . $fila["ProfesionistaID"] . '">Ver Comentarios</button>';
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
        img:hover {
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

        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: center;
        }

        .rating input {
            display: none;
        }

        .rating label {
            display: inline-block;
            padding: 5px;
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
        }

        .rating input:checked ~ label {
            color: #f90;
        }
    </style>
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css" rel="stylesheet"> <!-- Agrega la biblioteca de iconos Bootstrap -->
</head>
<body>


<!-- Modal de Comentarios -->
<div class="modal fade" id="modalComentarios" tabindex="-1" role="dialog" aria-labelledby="modalComentariosLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalComentariosLabel">Comentarios y Calificaciones</h5>
               <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Aquí se cargarán los comentarios y calificaciones mediante AJAX -->
                <div id="comentariosContainer">
                    <!-- Contenido dinámico -->
                </div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Vas a contratar a </h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="profesionistaDetails">
                <!-- Aquí se cargarán los detalles del profesionista mediante AJAX -->
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <form id="formContratar">
                    <!-- Campos del formulario de transacción -->
                    <input type="hidden" id="profesionistaIdContratar" name="profesionistaId" value="">
                    
                    <button type="submit" class="btn btn-primary btn-confirmar">Confirmar</button>
                </form>
                
            </div>
        </div>
    </div>
</div>



<!-- Modal Coments -->
<div class="modal fade" id="modalAgregarComentario" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar Comentario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <form id="formAgregarComentario">
                    <div class="form-group">
                        <label for="calificacion">Calificación:</label>
                        <div class="rating">
                            <input type="radio" name="star" id="star5" value="5"><label for="star5">&#9733;</label>
                            <input type="radio" name="star" id="star4" value="4"><label for="star4">&#9733;</label>
                            <input type="radio" name="star" id="star3" value="3"><label for="star3">&#9733;</label>
                            <input type="radio" name="star" id="star2" value="2"><label for="star2">&#9733;</label>
                            <input type="radio" name="star" id="star1" value="1"><label for="star1">&#9733;</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="3"></textarea>
                    </div>
                    <!-- Campo oculto para almacenar el ID del profesionista -->
                    <input type="hidden" id="profesionistaIdComentario" name="profesionistaId" value="">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
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
        // Establecer el ID del profesionista en el campo oculto
        $('#profesionistaIdContratar').val(profesionistaId);
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

        // Manejar el clic en el botón "Agregar Comentario"
        $('.btn-agregar-comentario').click(function(e) {
            e.preventDefault(); // Evitar el comportamiento predeterminado del botón
            // Obtener el ID del profesionista
            var profesionistaId = $(this).data('profesionista-id');
            // Asignar el ID del profesionista al campo hidden en el modal
            $('#profesionistaIdComentario').val(profesionistaId);
            // Mostrar el modal para agregar comentario
            $('#modalAgregarComentario').modal('show');
        });
    });

    

$(document).ready(function() {
    // Manejar el clic en el botón "Ver Comentarios"
    $('.btn-ver-comentario').click(function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del botón
        // Obtener el ID del profesionista
        var profesionistaId = $(this).data('profesionista-id');
        // Realizar la solicitud AJAX para obtener los comentarios y calificaciones del profesionista
        $.ajax({
            url: 'obtener_comentarios.php', // Asegúrate de tener un script PHP que maneje esta solicitud y devuelva los datos adecuados
            type: 'POST',
            data: { profesionista_id: profesionistaId },
            success: function(response) {
                // Manejar la respuesta del servidor (por ejemplo, cargar los comentarios en el modal correspondiente)
                $('#comentariosContainer').html(response);
                $('#modalComentarios').modal('show');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});

    $(document).ready(function(){
        $('#formAgregarComentario').submit(function(e){ // Cambiar a $('#formAgregarComentario').submit(...)
            e.preventDefault(); // Evitar el comportamiento predeterminado del formulario
            
            // Verificar el ID del profesionista antes de enviar el formulario
            var profesionistaId = $('#profesionistaIdComentario').val();
            console.log("ID del profesionista:", profesionistaId);
            
            // Continuar con el envío del formulario mediante AJAX
            $.ajax({
                url: 'guardar_comentarios.php',
                type: 'post',
                data: $(this).serialize(), // Cambiar a $(this).serialize()
                success: function(response){
                    alert(response);
                    // Aquí puedes agregar más lógica según necesites, como cerrar el modal, mostrar un mensaje, etc.
                },
                error: function(xhr, status, error){
                    alert('Error al enviar el comentario: ' + error);
                }
            });
        });
    });


    $(document).ready(function() {
    // Manejar el envío del formulario de contratación
    $('#formContratar').submit(function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del formulario
        var profesionistaId = $('#profesionistaIdContratar').val();
            console.log("ID del profesionista:", profesionistaId);
     
        $.ajax({
            url: 'guardar_transaccion.php', // Ruta al archivo PHP que procesará la contratación
            type: 'post',
            data: $(this).serialize(), // Serializar los datos del formulario
            success: function(response){
                alert(response); // Mostrar respuesta del servidor (por ejemplo, "Contratación exitosa")
                $('#myModal').modal('hide'); // Cerrar el modal después de la contratación
            },
            error: function(xhr, status, error){
                alert('Error al realizar la contratación: ' + error); // Mostrar mensaje de error en caso de falla
            }
        });
    });
});
</script>

<script>
    $(document).ready(function() {
        // Manejar el clic en el botón "Cerrar" del modal de Detalles del Profesionista
        $('#myModal .close').click(function() {
            // Cerrar el modal
            $('#myModal').modal('hide');
        });

        // Manejar el clic en el botón "Cerrar" del modal de Agregar Comentario
        $('#modalAgregarComentario .close').click(function() {
            // Cerrar el modal
            $('#modalAgregarComentario').modal('hide'); 
        });
        
        $('#modalComentarios .close').click(function() {
            // Cerrar el modal
            $('#modalComentarios').modal('hide'); 
        });
    });
    
    
</script>

</body>
</html>
