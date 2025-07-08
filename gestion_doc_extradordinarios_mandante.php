<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and  $_SESSION['nivel']==2  ) { 
include('config/config.php');


$_SESSION['active']="list_contratistas";

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];

$contratistas=mysqli_query($con,"select m.acreditada, c.* from contratistas as c LEFT JOIN contratistas_mandantes as m ON m.contratista=id_contratista where m.mandante='".$_SESSION['mandante']."' and m.contratista='$contratista'  ");
$result_contratista=mysqli_fetch_array($contratistas);
$num_c=mysqli_num_rows($contratistas);

$query_doc=mysqli_query($con,"select  d.estado as estado_doc, d.*, c.* from documentos_extras as d left join contratistas as c On c.id_contratista=d.contratista where d.contratista='$contratista' and  d.mandante='".$_SESSION['mandante']."' and d.tipo=1 and d.estado!='3' ");
$result_doc=mysqli_fetch_array($query_doc); 
$cantidad_de=mysqli_num_rows($query_doc);

$query_obs=mysqli_query($con,"select * from doc_comentarios_extra where mandante='$mandante' and contratista='$contratista' and leer_contratista=0 ");
$result_obs=mysqli_fetch_array($query_obs);
?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Gestion Documentos Extraordinarios</title>
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
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<link rel="stylesheet" href="loader.css">

    
<script>

function selcontratista(id,mandanate){
    //alert(id); 
    if (id==0) {
        swal({
            title: "Selecciona una Contratista a consultar",
            //text: "Un Documento no validado esta sin comentario",
            type: "warning"
         });  
    } else {
        $.post("sesion/doc_contratos.php", { id: id }, function(data){
            window.location.href='gestion_doc_extradordinarios_mandante.php';
        }); 
    }    
} 

 function deshabilitar(i) {
        var isChecked = $('#verificar_doc'+i).prop('checked');
        if  (isChecked) {
             //document.getElementById("mensaje"+i).value ="";
            //document.getElementById("mensaje"+i).disabled = true;
             $("#mensaje"+i).attr("readonly","readonly");
        } else {
            //document.getElementById("mensaje"+i).disabled = false;
            $("#mensaje"+i).removeAttr("readonly");
        }    
 }
 
function deshabilitar_m(i) {
        var isChecked = $('#verificar_doc_m'+i).prop('checked');
        if  (isChecked) {
             $("#mensaje_m"+i).attr("readonly","readonly");
        } else {
            $("#mensaje_m"+i).removeAttr("readonly");
        }    
 }
       
 function enviar(total) {
        var control=$('#control').val();
        var arreglo=[];
        var arreglo2=[];
        var arreglo3=[];
        var arreglo4=[];
        var arreglo_doc=[];
        var falta_revisar=false;
        var no_chequeado=0;
        var mensaje=0;
        var acreditada=$('#acreditada').val();
        var cant_trab_acre=$('#cant_trab_acre').val();
        
        //alert(acreditada);
        
        for (i=0;i<=total-1;i++) {
            //si verificado esta seleccionado
            var isChecked = $('#verificar_doc'+i).prop('checked');
            if (isChecked) {
                var valor=document.getElementById("verificar_doc"+i).value = "1";
                var valor2=$('#mensaje'+i).val();
                arreglo.push(valor);
                arreglo2.push(valor2);
                
                var valor3=$('#doc'+i).val();
                arreglo3.push(valor3); 
                
                if (valor2!='') {
                    mensaje++;
                }
            } else {
                var valor=document.getElementById("verificar_doc"+i).value = "0";
                var valor2=$('#mensaje'+i).val();
                var isDisabled = $('#verificar_doc'+i).prop('disabled');
                //if (valor==0 && valor2=="" && isDisabled==false) {
                if (valor==0) {
                    var falta_revisar=true;
                }
                var valor3=$('#doc'+i).val();
                arreglo3.push(valor3); 
                
                arreglo.push(valor);
                arreglo2.push(valor2);
            
                no_chequeado++;
                
                if (valor2!='') {
                    mensaje++;
                }
            }

            var valor_trabajadores=$('#trabajadores'+i).val();
            arreglo4.push(valor_trabajadores);
        }
        
        if (no_chequeado==total && mensaje==0) { 
            swal({ 
                title:"Seleccionar al menos un Documentos o Enviar una nueva Observacion.",
                //text: "Debe selecionar al menos un documento",
                type: "warning"
            });          
        
        } else {    
               var existe_acreditado=false;
               var existe_sin_obs=false;
               for (i=0;i<=total-1;i++) {
                    //si verificado esta seleccionado
                    var isChecked = $('#verificar_doc'+i).prop('checked');
                    if (isChecked) {
                        var v1=document.getElementById("verificar_doc"+i).value = "1";
                        var v2=$('#mensaje'+i).val();
                        if (v2=='Acreditado') {
                           existe_acreditado=true; 
                        }
                        
                    } else {
                        var v1=document.getElementById("verificar_doc"+i).value = "0";
                        var v2=$('#mensaje'+i).val();
                        if (v2=='') {
                           existe_sin_obs=true; 
                        }
                    }
                } 
                
                if (existe_acreditado && existe_sin_obs ) {
                    swal({ 
                        title:"Seleccionar al menos un Documentos o Enviar una nueva Observacion.",
                        //text: "Debe selecionar al menos un documento",
                        type: "warning"
                    }); 
                
                } else {    
                    
                    // si contratista esta acreditada
                    if (acreditada==1) {
                        
                        var formData = new FormData();  
                                 
                        var json=JSON.stringify(arreglo);
                        formData.append('verificado', json );
                        
                        var json2=JSON.stringify(arreglo2);
                        formData.append('obs', json2 );
                        
                        var json3=JSON.stringify(arreglo3);
                        formData.append('doc', json3 );

                        var json4=JSON.stringify(arreglo4);
                        formData.append('trabajadores', json4 );

                        //var json4=JSON.stringify(arreglo_est);
                        //formData.append('data4', json4 );

                        formData.append('cant_trab_acre', cant_trab_acre );
                       
                        //alert(json4); 
                        
                        $.ajax({
              			    method: "POST",
                            url: "enviar_observacion_doc_extra.php", 
                 		    type: 'post',
                            data:formData,
                            contentType: false,
                            processData: false, 
                  			beforeSend: function(data){
                                $('#modal_cargar_procesar').modal('show');
                  			},
                  			success: function(data) {                        
                                 //alert(data);
                                 $('#modal_cargar_procesar').modal('hide');
                                 if (data==0) {
                                        swal({
                                            title: "Documentos Procesados.",
                                            //text: "Documentos sin validar",
                                            type: "warning"
                                        });
                                        window.location.href='gestion_doc_extradordinarios_mandante.php';           
                                 }
                                 if (data==3) {
                                        swal({
                                            title: "Documentos Procesados.",
                                            //text: "Documentos sin validar",
                                            type: "warning"
                                        });
                                        window.location.href='gestion_doc_extradordinarios_mandante.php';           
                                 } 
                                 if (data==1) {
                                      swal({ 
                                            title: "Error de Sistema",
                                            text: "Por favor Vuelva a intentar",
                                            type: "error"
                                       });
                                 }
                                 if (data==2) {
                                        swal({
                                            title: "Observacion Enviada.",
                                            //text: "Documentos sin validar",
                                            type: "success"
                                        });
                                        window.location.href='gestion_doc_extradordinarios_mandante.php';           
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

                       
                    
                  }  else {
                        swal({
                            title: "Contratista no Acreditada.",
                            text: "No se puede acreditar documento",
                            type: "warning"
                        });
                    
                  }
               }     
          } 
   }
      
    
      
   function poner_cero(id){
      $("#verificar_doc"+id).prop('checked', true);
      document.getElementById("verificar_doc"+id).value = "0";
      
   }      
   
   $(document).ready(function() {

            $('#menu-doc-extras').attr('class','active');
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

</script>

   <style>
        .estilo {
            display: inline-block;
        	content: "";
        	width: 15px;
        	height: 15px;
        	margin: 0.5em 0.5em 0 0;
            background-size: cover;
        }
        .estilo:checked  {
        	content: "";
        	width: 15px;
        	height: 15px;
        	margin: 0.5em 0.5em 0 0;
        }
        
        input[type=checkbox]
        {
          /* Doble-tama�o Checkboxes */
          -ms-transform: scale(2); /* IE */
          -moz-transform: scale(2); /* FF */
          -webkit-transform: scale(2); /* Safari y Chrome */
          -o-transform: scale(2); /* Opera */
          padding: 10px;
        }
        
        /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificaci�n */
        .checkboxtexto
        {
          /* Checkbox texto */
          font-size: 80%;
          display: inline;
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
    
    </style>

</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Documentos Extraordinarios <?php    ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
        
        
               
               
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                         <div class="ibox-title">
                            <div class="form-group row">
                               <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                    <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Gestión de Contratos</a>
                                    <a class="btn btn-sm btn-success btn-submenu" href="crear_doc_extra.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Documentos Extraordinarios</a>                                       
                                 </div>
                              </div>   
                            </div>   
                            <?php include('resumen.php') ?>                        
                        
                        <div class="ibox-content">
                       
                            <div class="row">
                              <div class="col-12">
                                
                                <!-- select de contratistas --> 
                                <div style="border-bottom:2px solid #fff;" class="row">                                                                    
                                    <label style="background:#e9eafb;color:#282828;font-weight:bold"   class="col-2 col-form-label"><b>Contratista</b></label>
                                    <div style="font-weight:bold" class="col-4">   
                                       <?php 
                                          
                                          if ($num_c>1) { ?>
                                            <select style="border:1px solid #969696" name="contratista" id="contratista" class="form-control m-b"  onchange="selcontratista(this.value)">
                                                <?php                                           
                                                    if ($contratista=="") {
                                                        #echo '<option value="0" selected="" >'.$result_contratista['razon_social'].'</option>';
                                                        echo '<option value="0" >Seleccionar Contratista</option>';
                                                    } else {
                                                        $query=mysqli_query($con,"select * from contratistas where id_contratista='".$contratista."' ");
                                                        $result=mysqli_fetch_array($query);
                                                        echo '<option value="" selected="" >'.$result['razon_social'].'</option>';
                                                        echo '<option value="0" >Seleccionar Contratista</option>';
                                                    }                                           
                                                    foreach ($contratistas as $row) {
                                                        echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                    }                                                
                                            } else {  ?>                                            
                                                <label   class="col-form-label"><?php echo $result_doc['razon_social']  ?></label>  
                                            
                                      <?php }   ?>                                           
                                            </select>
                                    </div> 
                                </div>   
                                                          
                                 <?php                                           
                                    if ($contratista!="") { ?>                                     
                                    <div class="row">
                                        <label style="background:#e9eafb;color:#282828;font-weight:bold"   class="col-2 col-form-label"><b> RUT </b></label>
                                        <div style="font-weight:bold" class="col-4">
                                            <label class="col-form-label "><?php echo $result_doc['rut']?></label>
                                        </div>
                                    </div>                                    
                                   
                                <?php } ?>
                              
                                 
                                 
                                 <div style="margin-top: 2%;" class="row"> 
                                    <div class="col-12">                       
                                                   <form  method="post" id="frmObs">                   
                                                         <div class="row">                            
                                                                <!--<input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                                                              <div class="table table-responsive">  
                                                                <table class="table table-stripped">
                                                                   <thead style="background:#e9eafb;color:#282828;font-weight:bold">
                                                                    <tr>
                                                                       
                                                                        <th style="width: 45%;border-right:1px #fff solid">Documentos para Revisi&oacute;n</th>
                                                                        <th style="width: 35%;border-right:1px #fff solid">Observaciones</th>
                                                                        <th style="width: 5%;text-align: center;border-right:1px #fff solid">Acreditar</th>                                                                        
                                                                        <th style="width: 15%;text-align: center;">Estado</th>
                                                                        
                                                                    </tr>
                                                                    </thead>
                                                                    
                                                                   <tbody>
                                                                    
                                                                    <?php  
                                                                     if ($cantidad_de!=0) {
                                                                        
                                                                         $i=0; 
                                                                         $cont_veri=0;
                                                                         $cont_doc=0;
                                                                          $estado=array();
                                                                          
                                                                         foreach ($query_doc as $row) {
                                                                            
                                                                            # numero de trabajadores asignados por contrato
                                                                            $query_cant_de=mysqli_query($con,"select count(*) as num_tra_asig from trabajadores_asignados where contrato='".$row['contrato']."' ");
                                                                            $result_cant_de=mysqli_fetch_array($query_cant_de);
                                                                            
                                                                            # numero de trabajadores acreditados por contrato
                                                                            $query_cant_de_a=mysqli_query($con,"select count(*) as num_tra_acre from trabajadores_acreditados where contrato='".$row['contrato']."' ");
                                                                            $result_cant_de_a=mysqli_fetch_array($query_cant_de_a);
                                                                            
                                                                            if ($result_cant_de['num_tra_asig']==$result_cant_de_a['num_tra_acre']) {
                                                                                $cant_tra_acre=1;
                                                                            } ELSE {
                                                                                $cant_tra_acre=0;
                                                                            }
                                                                            
                                                                            $query_com=mysqli_query($con,"select * from doc_comentarios_extra where id_doc='".$row['id_de']."' and documento='".$row['documento']."' and estado=0 order by id_dcome desc ");
                                                                            $result_com=mysqli_fetch_array($query_com);
                                                                            
                                                                            switch ($row['tipo']) {
                                                                                case 1: $tipo='Empresa';break;
                                                                                case 2: $tipo='Trabajadores';break;
                                                                                case 3: $tipo='Trabajadores';break;
                                                                            }
                                                                            
                                                                                # tipo de documento extra
                                                                                # empresa
                                                                                if ($row['tipo']==1) {
                                                                                    $query_consulta=mysqli_query($con,"select * from contratistas where id_contratista='".$row['contratista']."' ");
                                                                                    $result_consulta=mysqli_fetch_array($query_consulta);
                                                                                    $nombre=$result_consulta['razon_social']; 
                                                                                    $rut=$result_consulta['rut'];

                                                                                    if ($row['estado_doc']==3) {
                                                                                        $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf';
                                                                                    } else {
                                                                                        $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf';
                                                                                    };
                                                                                }                                                                   

                                                                                # todos los trabajadores de un contrato    
                                                                                if ($row['tipo']==2 or $row['tipo']==3 ) {
                                                                                    $query_consulta=mysqli_query($con,"select t.rut, t.nombre1, t.apellido1, a.codigo from trabajador as t Left Join trabajadores_acreditados as a On a.trabajador=t.idtrabajador where t.idtrabajador='".$row['trabajador']."' and contrato='".$row['contrato']."' ");
                                                                                    $result_consulta=mysqli_fetch_array($query_consulta);
                                                                                    $nombre=$result_consulta['nombre1'].' '.$result_consulta['apellido1']; 
                                                                                    $rut=$result_consulta['rut'];

                                                                                    if ($row['estado_doc']==3) {
                                                                                        $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$row['contrato'].'/'.$result_consulta['rut'].'/'.$result_consulta['codigo'].'/'.$row['documento'].'_'.$result_consulta['rut'].'.pdf';
                                                                                    } else {
                                                                                        $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$row['contrato'].'/'.$result_consulta['rut'].'/'.$result_consulta['codigo'].'/'.$row['documento'].'_'.$result_consulta['rut'].'.pdf';
                                                                                    }; 
                                                                                }  

                                                                            $query_noaplica=mysqli_query($con,"select * from noaplica where extra='".$row['documento']."' ");
                                                                            $resul_noaplica=mysqli_num_rows($query_noaplica);    
                                                                            
                                                                            $archivo_existe=file_exists($carpeta);
                                                                             
                                                                             # si el archivo existe
                                                                             if ($archivo_existe) {   ?>
                                                                             
                                                                             <tr>
                                                                                
                                                                                <?php if ($resul_noaplica>0) { ?>
                                                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?> <small><label style="border-radius:5px" class="badge-primary">&nbsp;NO APLICA&nbsp;</label><small></a></td>
                                                                                <?php } else { ?>
                                                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>
                                                                                <?php } ?>


                                                                                <input type="hidden" id="doc<?php echo $i ?>" name="doc[]" value="<?php echo $row['id_de'] ?>" />

                                                                                <td>
                                                                                    <div class="btn-group"> 
                                                                                            <textarea style="border:1px solid #969696" cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ><?php echo $result_com['comentarios'] ?></textarea>
                                                                                            <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row['id_de'] ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                    </div>
                                                                                </td>
                                                                                                                                                             
                                                                                <?php     
                                                                                    if ($row['tipo']==1) {
                                                                                        if ($result_contratista['acreditada']==1) { ?>
                                                                                           <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo $i ?>) "  /></td>
                                                                                <?php   } else { ?>
                                                                                           <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo $i ?>) " disabled="" title="Contratista No Acreditada" /></td> 
                                                                                
                                                                                <?php } 
                                                                                           
                                                                                     } else {    
                                                                                          # si trabajadores estan acreditados
                                                                                            if ( $cant_tra_acre==1) { ?>
                                                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo $i ?>) "  /></td>
                                                                                <?php       } else { ?>
                                                                                                <td style="text-align: center;"><input title="Trabajadores del Contrato sin Acreditar" class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo $i ?>) "   /></td>
                                                                                 <?php      } 
                                                                                      }?>
                                                                                
                                                                                    
                                                                                    
                                                                                    
                                                                                
                                                                                    <td style="text-align:center">
                                                                                        <?php if ($row['estado_doc']==0) { ?>
                                                                                            <div style="font-size: 14px;" class="bg-danger p-xxs "><b>NO ENVIADO</b></div>
                                                                                         <?php } ?>
                                                                                        
                                                                                        <?php if ($row['estado_doc']==1) { ?>
                                                                                            <div style="font-size: 14px;" class="bg-warning p-xxs "><b>EN PROCESO</b></div>
                                                                                        <?php } ?>
                                                                                        
                                                                                        <?php if ($row['estado_doc']==2) { ?>
                                                                                            <div style="font-size: 14px;" class="bg-warning p-xxs "><b>EN PROCESO</b></div>
                                                                                        <?php } ?>
                                                                                        
                                                                                        <?php if ($row['estado_doc']==3) { ?>
                                                                                            <div style="font-size: 14px;" class="bg-success p-xxs "><b>VALIDADO</b></div>
                                                                                        <?php } ?>
                                                                                     </td>   
                                                                                  
                                                                            <?php # si archi no existe       
                                                                             } else { 
                                                                                    $estado='1';?>
                                                                                        
                                                                                        <td style=""><?php echo $row['documento'] ?></td>
                                                                                        <td>
                                                                                            <div class="btn-group"> 
                                                                                                <textarea style="border:1px solid #969696" cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" disabled=""></textarea>
                                                                                                <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td style="text-align: center;"><input class="estilo" name="verificar[]" id="verificar_doc<?php echo $i ?>" type="checkbox" disabled=""/></td>
                                                                                        
                                                                                        <td style="text-align:center;"><div style="font-size: 14px;" class="bg-danger p-xxs "><b>NO ENVIADO</b></div></td>              
                                                                                   
                                                                               <?php $cont_doc=$cont_doc+1;                                                                                   
                                                                             }  ?>  
                                                                           </tr>
                                                                             
                                                                   <?php   
                                                                        echo '<input type="hidden" name="estado[]" id="estado'.$i.'" value="'.$estado.'" />';
                                                                        echo '<input type="hidden" name="trabajadores[]" id="trabajadores'.$i.'" value="'.$row['trabajador'].'" />';
                                                                        echo '<input type="hidden" name="cant_tra_acre[]" id="cant_tra_acre'.$i.'" value="'.$result_cant_de_a['num_tra_acre'].'" />';
                                                                        $i++; 
                                                                         }
                                                                         
                                                                      if ($cont_doc==$i) {
                                                                        $sin_archivos=true;
                                                                      } else {
                                                                        $sin_archivos=false;
                                                                      }
                                                                      
                                                                    } else { ?>
                                                                        
                                                                        <tr>
                                                                            <td colspan="5"><strong>Sin Documentos Extras</strong> </td>
                                                                        </tr>
                                                                    
                                                                    <?php } ?>
                                                                      
                                                                  </tbody>
                                                               </table>  
                                                              </div>   
                                                             </div>
                                                           <input type="hidden" id="control" value="<?php echo $result_obs['control'] ?>" /> 
                                                           <input type="hidden" id="acreditada" value="<?php echo $result_contratista['acreditada'] ?>" />
                                                           <input type="hidden" id="cant_trab_acre" value="<?php echo $result_cant_de_a['num_tra_acre'] ?>" />
                                                            <?php if ($cantidad_de!=0) { ?>
                                                                <div style="border:1px #c0c0c0 solid;padding: 0.5% 0%" class="row">
                                                                    <div class="col-4">
                                                                        <button style="font-size:16px" id="btnenviar" class="btn btn-md btn-success btn-block font-bold" type="button" onclick="enviar(<?php echo $i ?>)" >PROCESAR DOCUMENTOS <?php #echo $result_contratista['acreditada'] ?> </button>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
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
                 
                 
                                                        <script>
                                                               function modal_ver_obs(id) {
                                                                     //alert(id);
                                                                    $('.body').load('selid_ver_obs_doc_extra.php?doc='+id,function(){
                                                                                $('#modal_ver_obs').modal({show:true});
                                                                    });
                                                                }

                                                        </script> 
                                                        
                                                        <div class="modal fade" id="modal_ver_obs" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                                  <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Historial de Observaciones</h3>
                                                                  <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                  </button>
                                                                </div>
                                                                        <div class="body">
                                                                         
                                                                              
                                                                        </div>                                    
                                                               </div>
                                                            </div>
                                                        </div>  
                                                        
                                                        <!-- modal cargando--->
                                                        <div class="modal fade" id="modal_cargar_procesar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-body text-center">
                                                                <div class="loader"></div>
                                                                  <h3>Procesando documentos, por favor espere un momento</h3>
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
    
       <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>



</body>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
