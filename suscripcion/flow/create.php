<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
require(__DIR__."/lib/FlowApi.class.php");

$email=$_POST['email'];
        $monto=$_POST['monto'];
        $plan=$_POST['plan'];
        #$monto=400;
        $token=$_POST['token'];

//Para datos opcionales campo "optional" prepara un arreglo JSON
$optional = array(
	"rut" => "9999999-9",
	"otroDato" => "otroDato"
);
$optional = json_encode($optional);

//Prepara el arreglo de datos
$params = array(
	"commerceOrder" => rand(1100,2000),
	"subject" => $plan,
	"currency" => "CLP",
	"amount" => $monto,
	"email" => $email,
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
#header("location:$redirect");

if ($response["token"]!='') {       
	echo $redirect;
} else {
	echo 1;
} 

?>