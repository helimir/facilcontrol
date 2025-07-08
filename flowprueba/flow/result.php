<?php
include('config.php');
date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());
#verafena57@gmail.com

require_once('PHPMailer/Exception.php');
require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/SMTP.php');
                                
Use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer;

$monto=11990;

$query=mysqli_query($con,"select i.*, c.* from ingresos as i Left Join clientes as c ON c.id_cliente=i.cliente where i.token='".$_GET['solicitud']."' ");
$result=mysqli_fetch_array($query);
$existe=mysqli_num_rows($query);

$solicitud=$result['id_ingreso'];
$cliente=$result['cliente'];
$email=$result['email'];

if ($_GET['solicitud']=='' or $existe==0) {
    echo "<script>window.location.href='../index.php'</script>";
} else {

mysqli_query($con,"update ingresos set estado='3',fecha_compra='$date' where token='".$_GET['solicitud']."' ");

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pension Justa | Informe de Pago</title>

    <link href="../assets2/img/icono-pj3.png" rel="icon">
    <link href="../assets2/img/pj180x180.png" rel="apple-touch-icon">

    <link href="../inspina\css\bootstrap.min.css" rel="stylesheet">
    <link href="../inspina\font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="../inspina\css\animate.css" rel="stylesheet">
    <link href="../inspina\css\style.css" rel="stylesheet">

      <!-- Sweet Alert -->
      <link href="../inspina\css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
      

   

   

  <style>
    .borde {
        border:1px solid;
        color: #C0C0C0;
    }

    .texto {
        color: #282828;
    }

    .boton {
        background:#7D40C5;
        border:1px #7D40C5 solid;
        color:#fff;
    }

    .boton:hover {
        background:#ff00ff;      
        border:1px #ff00ff solid;  
        color:#fff;
    }

    .boton:active {
        background:#ff00ff;      
        border:1px #ff00ff solid;  
        color:#fff;
    }

    .whatsapp {
    position:fixed;
    width:60px;
    height:60px;
    bottom:40px;
    right:30px;
    background-color:#25d366;
    color:#FFF;
    border-radius:50px;
    text-align:center;
    font-size:30px;
    z-index:100;
    }

  .whatsapp-icon {
    margin-top:15px;
    }
    

  </style>
<?php $useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match("/mobile/i", $useragent) ) { ?>
     <a title="Soporte Pension Justa" href="https://api.whatsapp.com/send?phone=56995333816&text=Hola, Pension Justa, soporte sobre " class="whatsapp" target="_blank"><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
    
<?php } else {  ?>       
   <a title="Soporte Pension Justa" href="https://web.whatsapp.com/send?phone=56995333816&text=Hola, Pension Justa, soporte sobre " class="whatsapp" target="_blank" title="Consulte cualquier duda via whatsapp"><span  style=""><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
<?php }   ?>


</head>

<body style="" class="top-navigation">

    <div class="row"> 
        <div class="col-12">
            <div style="background-image:url('../assets2/img/5.png');background-size: 100% 100% ;color:#fff; justify-content: center;align-items: center;display: flex">
                <div class="row">
                    <div style="text-align:center"  class="col-sm-12">
                        <a href="../index.php"><img  width="300px" src="../assets/img/logopj.png" ></a>              
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="" id="wrapper">
     <div style="background-image:url('../assets2/img/fondo.png')" id="page-wrapper" class="">
          
        <div class="wrapper ">
                <div class="row ">
                    <div class="col-lg-12">
                        <div  class="ibox ">                            
                            <div style="background:none !important" class="ibox-content">
                                    
                            <?php $useragent = $_SERVER['HTTP_USER_AGENT'];
                            if (preg_match("/mobile/i", $useragent) ) { ?>
                                    <div style="margin-top:8%" class="row text-center mt-10">
                                        <div class="col-12">
                                            <h1 style="font-weight:800;color:#6612C9;font-size:28px">¡Muchas Gracias por preferir <span style="color:#ff00ff">Pensi&oacute;n Justa!</span></h1>
                                        </div>   
                                    </div>

                                    <div style="background:#fff;border-radius:25px" class="row text-center p-3">
                                        <div class="col-12">
                                            <h1 style="font-weight:800;color:#6612C9;">Le hemos enviado un correo electr&oacute;nico inform&aacute;tivo</h1>                                            
                                        </div>   
                                    </div>
                            <?php } else {  ?>   

                                    <div style="margin-top:%" class="row text-center mt-10">
                                        <div class="col-12">
                                            <h1 style="font-weight:800;color:#6612C9;font-size:28px">
                                                Le hemos enviado un correo electr&oacute;nico inform&aacute;tivo.
                                            </h1>
                                        </div>   
                                    </div>

                                    <div style="margin-top:2%" class="row">
                                        <div class="col-2"></div> 
                                        <div class="col-8">
                                            <label style="font-size:16px;color:#412049;font-weight:700" class="form-label">Estimad@: <?php echo $result['nombre'].' '.$result['apellido']  ?><label>
                                        </div>   
                                        <div class="col-2"></div>
                                    </div>

                                    <div style="margin-top:" class="row">
                                        <div class="col-2"></div> 
                                        <div class="col-8">
                                            <label style="font-size:16px;color:#412049;font-weight:700" class="form-label">
                                                Muchas gracias por usar los servicios de Pensión Justa. Su solicitud ha sido recibida y esta siendo revisada por nuestros especialistas, en un lapso no mayor de 24 horas recibirá el Informe Completo donde podra conocer los montos precisos, además, de una evaluación detallada de los gastos.<br><br>
                                                Si tenemos alguna duda sobre los datos que ingresaste en el formulario, nos contactaremos via WhatsApp al número <strong><?php echo $result['fono']  ?></strong> que Ud. registro en el sistema.<br><br>
                                                Cualquier duda puede consultar al correo electrónico <strong>atencioncliente@pensionjusta.cl</strong>.<br><br>
                                                Muchas Gracias.<br>
                                                <span style="color:#ff00ff">Equipo Pensión Justa.</span>
                                            <label>
                                        </div>   
                                        <div class="col-2"></div>
                                    </div>

                                   

                                    <div style="margin-top:" class="row">
                                            <div class="col-lg-4 col-sm-12 col-xs-12"></div> 
                                            <div style="border-radius:15px;font-size:20px;font-weight:700;padding:2% 0%" class="col-lg-4 col-sm-12 col-xs-12  pt-3 pb-3">
                                                <button style="border-radius:15px;font-size:20px;font-weight:700;padding:2% 0%" class="btn btn-md btn-block boton"  onclick="window.location.href='../index.php'">Volver a Pensi&oacute;n Justa</button>
                                            </div>  
                                            <div class="col-lg-4 col-sm-12 col-xs-12"></div> 
                                    </div>                                    

                            <?php }   ?>   


                                  

 

                            </div>
                        </div>
                    </div>
            </div>
            <input type="hidden" name="solicitud" id="solicitud" value="<?php echo $_GET['solicitud'] ?>">
     

        </div>
        <div style="background:#6612C9;" class="footer">
            <div style="text-align:center">
                <strong><a style="color:#fff" href="index.php"><u>pensionjusta.cl</u></a></strong>
            </div>
            <div>
                <!--<strong>Copyright</strong> Example Company &copy; 2014-2018-->
            </div>
        </div>

    </div>
</div>

                      

    <!-- Mainly scripts -->
    <script src="../inspina\js\jquery-3.1.1.min.js"></script>
    <script src="../inspina\js\popper.min.js"></script>
    <script src="../inspina\js\bootstrap.js"></script>
    <script src="../inspina\js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="../inspina\js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../inspina\js\inspinia.js"></script>
    <script src="../inspina\js\plugins\pace\pace.min.js"></script>

    <!-- Sweet alert -->
    <script src="../inspina\js\plugins\sweetalert\sweetalert.min.js"></script>

    <!-- ChartJS-->
    <script src="../inspina\js\plugins\chartJs\Chart.min.js"></script>

    <!-- iCheck -->
    <script src="../inspina\js\plugins\iCheck\icheck.min.js"></script>
        
    <script>
 


    </script>

</body>

</html>

<?php
# crea codigo si compra es sin codigo
if ($result['con_codigo']==0) {
    $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $ca = strlen($Caracteres);
    $ca--;
    $Hash = '';
    for ($x = 1; $x <= 6; $x++) {
        $Posicao = rand(0, $ca);
        $Hash .= substr($Caracteres, $Posicao, 1);
    };

    $codigo_promocional='PJ'.$Hash;
    $query_codigo=mysqli_query($con,"insert into codigo (solicitud,codigo,valor,tipo,duracion,veces_uso) values ('$solicitud','$codigo_promocional','100','1','1','1') ");

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
        background:#C17BE8;
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
                            <td  class="alert alert-good">                                                       
                                <img width="50%" src="https://pensionjusta.cl/assets2/img/logo_email.png">
                            </td>
                        </tr>
                        <tr>
                            <td class="content-wrap">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block">
                                            Estimad@: <strong>'.$result['nombre'].' '.$result['apellido'].'</strong>.<br/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Muchas gracias por usar los servicios de Pensión Justa. Su solicitud de <strong>Informe Completo No. '.$solicitud.'</strong> ha sido recibida y esta siendo revisada por nuestros especialistas, en un lapso no mayor de 24 horas recibirá el Informe Completo donde podra conocer los montos precisos, además, de una evaluación detallada de los gastos.
                                        </td>
                                    </tr>         
                                    <tr>
                                        <td class="content-block">
                                            Si tenemos alguna duda sobre los datos que ingresaste en el formulario, nos contactaremos via WhatsApp al número <strong>'.$result['fono'].'</strong> que Ud. registro en el sistema.
                                        </td>                                   
                                    </tr> 
                                    <tr>
                                        <td class="content-block">
                                            Codigo Promocional para obtener un nuevo Informe totalmente gratis: <span style="font-weight:700;color:#C17BE8;">'.$codigo_promocional.'</span>
                                        </td>                                   
                                    </tr>                                                     
                                    <tr>
                                        <td class="content-block">
                                                Cualquier duda puede consultar al correo electrónico atencioncliente@pensionjusta.cl.                                        
                                        </td>
                                    </tr>                                
                                    <tr>
                                        <td class="content-block">
                                            Muchas Gracias.<br/>
                                            <strong>Equipo Pensión Justa</strong>.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div style="background: #C17BE8;" class="footer">
                        <table width="100%">
                            <tr style="font-weight:700;color:#282828">
                                <td class="aligncenter content-block">Email desde <a style="font-weight:700;color:#6612C9" href="https://pensionjusta.cl" target="_BLACK" >Pension Justa</a></td>
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

    /*CONFIGURACI N DE CLASE*/          
    $mail->isSMTP(); //Indicar que se usar  SMTP
    $mail->CharSet = 'UTF-8';//permitir env o de caracteres especiales (tildes y  )

    /*CONFIGURACI N DE DEBUG (DEPURACI N)*/
    $mail->SMTPDebug = 0; //Mensajes de debug; 0 = no mostrar (en producci n), 1 = de cliente, 2 = de cliente y servidor
    $mail->Debugoutput = 'html'; //Mostrar mensajes (resultados) de depuraci n(debug) en html

    /*CONFIGURACI N DE PROVEEDOR DE CORREO QUE USAR  EL EMISOR(GMAIL)*/
    $mail->Host = 'mail.pensionjusta.cl.';   /*Servidor SMTP*/
    // $mail->Host = gethostbyname('smtp.gmail.com'); // Si su red no soporta SMTP sobre IPv6
    $mail->Port = 587; //Puerto SMTP, 587 para autenticado TLS
    $mail->SMTPSecure = 'SSL'; //Sistema de encriptaci n - ssl (obsoleto) o tls
    $mail->SMTPAuth = true;//Usar autenticaci n SMTP
    //$mail->SMTPOptions = array(
    //          'ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)
        //    );//opciones para "saltarse" comprobaci n de certificados (hace posible del env o desde localhost)

    //CONFIGURACI N DEL EMISOR
    $mail->Username = 'no-responder@pensionjusta.cl';   /*Usuario, normalmente el correo electr nico*/
    $mail->Password = 'Noresponderpj2024!';   /*Tu contrase a*/
    $mail->From = 'no-responder@pensionjusta.cl';   /*Correo electr nico que estamos autenticando*/
    $mail->setFrom('no-responder@pensionjusta.cl', 'no-reponder');
    $mail->FromName = 'Pension Justa';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/

    //CONFIGURACI N DEL MENSAJE, EL CUERPO DEL MENSAJE SERA UNA PLANTILLA HTML QUE INCLUYE IMAGEN Y CSS
    $mail->Subject = 'Compra de Informe Completo'; //asunto del mensaje

    //incrustar imagen para cuerpo de mensaje(no confundir con Adjuntar)
    //$mail->AddEmbeddedImage($sImagen, 'imagen'); //ruta de archivo de imagen

    //cargar archivo css para cuerpo de mensaje
    //$rcss = "email/styles.css";//ruta de archivo css
    //$fcss = fopen ($rcss, "r");//abrir archivo css
    //$scss = fread ($fcss, filesize ($rcss));//leer contenido de css
    //fclose ($fcss);//cerrar archivo css

    //Cargar archivo html   
    //$shtml = file_get_contents('email/billing.php');
    //reemplazar secci n de plantilla html con el css cargado y mensaje creado
    //$incss  = str_replace('<style id="estilo"></style>',"<style>$scss</style>",$shtml);
    //$cuerpo = str_replace('<d="mensaje"></body>',$mensaje,$incss);
    $mail->Body = $cuerpo; //cuerpo del mensaje
    $mail->AltBody = '---';//Mensaje de s lo texto si el receptor no acepta HTML

    //CONFIGURACI N DE RECEPTORES
    #$emails = array("helimirlopez@hotmail.com" , "helimirlopez@gmail.com");
    #for($i = 0; $i < count($emails); $i++) {
    #    $mail->AddAddress($emails[$i]);
        #echo $emails[$i];
    #};

    #$url='https://pensionjusta.cl/informes/'.$solicitud.'/pension_justa_'.$solicitud.'.pdf';
    #$fichero = file_get_contents($url);
    #$mail->addStringAttachment($fichero, 'pension_justa_'.$solicitud.'.pdf','base64', 'application/pdf');

    $mail->addAddress($email);
    $mail->addBCC("helimirlopez@hotmail.com");
    $mail->addBCC("arielguzmansardy@gmail.com");
    $mail->IsHTML(true);

    if ($mail->send()) {
        echo 0;
    } else {
        echo 1;
    }
    
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
            background:#C17BE8;
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
                                <td  class="alert alert-good">                                                       
                                    <img width="50%" src="https://pensionjusta.cl/assets2/img/logo_email.png">
                                </td>
                            </tr>
                            <tr>
                                <td class="content-wrap">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="content-block">
                                                Estimad@: <strong>'.$result['nombre'].' '.$result['apellido'].'</strong>.<br/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="content-block">
                                                Muchas gracias por usar los servicios de Pensión Justa. Su solicitud de <strong>Informe Completo No. '.$solicitud.'</strong> ha sido recibida y esta siendo revisada por nuestros especialistas, en un lapso no mayor de 24 horas recibirá el Informe Completo donde podra conocer los montos precisos, además, de una evaluación detallada de los gastos.
                                            </td>
                                        </tr>         
                                        <tr>
                                            <td class="content-block">
                                                Si tenemos alguna duda sobre los datos que ingresaste en el formulario, nos contactaremos via WhatsApp al número <strong>'.$result['fono'].'</strong> que Ud. registro en el sistema.
                                            </td>                                   
                                        </tr>                                                 
                                        <tr>
                                            <td class="content-block">
                                                    Cualquier duda puede consultar al correo electrónico atencioncliente@pensionjusta.cl.                                        
                                            </td>
                                        </tr>                                
                                        <tr>
                                            <td class="content-block">
                                                Muchas Gracias.<br/>
                                                <strong>Equipo Pensión Justa</strong>.
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div style="background: #C17BE8;" class="footer">
                            <table width="100%">
                                <tr style="font-weight:700;color:#282828">
                                    <td class="aligncenter content-block">Email desde <a style="font-weight:700;color:#6612C9" href="https://pensionjusta.cl" target="_BLACK" >Pension Justa</a></td>
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

        /*CONFIGURACI N DE CLASE*/          
        $mail->isSMTP(); //Indicar que se usar  SMTP
        $mail->CharSet = 'UTF-8';//permitir env o de caracteres especiales (tildes y  )

        /*CONFIGURACI N DE DEBUG (DEPURACI N)*/
        $mail->SMTPDebug = 0; //Mensajes de debug; 0 = no mostrar (en producci n), 1 = de cliente, 2 = de cliente y servidor
        $mail->Debugoutput = 'html'; //Mostrar mensajes (resultados) de depuraci n(debug) en html

        /*CONFIGURACI N DE PROVEEDOR DE CORREO QUE USAR  EL EMISOR(GMAIL)*/
        $mail->Host = 'mail.pensionjusta.cl.';   /*Servidor SMTP*/
        // $mail->Host = gethostbyname('smtp.gmail.com'); // Si su red no soporta SMTP sobre IPv6
        $mail->Port = 587; //Puerto SMTP, 587 para autenticado TLS
        $mail->SMTPSecure = 'SSL'; //Sistema de encriptaci n - ssl (obsoleto) o tls
        $mail->SMTPAuth = true;//Usar autenticaci n SMTP
        //$mail->SMTPOptions = array(
        //          'ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)
            //    );//opciones para "saltarse" comprobaci n de certificados (hace posible del env o desde localhost)

        //CONFIGURACI N DEL EMISOR
        $mail->Username = 'no-responder@pensionjusta.cl';   /*Usuario, normalmente el correo electr nico*/
        $mail->Password = 'Noresponderpj2024!';   /*Tu contrase a*/
        $mail->From = 'no-responder@pensionjusta.cl';   /*Correo electr nico que estamos autenticando*/
        $mail->setFrom('no-responder@pensionjusta.cl', 'no-reponder');
        $mail->FromName = 'Pension Justa';   /*Puedes poner tu nombre, el de tu empresa, nombre de tu web, etc.*/

        //CONFIGURACI N DEL MENSAJE, EL CUERPO DEL MENSAJE SERA UNA PLANTILLA HTML QUE INCLUYE IMAGEN Y CSS
        $mail->Subject = 'Compra de Informe Completo'; //asunto del mensaje

        //incrustar imagen para cuerpo de mensaje(no confundir con Adjuntar)
        //$mail->AddEmbeddedImage($sImagen, 'imagen'); //ruta de archivo de imagen

        //cargar archivo css para cuerpo de mensaje
        //$rcss = "email/styles.css";//ruta de archivo css
        //$fcss = fopen ($rcss, "r");//abrir archivo css
        //$scss = fread ($fcss, filesize ($rcss));//leer contenido de css
        //fclose ($fcss);//cerrar archivo css

        //Cargar archivo html   
        //$shtml = file_get_contents('email/billing.php');
        //reemplazar secci n de plantilla html con el css cargado y mensaje creado
        //$incss  = str_replace('<style id="estilo"></style>',"<style>$scss</style>",$shtml);
        //$cuerpo = str_replace('<d="mensaje"></body>',$mensaje,$incss);
        $mail->Body = $cuerpo; //cuerpo del mensaje
        $mail->AltBody = '---';//Mensaje de s lo texto si el receptor no acepta HTML

        //CONFIGURACI N DE RECEPTORES
        #$emails = array("helimirlopez@hotmail.com" , "helimirlopez@gmail.com");
        #for($i = 0; $i < count($emails); $i++) {
        #    $mail->AddAddress($emails[$i]);
            #echo $emails[$i];
        #};

        #$url='https://pensionjusta.cl/informes/'.$solicitud.'/pension_justa_'.$solicitud.'.pdf';
        #$fichero = file_get_contents($url);
        #$mail->addStringAttachment($fichero, 'pension_justa_'.$solicitud.'.pdf','base64', 'application/pdf');

        $mail->addAddress($email);
        $mail->addBCC("helimirlopez@hotmail.com");
        $mail->addBCC("arielguzmansardy@gmail.com");


        $mail->IsHTML(true);

        if ($mail->send()) {
            echo 0;
        } else {
            echo 1;
        }
    }
}
?>

