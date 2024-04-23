<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <style>
        /* Puedes agregar estilos personalizados aquí */
        .search-bar {
            max-width: 400px;
            margin: auto;
        }
        .search-bar input[type="search"] {
            border-radius: 20px;
        }
        .search-bar button {
            border-radius: 20px;
        }
    </style>
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container-fluid bg-danger text-white text-center py-5">
    <h1 class="display-1 text-center">Bienvenido</h1>
    
    <!-- Barra de búsqueda compacta -->
    <div class="container mt-4 search-bar">
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Buscar profesionales" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
    </div>
</div>

<div class="container px-4">
    <div class="row gx-5">
        <p class="lead border bg-light">
            <?php include('cards.php'); ?>
        </p>
    </div>
</div>

<div class="container-fluid text-center">
    <button type="button" id="entrar" class="btn btn-primary btn-lg">Iniciar sesión</button>
</div>

<script>
    document.getElementById('entrar').addEventListener('click', function() {
        window.open('login.php', '_blank');
    });
</script>
<script>
$(document).ready(function() {
    // Manejar el envío del formulario de búsqueda
    $('.search-bar form').submit(function(e) {
        e.preventDefault(); // Evitar el comportamiento predeterminado del formulario

        console.log('Formulario de búsqueda enviado'); // Agregamos un mensaje para verificar si se activa el evento

        // Obtener el término de búsqueda ingresado
        var searchTerm = $(this).find('input[type="search"]').val().toLowerCase();

        // Filtrar las tarjetas según la profesión
        $('.professional-card').each(function() {
            var profession = $(this).data('profesion').toLowerCase();

            // Mostrar u ocultar la tarjeta según el término de búsqueda
            if (profession.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>


</body>
</html>
