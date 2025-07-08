<?php
include('../config/config.php');
require("lib/FlowApi.class.php");

$query=mysqli_query($con,"SELECT f.*, r.nombre,r.plan,r.monto FROM facturas as f LEFT JOIN registro as r On r.id_custorm=f.custorm_id where f.estado='0' order by f.id_invoice desc ");
$suscripciones=mysqli_query($con,"SELECT * FROM suscripciones");

#buscar nuevas facturas
foreach ($suscripciones as $row) {
    $params = array(
		"subscriptionId"=> $row['subscriptionId'],
		"planId"=> $row['idplannombre'],	
	);

    $serviceName = "subscription/get";
    $flowApi = new FlowApi;
    $response = $flowApi->send($serviceName, $params,"GET");
	$invoices=$response['invoices'];

    foreach($invoices as $invoice) {

        $query_fac=mysqli_query($con,"SELECT * FROM facturas WHERE id_invoice='".$invoice['id']."' ");
        $existe_factura=mysqli_num_rows($query_fac);

        if ($existe_factura==0) {
            $monto=number_format($invoice['amount'], 0, ",", ".");
            $query_factura=mysqli_query($con,"INSERT INTO facturas (id_invoice,subscriptionId,custorm_id,asunto,currency,amount,period_start,period_end,attemp_count,attemped,next_attemp_date,due_date,creado,estado) 
            VALUES 
            ('".$invoice['id']."','".$invoice['subscriptionId']."','".$invoice['customerId']."','".$invoice['subject']."','".$invoice['currency']."','$monto','".$invoice['period_start']."','".$invoice['period_end']."','".$invoice['attemp_count']."','".$invoice['attemped']."','".$invoice['next_attemp_date']."','".$invoice['due_date']."','".$invoice['created']."','".$invoice['status']."');   ");

            if ($query_factura) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
 


?>