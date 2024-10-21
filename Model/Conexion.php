<?php
    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $basedatos = "gestion_justificantes";

    // Conexión a la base de datos
    $conexion = new mysqli($servidor, $usuario, $clave, $basedatos);

    // Verifica si la conexión tiene errores
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
?>