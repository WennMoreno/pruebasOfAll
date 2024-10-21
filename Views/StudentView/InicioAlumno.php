<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Resources/CSS/styleUsers.css">
    <title>Inicio</title>
</head>
<body>
    <?php 
        session_start();//para que la sesión del usuario no se rompa

        $user = $_SESSION['identificador'];
        //si existe una sesión iniciada
        if(isset($user)){
    ?>
    
    <p><img src="../Resources/img/logo.png" align="left" width=50></a>
    <p align="right"><a href="">Mi cuenta</a>   
    <a href="../CerrarSesion.php">Cerrar Sesion</a></p>
    <br> 
    
    <hr>

    <div >
        <div class="informacion">
           <p><?php
                echo "<h1> Usuario:" . $user . "</h1>"; 
            ?></p>

            <p align="center"><img src="../Resources/img/user.png" class="imagen-usuario" width=50 height=50></p>
        </div>

        <div class="opcion" >
            <p align="center"> <a href="SoliJusti.php"><button type="submit">SOLICITAR JUSTIFICANTES</button></p> 
            <br>
            <p align="center"> <a href="ConsultarJustificantes.php"><button type="submit">CONSULTAR JUSTIFICANTES</button></p> 
        </div>
    </div>

    <?php
        }else{
            header("Location: ../login.php");
        }   
    ?>
</body>
</html>