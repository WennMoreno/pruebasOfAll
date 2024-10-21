<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Resources/CSS/Style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Inicio de Sesión</title>
</head>
<body>
    <form method="POST" action="../Controller/Validar.php">
        <h1>Iniciar Sesión</h1>
        <hr>

        <?php 
            
            if(isset($_GET['error'])){
            ?>
            <p class="error">
                <?php
                    echo $_GET['error'];
                    echo "<hr>";
                ?>
            </p>
        <?php   }?>
        
        <i class="fa-solid fa-user"></i> 
        <label>Usuario</label>
        <input type="text" name="Usuario" placeholder="Nombre de Usuario">

        <i class="fa-solid fa-unlock"></i>
        <label>Contraseña</label>
        <input type="password" name="Contraseña" placeholder="Contraseña">
        
        <hr>
        <button type="submit">Iniciar Sesión</button>
        <a href="StudentView/Registrarse.php">Crear Cuenta</a>

    </form>
</body>
</html>