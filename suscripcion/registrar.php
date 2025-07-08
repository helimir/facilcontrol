<?php
session_start();
include('config/config.php');
date_default_timezone_set('America/Santiago');
$fecha = date('Y-m-d H:m:s', time());

require_once('PHPMailer/Exception.php');
require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/SMTP.php');
                            
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
                            
$mail = new PHPMailer; 

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$email=$_POST['email'];
$nick=$_POST['nick'];
$pass1=$_POST['pass1'];
$pass2=$_POST['pass2'];
$plan=$_POST['plan'];
$pais=$_POST['pais'];
$codigo=$_POST['codigo'];
$ip=$_POST['ip'];
$monto=$_POST['monto'];
$planid=$_POST['planid'];
$nombre_plan=$_POST['nombre_plan'];

$select1=mysqli_query($con,"select * from registro where email='$email' ");
$result=mysqli_fetch_array($select1);
$existe1=mysqli_num_rows($select1);

$Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$ca = strlen($Caracteres);
$ca--;
$Hash = '';
for ($x = 1; $x <= 40; $x++) {
    $Posicao = rand(0, $ca);
    $Hash .= substr($Caracteres, $Posicao, 1);
}

#if ($existe1>0) {
#    echo 2;
#} else {

    $select2=mysqli_query($con,"select * from registro where nick='$nick' ");
    $existe2=mysqli_num_rows($select2);

    if ($existe2>0) {
        echo 3;
    } else {
        

        $query=mysqli_query($con,"insert into registro (nombre,apellido,email,nick,plan,pass,raww,pais,codigo,ip,token,monto,creado,planid,nombre_plan) values ('$nombre','$apellido','$email','$nick','$plan','$pass1','$pass1','$pais','$codigo','$ip','$Hash','$monto','$fecha','$planid','$nombre_plan') ");
        if ($query) {

            $query =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_proyecto' AND TABLE_NAME = 'registro' ");
            $result= mysqli_fetch_array($query); 
            $id_cliente=$result['AUTO_INCREMENT']-1;

            require("lib/FlowApi.class.php");
            $cliente=$nombre.' '.$apellido;
            $params = array(
                "email"=> $email,
                "name"=> $cliente,	
                "externalId"=> $id_cliente,
            );
            $serviceName = "customer/create";
            $flowApi = new FlowApi;
            $response = $flowApi->send($serviceName, $params,"POST");

            if ($response['customerId']!="" ) {           
            
                mysqli_query($con,"update registro set id_custorm='".$response['customerId']."' where id_registro='$id_cliente' ");

                $_SESSION['cliente']=$id_cliente;
                $_SESSION['email']=$email;
                $_SESSION['nick']=$nick;
                $_SESSION['plan']=$plan;
                $_SESSION['monto']=$monto;

                                 $correo=$email;
                                 $cuerpo='
                                 <!DOCTYPE html">
                                 <html>
                                 <head>
                                     <meta name="viewport" content="width=device-width" />
                                     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                                     <title>Validacion Usuario</title>
                                 <style>
                                 
                                 /* -------------------------------------
                                     GLOBAL
                                     A very basic CSS reset
                                 ------------------------------------- */
                                 * {
                                     margin: 0;
                                     padding: 0;
                                     font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
                                     box-sizing: border-box;
                                     font-size: 14px;
                                 }
                                 
                                 img {
                                     max-width: 100%;
                                 }
                                 
                                 body {
                                     -webkit-font-smoothing: antialiased;
                                     -webkit-text-size-adjust: none;
                                     width: 100% !important;
                                     height: 100%;
                                     line-height: 1.6;
                                     background: #000000;
                                 }
                                 
                                 /* Lets make sure all tables have defaults */
                                 table td {
                                     vertical-align: top;
                                 }
                                 
                                 /* -------------------------------------
                                     BODY & CONTAINER
                                 ------------------------------------- */
                                 body {                                     
                                     background: #000000;
                                 }
                                 
                                 .body-wrap {
                                     background: #000000;
                                     width: 100%;
                                 }
                                 
                                 .container {
                                     display: block !important;
                                     max-width: 600px !important;
                                     margin: 0 auto !important;
                                     /* makes it centered */
                                     clear: both !important;
                                 }
                                 
                                 .content {
                                     max-width: 600px;
                                     margin: 0 auto;
                                     display: block;
                                     padding: 20px;
                                 }
                                 
                                 /* -------------------------------------
                                     HEADER, FOOTER, MAIN
                                 ------------------------------------- */
                                 .main {
                                     background: #fff;
                                     border: 1px solid #000000;
                                     border-radius: 3px;
                                 }
                                 
                                 .content-wrap {
                                     padding: 20px;
                                 }
                                 
                                 .content-block {
                                     padding: 0 0 20px;
                                 }
                                 
                                 .header {
                                     width: 100%;
                                     margin-bottom: 20px;
                                 }
                                 
                                 .footer {
                                     width: 100%;
                                     clear: both;
                                     color: #999;
                                     padding: 20px;
                                 }
                                 .footer a {
                                     color: #999;
                                 }
                                 .footer p, .footer a, .footer unsubscribe, .footer td {
                                     font-size: 12px;
                                 }
                                 
                                 /* -------------------------------------
                                     TYPOGRAPHY
                                 ------------------------------------- */
                                 h1, h2, h3 {
                                     font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
                                     color: #000;
                                     margin: 40px 0 0;
                                     line-height: 1.2;
                                     font-weight: 400;
                                 }
                                 
                                 h1 {
                                     font-size: 32px;
                                     font-weight: 500;
                                 }
                                 
                                 h2 {
                                     font-size: 24px;
                                 }
                                 
                                 h3 {
                                     font-size: 18px;
                                 }
                                 
                                 h4 {
                                     font-size: 14px;
                                     font-weight: 600;
                                 }
                                 
                                 p, ul, ol {
                                     margin-bottom: 10px;
                                     font-weight: normal;
                                 }
                                 p li, ul li, ol li {
                                     margin-left: 5px;
                                     list-style-position: inside;
                                 }
                                 
                                 /* -------------------------------------
                                     LINKS & BUTTONS
                                 ------------------------------------- */
                                 a {
                                     color: #ffffff;
                                     text-decoration: underline;
                                 }
                                 
                                 .btn-primary {
                                     text-decoration: none;
                                     color: #FFF;
                                     background-color: #2EB8E2;
                                     border: solid #2EB8E2;
                                     border-width: 5px 10px;
                                     line-height: 2;
                                     font-weight: bold;
                                     text-align: center;
                                     cursor: pointer;
                                     display: inline-block;
                                     text-transform: capitalize;
                                     padding:2% 4%;
                                     font-size:20px;
                                 }
                                 
                                 /* -------------------------------------
                                     OTHER STYLES THAT MIGHT BE USEFUL
                                 ------------------------------------- */
                                 .last {
                                     margin-bottom: 0;
                                 }
                                 
                                 .first {
                                     margin-top: 0;
                                 }
                                 
                                 .aligncenter {
                                     text-align: center;
                                 }
                                 
                                 .alignright {
                                     text-align: right;
                                 }
                                 
                                 .alignleft {
                                     text-align: left;
                                 }
                                 
                                 .clear {
                                     clear: both;
                                 }
                                 
                                 /* -------------------------------------
                                     ALERTS
                                     Change the class depending on warning email, good email or bad email
                                 ------------------------------------- */
                                 .alert {
                                     font-size: 16px;
                                     color: #fff;
                                     font-weight: 500;
                                     padding: 10px;
                                     text-align: center;
                                     border-radius: 3px 3px 0 0;
                                 }
                                 .alert a {
                                     color: #fff;
                                     text-decoration: none;
                                     font-weight: 500;
                                     font-size: 16px;
                                 }
                                 .alert.alert-warning {
                                     background: #f8ac59;
                                 }
                                 .alert.alert-bad {
                                     background: #ed5565;
                                 }
                                 .alert.alert-good {                                
                                     background: #000000;
                                 }
                                 
                                 /* -------------------------------------
                                     INVOICE
                                     Styles for the billing table
                                 ------------------------------------- */
                                 .invoice {
                                     margin: 40px auto;
                                     text-align: left;
                                     width: 80%;
                                 }
                                 .invoice td {
                                     padding: 5px 0;
                                 }
                                 .invoice .invoice-items {
                                     width: 100%;
                                 }
                                 .invoice .invoice-items td {
                                     border-top: #eee 1px solid;
                                 }
                                 .invoice .invoice-items .total td {
                                     border-top: 2px solid #333;
                                     border-bottom: 2px solid #333;
                                     font-weight: 700;
                                 }
                                 
                                 /* -------------------------------------
                                     RESPONSIVE AND MOBILE FRIENDLY STYLES
                                 ------------------------------------- */
                                 @media only screen and (max-width: 640px) {
                                     h1, h2, h3, h4 {
                                         font-weight: 600 !important;
                                         margin: 20px 0 5px !important;
                                     }
                                 
                                     h1 {
                                         font-size: 22px !important;
                                     }
                                 
                                     h2 {
                                         font-size: 18px !important;
                                     }
                                 
                                     h3 {
                                         font-size: 16px !important;
                                     }
                                 
                                     .container {
                                         width: 100% !important;
                                     }
                                 
                                     .content, .content-wrap {
                                         padding: 10px !important;
                                     }
                                 
                                     .invoice {
                                         width: 100% !important;
                                     }
                                 }
                                 
                                 
                                 </style>
                                 
                                 
                                 </head>
                                 
                                 <body>
                         
                                 <table style="" class="body-wrap">
                                     <tr>
                                         <td></td>
                                         <td class="container" width="600">
                                             <div class="content">
                                                 <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                         <td style="background: #000000;border:1 px #000000 solid;font-size: 16px;color: #2EB8E2;font-weight: 500;text-align:left">                                                       
                                                             <h1 style="color: #2EB8E2;font-weight:800">Preflopperfec</h1>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td style="border:1 px #000000 solid"  class="alert alert-good">                                                       
                                                             <h1 style="color: #ffffff;font-weight:800">CONFIRMACION DE CORREO ELECTRÓNICO</h1>
                                                         </td>
                                                     </tr>
                                                     <tr>
                                                         <td style="background: #262626;color: #ffffff" class="content-wrap">
                                                             <table width="100%" cellpadding="0" cellspacing="0">
                                                                 <tr>
                                                                     <td class="content-block">
                                                                         Gracias por registrarte. Para completar tu registro y activar tu cuenta, por favor verifica tu dirección de correo electrónico haciendo clic en en enlace al final del correo.
                                                                     </td>
                                                                 </tr>
                                                                 <tr>
                                                                     <td class="content-block">
                                                                        Si no solicitaste este registro, puedes ignorar este mensaje. Si tienes alguna pregunta, no dudes en contactarnos en <span style="color: #2EB8E2 !mportant">soporte@preflopperfect.com</span>.
                                                                     </td>
                                                                 </tr>                                                                                                                                                                                                  
                                                                 <tr>
                                                                     <td class="content-block">
                                                                         ¡Nos alegra tenerte con nosotros!.<br/>
                                                                         Atentamente<br/><br/>
                                                                         <strong>Equipo Preflopperfectf</strong>.
                                                                     </td>
                                                                 </tr>
                                                             </table>
                                                         </td>
                                                     </tr>
                                                 </table>
                                                 <div style="background: #000000;color:" class="footer">
                                                     <table width="100%">
                                                         <tr style="font-weight:700;">
                                                             <td class="content-block"><a style="color: #ffffff;font-size:20px" href="https://facilcontrol.cl/suscripcion/confirmar_email.php?token='.$Hash.'" target="_BLACK" class="btn btn-lg btn-primary" >Confirmar Correo</button></a>
                                                         </tr>
                                                     </table>
                                                 </div>
                                             </div>
                                         </td>
                                         <td></td>
                                     </tr>
                                 </table>
                                 
                                 </body>
                                 </html>';
                                 
                                 /*CONFIGURACI�N DE CLASE*/                            
                            $mail = new PHPMailer;  
                            $mail->isSMTP(); //Indicar que se usar� SMTP
                            $mail->CharSet = 'UTF-8';//permitir env�o de caracteres especiales (tildes y �)
                            
                            /*CONFIGURACI�N DE DEBUG (DEPURACI�N)*/
                            $mail->SMTPDebug = 0; //Mensajes de debug; 0 = no mostrar (en producci�n), 1 = de cliente, 2 = de cliente y servidor
                            $mail->Debugoutput = 'html'; //Mostrar mensajes (resultados) de depuraci�n(debug) en html
                            
                            /*CONFIGURACI�N DE PROVEEDOR DE CORREO QUE USAR� EL EMISOR(GMAIL)*/
                            $mail->Host = 'mail.facilcontrol.cl';   /*Servidor SMTP*/
                            // $mail->Host = gethostbyname('smtp.gmail.com'); // Si su red no soporta SMTP sobre IPv6
                            $mail->Port = 587; //Puerto SMTP, 587 para autenticado TLS
                            $mail->SMTPSecure = 'SSL'; //Sistema de encriptaci�n - ssl (obsoleto) o tls
                            $mail->SMTPAuth = true;//Usar autenticaci�n SMTP
                            //$mail->SMTPOptions = array(
                              //          'ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)
                                //    );//opciones para "saltarse" comprobaci�n de certificados (hace posible del env�o desde localhost)
                            
                            //CONFIGURACI�N DEL EMISOR
                            $mail->Username = 'no-responder@facilcontrol.cl';   /*Usuario, normalmente el correo electr�nico*/
                            $mail->Password = 'facilcontrol2022!!';   /*Tu contrase�a*/
                            $mail->From = 'no-responder@facilcontrol.cl';   /*Correo electr�nico que estamos autenticando*/
                            $mail->setFrom('no-responder@facilcontrol.cl', 'no-reponder');
                            $mail->FromName = 'PerflopPerfect';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
                            
                            //CONFIGURACI�N DEL MENSAJE, EL CUERPO DEL MENSAJE SERA UNA PLANTILLA HTML QUE INCLUYE IMAGEN Y CSS
                            $mail->Subject = 'Registro'; //asunto del mensaje
                            
                            //incrustar imagen para cuerpo de mensaje(no confundir con Adjuntar)
                            //$mail->AddEmbeddedImage($sImagen, 'imagen'); //ruta de archivo de imagen
                            
                            //cargar archivo css para cuerpo de mensaje
                            //$rcss = "email/styles.css";//ruta de archivo css
                            //$fcss = fopen ($rcss, "r");//abrir archivo css
                            //$scss = fread ($fcss, filesize ($rcss));//leer contenido de css
                            //fclose ($fcss);//cerrar archivo css
                            
                            //Cargar archivo html   
                            //$shtml = file_get_contents('email/billing.php');
                            //reemplazar secci�n de plantilla html con el css cargado y mensaje creado
                            //$incss  = str_replace('<style id="estilo"></style>',"<style>$scss</style>",$shtml);
                            //$cuerpo = str_replace('<d="mensaje"></body>',$mensaje,$incss);
                            $mail->Body = $cuerpo; //cuerpo del mensaje
                            $mail->AltBody = '---';//Mensaje de s�lo texto si el receptor no acepta HTML
                            
                            //CONFIGURACI�N DE RECEPTORES
                            $mail->addAddress($correo);
                            #$mail->addCC('arielguzmansardy@gmail.com');
                                                       
                            $mail->IsHTML(true);
                            $mail->send(); 
                            echo 0;
                } else {
                    echo 1;
                }
        } else {
            echo 1;
        }
    #}
}

?>