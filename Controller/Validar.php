<?php include '../Model/Conexion.php'; ?>

<?php
    session_start();

    if(isset($_POST['Usuario']) && isset($_POST['Contraseña'])){
        
        function validate($data){
            $data=trim($data);
            $data=stripslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }

        $Usuario=validate($_POST['Usuario']);
        $Clave=validate($_POST['Contraseña']);

        if(empty($Usuario)){
            header("Location: login.php?error=El Usuario es Requerido");
            exit();
        }elseif(empty($Clave)){
            header("Location: login.php?error=La Contraseña es Requerida");
            exit();
        }else{
            //COMPROBACIÓN DE CREDENCIALES PARA EL INICIO DE SESIÓN CORRECTO

            // Comprobar si es un alumno (matrícula y clave)
            $sqlAlumno = "
                SELECT 'alumno' AS tipo_usuario, matricula AS identificador, nombreAlu, apellidoAlu,contrasena
                FROM alumno 
                WHERE matricula = '$Usuario' AND contrasena = '$Clave'
            ";
            $resultAlumno = mysqli_query($conexion, $sqlAlumno);

            // Comprobar si es un profesor (nombre y apellido, y contraseña)
            $sqlProfesor = "
                SELECT 'profesor' AS tipo_usuario, idProf AS identificador, nombreProf, apellidoProf, passwordProf AS contraseña
                FROM profesor
                WHERE nombreProf = '$Usuario' AND passwordProf = '$Clave'
            ";
            $resultProfesor = mysqli_query($conexion, $sqlProfesor);

            // Comprobar si es un administrador (nombre y contraseña)
            $sqlAdmin = "
                SELECT 'administrador' AS tipo_usuario, idAdmin AS identificador, nombreAdmin, apellidoAdmin, passAd
                FROM administrador 
                WHERE nombreAdmin = '$Usuario' AND passAd = '$Clave'
            ";
            $resultAdmin = mysqli_query($conexion, $sqlAdmin);
            
            // Validación para alumnos
            if (mysqli_num_rows($resultAlumno) === 1) {
                $row = mysqli_fetch_assoc($resultAlumno);
                $_SESSION['identificador'] = $row['identificador'];
                $_SESSION['nombre'] = $row['nombre'];
                $_SESSION['apellido'] = $row['apellido'];
                $_SESSION['tipo_usuario'] = 'alumno';
                header("Location: ../Views/StudentView/InicioAlumno.php");
                exit();
            } else{
                // Validación para profesores
                if (mysqli_num_rows($resultProfesor) === 1) {
                    $row = mysqli_fetch_assoc($resultProfesor);
                    $_SESSION['identificador'] = $row['identificador'];
                    $_SESSION['nombre'] = $row['nombre'];
                    $_SESSION['apellido'] = $row['apellido'];
                    $_SESSION['tipo_usuario'] = 'profesor';
                    header("Location: ../Views/teachersView/InicioProfesor.php");
                    exit();
                }else{
                    if (mysqli_num_rows($resultAdmin) === 1) {
                        // Validación para administradores
                        $row = mysqli_fetch_assoc($resultAdmin);
                        $_SESSION['identificador'] = $row['identificador'];
                        $_SESSION['nombre'] = $row['nombre'];
                        $_SESSION['apellido'] = $row['apellido'];
                        $_SESSION['tipo_usuario'] = 'administrador';
                        header("Location: ../Views/AdminView/InicioAdmin.php");
                        exit();
                    } else {
                        // Si no se encuentra el usuario
                        header("Location: ../Views/login.php?error=El usuario o contraseña son incorrectas");
                        exit();
                    }
                }
            }   
        }
    }else{
        header("Location: ../Views/login.php");
        exit();
    }

    
?>