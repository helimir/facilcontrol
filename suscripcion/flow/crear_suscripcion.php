<?php
/**
 * Ejemplo de creaci�n de una orden de cobro, iniciando una transacci�n de pago
 * Utiliza el m�todo payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	//"subscriptionId"=> "sus_azcyjj9ycd",
	"planId"=> "F-DIARIOCL",
	"plan_name"=> "Suscipcion Diaria",
	"customerId"=> "cus_na4fda70e2",
);

//Define el metodo a usar
$serviceName = "subscription/create";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

$responseData = json_encode($response, true);
echo $responseData;

#echo $response['subscriptionId'];

#$invoices=$response['invoices'];
#foreach($invoices as $invoice) {
#    echo $invoice['id'];
#	echo $invoice['subscriptionId'];
#	echo $invoice['subscriptionId'];
#}

#echo $invoices['id'];
#echo $invoices['subscriptionId'];
#echo $invoices['customerId'];

#foreach ($response as $objeto) {
#	echo $objeto['invoices']['id']."</br>";
#	echo $objeto['invoices']['subscriptionId']."</br>";
#	echo $objeto['invoices']['customerId'];
#}

// Verificar la respuesta
#if ($response['subscriptionId']!="" ) {
#    echo "Suscripcion Creada ";
#} else {
	#echo "Error al crear suscripcion ";
#}

?>