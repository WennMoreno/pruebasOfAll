<?php
session_start();
require_once '../../Model/Conexion.php';  // Incluye la conexión a la base de datos
require_once '../../Model/Justificante.php'; // Incluye el modelo de justificantes

class JustificanteController {
    private $justificanteModel;

    public function __construct() {
        global $conexion; // Obtener la conexión a la base de datos
        $this->justificanteModel = new Justificante($conexion);
    }

    public function consultarJustificantes() {
        // Verifica si el usuario está en sesión
        if (!isset($_SESSION['identificador'])) {
            header("Location: ../Views/login.php");
            exit;
        }

        // Obtener la matrícula del alumno
        $matriculaAlumno = $_SESSION['identificador'] ?? null;

        if ($matriculaAlumno === null) {
            echo "Error: No se encontró la matrícula en la sesión.";
            exit;
        }

        // Obtener justificantes del modelo
        return $this->justificanteModel->getJustificantesPorAlumno($matriculaAlumno);
    }
}
