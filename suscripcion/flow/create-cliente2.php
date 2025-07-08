<?php
// Configuraci�n de la API de Flow
$flowApiUrl = 'https://sandbox.flow.cl/api/customer/create';
$apiKey = "640370F5-956D-4BDF-9DA4-871A5523LEC5"; // Reemplaza con tu API Key
$secretKey = "2266d7042a2852822b6f85be14aedd031c834c13"; // Reemplaza con tu Secret Key

// Datos del cliente a crear
$customerData = [
    "customerId"=> "cus_onoolldvzx",
	"created"=> "2025-02-23 12:33:33",
	"email"=> "helimirlopez@yahoo.es",
	"name"=> "Pedro Raul Perez",
	"pay_mode"=> "auto",
	"creditCardType"=> "Visa",
	"last4CardDigits"=> "4425",
	"externalId"=> "14233531-8",
	"status"=> "1",
	"registerDate"=> "2017-07-21 14:22:01",
];

// Configuraci�n de cURL
$ch = curl_init($flowApiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode("$apiKey:$secretKey"),
]);

// Ejecutar la solicitud
$response = curl_exec($ch);
curl_close($ch);

// Decodificar la respuesta
$responseData = json_decode($response, true);

// Verificar la respuesta
if (isset($responseData['customerId'])) {
    echo "Cliente creado con �xito. ID del cliente: " . $responseData['customerId'];
} else {
    echo "Error al crear el cliente: ";
    print_r($responseData); // Mostrar detalles del error
}
?>