<?php
include 'conexion_bd.php';

// Verifica si se recibió el ID del profesionista
if (isset($_POST['profesionista_id'])) {
  $profesionistaId = $_POST['profesionista_id'];
  
  // Establece la conexión a la base de datos
  $con = connection();
  
  // Consulta SQL para obtener los datos del profesionista
  $sql = "SELECT * FROM profesionistas WHERE ProfesionistaID = '$profesionistaId'";
  $resultado = mysqli_query($con, $sql);
  
  if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    // Imprime los datos del profesionista en formato HTML
    echo '<table class="table">';
    echo '<tr><th class = "mr-2  ml-2  ">Nombre</th><th class = "mr-2  ml-2" >Profesión</th><th class = "mr-2  ml-2" >Tarifa de visita</th></tr>';
    echo '<tr>';
    echo '<td>' . $fila["Nombre"] . '</td>';
    echo '<td>' . $fila["Profesion"] . '</td>';
    echo '<td>$' . $fila["Costo"] . '</td>';

    
   
    echo '</tr>';
    echo '</table>';
    // Agrega más campos según tus necesidades
  } else {
    echo 'No se encontraron datos para este profesionista.';
  }
  
  // Cierra la conexión
  mysqli_close($con);
} else {
  echo 'No se proporcionó el ID del profesionista.';
}
?>
