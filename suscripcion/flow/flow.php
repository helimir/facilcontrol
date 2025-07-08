<?php
session_start(); 
require(__DIR__."/lib/FlowApi.class.php");
       
        $email=$_POST['email'];
        $monto=$_POST['monto'];
        $plan=$_POST['plan'];
        #$monto=400;
        $token=$_POST['token'];

        
       $params = array(
        	"commerceOrder" => rand(1100,2000),
        	"subject" => $plan,
        	"currency" => "CLP",
        	"amount" => $monto,
        	"email" => $email,
        	"paymentMethod" => 1,
        	"urlConfirmation" => Config::get("BASEURL")."/confirm.php",
        	"urlReturn" => Config::get("BASEURL")."/result.php?solicitud=".$token
        	//"optional" => $optional
        );
    
        
        //Define el metodo a usar
        $serviceName = "payment/create";
        
        // Instancia la clase FlowApi
        $flowApi = new FlowApi;
        
        // Ejecuta el servicio
        $response = $flowApi->send($serviceName, $params,"POST");
        
        #$enlace='https://flow.cl/app/web/pay.php?token='.$response["token"];
        $enlace='https://sandbox.flow.cl/app/web/pay.php?token='.$response["token"];
                    
        #$query_pagos=mysqli_query($con,"update pagos set enlace='$enlace', fecha_inicio_plan='$fecha_actual', fecha_fin_plan='$fecha_fin'  where idcontratista='".$_POST['id']."'   ");
        
        if ($response["token"]!='') {       
             echo $enlace;
        } else {
             echo 1;
        }  


                 


?>