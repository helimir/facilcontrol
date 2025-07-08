<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"subscriptionId"=> "sus_nf05ac7db4",
	"planId"=> "F-DIARIACL",	
);

//Define el metodo a usar
$serviceName = "subscription/get";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"GET");
#$responseData = json_encode($response, true);
#echo $responseData

$paymentData = $response['invoices'];
$responseData = json_encode($paymentData, true);
echo $responseData;

#$responseData = json_encode($paymentData, true);
#echo $responseData;




?>