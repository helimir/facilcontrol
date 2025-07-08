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

                   

                    <!--<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-reorder"></i>
                    </button>-->

                <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav mr-auto">
                            <?php if ($sesion==1) { ?>
                                <li>                                
                                    <span>&nbsp;&nbsp;<?php echo $usuario ?></span>
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

                                

                                <!--<?php if (preg_match("/mobile/i", $useragent) ) { ?>
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
                                <?php }  ?>   -->    

                                
                        

                                            <div style="border:none" class="ibox-content black-bg">  

                                                    <?php if (preg_match("/mobile/i", $useragent) ) { ?>

                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div  class="ibox">
                                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content" id="">

                                                                        <div class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">NOMBRE</label><br>
                                                                                <label style="font-size:20px;color:#fff"><?php echo $cliente ?></label>
                                                                            </div>
                                                                        </div>

                                                                        <div style="margin-top:5%" class="row">
                                                                            <div style="font-size:15px;color:#fff" class="col-lg-6 col-sm-12">
                                                                                <label style="font-size:12px;" class="form-label">PLAN</label><br>
                                                                                <label style="font-size:20px;color:#fff"><?php  echo $_SESSION['plan'].' $'. number_format($monto, 0, ",", ".");?></label>
                                                                            </div>

                                                                            <div style="margin-top:5%" class="row">
                                                                                <div style="font-size:15px;color:#fff;text-align:center" class="col-lg-12 col-sm-12">
                                                                                    <a href="logout-suscripcion.php" class="btn btn-lg btn-success">Inicio</a>
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

                                                                        <div style="margin-top:5%" class="row">
                                                                            <div style="font-size:15px;color:#fff;text-align:center" class="col-lg-12 col-sm-12">
                                                                                <a href="logout-suscripcion.php" class="btn btn-lg btn-success">Inicio</a>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php }   ?>
                                       

                                            </div>

                                            <!--<div style="margin-top:4%"  class="row">  
                                                <?php  if (preg_match("/mobile/i", $useragent) ) { ?>
                                                    <div style="text-align:center;" class="col-lg-12 col-sm-12">                                                        
                                                        <a style="font-size:18px;border-radius:5px;padding:2% 5%;color: #fff" class="btn btn-lg btn-success" href="suscripcion.php">Volver a Inicio</a>                                                                                                                                                    
                                                    </div>
                                                <?php } else {  ?>       
                                                    <div style="text-align:center;" class="col-lg-12 col-sm-12">                                                     
                                                            <a style="font-size:18px;border-radius:5px;padding:1% 5%;color: #fff" class="btn btn-lg btn-success" href="suscripcion.php" >Volver a Inicio</a>                                                                                            
                                                    </div>
                                                <?php }   ?>
                                            </div>-->
                          
                                

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
            window.location.href='checkout.php';
        }

        function aceptar_terminos() {
             var elemento=document.getElementById("terminos")
             if (elemento.checked) {
                document.getElementById("realizar_pago").disabled=false;
             } else {
                document.getElementById("realizar_pago").disabled=true;
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