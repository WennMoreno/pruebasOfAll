<?php include '../../Model/Profesor.php'; ?>

<DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar justificante</title>

    <style>
        .hidden {
            display: none; /* Clase para ocultar elementos */
        }
    </style>
    <script>
        function mostrarPreguntas() {
            const checkboxSi = document.getElementById('si');
            const preguntasAdicionales = document.getElementById('preguntasAdicionales');
            const listaProfesores = document.getElementById('listaProfesores');
            const calendarioHora = document.getElementById('calendarioHora');
            const campoHora = document.getElementById('campoHora');

            if (checkboxSi.checked) {
                preguntasAdicionales.classList.remove('hidden'); // Muestra preguntas adicionales
                listaProfesores.classList.remove('hidden'); // Muestra la lista de profesores
                calendarioHora.classList.remove('hidden'); // Muestra la fecha
                campoHora.classList.add('hidden'); // Oculta el campo de hora
            } else {
                preguntasAdicionales.classList.add('hidden'); // Oculta preguntas adicionales
                listaProfesores.classList.add('hidden'); // Oculta la lista de profesores
                calendarioHora.classList.remove('hidden'); // Muestra la fecha
                campoHora.classList.remove('hidden'); // Muestra el campo de hora
            }
        }
    </script>

</head>
<body>
    <form action="../../Controller/procesarJusti.php" method="POST" enctype="multipart/form-data">
        <h1>Solicitar Justificante</h1>
        <hr>

        <?php
            include '../../Controller/mostrarMotivos.php';
            //crear instancia 
            $motivo = new showMotivs($conexion);
            //obtener motivos
            $resultMotivo = $motivo->mostrarMotivos();    
        ?>

        <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error'] ?></p>
        <?php } ?>

        <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success'] ?></p>
        <?php } ?>

        <!-- Información del estudiante -->
        <div class="mb-3">
            <i class="fa-solid fa-user"></i>
            <label class="form-label">Nombre Completo (Iniciando por apellido)</label>
            <input type="text" name="NombreCom" placeholder="Nombre Completo" required>
        </div>

        <div class="mb-3">
            <i class="fa-brands fa-google-scholar"></i>
            <label>Matrícula (Mayúscula)</label>
            <input type="text" name="Matricula" placeholder="Matrícula" required>
        </div>

        <div class="mb-3">
            <i class="fa-solid fa-chalkboard-user"></i>
            <label>Cuatrimestre (Número)</label>
            <input type="number" name="Cuatri" placeholder="Cuatrimestre" required>
        </div>

        <div class="mb-3">
            <i class="fa-solid fa-user-group"></i>
            <label>Grupo</label>
            <input type="text" name="Grupo" placeholder="Grupo" required>
        </div>

        <div class="mb-3">
            <i class="fa-solid fa-graduation-cap"></i>
            <label for="Carrera">Carrera</label>
            <select name="Carrera" id="Carrera" class="form-select" required>
                <option value="" disabled selected>Selecciona tu carrera</option>
                <option value="ITI">ITI</option>
                <option value="IET">IET</option>
            </select>
        </div>

        <div class="mb-3">
            <i class="fa-solid fa-chalkboard-user"></i>
            <label>Período</label>
            <input type="text" name="peri" placeholder="Periodo" required>
        </div>

        <hr>
        
        <label for="motivo">Motivo:</label>
        <select id="motivo" name="opciones" required>
            <?php
            if (!empty($resultMotivo)) {
                ?>
                    <option value="" disabled selected>Selecciona un motivo</option>
                <?php
                foreach ($resultMotivo as $row) {  
                    echo '<option value="' . htmlspecialchars($row['tipo']) . '">' . htmlspecialchars($row['tipo']) . '</option>';
                }
            } else {
                echo '<option value="">No hay motivos disponibles</option>';
            }
            ?>
        </select>

        <br> 
        <label>¿Te ausentaste todo el día?</label><br>
        <input type="radio" id="si" name="info" value="si" onclick="mostrarPreguntas()" required>
        <label for="si">Sí</label><br>
        <input type="radio" id="no" name="info" value="no" onclick="mostrarPreguntas()">
        <label for="no">No</label><br>

        <div id="calendarioHora" class="hidden">
            <br>
            <h3>Por favor, selecciona la fecha y hora:</h3>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" required><br><br>
        </div>

        <div id="preguntasAdicionales" class="hidden">
            <h3>Por favor, selecciona a los profesores con los que tuviste clase:</h3>
            <div id="listaProfesores" class="hidden">
                <?php
                $prof = new Profesor($conexion);
                $resultProfesor = $prof->obtenerProfesores();
                if (mysqli_num_rows($resultProfesor) > 0) {
                    while ($row = mysqli_fetch_assoc($resultProfesor)) {
                        $nombreCompleto = $row['nombreProf'] . " " . $row['apellidoProf'];
                        echo "<input type='checkbox' name='profesores[]' value='$nombreCompleto'> $nombreCompleto <br>";
                    }
                } else {
                    echo "No se encontraron profesores.";
                }
                ?>
                <br><br>
            </div>
        </div>

        
        <!-- Campo de fecha -->
        <div id="calendarioHora2" class="hidden" >
            <br>
            <h3>Por favor, selecciona la fecha y hora:</h3>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha2" name="fecha2"><br><br>
        </div>
        
         <!-- Campo de hora (se muestra solo cuando selecciona "No") -->
        <div id="campoHora">
            <label for="hora">Hora inicio:</label>
            <input type="time" id="hora" name="hora" min="7:00" max="21:00"><br><br>
            <label for="horaFinal">Hora Final:</label>
            <input type="time" id="horaFinal" name="horaFinal" min="7:00" max="21:00"><br><br>
        </div>

        <label for="evidencia">Sube una evidencia (imagen o PDF):</label>
        <input type="file" name="evidencia" accept=".jpg, .jpeg, .png, .pdf" required>

        <div class="form_container">                    
            <button type="submit" class="formulario_btn">Solicitar</button>                   
        </div> 
        <a href="InicioAlumno.php">Regresar</a>
    </form>
</body>
</html>
