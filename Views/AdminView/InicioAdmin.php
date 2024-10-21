<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
    <?php 
    session_start();//para que la sesión del usuario no se rompa

    $user = $_SESSION['identificador'];

    if(isset($_SESSION['identificador'])){
        ?>
        <center><h1>HOME ADMIN</h1></center>
        <a href="../CerrarSesion.php">Cerrar Sesion</a>
   <?php
    }else{
        header("Location: ../login.php");
    } 
?>

    <div class="opcion" >
        <p align="center"> <a href="SoliAluRegu.php"><button type="submit">JUSTIFICANTES DE ALUMNO REGULAR</button></p> 
    </div>
</body>
</html>