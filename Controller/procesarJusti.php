<?php  
    session_start();
    include '../Model/Conexion.php';
    include '../Model/Justificante.php';
    include '../Model/Evidencia.php';
    include '../Model/Profesor.php';
    include '../Model/JustificanteProfesor.php';  

    
  
// Mostrar los datos enviados y los archivos subidos
echo '<pre>';
print_r($_POST); // Ver todos los datos del formulario
print_r($_FILES); // Ver la información del archivo subido
echo '</pre>';

if (isset($_POST['NombreCom'], $_POST['Matricula'], $_POST['Cuatri'], $_POST['Grupo'], $_POST['Carrera'], $_POST['peri'], $_POST['opciones'], $_POST['info'], $_POST['fecha'], $_POST['fecha2'], $_POST['hora'], $_POST['horaFinal']) && isset($_FILES['evidencia'])) {

    $rutaEstatica = "C:/wamp64/www/Gestion_Justificantes/proyEstancia2"; 

    // Capturar datos del estudiante
    $nombre = $_POST['NombreCom'];
    $matricula = $_POST['Matricula'];
    $cuatrimestre = $_POST['Cuatri'];
    $grupo = $_POST['Grupo'];
    $carrera = $_POST['Carrera'];
    $periodo = $_POST['peri'];
    $motivo = $_POST['opciones'];
    $motivoE= null;
    $ausenteTodoDia = $_POST['info'] == "si" ? true : false;
    // Fecha de la ausencia
    $fecha = $_POST['fecha'];
    // Hora de ausencia (solo si el estudiante no faltó todo el día)
    $horaInicio = $ausenteTodoDia ? null : $_POST['hora'];
    $horaFin = $ausenteTodoDia ? null : $_POST['horaFinal'];

    if (isset($_FILES['evidencia']) && $_FILES['evidencia']['error'] == UPLOAD_ERR_OK) {
        // Manejar la subida de la evidencia
        $nombreArchivo = $_FILES['evidencia']['name'];
        $rutaArchivo = $rutaEstatica . "/" . basename($nombreArchivo);
        $tipoArchivo = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));

        // Verificar el tipo de archivo (imagen o PDF)
        $tiposPermitidos = array("jpg", "jpeg", "png", "pdf");
        if (!in_array($tipoArchivo, $tiposPermitidos)) {
            die("Error: Solo se permiten archivos JPG, JPEG, PNG, y PDF.");
        }

        // Verificar el tamaño del archivo
        $tamañoArchivo = $_FILES['evidencia']['size'];
        if ($tamañoArchivo > 1024 * 1024 * 5) { // 5MB
            die("Error: El archivo es demasiado grande.");
        }

        // Verificar si el archivo es una imagen
        if (in_array($tipoArchivo, array("jpg", "jpeg", "png"))) {
            $imagen = getimagesize($_FILES['evidencia']['tmp_name']);
            if (!$imagen) {
                die("Error: El archivo no es una imagen válida.");
            }
        }
    
        // Intentar mover el archivo subido a la carpeta de destino
        if (move_uploaded_file($_FILES['evidencia']['tmp_name'], $rutaArchivo)) {
            echo "El archivo se ha subido exitosamente.";

            // Crear instancias de los modelos
            $evidenciaModel = new Evidencia($conexion);
            $justificanteModel = new Justificante($conexion);
            $profesorModel = new Profesor($conexion);
            $justificanteProfesorModel = new JustificanteProfesor($conexion);

            // Insertar la evidencia en la base de datos
            $idEvidencia = $evidenciaModel->insertarEvidencia($nombreArchivo, $rutaArchivo);

            if ($idEvidencia) {
                // Insertar el justificante en la base de datos
                $idJustificante = $justificanteModel->insertarJustificante([
                    'nombre' => $nombre,
                    'matricula' => $matricula,
                    'cuatrimestre' => $cuatrimestre,
                    'grupo' => $grupo,
                    'carrera' => $carrera,
                    'periodo' => $periodo,
                    'motivo' => $motivo,
                    'motivoE' => $motivoE,
                    'fecha' => $fecha,
                    'horaInicio' => $horaInicio,
                    'horaFin' => $horaFin,
                    'ausenteTodoDia' => $ausenteTodoDia,
                    'idEvi' => $idEvidencia
                ]);

                // Si el estudiante faltó todo el día, insertar los profesores seleccionados en `justificante_profesor`
                if ($ausenteTodoDia && !empty($_POST['profesores'])) {
                    foreach ($_POST['profesores'] as $nombreProfesor) {
                        $idProfesor = $profesorModel->obtenerIdPorNombre($nombreProfesor);
                        if ($idProfesor) {
                            $justificanteProfesorModel->insertarJustificanteProfesor($idJustificante, $idProfesor);
                        }
                    }
                }

                // Mensaje de éxito
                echo "Justificante solicitado exitosamente.";
                exit();
            } else {
                echo "Error al insertar la evidencia en la base de datos.";
            }
        } else {
            echo "Error al mover el archivo. Verifica la ruta de destino y permisos.";
        }
      
    } else {
        header("location: ../Views/StudentView/SoliJusti.php");
        exit();
    }
}

?>
