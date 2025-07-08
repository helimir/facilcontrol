<?php
/**
 * Ejemplo de creaci�n de una orden de cobro, iniciando una transacci�n de pago
 * Utiliza el m�todo payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	"customerId"=> "cus_n8706c6e0f",
	"externalId"=> "1111111-3",
);

//Define el metodo a usar
$serviceName = "customer/edit";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

$responseData = json_encode($response, true);
echo $responseData

// Verificar la respuesta
#if ($response['customerId']=="" ) {
#    echo "Error al editar el cliente: ";
#} else {
	#echo "Cliente Editado con éxito.";    
#}

?>