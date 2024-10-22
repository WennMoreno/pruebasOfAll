<?php 
    include '../Model/Conexion.php';
    include '../Model/Alumno.php';
?>

<?php 
   session_start();
  
   if(isset($_POST['nombre']) && isset($_POST['ape']) && isset($_POST['feNac']) && isset($_POST['matricula']) && isset($_POST['clave']) && isset($_POST['Rclave'])){
        function validar($data){
            $data=trim($data);
            $data=stripslashes($data);
            $data=htmlspecialchars($data);
            return $data;
        }
        //obtener los datos del formulario sin carcateres especiales ni alguna informacion erronea
        $nombre=validar($_POST['nombre']);
        $ape=validar($_POST['ape']);
        $nac=validar($_POST['feNac']);
        $usuario=validar($_POST['matricula']);
        $clave=validar($_POST['clave']);
        $Rclave=validar($_POST['Rclave']);
    
        $datosUsuario='nombre='.$nombre."&ape=".$ape.'&nac='.$nac.'&matricula='.$usuario;

        if(empty($nombre)){
            header("location: ../Views/StudentView/Registrarse.php?error=El Nombre es requerido&$datosUsuario");
            exit();
        }elseif(empty($ape)){
            header("location: ../Views/StudentView/Registrarse.php?error=El Apellido es requerido&$datosUsuario");
            exit();
        }elseif(empty($nac)){
            header("location: ../Views/StudentView/Registrarse.php?error=La fecha de Nacimiento es requerida&$datosUsuario");
            exit();
        }elseif(empty($usuario)){
            header("location: ../Views/StudentView/Registrarse.php?error=La Matricula es requerida&$datosUsuario");
            exit();
        }elseif(empty($clave)){
            header("location: ../Views/StudentView/Registrarse.php?error=La Contraseña es requerida&$datosUsuario");
            exit();
        }elseif(empty($Rclave)){
            header("location: ../Views/StudentView/Registrarse.php?error=Repetir la Contraseña es requerida&$datosUsuario");
            exit();
        }elseif($clave !== $Rclave){
            header("location: ../Views/StudentView/Registrarse.php?error=No Coinciden las Contraseñas&$datosUsuario");
            exit();
        }else{

            //Los campos contienen información
            $clave=$clave;
            //encriptar la contraseña
            $clave2=md5($clave);
            
            // Convertir formato de la fecha de d/m/Y a Y-m-d
            $date = DateTime::createFromFormat('d/m/Y', $nac);

            if ($date) { // Si la conversión es exitosa
                $nac = $date->format('Y-m-d');
            } else {
                header("location: ../Views/StudentView/Registrarse.php?error=Formato de Fecha Incorrecto");
                exit();
            }

            // Crear una instancia
            $alumnoModel = new Alumno ($conexion);
            if ($alumnoModel->validarMatriculaExistente($usuario)) {
                header("location: ../Views/StudentView/Registrarse.php?error=El Usuario ya existe");
                exit();
            } else {
                // Registrar el alumno
                if ($alumnoModel->registrarAlumno($nombre, $ape, $nac, $usuario, $clave, $clave2)) {
                    header("location: ../Views/StudentView/Registrarse.php?success=Usuario Creado Exitosamente");
                } else {
                    header("location: ../Views/StudentView/Registrarse.php?error=Ocurrio un Error");
                }
                exit();
            }   
        }
    }else{
        header("location: ../Views/StudenView/Registrarse.php");
        exit();
    } 
?>