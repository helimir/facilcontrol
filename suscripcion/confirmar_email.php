<?php
session_start();
include('config/config.php');
$token=$_GET['token'];
$query=mysqli_query($con,"select * from registro where token='$token' ");
$result=mysqli_fetch_array($query);

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

                                

                                <?php if (preg_match("/mobile/i", $useragent) ) { ?>
                                    <div  class="row">
                                        <div class="col-lg-12">
                                            <div  class="ibox">
                                                <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:28px">Confirmación de Email</h1>
                                            </div>
                                        </div>
                                    </div> 
                                <?php } else {  ?>       
                                    <div  class="row">
                                        <div class="col-lg-12">
                                            <div  class="ibox">
                                                <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Confirmación de Email</h1>
                                            </div>
                                        </div>
                                    </div> 
                                <?php }  ?>       

                                
                        
                                <?php if ($result['confirmar']==0) { 
                                    $query_confirmar=mysqli_query($con,"update registro set confirmar=1 where token='$token'");

                                    if ($query_confirmar) {
                                ?>        
                                                <div style="border:none" class="ibox-content black-bg"> 
                                                    <?php if (preg_match("/mobile/i", $useragent) ) { ?>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                            <div style="margin-top:" class="row">
                                                                                <div style="color:#fff" class="col-lg-12">
                                                                                    <label style="font-size:22px;" class="form-label">Su email ha sido confirmado, puede <a style="color:#2EB8E2" href="#" onclick="login()">iniciar sesión</a> para continuar con la suscripción</label>
                                                                                </div>
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

                                                                        <div style="margin-top:" class="row">
                                                                            <div style="color:#fff" class="col-lg-12">
                                                                                <label style="font-size:28px;" class="form-label">Su email ha sido confirmado, puede <a style="color: #2EB8E2" href="#" onclick="login()">iniciar sesión</a> para continuar con la suscripción.</label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }   ?>
                                            </div>

                                <?php 
                                    # sino se logra confirmar correo mensaje de refrescar pagina
                                    } else { ?>

                                                <div style="border:none" class="ibox-content black-bg"> 
                                                    <?php if (preg_match("/mobile/i", $useragent) ) { ?>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                            <div style="margin-top:" class="row">
                                                                                <div style="color:#fff" class="col-lg-12">
                                                                                    <label style="font-size:22px;" class="form-label">Disculpe!! Error de sistema email no se confirmo, refresque la pagina.</label>
                                                                                </div>
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

                                                                        <div style="margin-top:" class="row">
                                                                            <div style="color:#fff" class="col-lg-12">
                                                                                <label style="font-size:28px;" class="form-label">Disculpe!! Error de sistema email no se confirmo, refresque la pagina.</label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }   ?>
                                                </div>
                                                        
                                <?php }
                                    } else { ?>           

                                                <div style="border:none" class="ibox-content black-bg"> 
                                                    <?php if (preg_match("/mobile/i", $useragent) ) { ?>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                            <div style="margin-top:" class="row">
                                                                                <div style="color:#fff" class="col-lg-12">
                                                                                    <label style="font-size:22px;" class="form-label">Email ya ha sido confirmado, puede <a style="color:#2EB8E2" href="#" onclick="login()">iniciar sesión</a> para continuar con la suscripción</label>
                                                                                </div>
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

                                                                        <div style="margin-top:" class="row">
                                                                            <div style="color:#fff" class="col-lg-12">
                                                                                <label style="font-size:28px;" class="form-label">Email ya ha sido confirmado, puede <a style="color: #2EB8E2" href="#" onclick="login()">iniciar sesión</a> para continuar con la suscripción.</label>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }   ?>
                                                </div>

                                            

                                <?php } ?>

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
                                        //window.location.href='checkout.php';
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

        $(document).ready(function() {

            

        });
    </script>

</body>

</html>