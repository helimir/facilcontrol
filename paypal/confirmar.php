<?php
// Verificar la respuesta de PayPal para confirmar la suscripción
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $paypal_url = 'https://api.sandbox.paypal.com/v1/checkout/orders/' . $token . '/capture';

    // Realiza la autenticación de la API de PayPal
    $headers = array(
        'Authorization: Bearer ' . 'tu_access_token',  // Usar el token de acceso obtenido al hacer login
        'Content-Type: application/json'
    );

    // Realiza la captura del pago
    $ch = curl_init($paypal_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    $response_data = json_decode($response, true);

    if (isset($response_data['status']) && $response_data['status'] == 'COMPLETED') {
        echo "Pago exitoso. Gracias por tu suscripción.";
    } else {
        echo "Error en el pago. Intenta nuevamente.";
    }
} else {
    echo "Error: No se encontró el token de pago.";
}
?>