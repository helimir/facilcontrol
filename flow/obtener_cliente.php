<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"customerId"=> "cus_h34b868aa1",
	"externalId"=> "14233530-0",
	"created"=> "2025-02-26",
	"email"=> "helimirlopez@gmail.com",
	"name"=> "Tuilo Jaramillo",
	"pay_mode"=> "auto",
	"creditCardType"=> "Visa",
	"last4CardDigits"=> "6623",
	"externalId"=> "14233531-8",
	"status"=> "1",
	"registerDate"=> "2017-07-21 14:22:01"
);

//Define el metodo a usar
$serviceName = "customer/get";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");
$responseData = json_encode($response, true);
echo $responseData

// Verificar la respuesta
#if ($response['customerId']=="" ) {
 #   echo "Error al crear el cliente:wwww ";
#} else {
#	echo "Cliente creado con éxito. ID del cliente: " . $response['customerId'];    
#}

?>