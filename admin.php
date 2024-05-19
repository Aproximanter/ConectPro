<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<?php include('navbarcrood.php');?>
<?php 
// Iniciar sesión si no está iniciada


include("conexion_bd.php");

// Obtener la conexión a la base de datos
$conexion = connection();

// Consulta para obtener la cantidad de usuarios
$sqlUsuarios = "SELECT COUNT(*) as totalUsuarios FROM usuarios";
$resultadoUsuarios = $conexion->query($sqlUsuarios);
$totalUsuarios = $resultadoUsuarios ? $resultadoUsuarios->fetch_assoc()['totalUsuarios'] : 0;

// Consulta para obtener la cantidad de profesionistas
$sqlProfesionistas = "SELECT COUNT(*) as totalProfesionistas FROM profesionistas";
$resultadoProfesionistas = $conexion->query($sqlProfesionistas);
$totalProfesionistas = $resultadoProfesionistas ? $resultadoProfesionistas->fetch_assoc()['totalProfesionistas'] : 0;

// Consulta para obtener datos generales de usuarios
$sqlDatosGenerales = "SELECT Nombre, Correo, FechaCreacion FROM usuarios";
$resultadoDatosGenerales = $conexion->query($sqlDatosGenerales);
?> 

<?php

// Verificar si el usuario está autenticado
if (!isset($_SESSION['UsuarioID'])) {
    echo "<script>alert('Debes iniciar sesión para acceder a esta página.'); window.location.href = 'login.php';</script>";
    exit();
}

// Obtener el nivel del usuario actual desde la base de datos
$usuarioID = $_SESSION['UsuarioID'];
$sql = "SELECT Nivel FROM usuarios WHERE UsuarioID = '$usuarioID'";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    $nivel = $fila['Nivel'];
    $_SESSION['nivel'] = $nivel;
} else {
    echo "<script>alert('Error: No se pudo encontrar la información del usuario.'); window.location.href = 'error_usuario.php';</script>";
    exit();
}

if ($_SESSION['nivel'] !== 'admin') {
    echo "<script>alert('Acceso denegado: No tienes permiso para acceder a esta página.'); window.location.href = 'index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>



<!-- Disclaimers de seguridad -->
<div class="container mt-4">
    <div class="alert alert-warning" role="alert">
        Esta página es parte del sistema de administración del sitio web. Por favor, asegúrese de estar autorizado antes de realizar cualquier acción.
    </div>
</div>

<div class="container mt-4">
    <h2>Cantidad de Usuarios y Profesionistas</h2>
    <p>Total de Usuarios: <?php echo $totalUsuarios; ?></p>
    <p>Total de Profesionistas: <?php echo $totalProfesionistas; ?></p>
</div>

<div class="container mt-4">
    <h2>Datos Generales de Usuarios</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Fecha de Creación</th>
            </tr>
        </thead>
        <tbody>
            <?php while($fila = $resultadoDatosGenerales->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['Nombre']; ?></td>
                <td><?php echo $fila['Correo']; ?></td>
                <td><?php echo $fila['FechaCreacion']; ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="container mt-4">
    <h2>Gráfico de Usuarios y Profesionistas</h2>
    <canvas id="myChart" width="200" height="100"></canvas>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Usuarios', 'Profesionistas'],
            datasets: [{
                label: 'Cantidad',
                data: [<?php echo $totalUsuarios; ?>, <?php echo $totalProfesionistas; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

</body>
</html>
