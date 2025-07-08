<?php
session_start();
    require_once('../PHPMailer/Exception.php');
    require_once('../PHPMailer/PHPMailer.php');
    require_once('../PHPMailer/SMTP.php');
                            
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    $mail = new PHPMailer;

if (isset($_SESSION['usuario'])   ) {    
    include "../config/config.php";
       
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d');

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
    
    $doc=serialize($_POST['doc_contratista']);
    $cant_doc=count($_POST['doc_contratista']);
    
    $administrador=$_POST['administrador'];
    $razon_social=$_POST['nom_contratista'];
    $email=$_POST['email'];
    
    
         
    $query_i=mysqli_query($con,"insert into contratistas_mandantes (contratista,mandante,creado,doc_contratista,cant_doc) values ('".$_POST['id_contratista']."','".$_SESSION['mandante']."','$date','$doc','$cant_doc' ) ");
       
        if ($query_i) {
            
            $query=mysqli_query($con,"select * from mandantes where id_mandante='".$_SESSION['mandante']."' ");
            $result=mysqli_fetch_array($query);   
                   
            $mandante=$result['razon_social'];
            $correo=$email;
            $nombre=$administrador;          
                       
            # documentos solicitados
            foreach ($_POST['doc_contratista'] as $row) {
                $query_d=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$row'  ");
                $result_d=mysqli_fetch_array($query_d);

                #notificacion que falta perfiles solo lectura
                $item='Gestion Documentos de Contratista';
                $nivel=2;
                $usuario=$_SESSION['usuario'];
                $envia=$_SESSION['mandante'];
                $recibe=$_POST['id_contratista'];
                $tipo=1;
                $url="gestion_documentos.php";
                $accion="Gestionar documentos";
                $mensaje="El Mandante <b>$mandante</b> ha solicitado la gestion del documento <b>".$result_d['documento']."</b> para la acreditacion de la Contratista</b>."; 
                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contratista,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$result_d['documento']."','".$_SESSION['mandante']."','".$_POST['id_contratista']."','".$result_d['documento']."') ");

         }
            
            
            
            $query_u=mysqli_query($con,"update contratistas set multiple=1 where rut='".$_POST['rut']."' ");
         
            
            
            
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
                                                        <img style="height: 100px ;" src="https://'.$result_config['url'].'/add/logo_fc.png" >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="content-wrap">
                                                        <table width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td class="content-block">
                                                                    Estimado:<strong>'.$administrador.'</strong>.<br/>
                                                                    Contratista:<strong>'.$razon_social.'</strong>.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="content-block">
                                                                    El mandante <strong>'.$mandante.'</strong> le ha agregado en la plataforma <strong>FacilControl</strong>.<br/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="content-block">
                                                                    Ingrese a la plataforma <b>FacilControl</b> por medio del siguiente enlace:<br/>
                                                                    <a href="https://'.$result_config['url'].'/admin.php">Inicio de FacionControl</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="content-block">
                                                                    Muchas Gracias.<br/>
                                                                    <strong>Equipo FacilControl</strong>.
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
                            $mail->Subject = 'Contratista Agregada'; //asunto del mensaje
                            
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
            
            
            echo 0;
        } else {
            echo 1;
        }

} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
    

?>