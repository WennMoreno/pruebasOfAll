<?php  include '../../Model/Conexion.php'; ?>

<?php

// Obtener todas las solicitudes pendientes
$query = "SELECT * FROM justificante WHERE estado = 'Pendiente'";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes Pendientes</title>
    <!-- Vincular el archivo CSS -->
    <link rel="stylesheet" href="../Resources/CSS/StyleAdmin.css">
</head>
<body>

<div class="container">
    <!-- Bandeja de solicitudes (estilo Gmail) -->
    <div class="sidebar">
        <h2>Solicitudes Pendientes</h2>

        <?php
        // Mostrar la lista de solicitudes
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="solicitud-item" data-id="' . $row['idJusti'] . '">';
            echo '<strong>' . $row['nombre'] . '</strong><br>';
            echo '<small>' . $row['fecha'] . ' | ' . $row['horaInicio'] . '</small><br>';
            echo '<span>' . $row['motivo'] . '</span>';
            echo '</div>';
        }

        ?>
    </div>

    <!-- Detalles de la solicitud seleccionada -->
    <div class="content">
        <h2>Detalles de la Solicitud</h2>
        <div id="detallesSolicitud">
            <p>Seleccione una solicitud para ver más detalles.</p>
        </div>
    </div>


</div>

<script>
    // Función para mostrar los detalles de la solicitud cuando se hace clic
    const solicitudItems = document.querySelectorAll('.solicitud-item');
    solicitudItems.forEach(item => {
    item.addEventListener('click', function() {
        const solicitudId = this.getAttribute('data-id');

        // Quitar clase 'active' de cualquier solicitud previamente seleccionada
        solicitudItems.forEach(i => i.classList.remove('active'));
        this.classList.add('active');

        fetch('../../Controller/detallesSoli.php?id=' + solicitudId)
        .then(response => response.text()) // Cambia a .text() para obtener HTML
        .then(html => {
            const detallesDiv = document.getElementById('detallesSolicitud');
            detallesDiv.innerHTML = html; // Inserta el HTML directamente
        })
        .catch(error => {
            console.error("Error al obtener los detalles:", error);
            const detallesDiv = document.getElementById('detallesSolicitud');
            detallesDiv.innerHTML = `<p>Error al cargar los detalles de la solicitud.</p>`;
        });

    });
});


    // Función para aceptar la solicitud
    function aceptarSolicitud(idSolicitud) {
    if (confirm("¿Desea aceptar esta solicitud y generar el PDF?")) {
        const formData = new FormData();
        formData.append('idJusti', idSolicitud); // Agregar el ID de la solicitud

        // Hacer una solicitud POST al archivo PHP
        fetch('aceptar_solicitud.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Aquí puedes manejar la respuesta, que puede ser HTML
            document.getElementById('detallesSolicitud').innerHTML = data;
            location.reload(); // Recargar para actualizar la lista
        })
        .catch(error => {
            console.error("Error al aceptar la solicitud:", error);
            alert("Error al aceptar la solicitud.");
        });
    }
}

</script>

</body>
</html>
