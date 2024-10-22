<?php include 'Conexion.php';  ?> 

<?php
class Profesor {
    private $conexion;

    // Constructor que recibe la conexión
    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerProfesores() {
        $sql = "SELECT nombreProf, apellidoProf FROM profesor"; 
        return mysqli_query($this->conexion, $sql);
    } 

    public function obtenerIdPorNombre($nombreProfesor) {
        $stmt = $this->conexion->prepare("SELECT idProf FROM profesor WHERE CONCAT(nombreProf, ' ', apellidoProf) = ?");
        $stmt->bind_param("s", $nombreProfesor);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? $result->fetch_assoc()['idProf'] : false;
    }
}
?>
