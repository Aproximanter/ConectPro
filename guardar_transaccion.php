<?php
session_start();

include 'conexion_bd.php';
$con = connection();
if (!isset($_SESSION['UsuarioID'])) {
    // Si el usuario no está autenticado, mostrar mensaje de alerta
    echo "Debes iniciar sesión primero.";
    exit; // Detener la ejecución del script
}
// Verificar si se ha enviado el valor del campo profesionistaId
if(isset($_POST['profesionistaId'])){
    // Cambio de nombre de la variable para que coincida con el formulario HTML
    $profesionistaId = $_POST['profesionistaId'];

    $usuarioId = $_SESSION['UsuarioID'];

    // Verificar si ya existe una contratación previa entre el usuario actual y el profesionista seleccionado
    $sql_verificar_contratacion = "SELECT * FROM contrataciones WHERE ProfesionistaID = ? AND UsuarioID = ?";
    $stmt_verificar_contratacion = mysqli_prepare($con, $sql_verificar_contratacion);
    mysqli_stmt_bind_param($stmt_verificar_contratacion, "ii", $profesionistaId, $usuarioId);
    mysqli_stmt_execute($stmt_verificar_contratacion);
    mysqli_stmt_store_result($stmt_verificar_contratacion);

    // Si ya existe una contratación previa, mostrar un mensaje de error
    if(mysqli_stmt_num_rows($stmt_verificar_contratacion) > 0) {
        echo "Ya has contratado a este profesionista anteriormente.";
    } else {
        // Si no existe una contratación previa, proceder con la inserción
        $sql_insert_contratacion = "INSERT INTO contrataciones (ProfesionistaID, UsuarioID) VALUES (?, ?)";
        $stmt_insert_contratacion = mysqli_prepare($con, $sql_insert_contratacion);
        mysqli_stmt_bind_param($stmt_insert_contratacion, "ii", $profesionistaId, $usuarioId);

        // Ejecutar la sentencia de inserción
        if (mysqli_stmt_execute($stmt_insert_contratacion)) {
            // Contratación realizada correctamente
            echo "¡Contratación realizada correctamente!";
        } else {
            // Error al realizar la contratación
            echo "Error al realizar la contratación: " . mysqli_error($con);
        }

        // Cerrar la sentencia de inserción
        mysqli_stmt_close($stmt_insert_contratacion);
    }

    // Cerrar la sentencia de verificación
    mysqli_stmt_close($stmt_verificar_contratacion);
} else {
    // Si el campo profesionistaId no se envió correctamente
    echo "Error: El campo profesionistaId no se envió correctamente.";
}

// Cerrar la conexión y liberar recursos
mysqli_close($con);
?>
