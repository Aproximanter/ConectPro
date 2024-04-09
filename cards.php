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
        echo '<div class="container">';
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
        echo '<a href="#" class="btn btn-primary">Contratar</a>';
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
    <script src="js/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container">
    <div class="card border-dark mb-2">
        <div class="card-body d-flex">
            <div class="mr-3">
                <img class="rounded-circle img-fluid" src="https://upload.wikimedia.org/wikipedia/commons/b/bf/Foto_Perfil_.jpg" alt="Foto de perfil" style="max-width: 150px; max-height: 150px;">
            </div>
            <div class="ml-3">
                <h5 class="card-title">Nombre</h5>
                <h6 class="card-subtitle mb-2 text-muted">Profesión</h6>
                <p class="card-text">Descripción de la persona</p>
                
            </div>
        </div>
        <div class="d-flex justify-content-center mb-2">
            <a href="#" class="btn btn-primary">Contratar</a>
        </div>
        <!-- Logo Profesionista -->
        <div class="ml-auto" style="ml-auto mr-4 d-flex">
    <img class="rounded-circle img-fluid logo-profesional" src="" alt="Logo del profesional" style="max-width: 75px; max-height: 75px;">
</div>


        <div class="text-center">
            <img src="https://www.ludusglobal.com/hubfs/Riesgo-el%C3%A9ctrico-en-el-trabajo.jpg#keepProtocol" class="card-img-top rounded img-fluid mb-3 click-to-zoom" alt="..." style="max-width: 150px; max-height: 150px; margin-right: 20px; margin-lefth: 20px;">
            <img src="https://www.ludusglobal.com/hubfs/Riesgo-el%C3%A9ctrico-en-el-trabajo.jpg#keepProtocol" class="card-img-top rounded img-fluid mb-3 click-to-zoom" alt="..." style="max-width: 150px; max-height: 150px; margin-right: 20px;">
            <img src="https://www.ludusglobal.com/hubfs/Riesgo-el%C3%A9ctrico-en-el-trabajo.jpg#keepProtocol" class="card-img-top rounded img-fluid mb-3 click-to-zoom" alt="..." style="max-width: 150px; max-height: 150px; margin-right: 20px;">
            <img src="https://www.ludusglobal.com/hubfs/Riesgo-el%C3%A9ctrico-en-el-trabajo.jpg#keepProtocol" class="card-img-top rounded img-fluid mb-3 click-to-zoom" alt="..." style="max-width: 150px; max-height: 150px; margin-right: 20px;">
        </div>
    </div>
</div>


<!-- Asegúrate de incluir jQuery antes de este script -->
<script>
    $(document).ready(function() {
        // Utiliza PHP para obtener la profesión del profesional desde la base de datos
        <?php
            // Conecta a la base de datos (asegúrate de manejar las conexiones de forma segura)
            $conexion = new mysqli("localhost", "root", "", "conectpro");

            // Verifica la conexión
            if ($conexion->connect_error) {
                die("La conexión a la base de datos ha fallado: " . $conexion->connect_error);
            }

            // Ejecuta la consulta para obtener la profesión del profesional
            $profesionistaID = 1; // Reemplaza esto con el ID del profesional actual
            $consulta = "SELECT Profesion FROM profesionistas WHERE ProfesionistaID = $profesionistaID";
            $resultado = $conexion->query($consulta);

            // Verifica si se obtuvo un resultado
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                $profesion = $fila['Profesion'];

                // Imprime la profesión como variable de JavaScript
                echo "var profesion = '$profesion';";
            }

            // Cierra la conexión
            $conexion->close();
        ?>

        // Switch para establecer la imagen del logo según la profesión
        switch (profesion) {
            case "plomero":
                $(".logo-profesional").attr("src", "https://images.vexels.com/media/users/3/129025/isolated/preview/1ff74bbbb9d5e2e296811ba970f2bbfe-simbolo-del-grifo-de-agua-svg.png");
                break;
            // Agrega más casos según las profesiones que desees manejar
        }

        // Agrega el código para el evento click-to-zoom aquí
        $('.click-to-zoom').click(function() {
            $(this).toggleClass('enlarged');
        });
    });
</script>


</body>
</html>
