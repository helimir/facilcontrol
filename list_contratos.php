<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$mandante=$_SESSION['mandante'];

if ($_SESSION['nivel']==1)  {
   $sql_contratistas=mysqli_query($con,"select c.* from contratistas as c ");
} else {    
   $sql_contratistas=mysqli_query($con,"select c.* from contratistas as c where c.mandante='".$_SESSION['mandante']."' ");
}   


?>




<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | Reporte de Contratos</title>
     <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">

    <script src="js\jquery-3.1.1.min.js"></script>

<style>

    .estilo {
        display: inline-block;
        content: "";
        width: 25px;
        height: 25px;       
        background-size: cover;
        vertical-align: middle;
        font-size: 20px;
    }
    .estilo:checked  {
        content: "";
        width: 25px;
        height: 25px;        
        vertical-align: middle;
        font-size: 20px;
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
        
</style>


<script> 

$(document).ready(function() {

$('#menu-contratos').attr('class','active');  
        $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
        });

        $('.footable').footable();
        $('.footable2').footable();
        
          
           
            
            
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
            
});
 
 function deshabilitar_mensual(contratista,mandante,condicion){
    //alert(condicion);
    if (condicion==1) {
            swal({ 
            title: "Deshabilitar Perfil Mensual",
            text: "Deshabilitar Documentos Mensuales",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Deshabilitar",
            cancelButtonText: "No, Deshabilitar",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/addmensual.php",
                    data: 'contratista='+contratista+'&condicion='+condicion,
        			success: function(data){			  
                     if (data==2) {
                         swal({
                                title: "Perfil Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } 
                      if (data==1) {
                         swal("Error de Sistema", "Perfil no Deshabilitado. Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
                setTimeout(window.location.href='list_contratos.php', 3000);
            }
        });
    } else {
       swal({
            title: "Habilitar Perfil Existente",
            text: "Habilitar Documentos Mensuales",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Habilitar",
            cancelButtonText: "No, Habilitar",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/addmensual.php",
                    data: 'contratista='+contratista+'&condicion='+condicion,
        			success: function(data){			  
                     if (data==2) {
                         swal({
                                title: "Perfil Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } 
                      if (data==1) {
                         swal("Error de Sistema", "Perfil no Habilitado. Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
                setTimeout(window.location.href='list_contratos.php', 3000);
            }
        });
   }    
}   

 function crear_doc_mensual(cant) {
    //const doc_sel = document.querySelectorAll(".estilo2 input[type=checkbox]:checked");
    var contador=0;
    for (i=0;i<=cant-1;i++) {
        var seleccionado=document.getElementById('doc_mensuales_dm'+i);
        if (seleccionado.checked) {
           contador++;
        };
    }

    if(contador==0){
            swal({
                title: "Lista Vacia",
                text: "Debe seleccionar al menos un documento",
                type: "warning"
            });   
        
        
    } else {   
                  var habilitar=document.getElementById('mensual');
                    if(habilitar.checked) {
                        var chequeado=1;
                        //alert('chequeado');
                    } else {
                        var chequeado=0;
                        //alert('no chequeado');
                    }                                               
                    var valores=$('#frmMensualDoc').serialize();
                    $.ajax({
                        method: "POST",
                        url: "add/addmensual.php",
                        data: valores,
                        beforeSend: function(data){
                            $('#modal_cargar_procesar').modal('show');
          			}   ,
             			success: function(data){			  
                        if (data==0) {                        
                            swal({
                                title: "Documentos Mensual Creado",
                                //text: "You clicked the button!", 
                                type: "success"
                            });
                            setTimeout(window.location.href='list_contratos.php', 3000);
                        }
                        if (data==2) {                        
                            swal({
                                title: "Documentos Mensual Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            });
                            setTimeout(window.location.href='list_contratos.php', 3000);
            		     } 
                         if (data==3) {                        
                            swal({
                                title: "Documento Mensual Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            });
                            setTimeout(window.location.href='list_contratos.php', 3000);
            		      }                                                                                                                             
                          if (data==1) { 
                            swal("Error de Sistema", "Solicitud no procesada. Vuelva a Intentar.", "error");                            
               			  }
             			},
                         complete:function(data){
                            $('#modal_cargar_procesar').modal('hide');
                            
                        }, 
                        error: function(data){
                            alert('error');
                            $('#modal_cargar_procesar').modal('hide');
                        }                
                    }); 
        }
 };  


function gestion_contratos(contrato,contratista){
    $.post("sesion/sesion_gestion_contrato_mandante.php", { contrato: contrato, contratista: contratista }, function(data){
            window.location.href='gestion_contratos_mandantes.php';
        });
}

function gestion_vehiculos(contrato,contratista){
    $.post("sesion/sesion_gestion_contrato_mandante.php", { contrato: contrato, contratista: contratista }, function(data){
            window.location.href='gestion_vehiculos_mandantes.php';
        });
}

function cambiar_asignados(contrato,contratista,mandante,valor) {
  $.ajax({
        method: "POST",
        url: "sesion/session_trabajadores_asignados.php",
        data: 'contrato='+contrato+'&contratista='+contratista+'&mandante='+mandante,
        success: function(data){			  
           window.location.href='trabajadores_asignados_mandante.php';
 		}                
  });  
}

function editar_contrato(id){
        $.ajax({
			method: "POST",
            url: "sesion_contratos.php",
			data:'id='+id,
			success: function(data){
                window.location.href='edit_contrato.php';
			}
       });
}

function eliminar(id,condicion){
           //alert(id+' '+condicion);
    
            swal({
            title: "Confirmar Eliminar Contrato",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Eliminar",
            cancelButtonText: "No, Eliminar",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/eliminar.php",
                    data: 'id='+id+'&condicion='+condicion,
        			success: function(data){			  
                     if (data==0) {
                         swal({
                                title: "Contrato Eliminado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } else {
                         swal("Cancelado", "Contrato No Eliminado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
}

function accion(valor,id,accion){
        //alert(id);
        if (valor===0) {
            swal({
            title: "Confirmar deshabilitar Contrato",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Deshabilitar!",
            cancelButtonText: "No, Deshabilitar!",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Contrato Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } else {
                         swal("Cancelado", "Contrato No Deshabilitado. Vuelva a Intentar.", "error");
                         
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Contrato",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Habilitar!",
            cancelButtonText: "No, Habilitar!",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Contrato Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } else {
                         swal("Cancelado", "Contrato No Hbilitado. Vuelva a Intentar.", "error");
                         //setTimeout(refresh, 1000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } 
}

 function ver_doc(id) {
    alert(id);
 }

 function ir_crear(){
        window.location.href='crear_contrato.php';
 }
 
 function sel_doc(id) {
        var isChecked = $('#doc_mensuales_dm'+id).prop('checked');
        if (isChecked) {
            document.getElementById("doc_mensual"+id).style.fontWeight = "bold";
        } else {
            document.getElementById("doc_mensual"+id).style.fontWeight = "Normal";
        }
      }
    

</script>

</head>


  

<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
        <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">REPORTE DE CONTRATOS <?php  #echo $_SESSION['usuario'].'-'.$_SESSION['nivel'].'-'.$_SESSION['mandante'] ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                          
                          <div class="ibox-title">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background:#217346;border:1px  #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_contratos_m.php"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="crear_contrato.php"  type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contrato</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_contratistas_mandantes.php" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratistas</a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                        </div>
                        
                        
                        <div class="ibox-content">
                         <div class="row" >
                           <div class="col-lg-12"> 
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Contrato">
                             <div class="table-responsive">
                                     <table style="100%;"  class="table footable" data-page-size="25" data-filter="#filter">
                                       <thead class="cabecera_tabla">
                                        <tr style="font-size: 12px;">
                                            <th style="width: 19%;border-right:1px #fff solid" >Nombre</th>
                                            <th style="width: 19%;border-right:1px #fff solid" >Contratista</th>
                                            <th style="width: 10%;border-right:1px #fff solid" >Documento</th>
                                            <th colspan="2" style="width: 25%;text-align: center;border-right:1px #fff solid" >Trabajadores</th>
                                            <th style="width: 12%;text-align: center;border-right:1px #fff solid" >Docs.Mensual</th>
                                            <th colspan="2" style="width: 27%;text-align: center;border-right:1px #fff solid;font-size:12px" >Vehiculo/Maquinaria</th>          
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                         
                                          $sql_perfiles_c=mysqli_query($con,"select * from perfiles where id_mandante='".$_SESSION['mandante']."' and eliminar=0 and tipo='0' ");
                                          $existe_perfiles_c=mysqli_num_rows($sql_perfiles_c);

                                          $sql_perfiles_v=mysqli_query($con,"select * from perfiles where id_mandante='".$_SESSION['mandante']."' and eliminar=0 and tipo='1' ");
                                          $existe_perfiles_v=mysqli_num_rows($sql_perfiles_v);
                                            
                                          $sql_contratos=mysqli_query($con,"select o.id_contratista, o.estado, g.contrato as contrato_trab_asig, c.estado as estado_contrato, c.*, o.*, v.*, c.mensuales as mensuales_c from contratos as c Left Join contratistas o On o.id_contratista=c.contratista Left Join trabajadores_asignados as g On g.contrato=c.id_contrato left join vehiculos_asignados as v On v.contrato=c.id_contrato  where c.mandante='$mandante' and c.eliminar=0 group by c.id_contrato ");
                                          $result_contratista=mysqli_fetch_array($sql_contratos);
                                          $existe_contratos=mysqli_num_rows($sql_contratos);
                                         
                                          $i=1;                                         
                                          $cont_cargo=0;
                                          $condicion=1;

                                          if ($existe_contratos>0) {
                                          
                                                foreach ($sql_contratos as $row) {
                                                    
                                                    //$query=mysqli_query($con,"select * from perfiles_cargos where mandante=$mandante and contrato='".$row['id_contrato']."' ");
                                                    $query=mysqli_query($con,"select c.*, o.rut from contratos as c left join contratistas as o On o.id_contratista=c.contratista where c.mandante='$mandante' and c.id_contrato='".$row['id_contrato']."' ");
                                                    $result=mysqli_fetch_array($query);     
                                                    
                                                    $query_vehiculos=mysqli_query($con,"select count(*) as total from vehiculos_asignados where contrato='".$row['id_contrato']."' ");
                                                    $result_vehiculos=mysqli_fetch_array($query_vehiculos);

                                                    $perfiles=unserialize($result['perfiles']);                                         
                                                    $perfiles_v=unserialize($result['perfiles_v']);

                                                    $cargos=unserialize($result['cargos']);
                                                    $vehiculos=unserialize($result['vehiculos']);
                                                
                                                    $cont_cargo=count($cargos);                                                                            
                                                    $cont_vehiculos=count($vehiculos);


                                                    $cont_perfil=0;
                                                    $cont_perfil2=0;
                                                    
                                                    foreach ($perfiles as $row_c) {
                                                        if ($row_c!=0) {
                                                            $cont_perfil++;
                                                        } 
                                                    } 

                                                    foreach ($perfiles_v as $row_v) {
                                                        if ($row_v!=0) {
                                                            $cont_perfil2++;
                                                        }
                                                    } 
                                                    
                                                    if ($cont_cargo==$cont_perfil) {
                                                        $faltan_perfiles=TRUE;
                                                    } else {
                                                        $faltan_perfiles=FALSE;
                                                    }

                                                    if ($cont_vehiculos==$cont_perfil2) {
                                                        $faltan_perfiles_v=TRUE;
                                                    } else {
                                                        $faltan_perfiles_v=FALSE;
                                                    }
                                                    
                                                                                        
                                                    $carpeta = 'doc/temporal/'.$mandante.'/'.$row['id_contratista'].'/contrato_'.$row['id_contrato'].'/'.$row['nombre_contrato'].'.pdf';?>
                                                                                        
                                                    <tr>
                                                            <td style="font-size: 13px;"><?php echo $row['nombre_contrato'] ?></td>
                                                            
                                                            <td style="font-size: 13px;"><?php echo $row['razon_social'] ?></td>
                                                    
                                                            <?php // si existe acrhivo
                                                            if (file_exists($carpeta)) { ?>
                                                                <td><a class="text-info" title="Descargar Archivo" href="<?php echo $carpeta ?>"  style="color: blue; font-size:;" target="_blank">Contrato</a></td>
                                                            <?php 
                                                            } else { ?>
                                                                <td><label>Sin Archivo</label></td>  
                                                            <?php 
                                                            }
                                                        
                                                            // sin contrato esta habilitado    
                                                            if ($row['estado_contrato']==1) { ?>  
                                                            
                                                                    <?php ############## SECCION PERFIL DE CARGOS ###################################
                                                                    if ($existe_perfiles_c!=0 ) { 
                                                                        if ($cont_perfil!=0 ) {  
                                                                            if ($faltan_perfiles) { ?>                                                                           
                                                                                <td><button title="Perfiles Asignados" class="btn btn-success btn-xs btn-block" type="button" onclick="modal_cargos(<?php echo $row['id_contrato'] ?>,<?php echo $cont_cargo ?>)"><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>                                                                           
                                                                            <?php 
                                                                            } else { ?>                                                                         
                                                                                    <td><button title="Falta Perfiles por Asignar" class="btn btn-warning btn-xs btn-block" type="button" onclick="modal_cargos(<?php echo $row['id_contrato'] ?>,<?php echo $cont_cargo ?>)"><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>
                                                                            <?php }   
                                                                            } else { ?>                                                                        
                                                                                    <td><button title="Sin Perfiles Asigandos" class="btn btn-danger btn-xs btn-block" type="button" onclick="modal_cargos(<?php echo $row['id_contrato'] ?>,<?php echo $cont_cargo?>)"><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>
                                                                            <?php
                                                                            }                                                             
                                                                    # sino hay peerfiles    
                                                                    } else { ?>                                                                        
                                                                                    <td><button title="Sin Perfiles Creados" class="btn btn-dark btn-xs btn-block" type="button" disabled=""><strong>PERFIL</strong></button></td>                                                                        
                                                                    <?php 
                                                                    }  ?>  

                                                                        
                                                                    <?php ############## SECCION TRABAJADORES ######################################
                                                                    if (empty($row['contrato_trab_asig'])) { ?>                                                                                                                
                                                                            <!-- gestion -->     
                                                                            <td><button  title="Gestion trabajadores" class="btn btn-xs btn-dark btn-block" disabled="" ><span style="font-size: 12px;font-weight:bold">TRABAJADOR</span></button></td>
                                                                    
                                                                <?php } else { ?>                                                 
                                                                            <!-- gestion con --> 
                                                                            <td><button style="background:#5635B9;border: none;" title="Gestion trabajadores" class="btn btn-xs btn-warning btn-block" onclick="gestion_contratos(<?php echo $row['id_contrato'] ?>,<?php echo $row['id_contratista'] ?>)" ><span style="font-size: 12px;font-weight:bold">TRABAJADOR</span></button></td>
                                                                <?php } ?>

                                                                <?php
                                                                    # SECCION DOCUMENTOS MENSUALES TRABAJADORES
                                                                    if ($row['mensuales_c']==0) { ?>
                                                                            <td style="text-align:center"><input class="estilo" id="mensual" name="mensual" type="checkbox" value="1" onclick="modal_mensual(<?php echo $row['id_contratista'] ?>,<?php echo $mandante ?>,0,<?php echo $row['id_contrato'] ?>,'<?php echo $row['razon_social'] ?>','<?php echo $row['nombre_contrato'] ?>')" /></td>                                         
                                                                    <?php 
                                                                    } else { ?>
                                                                            <td style="text-align:center"><input class="estilo" id="mensual" name="mensual" type="checkbox"  checked="" disabled=""  /></td>
                                                                    <?php 
                                                                    } ?>
                                                                
                                                            
                                                                    <?php # si existen pefiles vehiculos
                                                                    if ($existe_perfiles_v!=0 ) {  
                                                                        if ($cont_perfil2!=0 ) {   
                                                                            if ($faltan_perfiles_v) { ?>
                                                                                    <td><button style="width:" title="Perfiles Asignados" class="btn btn-success btn-xs btn-block" type="button" onclick="modal_vehiculos(<?php echo $row['id_contrato'] ?>,<?php echo $cont_vehiculos?>)"><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>       
                                                                            <?php 
                                                                            } else { ?> 
                                                                                    <td><button style="width:" title="Falta Perfiles por Asignar" class="btn btn-warning btn-xs btn-block" type="button" onclick="modal_vehiculos(<?php echo $row['id_contrato'] ?>,<?php echo $cont_vehiculos?>)"><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>
                                                                            <?php }   
                                                                            } else { ?>              
                                                                                    <td><button style="width:" title="Sin Perfiles Asigandos" class="btn btn-danger btn-xs btn-block" type="button" onclick="modal_vehiculos(<?php echo $row['id_contrato'] ?>,<?php echo $cont_vehiculos?>)"><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>
                                                                            <?php 
                                                                            }        

                                                                    } else {  ?>                
                                                                                    <td><button style="width:" title="Sin Perfiles Creados" class="btn btn-dark btn-xs btn-block" type="button" disabled=""><span style="font-size: 12px;font-weight:bold"><strong>PERFIL</strong></span></button></td>
                                                                    <?php 
                                                                    }   ?>    


                                                                <?php if ($result_vehiculos['total']==0) { ?>                                                                                                                
                                                                            <!-- gestion -->     
                                                                            <td><button title="Gestion Contratos" class="btn btn-xs btn-dark btn-block" disabled="" ><span style="font-size: 12px;font-weight:bold"><strong>VEH/MAQ</strong></span></button></td>                                                               
                                                                <?php } else { ?>                                                 
                                                                            <!-- gestion con --> 
                                                                            <td><button style="width:;background:#5635B9;border: none" title="Gestion Contratos" class="btn btn-xs btn-warning btn-block" name="" id="" onclick="gestion_vehiculos(<?php echo $row['id_contrato'] ?>,<?php echo $row['id_contratista'] ?>)" ><span style="font-size: 12px;font-weight:bold">VEHIC/MAQUI</span></button></td>
                                                                <?php } ?>

                                                                <!--
                                                                <?php
                                                                    # SECCION DOCUMENTOS MENSUALES VEHICULOS
                                                                    #if ($row['mensuales_c']==0) { ?>
                                                                            <td style="text-align:center"><input class="estilo" id="mensual" name="mensual" type="checkbox" value="1" onclick="modal_mensual(<?php echo $row['id_contratista'] ?>,<?php echo $mandante ?>,0,<?php echo $row['id_contrato'] ?>,'<?php echo $row['razon_social'] ?>','<?php echo $row['nombre_contrato'] ?>')" /></td>                                         
                                                                    <?php 
                                                                    #} else { ?>
                                                                            <td style="text-align:center"><input class="estilo" id="mensual" name="mensual" type="checkbox" value="1" checked="" disabled=""  /></td>
                                                                    <?php 
                                                                    #} ?>
                                                                -->
                                                        
                                                            <?php 
                                                            # si contrato No esta habilitado  
                                                            } else { ?>
                                                                    <td><button style="" title="Perfiles Asignados" class="btn btn-dark btn-xs" type="button" disabled=""><span style="font-size: 12px;">Perfiles</span></button></td>
                                                                    <td><button style="" title="Gestion Contratos" class="btn btn-xs btn-dark" name="" id="" disabled=""><span style="font-size: 12px;"> Gestionar</span></button></td>
                                                            <?php  
                                                            } ?>    
                                                        
                                                    </tr>
                                                    
                                                    <?php
                                                    }
                                                } else { ?>
                                                    <tr colpspan="8">
                                                        <td style="font-size: 16px;">Sin contratos creados</td>
                                                    </tr>
                                                <?php
                                                }  ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="8">
                                                    <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                 </div>   
                            
                            <script>
                                 
                                 
                                 function modal_cargos(contrato,cargos) {
                                      $('.body').load('selid_perfil.php?contrato='+contrato+'&cargos='+cargos,function(){
                                          $('#modal_cargos').modal({show:true});
                                       });
                                  }

                                  function modal_vehiculos(contrato,cargos) {
                                      $('.body').load('selid_perfil_vehiculos.php?contrato='+contrato+'&cargos='+cargos,function(){
                                          $('#modal_vehiculos').modal({show:true});
                                          //$('#modal_cargos input[name=id]').val(id);
                                       });
                                  }
                                  
                                   function modal_reporte_trabajadores(contrato) {
                                      $('.body').load('selid_reporte_trabajadores.php?contrato='+contrato,function(){
                                                $('#modal_reporte_trabajadores').modal({show:true});
                                           });
                                    }
                                    
                                  function modal_mensual(contratista,mandante,condicion,contrato,nom_contratista,nom_contrato) {
                                        //alert(nom_contratista);
                                            $('#modal_doc_mensual input[name=contratista_dm]').val(contratista);
                                            $('#modal_doc_mensual input[name=mandante_dm]').val(mandante);
                                            $('#modal_doc_mensual input[name=condicion_dm]').val(condicion);
                                            $('#modal_doc_mensual input[name=contrato_dm]').val(contrato);
                                            $('#modal_doc_mensual input[name=nom_contratista]').val(nom_contratista);
                                            $('#modal_doc_mensual input[name=nom_contrato]').val(nom_contrato);
                                            $('#modal_doc_mensual').modal({show:true});
                                            
                                    }  
                                    
                            </script>
                            
                                            <div class="modal fade" id="modal_doc_mensual" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg ">
                                                    <div class="modal-content animated fadeIn">
                                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel"> Documentos Mensuales Trabajadores</h3>
                                                    <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" ><span aria-hidden="true">x</span></button>
                                                    </div>
                                                    <div class="body">
                                                    <style>
                                                            .estilo {
                                                                display: inline-block;
                                                                content: "";
                                                                width: 25px;
                                                                height: 25px;       
                                                                background-size: cover;
                                                                vertical-align: middle;
                                                                font-size: 20px;
                                                            }
                                                            .estilo:checked  {
                                                                content: "";
                                                                width: 25px;
                                                                height: 25px;        
                                                                vertical-align: middle;
                                                                font-size: 20px;
                                                            }
                                                        </style>
                                                        

                                                            <form  method="post" id="frmMensualDoc">    
                                                            <div class="modal-body">

                                                                <div class="row">
                                                                    <label  class="col-2 col-form-label"><b>Contratista:</b></label>
                                                                    <input style="border:none"  class="col-10 col-form-control" type="text" id="nom_contratista" name="nom_contratista"  >
                                                                </div>
                                                                <div class="row">
                                                                    <label  class="col-2 col-form-label"><b>Contrato:</b></label>
                                                                    <input  style="border:none" class="col-10 col-form-control" type="text" id="nom_contrato" name="nom_contrato"  >
                                                                </div>
                                                            
                                                                <div class="row" style="margin-top:2%" >
                                                                    <div class="col-12">
                                                                        <table style="overflow-y: auto;" class="table table-stripped">
                                                                            <thead style="background:#e9eafb;color:#282828">
                                                                                <tr>
                                                                                    <th style="width: ;border-right:1px #fff solid">Documento</th>
                                                                                    <th class="text-rigth" style="width: ;text-align:center">Seleccionar</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody> 
                                                                                <?php $i=0; 
                                                                                    $query=mysqli_query($con,"select * from doc_mensuales "); 
                                                                                    foreach ($query as $row) { ?>
                                                                                    <tr>
                                                                                        
                                                                                        <td><label id="doc_mensual<?php echo $i ?>" class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                                                                        <td style="text-align:center"><input class="estilo" id="doc_mensuales_dm<?php echo $i ?>" name="doc_mensuales_dm[]" type="checkbox" value="<?php echo $row['id_dm'] ?>" onclick="sel_doc(<?php echo $i ?>)" /></td>
                                                                                    </tr>
                                                                                <?php $i++; } ?>
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        <!--<div class="row">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                                                                <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" >Documentos faltantes enviar a <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                                                            </div>
                                                                        </div>   -->
                                                                        
                                                                    </div>   
                                                                </div>                                                  
                                                            </div>
                                                            
                                                                                                    
                                                            <div class="modal-footer">
                                                            <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" >Documentos faltantes enviar a <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                                                <button class="btn btn-secondary btn-sm" title="Cerrar Ventana" data-dismiss="modal"  >Cancelar </button>
                                                                <button class="btn btn-success btn-sm" type="button" onclick="crear_doc_mensual(<?php echo $i ?>)" >Enviar Solicitud</button>  
                                                            </div> 
                                                            
                                                            <input type="hidden" id="contratista_dm" name="contratista_dm"  />
                                                            <input type="hidden" id="mandante_dm" name="mandante_dm" />
                                                            <input type="hidden" id="condicion_dm" name="condicion_dm" />
                                                            <input type="hidden" id="contrato_dm" name="contrato_dm"  />
                                                                
                                                            </form>
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
            

            
            
            <div class="footer">
                <div class="float-right">
                    Versi&oacute;n <strong>1.0</strong>
                </div>
                <div>
                    <strong>Copyright</strong> FacilControl &copy; <?php echo $year ?>
                </div>
            </div>

        </div>
        </div>
                        

                        <div class="modal inmodal" id="modal_cargos" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content animated fadeIn">
                                     <div style="background:#e9eafb;color:#282828" class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 class="modal-title">Asignar Perfil a Cargos del Contrato</h4>
                                        </div>
                                    <div class="body">
                                       <div class="body">
                                     
                                           
                                      </div>                                              
                                </div>  
                            </div>
                        </div> 

                        <div class="modal inmodal" id="modal_vehiculos" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content animated fadeIn">                                    
                                    <div style="background:#e9eafb;color:#282828" class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 class="modal-title">Asignar Perfil a Vehículos del Contrato</h4>
                                        </div>
                                    <div class="body">
                                    </div>                                              
                                </div>  
                            </div>
                        </div> 
                        
                         <div class="modal fade" id="modal_reporte_trabajadores" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg ">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                            <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-align-justify" aria-hidden="true"></i> Trabajadores del Contrato</h3>
                                            <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="body">
                                     
                                        </div>

                                        <div class="modal-footer">
                                         <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</a>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                         <div class="modal fade" id="modal_cargar_perfiles" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Enviando solicitud, por favor espere un momento</h3>
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
    

    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script><!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
  


</body>
</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
