<?php
session_start();
include('config/config.php');
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

if ($_GET['plan']=="Diario") {
    $query=mysqli_query($con,"select * from plan_suscripcion where plan='Diario' ");
    $result=mysqli_fetch_array($query);
    $monto=$result['monto'];
    $planid=$result['planid'];
    $nombre_plan=$result['nombre_plan'];
} 

if ($_GET['plan']=="Mensual") {
    $query=mysqli_query($con,"select * from plan_suscripcion where plan='Mensual' ");
    $result=mysqli_fetch_array($query);
    $monto=$result['monto'];
    $planid=$result['planid'];
    $nombre_plan=$result['nombre_plan'];
} 
if ($_GET['plan']=="Anual") {
    $query=mysqli_query($con,"select * from plan_suscripcion where plan='Anual'");
    $result=mysqli_fetch_array($query);
    $monto=$result['monto'];
    $planid=$result['planid'];
    $nombre_plan=$result['nombre_plan'];
}

if (empty($_SESSION['email']) ) { 
    $sesion=0;
} else {
    $query=mysqli_query($con,"select * from registro where email='".$_SESSION['email']."' ");
    $result=mysqli_fetch_array($query);
    $sesion=1;
    $usuario='@'.explode(" ",$result['nombre'])[0];
}

?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Suscipcion-Registro</title>

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

        .bordefalta {
            border-style: solid;
            border-color: #F03737;
            border-width: 2px;
        }

        .bordellenar {
            border-style: solid;
            border-color: #FFF;
            border-width: 1px;
        }


body {
    font-family: Arial, sans-serif;
    
}

.stepper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 1000px;
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


.loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #1C84C6;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
}

    </style>

</head>

<body class="top-navigation">

<div id="wrapper">
    <div style="background:#000" id="page-wrapper" class="black-bg">

        <div class="row ">
            <nav style="background:#262626;" class="navbar navbar-expand-lg navbar-static-top" role="navigation">

                    <?php if ($sesion==1) { ?>
                        <a  style="background: #F03737;color: #fff;" href="logout-suscripcion.php"  class="navbar-brand"></i><span style="border:1px #fff solid;padding: 4% 6%">Cerrar Sesión</span></a>
                    <?php } else { ?>
                            <a style="background: #2EB8E2" href="#" onclick="login()"  class="navbar-brand"><span style="border:1px #fff solid;padding: 4% 6%">Iniciar Sesión</span></a>
                    <?php }  ?>

                    <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-reorder"></i>
                    </button>-->
                

                <div style="background:#262626;" class="navbar-collapse collapse" id="navbar">
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
                    <!--<ul class="nav navbar-top-links s">
                        <li>                            
                        </li>
                    </ul>-->
                </div>
            </nav>
        </div>
    
            
       
        <div class="wrapper wrapper-content">

     
            <div class="container">            
        
            
                <div style="border-radius: 10px;padding-top:2%" class="row black-bg">                        

                    <div class="col-lg-12 ">
                        <div class="ibox">

                            <div style="border:none" class="ibox-content black-bg">  
                                <div  class="row">
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
                                                <div class="step">
                                                    <div class="step-circle">3</div>
                                                    <div class="step-label">PAGO</div>
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
                                            <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Registro <?php ?></h1>  
                                            <h1  style="color:#fff;text-align:center;font-size:18px">¿Ya esta Registrado? <a style="color:#2EB8E2" onclick="login()">Inicie Sesión</a></h1>
                                        </div>
                                    </div>
                                </div> 

                                <!--<form  method="post"  enctype="multipart/form-data" id="frmregistro" autocomplete="OFF">-->
                                        <div class="row">
                                            <div style="font-size:20px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label style="margin-top:4%" class="col-form-label">NOMBRE</label>
                                                <input  style="background-color:#262626;font-size:20px;color:#fff" placeholder="escriba su nombre" type="text" name="nombre" id="nombre" onblur="validar_nombre()" onclick="btnnombre()" autocomplete="off" class="form-control bordellenar">
                                                <span style="color: #F03737;font-weight: bold;" id="lbl_nombre" class="form-label" ></span>
                                            </div>
                                            <div style="font-size:20px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label style="margin-top:4%" class="col-form-label">APELLIDO</label>
                                                <input style="background-color:#262626;font-size:20px;color:#fff" placeholder="escriba su apellido" type="text" name="apellido" id="apellido" onblur="validar_apellido()" onclick="btnapellido()" class="form-control">
                                                <span style="color: #F03737;font-weight: bold;" id="lbl_apellido" class="form-label" ></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div style="font-size:20px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label style="margin-top:4%" class="col-form-label">EMAIL</label>
                                                <input style="background-color:#262626;font-size:20px;color:#fff" placeholder="escriba su correo electrónico" type="email" name="email" id="email" autocomplete="OFF" onblur="validar_email()" onclick="btnemail()"   class="form-control">
                                                <span style="color: #F03737;font-weight: bold;" id="lbl_email" class="form-label" ></span>
                                                <span style="color: #2EB8E2;font-weight: bold;" id="lbl_validar" class="form-label" ></span>
                                                <input type="hidden" id="validar_email" name="validar_email" value="0">
                                            </div>
                                            <div style="font-size:20px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label style="margin-top:4%" class="col-form-label">NICKNAME</label>
                                                <input style="background-color:#262626;font-size:20px;color:#fff" placeholder="escriba su usuario" type="text" name="nick" id="nick" onblur="validar_nick()" onclick="btnnick()" class="form-control">
                                                <span style="color: #F03737;font-weight: bold;" id="lbl_nick" class="form-label" ></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div style="font-size:20px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label style="margin-top:4%" class="col-form-label">CONTRASEÑA</label>
                                                <input style="background-color:#262626;font-size:20px;color:#fff" placeholder="escriba su contraseña" type="password" name="pass1" id="pass1" onblur="validar_pass1()" onclick="btnpass1()" autocomplete="new-password" class="form-control">
                                                <span style="color: #F03737;font-weight: bold;" id="lbl_pass1" class="form-label" ></span>
                                            </div>
                                            <div style="font-size:20px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label style="margin-top:4%" class="col-form-label">CONFIRMAR CONTRASEÑA</label>
                                                <input style="background-color:#262626;font-size:20px;color:#fff" placeholder="confirme su contraseña" type="password" name="pass2" id="pass2" onblur="validar_pass2()" onclick="btnpass2()" autocomplete="new-password" class="form-control">
                                                <span style="color: #F03737;font-weight: bold;" id="lbl_pass2" class="form-label" ></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div style="font-size:14px;color:#fff" class="col-lg-6 col-sm-12">
                                                <label class="col-form-label">Todos los campos son obligatorios.</label>                                        
                                            </div>
                                        </div>

                                    <input type="hidden" name="plan" id="plan" value="<?php echo $_GET['plan'] ?>" >    
                                    <input type="hidden" name="pais" id="pais" value="<?php echo $pais ?>" >
                                    <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo ?>" >
                                    <input type="hidden" name="ip" id="ip" value="<?php echo $direccion_ip ?>" >
                                    <input type="hidden" name="monto" id="monto" value="<?php echo $monto ?>" >
                                    <input type="hidden" name="planid" id="planid" value="<?php echo $planid ?>" >
                                    <input type="hidden" name="nombre_plan" id="nombre_plan" value="<?php echo $nombre_plan ?>" >

                                    <div style="margin-top:4%"  class="row">  
                                            <?php  if (preg_match("/mobile/i", $useragent) ) { ?>
                                                <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                    <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="anterior()">Volver atrás</button>                                    
                                                    <button style="font-size:18px;border-radius:5px;padding:2% 2%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="registro()">Siguiente paso</button>
                                                </div>
                                            <?php } else {  ?>       
                                                <div style="text-align:center;" class="col-lg-12 col-sm-12">
                                                    <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="anterior()">Volver atrás</button>                                    
                                                    <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="registro()">Siguiente paso</button>
                                                </div>
                                            <?php }   ?>
                                    </div>

                                <!--</form>-->

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


                        <div class="modal fade" id="modal_registro2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando registro, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Espere hasta que cierre esta ventana</h3> 
                                                <div class="progress"> 
                                                    <div id="myBar" class="progress-bar" style="width:0%;">
                                                        <span class="progress-bar-text">0%</span>
                                                    </div>
                                                </div>     
                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div style="background:#000000" class="modal-content">
      <!--div style="margin-buttom--2%" class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span style="color:#fff" aria-hidden="true">&times;</span>
        </button>
      </div>-->
      <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span style="color:#fff" aria-hidden="true">&times;</span>
            </button>
            <div class="form-title text-center">
                    <h1 style="color:#fff;">Iniciar Sesión</h1>
                </div>
                <div class="d-flex flex-column ">

                    <div id="div_confirmar" style="background: #F03737;padding: 0% 2%;" class="form-group">
                        <label style="text-align:left;color:#fff;font-size:18px;margin-top:2%;padding: 0% 2%">Cuenta NO confirmada. Favor confirmar con el email de confirmación recibido.</label>                        
                    </div>
                
                    <div class="form-group">
                        <label style="text-align:left;color:#fff;font-size:16px;margin-top:2%">Ingrese Email</label>
                        <input style="background:#000000;font-size:18px;color:#fff;" type="email" class="form-control" name="cliente" id="cliente"placeholder="Su email" autocomplete="new-password" onblur="validar_email2()" onclick="btnemail2()" class="form-control">
                        <span style="color: #F03737;font-weight: bold;" id="lbl_email2" class="form-label" ></span>
                        <span style="color: #2EB8E2;font-weight: bold;" id="lbl_validar2" class="form-label" ></span>
                        <!--<span style="color: #2EB8E2;font-weight: bold;" id="validar_email" class="form-label" ></span>-->
                    </div>
                    <div class="form-group">
                        <label style="text-align:left;color:#fff;font-size:16px;margin-top:4%">Ingrese su contraseña</label>
                        <input style="background:#000000;font-size:18px;color:#fff;" type="password" class="form-control" name="pass" id="pass" placeholder="Su contraseña" autocomplete="new-password" onblur="validar_pass3()" onclick="btnpass3()" class="form-control">
                        <span style="color: #F03737;font-weight: bold;" id="lbl_pass3" class="form-label" ></span>
                    </div>
                    <button style="background-color: #2EB8E2;padding:2% 0%;margin-top:4%;font-size:26px" class="btn btn-info btn-block btn-round" type="button" onclick="acceder()">Acceder</button>
              
                <script>

                    function acceder() {
                        var cliente=$('#cliente').val();
                        var pass=$('#pass').val();

                        if (cliente=="") {
                            swal({
                                title: "Email Requerido",
                                //text: "You clicked the button!", 
                                type: "error",
                            }); 
                        } else {

                            if (pass=="") {
                                swal({
                                    title: "Contraseña Requerida",
                                    //text: "You clicked the button!", 
                                    type: "error",
                                }); 
                            } else {

                                $.ajax({
                                    method: "POST",
                                    url: "suscripcion-login.php",
                                    data: 'cliente='+cliente+'&pass='+pass,
                                    success: function(data) {
                                         //alert(data)
                                         if (data==0) {
                                            swal({
                                                title: "Email Inválido",                                                
                                                //text: "No registrado ", 
                                                type: "error",
                                            });                                    
                                        }
                                        if (data==3) {
                                            swal({
                                                title: "Contraseña Inválida",
                                                //text: "You clicked the button!", 
                                                type: "error",
                                            });                                    
                                        }
                                        if (data==1) {
                                            window.location.href='checkout.php';                                    
                                        }
                                        if (data==5) {
                                            $('#div_confirmar').show();
                                        }
                                    }
                                })
                            }
                        }
                    }
                    
                </script>    
      </div>
        <!--<div class="modal-footer d-flex justify-content-center">
          <div class="signup-section">¿No esta Registrado? <a href="#a" class="text-info"> Registro</a>.</div>
        </div>-->  
    </div>
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

        function login() {
            $('#exampleModal').modal('show');
        }

        

        function validar_email2() {            
            var valor=$('#cliente').val();
            
            if (valor!="") {
                //var texto = document.getElementById(valor).value;
                var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
                
                if (!regex.test(valor)) {
                    //document.getElementById("validar_email").innerHTML = "Correo invalido";
                    $("#lbl_validar2").html("<span style='font-size:15px'>Correo invalido</span>");
                } else {
                    //document.getElementById("validar_email").innerHTML = "";
                    $("#lbl_validar2").html("<span style='font-size:15px'></span>");
                }
                
                document.getElementById("cliente").classList.remove("bordefalta");
                document.getElementById("cliente").classList.add("bordellenar");
                $("#lbl_email2").html("<span style='font-size:15px'></span>");

            } else {
                document.getElementById("cliente").classList.remove("bordellenar");
                document.getElementById("cliente").classList.add("bordefalta");
                $("#lbl_email2").html("<span style='font-size:15px'>* EMAIL REQUERIDO</span>");
            }
        }

        function validar_pass3() {
            var valor=$('#pass').val();
            if (valor!="") {
                document.getElementById("pass").classList.remove("bordefalta");
                document.getElementById("pass").classList.add("bordellenar");
                $("#lbl_pass3").html("<span style='font-size:12px'></span>");
            } else {
                document.getElementById("pass").classList.remove("bordellenar");
                document.getElementById("pass").classList.add("bordefalta");
                $("#lbl_pass3").html("<span style='font-size:12px'>* CONTRASEÑA REQUERIDO</span>");
            }
        }

       
        function btnemail2() {
            $("#lbl_email2").html("<span style='font-size:15px'></span>");
            $("#lbl_validar2").html("<span style='font-size:15px'></span>");
        }

        function btnpass3() {            
            $("#lbl_pass3").html("<span style='font-size:15px'></span>");
        }
    
        function registro() {
            //alert('registro')
            var nombre=$('#nombre').val();        
            var apellido=$('#apellido').val();
            var nick=$('#nick').val();
            var email=$('#email').val();
            var pass1=$('#pass1').val();
            var pass2=$('#pass2').val();
            var plan=$('#plan').val();
            var pais=$('#pais').val();
            var codigo=$('#codigo').val();
            var ip=$('#ip').val();
            var monto=$('#monto').val();

            var planid=$('#planid').val();
            var nombre_plan=$('#nombre_plan').val();

            
            if (nombre=="") {
                swal({
                    title: "Nombre no puede estar vacio",
                    //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                });
                document.getElementById("nombre").classList.remove("bordellenar");
                document.getElementById("nombre").classList.add("bordefalta");
                $("#lbl_nombre").html("<span style='font-size:14px'>* NOMBRE REQUERIDO</span>");
            } else {
                if (apellido=="") {
                    swal({
                        title: "Apellido no puede estar vacio",
                        //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                    });
                } else {
                    if (email=="") {
                        swal({
                            title: "Email no puede estar vacio",
                            //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                        });
                    } else {

                        var validar_email=$('#validar_email').val();
                        if (validar_email==0) {
                            swal({
                                title: "Email no válido",
                                //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                            });

                        } else {
                                if (nick=="") {
                                    swal({
                                        title: "Nickname no puede estar vacio",
                                        //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                                    });
                                } else {
                                    if (pass1=="") {
                                        swal({
                                            title: "Contraseña no puede estar vacio",
                                            //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                                        });
                                    } else {
                                        if (pass1!=pass2) {
                                            swal({
                                                title: "Contraseñas deben ser iguales",
                                                //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                                            });
                                        } else {
                                            //alert('registro22')
                                                    var formData = new FormData();                                             
                                                    formData.append('nombre',nombre);
                                                    formData.append('apellido',apellido);
                                                    formData.append('email',email);
                                                    formData.append('nick', nick );
                                                    formData.append('pass1', pass1 );
                                                    formData.append('pass2', pass2 );
                                                    formData.append('plan', plan );
                                                    formData.append('pais', pais );
                                                    formData.append('codigo', codigo );
                                                    formData.append('ip', ip );
                                                    formData.append('monto', monto );
                                                    formData.append('planid', planid );
                                                    formData.append('nombre_plan', nombre_plan );
                                                    $.ajax({
                                                        url: 'registrar.php',
                                                        type: 'post',
                                                        data:formData,
                                                        contentType: false,
                                                        processData: false,
                                                        beforeSend: function(){

                                                                const progressBar = document.getElementById('myBar');
                                                                const progresBarText = progressBar.querySelector('.progress-bar-text');
                                                                let percent = 0;
                                                                progressBar.style.width = percent + '%';
                                                                progresBarText.textContent = percent + '%';
                                                                    
                                                                let progress = setInterval(function() {
                                                                    if (percent >= 100) {
                                                                            clearInterval(progress);                                                                                                       
                                                                        } else {
                                                                            percent = percent + 1; 
                                                                            progressBar.style.width = percent + '%';
                                                                            progresBarText.textContent = percent + '%';
                                                                        }
                                                                }, 100);
                                                                $('#modal_cargar').modal('show');						
                                                            },
                                                        success: function(data){		
                                                            //alert(data)	  
                                                            if (data==0) { 
                                                                $('#modal_cargar').modal('hide');   
                                                                swal({
                                                                        title: "Registro Creado",
                                                                        //text: "You clicked the button!", 
                                                                        type: "success"
                                                                });
                                                                setTimeout(window.location.href='checkout.php', 3000);
                                                            } else {
                                                                $('#modal_cargar').modal('hide'); 
                                                                if (data==1) { 
                                                                    swal("Registro No Creado", "Vuelva a Intentar.", "error");
                                                                }
                                                                if (data==2) { 
                                                                    swal({
                                                                        title: "Email ya esta Registrado",
                                                                        text: "Favor intentar con otro",
                                                                        type: "warning"
                                                                    });
                                                                }

                                                                if (data==3) { 
                                                                    swal({
                                                                        title: "Nickname ya esta Registrado",
                                                                        text: "Favor intentar con otro",
                                                                        type: "warning"
                                                                    });
                                                                }
                                                                
                                                            }
                                                            },
                                                        complete:function(data){
                                                                $('#modal_cargar').modal('hide');
                                                            }, 
                                                        error: function(data){
                                                            }                
                                                        }); 
                                        }
                                    }
                                }
                            }
                    }
                }

            }            
        }
        
    

        function siguiente() {
            window.location.href='suscripcion.php';
        }

        function anterior() {
            window.location.href='suscripcion.php';
        }

        function btnnombre() {
            $("#lbl_nombre").html("<span style='font-size:12px'></span>");
        }        

        function btnapellido() {
            $("#lbl_apellido").html("<span style='font-size:12px'></span>");
        }

        function btnemail() {
            $("#lbl_email").html("<span style='font-size:15px'></span>");
            $("#lbl_validar").html("<span style='font-size:15px'></span>");
        }

        function btnnick() {
            $("#lbl_nick").html("<span style='font-size:12px'></span>");
        }

        function btnpass1() {
            $("#lbl_pass1").html("<span style='font-size:12px'></span>");
        }

        function btnpass2() {
            $("#lbl_pass2").html("<span style='font-size:12px'></span>");
        }

        function validar_nombre() {
            var valor=$('#nombre').val();
            if (valor!="") {
                document.getElementById("nombre").classList.remove("bordefalta");
                document.getElementById("nombre").classList.add("bordellenar");
                $("#lbl_nombre").html("<span style='font-size:12px'></span>");
            } else {
                document.getElementById("nombre").classList.remove("bordellenar");
                document.getElementById("nombre").classList.add("bordefalta");
                $("#lbl_nombre").html("<span style='font-size:12px'>* NOMBRE REQUERIDO</span>");
            }
        }

        function validar_apellido() {
            var valor=$('#apellido').val();
            if (valor!="") {
                document.getElementById("apellido").classList.remove("bordefalta");
                document.getElementById("apellido").classList.add("bordellenar");
                $("#lbl_apellido").html("<span style='font-size:12px'></span>");
            } else {
                //document.getElementById("apellido").classList.remove("bordellenar");
                document.getElementById("apellido").classList.add("bordefalta");
                $("#lbl_apellido").html("<span style='font-size:12px'>* APELLIDO REQUERIDO</span>");
            }
        }

        function validar_email() {
            var valor=$('#email').val();
            if (valor!="") {
                //var texto = document.getElementById(valor).value;
                var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

                if (!regex.test(valor)) {
                    document.getElementById("validar_email").value=0;
                    //document.getElementById("validar_email").innerHTML = "Correo invalido";
                    $("#lbl_validar").html("<span style='font-size:15px'>Correo invalido</span>");
                } else {
                    document.getElementById("validar_email").value=1;
                    //document.getElementById("validar_email").innerHTML = "";
                    $("#lbl_validar").html("<span style='font-size:15px'></span>");
                }
                document.getElementById("email").classList.remove("bordefalta");
                document.getElementById("email").classList.add("bordellenar");
                $("#lbl_email").html("<span style='font-size:15px'></span>");

            } else {
                document.getElementById("email").classList.remove("bordellenar");
                document.getElementById("email").classList.add("bordefalta");
                $("#lbl_email").html("<span style='font-size:15px'>* EMAIL REQUERIDO</span>");
            }
        }

        function validar_nick() {
            var valor=$('#nick').val();
            if (valor!="") {
                document.getElementById("nick").classList.remove("bordefalta");
                document.getElementById("nick").classList.add("bordellenar");
                $("#lbl_nick").html("<span style='font-size:12px'></span>");
            } else {
                document.getElementById("nick").classList.remove("bordellenar");
                document.getElementById("nick").classList.add("bordefalta");
                $("#lbl_nick").html("<span style='font-size:12px'>* NICKNAME REQUERIDO</span>");
            }
        }

        function validar_pass1() {
            var valor=$('#pass1').val();
            if (valor!="") {
                document.getElementById("pass1").classList.remove("bordefalta");
                document.getElementById("pass1").classList.add("bordellenar");
                $("#lbl_pass1").html("<span style='font-size:12px'></span>");
            } else {
                document.getElementById("pass1").classList.remove("bordellenar");
                document.getElementById("pass1").classList.add("bordefalta");
                $("#lbl_pass1").html("<span style='font-size:12px'>* CONTRASEÑA REQUERIDO</span>");
            }
        }

        function validar_pass2() {
            var valor=$('#pass2').val();
            if (valor!="") {
                document.getElementById("pass2").classList.remove("bordefalta");
                document.getElementById("pass2").classList.add("bordellenar");
                $("#lbl_pass2").html("<span style='font-size:12px'></span>");
            } else {
                document.getElementById("pass2").classList.remove("bordellenar");
                document.getElementById("pass2").classList.add("bordefalta");
                $("#lbl_pass2").html("<span style='font-size:12px'>* CONFIRMAR CONTRASEÑA REQUERIDO</span>");
            }
        }

        function plan(plan) {
            
            if (plan==1) {
                document.getElementById("plan1").classList.remove("bordeinactivo");
                document.getElementById("plan1").classList.add("bordeactivo");

                document.getElementById("plan2").classList.remove("bordeactivo");
                document.getElementById("plan2").classList.add("bordeinactivo");
            } else {
                document.getElementById("plan1").classList.remove("bordeactivo");
                document.getElementById("plan1").classList.add("bordeinactivo");

                document.getElementById("plan2").classList.remove("bordeinactivo");
                document.getElementById("plan2").classList.add("bordeactivo");
            }

        }

        $(document).ready(function() {
            $('#div_confirmar').hide();

            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            

        });

        

        

        


    </script>

</body>

</html>

