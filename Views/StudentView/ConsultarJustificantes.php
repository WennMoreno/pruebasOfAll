

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Resources/CSS/styleUsers.css">
    <title>Consultar Justificantes</title>
</head>
<body>
    <?php

        include '../../Model/Conexion.php';
        session_start();

        // Verifica si el usuario está en sesión
        if (!isset($_SESSION['identificador'])) {
            header("Location: ../login.php");
            exit;
        }

        // Obtener la matrícula del alumno
        $matriculaAlumno = $_SESSION['identificador'] ?? null; // Evitar error si no está definido

        if ($matriculaAlumno === null) {
            echo "Error: No se encontró la matrícula en la sesión.";
            exit;
        }

        function getJustificantesPorAlumno($matricula) {
            global $conexion;

            $sql = "SELECT * FROM justificante WHERE matricula = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $matricula); // "s" indica que el parámetro es una cadena
            $stmt->execute();
            
            $resultado = $stmt->get_result(); // Obtén el resultado
            return $resultado->fetch_all(MYSQLI_ASSOC); // Usa fetch_all para mysqli
        }

        // Obtener justificantes
        $justificantes = getJustificantesPorAlumno($matriculaAlumno);
    ?>

    <h1>Justificantes de <?php echo $_SESSION['identificador']; ?></h1>

    <?php if (!empty($justificantes)) : ?>
        <table class="table-danger">
            <tr>
                <th>Motivo</th>
                <th>Fecha</th>
                <th>Estado</th>
            </tr>
            <?php foreach ($justificantes as $justificante): ?>
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
