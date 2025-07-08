<?php
header('Content-Type: application/json');

// Credenciales de Flow Sandbox
$apiKey = '640370F5-956D-4BDF-9DA4-871A5523LEC5'; // Reemplaza con tu API Key de Sandbox
$secretKey = '2266d7042a2852822b6f85be14aedd031c834c13'; // Reemplaza con tu Secret Key de Sandbox

// Datos recibidos desde el frontend
//$data = json_decode(file_get_contents('php://input'), true);
$email = 'helimirlopez@gmail.com';
$planId = 'F-ANUALCL';

// URL de la API de Flow Sandbox
$flowApiUrl = 'https://sandbox.flow.cl/api/subscription/create';

// Datos para la solicitud
$payload = [
    'planId' => $planId,
    'customerId' => $email,
    'url_confirmation' => 'https://facilcontrol.cl/flowprueba/confirmacion.php', // URL de confirmación
    'url_return' => 'https://facilcontrol.cl/flowprueba/retorno.php', // URL de retorno
];



// Configuración de cURL
$ch = curl_init($flowApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("$apiKey:$secretKey"),
]);

// Ejecutar la solicitud
$response = curl_exec($ch);
curl_close($ch);

// Decodificar la respuesta
$responseData = json_decode($response, true);

if (isset($responseData['url'])) {
    echo json_encode(['url' => $responseData['url']]);
} else {
    echo json_encode(['error' => 'Error al crear la suscripción']);
}
?>