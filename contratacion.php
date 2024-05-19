<?php
// Incluir la biblioteca TCPDF
require_once('TCPDF-main\tcpdf.php');

// Verificar si se recibió el ID del profesionista
if (isset($_POST['profesionista_id'])) {
    $profesionistaId = $_POST['profesionista_id'];

    // Establecer la conexión a la base de datos
    include 'conexion_bd.php';
    $con = connection();

    // Consulta SQL para obtener los datos del profesionista y sus datos de contacto
    $sql = "SELECT p.*, c.Telefono, c.Correo, c.Direccion 
            FROM profesionistas p 
            LEFT JOIN datoscontactoprofesionista c ON p.ProfesionistaID = c.ProfesionistaID 
            WHERE p.ProfesionistaID = '$profesionistaId'";
    $resultado = mysqli_query($con, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);

        // Crear una nueva instancia de TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Agregar una página al PDF
        $pdf->AddPage();

        // Establecer el contenido del PDF
        $html = '<h1>Orden de Pago</h1>';
        $html .= '<p>Nombre: ' . $fila["Nombre"] . '</p>';
        $html .= '<p>Profesión: ' . $fila["Profesion"] . '</p>';
        $html .= '<p>Costo: ' . $fila["Costo"] . '</p>';
        $html .= '<p>Teléfono: ' . $fila["Telefono"] . '</p>'; // Agregar el teléfono del profesionista
        $html .= '<p>Correo: ' . $fila["Correo"] . '</p>'; // Agregar el correo del profesionista
        $html .= '<p>Dirección: ' . $fila["Direccion"] . '</p>'; // Agregar la dirección del profesionista
        // Agrega más campos según tus necesidades

        // Escribir el contenido en el PDF
        $pdf->writeHTML($html, true, false, true, false, '');

        // Establecer el nombre del archivo PDF
        $pdfName = 'Orden_de_Pago_' . $fila["Nombre"] . '.pdf';

        // Descargar el PDF en lugar de mostrarlo en el navegador
        $pdf->Output($pdfName, 'D');
    } else {
        echo 'No se encontraron datos para este profesionista.';
    }

    // Cerrar la conexión
    mysqli_close($con);
} else {
    echo 'No se proporcionó el ID del profesionista.';
}
?>
