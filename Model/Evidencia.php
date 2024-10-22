<?php include 'Conexion.php';  ?> 
<?php
class Evidencia {
    private $conexion;

    // Constructor que recibe la conexión
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function insertarEvidencia($nombreArchivo, $rutaArchivo) {
        $stmt = $this->conexion->prepare("INSERT INTO evidencia (nomenclatura, ruta) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombreArchivo, $rutaArchivo);
        return $stmt->execute() ? $this->conexion->insert_id : false;
    }
}
?>
