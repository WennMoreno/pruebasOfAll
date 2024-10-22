<?php  
    session_start();
    require_once '../../Model/Conexion.php'; 
    require_once '../../Model/Motivo.php';

    class showMotivs{
        private $motivos;

        public function __construct() {
            global $conexion; // Obtener la conexión a la base de datos
            $this->motivos = new Motivo($conexion);  // Se pasa la conexión al constructor de Motivo
        }
    
        public function mostrarMotivos() {
            return $this->motivos->obtenerMotivos();  // Llamada correcta al método obtenerMotivos de Motivo
        }
        
    } 

?>