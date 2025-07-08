<?php
// Suscripción basada en el token recibido

$apiKey = '2266d7042a2852822b6f85be14aedd031c834c13'; // Tu clave privada de Flow
$paymentToken = $_POST['payment_token']; // Token recibido de Flow
$email = $_POST['email']; // Correo electrónico del cliente
$plan = $_POST['plan']; // Plan seleccionado por el cliente (mensual o anual)

// Endpoint de la API de Flow para suscripciones
$apiUrl = 'https://api.flow.cl/subscriptions';

// Definir el plan y el precio en base a la opción seleccionada
$planDetails = [
    'mensual' => [
        'name' => 'Plan Mensual',
        'price' => 1000, // Monto del plan mensual
        'interval' => 'month'
    ],
    'anual' => [
        'name' => 'Plan Anual',
        'price' => 12000, // Monto del plan anual
        'interval' => 'year'
    ]
];

// Asegúrate de que el plan recibido sea válido
if (!isset($planDetails[$plan])) {
    die('Plan no válido');
}

// Definir los detalles de la suscripción
$planData = $planDetails[$plan];

// Datos a enviar a Flow
$data = [
    'email' => $email,
    'payment_token' => $paymentToken,
    'plan' => $planData['name'],
    'price' => $planData['price'],
    'interval' => $planData['interval'], // 'month' o 'year'
    'currency' => 'CLP' // Puedes ajustar la moneda según tus necesidades
];

// Iniciar cURL para hacer la solicitud
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiKey,
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Ejecutar la solicitud
$response = curl_exec($ch);

// Verificar si ocurrió algún error
if (curl_errno($ch)) {
    echo 'Error en la solicitud: ' . curl_error($ch);
} else {
    $responseData = json_decode($response, true);
    if (isset($responseData['status']) && $responseData['status'] == 'success') {
        echo '¡Suscripción exitosa! Has elegido el plan: ' . $planData['name'];
    } else {
        echo 'Error al procesar el pago: ' . $responseData['message'];
    }
}

// Cerrar cURL
curl_close($ch);
?>