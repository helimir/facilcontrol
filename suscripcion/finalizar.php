<?php
session_start();
include('config/config.php');
if (empty($_SESSION['email']) ) { 
    $sesion=0;
    header("Location:suscripcion.php");
} else {

    $paises=mysqli_query($con,"select * from paises");
    $query=mysqli_query($con,"select * from registro where email='".$_SESSION['email']."' ");
    $result=mysqli_fetch_array($query);
    $cliente=$result['nombre'].' '.$result['apellido'];
    $monto=$result['monto'];
    $nick=$result['nick'];
    $id_custorm=$result['id_custorm'];
    $usuario='@'.explode(" ",$result['nombre'])[0];
    $confirmar=$result['confirmar'];
    $sesion=1;
    
}

$query_plan=mysqli_query($con,"select * from plan_suscripcion where plan='".$result['plan']."' ");
$result_plan=mysqli_fetch_array($query_plan);

require_once 'request.php';
$requestModel = new Request();
$ip = $requestModel->getIpAddress();
$isValidIpAddress = $requestModel->isValidIpAddress($ip);

if ($isValidIpAddress == "") {
    $ip='invalida';
} else {
    $geoLocationData = $requestModel->getLocation($ip);
    $pais=$geoLocationData['country'];
    $codigo=$geoLocationData['country_code'];
    $direccion_ip=$geoLocationData['ip'];

}

################################################################### PAYPAL
//get logged in user ID from sesion
$loggedInUserID =$result['id_registro'];

//PayPal variables
$paypalURL 	= 'https://sandbox.paypal.com/cgi-bin/webscr';
$paypalID 	= 'sb-wohlr36833816@business.example.com';
$successURL = 'https://facilcontrol.cl/suscripcion/result.php';
$cancelURL 	= 'https://facilcontrol.cl/suscripcion/result.php';
$notifyURL 	= 'https://facilcontrol.cl/suscripcion/paypal_ipn.php';

$itemName = 'Member Subscriptions';
$itemNumber = 'MS'.$loggedInUserID;

//subscription price for one month
$itemPrice = ($result['monto']/$result_plan['dolar']);



if (empty($_SESSION['email']) ) { 
    header("Location:suscripcion.php");
} else {
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Suscipcion-Finalizar</title>

    <link href="..\css\bootstrap.min.css" rel="stylesheet">
    <link href="..\font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="..\css\animate.css" rel="stylesheet">
    <link href="..\css\style.css" rel="stylesheet">

    <link href="..\css\plugins\iCheck\custom.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="..\css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

        .navbar-toggler {
            background-color: #2EB8E2;
            color: #fff;
            padding: 6px 12px;
            font-size: 14px;
            margin: 8px;
        }

        .nav li  a {
            color: #ffffff !important;
            font-weight: 700;
            padding: 14px 20px 14px 25px;
            display: block;
        }
        .nav li  span {
            color: #ffffff !important;
            font-weight: 700;
            font-size:20px;
            padding-top: 5px;
            display: block;
        }

        .nav li  a:hover {
            background-color: #2EB8E2 !important;
            color: #ffffff !important;
            font-weight: 700;
            padding: 14px 20px 14px 25px;
            display: block;
        }

        /* The contenedor */

        .contenedor {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        }


        /* Hide the browser's default radio button */

        .contenedor input[type=radio] {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        }


        /* Create a custom radio button */

        .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
        }


        /* On mouse-over, add a grey background color */

        .contenedor:hover input~.checkmark {
        background-color: #ccc;
        }


        /* When the radio button is checked, add a blue background */

        .contenedor input:checked~.checkmark {
        background-color: #2EB8E2;
        }


        /* Create the indicator (the dot/circle - hidden when not checked) */

        .checkmark:after {
        content: "";
        position: absolute;
        display: none;
        }


        /* Show the indicator (dot/circle) when checked */

        .contenedor input:checked~.checkmark:after {
        display: block;
        }


        /* Style the indicator (dot/circle) */

        .contenedor .checkmark:after {
            top: 9px;
            left: 9px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: white;
        }

        .bordeactivo {
            border-style: solid;
            border-color: #2EB8E2;
            border-width: 4px;
        }
        .bordeinactivo {
            border-style: solid;
            border-color: #fff;
            border-width: 4px;
        }


body {
    font-family: Arial, sans-serif;
   
}

.stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    /*max-width: 80%;*/
    position: relative;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;    
}

.step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #2EB8E2;
    font-weight: bold;
    margin-bottom: 10px;
    z-index: 2;
}

.step-label {
    font-size: 16px;
    color: #666;
    text-align: center;
}

.step-label-completed {
    font-size: 16px;
    color: #fff;
    text-align: center;
    font-weight:700;
}

.step.completed .step-circle {
    background-color: #2EB8E2;
    color:#fff;
}

.step::before, .step::after {
    content: '';
    position: absolute;
    top: 20px;
    width: 50%;
    height: 2px;
    background-color: #ccc;
    z-index: 1;
}

.step::before {
    left: 0;
}

.step::after {
    right: 0;
}

.step:first-child::before, .step:last-child::after {
    display: none;
}

.step.completed::before, .step.completed::after {
    background-color: #2EB8E2;
}

.custom-checkbox {    
    appearance: none;
    width: 30px;
    height: 30px;
    background-color: none;
    border:1px #fff solid;
}

.custom-checkbox:checked {
    background-color: #2EB8E2;
}

input[type=checkbox]  { 
   appearance: none;
   width: 35px;
   height:35px;
   border:1px #fff solid;
}

input[type=checkbox]:checked  {     
      background: #2EB8E2;
}

.card-input-container {
    position: relative;
    width: 100%;
}

.card-icon {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #666;
    font-size: 18px;
}

#card-number {
    width: 100%;
    padding: 10px 10px 10px 40px; /* Espacio para el icono */
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease;
}

#card-number:focus {
    border-color: #007bff;
}

#card-number::placeholder {
    color: #999;
}

input {
    width: 100%;
    padding: 10px 10px 10px 40px; /* Espacio para el icono */
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.3s ease;
}


.two-fields {
  width:100%;
}
.two-fields .input-group {
  width:100%;
}
.two-fields input {
  width:20% !important;
}

    </style>

</head>

<body class="top-navigation">

<div id="wrapper">
    <div style="background:#000;" id="page-wrapper" class="black-bg">

    <div style="background:#262626;" class="row">
            <nav style="background:#262626;" class="navbar navbar-expand-lg navbar-static-top" role="navigation">

                    <?php if ($sesion==1) { ?>
                        <a  style="background: #F03737;color: #fff;" href="logout-suscripcion.php"  class="navbar-brand"></i><span style="border:1px #fff solid;padding: 4% 6%">Cerrar Sesión</span></a>
                    <?php } else { ?>
                            <a style="background: #2EB8E2" href="#" onclick="login()"  class="navbar-brand"><span style="border:1px #fff solid;padding: 4% 6%">Iniciar Sesión</span></a>
                    <?php }  ?>

                <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav mr-auto">
                            <?php if ($sesion==1) { ?>
                                <li>                                
                                    <span> <?php echo $usuario ?></span>
                                </li>
                            <?php } ?>                          
                        </ul>
                </div>
            </nav>
        </div>
       
        <div class="wrapper wrapper-content">               
               
            <div  class="container">         
                <div style="border-radius: 10px;padding-top:2%" class="row black-bg">   

                    <div class="col-lg-12 ">
                        <div class="ibox">
                            
                            <div style="border:none;padding:0%" class="ibox-content black-bg">  

                                <?php $useragent = $_SERVER['HTTP_USER_AGENT'];
                                if (preg_match("/mobile/i", $useragent) ) { ?>
                                    <div style="margin-top:6%"  class="row">
                                <?php } else {  ?>       
                                    <div style="margin-top:2%"  class="row">
                                <?php }   ?>

                                
                                    <div class="col-lg-12">
                                        <div  class="ibox">
                                            <div class="stepper">
                                                <div class="step completed">
                                                    <div class="step-circle">1</div>
                                                    <div class="step-label-completed">PLAN</div>
                                                </div>
                                                <div class="step completed">
                                                    <div class="step-circle">2</div>
                                                    <div class="step-label-completed">REGISTRO</div>
                                                </div>
                                                <div class="step completed">
                                                    <div class="step-circle">3</div>
                                                    <div class="step-label-completed">PAGO</div>
                                                </div>
                                                <div class="step completed">
                                                    <div class="step-circle">4</div>
                                                    <div class="step-label-completed">FINALIZAR</div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>

                                <?php if (preg_match("/mobile/i", $useragent) ) { ?>
                                    <div  class="row">
                                        <div class="col-lg-12">
                                            <div  class="ibox">
                                                <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:28px">Confirmación de Pago</h1>
                                            </div>
                                        </div>
                                    </div> 
                                <?php } else {  ?>       
                                    <div  class="row">
                                        <div class="col-lg-12">
                                            <div  class="ibox">
                                                <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Confirmación de Pago <?php echo $monto ?></h1>
                                                
                                            </div>
                                        </div>
                                       
                                    </div> 
                                <?php }  ?>       

                                
                        

                                <div style="border:none" class="ibox-content black-bg"> 
                                
                                        <?php if ($_SESSION['metodo']=="Tarjeta") { ?>
                                                    <?php if (preg_match("/mobile/i", $useragent) ) { ?>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <?php if ($confirmar==0) { ?>
                                                                            <div id="div_confirmar" style="background: #F03737;padding: 0% 2%;" class="form-group">
                                                                                <label style="text-align:left;color:#fff;font-size:18px;margin-top:2%;padding: 0% 2%">Cuenta NO confirmada. Favor confirmar con el email de confirmación recibido para continuar con el proceso de suscripción.</label>                        
                                                                            </div>
                                                                    <?php } ?>
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                        <div class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">NOMBRE<br>
                                                                                <span style="font-size:20px;color:#fff"><?php echo $cliente ?></span></label>
                                                                            </div>

                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">EMAIL<br>
                                                                                <span style="font-size:20px;color:#fff"><?php echo $_SESSION['email'] ?></span></label>
                                                                            </div>
                                                                        </div>

                                                                        <div style="margin-top:5%" class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">PLAN<br>
                                                                                <span style="font-size:20px;color:#fff"><?php  echo $_SESSION['plan'].' $'. number_format($monto, 0, ",", ".");?></span></label>
                                                                            </div>

                                                                            <div style="font-size:12px;color:#fff;margin-top:4%" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">METODO DE PAGO<br>
                                                                                <?php                                                                                    
                                                                                    if ($_SESSION['metodo']=="Paypal") {
                                                                                        $imagen="paypal3.png";
                                                                                    }
                                                                                    if ($_SESSION['metodo']=="Tarjeta") {
                                                                                        $imagen="tarjeta1.png";
                                                                                    }
                                                                                ?>
                                                                                <span style="font-size:20px;color:#fff"><img width="100" src="<?php echo $imagen ?>"> <?php echo $_SESSION['metodo'] ?></span></label>
                                                                            </div>
                                                                        </div>

                                                                        <div style="margin-top:5%" class="row">
                                                                            <div style="font-size:12px;color:#fff" class="col-lg-12 col-sm-12">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="width:10%"><input type="checkbox" name="terminos" id="terminos" value="1" onclick="aceptar_terminos()"></td>
                                                                                        <td style="width:90%;font-size:20px;text-align:right">He leído y acepto <a href="#"><u>los términos y condiciones de contratación</u></a> y <a href="#"><u>la política de privacidad</u></a></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    <?php } else {  ?>       
                                                        <div style="margin-left:10%;margin-right:10%"  class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <?php if ($confirmar==0) { ?>
                                                                            <div id="div_confirmar" style="background: #F03737;padding: 0% 2%;" class="form-group">
                                                                                <label style="text-align:left;color:#fff;font-size:18px;margin-top:2%;padding: 0% 2%">Cuenta NO confirmada. Favor confirmar con el email de confirmación recibido para continuar con el proceso de suscripción.</label>                        
                                                                            </div>
                                                                    <?php } ?>
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">                                                                      

                                                                        <div class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:15px;" class="form-label">NOMBRE</label><br>
                                                                                <label style="font-size:30px;color:#fff"><?php echo $cliente ?></label>
                                                                            </div>

                                                                            <div style="font-size:15px;color:#fff" class="col-lg-5 col-sm-12">
                                                                                <label style="font-size:15px;" class="form-label">EMAIL</label><br>
                                                                                <label style="font-size:30px;color:#fff"><?php echo $_SESSION['email'] ?></label>
                                                                            </div>
                                                                        </div>

                                                                        <div style="margin-top:2%" class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:15px;" class="form-label">PLAN<br>
                                                                                <span style="font-size:24px;color:#fff"><?php  echo $_SESSION['plan'].' $'. number_format($monto, 0, ",", ".");?></span></label>
                                                                            </div>

                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:15px;" class="form-label">METODO DE PAGO<br>
                                                                                <?php 
                                                                                    if ($_SESSION['metodo']=="Paypal") {
                                                                                        $imagen="paypal3.png";
                                                                                    }
                                                                                    if ($_SESSION['metodo']=="Tarjeta") {
                                                                                        $imagen="tarjeta1.png";
                                                                                    }
                                                                                ?>
                                                                                <span style="font-size:30px;color:#fff"><img width="100" src="<?php echo $imagen ?>"> <?php echo $_SESSION['metodo'] ?></span></label>
                                                                            </div>
                                                                        </div>

                                                                        <div style="margin-top:5%" class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-12 col-sm-12">
                                                                                <table>
                                                                                    <tr>
                                                                                        <td style="width:8%"><input type="checkbox" name="terminos" id="terminos" value="1" onclick="aceptar_terminos()"></td>
                                                                                        <td style="width:92%;font-size:20px">He leído y acepto <a href="#"><u>los términos y condiciones de contratación</u></a> y <a href="#"><u>la política de privacidad</u></a></td>
                                                                                    </tr>
                                                                                </table>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }   ?>
                                        <?php }   ?>

                                        <?php if ($_SESSION['metodo']=="Paypal") { ?>

                                                <?php if (preg_match("/mobile/i", $useragent) ) { ?>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div  class="ibox">
                                                                    <?php if ($confirmar==0) { ?>
                                                                        <div id="div_confirmar" style="background: #F03737;padding: 0% 2%;" class="form-group">
                                                                            <label style="text-align:left;color:#fff;font-size:18px;margin-top:2%;padding: 0% 2%">Cuenta NO confirmada. Favor confirmar con el email de confirmación recibido para continuar con el proceso de suscripción.</label>                        
                                                                        </div>
                                                                    <?php } ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                    <div class="row">
                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:12px;" class="form-label">NOMBRE</label><br>
                                                                            <label style="font-size:20px;color:#fff"><?php echo $cliente ?></label>
                                                                        </div>

                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:12px;" class="form-label">EMAIL</label><br>
                                                                            <label style="font-size:20px;color:#fff"><?php echo $_SESSION['email'] ?></label>
                                                                        </div>
                                                                    </div>

                                                                    <div style="margin-top:5%" class="row">
                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:12px;" class="form-label">PLAN</label><br>
                                                                            <label style="font-size:20px;color:#fff"><?php  echo $_SESSION['plan'].' $'. number_format($monto, 0, ",", ".");?></small></label>
                                                                            <br>
                                                                            <label style="font-size:12px;color:#fff;font-weight:bold">(EN DOLARES <?php echo '$ '. number_format($itemPrice, 2, ".", "") ?>)</label>
                                                                        </div>

                                                                        <div style="font-size:12px;color:#fff;margin-top:4%" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:12px;" class="form-label">METODO DE PAGO</label><br>
                                                                            <?php
                                                                                if ($_SESSION['metodo']=="Paypal") {
                                                                                    $imagen="paypal3.png";
                                                                                }
                                                                                if ($_SESSION['metodo']=="Tarjeta") {
                                                                                    $imagen="tarjeta1.png";
                                                                                }
                                                                            ?>
                                                                            <label style="font-size:20px;color:#fff"><img width="100" src="<?php echo $imagen ?>"> <?php echo $_SESSION['metodo'] ?></label>
                                                                        </div>
                                                                    </div>

                                                                    <div style="margin-top:5%" class="row">
                                                                        <div style="font-size:12px;color:#fff" class="col-lg-12 col-sm-12">
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width:10%"><input type="checkbox" name="terminos" id="terminos" value="1" onclick="aceptar_terminos()"></td>
                                                                                    <td style="width:90%;font-size:20px;text-align:right">He leído y acepto <a href="#"><u>los términos y condiciones de contratación</u></a> y <a href="#"><u>la política de privacidad</u></a></td>
                                                                                </tr>
                                                                            </table>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                <?php } else {  ?>       
                                                    <div style="margin-left:10%;margin-right:10%"  class="row">
                                                        <div class="col-lg-12">
                                                            <div  class="ibox">
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">
                                                                    <?php if ($confirmar==0) { ?>
                                                                        <div id="div_confirmar" style="background: #F03737;padding: 0% 2%;" class="form-group">
                                                                            <label style="text-align:left;color:#fff;font-size:18px;margin-top:2%;padding: 0% 2%">Cuenta NO confirmada. Favor confirmar con el email de confirmación recibido para continuar con el proceso de suscripción.</label>                        
                                                                        </div>
                                                                    <?php } ?>
                                                                    <div class="row">
                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:15px;" class="form-label">NOMBRE</label><br>
                                                                            <label style="font-size:30px;color:#fff"><?php echo $cliente ?></label>
                                                                        </div>

                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:15px;" class="form-label">EMAIL</label><br>
                                                                            <label style="font-size:30px;color:#fff"><?php echo $_SESSION['email'] ?></label>
                                                                        </div>
                                                                    </div>

                                                                    <div style="margin-top:5%" class="row">
                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:15px;" class="form-label">PLAN</label><br>
                                                                            <label style="font-size:30px;color:#fff"><?php  echo $_SESSION['plan'].' $'. number_format($monto, 0, ",", ".");?></label>
                                                                            <br>
                                                                            <label style="font-size:14px;color:#fff;font-weight:bold">(EN DOLARES <?php echo '$ '. number_format($itemPrice, 2, ".", "") ?>)</label>
                                                                        </div>

                                                                        <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                            <label style="font-size:15px;" class="form-label">METODO DE PAGO</label><br>
                                                                            <?php 
                                                                                if ($_SESSION['metodo']=="Paypal") {
                                                                                    $imagen="paypal3.png";
                                                                                }
                                                                                if ($_SESSION['metodo']=="Tarjeta") {
                                                                                    $imagen="tarjeta1.png";
                                                                                }
                                                                            ?>
                                                                            <label style="font-size:30px;color:#fff"><img width="100" src="<?php echo $imagen ?>"> <?php echo $_SESSION['metodo'] ?></label>
                                                                        </div>
                                                                    </div>

                                                        <div style="margin-top:5%" class="row">
                                                            <div style="font-size:15px;color:#fff" class="col-lg-12 col-sm-12">
                                                                <table>
                                                                    <tr>
                                                                        <td style="width:8%"><input type="checkbox" name="terminos" id="terminos" value="1" onclick="aceptar_terminos()"></td>
                                                                        <td style="width:92%;font-size:20px">He leído y acepto <a href="#"><u>los términos y condiciones de contratación</u></a> y <a href="#"><u>la política de privacidad</u></a></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }   ?>
                                <?php }   ?>


                            </div>

                            <?php if ($_SESSION['metodo']=="Tarjeta") { ?>

                                <input type="hidden" name="solicitud" id="solicitud" value="<?php echo $result['id_registro'] ?>" >
                                <input type="hidden" name="cliente" id="cliente" value="<?php echo $cliente ?>" >
                                <input type="hidden" name="token" id="token" value="<?php echo $result['token'] ?>" >
                                <input type="hidden" name="monto" id="monto" value="<?php echo $monto ?>" >
                                <input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" >
                                <input type="hidden" name="metodo" id="metodo" value="<?php echo $_SESSION['metodo'] ?>" >
                                <input type="hidden" name="plan" id="plan" value="<?php echo $_SESSION['plan'] ?>" >

                                        <div style="margin-top:4%"  class="row">  
                                            <?php  if (preg_match("/mobile/i", $useragent) ) { ?>
                                                <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                    <a style="font-size:18px;border-radius:5px;padding:2% 5%;color: #fff;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" href="checkout.php">Volver atrás</a>                                    
                                                    <button style="font-size:18px;border-radius:5px;padding:2% 2%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" id="realizar_pago" disabled onclick="pago()">Realizar pago</button>
                                                </div>
                                            <?php } else {  ?>       
                                                <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                    <a style="font-size:18px;border-radius:5px;padding:1% 5%;color: #fff;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" href="checkout.php">Volver atrás</a>                                    
                                                    <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" id="realizar_pago" disabled onclick="pago()">Realizar pago</button>
                                                </div>
                                            <?php }   ?>
                                        </div>
                            <?php }   ?>


                            <?php if ($_SESSION['metodo']=="Paypal") { ?>

                                    <input type="hidden" name="solicitud" id="solicitud" value="<?php echo $result['id_registro'] ?>" >
                                    <input type="hidden" name="cliente" id="cliente" value="<?php echo $cliente ?>" >
                                    <input type="hidden" name="token" id="token" value="<?php echo $result['token'] ?>" >
                                    <input type="hidden" name="monto" id="monto" value="<?php echo $monto ?>" >
                                    <input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" >
                                    <input type="hidden" name="metodo" id="metodo" value="<?php echo $_SESSION['metodo'] ?>" >

                                            <div style="margin-top:4%"  class="row">  
                                                <?php  if (preg_match("/mobile/i", $useragent) ) { ?>
                                                    <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                        <form action="<?php echo $paypalURL; ?>" method="post">
                                                            <!-- identify your business so that you can collect the payments -->
                                                            <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
                                                            <!-- specify a subscriptions button. -->
                                                            <input type="hidden" name="cmd" value="_xclick-subscriptions">
                                                            <!-- specify details about the subscription that buyers will purchase -->
                                                            <input type="hidden" name="item_name" value="<?php echo $itemName; ?>">
                                                            <input type="hidden" name="item_number" value="<?php echo $itemNumber; ?>">
                                                            <input type="hidden" name="currency_code" value="USD">
                                                            <input type="hidden" name="a3" id="paypalAmt" value="<?php echo $itemPrice; ?>">
                                                            <input type="hidden" name="p3" id="paypalValid" value="1">
                                                            <input type="hidden" name="t3" value="M">
                                                            <!-- custom variable user ID -->
                                                            <input type="hidden" name="custom" value="<?php echo $loggedInUserID; ?>">
                                                            <!-- specify urls -->
                                                            <input type="hidden" name="cancel_return" value="<?php echo $cancelURL; ?>">
                                                            <input type="hidden" name="return" value="<?php echo $successURL; ?>">
                                                            <input type="hidden" name="notify_url" value="<?php echo $notifyURL; ?>">
                                                            <!-- display the payment button -->  
                                                            <a style="font-size:18px;border-radius:5px;padding:2% 5%;color: #fff;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" href="checkout.php">Volver atrás</a>                                    
                                                            <button style="font-size:18px;border-radius:5px;padding:2% 2%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" id="realizar_pago" type="submit" onclick="pago()">Realizar pago</button>
                                                        </from>
                                                    </div>
                                                <?php } else {  ?>       
                                                    <div style="text-align:center;" class="col-lg-12 col-sm-12">

                                                     <form action="<?php echo $paypalURL; ?>" method="post">
                                                            <!-- identify your business so that you can collect the payments -->
                                                            <input type="hidden" name="business" value="<?php echo $paypalID; ?>">
                                                            <!-- specify a subscriptions button. -->
                                                            <input type="hidden" name="cmd" value="_xclick-subscriptions">
                                                            <!-- specify details about the subscription that buyers will purchase -->
                                                            <input type="hidden" name="item_name" value="<?php echo $itemName; ?>">
                                                            <input type="hidden" name="item_number" value="<?php echo $itemNumber; ?>">
                                                            <input type="hidden" name="currency_code" value="USD">
                                                            <input type="hidden" name="a3" id="paypalAmt" value="<?php echo $itemPrice; ?>">
                                                            <input type="hidden" name="p3" id="paypalValid" value="1">
                                                            <input type="hidden" name="t3" value="M">
                                                            <!-- custom variable user ID -->
                                                            <input type="hidden" name="custom" value="<?php echo $loggedInUserID; ?>">
                                                            <!-- specify urls -->
                                                            <input type="hidden" name="cancel_return" value="<?php echo $cancelURL; ?>">
                                                            <input type="hidden" name="return" value="<?php echo $successURL; ?>">
                                                            <input type="hidden" name="notify_url" value="<?php echo $notifyURL; ?>">
                                                            <!-- display the payment button -->                                                            
                                                            <a style="font-size:18px;border-radius:5px;padding:1% 5%;color: #fff;;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" href="checkout.php" >Volver atrás</a>                                    
                                                            <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" id="realizar_pago" type="submit" value="Compar Suscripción" disabled >Realizar pago</button>
                                                        </form>

                                                        
                                                    </div>
                                                <?php }   ?>
                                            </div>
                                <?php }   ?>
                                

                        </div>
                    </div>

                </div>

            </div>
            <input type="hidden" name="confirmar" id="confirmar" value="<?php echo $confirmar ?>">
            <input type="hidden" name="id_custorm" id="id_custorm" value="<?php echo $id_custorm ?>">
        </div>
        <!--<div class="footer">
            <div class="float-right">
                10GB of <strong>250GB</strong> Free.
            </div>
            <div>
                <strong>Copyright</strong> Example Company &copy; 2014-2018
            </div>
        </div>-->

    </div>
</div>



    <!-- Mainly scripts -->
    <script src="..\js\jquery-3.1.1.min.js"></script>
    <script src="..\js\popper.min.js"></script>
    <script src="..\js\bootstrap.js"></script>
    <script src="..\js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="..\js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="..\js\inspinia.js"></script>
    <script src="..\js\plugins\pace\pace.min.js"></script>

    <!-- iCheck -->
    <script src="..\js\plugins\iCheck\icheck.min.js"></script>

    <!-- Sweet alert -->
    <script src="..\js\plugins\sweetalert\sweetalert.min.js"></script>

    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <script>

    function validateCardNumber(input) {
        // Elimina cualquier carácter que no sea un número
        input.value = input.value.replace(/\D/g, '');

        // Limita la longitud a 16 dígitos
        if (input.value.length > 16) {
            input.value = input.value.slice(0, 16);
        }

        // Muestra un mensaje si la longitud no es válida
        const isValid = input.value.length === 16;
        if (!isValid) {
            input.setCustomValidity("El número de tarjeta debe tener 16 dígitos.");
        } else {
            input.setCustomValidity("");
        }
    }

    function formatCardNumber(input) {
        // Elimina espacios y caracteres no numéricos
        let value = input.value.replace(/\D/g, '');

        // Agrupa en bloques de 4 dígitos
        value = value.replace(/(\d{4})(?=\d)/g, '$1 ');

        // Actualiza el valor del input
        input.value = value;
    }


    // Valida el mes (MM)
    function validateMonth(input) {
        // Elimina caracteres no numéricos
        input.value = input.value.replace(/\D/g, '');

        // Limita el valor a 12 (meses)
        if (input.value > 12) {
            input.value = 12;
        }
    }

    // Valida el año (AA)
    function validateYear(input) {
        // Elimina caracteres no numéricos
        input.value = input.value.replace(/\D/g, '');

        // Limita la longitud a 2 dígitos
        if (input.value.length > 2) {
            input.value = input.value.slice(0, 2);
        }
    }

    // Valida el CVC
    function validateCVC(input) {
        // Elimina caracteres no numéricos
        input.value = input.value.replace(/\D/g, '');

        // Limita la longitud a 3 dígitos
        if (input.value.length > 3) {
            input.value = input.value.slice(0, 3);
        }
    }



        function anterior() {
            window.location.href='checkout.php';
        }

        function aceptar_terminos() {
            var confirmar=$('#confirmar').val();
            //alert(confirmar)
            if (confirmar==0) {
                document.getElementById("realizar_pago").disabled=true;
            } else {
                var elemento=document.getElementById("terminos")
                if (elemento.checked) {
                    document.getElementById("realizar_pago").disabled=false;
                } else {
                    document.getElementById("realizar_pago").disabled=true;
                }
            }
        }

        function pago() {            
            var solicitud=$('#solicitud').val();
            var cliente=$('#cliente').val();
            var token=$('#token').val();
            var monto=$('#monto').val();
            var email=$('#email').val();
            var metodo=$('#metodo').val();
            var id_custorm=$('#id_custorm').val();
            var plan='Plan de Suscripcion '+$('#plan').val();

            //alert(solicitud+' '+cliente+' '+token+' '+monto+' '+email+' '+metodo+' '+id_custorm)
           
            var terminos = $('input[name="terminos"]:checked').val();
            
            if (terminos==1) {
                //if (metodo=="Tarjeta") {
                    $.ajax({
                        method: "POST",
                        url: "flow/email_registrar_tarjeta.php",
                        data: 'solicitud='+solicitud+'&monto='+monto+'&cliente='+cliente+'&token='+token+'&email='+email+'&plan='+plan+'&id_custorm='+id_custorm+'&metodo='+metodo,
                        success: function(data) { 
                            //alert(data)
                            if (data!=1) {
                                window.open(data, '_blank');
                            } else {
                                $('#modal_error_mysqli').modal('show');                
                            }
                        }                
                    });                 
                //}
            } else {
                swal({
                    title: "Debe Aceptar Términos y Condiciones",
                    //text: "You clicked the button!", 
                    type: "warning",
                }); 
            }
        }
        

        function plan(plan) {
            
            if (plan=="webpay") {
                document.getElementById("plan1").classList.remove("bordeinactivo");
                document.getElementById("plan1").classList.add("bordeactivo");
                
                document.getElementById("plan2").classList.remove("bordeactivo");
                document.getElementById("plan2").classList.add("bordeinactivo");
                
                document.getElementById("plan3").classList.remove("bordeactivo");
                document.getElementById("plan3").classList.add("bordeinactivo");                
            } 
            if (plan=="paypal") {                
                document.getElementById("plan2").classList.remove("bordeinactivo");
                document.getElementById("plan2").classList.add("bordeactivo");
                
                document.getElementById("plan1").classList.remove("bordeactivo");
                document.getElementById("plan1").classList.add("bordeinactivo");
                
                document.getElementById("plan3").classList.remove("bordeactivo");
                document.getElementById("plan3").classList.add("bordeinactivo");
            } 
            if (plan=="tarjeta") {                
                document.getElementById("plan3").classList.remove("bordeinactivo");
                document.getElementById("plan3").classList.add("bordeactivo");
                
                document.getElementById("plan1").classList.remove("bordeactivo");
                document.getElementById("plan1").classList.add("bordeinactivo");
                
                document.getElementById("plan2").classList.remove("bordeactivo");
                document.getElementById("plan2").classList.add("bordeinactivo");
            }

        }

        $(document).ready(function() {

            document.getElementById("realizar_pago").disabled=true;             

            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            

        });
    </script>

</body>

</html>

<?php
}
?>
