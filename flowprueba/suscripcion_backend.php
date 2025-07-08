<?php
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verifica el estado del pago o suscripción
if ($data['status'] == 'paid') {
    // Procesar pago exitoso
    echo "Pago recibido con éxito.";
} else {
    // Manejar error
    echo "Hubo un problema con el pago.";
}
?>