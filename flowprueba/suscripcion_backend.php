<?php
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Verifica el estado del pago o suscripci�n
if ($data['status'] == 'paid') {
    // Procesar pago exitoso
    echo "Pago recibido con �xito.";
} else {
    // Manejar error
    echo "Hubo un problema con el pago.";
}
?>