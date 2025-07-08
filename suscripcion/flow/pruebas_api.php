<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"flowOrder"=> "2603851",	
);

//Define el metodo a usar
$serviceName = "payment/getStatusByFlowOrder";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"GET");

$responseData=json_encode($response);
echo $responseData; 


?>