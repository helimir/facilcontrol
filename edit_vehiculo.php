<?php
session_start();
if (isset($_SESSION['usuario']) ) { 
    include('config/config.php');    
setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

$idtrabajador=$_SESSION['vehiculo'];    

$fcargos=mysqli_query($con,"SELECT * from cargos where estado=1");

$contratistas=mysqli_query($con,"SELECT id_contratista from contratistas where rut='".$_SESSION['usuario']."' ");
$fcontratista=mysqli_fetch_array($contratistas);

$contratos=mysqli_query($con,"SELECT * from contratos where estado=1 and contratista='".$fcontratista['id_contratista']."' ");
$contratista=$fcontratista['id_contratista'];

$asignados=mysqli_query($con,"SELECT contrato from vehiculos_asignados where vehiculos='".$idtrabajador."' and estado=1");
$fasignados=mysqli_fetch_array($asignados);
$conasig=unserialize($fasignados['contrato']);



if (!empty($idtrabajador)) {
    $qtrabajador=mysqli_query($con,"select * from autos where id_auto=$idtrabajador");
    $ftrabajador=mysqli_fetch_array($qtrabajador);
    $patente=$ftrabajador['patente'];
    $siglas=$ftrabajador['siglas'].'-'.$ftrabajador['control'];
}


if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante='".$_SESSION['mandante']."' ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}



?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="pragma" content="no-cache" />

    <title>FacilControl | Editar Vehiculo</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">

    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    
    
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    

<script src="js\jquery-3.1.1.min.js"></script>
<script>


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
                
                
                $("#doc").change(function () {
                    
					$("#doc option:selected").each(function () {
						doc = $(this).val();
                        if (doc=="0") {
                            $("#carga").prop('disabled', true);
                            $("#Subir").prop('disabled', true);
                        } else {
                            $("#carga").prop('disabled', false);
                            $("#Subir").prop('disabled', false);
                        }
						//$.post("comunas.php", { IdRegion: IdRegion }, function(data){
						//	$("#comuna").html(data);
						//});            
					});
				})
    });
    

  
 
function ShowSelected()
{
var combo = document.getElementById("licencia");
var selected = combo.options[combo.selectedIndex].text;
  
  if (selected=='NO)') {
      $('#tipolicencia').prop('disabled',true);
  } else  {
      $('#tipolicencia').prop('disabled',false);
  }  
   
} 
 
function descargar(rut) {
   window.location.href='files/bajar.php?rut='+rut;  
} 

function eliminar(carpeta) {
    
    swal({
        title: "Eliminar Documento",
        text: "Confirmar la solicitud",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        closeOnConfirm: false
        }, function () {
            $.ajax({
    			method: "POST",
                url: "eliminar_fichero.php",
                data: 'archivo='+carpeta,
    			success: function(data){
                  //swal("Eliminado", "Documento ha sido eliminado", "success");   
                  window.location.href='edit_trabajador.php'; 
    			}                
           });
            
        });
    
   }  

     function cargar_doc(vehiculo,id,patente){ 
               //alert(cant)
               //var patente = document.getElementById('h_siglas').value;
               var cant = document.getElementById('cant').value;
               var contador=0;
               var arreglo_doc_t=[];
               var formData = new FormData();
               //alert(patente)
               for (var i=0;i<=cant-1;i++) {
                 var filename = $('#carga'+i).val()
                 if (filename!='') {
                    formData.append('carga[]',$('#carga'+i)[0].files[0]);
                    
                    var valor_doc=$('#cadena_doc'+i).val();
                    arreglo_doc_t.push(valor_doc);
                    //alert(valor_doc);
                    contador++;
                    
                 }
              }
              if (contador>0) {
                        var doc_t=JSON.stringify(arreglo_doc_t);
                        formData.append('doc', doc_t );                                              
                        formData.append('vehiculo', vehiculo );
                        formData.append('cant', cant );
                        formData.append('patente', patente);                        
                     

                        $.ajax({
                                url: 'cargar_ficheros_vehiculo.php',
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
                                success: function(response) {
                                    if (response==0) {
                                        $('#modal_cargar').modal('hide');
                                        swal({
                                                title: "Documento Enviado",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                            });
                                        setTimeout(
                                        function() {
                        	               window.location.href='edit_vehiculo.php';
                                        },3000);
                                    } else {
                                        $('#modal_cargar').modal('hide');
                                        if (response==2) {
                                            //alert(response);
                                             swal({
                                                title: "Sin Documento",
                                                text: "Debe seleccionar un archivo",
                                                type: "warning"
                                            });
                                        } else {
                                           // alert(response);
                                            swal({
                                                title: "Documeto No Cargado",
                                                text: "Vuelva a intetar",
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

                        

               } else {
                    swal({
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF",
                        type: "warning"
                    });
               }
                    
    }

  function subir_foto(vehiculo,siglas) {
    var fileInput = document.getElementById('foto');
    var filePath = fileInput.files.length;
    if (filePath>0 ) {
                var formData = new FormData(); 
                var files= $('#foto')[0].files[0];                   
                formData.append('foto',files);
                formData.append('vehiculo',vehiculo);
                formData.append('siglas',siglas);
                $.ajax({
                    url: 'cargar/cargar_fotos_vehiculo.php',
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
                    success: function(response) {
                        $('#modal_cargar').modal('hide');
                        if (response!=1 || response!=2) {
                            swal({
                                title: "Imagen Cargada",
                                //text: "Dimensiones no validas",
                                type: "success"
                            });
                            setTimeout(function() { window.location.href='edit_vehiculo.php';},2000)

                        } else {
                            // no se cargo imagen
                            if (response==1) {
                            swal({
                                title: "Imagen No se Cargo",
                                text: "Vuelva a intentar",
                                type: "error"
                            });           
                            } else { // tipo no permitido
                            swal({
                                title: "Tipo Archivo No permitido",
                                text: "Debe adjuntar un archivo tipo imagen",
                                type: "warning"
                            });  
                            }
                        } 
                    },
                    complete:function(data){
                        $('#modal_cargar').modal('hide');
                    }, 
                    error: function(data){
                        $('#modal_cargar').modal('hide');
                    }
                });
            //}
                
       

                
    } else {
      swal({
        title: "Sin Archivo",
        text: "Debe Seleccionar una Imagen",
        type: "error"
      });    
    }    
  }  
    
  function editar() {
    //alert('hola') CAM-12-210
    var valores=$('#frmTrabajador').serialize();
    $.ajax({
    			method: "POST",
                url: "add/update_vehiculo.php",
    			data:valores,
    			success: function(data) {
    			    if (data==0) {                    
                        swal({
                            title: "Vehículo Actualizado",
                            //text: "Dimensiones no validas",
                            type: "success"
                        });
                    } 
                    setTimeout(function() { window.location.href='edit_vehiculo.php';},2000)
                 
                 if (data==1) { 
    			     swal({
                       title: "Disculpe, error de sistema",
                       text: "Vuelva a intentar",
                       type: "error"
                     });
                 }                                 
    		   }
           });
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

.estilo {
    background:#e9eafb;
    color:#292929;
}

input[type=checkbox]
        {
          /*  #F8AC59 Doble-tama�o Checkboxes */
          -ms-transform: scale(2.5); /* IE */
          -moz-transform: scale(2.5); /* FF */
          -webkit-transform: scale(2.5); /* Safari y Chrome */
          -o-transform: scale(2.5); /* Opera */
          padding: 0px;
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
                    <h2 style="color: #010829;font-weight: bold;"> Editar Vehículo: <?php echo $ftrabajador['tipo'].' '.$ftrabajador['marca'].' '.$ftrabajador['modelo'].' '.$ftrabajador['patente'] ?>]</h2>
                    <!--<label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>-->
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight"> 
          
            <div class="row" id="documentos">
                
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                           <div class="form-group row">
                                    <div class="col-12 col-sm-offset-2">
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-sm btn-success" href="crear_auto.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Vehículo/Maquinaria</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-sm btn-success" href="list_vehiculos.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte Vehículo/Maquinaria</a>
                                    </div>
                              </div> 
                             
                        </div>
                        <div class="ibox-content" >
                        
                        
                           <div class="col-lg-12">
                                <div class="tabs-container" >
                                    <ul class="nav nav-tabs" role="tablist">
                                    
                                      <?php if ($_SESSION['active_edit']=='personal') { ?>
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><h3>Informaci&oacute;n del Vehiculo</h3> </a></li>
                                        <li><a class="nav-link " data-toggle="tab" href="#tab-2"><h3>Documentaci&oacute;n</h3> </a></li>
                                      <?php } else {?>
                                        <li><a class="nav-link " data-toggle="tab" href="#tab-1"><h3>Informaci&oacute;n del Vehículo</h3> </a></li>
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-2"><h3>Documentaci&oacute;n</h3> </a></li>
                                         
                                      <?php } ?>  
                                       
                                    </ul>
                                    <div class="tab-content">
                                         <?php if ($_SESSION['active_edit']=='personal') { ?>
                                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                          <?php } else {?>
                                             <div role="tabpanel" id="tab-1" class="tab-pane">
                                          <?php } ?>   
                                                <div class="panel-body">
                                                    <?php include('datos_vehiculo.php') ?>
                                                </div>
                                            </div>
                                          <?php if ($_SESSION['active_edit']=='documentos') { ?>
                                            <div role="tabpanel" id="tab-2" class="tab-pane active">
                                          <?php } else {?>
                                             <div role="tabpanel" id="tab-2" class="tab-pane">
                                          <?php } ?>

                                          <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox "> 
                                            
                                                    <div class="panel-body">                                                   
                                                        <div class="panel panel-success">
                                                                <table class="table">
                                                                  <thead style="background:#010829;color:#fff;border-rigth:1px #fff solid">
                                                                    <tr>                                                                      
                                                                      <th style="border-right:1px #fff solid" width="50%">Documento</th>
                                                                      <th style="border-right:1px #fff solid" width="30%">Archivo</th>
                                                                      <th style="border-right:1px #fff solid" width="10%">Cargar</th>
                                                                      <th width="10%;text-align:center">Accion</th>
                                                                    </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                   
                                                                   <?php
                                                                    $i=0;                                                                    
                                                                    $documentos=mysqli_query($con,"select * from doc_autos where estado=0");
                                                                    foreach ($documentos as $row) {                                                                     
                                                                        $carpeta='doc/vehiculos/'.$fcontratista['id_contratista'].'/'.$siglas.'/'.$row['documento'].'_'.$siglas.'.pdf';
                                                                        $archivo_exitse=file_exists($carpeta);    
                                                                        
                                                                        $doc=$row['documento'];
                                                                        $id_doc=$row['id_vdoc'];
                                                                                                                                        
                                                                        ?> 
                                                                       <tr>
                                                                          <?php if ($archivo_exitse) { ?>                                                                                 
                                                                                <td><a  href="<?php echo $carpeta ?>" class="" title="Descargar Archivo" target="_blank" ><strong><u><?php echo $row['documento'] ?></u></strong></a>  </td>
                                                                                <td>
                                                                                    <div   class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                <span style="background: #282828;color:#fff;border:1px #282828 solid" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                                                                <span class="fileinput-exists">Cambiar</span><input type="file" id="carga<?php echo $i ?>" name="carga[]" accept="application/pdf" /></span>
                                                                                                <span class="fileinput-filename"></span>
                                                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                    </div>  
                                                                                </td>    
                                                                           <?php } else { ?>  
                                                                                <td><strong><?php echo $row['documento'] ?></strong></td>
                                                                                <td>
                                                                                    <div   class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                <span style="background: #282828;color:#fff;border:1px #282828 solid" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                                                                <span class="fileinput-exists">Cambiar</span><input type="file" id="carga<?php echo $i ?>" name="carga[]" accept="application/pdf" /></span>
                                                                                                <span class="fileinput-filename"></span>
                                                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                    </div>  
                                                                                </td>    
                                                                           <?php } ?> 
                                                                          
                                                                                 
                                                                        <td>
                                                                            <button class="btn-success btn btn-sm " id="subir1" type="button" value="<?php echo $i ?>" onclick="cargar_doc(<?php echo $idtrabajador  ?>,<?php echo $i ?>,'<?php echo $siglas ?>')"><i class="fa fa-upload" aria-hidden="true"></i> Cargar</button>
                                                                        </td>
                                                                               
                                                                          </td>
                                                                          <td>
                                                                           <div class="form-group row">
                                                                                
                                                                                <?php if ($archivo_exitse) { ?>
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a style="color: #FFFFFF;" href="<?php echo $carpeta ?>" class="btn-success btn btn-sm" title="Descargar Archivo" target="_blank" ><i class="fa fa-download" aria-hidden="true"></i>  </a>&nbsp;
                                                                                    <a style="color: #FFFFFF;" class="btn-danger btn btn-sm" title="Eliminar Archivo" onclick="eliminar('<?php echo $carpeta ?>')" ><i class="fa fa-trash-o" aria-hidden="true"></i>  </a>
                                                                                <?php } else { ?>
                                                                                    
                                                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn-dark btn btn-sm" title="Descargar Archivo" disabled=""><i class="fa fa-download" aria-hidden="true"></i>  </button>&nbsp;
                                                                                    <button type="button" class="btn-danger btn btn-sm" title="Eliminar Archivo" disabled=""><i class="fa fa-trash-o" aria-hidden="true"></i>  </button>
                                                                                    
                                                                                <?php } ?>    
                                                                            </div>
                                                                          </td>                                                                    
                                                                        <input type="hidden" id="trabajador" name="trabajador" value="<?php echo $idtrabajador ?>" />
                                                                        <input type="hidden" id="documento" value="<?php echo $doc ?>" />
                                                                        <input type="hidden" name="cadena_doc[]" id="cadena_doc<?php echo $i ?>" value="<?php echo $id_doc ?>" />
                                                                        <input type="hidden" name="patente" id="patente" value="<?php echo $siglas ?>" />
                                                                        </tr>
                                                                   <?php $i++; } ?> 
                                                                 </tbody>
                                                                 <input type="hidden" id="cant" name="cant" value="<?php echo $i ?>" />
                                                               </table>
                                                        </div>    
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>


                                </div>                                            
                            </div>
                        </div>
                    </div>  
                            
                </div>
            </div>
        </div>
                
                <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Cargando Archivos, por favor espere un momento</h3>
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
                
                
            </div>
        </div>
        <div class="footer">
            <div class="float-right">
                Versi&oacute;n <strong>1.0</strong>.
            </div>
            <div>
                <strong>Copyright</strong> Proyecto Empresas &copy; <?php echo $year ?>
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

    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
        <script>
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
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
    function refresh_cargar(){
        window.location.href='edit_trabajador.php';
    }        
            
    
    
    
    </script>
</body>

<?php 

if ($_SESSION['sms']==8) {             
    echo '<script>swal("Actualizado!", "Trabajador Actualizado.", "success");</script>';
    $_SESSION['sms']=0;
 }

if ($_SESSION['sms']==9) {             
     echo '<script>swal("Cancelado", "Trabajador No Actualizado. Vuelva a intentar.", "warning");;</script>';
    $_SESSION['sms']=0;
 }
 
if ($_SESSION['sms']==10) {             
    echo '<script>
            swal({
                title: "Documento Cargado",
                //text: "You clicked the button!",
                type: "success"
            });
         </script>';
    $_SESSION['sms']=0;
 } 

?>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
