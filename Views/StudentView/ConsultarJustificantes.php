<?php 
    include '../../Controller/consuJusti.php';


    $matriculaAlumno = $_SESSION['identificador'] ?? null;

    if ($matriculaAlumno === null) {
        echo "Error: No se encontró la matrícula en la sesión.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Resources/CSS/styleUsers.css">
    <title>Consultar Justificantes</title>
</head>
<body>

    <h1>Justificantes de <?php echo $matriculaAlumno; ?></h1>

    <?php
        $Justi = new JustificanteController($conexion);
        $resultProfesor = $Justi->consultarJustificantes();
    ?>

    <?php if (!empty($resultProfesor)) : ?>
        <table class="table-danger">
            <tr>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($resultProfesor as $justificante): ?>
            <tr>
                <td><?php echo $justificante['motivo']; ?></td>
                <td><?php echo $justificante['fecha']; ?></td>
                <td><?php echo $justificante['estado']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay justificantes para este alumno.</p>
    <?php endif; ?>

    <p><a href="InicioAlumno.php">Volver</a></p>

</body>
</html>
