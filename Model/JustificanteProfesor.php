<?php include 'Conexion.php';  ?>

<?php
class JustificanteProfesor {
    private $conexion;

    // Constructor que recibe la conexión
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }
    
    public function insertarJustificanteProfesor($idJustificante, $idProfesor) {
        $stmt = $this->conexion->prepare("INSERT INTO justificante_profesor (idJusti, idProf) VALUES (?, ?)");
        $stmt->bind_param("ii", $idJustificante, $idProfesor);
        return $stmt->execute();
    }
}
?>
