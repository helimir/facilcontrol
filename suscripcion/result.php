<?php
session_start();

if (empty($_SESSION['email']) ) { 
    header("Location:suscripcion.php");
} else {

    include('config/config.php');
date_default_timezone_set('America/Santiago');
$fecha = date('Y-m-d H:m:s', time());
$data=date('Y-m-d', time());

if (empty($_SESSION['email']) ) { 
    $sesion=0;
} else {
    require(__DIR__."/lib/FlowApi.class.php");

    $query=mysqli_query($con,"select * from registro where email='".$_SESSION['email']."' ");
    $result=mysqli_fetch_array($query);
    $cliente=$result['nombre'].' '.$result['apellido'];
    $monto=$result['monto'];
    $nick=$result['nick'];
    $usuario='@'.explode(" ",$result['nombre'])[0];
    $sesion=1;

    # obtener datos de tarjeta del clienta
    $id_custorm=$result['id_custorm'];
    $id_cliente=$result['id_registro'];

    $params = array(
        "customerId"=> $id_custorm,
        "externalId"=> $id_cliente,
    );

    $flowApi = new FlowApi;
    $serviceName = "customer/edit";    
    $response = $flowApi->send($serviceName, $params,"POST");

    $modo_pago=$response['pay_mode'];
    $tipo_tarjeta=$response['creditCardType'];
    $ultimos_numeros=$response['last4CardDigits'];

    #actualiza datos de tarjeta y metodo de pago en registro
    mysqli_query($con,"update registro set modo_pago='$modo_pago', numero_tarjeta='$ultimos_numeros', tipo_tarjeta='$tipo_tarjeta', metodo='".$_SESSION['metodo']."' where id_registro='$id_cliente' ");

    #crear suscripcion
    $params2 = array(
        //"subscriptionId"=> "sus_azcyjj9ycd",
        "planId"=> "F-DIARIOCL",
        "plan_name"=> "Suscipcion Diaria",
        "customerId"=> $result['id_custorm'], 
    );

    $serviceName2 = "subscription/create";
    $response2 = $flowApi->send($serviceName2, $params2,"POST");

    $cliente=$result['id_registro'];
    $plan=$result['plan'];

    
    $inicio=$response2['subscription_start'];
    $periodo_inicio=$response2['subscription_start'];
    $periodo_fin=$response2['subscription_end'];
    $proxima_factura=$response2['next_invoice_date'];
    $dias_hasta_vencimiento=$response2['days_until_due'];
    $estado=$response2['status'];
    $creado=$response2['created'];
    $mororidad=$response2['morose'];
    

    $query_suscripcion=mysqli_query($con,"INSERT INTO suscripciones 
    (custorm_id,plan,inicio,periodo_inicio,periodo_fin,proxima_factura,dias_hasta_vencimiento,creado,estado,morosidad) 
    values 
    ('$id_custorm','$plan','$inicio','$periodo_inicio','$periodo_fin','$proxima_factura','$dias_hasta_vencimiento','$fecha','$estado','$mororidad)  ");

    # si se creo la suscripcion
    if ($query_suscripcion) {
        $invoices=$response['invoices'];
        foreach($invoices as $invoice) {
            mysqli_query($con,"INSERT INTO facturas 
            (id_invoice,subscriptionId,custorm_id,asunto,currency,amount,period_start,period_end,attemp_count,attemped,next_attemp_date,due_date,creado,estado) 
            VALUES 
            ('".$invoice['id']."','".$invoice['subscriptionId']."','".$invoice['custorm_id']."','".$invoice['subject']."','".$invoice['currency']."','".$invoice['amount']."','".$invoice['period_star']."','".$invoice['period_end']."','".$invoice['attemp_count']."','".$invoice['attemped']."','".$invoice['next_attemp_date']."','".$invoice['due_date']."','".$invoice['created']."','".$invoice['status']."' ) ");            
        }
    }

}

$query_plan=mysqli_query($con,"select * from plan_suscripcion");
$result_plan=mysqli_fetch_array($query_plan);


    
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Suscipcion-Result</title>

    <link href="..\css\bootstrap.min.css" rel="stylesheet">
    <link href="..\font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="..\css\animate.css" rel="stylesheet">
    <link href="..\css\style.css" rel="stylesheet">

    <link href="..\css\plugins\iCheck\custom.css" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="..\css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

    

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

                    <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-reorder"></i>
                    </button>-->

                <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav mr-auto">
                            <?php if ($sesion==1) { ?>
                                <li>                                
                                    <span> <?php echo $usuario ?></span>
                                </li>
                            <?php } ?>
                            <!--<li>
                                <a  href="#" > Menu item</a>
                            </li>
                            <li>
                                <a  href="#" > Menu item</a>
                            </li>-->

                        </ul>
                    <!--<ul class="nav navbar-top-links navbar-right">
                        <li>
                        </li>
                    </ul>-->
                </div>
            </nav>
        </div>
       
        <div class="wrapper wrapper-content">               
               
            <div  class="container">         
                <div style="border-radius: 10px;padding-top:2%" class="row black-bg">   

                    <div class="col-lg-12 ">
                        <div class="ibox">
                            
                            <div style="border:none;padding:0%" class="ibox-content black-bg">  

                                

                                <?php if (preg_match("/mobile/i", $useragent) ) { ?>
                                    <div  class="row">
                                        <div class="col-lg-12">
                                            <div  class="ibox">
                                                <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:28px">Resultado de Pago</h1>
                                            </div>
                                        </div>
                                    </div> 
                                <?php } else {  ?>       
                                    <div  class="row">
                                        <div class="col-lg-12">
                                            <div  class="ibox">
                                                <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Resultado de Pago</h1>
                                            </div>
                                        </div>
                                    </div> 
                                <?php }  ?>       

                                
                        

                                <div style="border:none" class="ibox-content black-bg">  

                                                    <?php if (preg_match("/mobile/i", $useragent) ) { ?>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                            <div class="row">
                                                                                <div style="font-size:15px;color:#fff" class="col-lg-12">
                                                                                    <label style="font-size:18px;" class="form-label">Estimad@: <b><?php echo $cliente ?></b></label>
                                                                                </div>
                                                                            </div>

                                                                            <div style="margin-top:" class="row">
                                                                                <div style="color:#fff" class="col-lg-12">
                                                                                    <label style="font-size:18px;" class="form-label">Su Plan de Suscripción <?php  echo $_SESSION['plan'] ?> ha sido registrado exitosamente.</label>
                                                                                </div>
                                                                            </div>

                                                                            <!--<div style="font-size:12px;color:#fff;margin-top:4%" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">METODO DE PAGO</label><br>
                                                                                <?php 
                                                                                    if ($_SESSION['metodo']=="Webpay") {
                                                                                        $imagen="webpay1.png";
                                                                                    }
                                                                                    if ($_SESSION['metodo']=="Paypal") {
                                                                                        $imagen="paypal3.png";
                                                                                    }
                                                                                    if ($_SESSION['metodo']=="Tarjeta") {
                                                                                        $imagen="tarjeta1.png";
                                                                                    }
                                                                                ?>
                                                                                <label style="font-size:20px;color:#fff"><img width="100" src="<?php echo $imagen ?>"> <?php echo $_SESSION['metodo'] ?></label>
                                                                            </div>-->
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

                                                                        <div class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-12">
                                                                                <label style="font-size:18px;" class="form-label">Estimad@: <b><?php echo $cliente ?></b></label>
                                                                            </div>
                                                                        </div>

                                                                        <div style="margin-top:" class="row">
                                                                            <div style="color:#fff" class="col-lg-12">
                                                                                <label style="font-size:18px;" class="form-label">Su Plan de Suscripción <?php  echo $_SESSION['plan'] ?> ha sido registrado exitosamente.</label>
                                                                            </div>
                                                                        </div>

                                                                        <!--<div style="margin-top:5%" class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-12 col-sm-12">
                                                                                <label style="font-size:15px;" class="form-label">METODO DE PAGO</label><br>
                                                                                <?php 
                                                                                    if ($_SESSION['metodo']=="Webpay") {
                                                                                        $imagen="webpay1.png";
                                                                                    }
                                                                                    if ($_SESSION['metodo']=="Paypal") {
                                                                                        $imagen="paypal3.png";
                                                                                    }
                                                                                    if ($_SESSION['metodo']=="Tarjeta") {
                                                                                        $imagen="tarjeta1.png";
                                                                                    }
                                                                                ?>
                                                                                <label style="font-size:30px;color:#fff"><img width="100" src="<?php echo $imagen ?>"> <?php echo $_SESSION['metodo'] ?></label>
                                                                            </div>
                                                                        </div>-->

                                                                       

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }   ?>
                                       

                            </div>

                                            <div style="margin-top:4%"  class="row">  
                                                <?php  if (preg_match("/mobile/i", $useragent) ) { ?>
                                                    <div style="text-align:center;" class="col-lg-12 col-sm-12">                                                        
                                                        <a style="font-size:18px;border-radius:5px;padding:2% 5%;color: #fff" class="btn btn-lg btn-success" href="suscripcion.php">Volver a Inicio</a>                                                                                                                                                    
                                                    </div>
                                                <?php } else {  ?>       
                                                    <div style="text-align:center;" class="col-lg-12 col-sm-12">                                                     
                                                            <a style="font-size:18px;border-radius:5px;padding:1% 5%;color: #fff" class="btn btn-lg btn-success" href="suscripcion.php" >Volver a Inicio</a>                                                                                            
                                                    </div>
                                                <?php }   ?>
                                            </div>
                          
                                

                        </div>
                    </div>

                </div>

            </div>

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

    <script>

        

        $(document).ready(function() {

            

        });
    </script>

</body>

</html>

<?php } ?>