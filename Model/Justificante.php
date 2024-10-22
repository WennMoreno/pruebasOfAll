<?php include 'Conexion.php'; 
    class Justificante { 
        private $conexion;

        // Constructor que recibe la conexión
        public function __construct($conexion) {
            $this->conexion = $conexion;
        }

        public function insertarJustificante($datos) {
            $stmt = $this->conexion->prepare("INSERT INTO justificante (nombre, matricula, cuatrimestre, grupo, carrera, periodo, motivo, motivoExtra, fecha, horaInicio, horaFin, ausenteTodoDia, idEvi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssiissssssiii", $datos['nombre'], $datos['matricula'], $datos['cuatrimestre'], $datos['grupo'], $datos['carrera'], $datos['periodo'], $datos['motivo'], $datos['motivoE'], $datos['fecha'], $datos['horaInicio'], $datos['horaFin'], $datos['ausenteTodoDia'], $datos['idEvi']);
            return $stmt->execute() ? $this->conexion->insert_id : false;
        }

        public function getJustificantesPorAlumno($matricula) {
            $sql = "SELECT * FROM justificante WHERE matricula = ?";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            $resultado = $stmt->get_result();
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }
        
    }
?>
