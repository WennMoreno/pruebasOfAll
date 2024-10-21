<?php
include('../../../Model/conexion.php');
require('fpdf.php'); // Asegúrate de que la ruta sea correcta

// Verificar si se ha recibido el ID de la solicitud
if (isset($_POST['idJusti'])) {
    $idSolicitud = intval($_POST['idJusti']); // Asegúrate de validar el ID

    // Actualizar el estado de la solicitud a "Aceptada"
    $query = "UPDATE justificante SET estado = 'Aceptada' WHERE idJusti = $idSolicitud";

    if (mysqli_query($conexion, $query)) {
        // Obtener los detalles de la solicitud aceptada
        $queryDetalles = "SELECT * FROM justificante WHERE idJusti = $idSolicitud";
        $result = mysqli_query($conexion, $queryDetalles);
        
        if (!$result) {
            echo "<p>Error en la consulta a la base de datos: " . mysqli_error($conexion) . "</p>";
            exit();
        }
        
        $solicitud = mysqli_fetch_assoc($result);

        if ($solicitud) {
            // Preparar los datos para el documento
            $fecha = date('d/m/Y'); // Fecha actual
            $horaInicio = $solicitud['horaInicio'];
            $horaFin = $solicitud['horaFin'];

            // Crear el PDF
            class PDF extends FPDF{
                private $solicitud;

                // Constructor para recibir datos de la solicitud
                function __construct($solicitud)
                {
                    parent::__construct();
                    $this->solicitud = $solicitud;
                }

                // Cabecera de página
                function Header(){
                    $this->Image('UPE.jpg', 90, 7, 50);
                    $this->SetFont('Arial', 'B', 19);
                    $this->Ln(30);
                    $this->SetTextColor(0, 0, 0);

                    // Obtener la fecha actual
                    $dia = date('d');
                    setlocale(LC_TIME, 'es_ES.UTF-8'); // Asegurarse de que la localización esté en español
                    $mes = strftime('%B', strtotime('now')); // Nombre del mes en español
                    $anio = date('Y');

                    // Formatear la fecha
                    $fechaActual = "$dia de $mes de $anio";
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(96, 10, mb_convert_encoding("Jiutepec, Mor. A $fechaActual", 'ISO-8859-1', 'UTF-8'), 0, 1, '', 0);

                    $this->Ln(20);
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(59, 10, mb_convert_encoding("PROFESORES DE DIRECCIÓN ACADÉMICA ITI-IET", 'ISO-8859-1', 'UTF-8'), 0, 1, '', 0);
                    $this->Ln(5);
                    $this->Cell(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(59, 10, mb_convert_encoding("P R E S E N T E", 'ISO-8859-1', 'UTF-8'), 0, 1, '', 0);
                    $this->Ln(15);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(59, 10, mb_convert_encoding("Por este medio hago de su conocimiento que el alumno(a): ", 'ISO-8859-1', 'UTF-8'), 0, 1, '', 0);
                    $this->Ln(5);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(85, 10, mb_convert_encoding("{$this->solicitud['nombre']}, {$this->solicitud['cuatrimestre']} {$this->solicitud['grupo']}, {$this->solicitud['carrera']} con MATRICULA: {$this->solicitud['matricula']} por motivo de {$this->solicitud['motivo']}.", 'ISO-8859-1', 'UTF-8'), 0, 1, '', 0);
                    $this->Ln(25);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);

                    // Formatear la fecha de la solicitud
                    $fecha = $this->solicitud['fecha']; // Obtiene la fecha
                    $timestamp = strtotime($fecha); // Convierte la fecha a timestamp
                    $mesYDia = strftime('%d de %B', $timestamp); // Formatea la fecha en español

                    // Mostrar la fecha de la solicitud
                    $this->Cell(85, 10, mb_convert_encoding("Fechas: $mesYDia", 'ISO-8859-1', 'UTF-8'), 0, 1, '', 0);
                    $this->Ln(5);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(85, 10, utf8_decode("Horario: {$this->solicitud['horaInicio']} a {$this->solicitud['horaFin']}."), 0, 1, '', 0);
                    $this->Ln(25);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(85, 10, utf8_decode("De esta forma solicito de su apoyo para que el alumno(a) entregue trabajos y/o exámenes que "), 0, 1, '', 0);
                    $this->Ln(5);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(85, 10, utf8_decode("se hayan generado en clase. Asimismo, justificar las faltas."), 0, 1, '', 0);
                    $this->Ln(10);
                    $this->Cell(10);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(85, 10, utf8_decode("Esperando contar con su apoyo, reciban un cordial saludo."), 0, 1, '', 0);
                    $this->Ln(40);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(0, 10, utf8_decode("A T E N T A M E N T E"), 0, 1, 'C');
                    $this->Ln(10);
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell(0, 10, utf8_decode("MARIA FERNANDA DIAZ AYALA"), 0, 1, 'C');
                    $this->Ln(5);
                    $this->Cell(0, 10, utf8_decode("___________________________________"), 0, 1, 'C');
                    $this->Ln(5);
                    $this->SetFont('Arial', '', 10);
                    $this->Cell(0, 10, utf8_decode("DRA. MARIA FERNANDA DIAZ AYALA"), 0, 1, 'C');
                    $this->Cell(0, 10, utf8_decode("DIRECTORA ACADÉMICA IIF-ITI-IET"), 0, 1, 'C');
                }

                // Pie de página
                function Footer()
                {
                    $this->SetY(-15);
                    $this->SetFont('Arial', 'I', 8);
                    $this->Cell(0, 10, utf8_decode('Boulevard. Cuauhnáhuac No. 566 Col. Lomas del Texcal, C.P. 62550 Tel: (777) 2 29 04 68 Ext. 2106'), 0, 0, 'C');
                    $this->SetY(-15);
                    $this->Cell(355, 10, utf8_decode(date('d/m/Y')), 0, 0, 'C');
                }
            }

            // Generar el PDF
            $pdf = new PDF($solicitud);
            $pdf->AddPage();
            $pdf->Output();
        } else {
            echo "<p>No se encontró la solicitud para generar el PDF.</p>";
        }
    } else {
        echo "<p>Error al actualizar el estado de la solicitud: " . mysqli_error($conexion) . "</p>";
    }
} else {
    echo "<p>No se recibió el ID de la solicitud.</p>";
}

?>
