<?php
session_start();
include('../config/config.php');
require(__DIR__."/lib/FlowApi.class.php");

$token=$_POST['token'];
$monto=$_POST['monto'];
$id_custorm=$_POST['id_custorm'];
$metodo=$_POST['metodo'];
$solicitud=$_POST['solicitud'];

$params = array(
	"customerId"=> $id_custorm,
	"url"=> "https://www.sandbox.flow.cl/app/customer/disclaimer.php",
	#"token"=> "33AB4429003EA480C7B4F679B11278D7C3E6A6CT",
	"url_return"=>"https://facilcontrol.cl/suscripcion/flow/result.php?token=".$token,
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
$token=$response['token'];
$query=mysqli_query($con,"update registro set monto='$monto', metodo='$metodo', token_registro_tdc='$token' where id_registro='$solicitud' ");

//Prepara url para redireccionar el browser del pagador
$redirect = $response['url']."?token=".$response['token'];
#header("location:$redirect");
echo $redirect;



?>