<?php include 'Conexion.php'; 
    class Alumno {
        private $conexion;

        public function __construct($conexion) {
            $this->conexion = $conexion;
        }

        public function validarMatriculaExistente($matricula) {
            $consulta = "SELECT * FROM alumno WHERE matricula = ?";
            $stmt = $this->conexion->prepare($consulta);
            $stmt->bind_param("s", $matricula);
            $stmt->execute();
            return $stmt->get_result()->num_rows > 0;
        }

        public function registrarAlumno($nombre, $apellido, $fechaNac, $matricula, $clave, $claveEncriptada) {
            $sql = "INSERT INTO alumno(nombreAlu, apellidoAlu, feNac, matricula, contrasena, confirmacionContra) 
                    VALUES(?, ?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ssssss", $nombre, $apellido, $fechaNac, $matricula, $clave, $claveEncriptada);
            return $stmt->execute();
        }
    }
?>
