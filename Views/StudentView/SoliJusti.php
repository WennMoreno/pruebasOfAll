<?php  include '../../Model/Conexion.php'; ?>

<!DOCTYPE html>
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

            <?php if(isset($_GET['error'])){ ?>
                <p class="error"><?php echo $_GET['error'] ?></p>
            <?php } ?>

            <br>

            <?php if(isset($_GET['success'])){ ?>
                <p class="success"><?php echo $_GET['success'] ?></p>
            <?php } ?>

            <!-- Información del estudiante -->
            <div class="mb-3">
            <i class="fa-solid fa-user"></i>
            <label class="form-label">Nombre Completo (Iniciando por apellido)</label>
            <input type="text" name="NombreCom" placeholder="Nombre Completo" >
            </div>

            <div class="mb-3">
            <i class="fa-brands fa-google-scholar"></i>
            <label>Matrícula (Mayúscula)</label>
            <input type="text" name="Matricula" placeholder="Matrícula" >
            </div>

            <div class="mb-3">
            <i class="fa-solid fa-chalkboard-user"></i>
            <label>Cuatrimestre (Número)</label>
            <input type="number" name="Cuatri" placeholder="Cuatrimestre">
            </div>

            <div class="mb-3">
            <i class="fa-solid fa-user-group"></i>
            <label>Grupo</label>
            <input type="text" name="Grupo" placeholder="Grupo" >
            </div>

            <div class="mb-3">
                <i class="fa-solid fa-graduation-cap"></i>
                <label for="Carrera">Carrera</label>
                <select name="Carrera" id="Carrera" class="form-select">
                    <option value="" disabled selected>Selecciona tu carrera</option>
                    <option value="ITI">ITI</option>
                    <option value="IET">IET</option>
                </select>
            </div>

            
            <div class="mb-3">
            <i class="fa-solid fa-chalkboard-user"></i>
            <label>Período</label>
            <input type="text" name="peri" placeholder="Periodo" >
            </div>

            <hr>
            <?php
                $sqlMotivo = "SELECT tipo FROM motivo"; 
                $resultMotivo = mysqli_query($conexion, $sqlMotivo);
            ?>
            <!-- 3. Generar el formulario HTML -->
            <label for="motivo">Motivo:</label>
            <select id="motivo" name="opciones" >
                <?php
                // Verificar si hay resultados
                if ($resultMotivo->num_rows > 0) {
                    // Salida de datos de cada fila
                    while ($row = $resultMotivo->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['tipo']) . '">' . htmlspecialchars($row['tipo']) . '</option>';
                    }
                } else {
                    echo '<option value="">No hay motivos disponibles</option>';
                }
                ?>
            </select>
            <br>
            <!-- Pregunta si el estudiante se ausentó todo el día -->
            <label>¿Te ausentaste todo el día?</label><br>
            <input type="radio" id="si" name="info" value="si" onclick="mostrarPreguntas()" >
            <label for="si">Sí</label><br>
            <input type="radio" id="no" name="info" value="no" onclick="mostrarPreguntas()">
            <label for="no">No</label><br>
                    <?php
                        // Consulta para obtener los nombres de los profesores
                        $sqlProfesor = "
                        SELECT nombreProf, apellidoProf  FROM profesor ";
                        $resultProfesor = mysqli_query($conexion, $sqlProfesor);
                    ?> 
                        <!-- Campo de fecha -->
                        <div id="calendarioHora" class="hidden">
                            <br>
                            <h3>Por favor, selecciona la fecha y hora:</h3>
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" ><br><br>
                        </div>

                        <!-- Preguntas adicionales que se muestran si seleccionan "Sí" -->
                        <div id="preguntasAdicionales" class="hidden">
                            <h3>Por favor, selecciona a los profesores con los que tuviste clase:</h3>
                            <!-- Lista de profesores que se muestra si seleccionan "Sí" -->
                        <div id="listaProfesores" class="hidden">
                        <?php
                        
                        // Mostrar los resultados en checkboxes
                        if (mysqli_num_rows($resultProfesor) > 0) {
                            // Generar checkbox para cada profesor
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
                <label for="hora">Hora incio:</label>
                <input type="time" id="hora" name="hora" min="7:00" max="21:00"><br><br>

                <label for="horaFinal">Hora Final:</label>
                <input type="time" id="horaFinal" name="horaFinal" min="7:00" max="21:00"><br><br>
            </div>
   
            <!-- Campo para subir archivo -->
            <label for="evidencia">Sube una evidencia (imagen o PDF):</label>
            <input type="file" name="evidencia" accept=".jpg, .jpeg, .png, .pdf">

            <div class="form_container">                    
                <button type="submit" class="formulario_btn" >Solicitar </button>                   
            </div> 
            <a href="InicioAlumno.php">Regresar</a>
        </form>
</body>
</html>
