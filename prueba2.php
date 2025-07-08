<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de Archivos</title>
    <style>
        #progress {
            width: 100%;
            background-color: #f3f3f3;
            border: 1px solid #ccc;
            height: 20px;
            display: none;
        }
        #progress-bar {
            width: 0;
            height: 100%;
            background-color: #4caf50;
        }
    </style>
</head>
<body>

    <h1>Cargar Archivo</h1>
    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Subir</button>
    </form>
    <div id="progress">
        <div id="progress-bar"></div>
    </div>
    <div id="status"></div>

    <script>
        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'upload.php', true);

            // Mostrar la barra de progreso
            const progressBar = document.getElementById('progress');
            const progress = document.getElementById('progress-bar');
            progressBar.style.display = 'block';

            // Actualizar la barra de progreso
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progress.style.width = percentComplete + '%';
                }
            });

            // Manejar la respuesta del servidor
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('status').innerText = 'Archivo cargado con éxito.';
                } else {
                    document.getElementById('status').innerText = 'Error al cargar el archivo.';
                }
                progressBar.style.display = 'none'; // Ocultar barra de progreso
            };

            xhr.send(formData);
        });
    </script>

</body>
</html>