<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
include('../config/config.php');
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	#"customerId"=> "cus_jc18f91696",
	#"externalId"=> "32",
	"limit"=> 100,
	"star"=> 1,
	"status"=> 1,
);

//Define el metodo a usar
$serviceName = "customer/list";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"GET");
$responseData = json_encode($response, true);
#echo $responseData

$clientes=$response['data'];

#"pay_mode":"auto","creditCardType":"Visa","last4CardDigits":"6623","externalId":"33","status":0,"registerDate":"2025-02-23 10:52:44"
$i=1;
$ip="190.46.84.231";
$pais="Chile";
$codigo="CL";
$raww=123;
$pass=password_hash($raww, PASSWORD_DEFAULT);

$Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$ca = strlen($Caracteres);
$ca--;
$token = '';
for ($x = 1; $x <= 40; $x++) {
    $Posicao = rand(0, $ca);
    $token.= substr($Caracteres, $Posicao, 1);
}

foreach($clientes as $cliente) {
	echo "<br>";
	echo "Num:".$i."<br>";
	echo "id_customer:".$cliente['customerId']."<br>";
	echo "id_externo:".$cliente['externalId']."<br>";
	echo "email:".$cliente['email']."<br>";
	echo "Nombre:".$cliente['name']."<br>";
	echo "Modo Pago:".$cliente['pay_mode']."<br>";
	echo "Tarjeta:".$cliente['creditCardType']."<br>";
	echo "4 ultimo:".$cliente['last4CardDigits']."<br>";	
	echo "Registro:".$cliente['registerDate']."<br>";
	echo "creado:".$cliente['created']."<br>";
	echo "estado:".$cliente['status']."<br>";
	$i++;
	if ($cliente['last4CardDigits']=="") {
		$estado=0;
	} else {
		$estado=1;
	}
    $nick=substr($cliente['name'],0,4);
	#$query=mysqli_query($con,"INSERT INTO registro (id_registro,id_custorm,nombre,email,modo_pago,tipo_tarjeta,numero_tarjeta,pass,raww,pais,ip,codigo,token,statu,estado,creado,registrado,nick,confirmar) VALUES ('".$cliente['externalId']."','".$cliente['customerId']."','".$cliente['name']."','".$cliente['email']."','".$cliente['pay_mode']."','".$cliente['creditCardType']."','".$cliente['last4CardDigits']."','$pass','$raww','$pais','$ip','$codigo','$token','".$cliente['status']."','$estado','".$cliente['created']."','".$cliente['registerDate']."','$nick',1)");
}
echo "<br> Total:".$i;

// Verificar la respuesta
#if ($response['customerId']=="" ) {
 #   echo "Error al crear el cliente:wwww ";
#} else {
#	echo "Cliente creado con éxito. ID del cliente: " . $response['customerId'];    
#}

?>