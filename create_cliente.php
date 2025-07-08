<?php
/**
 * Ejemplo de creaci�n de una orden de cobro, iniciando una transacci�n de pago
 * Utiliza el m�todo payment/create
 */
require("lib/FlowApi.class.php"); 

//Prepara el arreglo de datos
$params = array(
	"customerId"=> "100",
	"created"=> "2025-02-23 12:33:33",
	"email"=> "helimirlopez@yahoo.es",
	"name"=> "Marcos Perez Jimenez",	
	"externalId"=> "77777777-1",
	"status"=> "1",
);

//Define el metodo a usar
$serviceName = "customer/create";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

// Verificar la respuesta
if ($response['customerId']=="" ) {
    echo "Error al crear el cliente. ";
} else {
	echo "Cliente creado con éxito. ID del cliente: " . $response['customerId'];    
}

?>