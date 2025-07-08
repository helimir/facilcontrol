<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de Archivos con Modal</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .modal {
            display: none; 
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; 
            padding: 20px;
            border: 1px solid #888;
            width: 80%; 
        }
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
    <button id="openModal">Abrir Modal</button>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" style="float:right;cursor:pointer;">&times;</span>
            <h2>Cargar Archivo</h2>
            <form id="uploadForm" enctype="multipart/form-data">
                <input type="file" name="file" required>
                <button type="submit">Subir</button>
            </form>
            <div id="progress">
                <div id="progress-bar"></div>
            </div>
            <div id="status"></div>
        </div>
    </div>

    <script>
        document.getElementById('openModal').onclick = function() {
            document.getElementById('myModal').style.display = 'block';
        }

        document.getElementById('closeModal').onclick = function() {
            document.getElementById('myModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('myModal')) {
                document.getElementById('myModal').style.display = 'none';
            }
        }

        document.getElementById('uploadForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', 'upload.php', true);

            const progressBar = document.getElementById('progress');
            const progress = document.getElementById('progress-bar');
            progressBar.style.display = 'block';

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progress.style.width = percentComplete + '%';
                }
            });

            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('status').innerText = 'Archivo cargado con éxito.';
                } else {
                    document.getElementById('status').innerText = 'Error al cargar el archivo.';
                }
                progressBar.style.display = 'none';
            };

            xhr.send(formData);
        });
    </script>

</body>
</html>