<?php
/**
 * @author lolkittens
 * @copyright 2021
 */
session_start();

$url_host=$_SERVER['HTTP_HOST'];
 if ($url_host=='localhost') {
    $url_actual=$url_host.'/facilcontrol/';
 } else {
    $url_actual='https://'.$url_host.'/';
 }

include "../config/config.php";
//session_destroy($_SESSION['sms']);

require_once('../PHPMailer/Exception.php');
require_once('../PHPMailer/PHPMailer.php');
require_once('../PHPMailer/SMTP.php');
                            
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
                            
$mail = new PHPMailer; 

if (isset($_SESSION['usuario'])) { 

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$query_config=mysqli_query($con,"select * from configuracion ");
$result_config=mysqli_fetch_array($query_config);

$usuario=$_SESSION['usuario'];

function make_date(){
    return strftime("%d-%m-%Y", time());
}

$fecha =make_date();

$contratista=$_POST['contratista'] ?? '';
$nombre_contrato=$_POST['nombre_contrato'] ?? '';
$cargos=serialize(json_decode(stripslashes($_POST['cargos'])));
$vehiculos=serialize(json_decode(stripslashes($_POST['vehiculos'])));


//$cargos=serialize($_SESSION['cargos']);


if ($_SESSION['nivel']==1)  {  
    $mandante=$_POST['mandante'] ?? '';
} else {    
    $mandante=$_SESSION['mandante'];
    $sql_mandante=mysqli_query($con,"select * from mandantes where id_mandante='$mandante'  ");
    $result_mandante=mysqli_fetch_array($sql_mandante);
    $nom_mandante=$result_mandante['razon_social'];
}



if ($_POST['accion']=="crear_contrato") { 
       
        mysqli_query($con,"delete from cargos_asignados where mandante='$mandante' ");
        mysqli_query($con,"delete from autos_asignados where mandante='$mandante' ");
              
        # obtener informacion de la contratista
        $sql_contratista=mysqli_query($con,"select * from contratistas where id_contratista='".$contratista."'  ");
        $result=mysqli_fetch_array($sql_contratista);    
        $rut=$result['rut'];
        
        # obtenet notificacion de Crear Trabajadores
        $sql_n=mysqli_query($con,"select * from notificaciones where contratista='$contratista' and item='Crear Trabajadores' ");
        $result_n=mysqli_fetch_array($sql_n); 
               
        $sql_contrato=mysqli_query($con,"insert into contratos (contratista,nombre_contrato,cargos,creado_contrato,mandante,vehiculos,rut) values ('$contratista','$nombre_contrato','$cargos','$date','$mandante','$vehiculos','$rut') ");
        
        // seleccionar ultimo id de contratos
        $query_idcontrato =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_facilcontrol' AND TABLE_NAME = 'contratos' ");
        $result_idcontrato= mysqli_fetch_array($query_idcontrato); 
        $idcontrato=$result_idcontrato['AUTO_INCREMENT']-1;
        
                
            if ($sql_contrato) {
                
                #subir el archivo
                if ($_FILES["archivo"]["name"]) { 
                    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$idcontrato.'/';
                    $nombre=$nombre_contrato.".pdf";
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    }
                    $archivo=$carpeta.$nombre;
                    if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo) ) {
                        # guardar url contrato
                        $url_contrato='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$idcontrato.'/'.$nombre_contrato.".pdf";
                        $udapte_c=mysqli_query($con,"update contratos set url='$url_contrato' where id_contrato='$idcontrato' ");
                    }
                } else {
                   $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$idcontrato.'/';                   
                   if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    } 
                }
                
                
                $query_perfiles=mysqli_query($con,"select count(id_perfil) as cant_perfiles from perfiles where id_mandante='$mandante' limit 1 ");
                $result_perfiles=mysqli_fetch_array($query_perfiles); 

                $query_perfiles_v=mysqli_query($con,"select count(id_perfil) as cant_perfiles from perfiles where id_mandante='$mandante' and tipo='1' limit 1 ");
                $result_perfiles_v=mysqli_fetch_array($query_perfiles_v); 
                
                if ($result_perfiles['cant_perfiles']==0) {
                    #notificacion que falta perfiles no solo lectura
                    $item='Crear Perfiles Cargos'; 
                    $nivel=2;
                    $tipo=2;
                    $envia=$mandante;
                    $recibe=$mandante;
                    $mensaje="Debe crear perfiles de cargos para los contratos.";
                    $accion="Crear perfiles de cargo";
                    $url="crear_perfil.php";
                    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$rut') ");
                } 

                if ($result_perfiles_v['cant_perfiles']==0) {
                    #notificacion que falta perfiles no solo lectura
                    $item='Crear Perfiles Vehiculos'; 
                    $nivel=2;
                    $tipo=3;
                    $envia=$mandante;
                    $recibe=$mandante;
                    $mensaje="Debe crear perfiles de vehículos/maquinarias para los contratos.";
                    $accion="Crear perfiles de cargo";
                    $url="crear_perfil_vehiculos.php";
                    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$rut') ");
                }
                
                // notificacion asignar perfiles a contrato
                $item='Asignar Perfiles Cargos'; 
                $nivel=2; 
                $tipo=2;
                $envia=$mandante;
                $recibe=$mandante;
                $mensaje="Debe asignar perfiles de cargos al contrato <b>$nombre_contrato</b>";
                $accion="Asignar perfiles de cargo";
                $url="list_contratos.php";
                mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contrato,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$idcontrato','$mandante','$idcontrato','$rut') "); 

                 // notificacion asignar perfiles a contrato
                 $item='Asignar Perfiles Vehiculos'; 
                 $nivel=2; 
                 $tipo=3;
                 $envia=$mandante;
                 $recibe=$mandante;
                 $mensaje="Debe asignar perfiles de vehiculos/maquinarias al contrato <b>$nombre_contrato</b>";
                 $accion="Asignar perfiles de cargo";
                 $url="list_contratos.php";
                 mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contrato,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$idcontrato','$mandante','$idcontrato','$rut') "); 
                
                 // seleccionar id de notificacion
                $query_noti =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_facilcontrol' AND TABLE_NAME = 'notificaciones' ");
                $result_noti= mysqli_fetch_array($query_noti); 
                $idnoti=$result_noti['AUTO_INCREMENT']-1;
                
                // guardar id de la notificacion en contratos
                $update_contratos=mysqli_query($con,"update contratos set noti='$idnoti' where id_contrato='$idcontrato' ");
                   
                
                $query_trab=mysqli_query($con,"select count(idtrabajador) as cant_trabajador from trabajador where contratista='$contratista' limit 1 ");
                $result_trab=mysqli_fetch_array($query_trab); 

                $query_vehi=mysqli_query($con,"select count(id_auto) as cant_autos from autos where contratista='$contratista' limit 1 ");
                $result_vehi=mysqli_fetch_array($query_vehi); 
                
                # NOTIFICACIONES AL CONTRATISTA 
                # enviar notificacion si no hay trabajadores creados no solo lectura
                if ($result_trab['cant_trabajador']==0) {
                    $item='Crear Trabajadores';
                    $nivel=2;
                    $tipo=2;
                    $envia=$mandante;
                    $recibe=$contratista;
                    $mensaje="Debe crear trabajadores para asignar a los contratos.";
                    $accion="Crear trabajadores";
                    $url="crear_trabajador.php";
                    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$rut') ");
                }

                if ($result_vehi['cant_autos']==0) {
                    $item='Crear Vehiculos';
                    $nivel=2;
                    $tipo=3;
                    $envia=$mandante;
                    $recibe=$contratista;
                    $mensaje="Debe crear vehhículos/maquinarias para asignar a los contratos.";
                    $accion="Crear vehiculos";
                    $url="crear_auto.php";
                    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$rut') ");
                }

                $item='Asignar Trabajadores';
                $nivel=2;
                $tipo=2;
                $envia=$mandante;
                $recibe=$contratista;
                $mensaje="Debe asignar trabajadores al contrato <b>$nombre_contrato</b> del mandante <b>$nom_mandante</b>.";
                $accion="Crear trabajadores";
                $url="list_contratos_contratistas.php";
                mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$idcontrato','$idcontrato','$rut') ");

                $item='Asignar Vehiculos';
                $nivel=2;
                $tipo=3;
                $envia=$mandante;
                $recibe=$contratista;
                $mensaje="Debe asignar vehiculo/maquinaria al contrato <b>$nombre_contrato</b> del mandante <b>$nom_mandante</b>.";
                $accion="Crear trabajadores";
                $url="list_contratos_contratistas.php";
                mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,rut) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$idcontrato','$idcontrato','$rut') ");
                
                
                $correo=$result['email'];
                $nombre=$result['administrador'];
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
                                            <img style="height: 100px ;" src="'.$url_actual.'add/logo_fc.png" >
                                        </td>
                                    </tr>   
                                    <tr>
                                        <td class="content-wrap">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td class="content-block">
                                                        Estimado:<strong>'.$nombre.'</strong>.<br/>
                                                        Contratista:<strong>'.$result['razon_social'].'</strong>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        El presente es para informale que el Mandante <b>'.$result_mandante['razon_social'].'</b> le ha asignado el contrato <b>'.$nombre_contrato.'</b>.<br/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        Ingrese a la plataforma <b>FacilControl</b> por medio del siguiente enlace:<br/>
                                                        <a href="'.$url_actual.'admin.php">Inicio de FacionControl</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-block">
                                                        Muchas Gracias.<br/>
                                                        <b>Equipo FacilControl.</b>
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
                $mail->Host = 'mail.clubi.cl';   /*Servidor SMTP*/
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
                $mail->Subject = 'Contrato Asignado'; //asunto del mensaje
                
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
                                           
                $mail->IsHTML(true);
                $mail->send();
                
                
                
                
                //header("Location: " . $_SERVER["HTTP_REFERER"]);
                //echo "<script> window.location.href='../list_contratos.php'; </script>"; 
                
                
                echo 0;
             } else {
               echo 1;
            }
 }   
 
if ($_POST['crearcontrato']=="actualizar") {
    
    $query=mysqli_query($con,"select * from contratos where id_contrato='$id_contrato' ");
    $result=mysqli_fetch_array($query);
    
    $cargos_comp=$_SESSION['cargos'];
    $cargos_actuales=unserialize($result['cargos']);
    $cant_cargos_act=count($cargos_actuales);
    $cant_cargos_comp=count($_SESSION['cargos']);
    $total_cargos= $cant_cargos_act+$cant_cargos_comp;
    
    // si hay nuevos cargos
    if ($total_cargos>$cant_cargos_act) {
       $perfiles_actuales=unserialize($result['perfiles']); 
    
        $i=$cant_cargos_act;
        foreach ($cargos_comp as $row) {
          $cargos_actuales[$i]=$row;
          $perfiles_actuales[$i]=0;
          $i++;
        }
        $cargos=serialize($cargos_actuales);
        $perfiles=serialize($perfiles_actuales);
    }
         
    
    
    $cargos=serialize($cargos_actuales);
    
    $sql_update_perfil=mysqli_query($con,"update perfiles_cargos set cargos='$cargos', perfiles='$perfiles' where contrato='$id_contrato'"); 
    $sql_update=mysqli_query($con,"update contratos set contratista='$contratista', nombre_contrato='$nombre_contrato', cargos='$cargos', perfiles='$perfiles' where id_contrato='$id_contrato' ");
 
    if ($sql_update) {
        
                #subir el archivo
                if ($_FILES["archivo"]["name"]) { 
                    $carpeta = '../doc/contratos/'.$mandante.'/'.$contratista.'/';
                    $nombre=$nombre_contrato.'_'.$result['rut'].".pdf";
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    }
                    $archivo=$carpeta.$nombre;
                    if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo) ) {
                        
                    }
                }
        
        echo 2;
    }  else { 
       echo 3;
    } 
 }

} else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>