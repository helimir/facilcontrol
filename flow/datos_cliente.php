<?php
/**
 * Ejemplo de creaci�n de una orden de cobro, iniciando una transacci�n de pago
 * Utiliza el m�todo payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"customerId"=> "cus_q78e896772",
);

//Define el metodo a usar
$serviceName = "customer/get";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

$responseData = json_encode($response, true);
echo $responseData;

// Verificar la respuesta
#if ($response['status']==0 ) {
#    echo "Cliente eliminado: ";
#} else {##
	#echo "Error al crear el cliente: ";
#}

?>