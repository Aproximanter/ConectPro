<?php
function connection() {
    $host = 'localhost';
    $usuario = 'id21883336_admin';
    $contrasena = 'A1274J&/Conect';
    $base_de_datos = 'id21883336_conectpro';

    $con = mysqli_connect($host, $usuario, $contrasena, $base_de_datos);

    if (!$con) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }
    

    return $con;
}
?>
