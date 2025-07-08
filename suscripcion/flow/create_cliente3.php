<?php
// Configuraci�n de la API de Flow
$apiURL = "https://sandbox.flow.cl/api/customer/create"; // Endpoint de creaci�n de clientes
$apiKey = "640370F5-956D-4BDF-9DA4-871A5523LEC5"; // Reemplaza con tu API Key
$secretKey = "2266d7042a2852822b6f85be14aedd031c834c13"; // Reemplaza con tu Secret Key

// Datos del cliente a registrar
$data = [
   "customerId"=> "cus_onoolldvzx",
	"created"=> "2025-02-23 12:33:33",
	"email"=> "helimirlopez@yahoo.es",
	"name"=> "Pedro Raul Perez",
	"pay_mode"=> "auto",
	"creditCardType"=> "Visa",
	"last4CardDigits"=> "4425",
	"externalId"=> "11111111-1",
	"status"=> "1",
	"registerDate"=> "2017-07-21 14:22:01",
];

// Convertimos los datos a JSON
$jsonData = json_encode($data);

// Configuraci�n de la petici�n HTTP con cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

$response  = curl_exec($ch);
#if($response  === false) {
	#$error = curl_error($ch);
	#throw new Exception($error, 1);
#}

#$httpCode = curl_getinfo($ch);
curl_close($ch);

#return array("output" =>$output, "info" => $info);

// Ejecutamos la petici�n
#$response = curl_exec($ch);
#$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
#curl_close($ch);

// Verificamos la respuesta
#if ($httpCode == 200) {
#    $result = json_decode($response, true);
#    echo "Cliente creado con éxito. ID: " . $result["customerId"];
#} else {
#    echo "Error al crear el cliente: " . $response;
#}
?>
