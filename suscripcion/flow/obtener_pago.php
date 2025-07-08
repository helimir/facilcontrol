<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"customerId"=> "sus_m1af6755f8",
	#"name"=> "Salomon Rincon",		
);

//Define el metodo a usar
$serviceName = "customer/getCharges";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

$responseData=json_encode($response);
echo $responseData; 

// Verificar la respuesta
#if ($response['customerId']=="" ) {
#    echo "Error al crear el cliente:wwww ";
#} else {
#echo "Cliente creado con éxito. ID del cliente: " . $response['customerId'];    
#}

?>