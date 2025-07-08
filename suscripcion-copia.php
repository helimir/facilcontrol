<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Suscipcion</title>

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">

    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">

    <style>

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
        background-color: #2196F3;
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
            border-color: #2196F3;
            border-width: 4px;
        }
        .bordeinactivo {
            border-style: solid;
            border-color: #fff;
            border-width: 4px;
        }


body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #f4f4f9;
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
    color: #2196F3;
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
    background-color: #2196F3;
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
    background-color: #2196F3;
}

    </style>

</head>

<body class="top-navigation">

    <div id="wrapper">
        <div style="background:#000" id="page-wrapper" class="black-bg">
       
        <div class="wrapper wrapper-content">
        
        <?php $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match("/mobile/i", $useragent) ) { ?>
            <div style="margin-top:20%" class="container">            
        <?php } else {  ?>       
            <div style="margin-top:0%" class="container">
        <?php }   ?>


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
                                            <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Seleccion un Plan de Suscripción</h1>  
                                        </div>
                                    </div>
                                </div>                                
                            </div>



                        <form id="plan">
                            <div style="border:none" class="ibox-content black-bg">                                                                
                                    <div  class="row">
                                        
                                            <div class="col-lg-6">
                                                <div  class="ibox">
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content bordeinactivo" id="plan1">
                                                            <div class="form-group row black-bg">
                                                                <label style="font-weight:bold;font-size:22px;color:#fff" class="col-lg-10 col-sm-11 col-form-label">Plan Mensual<br><span style="font-size:36px">$10.999</span></label>

                                                                <div class="col-lg-2 col-sm-1">                                                                
                                                                    <label class="contenedor">
                                                                        <input type="radio" checked="" value="mensual" name="plan" id="mensual" onclick="seleccion(this.value)">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- anual -->
                                            <div class="col-lg-6">
                                                <div class="ibox ">
                                                    <div style="background:#262626;border-radius:10px;" class="ibox-content bordeactivo" id="plan2">
                                                            <div class="form-group row black-bg">
                                                                <label style="font-weight:bold;font-size:22px;color:#fff" class="col-lg-10 col-sm-11 col-form-label">Plan Anual <small>(ahorre 25%)</small><br><span style="font-size:36px">$100.000</span></label>

                                                                <div class="col-lg-2 col-sm-1">                                                                
                                                                    <label class="contenedor">
                                                                        <input type="radio" checked="" value="anual" name="plan" id="anual" onclick="seleccion(this.value)">
                                                                        <span class="checkmark"></span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>                                         
                                    </div>
                                </div>

                            </form>

                                <div  class="row">  
                                    <div style="text-align:right;padding-right:3%" class="col-lg-12">
                                        <button style="font-size:18px;border-radius:5px;padding:1% 5%" class="btn btn-lg btn-success" onclick="siguiente()">Siguiente paso</button>
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



    <!-- Mainly scripts -->
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>

    <script>

        function siguiente() {
            var plan = $('input[name="plan"]:checked').val();
            window.location.href='suscripcion-registro.php?plan='+plan;
        }

        function seleccion(plan) {
            alert(plan)
            
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


            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            
                

        });
    </script>

</body>

</html>
