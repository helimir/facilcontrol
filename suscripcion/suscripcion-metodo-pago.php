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
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

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
        background-color: #044f9a;
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
            border-color: #044f9a;
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
    max-width: 1200px;
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
    color: #044f9a;
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
    background-color: #044f9a;
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
    background-color: #044f9a;
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
       
        <div class="wrapper wrapper-content">

            <div style="margin-top:20%" class="container">
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
                                                    <div class="step-label-c">REGISTRO</div>
                                                </div>
                                                <div class="step completed">
                                                    <div class="step-circle">3</div>
                                                    <div class="step-label-completeds">MÉTODO PAGO</div>
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
                                            <h1 style="font-weight:bold;color:#fff;text-align:center;font-size:36px">Seleccione Método de Pago</h1>  
                                            <h1  style="color:#fff;text-align:center;font-size:20px">¿Ya esta Registrado? <a style="text-decoration:underline" href="#">Inicie Sesi�n</a></h1>
                                        </div>
                                    </div>
                                </div> 

                                <form  method="post"  enctype="multipart/form-data" id="frmregistro">
                                        <div class="form-group row">
                                            <div style="font-size:20px;color:#fff" class="col-6">
                                                <label class="col-form-label">NOMBRE</label>
                                                <input style="background-color:#262626;border:1px #fff solid;font-size:24px;color:#fff" placeholder="escriba su nombre" type="text" name="nombre" id="nombre" class="form-control">
                                            </div>
                                            <div style="font-size:20px;color:#fff" class="col-6">
                                                <label class="col-form-label">APELLIDO</label>
                                                <input style="background-color:#262626;border:1px #fff solid;font-size:24px;color:#fff" placeholder="escriba su apellido" type="text" name="apellido" id="apellido" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div style="font-size:20px;color:#fff" class="col-6">
                                                <label class="col-form-label">EMAIL</label>
                                                <input style="background-color:#262626;border:1px #fff solid;font-size:24px;color:#fff" placeholder="escriba su correo electr�nico" type="email" name="email" id="email" class="form-control">
                                            </div>
                                            <div style="font-size:20px;color:#fff" class="col-6">
                                                <label class="col-form-label">NICKNAME</label>
                                                <input style="background-color:#262626;border:1px #fff solid;font-size:24px;color:#fff" placeholder="escriba su usuario" type="text" name="nick" id="nick" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div style="font-size:20px;color:#fff" class="col-6">
                                                <label class="col-form-label">CONTRASE�A</label>
                                                <input style="background-color:#262626;border:1px #fff solid;font-size:24px;color:#fff" placeholder="escriba su contrase�a" type="password" name="pass1" id="pass1" class="form-control">
                                            </div>
                                            <div style="font-size:20px;color:#fff" class="col-6">
                                                <label class="col-form-label">CONFIRMAR CONTRASE�A</label>
                                                <input style="background-color:#262626;border:1px #fff solid;font-size:24px;color:#fff" placeholder="confirme su contrase�a" type="password" name="pass2" id="pass2" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div style="font-size:18px;color:#fff" class="col-6">
                                                <label class="col-form-label">Todos los campos son obligatorios.</label>                                        
                                            </div>
                                        </div>

                                    <div style="margin-top:4%"  class="row">  
                                            <div style="text-align:left;" class="col-lg-6">
                                                <button style="font-size:18px;border-radius:5px;padding:3% 5%" class="btn btn-lg btn-success" onclick="anterior()">Volver atr�s</button>                                    
                                            </div>
                                            <div style="text-align:right;padding-right:2%" class="col-lg-6">                                        
                                                <button style="font-size:18px;border-radius:5px;padding:3% 5%" class="btn btn-lg btn-success" onclick="registro()">Siguiente paso</button>
                                            </div>        
                                        </div>

                                </form>

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


                        <div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando registro, por favor espere un momento</h3>
                              </div>
                            </div>
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

    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

    <script>

        function siguiente() {
            //window.location.href='suscripcion-registro.php'
        }

        function anterior() {
            window.location.href='suscripcion.php'
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


            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            

        });

        function registro() {
            var nombre=$('#nombre').val();
            var apellido=$('#apellido').val();
            var nick=$('#nick').val();
            var email=$('#email').val();
            var pass1=$('#pass1').val();
            var pass2=$('#pass2').val();
            if (nombre=="") {
                swal({
                    title: "Nombre no puede estar vacio",
                    //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                });
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
                        if (nick=="") {
                            swal({
                                title: "Nickname no puede estar vacio",
                                //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                            });
                        } else {
                            if (pass1=="") {
                                swal({
                                    title: "Contrase�a no puede estar vacio",
                                    //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                                });
                            } else {
                                if (pass1!=pass2) {
                                    swal({
                                        title: "Contrase�as deben ser iguales",
                                        //text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                                    });
                                } else {

                                            var valores=$('#frmregistro').serialize();
                                              $.ajax({
                                        			method: "POST",
                                                    url: "registro.php",
                                                    data: valores,
                                                     beforeSend: function(){
                                                        $('#modal_cargar').modal('show');						
                                        			},
                                        			success: function(data){			  
                                                     if (data==0) { 
                                                         $('#modal_cargar').modal('hide');   
                                                         swal({
                                                                title: "Registro Creado",
                                                                //text: "You clicked the button!", 
                                                                type: "success"
                                                         });
                                                         setTimeout(window.location.href='suscripcion-metodo-pago.php', 3000);
                                        			  } else {
                                        			     $('#modal_cargar').modal('hide'); 
                                        			     if (data==1) { 
                                                            swal("Registro No Creado", "Vuelva a Intentar.", "error");
                                                         }
                                                         if (data==2) { 
                                                            swal({
                                                                title: "Email Existe",
                                                                //text: "You clicked the button!",
                                                                type: "error"
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

        


    </script>

</body>

</html>
