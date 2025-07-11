<?php
include "config/config.php"; 
date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$token=$_GET['token'];


$sql_token=mysqli_query($con,"select u.estado as estado_user, u.*, t.* from tokens as t left join users as u On u.id_user=t.id_user where t.token='$token' ");
$result_token=mysqli_fetch_array($sql_token);   

if ($result_token['estado_user']==0) {

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Facil Control</title>

     <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet"> 
    <link href="assets/img/favicon.png" rel="icon">   

     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />

    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>

function inicio() {
      window.location.href='index.php';  
}

function comparar() {
    var pass1=$('#pass1').val();
    var pass2=$('#pass2').val();
    var token=$('#token').val();
    var nombre=$('#nombre').val();
    var email=$('#email').val();
    var rut=$('#rut').val();
    var id_user=$('#id_user').val();
    var aceptar = $("#aceptar").is(":checked");
    //alert(pass1+'-'+pass2+'-'+token+'-'+rut+'-'+id_user);
    if (aceptar) {
         if (pass1!="" && pass2!="") {
            if (pass1!=pass2) {
                Swal.fire({
                    title: "Contraseñas deben ser iguales",
                    icon: "warning",
                    draggable: true
                });
            } else {
                $.ajax({
                    method: 'POST',
                    url: 'add/validar_user.php',
                    data:'pass1='+pass1+'&token='+token+'&id_user='+id_user+'&nombre='+nombre+'&email='+email+'&rut='+rut,
                    beforeSend: function(){
                        $('#modal_cargar').modal('show');						
         			},
                    success: function(data){
                        if (data==0){  
                            $('#modal_cargar').modal('hide');
                            Swal.fire({
                                title: "Cuenta Validada",
                                icon: "success",
                                draggable: true
                            });
                            window.location.href='admin.php';
                        } else {                            
                            $('#modal_cargar').modal('hide');
                            Swal.fire({
                                title: "Clave No se Acualizo",
                                icon: "error",
                                draggable: true
                            });
                             window.location.href='validation.php?token='+token;  
                        }
                    },
                    complete:function(data){
                        $('#modal_cargar').modal('hide');
                    }, 
                    error: function(data){
                        
                    }
                })
            }
            
         } else {
                Swal.fire({
                    title: "Alguna clave esta vacia",
                    icon: "warning",
                    draggable: true
                });
         }   
     } else {
        Swal.fire({
            title: "Aceptar Terminos y Condiciones",
            icon: "warning",
            draggable: true
        });        
     }   
    
    
}

</script>

<style>

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

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

</style>

</head>

<body style="background: #010829" >

    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content text-center">                
                    
                    <div>
                    <h1 style="color: #010829;" class="logo-name"><img style="height:90%;width:90%" src="assets/img/logo_2.png"></i></h1>
                    </div>
                    <h2 style="" class="font-bold text-center">Validar Usuario <?  ?></h2>                    
                    
                   
                    <div class="row">
                        <div class="col-lg-12">                       
                            
                                <div class="form-group">
                                    <input style="text-transform:lowercase;" id="rut" name="rut" class="form-control"  value="<?php echo $result_token['usuario'] ?>" readonly="" />
                                    
                                </div>  
                               <div class="form-group">
                                    <input type="password" id="pass1" name="pass1" class="form-control" placeholder="Ingresar Contrase&ntilde;a" required="" />
                                   
                                </div>
                               <div class="form-group">
                                    <input type="password" id="pass2" name="pass2" class="form-control" placeholder="Repetir Contrase&ntilde;a" required="" />
                                    
                                </div>
                                
                                <input type="hidden" id="nombre" name="nombre" value="<?php echo $result_token['nombre_user'] ?>" />                                                                                                
                                <input type="hidden" id="token" name="token" value="<?php echo $token ?>" />
                                <input type="hidden" id="id_user" name="id_user" value="<?php echo $result_token['id_user'] ?>" />
                                <input type="hidden" id="email" name="email" value="<?php echo $result_token['email_user'] ?>" />
                                                                
                                                        
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <input class="" type="checkbox" id="aceptar" name="aceptar" value="1" />
                            <a title="Leer Terminos y Condiciones" href="doc/Terminos_y_condiciones_Clubi_Spa.pdf" target="_blank" >Aceptar T&eacute;rminos y Condiciones</a>  
                        </div>
                    </div>
                    <br />
                     <div class="row">
                        <div class="col-lg-12">
                            <button style="padding:;font-size: 16px;" type="buttom" class="btn btn-success block full-width m-b" onclick="comparar()">Enviar</button>
                            <button style="padding:;font-size: 16px;" type="buttom" class="btn btn-dark block full-width m-b" onclick="inicio()">Inicio</button>  
                        </div>
                    </div>
                    
                        
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-12">
                <p style="text-align: center;" class="m-t">FacilControl <?php echo $year ?></p>
            </div>
        </div>
    </div>
    
                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando cuenta, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>
    
    
    <!-- Mainly scripts -->
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

</body>

</html>

<?php 
     
 } else {
    echo '<script>window.location.href="index.php"</script>';
 }
?>
