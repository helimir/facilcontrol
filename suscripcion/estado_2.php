<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Suscipcion</title>

    <link href="..\css\bootstrap.min.css" rel="stylesheet">
    <link href="..\font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="..\css\animate.css" rel="stylesheet">
    <link href="..\css\style.css" rel="stylesheet">

    <link href="..\css\plugins\iCheck\custom.css" rel="stylesheet">

    <!-- Google Fonts
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">    
    <script src="https://accounts.google.com/gsi/client" async defer></script> -->

    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

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
                            <a href="logout-suscripcion.php"><i class="fa fa-sign-out"></i> Cerrar Sesi�n</a>                            
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
                                                <div class="step">
                                                    <div class="step-circle">2</div>
                                                    <div class="step-label">REGISTRO</div>
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
                                            <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Seleccionar Plan <?php //echo $_SESSION['plan'].'/'.$result['plan']  ?></h1>  
                                        </div>
                                    </div>
                                </div> 
                        

                            <div style="border:none" class="ibox-content black-bg">

                                    <div  class="row">
                                        <div class="col-lg-4 col-sm-12">
                                            <div  class="ibox">
                                                <?php 
                                                
                                                $query_diario=mysqli_query($con,"select * from plan_suscripcion where plan='Diario' ");
                                                $result_diario=mysqli_fetch_array($query_diario);

                                                if ($sesion==0) { ?>
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content bordeinactivo" id="plan0">
                                                        <div class="form-group row black-bg">
                                                            <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Diario<br><span style="font-size:36px"><?php echo "$" . number_format($result_diario['monto'], 0, ",", ".");?></span></label>

                                                            <div class="col-sm-2">                                                                
                                                                <label class="contenedor">
                                                                    <input type="radio" checked="" value="Diario" name="plan" onclick="plan(this.value)">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { 
                                                            if ($_SESSION['plan']=="Diario") {    ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content bordeactivo" id="plan0">
                                                                    <div class="form-group row black-bg">
                                                                        <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Diario<br><span style="font-size:36px"><?php echo "$" . number_format($result_diario['monto'], 0, ",", ".");?></span></label>

                                                                        <div class="col-sm-2">                                                                
                                                                            <label class="contenedor">
                                                                                    <input type="radio" checked="" value="Diario" name="plan" onclick="plan(this.value)">
                                                                                    <span class="checkmark"></span>                                                                                                                                            
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content bordeinactivo" id="plan0">
                                                                    <div class="form-group row black-bg">
                                                                        <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Diario<br><span style="font-size:36px"><?php echo "$" . number_format($result_diario['monto'], 0, ",", ".");?></span></label>

                                                                        <div class="col-sm-2">                                                                
                                                                            <label class="contenedor">
                                                                                    <input type="radio" value="Diario" name="plan" onclick="plan(this.value)">
                                                                                    <span class="checkmark"></span>                                                                                                                                            
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>                                  
                                    
                            
                                   
                                        <div class="col-lg-4 col-sm-12">
                                            <div  class="ibox">
                                                <?php 
                                                $query_mensual=mysqli_query($con,"select * from plan_suscripcion where plan='Mensual' ");
                                                $result_mensual=mysqli_fetch_array($query_mensual);

                                                if ($sesion==0) { ?>
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content bordeinactivo" id="plan1">
                                                        <div class="form-group row black-bg">
                                                            <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Mensual<br><span style="font-size:36px"><?php echo "$" . number_format($result_mensual['monto'], 0, ",", ".");?></span></label>

                                                            <div class="col-sm-2">                                                                
                                                                <label class="contenedor">
                                                                    <input type="radio" checked="" value="Mensual" name="plan" onclick="plan(this.value)">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { 
                                                            if ($_SESSION['plan']=="Mensual") {    ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content bordeactivo" id="plan2">
                                                                    <div class="form-group row black-bg">
                                                                        <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Mensual<br><span style="font-size:36px"><?php echo "$" . number_format($result_mensual['monto'], 0, ",", ".");?></span></label>

                                                                        <div class="col-sm-2">                                                                
                                                                            <label class="contenedor">
                                                                                    <input type="radio" checked="" value="Mensual" name="plan" onclick="plan(this.value)">
                                                                                    <span class="checkmark"></span>                                                                                                                                            
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content bordeinactivo" id="plan2">
                                                                    <div class="form-group row black-bg">
                                                                        <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Mensual<br><span style="font-size:36px"><?php echo "$" . number_format($result_mensual['monto'], 0, ",", ".");?></span></label>

                                                                        <div class="col-sm-2">                                                                
                                                                            <label class="contenedor">
                                                                                    <input type="radio" value="Mensual" name="plan" onclick="plan(this.value)">
                                                                                    <span class="checkmark"></span>                                                                                                                                            
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                   

                                        <!-- anual -->
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="ibox ">
                                                <?php 
                                                $query_anual=mysqli_query($con,"select * from plan_suscripcion where plan='Anual' ");
                                                $result_anual=mysqli_fetch_array($query_anual);
                                                if ($sesion==0) { ?>
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content bordeactivo" id="plan2">
                                                        <div class="form-group row black-bg">
                                                            <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Anual<br><span style="font-size:36px"><?php echo "$" . number_format($result_anual['monto'], 0, ",", ".");?></span></label>

                                                            <div class="col-sm-2">                                                                
                                                                <label class="contenedor">
                                                                        <input type="radio" checked="" value="Anual" name="plan" onclick="plan(this.value)">
                                                                        <span class="checkmark"></span>                                                                                                                                            
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } else { 
                                                            if ($_SESSION['plan']=="Anual") {    ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content bordeactivo" id="plan2">
                                                                    <div class="form-group row black-bg">
                                                                        <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Anual<br><span style="font-size:36px"><?php echo "$" . number_format($result_anual['monto'], 0, ",", ".");?></span></label>

                                                                        <div class="col-sm-2">                                                                
                                                                            <label class="contenedor">
                                                                                    <input type="radio" checked="" value="Anual" name="plan" onclick="plan(this.value)">
                                                                                    <span class="checkmark"></span>                                                                                                                                            
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div style="background:#262626;border-radius:10px;" class="ibox-content bordeinactivo" id="plan2">
                                                                    <div class="form-group row black-bg">
                                                                        <label style="font-weight:bold;font-size:22px;color:#fff" class="col-sm-10 col-form-label">Plan Anua<br><span style="font-size:36px"><?php echo "$" . number_format($result_anual['monto'], 0, ",", ".");?></span></label>

                                                                        <div class="col-sm-2">                                                                
                                                                            <label class="contenedor">
                                                                                    <input type="radio" value="Anual" name="plan" onclick="plan(this.value)">
                                                                                    <span class="checkmark"></span>                                                                                                                                            
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                <?php } ?>    
                                            </div>
                                        </div>    
                                        
                                        
                                    </div>
                                </div>
                                
                                <input type="hidden" id="sesion" name="sesion" value="<?php echo $sesion ?>">
                                <input type="hidden" id="plan_sel" name="plan_sel" value="<?php echo $_SESSION['plan'] ?>">
                                <input type="hidden" id="email" name="email" value="<?php echo $_SESSION['email'] ?>">
                                
                                <div  class="row">  
                                    <div style="text-align:right;padding-right:3%" class="col-lg-12">
                                        <?php if (empty($_SESSION['email'])) { ?>
                                            <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="siguiente()">Siguiente paso</button>
                                        <?php } else { ?>
                                            <button style="font-size:18px;border-radius:5px;padding:1% 5%;background: #2EB8E2;border:1px  #2EB8E2 solid" class="btn btn-lg btn-success" onclick="siguiente2()">Siguiente paso</button>
                                        <?php }  ?>
                                    </div>        
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
                        <input style="background:#000000;font-size:18px;color:#fff;" type="email" class="form-control" name="cliente" id="cliente"placeholder="Su email" autocomplete="new-password" onblur="validar_email()" onclick="btnemail()" class="form-control">
                        <span style="color: #F03737;font-weight: bold;" id="lbl_email" class="form-label" ></span>
                        <span style="color: #2EB8E2;font-weight: bold;" id="lbl_validar" class="form-label" ></span>
                        <!--<span style="color: #2EB8E2;font-weight: bold;" id="validar_email" class="form-label" ></span>-->
                    </div>
                    <div class="form-group">
                        <label style="text-align:left;color:#fff;font-size:16px;margin-top:4%">Ingrese su contrase�a</label>
                        <input style="background:#000000;font-size:18px;color:#fff;" type="password" class="form-control" name="pass" id="pass" placeholder="Su contrase�a" autocomplete="new-password" onblur="validar_pass()" onclick="btnpass()" class="form-control">
                        <span style="color: #F03737;font-weight: bold;" id="lbl_pass" class="form-label" ></span>
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
                                    title: "Contrase�a Requerida",
                                    //text: "You clicked the button!", 
                                    type: "error",
                                }); 
                            } else {

                                $.ajax({
                                    method: "POST",
                                    url: "suscripcion-login.php",
                                    data: 'cliente='+cliente+'&pass='+pass,
                                    success: function(data) {
                                        alert(data)
                                        if (data==0) {
                                            swal({
                                                title: "Email Inv�lido",                                                
                                                //text: "No registrado ", 
                                                type: "error",
                                            });                                    
                                        }
                                        if (data==1) {
                                            window.location.href='checkout.php';                                    
                                        }
                                        if (data==2) {
                                            window.location.href='suscripcion.php';                                    
                                        }
                                        if (data==3) {
                                            swal({
                                                title: "Contrase�a Inv�lida",
                                                //text: "You clicked the button!", 
                                                type: "error",
                                            });                                    
                                        }                                       
                                        if (data==5) {
                                            $('#div_confirmar').show();
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
          <div class="signup-section">�No esta Registrado? <a href="#a" class="text-info"> Registro</a>.</div>
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

        function validar_email() {
            var valor=$('#cliente').val();
            if (valor!="") {
                //var texto = document.getElementById(valor).value;
                var regex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;

                if (!regex.test(valor)) {
                    //document.getElementById("validar_email").innerHTML = "Correo invalido";
                    $("#lbl_validar").html("<span style='font-size:15px'>Correo invalido</span>");
                } else {
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

        function validar_pass() {
            var valor=$('#pass').val();
            if (valor!="") {
                document.getElementById("pass").classList.remove("bordefalta");
                document.getElementById("pass").classList.add("bordellenar");
                $("#lbl_pass").html("<span style='font-size:12px'></span>");
            } else {
                document.getElementById("pass").classList.remove("bordellenar");
                document.getElementById("pass").classList.add("bordefalta");
                $("#lbl_pass").html("<span style='font-size:12px'>* CONTRASE�A REQUERIDO</span>");
            }
        }

        function btnemail() {
            $("#lbl_email").html("<span style='font-size:15px'></span>");
            $("#lbl_validar").html("<span style='font-size:15px'></span>");
        }

        function btnpass() {            
            $("#lbl_pass").html("<span style='font-size:15px'></span>");
        }

        function siguiente() {
            var plan = $('input[name="plan"]:checked').val();
            window.location.href='registro.php?plan='+plan;
        }

        function siguiente2() {            
            window.location.href='checkout.php';
        }

        function plan(plan) {
            var sesion=$('#sesion').val();
            var plan_sel=$('#plan_sel').val();
            var email=$('#email').val();
            var plan = $('input[name="plan"]:checked').val();
           
            //alert(plan+' '+plan_sel)

            if (plan!=plan_sel) {
                $.ajax({
                    method: "POST",
                    url: "actualizar.php",
                    data: 'email='+email+'&plan='+plan,
                    success: function(data) {
                    }
                })
            }

            if (plan=="Diario") {
                document.getElementById("plan0").classList.remove("bordeinactivo");
                document.getElementById("plan0").classList.add("bordeactivo");

                document.getElementById("plan1").classList.remove("bordeactivo");
                document.getElementById("plan1").classList.add("bordeinactivo");
                document.getElementById("plan2").classList.remove("bordeactivo");
                document.getElementById("plan2").classList.add("bordeinactivo");
            } 

            if (plan=="Mensual") {
                document.getElementById("plan1").classList.remove("bordeinactivo");
                document.getElementById("plan1").classList.add("bordeactivo");

                document.getElementById("plan0").classList.remove("bordeactivo");
                document.getElementById("plan0").classList.add("bordeinactivo");
                document.getElementById("plan2").classList.remove("bordeactivo");
                document.getElementById("plan2").classList.add("bordeinactivo");
            } 
            if (plan=="Anual") {
                document.getElementById("plan2").classList.remove("bordeinactivo");
                document.getElementById("plan2").classList.add("bordeactivo");

                document.getElementById("plan0").classList.remove("bordeactivo");
                document.getElementById("plan0").classList.add("bordeinactivo");
                document.getElementById("plan1").classList.remove("bordeactivo");
                document.getElementById("plan1").classList.add("bordeinactivo");
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