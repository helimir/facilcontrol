<?php
session_start();
include('config/config.php');
if (empty($_SESSION['email']) ) { 
    $sesion=0;
} else {
    $query=mysqli_query($con,"select * from registro where id_registro='".$_SESSION['cliente']."' ");
    $result=mysqli_fetch_array($query);
    $cliente=$result['nombre'].' '.$result['apellido'];
    $monto=$result['monto'];
    $sesion=1;
    $usuario='@'.explode(" ",$result['nombre'])[0];
}

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



if (empty($_SESSION['email']) ) { 
    header("Location:suscripcion.php");
} else {
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Suscipcion-Checkout</title>

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
            font-size:22px;
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
        padding-left: 5px;
        margin-bottom: 0px;
        cursor: pointer;
        font-size: 22px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        }


        /* Hide the browser's default radio button */

        .contenedor input[type=radio] {
        opacity: 0;
        cursor: pointer;
        }


        /* Create a custom radio button */

        .checkmark {
        position: absolute;
        top: 20px;
        left: 50%;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
        }


        /* On mouse-over, add a grey background color */

        .contenedor:hover input~.checkmark {
        background-color: #fff;
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

@media (max-width: 768px) {
    .checkmark {
        position: absolute;
        top: 0px;
        left: 80%;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }
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
                                                <div class="step">
                                                    <div class="step-circle">4</div>
                                                    <div class="step-label">FINALIZAR</div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>

                                <div  class="row">
                                    <div class="col-lg-12">
                                        <div  class="ibox">
                                            <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Método de Pago <?php ?></h1>  
                                            <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:28px">Plan: <?php echo $_SESSION['plan'] ?></h1>  
                                                
                                        </div>
                                    </div>
                                </div> 
                        

                            <div style="border:none" class="ibox-content black-bg">     
                                
                                    <?php $useragent = $_SERVER['HTTP_USER_AGENT'];
                                    if (preg_match("/mobile/i", $useragent) ) { ?>
                                        <div  class="row">                                           
                                            <div class="col-lg-12">
                                                <div  class="ibox">
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="plan1">
                                                            <div class="form-group row black-bg">                                                                
                                                                <div class="col-12">                                                                                                                                            
                                                                    <label class="contenedor">                                                                        
                                                                         <label style="color:#fff;font-size:20px;font-weight:bold">Tarjetas Debito/Crédito</label>  
                                                                        <input type="radio" value="Tarjeta" name="metodo" onclick="plan(this.value)">
                                                                        <span class="checkmark"></span>                                                                        
                                                                    </label>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row black-bg">
                                                                <img style="border-radius:10px" width="150" class="col-sm-12" src="tarjeta1.png" >                                                                
                                                            </div>                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else {  ?>       
                                        <div style="margin-left:12%;margin-right:12%"  class="row">                                            
                                            <div class="col-lg-12">
                                                <div  class="ibox">
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="plan1">
                                                            <div class="form-group row black-bg">
                                                                <img style="border-radius:10px" width="150" class="col-4" src="tarjeta1.png" >
                                                                <label style="font-weight:bold;font-size:22px;color:#fff" class="col-6 col-form-label">Tarjetas Debito/Crédito</span></label>

                                                                <div class="col-2">                                                                
                                                                    <label class="contenedor">
                                                                        <input type="radio" value="Tarjeta" name="metodo" onclick="plan(this.value)">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }   ?>
                                        

                                    <?php $useragent = $_SERVER['HTTP_USER_AGENT'];
                                    if (preg_match("/mobile/i", $useragent) ) { ?>
                                        <div  class="row">                                           
                                            <div class="col-lg-12">
                                                <div  class="ibox">
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="plan2">                                                            
                                                            <div class="form-group row black-bg">                                                                
                                                                <div class="col-12">                                                                           
                                                                    <label class="contenedor">     
                                                                        <label style="color:#fff;font-size:20px;font-weight:bold">Paypal</label>                                                                     
                                                                        <input type="radio" value="Paypal" name="metodo" onclick="plan(this.value)">
                                                                        <span class="checkmark"></span>                                                                        
                                                                    </label>                                                                    
                                                                </div>
                                                            </div>
                                                            <div class="form-group row black-bg">
                                                                <img style="border-radius:10px" width="150" class="col-sm-12" src="paypal3.png" >                                                                
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else {  ?>                                     
                                        <div style="margin-left:12%;margin-right:12%"  class="row">                                                                              
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="plan2">
                                                            <div class="form-group row black-bg">
                                                                <img style="border-radius:10px" width="150" class="col-4" src="paypal3.png" >
                                                                <label style="font-weight:bold;font-size:22px;color:#fff" class="col-6 col-form-label">PayPal</span></label>

                                                                <div class="col-2">                                                                
                                                                    <label class="contenedor">
                                                                        <input type="radio" value="Paypal" name="metodo" onclick="plan(this.value)">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>                                      
                                        </div>
                                    <?php } ?>

                                    

                                </div>

                                <input type="hidden" name="solicitud" id="solicitud" value="<?php echo $result['id_registro'] ?>" >
                                <input type="hidden" name="cliente" id="cliente" value="<?php echo $cliente ?>" >
                                <input type="hidden" name="token" id="token" value="<?php echo $result['token'] ?>" >
                                <input type="hidden" name="monto" id="monto" value="<?php echo $monto ?>" >
                                <input type="hidden" name="email" id="email" value="<?php echo $_SESSION['email'] ?>" >

                                <div style="margin-top:4%"  class="row">  
                                            <?php  if (preg_match("/mobile/i", $useragent) ) { ?>
                                                <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                    <button style="font-size:18px;border-radius:5px;padding:2% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="anterior()">Volver atrás</button>                                    
                                                    <button style="font-size:18px;border-radius:5px;padding:2% 2%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="finalizar()">Siguiente paso</button>
                                                </div>
                                            <?php } else {  ?>       
                                                <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                    <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="anterior()">Volver atrás</button>                                    
                                                    <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="finalizar()">Siguiente paso</button>
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

        function anterior() {
            window.location.href='suscripcion.php';
        }

        

        function finalizar() {
            var plan = $('input[name="metodo"]:checked').val();
            if (plan!="Paypal" && plan!="Tarjeta") {
                swal({
                    title: "Seleccionar un Método",
                });
            } else {               
                    $.ajax({
                        method: "POST",
                        url: "suscripcion-metodo.php",
                        data: 'metodo='+plan,
                        success: function(data) {                             
                            if (data==1) {                              
                                window.location.href='finalizar.php';
                            } 
                        }                
                    }); 
            }
        }

        function finalizarwww() {
            var plan = $('input[name="metodo"]:checked').val();
            var solicitud=$('#solicitud').val();
            var cliente=$('#cliente').val();
            var token=$('#token').val();
            var monto=$('#monto').val();
            var email=$('#email').val();

            alert(plan+' '+solicitud+' '+cliente+' '+token+' '+monto+' '+email)

            if (plan!="Paypal" && plan!="Tarjeta") {
                swal({
                    title: "Seleccionar un Método",
                });
            } else {
                if (plan=="webpay") {
                    var solicitud=$('#solicitud').val();
                    var cliente=$('#cliente').val();
                    var token=$('#token').val();
                    var monto=$('#monto').val();
                    var email=$('#email').val();
                         
                    //alert(token+' '+solicitud+' '+cliente+' '+monto+' '+email)
                    $.ajax({
                        method: "POST",
                        url: "flow/flow.php",
                        data: 'solicitud='+solicitud+'&monto='+monto+'&cliente='+cliente+'&token='+token+'&email='+email,
                        success: function(data) { 
                            //alert(data)
                            if (data!=1) {
                                //alert('procesar')
                                window.open(data, '_blank');
                            } else {
                                $('#modal_error_mysqli').modal('show');                
                            }
                        }                
                    }); 
                }
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
