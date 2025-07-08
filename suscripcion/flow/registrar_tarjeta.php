<?php
session_start();
include('config/config.php');
require("lib/FlowApi.class.php");

$id_custorm=$_POST['id_custorm'];
$metodo=$_POST['metodo'];
$solicitud=$_POST['solicitud'];


$params = array(
	"customerId"=> $id_custorm,
	"url"=> "https://www.sandbox.flow.cl/app/customer/disclaimer.php",
	"url_return"=>Config::get("BASEURL")."/result.php",
);
//Define el metodo a usar
$serviceName = "customer/register";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"POST");
$token_registro=$response['token'];
#$responseData=json_encode($response);
#echo $responseData;

$query=mysqli_query($con,"update registro set metodo='".$metodo."', token_registro_tdc='$token_registro' where id_registro='$solicitud' ");

if ($query) {
	//Prepara url para redireccionar el browser del pagador
	$redirect = $response["url"]."?token=".$response["token"];
	header("location:$redirect");
} else {
	header("location:../finalizar.php");
}


?>