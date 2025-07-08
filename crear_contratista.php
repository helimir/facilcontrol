<?php
session_start();
if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==2 or $_SESSION['nivel']==1)  ) { 

    
include('config/config.php');
//$regiones= consulta_general('regiones');
$regiones=mysqli_query($con,"Select * from regiones order by orden asc ");
$doc=mysqli_query($con,"Select * from doc_contratistas ");

$query_user=mysqli_query($con,"select * from users where usuario='".$_SESSION['usuario']."' ");
$result_user=mysqli_fetch_array($query_user);

$query_mandantes=mysqli_query($con,"Select * from mandantes where id_mandante='".$_SESSION['mandante']."' ");
$result_mandantes=mysqli_fetch_array($query_mandantes);
if (isset($result_mandantes['dualidad'])) {$dualidad=$result_mandantes['dualidad'];}

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

    <title>FacilControl | Crear Contratista</title> 
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


<script src="js\jquery-3.1.1.min.js"></script>
<script>


    $(document).ready(function(){
				
                $("#region_com").change(function () {				
					$("#region_com option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna_com").html(data);
						});            
					});
				})
                
                $("#region_rep").change(function () {				
					$("#region_rep option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna_rep").html(data);
						});            
					});
				})
    });
    
    function agregar(usuario,opcion) {
    swal({
        title: "¿Desea Agregar como Contratista?",
        //text: "Desea Agregarla",
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#1AB394",
        confirmButtonText: "Si, Agregar!",
        cancelButtonText: "No, Agregar!",
        closeOnConfirm: false,
        closeOnCancel: false },
        function (isConfirm) {
            if (isConfirm) { 
                $.ajax({
                    method: "POST",
                    url: "add/agregar_dual.php",
                    data: 'rut='+usuario+'&opcion='+opcion,
                    success: function(data) {
                        //alert(data)
                        if (data==0) {
                            swal({
                                title: "Contratista Agregada",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                          setTimeout(window.location.href='list_contratistas_mandantes.php', 3000);                            
                        } else {
                            swal("Disculpe Error de Sistema", "Vuelva a intentar", "error");
                        }
                    },
                });     
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        }); 
}


    function existerut(rut) {
    
      //alert(rut);
      if (rut!='') {   
       
        $.ajax({
 			method: "POST",
            url: "verificar_rut.php",
            data: 'rut='+rut,
 			success: function(data) {
                 //alert(data);
                 if (data==0) {
 			        swal({
                        title: "Contratista Existe en FacilControl. ¿Desea Agregar?",
                        //text: "Desea Agregarla",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonColor: "#1AB394",
                        confirmButtonText: "Si, Agregar!",
                        cancelButtonText: "No, Agregar!",
                        closeOnConfirm: false,
                        closeOnCancel: false },
                        function (isConfirm) {
                            if (isConfirm) {
                                $.ajax({
                         			method: "POST",
                                    url: "sesion_contratistas_agregar.php",
                                    data: 'rut='+rut,
                         			success: function(data) {
                                      window.location.href='agregar_contratista.php';
                                    },
                                });     
                                //swal("Confirmado!", "El Mandante ha sido deshabilitado.", "success");                                
                                //setTimeout(window.location.href='list_contratos.php', 3000);
                        } else {
                           swal("Cancelado", "Accion Cancelada", "error");
                          
                        }
                    });                    
 			    } 
                  if (data==1) {
 			        document.getElementById("rut").value = "";
 			        swal({
                        title: "Contratista esta en Listado",
                        //text: "You clicked the button!",
                        type: "warning"
                    });
                    
 			    }
            }                                                            
        });
     } else {
        swal({          
            title: "RUT no puede estar vacío",
            //text: "You clicked the button!",
            type: "error"
        });
     }   
        
    }

    $(document).ready(function(){
				
                $("#region").change(function () {				
					$("#region option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna").html(data);
						});            
					});
				})
                
                $("#contrato").change(function () {				
					$("#contrato option:selected").each(function () {
						id= $(this).val();
						$.post("cargos.php", { id: id }, function(data){
							$("#cargo").html(data);
						});            
					});
				})


                $('#menu-contratistas').attr('class','active');
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

  // Separa con un GuiÃ³n el cuerpo del dilgito verificador.
  rut.value = format(rut.value);

  // Si no cumple con el minimo ej. (n.nnn.nnn)
  if (bodyRut.length < 7) {
    $("#help").html("<span style='color:#1AB394;font-weight:bold' >Rut de ser mayor de 7 dígitos</span>");
    return validacion=false;
  }

  // Calcular DÃ­gito Verificador "MÃ©todo del MÃ³dulo 11"
  suma = 0;
  multiplo = 2;

  // Para cada dÃ­gito del Cuerpo
  for (i = 1; i <= bodyRut.length; i++) {
    // Obtener su Producto con el MÃºltiplo Correspondiente
    index = multiplo * valor.charAt(bodyRut.length - i);

    // Sumar al Contador General
    suma = suma + index;

    // Consolidar MÃºltiplo dentro del rango [2,7]
    if (multiplo < 7) {
      multiplo = multiplo + 1;
    } else {
      multiplo = 2;
    }
  }

  // Calcular DÃ­gito Verificador en base al MÃ³dulo 11
  dvEsperado = 11 - (suma % 11);

  // Casos Especiales (0 y K)
  dv = dv == "K" ? 10 : dv;
  dv = dv == 0 ? 11 : dv;

  // Validar que el Cuerpo coincide con su DÃ­gito Verificador
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
      
// validar rut repsesentante --------------------------------------------------------------------------------


function validar_rep(rut_rep) {
  

  if (rut_rep.value.length <= 1) {
      $("#help_rep").html("<span style='color:#1AB394;' >Ingrese un RUT v&aacute;lido</span>");
    return false
  }

  // Obtiene el valor ingresado quitando puntos y guion.
  let valor = clean(rut_rep.value);

  // Divide el valor ingresado en digito verificador y resto del rut_rep.
  let bodyrut_rep = valor.slice(0, -1);
  let dv = valor.slice(-1).toUpperCase();

  // Separa con un GuiÃ³n el cuerpo del dilgito verificador.
  rut_rep.value = format(rut_rep.value);

  // Si no cumple con el minimo ej. (n.nnn.nnn)
  if (bodyrut_rep.length < 7) {
    $("#help_rep").html("<span style='color:#1AB394;font-weight:bold' >RUT de ser mayor de 7 dígitos</span>");
    
  }

  // Calcular DÃ­gito Verificador "MÃ©todo del MÃ³dulo 11"
  suma = 0;
  multiplo = 2;

  // Para cada dÃ­gito del Cuerpo
  for (i = 1; i <= bodyrut_rep.length; i++) {
    // Obtener su Producto con el MÃºltiplo Correspondiente
    index = multiplo * valor.charAt(bodyrut_rep.length - i);

    // Sumar al Contador General
    suma = suma + index;

    // Consolidar MÃºltiplo dentro del rango [2,7]
    if (multiplo < 7) {
      multiplo = multiplo + 1;
    } else {
      multiplo = 2;
    }
  }

  // Calcular DÃ­gito Verificador en base al MÃ³dulo 11
  dvEsperado = 11 - (suma % 11);

  // Casos Especiales (0 y K)
  dv = dv == "K" ? 10 : dv;
  dv = dv == 0 ? 11 : dv;

  // Validar que el Cuerpo coincide con su DÃ­gito Verificador
  if (dvEsperado != dv) {    
    $("#help_rep").html("<span style='color:#ED5565;font-weight:bold' >RUT Inv&aacute;lido</span>");
  } else {
    $("#help_rep").html("<span style='color:#1C84C6;font-weight:bold' >RUT V&aacute;lido</span>");
  }
}


  function validar(caso) {
    
   switch (caso) { 
        case 1:  var item=$('#razon_social').val();
                 if (item=='') {
                      $("#lbl_razon_social").html("<span><small>*<b>RAZON SOCIAL REQUERIDO</b></small></span>");
                 }
                break;  
        case 2:  var item=$('#giro').val();
                 if (item=='') {
                      $("#lbl_giro_social").html("<span><small><b>* GIRO SOCIAL REQUERIDO</b></small></span>");
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

  function sel_doc(id) {
        var isChecked = $('#doc_contratista'+id).prop('checked');
        if (isChecked) {
            document.getElementById("doc"+id).style.fontWeight = "bold";
        } else {
            document.getElementById("doc"+id).style.fontWeight = "Normal";
        }
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

        .bordes {
            border: 1px solid #c0c0c0;
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

.cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
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

    .fondo {
        background:#e9eafb;
        color:#292929;
        font-weight:700;
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
                    <h2 style="color: #010829;font-weight: bold;">CREAR CONTRATISTA<?php  ?></h2>
                </div>
            </div> 
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                              <!--<div class="ibox-title"> 

                              </div>-->
                        <div class="ibox-content">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-2 col-sm-12" href="list_contratistas_mandantes.php" class="" type="button">CONTRATISTAS</a>
                                            <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-2 col-sm-12" href="list_contratos.php" class="" type="button">CONTRATOS</a>
                                        </div> 
                                    </div>
                                    <hr>
                                    <?php include('resumen.php') ?>
                            <form  method="post" id="frmContratistas">
                                 
                                 <?php  if ($_SESSION['nivel']==1)  {
                                    $mandantes=mysqli_query($con,"Select * from mandantes ");  
                                    echo '<div class="form-group  row"><label class="col-sm-2 col-form-label">Mandante</label>';
                                        echo '<div class="col-sm-4">
                                          <select id="mandante" name="mandante" class="form-control">
                                           <option value="0" selected="">Seleccionar Mandante</option>';
                                           
                                            foreach ($mandantes as $row){
                                                echo '<option value="'.$row['id_mandante'].'" >'.$row['razon_social'].'</option>';
                                            }    
                                                
                                        echo '</select>
                                        
                                            </div>
                                      </div>';
                                  } ?>   

                                <div class="form-group row"> 
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <?php if ($dualidad==0) { ?>
                                            <a style="font-size:12px;color:#fff" class="btn btn-success btn-sm" onclick="agregar('<?php echo $_SESSION['usuario'] ?>',1)"><b>AGREGAR COMO CONTRATISTA</b></a>
                                        <?php } else {?>        
                                            <button style="font-size:12px;color:#fff" class="btn btn-secondary btn-sm" disabled ><b>AGREGAR COMO CONTRATISTA</b></button>
                                        <?php }  ?>                                    
                                    </div>
                                </div> 
                                 
                                   
                                
                                 <!--- rut -->
                                <div class="form-group row">                                    
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-lg-2 col-sm-12 col-xs-12 col-form-label">RUT </small></label>                                    
                                        <input class="form-control bordes col-lg-2 col-md-2 col-sm-12 col-xs-12" maxlength="12" name="rut" id="rut" type="text" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" onBlur="existerut(this.value)" oninput="checkRut(this)" required=""  />
                                        <span style="color: #1AB394;"  id="help" class="form-label" >ingrese un RUT v&aacute;lido</span>
                                    </div>
                                </div>
                                
                                 <!--- razon social -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-lg-2 col-sm-12 col-xs-12 col-form-label">Raz&oacute;n Social </small></label>
                                        <input name="razon_social" id="razon_social" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onBlur="validar(1)"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_razon_social" class="form-label" ></span>
                                    </div>
                                    
                                </div>
                                
                                 <!--- giro -->
                                <div class="form-group  row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label ">Giro </small></label>
                                        <input name="giro" id="giro" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onBlur="validar(2)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_giro_social" class="form-label" ></span>
                                    </div>
                                </div>
                                 <!--- descripcion -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label ">Descripci&oacute;n del giro </small></label>
                                        <input name="descripcion" id="descripcion" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onBlur="validar(3)"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_descripcion" class="form-label" ></span>
                                    </div>
                                </div>
                                 <!--- nombre de fantasia -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label ">Nombre de Fantas&iacute;a</label>
                                        <input name="nombre_fantasia" id="nombre_fantasia" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onBlur="validar(4)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_nombre_fantasia" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                
                                <!--- direcion empresa -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label ">Direccion </small></label>
                                        <input name="direccion_empresa" id="direccion_empresa" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" placeholder="" onBlur="validar(5)"  />
                                        <span style="color: #FF0000;font-weight: bold;;font-weight: bold;" id="lbl_direccion_empresa" class="form-label" ></span>
                                    </div>
                                </div>
                                <!--- direccion comercial -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label ">Regi&oacute;n </small></label>
                                        <select id="region_com" name="region_com" id="region_com" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onchange="validar(6)" onBlur="validar(6)">
                                           <option value="0" selected="">Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_region_com" class="form-label" ></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Comuna </small></label>
                                        <select id="comuna_com" name="comuna_com" id="comuna_com" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onchange="validar(7)" onBlur="validar(7)"  >
                                           <option value="0" selected="">Seleccionar Comuna</option>
                                               
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_comuna_com" class="form-label" ></span>
                                    </div>
                                </div>                   
                                
                                <hr />
                                 <div class="form-group row">
                                    <div style="font-weight:bold;color: #000000" class="col-sm-12 col-form-label font-bold"><h3>Informaci&oacute;n del Responsable de Facil Control</h3> </div>
                                </div>            
                                <!-- administrador -->
                                <div class="form-group  row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Nombre </small></label>
                                        <input name="administrador" id="administrador" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" required="" onBlur="validar(8)" />
                                         <span style="color: #FF0000;font-weight: bold;" id="lbl_administrador" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                <!-- fono admin -->
                                <div class="form-group  row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Tel&eacute;fono </small></label>
                                        <input name="fono" id="fono" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" required="" onBlur="validar(9)" />
                                         <span style="color: #FF0000;font-weight: bold;" id="lbl_fono" class="form-label" ></span>
                                    </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Correo </small></label>
                                        <input name="email" id="email" type="email" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12"  placeholder="email@dominio.com" required="" onBlur="validar(10)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_email" class="form-label" ></span>
                                    </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label"></label>
                                        <input name="email2" id="email2" type="email2" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12"  placeholder="Confirmar Email" required="" onBlur="validar(11)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_email2" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                
                                <hr />
                                <div class="form-group row">
                                    <div style="font-weight:bold;color: #000000" class="col-sm-12 col-form-label"><h3>Informaci&oacute;n del Representante Legal</h3> </div>
                                </div>           
                                <!-- representante -->
                                <div class="form-group  row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Nombre </small></label>
                                        <input name="representante" id="representante" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" required="" onBlur="validar(12)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_representante" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                <!-- rut -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">RUT </small></label>
                                        <input class="form-control bordes col-lg-2 col-md-2 col-sm-12 col-xs-12" maxlength="12" name="rut_rep" id="rut_rep" type="text" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" oninput="validar_rep(this)" required=""  />
                                        <span style="color: #1AB394;"  id="help_rep" class="form-label" >ingrese un RUT v&aacute;lido</span>
                                    </div>
                                </div>
                               
                                 <!--- direccion representante -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Direcci&oacute;n </small></label>
                                        <input name="direccion_rep" id="direccion_rep" type="text" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" required="" onBlur="validar(13)" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_direccion_rep" class="form-label" ></span>
                                    </div>
                                </div>
                                                                
                                <!--- direccion rep -->
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Regi&oacute;n </small></label>
                                        <select id="region_rep" name="region_rep" id="region_rep" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onchange="validar(14)" onBlur="validar(14)" >
                                           <option value="0" selected="">Seleccionar Region</option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_region_rep" class="form-label" ></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Comuna </small></label>
                                        <select id="comuna_rep" name="comuna_rep" id="comuna_rep" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onchange="validar(15)" onBlur="validar(15)"  >
                                           <option value="0" selected="">Seleccionar Comuna</option>                                               
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_comuna_rep" class="form-label" ></span>
                                    </div>
                                </div>   
                                
                                <div class="form-group row">
                                    <div class="col-12">
                                        <label style="font-weight:bold;color: #000000" class="col-sm-2 col-form-label">Estado Civil</label>
                                        <select id="estado_civil" name="estado_civil" id="estado_civil" class="form-control bordes col-lg-12 col-md-12 col-sm-12 col-xs-12" onchange="validar(16)" onBlur="validar(16)" >
                                           <option value="" selected="">Seleccionar Estado Civil</option>
                                           <option value="Soltero" >Soltero</option>
                                           <option value="Casado" >Casado</option>
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_estado_civil" class="form-label" ></span>
                                    </div>
                                </div>                                
                                 <hr />
                                 
                                 <div class="form-group row">
                                    <div  class="col-sm-12 col-form-label font-bold">
                                      
                                        <h3 style="text-align: ;">Documentacio&oacute;n que debe enviar el Contratista 
                                            <a class="tags" gloss="Seleccionar en boton habilitar los documetnos que la empresa contratista debe enviar para revisión del mandante antes de comezar su operación, si esta información no esta disponible no podrá crea acceso a su personal"><sup  ><i style="font-size: 14px;" class="fa fa-info-circle" aria-hidden="true"></i></sup></a>
                                        </h3> 
                                        <label style="background: #333;color:#fff;padding: 0% 1% 0% 1%;border-radius: 10px;" >Para documentos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                    </div>    
                                </div>
                                
                                
                                <div class="row">
                                        <table class="table table-responsive">
                                                                        
                                            <thead  class="cabecera_tabla">
                                                <tr >
                                                    <th style="border-right:1px #fff solid">Seleccionar</th>
                                                    <th style="width:100%">Documento</th>         
                                                </tr>                                    
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" ></td>    
                                                </tr>
                                            <?php $i=1; foreach ($doc as $row) { ?>                                                    
                                                <tr>
                                                    <td class="text-center" ><input id="doc_contratista<?php echo $i ?>" name="doc_contratista[]" type="checkbox" value="<?php echo $row['id_cdoc'] ?>" onclick="sel_doc(<?php echo $i ?>)"   /></td>    
                                                    <td><label id="doc<?php echo $i ?>" class="font-bold"><?php echo $row['documento'] ?></label></td>    
                                                </tr>

                                            <?php $i++; } ?> 
                                        
                                            </tbody>
                                        </table>
                                </div>
                                  
                                <hr />
                                <input type="hidden" name="contratistas" value="crear" />
                                <input type="hidden" name="total_doc" value="<?php echo $i ?>" />
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div style="font-size:16px" class="col-12 col-sm-offset-2">
                                        <button class="btn btn-success btn-md col-lg-4 col-sm-12 col-xs-12" type="button" name="contratistas" value="crea" onclick="crear_contratista(<?php echo $i ?>)">CREAR CONTRATISTA</button>
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
                                  <h3>Creando Contratista, por favor espere un momento</h3>
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
        
    function habilitar_fecha(id) {
        //alert (id);
        var isChecked = $('#doc_contratista'+id).prop('checked');
        if (isChecked) {
           $("#periodo"+id).removeAttr("disabled");
           $("#indefinido"+id).removeAttr("disabled");
        } else {
           $("#periodo"+id).attr("disabled","disabled");
           $("#indefinido"+id).attr("disabled","disabled");
        }
      }
    
    function crear_contratista(total){
      //alert(total);
      
      var rut=$('#rut').val();
      var razon_social=$('#razon_social').val();
      var giro=$('#giro').val();
      var descripcion=$('#descripcion').val();
      var nombre_fantasia=$('#nombre_fantasia').val();
      var direccion_empresa=$('#direccion_empresa').val();
      var region_com=$('#region_com').val();
      var comuna_com=$('#comuna_com').val();
      
      var administrador=$('#administrador').val();
      var fono=$('#fono').val();
      var email=$('#email').val();
      var email2=$('#email2').val();
      
      var representante=$('#representante').val();
      var rut_rep=$('#rut_rep').val();
      var direccion_rep=$('#direccion_rep').val();
      var region_rep=$('#region_rep').val();
      var comuna_rep=$('#comuna_rep').val();
      var estado_civil=$('#estado_civil').val();
      
      var contador=0;
      for (var i=0;i<=total-1;i++){
       var isChecked_doc = $('#doc_contratista'+i).prop('checked');
        if (isChecked_doc) {
           contador=contador+1;
        } 
      }
            
      //validar rut
      if (rut=="") {
         swal({
            title: "RUT Requerido",
            text: "Debe completar información",
            type: "warning"
         });
        // validar razon social
      } else {
            if (razon_social=="") {
               swal({
                    title: "Razon Social Requerido",
                    text: "Debe completar información",
                    type: "warning"
                });
                $("#lbl_razon_social").html("<span style='' >* Razon Social requerido</span>");
            } else {
                if (giro=="") {
                       swal({
                        title: "Giro Social Requerido",
                        text: "Debe completar información",
                        type: "warning"
                    });
                    $("#lbl_giro_social").html("<span style='' >* Giro Social requerido</span>");
                } else {
                  if (descripcion==""){
                         swal({
                            title: "Descripcion Requerido",
                            text: "Debe completar información",
                            type: "warning"
                        });
                        
                  } else {
                    if (nombre_fantasia=="") {
                        swal({
                            title: "Nombre Fantasia Requerido",
                            text: "Debe completar información",
                            type: "warning"
                        });
                    } else {
                        if (direccion_empresa=="") {
                             swal({
                                title: "Dirección Empresa Requerido",
                                text: "Debe completar información",
                                type: "warning"
                            });
                        } else {
                            if (region_com=="0") {
                                swal({
                                    title: "Region Empresa Requerido",
                                    text: "Debe completar información",
                                    type: "warning"
                                }); 
                            } else {
                                if (comuna_com=="0") {
                                    swal({
                                        title: "Comuna Empresa Requerido",
                                        text: "Debe completar información",
                                        type: "warning"
                                    });
                                } else {
                                    if (administrador=="") {
                                        swal({
                                            title: "Administrador Sistema Requerido",
                                            text: "Debe completar información",
                                            type: "warning"
                                        });
                                    } else {
                                        if (fono=="") {
                                            swal({
                                                title: "Fono Administrador Sistema Requerido",
                                                text: "Debe completar información",
                                                type: "warning"
                                            });
                                        } else {
                                            if (email=="") {
                                                swal({
                                                    title: "Email Administrador Sistema Requerido",
                                                    text: "Debe completar información",
                                                    type: "warning"
                                                });  
                                            } else {
                                                if (email2=="") {
                                                    swal({
                                                        title: "Confirmar Email Requerido",
                                                        text: "Debe completar información",
                                                        type: "warning"
                                                    });  
                                                } else {
                                                    if (email!=email2) {
                                                        swal({
                                                            title: "Email deben ser iguales",
                                                            //text: "Debe completar información",
                                                            type: "warning"
                                                        }); 
                                                    } else {
                                                        if (representante=="") {
                                                            swal({
                                                                title: "Representante Requerido",
                                                                text: "Debe completar información",
                                                                type: "warning"
                                                            });   
                                                        } else {
                                                            if (rut_rep=="") {
                                                                   swal({
                                                                     title: "RUT Representante Requerido",
                                                                     text: "Debe completar información",
                                                                     type: "warning"
                                                                   });     
                                                            } else {
                                                                if (direccion_rep=="") {
                                                                     swal({
                                                                         title: "Direccion Representante Requerido",
                                                                         text: "Debe completar información",
                                                                         type: "warning"
                                                                     });
                                                                } else {
                                                                    if (region_rep=="0") {
                                                                          swal({
                                                                             title: "Region Representante Requerido",
                                                                             text: "Debe completar información",
                                                                             type: "warning"
                                                                          });
                                                                    } else {
                                                                        if (comuna_rep=="0") {
                                                                             swal({
                                                                                 title: "Comuna Representante Requerido",
                                                                                 text: "Debe completar información",
                                                                                 type: "warning"
                                                                              });
                                                                        } else {
                                                                            
                                                                            // sino hay documentos seleccionados
                                                                            if (contador==0) {
                                                                                
                                                                                // confirmacion si crea sin documentos
                                                                                swal({
                                                                                    title: "Ningun documento de Contratista seleccionado . ¿Desea Agregar?",
                                                                                    //text: "Desea Agregarla",
                                                                                    type: "success",
                                                                                    showCancelButton: true,
                                                                                    confirmButtonColor: "#1AB394",
                                                                                    confirmButtonText: "Si, Agregar!",
                                                                                    cancelButtonText: "No, Agregar!",
                                                                                    closeOnConfirm: false,
                                                                                    closeOnCancel: false },
                                                                                    function (isConfirm) {
                                                                                        if (isConfirm) {
                                                                                              var valores=$('#frmContratistas').serialize();
                                                                                              $.ajax({
                                                                                    			method: "POST",
                                                                                                url: "add/contratistas.php",
                                                                                                data: valores,
                                                                                                beforeSend: function(){
                                                                                                    $('#modal_cargar').modal('show');						
                                                                                    			},
                                                                                    			success: function(data) {			  
                                                                                                 if (data==0) {
                                                                                                     //alert(data);                     ; 
                                                                                                     swal({
                                                                                                            title: "Contratista Creada",
                                                                                                            //text: "You clicked the button!",
                                                                                                            type: "success"
                                                                                                     });
                                                                                                     setTimeout(window.location.href='list_contratistas_mandantes.php', 3000);
                                                                                                     //window.location.href='list_contratistas_mandantes.php';
                                                                                    			  } else {
                                                                                    			      if (data==1) {  
                                                                                                        swal("Cancelado", "Contratista No Creada. Vuelva a Intentar.", "error");
                                                                                                      } 
                                                                                                      if (data==2) {
                                                                                                        swal({
                                                                                                            title: "Contratista Actualizada",
                                                                                                            //text: "You clicked the button!",
                                                                                                            type: "success"
                                                                                                        });
                                                                                                      }
                                                                                                      if (data==3) {
                                                                                                        swal("Contratista No Actualizada", "Vuelva a Intentar.", "error");
                                                                                                      }
                                                                                                      
                                                                                                      if (data==4) {
                                                                                                         swal({
                                                                                                            title: "Contratista existe en FacilControl",
                                                                                                            text: "Desea agrega a sus registros",
                                                                                                            type: "success",
                                                                                                            showCancelButton: true,
                                                                                                            confirmButtonColor: "#DD6B55",
                                                                                                            confirmButtonText: "Yes, agregar",
                                                                                                            cancelButtonText: "No, agregar",
                                                                                                            closeOnConfirm: false,
                                                                                                            closeOnCancel: false },
                                                                                                        function (isConfirm) {
                                                                                                            // confirma agregar contratista
                                                                                                            if (isConfirm) {
                                                                                                                swal("Agregar Contratista", "Funcion no activa)", "success");                                                                                            
                                                                                                            } else {
                                                                                                                swal("Cancelado", "Contratista no agregada)", "error");
                                                                                                            }
                                                                                                        });
                                                                                                      }
                                                                                                       
                                                                                                      if (data==5) {
                                                                                                        swal({
                                                                                                            title: "Ya tiene esta Contratista agregada",
                                                                                                            //text: "You clicked the button!",
                                                                                                            type: "warning"
                                                                                                        });
                                                                                                      }    
                                                                                                      
                                                                                                      if (data==6) {
                                                                                                        swal({
                                                                                                            title: "RUT existe como Mandante",
                                                                                                            text: "Agregue como Contratista",
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
                                                                                    } else {
                                                                                       swal("Cancelado", "Accion Cancelada", "error");
                                                                                      
                                                                                    }
                                                                                });    
                                                                            
                                                                        // con documentos seleccionados              
                                                                        } else {
                                                                                              var valores=$('#frmContratistas').serialize();
                                                                                              $.ajax({
                                                                                    			method: "POST",
                                                                                                url: "add/contratistas.php",
                                                                                                data: valores,
                                                                                                beforeSend: function(){
                                                                                                    $('#modal_cargar').modal('show');						
                                                                                    			},
                                                                                    			success: function(data) {	
                                                                                                    $('#modal_cargar').modal('hide');
                                                                                                    if (data==0) {                                                                                                     
                                                                                                        swal({
                                                                                                                title: "Contratista Creada",
                                                                                                                //text: "You clicked the button!",
                                                                                                                type: "success"
                                                                                                        });
                                                                                                        setTimeout(window.location.href='list_contratistas_mandantes.php', 3000);
                                                                                                        //window.location.href='list_contratistas_mandantes.php';
                                                                                                    } else {
                                                                                                            if (data==1) {  
                                                                                                                swal("Cancelado", "Contratista No Creada. Vuelva a Intentar.", "error");
                                                                                                            } 
                                                                                                            if (data==2) {
                                                                                                                swal({
                                                                                                                    title: "Contratista Actualizada",
                                                                                                                    //text: "You clicked the button!",
                                                                                                                    type: "success"
                                                                                                                });
                                                                                                            }
                                                                                                            if (data==3) {
                                                                                                                swal("Contratista No Actualizada", "Vuelva a Intentar.", "error");
                                                                                                            }
                                                                                                            
                                                                                                            if (data==4) {
                                                                                                                swal({
                                                                                                                    title: "Contratista existe en FacilControl",
                                                                                                                    text: "Desea agrega a sus registros",
                                                                                                                    type: "success",
                                                                                                                    showCancelButton: true,
                                                                                                                    confirmButtonColor: "#DD6B55",
                                                                                                                    confirmButtonText: "Yes, agregar",
                                                                                                                    cancelButtonText: "No, agregar",
                                                                                                                    closeOnConfirm: false,
                                                                                                                    closeOnCancel: false },
                                                                                                                function (isConfirm) {
                                                                                                                    // confirma agregar contratista
                                                                                                                    if (isConfirm) {
                                                                                                                        swal("Agregar Contratista", "Funcion no activa)", "success");                                                                                            
                                                                                                                    } else {
                                                                                                                        swal("Cancelado", "Contratista no agregada)", "error");
                                                                                                                    }
                                                                                                                });
                                                                                                            }
                                                                                                            
                                                                                                            if (data==5) {
                                                                                                                swal({
                                                                                                                    title: "Ya tiene esta Contratista agregada",
                                                                                                                    //text: "You clicked the button!",
                                                                                                                    type: "warning"
                                                                                                                });
                                                                                                            } 
                                                                                                            
                                                                                                            if (data==6) {
                                                                                                                swal({
                                                                                                                    title: "RUT existe como Mandante",
                                                                                                                    text: "Agregue como Contratista",
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
                                            }
                                            
                                        }
                                    }
                                    
                                }
                                
                            }
                        }
                        
                    }
                    
                    
              }  
            }
        }    
      } 
 }        
 

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>