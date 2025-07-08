<?php
// Aquí puedes procesar la confirmación del pago
// Flow Sandbox enviará datos por POST, como el token y el status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $status = $_POST['status'];

    // Guardar el estado de la suscripción en tu base de datos
    // ...

    echo "Suscripción confirmada con éxito.";
} else {
    echo "Acceso no autorizado.";
}
?>