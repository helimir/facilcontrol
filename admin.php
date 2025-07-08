<?php
 session_start();
include "config/config.php";

setlocale(LC_MONETARY,"es_CL");
$year=date('Y');

$query_config=mysqli_query($con,"select * from configuracion ");
$result_config=mysqli_fetch_array($query_config);


if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = "https://";
} else {
    $url = "http://";
}
#echo $url_actual = $url . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$url_actual = $url . $_SERVER['HTTP_HOST'].'/';


?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proyecto | Login</title>
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    
    <!-- Toastr style -->
    <link href="css\plugins\toastr\toastr.min.css" rel="stylesheet">
    
    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
 
<style>

    .floatm1 {   
        position:fixed;
        width:60px;
        height:60px;
        bottom:35%;
        right:0%;
        background:#25d366;
        color:#FFFFFF !important;
        border-radius:0px;
        text-align:center;
        font-size:30px;
        padding-right: ;
        padding-left: ;
        /**box-shadow: 2px 2px 3px #999;**/
        z-index:100;
    }
    .my-floatm1{
        margin-top:12px;
    }

    .float {   
        position:fixed;
        width:140px;
        height:40px;
        bottom:20%;
        right:0%;
        background:#25d366;
        color:#FFFFFF !important;
        text-align:right;
        font-size:15px;
        padding-right: 1%;
        padding-left: ;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
        /**box-shadow: 2px 2px 3px #999;**/
        z-index:100;
    }
    
    .my-float{
        margin-top:14px;
    }

    .whatsapp {
    position:fixed;
    width:60px;
    height:60px;
    bottom:45px;
    right:30px;
    background-color:#25d366;
    color:#FFF;
    border-radius:50px;
    text-align:center;
    font-size:30px;
    z-index:100;
    }

    .whatsapp-icon {
    margin-top:13px;
    }

.password-container input {
      width: 100%;
      padding: 10px 40px 10px 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    .toggle-password {
      position: absolute;
      right: 20px;
      top: 59%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #666;
    }


</style>
   
<script>

function login() {
    var valores=$('#frmLogin').serialize();
    var rut=$('#rut').val();
    var pass=$('#pass').val();
    //alert(rut);
    if (rut!=="" && pass!=="") {
        $.ajax({
            method: "POST",
            url: "login.php",
            data:valores,
            success: function(data){
                if (data==1) { // admin
                    window.location.href="list_mandantes.php";
                } 
                if (data==2) { // mandante
                    window.location.href="tareas.php";
                }
                if (data==3) { // contratista
                    window.location.href="tareas.php";
                }
                
                if (data==4) { // dual
                    $('#modal_dual #mrut').val(rut)
                    $('#modal_dual').modal('show');
                }
                
                if (data==5) { // no validada
                    swal({
                        title: "Cuenta No Validada",
                        text: "Por favor revise correo de validacion",
                        type: "warning"
                    });  
                }
                
                if (data==6) { // error de credenciales
                    swal({
                        title: "Usuario y/o Password",
                        text: "Credenciales no Validas",
                        type: "error"
                    });  
                } 
                if (data==7) { // error de credenciales
                    //window.location.href="https://facilcontrol.cl/actualizar_plan.php?rut="+rut;
                    $('.body').load('selid_modal_pagos.php?rut='+rut,function(){
                        $('#modal_pagos').modal({show:true});
                    });
                } 

                if (data==8) { // no validada
                    swal({
                        title: "Cuenta Inactiva",
                        text: "Por favor contactar via WhatsApp con Soporte Técnico ",
                        type: "warning"
                    });  
                }
                            
            }
        });
    } else {
        
        swal({
            title: "Debe ingresar RUT y Password",
            //text: "",
            type: "error"
        });  
    }    
}

// Permitir solo numeros y letra K en el imput
function isNumber(evt) {
  let charCode = evt.which;

  if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode === 75) {
    return false;
  }

  return true;
}

function checkRut(rut) {
  

  if (rut.value.length <= 1) {
      $("#help").html("<span style='color:#1AB394;font-weight:bold' >Ingrese un RUT válido</span>");
    return false
  }

  // Obtiene el valor ingresado quitando puntos y guion.
  let valor = clean(rut.value);

  // Divide el valor ingresado en digito verificador y resto del RUT.
  let bodyRut = valor.slice(0, -1);
  let dv = valor.slice(-1).toUpperCase();

  // Separa con un Guión el cuerpo del dilgito verificador.
  rut.value = format(rut.value);

  // Si no cumple con el minimo ej. (n.nnn.nnn)
  if (bodyRut.length < 7) {
    $("#help").html("<span style='color:#1AB394;font-weight:bold' >Rut de ser mayor de 7 dpigitos</span>");
    return false
  }

  // Calcular Dígito Verificador "Método del Módulo 11"
  suma = 0;
  multiplo = 2;

  // Para cada dígito del Cuerpo
  for (i = 1; i <= bodyRut.length; i++) {
    // Obtener su Producto con el Múltiplo Correspondiente
    index = multiplo * valor.charAt(bodyRut.length - i);

    // Sumar al Contador General
    suma = suma + index;

    // Consolidar Múltiplo dentro del rango [2,7]
    if (multiplo < 7) {
      multiplo = multiplo + 1;
    } else {
      multiplo = 2;
    }
  }

  // Calcular Dígito Verificador en base al Módulo 11
  dvEsperado = 11 - (suma % 11);

  // Casos Especiales (0 y K)
  dv = dv == "K" ? 10 : dv;
  dv = dv == 0 ? 11 : dv;

  // Validar que el Cuerpo coincide con su Dígito Verificador
  if (dvEsperado != dv) {    
    $("#help").html("<span style='color:#ED5565;font-weight:bold' >Rut Inválido</span>");
    return false
  } else {
    $("#help").html("<span style='color:#1C84C6;font-weight:bold' >Rut válido</span>");
    return false
  }
}

function format (rut) {
  rut = clean(rut)

  var result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1)
  for (var i = 4; i < rut.length; i += 3) {
    result = rut.slice(-3 - i, -i) + '.' + result
  }

  return result;
}

function clean (rut) {
  return typeof rut === 'string'
    ? rut.replace(/^0+|[^0-9kK]+/g, '').toUpperCase()
    : ''
}

function togglePassword() {
            const passwordInput = document.getElementById('pass');
            const toggleIcon = document.querySelector('.toggle-password i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

                           

</script>       

</head>


<?php $useragent = $_SERVER['HTTP_USER_AGENT'] ?? '';
    if (preg_match("/mobile/i", $useragent) ) { ?>
         <a title="Soporte Tecnico FacilControl" href="https://api.whatsapp.com/send?phone=56936450940&text=Hola, soporte ayuda sobre," class="whatsapp" target="_blank"><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
       <!--<a href="https://clubi.cl/tienda/" class="floatm2" target="_blank"><span style="font-size: 15px;color: #fff !important;"><i class="fa fa-shopping-bag my-floatm2"></i></span></a>
        <a href="https://www.instagram.com/clubipets/" class="floatm3" target="_blank"><span style="font-size: 15px;color: #fff !important;"><i class="fa fa-instagram my-floatm3"></i></span></a>-->
        
	<?php } else {  ?>       
       <a title="Soporte Tecnico FacilControl" href="https://web.whatsapp.com/send?phone=56936450940&text=Hola, necesito soporte sobre," class="whatsapp" target="_blank" title="Consulte cualquier duda via whatsapp"><span  style=""><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
         <!--<a title="Escribanos para cualquier consulta" href="https://web.whatsapp.com/send?phone=56997835878&text=Hola, para m�s informaci�n sobre," class="whatsapp" target="_blank" title="Consulte cualquier duda via whatsapp"><span  style=""><i style="color: #FFFFFF;" class="fa fa-whatsapp whatsapp-icon"></i></span></a>
        <a href="https://clubi.cl/tienda/" class="float2" target="_blank"><span style="" title="Compre directo sin registro">Tienda Clubi <i class="fa fa-shopping-bag my-float2"></i></span></a>
        <a href="https://www.instagram.com/clubipets/" class="float3" target="_blank"><span style="" title="Siguenos es nuestra cuenta">Instagram <i class="fa fa-instagram my-float3"></i></span></a>-->
<?php }   ?>

<body style="background: #010829;" class="gray-bg">

    <div  class="middle-box text-center loginscreen animated fadeInDown">
        <div style="background: #fff;padding: 2% 2%;border-radius: 4px;">
            <div>
                <h1 style="color: #010829;" class="logo-name"><img style="height:90%;width:90%" src="assets/img/logo_2.png"></i></h1>
            </div>
            <h3 style="color: #282828;">Inicio de Sesi&oacute;n</h3>
            <form class="m-t" role="form" method="post" id="frmLogin" action="login.php">
                <div class="form-group">
                    <input type="text" name="rut" id="rut" class="form-control" placeholder="RUT" maxlength="12" oninput="checkRut(this)"  required="" autocomplete="off" />
                    <span id="help"></span>
                </div>
                <div class="form-group password-container">
                    <input type="password" name="pass" id="pass" class="form-control" placeholder="Password" required="" autocomplete="off" />
                    <span class="toggle-password" aria-label="Mostrar contraseña" onclick="togglePassword()">
                        <i style="font-size:16px" class="fa fa-eye"></i>
                    </span>
                </div>
                <button style="font-weight:700;font-size:14px" type="button" name="ingresar" id="ingresar" class="btn btn-success block full-width m-b" onclick="login()">INGRESO</button>
                
                
            </form>
            <button style="font-weight:700;font-size:14px" type="button" class="btn btn-primary block full-width m-b" onclick="modal_codigo_t()">VERIFICAR TRABAJADOR</button>
            <button style="font-weight:700;font-size:14px" type="button" class="btn btn-primary block full-width m-b" onclick="modal_codigo_v()">VERIFICAR VEHICULO/MAQUINARIA</button>

                <a href="#"><small>Olvide Contrase&ntilde;a</small></a>
            <p style="color: #282828;" class="m-t"> <small>Proyecto &copy; <?PHP echo $year ?></small> </p>
            <input type="hidden" name="url" id="url" value="<?php echo $result_config['url'] ?>">
        </div>
    </div>

        <div class="modal fade" id="modal_codigo_t" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="color: #000;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Verificar Credencial Trabajador</h3>
                        <button style="color: #FF0000;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
                    </div>
                    <form method="post" id="frmCargos">     
                    <div class="modal-body">
                          
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                  <input style="text-align: center;font-size: 20px;font-weight: bold" class="form-control block" style="font-size: 16px;" type="text" name="codigo_t" id="codigo_t" placeholder="ingresar codigo" autocomplete="off" onkeyup="this.value = mascara(this.value)" maxlength="7"  />
                                </div>                    
                            </div>
                        
                    </div>
                    
                  
                   <script>
                     function modal_verificar_t(tipo) {
                       var codigo_t=$('#codigo_t').val();
                       //alert(tipo+' '+codigo_t)
                        $.ajax({
                			method: "POST",
                            url: "add/verificar_codigo.php",
                			data:'codigo='+codigo_t+'&tipo='+tipo,
                			success: function(data){
                			     if (data!=1) {
                			       // alert(data);
                                   $('#modal_codigo_t').modal('hide');
                                      
                                  $('.body').load('selid_info_trabajadores.php?codigo='+data,function(){
                                        $('#modal_info').modal({show:true});
                                    });
                                  //$('#modal_info').modal('show');
                                   
                                 } else {
                                    swal({
                                      title: "Codigo No Existe",
                                      type: "error"
                                   });
                                    
                                 }                
                			}
                       });  
                     }
                    </script> 
                    
                    
                    <input type="hidden" name="asignar" value="edit_contrato" />   
                    <div class="modal-footer">
                        <!--<a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>-->
                        <button style="color: #fff;" class="btn btn-secondary" type="reset" >BORRAR</button>
                        <button style="color: #fff;" class="btn btn-success" type="button" name="verificar" onclick="modal_verificar_t(1)">VERIFICAR</button>
                    </div>
                    </form> 
                   
                    
                </div>
            </div>
        </div>


        <div class="modal fade" id="modal_codigo_v" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="color: #000;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Verificar Credencial Vehículo</h3>
                        <button style="color: #FF0000;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
                    </div>
                    <form method="post" id="frmCargos">     
                    <div class="modal-body">
                          
                            <div class="row">
                               <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                  <input style="text-align: center;font-size: 20px;font-weight: bold" class="form-control block" style="font-size: 16px;" type="text" name="codigo_v" id="codigo_v" placeholder="ingresar codigo" autocomplete="off" onkeyup="this.value = mascara(this.value)" maxlength="7"  />
                                </div>                    
                            </div>
                        
                    </div>
                    
                  
                   <script>
                     function modal_verificar_v(tipo) {
                       var codigo_veri_v=$('#codigo_v').val();
                       //alert(tipo+' '+codigo_veri_v)
                        $.ajax({
                			method: "POST",
                            url: "add/verificar_codigo.php",
                			data:'codigo='+codigo_veri_v+'&tipo='+tipo,
                			success: function(data){
                			     if (data!=1) {
                			       // alert(data);
                                   $('#modal_codigo_v').modal('hide');
                                      
                                  $('.body').load('sel/selid_verificar_vehiculo.php?codigo='+data,function(){
                                        $('#modal_info_v').modal({show:true});
                                    });
                                  //$('#modal_info').modal('show');
                                   
                                 } else {
                                    swal({
                                      title: "Codigo No Existe",
                                      type: "error"
                                   });
                                    
                                 }                
                			}
                       });  
                     }
                    </script> 
                    
                    
                    <input type="hidden" name="asignar" value="edit_contrato" />   
                    <div class="modal-footer">
                        <!--<a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>-->
                        <button style="color: #fff;" class="btn btn-secondary" type="reset" >BORRAR</button>
                        <button style="color: #fff;" class="btn btn-success" type="button" name="verificar" onclick="modal_verificar_v(2)">VERIFICAR</button>
                    </div>
                    </form> 
                   
                    
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modal_pagos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="background: #05D3BF; color: #282828;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Actualizaci&oacute;n de Plan</h3>
                        <button style="color: #282828;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
                    </div>
                    <div class="body">
                    
                    </div>
                </div>
            </div>
        </div>             

        <div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="background: ;color: #000;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Informaci&oacute;n del Trabajador</h3>
                        <button style="color: #FF0000;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
                    </div>
                    <div class="body">
                    
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_info_v" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div style="background: ;color: #000;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Informaci&oacute;n del Vehículos/Maquinaria</h3>
                        <button style="color: #FF0000;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
                    </div>
                    <div class="body">
                    
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modal_dual" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 20%;">
                <div class="modal-content" >
                    <!--<div style="background: ;color: #000;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Seleccionar Funci&oacute;n </h3>
                        <button style="color: #FF0000;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">x</span></button>
                    </div>-->
                    <div class="modal-body">
                        <input type="hidden" name="mrut" id="mrut" >
                        <script>
                        function dual(valor) {
                           var url=$('#url').val();
                           //alert(url);
                           var rut=$('#mrut').val();
                           $.ajax({
                                method: "POST",
                                url: "cambiar_dual.php",
                                data:'valor='+valor+'&rut='+rut,
                                success: function(data){
                                    window.location.href="https://"+url+"/tareas.php";
                                }
                            });
                        }
                       </script>
                        <div style="text-align:center;color:#292929;" class="row">
                            <h4 class="form-control"><strong>INGRESAR COMO</strong></h4>
                        </div>
                        <div class="row">
                            <button type="button" style="font-size: 20px;" class="btn btn-success btn-md btn-block" onclick="dual(1)">CONTRATISTA</button>
                        </div>
                        <br />
                        <div class="row">
                            <button type="button" style="font-size: 20px;" class="btn btn-success btn-md btn-block" onclick="dual(2)">MANDANTE</button>
                        </div>    
                    </div>
                      <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-secondary btn-sm" data-dismiss="modal" >Cerrar</a>
                    </div>
                </div>
            </div>
        </div>


        
        
  

</body>


   <!-- Mainly scripts -->
   <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>

    
    <!-- Sweet alert -->
   <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
   
    <!-- Peity -->
    <script src="js\plugins\peity\jquery.peity.min.js"></script>

    <!-- Peity demo data -->
    <script src="js\demo\peity-demo.js"></script>
    
    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
    
    <script>
    
        function modal_codigo_t() {      
            $('#modal_codigo_t').modal({show:true})
        } 

        function modal_codigo_v() {      
            $('#modal_codigo_v').modal({show:true})
        } 
         
     
        function mascara(valor) {
              if (valor.match(/^\d{3}$/) !== null) {
                return valor + '-';
              } else if (valor.match(/^\d{2}\-\d{2}$/) !== null) {
                return valor + '-';
              }
              return cadena;
            }
    </script>
    
    
    <?php 
    
        #if (isset(['estado'])==0 and !empty($token) ) { 
        #if (isset(['estado'])==0  ) {?>
        <script>
            //$(document).ready(function () {                
                //swal({
                  //      title: "Usuario Validado",
                        //text: "You clicked the button!",
                  //      type: "success"
                  //  });            
            //});
            
          
         //function modal_codigo() {
          //alert('hola')
         //}                    
      
            
        </script>            
    <?php #} ?> 

</html>