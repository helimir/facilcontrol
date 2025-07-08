<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"customerId"=>"cus_ie44b52efa",
	//"flowOrder"=> 2581311,
	"commerceOrder"=> "936835",
	#"requestDate"=> "2017-07-21 12:32:11",
	#"status" =>1,
	"subject"=> "Suscripción Diaria API - período: 2025-02-27 / 2025-02-27 00:00:00",
	#"currency"=> "CLP",
	"amount"=> 500,
	#"payer"=> "helimirlopez@gamil.com",
		//"optional"=> {
		//"RUT"=> "27069177-3",
		//"ID"=> "45"
	//},
	//"pending_info" {
	//	"media"=> "Multicaja",
	//	"date"=> "2017-07-21 10:30:12"
	//},
	//"paymentData": {
	//	"date"=> "2017-07-21 12:32:11",
	//	"media"=> "webpay",
	//	"conversionDate"=> "2017-07-21",
	//	"conversionRate"=> 1.1,
	//	"amount"=>500,
	//	"currency"=> "CLP",
	//	"fee"=> 551,
	//	"balance"=> 11499,
	//	"transferDate"=> "2017-07-24"
	//},
	//"merchantId": "string"
);

//Define el metodo a usar
$serviceName = "customer/charge";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");
#echo $response;

$responseData=json_encode($response);
echo $responseData;

// Verificar la respuesta
#if ($response['customerId']=="" ) {
#    echo "Error al efectuar cargo";
#} else {#
	#echo "Cargo efectuado";    
#}

?>