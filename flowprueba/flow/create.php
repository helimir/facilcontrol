<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

//if (defined('BASEPATH')) exit('No direct script access allowed');
//require(__DIR__ . "/lib/FlowApi.class.php");
//class Flow extends FlowApi {
//    public function _construct() {
//        parent::_construct();
// }
//} 

//Para datos opcionales campo "optional" prepara un arreglo JSON
//$optional = array(
//	"rut" => "9999999-9",
//	"otroDato" => "otroDato"
//);
//$optional = json_encode($optional);

//Prepara el arreglo de datos
$params = array(
	"commerceOrder" => rand(1100,2000),
	"subject" => "Pago de prueba",
	"currency" => "CLP",
	"amount" => 354,
	"email" => "helimirlopez@gmail.com",
	"paymentMethod" => 9,
	"urlConfirmation" => Config::get("BASEURL")."/confirm.php",
	"urlReturn" => Config::get("BASEURL")."/result.php",
	//"optional" => $optional
);
//Define el metodo a usar
$serviceName = "payment/create";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");

//Prepara url para redireccionar el browser del pagador
$redirect = $response["url"]."?token=".$response["token"];
header("location:$redirect");

?>