<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal con barra de progreso</title>

<style>
  .modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 300px;
    max-width: 90%;
}

/* Barra de progreso */
.progress-bar {
    width: 100%;
    background-color: #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    margin: 20px 0;
}

.progress {
    height: 20px;
    width: 0;
    background-color: #4caf50;
    transition: width 0.4s;
}
</style> 

<script>

$(document).ready(function () {
    const $modal = $("#progressModal");
    const $progressBar = $(".progress");
    let progressInterval;

    // Función para mostrar el modal y comenzar la barra de progreso
    function showModalWithProgress() {
        $modal.show();
        $progressBar.css("width", "0%");

        // Simular el progreso de la barra
        let progress = 0;
        progressInterval = setInterval(function () {
            if (progress < 90) {
                progress += 10; // Incremento en porcentaje
                $progressBar.css("width", progress + "%");
            }
        }, 400);
    }

    // Función para ocultar el modal
    function hideModal() {
        $modal.hide();
        clearInterval(progressInterval);
    }

    // Evento al hacer clic en el botón para iniciar la solicitud
    $("#launchRequest").click(function () {
        showModalWithProgress();

        // Ejemplo de solicitud AJAX simulada
        $.ajax({
            url: "https://jsonplaceholder.typicode.com/posts",
            method: "GET",
            success: function (response) {
                console.log("Respuesta recibida:", response);
            },
            error: function () {
                alert("Error en la solicitud");
            },
            complete: function () {
                // Finalizar la barra de progreso y ocultar el modal
                $progressBar.css("width", "100%");
                setTimeout(hideModal, 500); // Espera para que el progreso final se muestre
            },
        });
    });
});

</script>


</head>
<body>
    <button id="launchRequest">Enviar Solicitud AJAX</button>

    <!-- Modal -->
    <div id="progressModal" class="modal">
        <div class="modal-content">
            <h2>Procesando...</h2>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <p>Esperando respuesta del servidor...</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
</body>
</html>