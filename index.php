
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <style>
    
    </style>
</head>
<body class="bg-light">

<?php include('navbar.php'); ?>

<div class="container-fluid bg-danger text-white text-center py-5">
    <h1 class="display-1 text-center">Bienvenido</h1>
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

</body>
</html>
