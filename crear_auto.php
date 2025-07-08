<?php
session_start();
if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==3)  ) { 
include('config/config.php');
//$regiones= consulta_general('regiones');
$doc=mysqli_query($con,"Select * from doc_autos ");
$result_doc=mysqli_fetch_array($doc);

$contratista=$_SESSION['contratista'];

$query_user=mysqli_query($con,"select * from users where usuario='".$_SESSION['usuario']."' ");
$result_user=mysqli_fetch_array($query_user);


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Crear Auto</title> 

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>



<script src="js\jquery-3.1.1.min.js"></script>
<script>

$(document).ready(function () {
    
                $('#menu-vehiculos').attr('class','active');

                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
                
                  // Bind normal buttons
                Ladda.bind( '.ladda-button',{ timeout: 2000 });
        
                // Bind progress buttons and simulate loading progress
                Ladda.bind( '.progress-demo .ladda-button',{
                    callback: function( instance ){
                        var progress = 0;
                        var interval = setInterval( function(){
                            progress = Math.min( progress + Math.random() * 0.1, 1 );
                            instance.setProgress( progress );
        
                            if( progress === 1 ){
                                instance.stop();
                                clearInterval( interval );
                            }
                        }, 200 );
                    }
                });
        
        
                var l = $( '.ladda-button-demo' ).ladda();
        
                l.click(function(){
                    // Start loading
                    l.ladda( 'start' );
        
                    // Timeout example
                    // Do something in backend and then stop ladda
                    setTimeout(function(){
                        l.ladda('stop');
                    },12000)
        
        
                });
                
                
                
                $('.demo1').click(function(){
                    swal({
                        title: "Welcome in Alerts",
                        text: "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                    });
                    
                });
        
                $('.demo2').click(function(){
                    swal({
                        title: "Plato Agregado",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                });
        
                $('.demo3').click(function () {
                    swal({
                        title: "Are you sure?",
                        text: "You will not be able to recover this imaginary file!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: false
                    }, function () {
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    });
                });
        
                $('.demo4').click(function () {
                            swal({
                                title: "Are you sure?",
                                text: "Your will not be able to recover this imaginary file!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Yes, delete it!",
                                cancelButtonText: "No, cancel plx!",
                                closeOnConfirm: false,
                                closeOnCancel: false },
                            function (isConfirm) {
                                if (isConfirm) {
                                    swal("Deleted!", "Your imaginary file has been deleted.", "success");
                                } else {
                                    swal("Cancelled", "Your imaginary file is safe :)", "error");
                                }
                            });
                }); 
                
                
            });

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
      $("#help").html("<span style='color:#1AB394;' >Ingrese un RUT v&aacute;lido</span>");
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
    $("#help").html("<span style='color:#1AB394;font-weight:bold' >Rut de ser mayor de 7 d�gitos</span>");
    return validacion=false;
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
    $("#help").html("<span style='color:#ED5565;font-weight:bold' >Rut Inv&aacute;lido</span>");
    return validacion=false;
  } else {
    $("#help").html("<span style='color:#1C84C6;font-weight:bold' >Rut V&aacute;lido</span>");
    return validacion=true;
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
    

    $(document).ready(function(){
				
               
    });  
  
    

  function validar(caso) {
    
   switch (caso) { 
        case 1:  var item=$('#tipo_auto').val();
                 if (item=='') {
                      $("#lbl_razon_social").html("<span><small><b>* TIPO AUTO REQUERIDO</b></small></span>");
                 }
                break;  
        case 2:  var item=$('#patente').val();
                 if (item=='') {
                      $("#lbl_giro_social").html("<span><small><b>* PATENTE REQUERIDO</b></small></span>");
                 }
                break; 
        case 3:  var item=$('#descripcion').val();
                 if (item=='') {
                      $("#lbl_descripcion").html("<span><small><b>* DESCRIPCION DE GIRO REQUERIDO</b></small></span>");
                 }
                break;
       case 4:  var item=$('#nombre_fantasia').val();
                 if (item=='') {
                      $("#lbl_nombre_fantasia").html("<span><small><b>* NOMBRE DE FANTASIA REQUERIDO</small></span>");
                 }
                break;  
       case 5:  var item=$('#direccion_empresa').val();
                 if (item=='') {
                      $("#lbl_direccion_empresa").html("<span><small><b>* DIRECCION EMPRESA REQUERIDO</b></small></span>");
                 }
                break;
       case 6:  var item=$('#region_com').val();
                 if (item==0) {
                      $("#lbl_region_com").html("<span><small><b>* REGION COMERCIAL REQUERIDO</b></small></span>");
                 }
                break;
      case 7:  var item=$('#comuna_com').val();
                 if (item==0) {
                      $("#lbl_comuna_com").html("<span><small><b>* COMUNA COMERCIAL REQUERIDO</b></small></span>");
                 }
                break; 
       case 8:  var item=$('#administrador').val();
                 if (item=='') {
                      $("#lbl_administrador").html("<span><small><b>* RESPONSABLE DEL FACILCONTROL REQUERIDO</b></small></span>");
                 }
                break; 
       case 9:  var item=$('#fono').val();
                 if (item=='') {
                      $("#lbl_fono").html("<span><small><b>* FONO DEL RESPONSABLE FACILCONTROL REQUERIDO</small></span>");
                 }
                break;
       case 10:  var item=$('#email').val();
                 if (item=='') {
                      $("#lbl_email").html("<span><small><b>* EMAIL DEL RESPONSABLE FACILCONTROL REQUERIDO</b></small></span>");
                 }
                break; 
       case 11:  var item=$('#email2').val();
                 if (item=='') {
                      $("#lbl_email2").html("<span><small><b>* CONFIRMAR EMAIL REQUERIDO</b></small></span>");
                 }
                break;
       case 12:  var item=$('#representante').val();
                 if (item=='') {
                      $("#lbl_representante").html("<span><small><b>* REPRESENTANTE LEGAL REQUERIDO</b></small></span>");
                 }
                break;
        case 13:  var item=$('#direccion_rep').val();
                 if (item=='') {
                      $("#lbl_direccion_rep").html("<span><small><b>* DIRECCION REPRESENTANTE LEGAL REQUERIDO</b></small></span>");
                 }
                break;
        case 14:  var item=$('#region_rep').val();
                 if (item==0) {
                      $("#lbl_region_rep").html("<span><small><b>* REGION REQUERIDO</b></small></span>");
                 }
                break; 
        case 15:  var item=$('#comuna_rep').val();
                 if (item==0) {
                      $("#lbl_comuna_rep").html("<span><small><b>* COMUNA REQUERIDO</b></small></span>");
                 }
                break;
        case 16:  var item=$('#estado_civil').val();
                 if (item=='') {
                      $("#lbl_estado_civil").html("<span><small><b>* ESTADO CIVIL REQUERIDO</b></small></span>");
                 }
                break;                                                                                                                                           
            
   }     
  }    

  function revision_tecnica33() {
    var fecha = new Date($('#revision').val());
    var dias=5;
    fecha.setDate(fecha.getDate() + dias);
    alert(fecha)
  }
      
</script>

<style>

        input[type=checkbox]
        {
          /*  #F8AC59 Doble-tama�o Checkboxes */
          -ms-transform: scale(2.5); /* IE */
          -moz-transform: scale(2.5); /* FF */
          -webkit-transform: scale(2.5); /* Safari y Chrome */
          -o-transform: scale(2.5); /* Opera */
          padding: 0px;
        }
        
        /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificaci�n */
        .checkboxtexto
        {
          /* Checkbox texto */
          font-size: 100%;
          display: inline;
        }

        .tags {
          display: inline;
          position: relative;
        }
        
        .tags:hover:after {
          background: #333;
          /*background: rgba(54, 165, 170, .9);*/
          background: rgba(248, 172, 89, .9);
          border-radius: 5px;
          bottom: -34px;
          color: #000;
          content: attr(gloss);
          left: 20%;
          padding: 5px 15px;
          position: absolute;
          z-index: 98;
          width: 350px;
        }
        
        .tags:hover:before {
          border: solid;
          border-color: #333 transparent;
          border-width: 0 6px 6px 6px;
          bottom: -4px;
          content: "";
          left: 50%;
          position: absolute;
          z-index: 99;
        }
        
        
        .tags2 {
          display: inline;
          position: relative;
        }
        
        .tags2:hover:after {
          background: #333;
          background: #F8AC59;
          opacity: 0.9;
          border-radius: 5px;
          bottom: -44px;
          color: #000;
          content: attr(gloss);
          left: 20%;
          padding: 5px 15px;
          position: absolute;
          z-index: 98;
          width: 150px;
        }
        
        .tags2:hover:before {
          border: solid;
          border-color: #333 transparent;
          border-width: 0 6px 6px 6px;
          bottom: -4px;
          content: "";
          left: 50%;
          position: absolute;
          z-index: 99;
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

.bordes {
    border:1px solid #c0c0c0;
}

.fondo {
        background:#e9eafb;
        color:#292929;
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

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Crear Vehículo/Maquinaria <?php ?></h2>
                </div>
            </div> 
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                              <div class="ibox-title"> 
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_contratos_contratistas.php"  type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Reporte Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_vehiculos.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Vehiculos/Maquinarias</a>
                                    </div> 
                                    <?php include('resumen.php') ?>
                              </div>    
                        <div class="ibox-content">
                            <form  method="post" id="frmVehiculos">   
                                
                                 <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>SIGLAS</b></label> 
                                    <div class="col-10">                                       
                                        <label style="font-weight:bold;font-size:18px;border:1px #eee solid" id="siglas" class="col-4 col-form-label"> </label>
                                        <input type="hidden" id="h_siglas" name="h_siglas" >
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>                  
                                    </div>
                                </div>
                                <br><br>
                                 <!--- tipo-->
                                <div class="row">
                                    <label class="col-2 col-form-label fondo"><b>Tipo</b></label>                                    
                                    <div class="col-lg-3 col-sm-12">
                                        <select id="tipo_auto" name="tipo_auto" class="form-control bordes" onchange="on_tipo(<?php echo $contratista ?>)" >
                                            <option value="seleccionar">Seleccionar</option>
                                            <?php 
                                                $query_tipos_autos=mysqli_query($con,"select * from tipo_autos where estado='0' ");
                                                foreach ($query_tipos_autos as $row) {  ?>
                                                    <option value="<?php echo $row['auto'] ?>"><?php echo $row['auto'] ?></option>
                                                <?php } ?>
                                        </select>    
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_tipo" class="form-label" ></span>
                                    </div>
                                    <div class="col-6">
                                            <!--<label style="font-size:18px;" class="col-2 col-form-label fondo"><b>SIGLA</b></label> 
                                            <label style="font-weight:bold;font-size:18px;background:#eee" id="siglas" class="col-4 col-form-label"> </label>
                                            <input type="hidden" id="h_siglas" name="h_siglas" >
                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>-->
                                    </div>   
                                    
                                </div>
                                
                                 <!--- patente -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Patente</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                            <input style="text-transform: uppercase;" maxlength="8"  name="patente" id="patente" type="text" class="form-control bordes" onBlur="on_patente(<?php echo $contratista ?>)"   />
                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>
                                    </div>
                                    <div class="col-2">                                                
                                            <input style="margin-top:10px" name="sin_panente" id="sin_patente" type="checkbox" class="bordes" onclick="sel_patente(<?php echo $contratista ?>)" />&nbsp;&nbsp;&nbsp;&nbsp;Sin patente
                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_patente" class="form-label" ></span>
                                    </div>                         
                                </div>
                                
                                 <!---motor -->
                                <div style="padding-top:0.5%" class=" row">
                                    <label class="col-2 col-form-label fondo"><b>Motor </b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="motor" id="motor" type="text" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_motor" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                <!--- chasis -->
                                <div style="padding-top:0.5%" class="row">
                                    <label  class="col-2 col-form-label fondo"><b>No. Chasis </b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="chasis" id="chasis" type="text" class="form-control bordes"   />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_chasis" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                <!--- marca -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Marca</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="marca" id="marca" type="text" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_marca" class="form-label" ></span>
                                    </div>
                                </div>

                                <!--- modelo -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Modelo</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="modelo" id="modelo" type="text" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_modelo" class="form-label" ></span>
                                    </div>
                                </div>

                                <!--- año -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Año</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input name="year" id="year" type="number" class="form-control />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_year" class="form-label" ></span>
                                    </div>
                                </div>

                                <!--- color -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Color</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <select id="color" name="color" class="form-control bordes" >
                                            <option value="seleccionar">Seleccionar</option>
                                            <option value="BLANCO">BLANCO</option>
                                            <option value="AZUL">AZUL</option>
                                            <option value="AMARILLO">AMARILLO</option>
                                            <option value="ROJO">ROJO</option>
                                            <option value="GRIS">GRIS</option>
                                            <option value="NEGRO">NEGRO</option>
                                            <option value="DORADO">DORADO</option>
                                            <option value="NARANJA">NARANJA</option>
                                            <option value="CELESTE">CELESTE</option>
                                            
                                        </select>    
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_tipo" class="form-label" ></span>
                                    </div>
                                </div>

                                <!--- pasajeros -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>No. pasajeros</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input name="puestos" id="puestos" type="number" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_pasajeros" class="form-label" ></span>
                                    </div>
                                </div>

                                  <!--- revision -->
                                  <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Revisión técnica</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input name="revision" id="revision" type="date" class="form-control bordes" onchange="revision_tecnica(this.value)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_revision" class="form-label" ></span>
                                    </div>
                                    <div class="col-2">
                                            <input name="sin_revision" id="sin_revision" type="checkbox" class="bordes" onclick="sel_revision()" />&nbsp;&nbsp;&nbsp;&nbsp;N/A
                                            <span style="color: #FF0000;font-weight: bold;" id="lbl_revision" class="form-label" ></span>
                                    </div>
                                </div>

                                <hr>

                                <!--- propietario -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Propietario</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="propietario" id="propietario" type="text" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_propietario" class="form-label" ></span>
                                    </div>
                                </div>

                                <!--- propietario -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>RUT</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="rut_propietario" id="rut_propietario" type="text" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" oninput="checkRut(this)" class="form-control bordes"  />
                                        <span style="color: #1AB394;"  id="help" class="form-label" >ingrese un RUT v&aacute;lido</span>
                                    </div>
                                </div>

                                <!--- propietario -->
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Fono Propietario</b></label>
                                    <div class="col-lg-3 col-sm-12">
                                        <input style="text-transform: uppercase;" name="fono_propietario" id="fono_propietario" type="text" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_fono_propietario" class="form-label" ></span>
                                    </div>
                                </div>

                                 <!--- propietario -->
                                 <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b>Email Propietario</b></label>
                                    <div class="col-lg-4 col-sm-12">
                                        <input style="text-transform: uppercase;" name="email_propietario" id="email_propietario" type="email" class="form-control bordes"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_email_propietario" class="form-label" ></span>
                                    </div>
                                </div>

                                <input type="hidden" name="auto" value="crear" />
                                <input type="hidden" name="contratista" value="<?php echo $_SESSION['contratista'] ?>" />
                                <input type="hidden" name="mandante" value="<?php echo $_SESSION['mandante'] ?>" />
                                <input type="hidden" name="control" id="control"  />
                                
                                <br>
                                <div style="border:1px #c0c0c0 solid;border-radius:5px;padding: 1% 0%" class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success btn-md" type="button" name="auto" value="crea" onclick="crear_vehiculo()"><strong>CREAR VEHICULO/MAQUINARIA</strong></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        <!-- modal cargando--->
                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Creando Vehículo, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>
        
        
        <div class="footer">
            <div class="float-right">
                Versi&oacute;n <strong>1.0</strong>.
            </div>
            <div>
                <strong>Copyright</strong> FacilControl &copy; <?php echo $year ?>
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

     <!-- rut 
    <script src="js\script-rut.js"></script>-->

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
      <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
    
    
        <script>
          

    function validar_patente() {
        const regex = /^[A-Z]{2}-[A-Z]{2}-\d{2}$/;
    }
    
    function on_tipo (contratista) {
        var tipo = document.getElementById("tipo_auto").value;
        switch (tipo) {
            case 'Camioneta':       letras='CAM';break;
            case 'Vehículo liviano':letras='VEH';break;
            case 'Camión 3/4':      letras='C34';break;
            case 'Camión':          letras='CMI';break;
            case 'Carro':           letras='CAR';break;
            case 'Bus traslado personal':letras='BUP';break;
            case 'Moto':letras='MOT';break;
            case 'Moto 4 ruedas':letras='M4R';break;
            case 'Tractor':letras='TRA';break;
            case 'Excavadora':letras='EXC';break;
            case 'Retroexcavadora':letras='RET';break;
            case 'Cargador frontal':letras='CAF';break;
            case 'Yale':letras='YAL';break;
            case 'Buldozer':letras='BUL';break;
            case 'Minicargador':letras='MIC';break;
            case 'Perforadora':letras='PER';break;
            case 'Grúa':letras='GRU';break;
        }
        document.getElementById("siglas").innerHTML= letras;

        if (tipo=="Excavadora" || tipo=="Retroexcavadora" || tipo=="Cargador frontal" || tipo=="Yale" || tipo=="Grúa" || tipo=="Buldozer" || tipo=="Minicargador" || tipo=="Perforadora" ) {
            //document.getElementById("patente").value="SP";
            //document.getElementById("patente").disabled=true;
            //document.getElementById("sin_patente").checked=true;          
            //document.getElementById("siglas").innerHTML= letras;
            
            //var valor=letras+'-SP-'+contratista;
            //$.ajax({
            //    method: "POST",
            //    url: "add/control_autos.php",
            //    data: 'sigla='+valor+'&contratista='+contratista,
            //    success: function(data) {                
                        //document.getElementById("siglas").innerHTML= "";
                        //document.getElementById("siglas").innerHTML= valor+'-'+data;
                        //document.getElementById("h_siglas").value=valor;
                        //document.getElementById("control").value=data;
                    
                //}
            //})

        } else {
            //document.getElementById("patente").disabled=false;
            //document.getElementById("sin_patente").checked=false;
        }
    }        

    function on_patente(contratista) {
        var tipo = document.getElementById("tipo_auto").value;
        switch (tipo) {
            case 'Camioneta':       letras='CAM';break;
            case 'Vehículo liviano':letras='VEH';break;
            case 'Camión 3/4':      letras='C34';break;
            case 'Camión':          letras='CMI';break;
            case 'Carro':           letras='CAR';break;
            case 'Bus traslado personal':letras='BUP';break;
            case 'Moto':letras='MOT';break;
            case 'Moto 4 ruedas':letras='M4R';break;
            case 'Tractor':letras='TRA';break;
            case 'Excavadora':letras='EXC';break;
            case 'Retroexcavador':letras='RET';break;
            case 'Cargador frontal':letras='CAF';break;
            case 'Yale':letras='YAL';break;
            case 'Buldozer':letras='BUL';break;
            case 'Minicargador':letras='MIC';break;
            case 'Perforadora':letras='PER';break;
            case 'Grúa':letras='GRU';break;
        }
        
        var  patente= document.getElementById("patente").value;
        const n=2;
        ultimo = patente.slice(-n);

        var valor=letras+'-'+ultimo+'-'+contratista;
        $.ajax({
            method: "POST",
            url: "add/control_autos.php",
            data: 'sigla='+valor+'&contratista='+contratista,
            success: function(data) {               
                document.getElementById("siglas").innerHTML= "";
                document.getElementById("siglas").innerHTML= valor+'-'+data;
                document.getElementById("h_siglas").value=valor;
                document.getElementById("control").value=data;
            }
        })
    }

    function sel_patente(contratista) {
        var isChecked = $('#sin_patente').prop('checked');
        if (isChecked) {
            document.getElementById("patente").value = "SP";
            //document.getElementById("patente").readOnly = true;
            var tipo = document.getElementById("tipo_auto").value;
            switch (tipo) {
                case 'Camioneta':       letras='CAM';break;
                case 'Vehículo liviano':letras='VEH';break;
                case 'Camión 3/4':      letras='C34';break;
                case 'Camión':          letras='CMI';break;
                case 'Carro':           letras='CAR';break;
                case 'Bus traslado personal':letras='BUP';break;
                case 'Moto':letras='MOT';break;
                case 'Moto 4 ruedas':letras='M4R';break;
                case 'Tractor':letras='TRA';break;
                case 'Excavadora':letras='EXC';break;
                case 'Retroexcavador':letras='RET';break;
                case 'Cargador frontal':letras='CAF';break;
                case 'Yale':letras='YAL';break;
                case 'Buldozer':letras='BUL';break;
                case 'Minicargador':letras='MIC';break;
                case 'Perforadora':letras='PER';break;
                case 'Grúa':letras='GRU';break;
            }            
                //var  patente= document.getElementById("patente").value;
                //const n=2;
                //ultimo = patente.slice(-n);
                //var siglas=document.getElementById("h_siglas").value;
                //document.getElementById("siglas").innerHTML= "";          
                //var valor=letras+'-SP-'+contratista;
                //document.getElementById("siglas").innerHTML= valor;
                //document.getElementById("h_siglas").value=valor

                var valor=letras+'-SP-'+contratista;
                $.ajax({
                    method: "POST",
                    url: "add/control_autos.php",
                    data: 'sigla='+valor+'&contratista='+contratista,
                    success: function(data) {
                    
                            document.getElementById("siglas").innerHTML= "";
                            document.getElementById("siglas").innerHTML= valor+'-'+data;
                            document.getElementById("h_siglas").value=valor;
                            document.getElementById("control").value=data;
                        
                    }
                })

        } else {
                document.getElementById("patente").value=""
                document.getElementById("patente").disabled = false;
                var  patente= document.getElementById("patente").value;
                const n=2;
                ultimo = patente.slice(-n);
                var siglas=document.getElementById("h_siglas").value;
                document.getElementById("siglas").innerHTML= siglas
            
        }
      }

      function sel_revision() {
        var isChecked = $('#sin_revision').prop('checked');
        if (isChecked) {
            document.getElementById("revision").disabled = true;
        } else {
            document.getElementById("revision").disabled = false;
        }
      }

    function sel_doc(id) {
        //alert (id);
        var isChecked = $('#doc_auto'+id).prop('checked');
        if (isChecked) {
            document.getElementById("doc"+id).style.fontWeight = "bold";
        } else {
            document.getElementById("doc"+id).style.fontWeight = "Normal";
        }
      }

    function habilitar_fecha(id) {
        //alert (id);
        var isChecked = $('#doc_vehiculo'+id).prop('checked');
        if (isChecked) {
           $("#periodo"+id).removeAttr("disabled");
           $("#indefinido"+id).removeAttr("disabled");
        } else {
           $("#periodo"+id).attr("disabled","disabled");
           $("#indefinido"+id).attr("disabled","disabled");
        }
      }
    
    function crear_vehiculo() {
      
        var patente=$('#patente').val();
        var modelo=$('#modelo').val();
        var marca=$('#marca').val();
        var color=$('#color').val();
        var puestos=$('#puestos').val();
        var siglas=$('#h_siglas').val();
        var tipo = document.getElementById("tipo_auto").value;       
        var valores=$('#frmVehiculos').serialize();                                                                   
        $.ajax({
            method: "POST",
            url: "add/autos.php",
            data: valores,
            success: function(data) {			  
                if (data==0) {
                    //alert(data); 

                    swal({
                        title: "Vehículo Creado",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                    
                    setTimeout(window.location.href='list_vehiculos.php', 3000); 
                } else {
                    if (data==1) {  
                        swal("Cancelado", "Diculpe Error de Sistema. Vuelva a Intentar.", "error");
                    } 
                    if (data==2) {
                        swal({
                            title: "Vehículo Actualizado",
                            //text: "You clicked the button!",
                            type: "success"
                        });
                    }
                    if (data==3) {
                        swal("Cancelado", "Diculpe Error de Sistema. Vuelva a Intentar.", "error");
                    }
                    if (data==4) {
                        swal({
                            title: "Vehículo Creado sin Documentos",
                            //text: "You clicked the button!",
                            type: "success"
                        });
                    }                                                                                                                                                          
                    if (data==5) {
                        swal({
                            title: "Ya tiene este vehículo agregado",
                            //text: "You clicked the button!",
                            type: "warning"
                        });
                    }                                                                                                                                
                }
               
            },                                                       
        });            
                   
 }        
 

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
