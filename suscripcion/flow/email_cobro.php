<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"commerceOrder"=> "935996",
	"requestDate"=> "2017-07-21 12:32:11",
	"status" =>1,
	"subject"=> "Cargo de prueba Enrique Chirinos",
	"currency"=> "CLP",
	"amount"=> 500,
	"payer"=> "helimirlopez@gamil.com",
);

//Define el metodo a usar
$serviceName = "customer/createEmail";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

$responseData=json_encode($response);
echo $responseData;

?>