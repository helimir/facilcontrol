<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['file'])) {
        $targetDir = "doc/";
        $targetFile = $targetDir . basename($_FILES['file']['name']);
        
        // Crear el directorio si no existe
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Intentar mover el archivo subido
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
            echo "El archivo ha sido cargado exitosamente.";
        } else {
            echo "Lo siento, hubo un error al cargar su archivo.";
        }
    } else {
        echo "No se ha recibido ning�n archivo.";
    }
} else {
    echo "M�todo de solicitud no permitido.";
}
?>