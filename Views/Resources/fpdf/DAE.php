<?php
require('./fpdf.php');

class PDF extends FPDF
{
   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD
      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();

      $this->Image('UPE.jpg', 90, 7, 50); // logo de la empresa, moverDerecha, moverAbajo, tamañoIMG
      $this->SetFont('Arial', 'B', 19); // tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      //$this->SetTextColor(0, 0, 0); //color
      // Creamos una celda o fila
      $this->Cell(110, 15, utf8_decode(' '), 0, 1, 'C', 0); // AnchoCelda, AltoCelda, titulo, borde(1-0), saltoLinea(1-0), posicion(L-C-R), ColorFondo(1-0)
      $this->Ln(30); // Salto de línea
      
      // Ubicación
      $this->SetFont('Arial', '', 10);
      $this->Cell(110); // Mover a la derecha
      $this->Cell(96, 10, utf8_decode("Jiutepec, Mor. A 10 de septiembre de 2024"), 0, 0, '', 0);
      $this->Ln(20);

      // Encabezado del mensaje
      $this->Cell(10); // Mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("PROFESORES DE DIRECCIÓN ACADÉMICA ITI-IET"), 0, 0, '', 0);
      $this->Ln(5);
      $this->Cell(10); // Mover a la derecha
      $this->Cell(59, 10, utf8_decode("P R E S E N T E"), 0, 0, '', 0);
      $this->Ln(15);

      // Cuerpo del mensaje
      $this->Cell(10); // Mover a la derecha
      $this->SetFont('Arial', '', 10);
      $this->Cell(59, 10, utf8_decode("Solicitamos su valioso apoyo para justificar la inasistencia y diferir actividades y "), 0, 0, '', 0);
      $this->Ln(5);
      $this->Cell(10); // Mover a la derecha
      $this->Cell(85, 10, utf8_decode("evaluaciones del siguientes alumno que se menciona a continuación, que se generaron el día:"), 0, 0, '', 0);
      $this->Ln(25);
      $this->Cell(10); // Mover a la derecha
      $this->Cell(85, 10, utf8_decode("Fecha y horarios justificar: "), 0, 0, '', 0);
      $this->Ln(5);
      $this->Cell(10); // Mover a la derecha
      $this->Cell(85, 10, utf8_decode("Motivo: "), 0, 0, '', 0);
      $this->Ln(15);
      
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); // Tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, utf8_decode('Boulevard. Cuauhnáhuac No. 566 Col. Lomas del Texcal, C.P. 62550 Tel: (777) 2 29 04 68 Ext. 2106') . $this->PageNo() . '/{nb}', 0, 0, 'C'); // Pie de página(numero de página)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); // Tipo fuente, cursiva, tamañoTexto
      $hoy = date('d/m/Y');
      $this->Cell(355, 10, utf8_decode($hoy), 0, 0, 'C'); // Pie de página(fecha de página)
   }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage(); // aquí entran dos parámetros (orientación, tamaño) V->portrait H->landscape tamaño (A3.A4.A5.letter.legal)
$pdf->AliasNbPages(); // muestra la página actual / y total de páginas
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163); // Color del borde

/*$consulta_reporte_alquiler = $conexion->query("  ");*/

/*while ($datos_reporte = $consulta_reporte_alquiler->fetch_object()) {      
   }*/

$i = 1; // Inicializamos el contador
/* TABLA */
$pdf->SetFont('Arial', 'B', 11); // Ajustamos la fuente para los encabezados
$pdf->SetFillColor(228, 100, 0); // Color de fondo para la cabecera
$pdf->SetTextColor(255, 255, 255); // Color del texto para la cabecera

// Encabezado de la tabla
$pdf->Cell(10, 10, utf8_decode('N°'), 1, 0, 'C', 1);
$pdf->Cell(40, 10, utf8_decode('Nombre'), 1, 0, 'C', 1);
$pdf->Cell(40, 10, utf8_decode('Matrícula'), 1, 0, 'C', 1);
$pdf->Cell(40, 10, utf8_decode('Grado y Grupo'), 1, 0, 'C', 1);
$pdf->Cell(60, 10, utf8_decode('Carrera'), 1, 1, 'C', 1);

// Restablecemos los colores y fuentes para el contenido de la tabla
$pdf->SetFont('Arial', '', 10); 
$pdf->SetTextColor(0, 0, 0); // Texto normal
$pdf->SetFillColor(255, 255, 255); // Fondo blanco para el contenido

// Datos ficticios
$pdf->Cell(10, 10, utf8_decode($i++), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode('Juan Pérez'), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode('123456789'), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode('1A IID'), 1, 0, 'C', 0);
$pdf->Cell(60, 10, utf8_decode('Ingeniería en Sistemas'), 1, 1, 'C', 0);

// Otra fila de ejemplo
$pdf->Cell(10, 10, utf8_decode($i++), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode('Ana García'), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode('987654321'), 1, 0, 'C', 0);
$pdf->Cell(40, 10, utf8_decode('2B ITI'), 1, 0, 'C', 0);
$pdf->Cell(60, 10, utf8_decode('Ingeniería Industrial'), 1, 1, 'C', 0);

// Bloque adicional después de la tabla
$pdf->Ln(10); // Salto de línea
/* TELEFONO */
$pdf->Cell(10);  // mover a la derecha
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(85, 10, utf8_decode("Sin otro particular por el momento, reciba un cordial saludo."), 0, 0, '', 0);
$pdf->Ln(30);
// Ancho total de la página
$anchoPagina = $pdf->GetPageWidth();

// Texto 1: A T E N T A M E N T E
$pdf->SetFont('Arial', '', 10);
$texto1 = utf8_decode("A T E N T A M E N T E ");
$anchoTexto1 = $pdf->GetStringWidth($texto1);
// Calculamos la posición para centrar
$posicionX = ($anchoPagina - $anchoTexto1) / 2;
$pdf->SetX($posicionX);
$pdf->Cell($anchoTexto1, 10, $texto1, 0, 0, 'C');
$pdf->Ln(20);

// Texto 2: MARIA FERNANDA DIAZ AYALA
$pdf->SetFont('Arial', 'B', 10);
$texto2 = utf8_decode("MARIA FERNANDA DIAZ AYALA");
$anchoTexto2 = $pdf->GetStringWidth($texto2);
$posicionX = ($anchoPagina - $anchoTexto2) / 2;
$pdf->SetX($posicionX);
$pdf->Cell($anchoTexto2, 10, $texto2, 0, 0, 'C');
$pdf->Ln(7);

// Línea
$pdf->SetFont('Arial', 'B', 10);
$texto3 = utf8_decode("___________________________________");
$anchoTexto3 = $pdf->GetStringWidth($texto3);
$posicionX = ($anchoPagina - $anchoTexto3) / 2;
$pdf->SetX($posicionX);
$pdf->Cell($anchoTexto3, 10, $texto3, 0, 0, 'C');
$pdf->Ln(5);

// Texto 4: DRA. MARIA FERNANDA DIAZ AYALA
$pdf->SetFont('Arial', '', 10);
$texto4 = utf8_decode("DRA. MARIA FERNANDA DIAZ AYALA ");
$anchoTexto4 = $pdf->GetStringWidth($texto4);
$posicionX = ($anchoPagina - $anchoTexto4) / 2;
$pdf->SetX($posicionX);
$pdf->Cell($anchoTexto4, 10, $texto4, 0, 0, 'C');
$pdf->Ln(5);

// Texto 5: DIRECTORA ACADÉMICA IIF-ITI-IET
$pdf->SetFont('Arial', '', 10);
$texto5 = utf8_decode("DIRECTORA ACADÉMICA IIF-ITI-IET");
$anchoTexto5 = $pdf->GetStringWidth($texto5);
$posicionX = ($anchoPagina - $anchoTexto5) / 2;
$pdf->SetX($posicionX);
$pdf->Cell($anchoTexto5, 10, $texto5, 0, 0, 'C');
$pdf->Ln(10);

// Salida del PDF
$pdf->Output('Prueba.pdf', 'I'); // nombreDescarga, Visor (I->visualizar - D->descargar)
