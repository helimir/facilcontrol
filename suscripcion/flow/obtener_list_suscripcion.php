<?php
/**
 * Ejemplo de creación de una orden de cobro, iniciando una transacción de pago
 * Utiliza el método payment/create
 */
include('../config/config.php');
require(__DIR__."/lib/FlowApi.class.php");

//Prepara el arreglo de datos
$params = array(
	#"subscriptionId"=> "sus_jda874dd5b",
	"planId"=> "F-DIARIOCL",
	"limit"=> 100,
	#"status"=> 1,
);

//Define el metodo a usar
$serviceName = "subscription/list";

// Instancia la clase FlowApi
$flowApi = new FlowApi;

// Ejecuta el servicio
$response = $flowApi->send($serviceName, $params,"GET");

$dates=$response['data'];
$i=0;
$i3=0;
foreach($dates as $date) {

	$params2 = array(
		"subscriptionId"=> $date['subscriptionId'],
		"planId"=> $date['planId'],	
	);

	$serviceName2 = "subscription/get";	
	$response2 = $flowApi->send($serviceName2, $params2,"GET");
	$invoices=$response2['invoices'];

	echo "<br>";
	echo "Num: ".$i."<br>";
	echo "Id Sucripcion: ".$date['subscriptionId']."<br>";
	echo "Nombre: ".$date['name']."<br>";
	echo "Cliente: ".$date['customerId']."<br>";
	echo "Creado: ".$date['created']."<br>";
	echo "Inicio: ".$date['subscription_start']."<br>";
	echo "Fin: ".$date['subscription_end']."<br>";
	echo "Periodo Inicio: ".$date['period_start']."<br>";
	echo "Periodo fin: ".$date['period_end']."<br>";
	echo "Periodo Prueba: ".$date['trial_period_days']."<br>";
	echo "Inicio Prueba: ".$date['trial_start']."<br>";
	echo "Fin Prueba: ".$date['trial_end']."<br>";
	echo "Cancelar al final de periodo actual: ".$date['cancel_at_period_end']."<br>";
	echo "Fecha cancelacion: ".$date['cancel_at']."<br>";
	echo "Proxima factura: ".$date['next_invoice_date']."<br>";
	echo "Status: ".$date['status']."<br>";
	echo "Id Plan: ".$date['planId']."<br>";
	echo "Id Plan Externo: ".$date['planExternalId']."<br>";
	echo "Numero periodos vigencia: ".$response2['periods_number']."<br>";
	echo "dias hasta vencimiento: ".$response2['days_until_due']."<br>";
	echo "Morosidad: ".$date['morose']."<br>";
	echo "FACTURAS ";
	

	#$query_sus=mysqli_query($con,"INSERT INTO suscripciones (subscriptionId,custorm_id,plan,inicio,fin,periodo_inicio,periodo_fin,proxima_factura,periodo_prueba,prueba_inicio,prueba_fin,cancelar_al_fin_periodo,numero_periodos,dias_hasta_vencimiento,morosidad,idplan,idplannombre,creado,estado) VALUES ('".$date['subscriptionId']."','".$date['customerId']."','Diario','".$date['subscription_start']."','".$date['subscription_end']."','".$date['period_start']."','".$date['period_end']."','".$date['next_invoice_date']."','".$date['trial_period_days']."','".$date['period_start']."','".$date['period_end']."','".$date['cancel_at_period_end']."','".$response2['periods_number']."','".$response2['days_until_due']."','".$date['morose']."','".$date['planId']."','".$date['planExternalId']."','".$date['created']."','".$date['status']."'  ) ");

	#if ($query_sus) {
		$i2=0;
		foreach($invoices as $invoice) {
			echo "<br>";
			echo "Num factura: ".$i2."<br>";
			echo "id Factura: ".$invoice['id']."<br>";
			echo "suscripcion: ".$invoice['subscriptionId']."<br>";
			echo "cliente: ".$invoice['customerId']."<br>";		
			echo "creada: ".$invoice['created']."<br>";
			echo "asunto: ".$invoice['subject']."<br>";
			echo "moneda: ".$invoice['currency']."<br>";
			echo "Monto: ".number_format($invoice['amount'], 0, ",", ".")."<br>";
			echo "Inicio Periodo: ".$invoice['period_start']."<br>";
			echo "Fin periodo: ".$invoice['period_end']."<br>";
			echo "intentos de cobro: ".$invoice['attemp_count']."<br>";
			echo "cobrar: ".$invoice['attemped']."<br>";
			echo "Proximo intento de cobro: ".$invoice['next_attemp_date']."<br>";
			echo "Fecha moroso: ".$invoice['due_date']."<br>";
			echo "Status factura: ".$invoice['status']."<br>";
			echo "------------------------------------------";
			$i2++;
			$i3++;
			$monto=number_format($invoice['amount'], 0, ",", ".");
			#$query_factura=mysqli_query($con,"INSERT INTO facturas (id_invoice,subscriptionId,custorm_id,asunto,currency,amount,period_start,period_end,attemp_count,attemped,next_attemp_date,due_date,creado,estado) 
			#VALUES 
			#('".$invoice['id']."','".$invoice['subscriptionId']."','".$invoice['customerId']."','".$invoice['subject']."','".$invoice['currency']."','$monto','".$invoice['period_start']."','".$invoice['period_end']."','".$invoice['attemp_count']."','".$invoice['attemped']."','".$invoice['next_attemp_date']."','".$invoice['due_date']."','".$invoice['created']."','".$invoice['status']."');   ");

		}

		#if ($query_factura) {
			#$query_update=mysqli_query($con,"UPDATE registro SET subscriptionId='".$date['subscriptionId']."', planid='".$date['planExternalId']."', metodo='Tarjeta', plan='Diario', nombre_plan='Suscripcion Diaria', monto='$monto', estado='1'  where id_custorm='".$date['customerId']."' ");
		#}
	#}
		
	
	
	
	
	$i++;
}
echo "<br> Total: ".$i."<br>";
echo "<br> facturas: ".$i3;


?>