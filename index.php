<?php include('navbar.php'); ?>
<!DOCTYPE html>
<html lang="es">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5; /* added a light gray background */
        }
        .search-bar {
            max-width: 400px;
            margin: auto;
            padding: 20px; /* added some padding */
            background-color: #fff; /* added a white background */
            border: 1px solid #ddd; /* added a light gray border */
            border-radius: 20px; /* added a rounded corner */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* added a subtle shadow */
        }
        .search-bar input[type="search"] {
            border-radius: 20px;
            padding: 10px; /* added some padding */
            font-size: 16px; /* increased font size */
        }
        .search-bar button {
            border-radius: 20px;
            padding: 10px; /* added some padding */
            font-size: 16px; /* increased font size */
            background-color: #337ab7; /* changed button color to a nice blue */
            color: #fff; /* changed button text color to white */
            border: none; /* removed border */
        }
        .jumbotron {
            background-image: url('https://img.freepik.com/vector-premium/fondo-abstracto-azul-amarillo-plantilla-fondo-patron-banner-diseno-grafico-abstracto-vector_249611-9037.jpg');
            background-size: cover;
            padding: 100px 0;
            margin-bottom: 0;
            color: #fff; /* changed text color to white */
        }
        .jumbotron h1 {
            font-size: 4em; /* increased font size */
            font-weight: bold; /* added bold font weight */
        }
        .card {
            transition: transform 0.2s;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* added a subtle shadow */
        }
        .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>



<div class="jumbotron text-center">
    <h1 class="display-1">ConectaPro</h1>
    <div class="container mt-4 search-bar">
    <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Buscar profesionales" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Buscar</button>
        </form>
    </div>
</div>

<div class="container">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php include('cards.php'); ?>
    </div>
</div>

<script src="//code.tidio.co/ynfcxx7pil0vhqb9bzd0zbcyqpbmxrek.js" async></script>

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