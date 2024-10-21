<?php
include('conexion.php');
require('fpdf.php'); // Asegúrate de que la ruta sea correcta

// Verificar si se ha recibido el ID de la solicitud
if (isset($_POST['idJusti'])) {
    $idSolicitud = $_POST['idJusti'];

    // Actualizar el estado de la solicitud a "Aceptada"
    $query = "UPDATE justificante SET estado = 'Aceptada' WHERE idJusti = $idSolicitud";

    if (mysqli_query($conexion, $query)) {
        // Obtener los detalles de la solicitud aceptada
        $queryDetalles = "SELECT * FROM justificante WHERE idJusti = $idSolicitud";
        $result = mysqli_query($conexion, $queryDetalles);
        $solicitud = mysqli_fetch_assoc($result);

        // Preparar los datos para el documento
        $nombre = $solicitud['nombre'];
        $grado = $solicitud['grado']; // Asegúrate de que esta columna exista en tu tabla
        $grupo = $solicitud['grupo']; // Asegúrate de que esta columna exista en tu tabla
        $carrera = $solicitud['carrera'];
        $matricula = $solicitud['matricula'];
        $fecha = date('d/m/Y'); // Fecha actual
        $horaInicio = $solicitud['horaInicio'];
        $horaFin = $solicitud['horaFin'];

        // Crear el contenido del documento
        $documento = "Jiutepec, Mor. A $fecha\n\n
        PROFESORES DE DIRECCIÓN ACADÉMICA ITI-IET\n
        P R E S E N T E\n\n
        Por este medio hago de su conocimiento que el alumno (a): $nombre, $grado - $grupo Y $carrera con Matrícula: $matricula, llegó tarde ya que no cuenta con la credencial de estudiante, en el horario especificado:\n\n
        FECHA: $fecha\n
        Horario: $horaInicio a $horaFin\n\n
        De esta forma solicito de su apoyo para que el alumno(a) entregue trabajos y/o exámenes que se hayan generado en clase. Asimismo, justificar las faltas.\n\n
        Esperando contar con su apoyo, reciban un cordial saludo.\n\n
        A T E N T A M E N T E\n\n
        MARIA FERNANDA DIAZ AYALA\n
        _______________________________\n
        DRA. MARIA FERNANDA DIAZ AYALA\n
        DIRECTORA ACADÉMICA IIF-ITI-IET";

        // Crear el PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->MultiCell(0, 10, $documento); // Usamos MultiCell para manejar el salto de línea

        // Definir la ruta y nombre del archivo PDF
        $nombrePdf = "justificante_$idJusti.pdf";
        $rutaPdf = "Escritorio/Justificantes/2025/$nombrePdf"; // Cambia esto a la ruta donde deseas guardar el PDF

        // Guardar el PDF en la carpeta especificada
        $pdf->Output('F', $rutaPdf); 

        // Registrar el PDF en la tabla
        $fechaGeneracion = date('Y-m-d H:i:s'); // Fecha y hora actual
        $queryRegistrarPdf = "INSERT INTO  pdf_generado (idJusti, nombrePdf, rutaPdf, fechaGeneracion) VALUES ($idSolicitud, '$nombrePdf', '$rutaPdf', '$fechaGeneracion')";

        if (mysqli_query($conexion, $queryRegistrarPdf)) {
            // Redireccionar o mostrar mensaje de éxito
            echo "<script>alert('Solicitud aceptada, documento generado y registrado.'); window.location.href='ruta_a_tu_pagina.php';</script>";
        } else {
            echo "<script>alert('Error al registrar el PDF en la base de datos.'); window.location.href='ruta_a_tu_pagina.php';</script>";
        }
    } else {
        echo "<script>alert('Error al aceptar la solicitud.'); window.location.href='ruta_a_tu_pagina.php';</script>";
    }
} else {
    echo "<script>alert('No se proporcionó el ID de la solicitud.'); window.location.href='ruta_a_tu_pagina.php';</script>";
}
?>
