<?php  
ob_start(); // Iniciar el buffering de salida
include('navbar.php'); // Iniciar la sesión en la página

// Verificar si el usuario tiene la sesión iniciada
if(!isset($_SESSION['UsuarioID'])) {
    // Si no tiene la sesión iniciada, redirigirlo a la página de inicio de sesión
    header("Location: login.php");
    exit; // Finalizar el script para evitar que el resto del contenido se muestre
}

// Definir opciones de profesión
$profesiones = array("Obrero", "Carpintero", "Pintor", "Maquinista", "Conductor", "Limpieza domestica", "Otro");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Profesionista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
</head>
<body>



<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Registro de Profesionista
                </div>
                <div class="card-body">
                    <form action="controlador_registro_profesionista.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
    <label for="telefono" class="form-label">Teléfono</label>
    <input type="tel" class="form-control" id="telefono" name="telefono">
</div>
<div class="mb-3">
    <label for="correo" class="form-label">Correo Electrónico</label>
    <input type="email" class="form-control" id="correo" name="correo" required>
</div>
<div class="mb-3">
    <label for="direccion" class="form-label">Dirección</label>
    <input type="text" class="form-control" id="direccion" name="direccion">
</div>

                        <div class="mb-3">
                            <label for="profesion" class="form-label">Profesión</label>
                            <select class="form-select" id="profesion" name="profesion" required>
                                <option value="">Selecciona una profesión</option>
                                <?php foreach ($profesiones as $profesion) { ?>
                                    <option value="<?php echo $profesion; ?>"><?php echo $profesion; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
    <label for="costo" class="form-label">Costo</label>
    <div class="input-group">
        <span class="input-group-text">$</span>
        <input type="number" class="form-control" id="costo" name="costo" step="0.01" required>
    </div>
</div>
                        <div class="mb-3">
                            <label for="foto_perfil" class="form-label">Foto de perfil</label>
                            <input type="file" class="form-control" id="foto_perfil" name="foto_perfil" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="crear_profesionista">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
