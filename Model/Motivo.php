<?php include 'Conexion.php'; 

    class Motivo {
        private $conexion;

        // Constructor que recibe la conexión
        public function __construct($conexion) {
            $this->conexion = $conexion;
        }

        public function obtenerMotivos() {
            $sql = "SELECT tipo FROM motivo"; 
            $result= mysqli_query($this->conexion, $sql);
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    }
?>
