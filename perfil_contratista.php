<?php
session_start();
if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==2 or $_SESSION['nivel']==1 or $_SESSION['nivel']==3)  ) { 

    
include('config/config.php');
//$regiones= consulta_general('regiones');
$regiones=mysqli_query($con,"Select * from regiones order by orden asc ");
$mandantes=mysqli_query($con,"Select * from mandantes ");

$query=mysqli_query($con,"Select r.Region as region_comercial, o.Comuna as comuna_comercial, c.* from contratistas as c left join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On IdComuna=c.dir_comercial_comuna where c.id_contratista='".$_SESSION['contratista']."' ");
$result=mysqli_fetch_array($query);

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

     <title>FacilControl | Perfil de la Contratista</title> 
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

    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">

<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>



<script src="js\jquery-3.1.1.min.js"></script>
<script>


    $(document).ready(function(){

                $('#menu-datos-contratista').attr('class','active');

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


    function subir_foto(contratista) {
        var fileInput = document.getElementById('logo');
        var filePath = fileInput.files.length;
        if (filePath>0 ) {
                
                var formData = new FormData(); 
                var files= $('#logo')[0].files[0];                   
                formData.append('foto',files);
                formData.append('contratista',contratista);
                $.ajax({
                    url: 'cargar/cargar_logo_contratista.php',
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
                    success: function(data) {                    
                        $('#modal_cargar').modal('hide');
                        if (data==0) {
                            swal({
                                title: "Imagen Cargada",
                                //text: "Dimensiones no validas",
                                type: "success"
                            });                           
                            window.location.href='perfil_contratista.php';
                        } else {
                            swal({
                                title: "Imagen No se Cargo",
                                text: "Vuelva a intentar",
                                type: "error"
                            }); 
                        } 
                    },
                    complete:function(data){
                        $('#modal_cargar').modal('hide');
                    }, 
                    error: function(data){
                        $('#modal_cargar').modal('hide');
                    }
                });
                
    } else {
      swal({
        title: "Sin Archivo",
        text: "Debe Seleccionar una Imagen",
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
        font-weight:600;
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
                    <h2 style="color: #010829;font-weight: bold;">Datos de la Contratista <?php  ?></h2>
                </div>
            </div> 
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                              <div class="ibox-title"> 
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_trabajadores.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Trabajadores</a>
                                    </div> 
                              </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmPerfil">
                                 
                                <div class="row"> 
                                    <div class="form-group fondo col-lg-2 col-md-2 col-sm-2 col-xs-3">
                                        <label  class="col-form-label" for="quantity"><strong>Logo empresa</strong></label>
                                    </div> 
                                    <div  class="form-group col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <?php 
                                        if ($result['url_logo']=="") {
                                            echo '<img src="img/sinimagen.png" />';
                                        } else {
                                            echo '<img width="150" heigth="150" src="'.$result['url_logo'].'" />';
                                        }                                                                       
                                        ?>
                                        <br />
                                        <br />
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <span style="background: #282828;color:#fff;" class="btn btn-default btn-file"><span  class="fileinput-new ">Seleccione Imagen</span>
                                            <input onchange="subir_foto(<?php echo $result['id_contratista'] ?>)"  type="file" id="logo" name="logo" accept="image/jpeg,image/jpg,image/png" /></span>
                                            <span class="fileinput-filename"></span>
                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                                                                
                                 <!--- rut -->
                                <div class="form-group row">                                    
                                    <label class="col-lg-2 col-sm-12 col-form-label fondo">RUT</label>
                                    <!--<div class="col-sm-2"><input class="form-control" type="text" name="rut" id="rut" placeholder="11111111-1" autocomplete="off" maxlength="10" onBlur="existerut(this.value)"  oninput="checkRut(this)"   required=""  ></div>-->
                                    <div class="col-lg-10 col-sm-12">
                                        <label class="col-form-label"><?php echo $result['rut'] ?></label>
                                    </div>
                                </div>
                                
                                 <!--- razon social -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Raz&oacute;n Social </small></label>
                                    <div class="col-lg-10 col-sm-12">
                                        <label class="col-form-label"><?php echo $result['razon_social'] ?></label>
                                    </div>
                                    
                                </div>
                                
                                 <!--- giro -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label fondo">Giro </small></label>
                                    <div class="col-sm-6">
                                        <input name="giro" id="giro" type="text" class="form-control" onBlur="validar(2)" value="<?php echo $result['giro'] ?>" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_giro_social" class="form-label" ></span>
                                    </div>
                                </div>
                                 <!--- descripcion -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Descripci&oacute;n del giro </small></label>
                                    <div class="col-sm-6">
                                        <input name="descripcion" id="descripcion" type="text" class="form-control" onBlur="validar(3)" value="<?php echo $result['descripcion_giro'] ?>"  />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_descripcion" class="form-label" ></span>
                                    </div>
                                </div>
                                 <!--- nombre de fantasia -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Nombre de Fantas&iacute;a</label>
                                    <div class="col-sm-6">
                                        <input name="nombre_fantasia" id="nombre_fantasia" type="text" class="form-control" onBlur="validar(4)" value="<?php echo $result['nombre_fantasia'] ?>" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_nombre_fantasia" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                
                                <!--- direcion empresa -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Direccion </small></label>
                                    <div class="col-sm-4">
                                        <input name="direccion_empresa" id="direccion_empresa" type="text" class="form-control" placeholder="" onBlur="validar(5)" value="<?php echo $result['direccion_empresa'] ?>"  />
                                        <span style="color: #FF0000;font-weight: bold;;font-weight: bold;" id="lbl_direccion_empresa" class="form-label" ></span>
                                    </div>
                                </div>
                                <!--- direccion comercial -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Regi&oacute;n </small></label>
                                    <div class="col-sm-4">
                                        <select id="region_com" name="region_com" id="region_com" class="form-control" onchange="validar(6)" onBlur="validar(6)">
                                           <option value="<?php $result['dir_comercial_region'] ?>" selected=""><?php echo $result['region_comercial'] ?></option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_region_com" class="form-label" ></span>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Comuna </small></label>
                                    <div class="col-sm-4">
                                        <select id="comuna_com" name="comuna_com" id="comuna_com" class="form-control" onchange="validar(7)" onBlur="validar(7)"  >
                                        <option value="<?php $result['dir_comercial_comuna'] ?>" selected=""><?php echo $result['comuna_comercial'] ?></option>
                                               
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_comuna_com" class="form-label" ></span>
                                    </div>
                                </div>                   
                                
                                <hr />
                                 <div class="form-group row">
                                    <div class="col-sm-12 col-form-label font-bold"><h3>Informaci&oacute;n del Responsable de Facil Control
                                    </h3> </div>
                                </div>            
                                <!-- administrador -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label fondo">Nombre </small></label>
                                    <div class="col-sm-4">
                                        <input name="administrador" id="administrador" type="text" class="form-control" required="" onBlur="validar(8)" value="<?php echo $result['administrador'] ?>" />
                                         <span style="color: #FF0000;font-weight: bold;" id="lbl_administrador" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label fondo">Tel&eacute;fono </small></label>
                                    <div class="col-sm-4">
                                        <input name="fono" id="fono" type="text" class="form-control" required="" onBlur="validar(9)" value="<?php echo $result['fono'] ?>" />
                                         <span style="color: #FF0000;font-weight: bold;" id="lbl_fono" class="form-label" ></span>
                                    </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label fondo">Correo </small></label>
                                    <div class="col-sm-4">
                                        <input name="email" id="email" type="email" class="form-control"  placeholder="email@dominio.com" required="" onBlur="validar(10)" value="<?php echo $result['email'] ?>" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_email" class="form-label" ></span>
                                    </div>
                                </div>
                                <!-- fono admin -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label fondo"></label>
                                    <div class="col-sm-4">
                                        <input name="email2" id="email2" type="email2" class="form-control"  placeholder="Confirmar Email" required="" onBlur="validar(11)" value="<?php echo $result['email'] ?>" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_email2" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                
                                <hr />
                                <div class="form-group row">
                                    <div class="col-sm-12 col-form-label"><h3>Informaci&oacute;n del Representante Legal</h3> </div>
                                </div>           
                                <!-- representante -->
                                <div class="form-group  row"><label class="col-sm-2 col-form-label fondo">Nombre </small></label>
                                    <div class="col-sm-4">
                                        <input name="representante" id="representante" type="text" class="form-control" required="" onBlur="validar(12)" value="<?php echo $result['representante'] ?>" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_representante" class="form-label" ></span>
                                    </div>
                                </div>
                                
                                <!-- rut -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label fondo">RUT </small></label>
                                    <div class="col-3">
                                        <input class="form-control" maxlength="12" name="rut_rep" id="rut_rep" type="text" placeholder="xxxxxxxx-x" onkeypress="return isNumber(event)" oninput="validar_rep(this)" required="" value="<?php echo $result['rut_rep'] ?>"  />
                                        <span style="color: #1AB394;"  id="help_rep" class="form-label" >ingrese un RUT v&aacute;lido</span>
                                    </div>
                                </div>
                               
                                 <!--- direccion representante -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Direcci&oacute;n </small></label>
                                    <div class="col-sm-6">
                                        <input name="direccion_rep" id="direccion_rep" type="text" class="form-control" required="" onBlur="validar(13)" value="<?php echo $result['direccion_rep'] ?>" />
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_direccion_rep" class="form-label" ></span>
                                    </div>
                                </div>
                                                                
                                <!--- direccion rep -->
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Regi&oacute;n </small></label>
                                    <div class="col-sm-4">
                                        <select id="region_rep" name="region_rep" id="region_rep" class="form-control" onchange="validar(14)" onBlur="validar(14)" value="<?php echo $result['region_rep'] ?>" >
                                           <option value="<?php echo $result['region_rep'] ?>" selected=""><?php echo $result['region_rep'] ?></option>
                                           <?php
                                            foreach ($regiones as $row){
                                                echo '<option value="'.$row['IdRegion'].'" >'.$row['Region'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_region_rep" class="form-label" ></span>
                                    </div>
                                </div>
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Comuna </small></label>
                                    <div class="col-sm-4">
                                        <select id="comuna_rep" name="comuna_rep" id="comuna_rep" class="form-control" onchange="validar(15)" onBlur="validar(15)" <?php echo $result['comuna_rep'] ?>  >
                                           <option value="<?php echo $result['comuna_rep'] ?>" selected=""><?php echo $result['comuna_rep'] ?></option>
                                               
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_comuna_rep" class="form-label" ></span>
                                    </div>
                                </div>   
                                
                                <div class="form-group row"><label class="col-sm-2 col-form-label fondo">Estado Civil</label>
                                    <div class="col-sm-4">
                                        <select id="estado_civil" name="estado_civil" id="estado_civil" class="form-control" onchange="validar(16)" onBlur="validar(16)" <?php echo $result['estado_civil'] ?> >
                                           <option value="<?php echo $result['estado_civil'] ?>" selected=""><?php echo $result['estado_civil'] ?></option>
                                           <option value="Soltero" >Soltero</option>
                                           <option value="Casado" >Casado</option>
                                        </select>
                                        <span style="color: #FF0000;font-weight: bold;" id="lbl_estado_civil" class="form-label" ></span>
                                    </div>
                                </div>     
                                
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-success btn-md" type="button" name="contratistas" value="crea" onclick="crear_contratista(<?php echo $i ?>)" disabled >ACTUALIZAR DATOS DE LA CONTRATISTA</button>
                                    </div>
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        </div>



                        <!-- modal cargando--->
                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Cargando foto, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
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

     <!-- Jasny -->
     <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

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
            $(document).ready(function () {
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