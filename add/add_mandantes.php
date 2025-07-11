<?php
/**
 * @author lolkittens
 * @copyright 2021
 */

include "../config/config.php"; 

require_once('../PHPMailer/Exception.php');
require_once('../PHPMailer/PHPMailer.php');
require_once('../PHPMailer/SMTP.php');
                            
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
                            
$mail = new PHPMailer; 

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());


function make_date(){
    return strftime("%d-%m-%Y H:i:s", time());
}

$fecha =make_date();

$giro=isset($_POST['giro']) ? $_POST['giro']: '';$_POST['giro'];
$descripcion=isset($_POST['descripcion']) ? $_POST['descripcion']: '';
$nombre_fantasia=isset($_POST['nombre_fantasia']) ? $_POST['nombre_fantasia']: '';
$razon_social=isset($_POST['razon_social']) ? $_POST['razon_social']: '';
$rut_empresa=isset($_POST['rut_empresa']) ? $_POST['rut_empresa']: '';
$rut_representante=isset($_POST['rut_representante']) ? $_POST['rut_representante']: '';
$representante=isset($_POST['representante']) ? $_POST['representante']: '';
$region_com=isset($_POST['region_com']) ? $_POST['region_com']: '';
$comuna_com=isset($_POST['comuna_com']) ? $_POST['comuna_com']: '';
$region_mat==isset($_POST['region_mat']) ? $_POST['region_mat']: '';
$comuna_mat=isset($_POST['comuna_mat']) ? $_POST['comuna_mat']: '';
$administrador=isset($_POST['administrador']) ? $_POST['administrador']: '';
$fono=isset($_POST['fono']) ? $_POST['fono']: '';
$email=isset($_POST['email']) ? $_POST['email']: '';
$direccion=isset($_POST['direccion_emp']) ? $_POST['direccion_emp']: '';
$dualidad=isset($_POST['dualidad']) ? $_POST['dualidad']: '';

$sql=mysqli_query($con,"select * from users where usuario='$rut_empresa' and nivel='2' ");
$result=mysqli_num_rows($sql);
$crear_contratista=FALSE;

if ($result>0) {
   echo 2;
} else {
    $sql_mandantes=mysqli_query($con,"insert into mandantes (giro,descripcion_giro,nombre_fantasia,razon_social,rut_empresa,rut_representante,representante_legal,dir_comercial_region,dir_comercial_comuna,dir_matriz_region,dir_matriz_comuna,administrador,fono,email,creado_mandante,direccion,usuario) values ('$giro','$descripcion','$nombre_fantasia','$razon_social','$rut_empresa','$rut_representante','$representante','$region_com','$comuna_com','$region_mat','$comuna_mat','$administrador','$fono','$email','$date','$direccion','".$_SESSION['usuario']."') ");
   
    $resultado =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_facilcontrol' AND TABLE_NAME = 'mandantes' ");
    $auto= mysqli_fetch_array($resultado); 
    $id_mandante=$auto['AUTO_INCREMENT']-1; 

    if ($sql_mandantes) {
        
        
            if ($_POST['dualidad']==1) {
                mysqli_query($con,"insert into contratistas (giro,nombre_fantasia,razon_social,rut,rut_rep,representante,direccion_empresa,dir_comercial_region,dir_comercial_comuna,administrador,fono,email,creado_contratista,mandante,descripcion_giro,dualidad,acreditada,usuario) values ('$giro','$nombre_fantasia','$razon_social','$rut_empresa','$rut_representante','$representante','$direccion','$region_com','$comuna_com','$administrador','$fono','$email', '$date','$id_mandante','$descripcion','1','1','".$_SESSION['usuario']."') ");

                $resultado_c =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_facilcontrol' AND TABLE_NAME = 'contratistas' ");           
                $auto_c= mysqli_fetch_array($resultado_c); 
                $id_contratista=$auto_c['AUTO_INCREMENT']-1;

                mysqli_query($con,"insert into contratistas_mandantes (contratista,mandante,creado,acreditada) values ('$id_contratista','$id_mandante','$date','1') ");
                mysqli_query($con,"update mandantes set dualidad='1' where id_mandante='$id_mandante' ");
                #$control='Informacion de Contratista';
                #$item='Gestion Informacion de Contratista';
                #$nivel=2;
                #$usuario=$_SESSION['usuario'];
                #$envia=$mandante;
                #$recibe=$id_contratista;
                #$tipo=1;
                #$url="perfil_contratista.php";
                #$accion="Gestionar informacion";
                #$mensaje="Debe completar informacion sobre la contratista"; 
                #$query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contratista,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$control','$id_mandante','$id_contratista','$control') ");

               $crear_contratista=TRUE; 
               $valor=4;
            } else {
                $valor=2;
            }
            
            $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            $ca = strlen($Caracteres);
            $ca--;
            $Hash = '';
            for ($x = 1; $x <= 60; $x++) {
                $Posicao = rand(0, $ca);
                $Hash .= substr($Caracteres, $Posicao, 1);
            }
            
            $sql_user=mysqli_query($con,"insert into users (nombre_user,usuario,email_user, nivel,creado_user) values ('$administrador','$rut_empresa','$email','$valor','$date')  "  );
            
            $resultado2 =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_facilcontrol' AND TABLE_NAME = 'users' ");
            $auto= mysqli_fetch_array($resultado2); 
            $id=$auto['AUTO_INCREMENT']-1; 
         
            $sql_token=mysqli_query($con,"insert into tokens (id_user,token,creado_token) values ('$id','$Hash','$date')  "  );
            
            $correo=$email;
            $correo2='helimirlopez@gmail.com';
            $nombre=$administrador;
            
            if ($crear_contratista==FALSE) {
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
                }
                
                /* Lets make sure all tables have defaults */
                table td {
                    vertical-align: top;
                }
                
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
                body {
                    background-color: #f6f6f6;
                }
                
                .body-wrap {
                    background-color: #f6f6f6;
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
                    border: 1px solid #e9e9e9;
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
                    color: #1ab394;
                    text-decoration: underline;
                }
                
                .btn-primary {
                    text-decoration: none;
                    color: #FFF;
                    background-color: #1ab394;
                    border: solid #1ab394;
                    border-width: 5px 10px;
                    line-height: 2;
                    font-weight: bold;
                    text-align: center;
                    cursor: pointer;
                    display: inline-block;
                    border-radius: 5px;
                    text-transform: capitalize;
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
                    padding: 20px;
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
                    background: #010829;
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
        
                <table class="body-wrap">
                    <tr>
                        <td></td>
                        <td class="container" width="600">
                            <div class="content">
                                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                       <td class="alert alert-good">
                                            <img style="height: 100px ;" src="https://facilcontrol.cl/add/logo_fc.png" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-wrap">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="content-block">
                                                        Estimado:<strong>'.$administrador.'</strong>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        Por favor validar el siguiente correo para activar su ingreso a la plataforma.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        <a style="background: #010829;color:#ffffff;padding: 2%" href="https://facilcontrol.cl/validation.php?token='.$Hash.'" class="btn">Validar Cuenta</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        Muchas Gracias, Equipo FacilControl.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <div class="footer">
                                    <table width="100%">
                                        <tr>
                                            <td class="aligncenter content-block">Email desde Plataforma FacilControl.</td>
                                        </tr>
                                    </table>
                                </div></div>
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
                $mail->FromName = 'FacilControl';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
                
                //CONFIGURACI�N DEL MENSAJE, EL CUERPO DEL MENSAJE SERA UNA PLANTILLA HTML QUE INCLUYE IMAGEN Y CSS
                $mail->Subject = 'Validacion de Mandante'; //asunto del mensaje
                
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
                $mail->addAddress($correo,$nombre);
                $mail->addCC('helimirlopez@gmail.com');
                $mail->addCC('arielguzmansardy@gmail.com');
                                           
                $mail->IsHTML(true);
                $mail->send();
                
            } else {
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
                }
                
                /* Lets make sure all tables have defaults */
                table td {
                    vertical-align: top;
                }
                
                /* -------------------------------------
                    BODY & CONTAINER
                ------------------------------------- */
                body {
                    background-color: #f6f6f6;
                }
                
                .body-wrap {
                    background-color: #f6f6f6;
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
                    border: 1px solid #e9e9e9;
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
                    color: #1ab394;
                    text-decoration: underline;
                }
                
                .btn-primary {
                    text-decoration: none;
                    color: #FFF;
                    background-color: #1ab394;
                    border: solid #1ab394;
                    border-width: 5px 10px;
                    line-height: 2;
                    font-weight: bold;
                    text-align: center;
                    cursor: pointer;
                    display: inline-block;
                    border-radius: 5px;
                    text-transform: capitalize;
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
                    padding: 20px;
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
                    background: #010829;
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
        
                <table class="body-wrap">
                    <tr>
                        <td></td>
                        <td class="container" width="600">
                            <div class="content">
                                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="alert alert-good">
                                            <img style="height: 100px ;" src="https://facilcontrol.cl/add/logo_fc.png" >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-wrap">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="content-block">
                                                        Estimado:<strong>'.$administrador.'</strong>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        Por favor validar el siguiente correo para activar su ingreso a la plataforma.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        <a style="background: #010829;color:#ffffff;padding: 2%" href="https://facilcontrol.cl/validation.php?token='.$Hash.'" class="btn">Validar Cuenta</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        Muchas Gracias, Equipo FacilControl.
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <div class="footer">
                                    <table width="100%">
                                        <tr>
                                            <td class="aligncenter content-block">Email desde Plataforma FacilControl.</td>
                                        </tr>
                                    </table>
                                </div></div>
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
                $mail->FromName = 'FacilControl';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/
                
                //CONFIGURACI�N DEL MENSAJE, EL CUERPO DEL MENSAJE SERA UNA PLANTILLA HTML QUE INCLUYE IMAGEN Y CSS
                $mail->Subject = 'Validacion de Mandante/Contratista'; //asunto del mensaje
                
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
                $mail->addAddress($correo,$nombre);
                $mail->addCC('helimirlopez@gmail.com');
                $mail->addCC('arielguzmansardy@gmail.com');
                                           
                $mail->IsHTML(true);
                $mail->send();  
            }
            echo 0;
     } else {
         echo 1;
    }
 }   

?>