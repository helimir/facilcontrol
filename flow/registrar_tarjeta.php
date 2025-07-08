<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require("lib/FlowApi.class.php");

//Para datos opcionales campo "optional" prepara un arreglo JSON
#$optional = array(
	#"rut" => "9999999-9",
	#"otroDato" => "otroDato"
#);
#$optional = json_encode($optional);

//Prepara el arreglo de datos
$params = array(
	"customerId"=> "cus_g670397837",
	"url"=> "https://www.sandbox.flow.cl/app/customer/disclaimer.php",
	#"token"=> "33AB4429003EA480C7B4F679B11278D7C3E6A6CT",
	"url_return"=>Config::get("BASEURL")."/result.php",
	#"urlConfirmation" => Config::get("BASEURL")."/confirm.php",
	#"urlReturn" => Config::get("BASEURL")."/result.php",
	//"optional" => $optional
);
//Define el metodo a usar
$serviceName = "customer/register";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

$responseData=json_encode($response);
echo $responseData;

//Prepara url para redireccionar el browser del pagador
$redirect = $response["url"]."?token=".$response["token"];
#header("location:$redirect");

echo $redirect;

#if ($response["token"]!='') {       
#	echo $redirect;
#} else {
#	echo 1;
#} 

?>