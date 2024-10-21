<?php
include('../Model/conexion.php');

if (!isset($_GET['id'])) {
    echo "<p>No se proporcionó el ID de la solicitud.</p>";
    exit();
}

$idSolicitud = intval($_GET['id']);

if (!$conexion) {
    echo "<p>Error en la conexión a la base de datos.</p>";
    exit();
}

$query = "SELECT * FROM justificante WHERE idJusti = $idSolicitud";
$result = mysqli_query($conexion, $query);

if (!$result) {
    echo "<p>Error en la consulta a la base de datos: " . mysqli_error($conexion) . "</p>";
    exit();
}


$solicitud = mysqli_fetch_assoc($result);

if ($solicitud) {
    // Crear un bloque HTML para mostrar los detalles
    echo "<h3>Solicitud #" . $solicitud['idJusti'] . "</h3>";
    echo "<p><strong>Nombre:</strong> " . $solicitud['nombre'] . "</p>";
    echo "<p><strong>Matrícula:</strong> " . $solicitud['matricula'] . "</p>";
    echo "<p><strong>Carrera:</strong> " . $solicitud['carrera'] . "</p>";
    echo "<p><strong>Fecha:</strong> " . $solicitud['fecha'] . "</p>";
    echo "<p><strong>Hora Inicio:</strong> " . $solicitud['horaInicio'] . "</p>";
    echo "<p><strong>Hora Fin:</strong> " . $solicitud['horaFin'] . "</p>";
    echo "<p><strong>Motivo:</strong> " . $solicitud['motivo'] . "</p>";
   
    ?>
    <form action="../Resources/fpdf/PruebaV.php" method="POST">
    <input type="hidden" name="idJusti" value="<?php echo $solicitud['idJusti']; ?>">
    <button type="submit">Aceptar y Generar PDF</button>
</form>

<?php

} else {
    echo "<p>No se encontró la solicitud con el ID proporcionado.</p>";
}

mysqli_close($conexion);
