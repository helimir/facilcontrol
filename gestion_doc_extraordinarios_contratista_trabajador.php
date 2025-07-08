<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and  $_SESSION['nivel']==3 ) { 
include('config/config.php');


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];
$contrato=$_SESSION['contrato'];

$query_doc=mysqli_query($con,"select d.estado as estado_doc, c.rut, d.* from documentos_extras as d LEFT JOIN contratistas as c On c.id_contratista=d.contratista where d.contratista='$contratista' and d.mandante='".$_SESSION['mandante']."' and d.estado!='3' ");
$result_doc=mysqli_fetch_array($query_doc); 
$cantidad_de=mysqli_num_rows($query_doc);

$query_contratos=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
$result_contratos=mysqli_fetch_array($query_contratos);

if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
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
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    

    <title>FacilControl | Gesión Documentos Extraordinarios</title>
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

  function selmandante(id){
    //alert(id); 
    if (id==0) {
         swal({
            title: "Selecciona un Mandante a consultar",
            //text: "Un Documento no validado esta sin comentario",
            type: "warning"
         });  
    } else {
        $.post("sesion/doc_contratistas_mandantes.php", { id: id }, function(data){
            window.location.href='gestion_doc_extraordinarios_contratista.php';
        });
    }     
}   

    
 $(document).ready(function (){
       

    $("#modal_no_aplica").on('hidden.bs.modal', function () {        
            var num=$("#num_na").val();        
            $("#aplica"+num).prop("checked", false);
            //window.location.href='gestion_documentos.php';
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


    /**$("#frmDocContratista").on('submit', function(e){
    //    e.preventDefault();
    //    alert('p');
    //    $.ajax({
    //        type: 'POST',
    //        url: 'cargar_documentos_contratistas.php',
            data: new FormData(this),
                                beforeSend: function(){
                                    $('#modal_cargar').modal('show');						
                    			},
                    			complete:function(data){
                                    $('#modal_cargar').modal('hide');	
                                     swal({
                                            title: "Documento Enviado",
                                            //text: "Un Documento no validado esta sin comentario",
                                            type: "success"
                                          });
                     	             window.location.href='gestion_documentos.php';
                                }, 
                                success: function(data) {
                                },
                                error: function(data){
                                }
        });
     });**/ 
    
   
    });   

    function cargar_simultaneo_extra(contrato,total){ 
          var fileInput = document.getElementById('carga_doc_simultaneo');
          var filePath = fileInput.files.length;
          var num=0;
          if (filePath>0) {

         
        } else {
         swal({
            title: "Sin Documento(s) Adjuntados",
            text: "Debe adjuntar al menos un Documento",
            type: "warning"
         });
      }  
               
    }

   
    function cargar_doc_extra(total,mandante,tipo,doc,trabajador,contrato){
          var arreglo_trabajadores=[];
          var fileInput = document.getElementById('carga_doc_simultaneo');
          var filePath = fileInput.files.length;
          var num=0;
          if (filePath>0) {

                    var formData = new FormData();
                        
                    var files= $('#carga_doc_simultaneo')[0].files[0]; 
                    formData.append('archivo',files);
                    formData.append('cant', total );
                    formData.append('mandante', mandante );
                    formData.append('tipo', tipo );
                    formData.append('doc', doc );
                    formData.append('trabajador', trabajador );
                    formData.append('contrato', contrato );

                    $.ajax({
                        url: 'cargar/cargar_documentos_contratistas_extra.php',
                        type: 'post',
                        data:formData,
                        contentType: false,
                        processData: false,                                
                        beforeSend: function(){
                            $('#modal_cargar').modal('show');						
                        },
                        success: function(data) {
                        if(data== 0){
                            $('#modal_cargar').modal('hide');
                            swal({
                                title: "Documento Enviado",
                                //text: "Un Documento no validado esta sin comentario",
                                type: "success"
                            });
                            window.location.href='gestion_doc_extraordinarios_contratista_contrato.php';
                        } else {
                            $('#modal_cargar').modal('hide');  
                            swal({
                                title: "Documeto No Cargado",
                                text: "Vuelva a intetar",
                                type: "error"
                            });  
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
            title: "Sin Documento(s) Adjuntados",
            text: "Debe adjuntar al menos un Documento",
            type: "warning"
         });
      }                 
                    
    }


    function cerrar_no_aplica() {
        var num=$("#num_na").val();        
        $("#modal_no_aplica").modal('hide');
        $("#aplica"+num).prop("checked", false);
    }

    function guardar_no_aplica(mandante) {        
      var doc=$("#doc_na").val();  
      var contratista=$("#contratista_na").val();    
      var mensaje_nax=$("#mensaje_na").val(); 
      var documento=$("#documento_na").val(); 
      var tipo=$("#tipo_na").val();       
      var trabajador=$("#trabajador_na").val(); 
      var contrato=$("#contrato_na").val(); 
     
      if (mensaje_nax=='') {
            swal({
               title: "Debe ingresar un mensaje",
               //text: "Un Documento no validado esta sin comentario",
               type: "warning"
            })
      } else {         
         $.ajax({
            method: "POST",
            url: "add/addnoaplica_extra.php",
            data:'contratista='+contratista+'&doc='+doc+'&mensaje='+mensaje_nax+'&mandante='+mandante+'&documento='+documento+'&tipo='+tipo+'&trabajador='+trabajador+'&contrato='+contrato, 
            success: function(data){
                  if (data==0) {
                        swal({
                            title: "Documento Enviado",
                            //text: "Un Documento no validado esta sin comentario",
                            type: "success"
                        });

                        $("#modal_no_aplica").modal('hide');
                        $("#modal_no_aplica").on('hidden.bs.modal', function () {   
                            $("#aplica"+num).prop("checked", true);
                        });

                        setTimeout(() => {
                            window.location.href='gestion_doc_extraordinarios_contratista_contrato.php';
                        }, 1000);
                        
                  } else {
                    swal({
                        title: "Disculpe, Error de Sistema",
                        text: "Vuelva a Intentar",
                        type: "warning"
                    })
                  }
            }   
         });
      }
   }  
   

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
              <h2 style="color: #010829;font-weight: bold;">Documentos Extraordinarios Trabajadores <?php  ?></h2>
              <label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>     
          </div>
       </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
            <!--<form id="frmDocContratista" enctype="multipart/form-data">   -->
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                             <div class="ibox-title">
                                 <div class="form-group row">
                                   <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                           <a class="btn btn-sm btn-success btn-submenu"  href="list_contratos_contratistas.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                           <a class="btn btn-sm btn-success btn-submenu"  href="gestion_contratos_contratistas.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Gesti&oacute;n de Contratos</a>
                                           <!--<button class="ladda-button ladda-button-demo btn btn-primary" data-style="zoom-in">Submit</button>-->
                                     </div>
                                  </div>
                                  <?php include('resumen.php') ?>
                                  
                             </div> 
                        
                        
                        <div class="ibox-content">
                        
                        <?php 
                            # contratistas con multiple mandantes
                            if ($_SESSION['multiple']==1 ) {  ?>     
                                <!-- select de contratistas --> 
                                <div class="row">                                                                    
                                    <label class="col-1 col-form-label"><b>Mandantes </b></label>
                                    <div style="text-align: right;" class="col-6">   
                                        <select name="contratista" id="contratista" class="form-control m-b"  onchange="selmandante(this.value)">
                                            <?php                                           
                                                
                                                $mandantes=mysqli_query($con,"select d.mandante, m.razon_social from contratistas_mandantes as d LEFT JOIN mandantes as m On m.id_mandante=d.mandante where contratista='".$_SESSION['contratista']."' ");
                                                                                              
                                                if ($_SESSION['mandante']=="") {
                                                    echo '<option value="0" selected="" >Seleccionar Mandante</option>';
                                                } else {
                                                    $query=mysqli_query($con,"select razon_social,id_mandante from mandantes where id_mandante='".$_SESSION['mandante']."' ");
                                                    $result=mysqli_fetch_array($query);
                                                    echo '<option value="'.$result['id_mandante'].'" selected="" >'.$result['razon_social'].'</option>';
                                                    echo '<option value="0" >Seleccionar Mandante</option>';
                                                }                                           
                                                foreach ($mandantes as $row) {
                                                    echo '<option value="'.$row['mandante'].'" >'.$row['razon_social'].'</option>';
                                                }                                                
                                            ?>                                           
                                        </select>
                                    </div> 
                                </div>
                        <?php 
                            # contratista con un solo mandante
                            } else { 
                                $query=mysqli_query($con,"select razon_social,id_mandante from mandantes where id_mandante='".$_SESSION['mandante']."' ");
                                $result=mysqli_fetch_array($query); 
                                ?>
                        
                                <div class="row">                                                                    
                                    <label style="background:#BFC6D4;color:#282828;font-weight:bold;border-bottom:2px solid #fff"  class="col-1 col-form-label">Mandante</label>
                                        <div style="background:#eee;;font-weight:boldfont-weight:bold;border-bottom:2px solid #fff" class="col-4">                                             
                                            <label class="col-form-label"><?php echo $result['razon_social'] ?></label>
                                        </div>
                                </div>
                                <!--<div class="row">                                                                    
                                    <label  class="col-1 col-form-label"><b>Estado: </b></label>
                                    <?php if ($acreditada==1) { ?> 
                                        <p style="margin-top: 0.5%;margin-left: 1%;"><span class="badge badge-success">Acreditada</span></p>
                                    <?php } else { ?>
                                        <p style="margin-top: 0.5%;margin-left: 1%;"><span class="badge badge-danger">No Acreditada</span></p>   
                                    <?php }  ?>
                                 </div> -->
                                 
                                 
                                 
                          <?php } ?>      
                        
                         <div class="row">                                                                    
                            <label style="background:#BFC6D4;color:#282828;font-weight:bold;bold;border-bottom:2px solid #fff"  class="col-1 col-form-label">Contrato</label>
                                <div style="background:#eee;;font-weight:bold;bold;border-bottom:2px solid #fff" class="col-4">                                             
                                    <label class="col-form-label"><?php echo $result_contratos['nombre_contrato'] ?></label>
                               </div>
                         </div>

                        
                         <div style="margin-top: 3%;" class="row">  
                             <div class="table table-responsive">
                                <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                   <thead style="background:#010829;color:#fff">
                                    <tr>                                        
                                        
                                        
                                        <th style="width: 20%;border-right:1px #fff solid">Documento</th>
                                        <th style="width: 15%;border-right:1px #fff solid">Trabajador</th>
                                        <th style="width: 10%;border-right:1px #fff solid">RUT</th>
                                        <th style="width: 20%;border-right:1px #fff solid">Observaciones</th> 
                                        <th style="width: 15%;text-align: center;border-right:1px #fff solid">Adjuntar</th>
                                        <th style="width: 5%;text-align: center;border-right:1px #fff solid">N/A</th>
                                        <th style="width: 15%;text-align: center;border-right:1px #fff solid">Estado</th>
                                        
                                    </tr>
                                    </thead>
                                    
                                   <tbody>
                                    
                                    <?php  

                                    $query_obs=mysqli_query($con,"select * from doc_observaciones_extra where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
                                    $result_obs=mysqli_fetch_array($query_obs);
                                    $list_veri=unserialize($result_obs['verificados']);
                                    
                                    if ($cantidad_de!=0) {
                                     
                                     if ($_SESSION['mandante']!=0 ) {    
                                         
                                         $i=0; 
                                         $cont_veri=0;
                                         $comentario=array();
                                         $cadena=array();
                                         $estado=array();
                                         
                                         foreach ($query_doc  as $row) {
                                          
                                          #if ($row['estado_doc']!=3) {
                                            
                                            $query_com=mysqli_query($con,"select * from doc_comentarios_extra where id_doc='".$row['id_de']."' and documento='".$row['documento']."' and estado=0 order by id_dcome desc ");
                                            $result_com=mysqli_fetch_array($query_com);

                                            $query_noaplica=mysqli_query($con,"select * from noaplica where documento='".$row['id_de']."' and contratista='$contratista' and mandante='$mandante' ");
                                            $resul_noaplica=mysqli_fetch_array($query_noaplica);
                                            
                                            switch ($row['tipo']) {
                                                case 1: $tipo='Empresa';break;
                                                case 2: $tipo='Trabajadores';break;
                                                case 3: $tipo='Trabajadores';break;
                                            }

                                                                                        
                                            if ($row['tipo']==1) {
                                                $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf';
                                            } 
                                            if ($row['tipo']==2) {
                                                $query_trab=mysqli_query($con,"select a.codigo, t.rut from trabajadores_acreditados as a LEFT JOIN trabajador as t On t.idtrabajador=a.trabajador where a.trabajador='".$row['trabajador']."' and a.contrato='".$row['contrato']."' ");
                                                $result_trab=mysqli_fetch_array($query_trab);
                                                $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$row['contrato'].'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/'.$row['documento'].'_'.$result_trab['rut'].'.pdf';
                                            } 
                                            if ($row['tipo']==3) {
                                                $query_trab=mysqli_query($con,"select a.codigo, t.rut from trabajadores_acreditados as a LEFT JOIN trabajador as t On t.idtrabajador=a.trabajador where a.trabajador='".$row['trabajador']."' and a.contrato='".$row['contrato']."' ");
                                                $result_trab=mysqli_fetch_array($query_trab);

                                                $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$row['contrato'].'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/'.$row['documento'].'_'.$result_trab['rut'].'.pdf';
                                            }
                                            
                                            $archivo_existe=file_exists($carpeta); 
                                            
                                            $cadena[$i]=$result['id_cdoc'];
                                            $comentario[$i]=$result_com['id_dcom'];
                                            
                                            ?>
                                            
                                             <tr>                    
                                            <?php 

                                               # tipo de documento extra
                                                    # empresa
                                                    if ($row['tipo']==1) {
                                                        $query_consulta=mysqli_query($con,"select * from contratistas where id_contratista='".$row['contratista']."' ");
                                                        $result_consulta=mysqli_fetch_array($query_consulta);
                                                        $nombre=$result_consulta['razon_social']; 
                                                        $rut=$result_consulta['rut'];

                                                    }                                                                   

                                                    # todos los trabajadores de un contrato    
                                                    if ($row['tipo']==2) {
                                                        $query_consulta=mysqli_query($con,"select * from trabajador where idtrabajador='".$row['trabajador']."' ");
                                                        $result_consulta=mysqli_fetch_array($query_consulta);
                                                        $nombre=$result_consulta['nombre1'].' '.$result_consulta['apellido1']; 
                                                        $rut=$result_consulta['rut'];
                                                    } 
                                                    
                                                    # algunos trabajadores de un contrato    
                                                    if ($row['tipo']==3) {
                                                        $query_consulta=mysqli_query($con,"select * from trabajador where idtrabajador='".$row['trabajador']."' ");
                                                        $result_consulta=mysqli_fetch_array($query_consulta);
                                                        $nombre=$result_consulta['nombre1'].' '.$result_consulta['apellido1']; 
                                                        $rut=$result_consulta['rut'];
                                                    } 
                                            
                                               # si archivo existe 
                                               if ($archivo_existe) { 
                                                
                                                
                                                    ?>
                                                    <!-- cargado 
                                                    <td style="text-align:center"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></td>-->
                                                    
                                                    <!-- documento  
                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>-->
                                                   
                                                    <td  style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $nombre ?></a></td>

                                                    <td  style=""><?php echo $rut ?></td>

                                                   <!--  observaciones  -->     
                                                   <td>
                                                       <div class="btn-group">
                                                            <?php if ($row['estado_doc']==2) { ?>
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $result_com['comentarios'] ?></textarea>
                                                             <?php } else { ?>
                                                            
                                                                 <textarea cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                              <?php }  ?>
                                                          
                                                            
                                                            <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row['id_de'] ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                        
                                                       </div>
                                                    </td>
                                                       
                                                        
                                                    <td tyle="text-align:center">
                                                          <?php if ($row['estado_doc']!=3) { ?>  
                                                            <button style="background: #292929;color:#fff" class="btn btn-md btn-primary btn-block" onclick="simultanea(<?php echo $row['tipo'] ?>,<?php echo $mandante ?>,<?php echo $contratista ?>,<?php echo $row['estado_doc'] ?>,<?php echo $row['id_de'] ?>,<?php echo $row['trabajador'] ?>,<?php echo $row['contrato'] ?>)" >Seleccionar</button>
                                                        <?php } else { ?>  
                                                            <button style="background: #292929;color:#fff" class="btn btn-md btn-primary btn-block" disabled >Seleccionar</button>
                                                        <?php } ?>  
                                                    </td>  
                                                    
                                                        <?php if ($resul_noaplica['documento']==$row['id_de']) { ?>                                                                    
                                                                <?php if ($row['estado_doc']!=3) { ?>
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row['id_de'] ?>,<?php echo $i ?>,'<?php echo $row['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,'<?php echo $rut ?>',2,<?php echo $row['trabajador'] ?>,<?php echo $row['contrato'] ?>)" value="<?php echo $row  ?>" checked  /></td>
                                                                <?php  } else { ?>        
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox"  value="<?php echo $row  ?>" checked disabled /></td>
                                                        <?php         }  
                                                    
                                                            } else { ?>
                                                            
                                                                <?php if ($row['estado_doc']!=3) { ?>                                                                                                                                
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row['id_de']?>,<?php echo $i ?>,'<?php echo $row['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,'<?php echo $rut ?>',2,<?php echo $row['trabajador'] ?>,<?php echo $row['contrato'] ?>)" value="<?php echo $row  ?>" /></td>
                                                                <?php  } else { ?>  
                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" disabled  /></td>
                                                                <?php  } 
                                                            }                                                        
                                                        ?>

                                                        



                                                    <td style="text-align:center">
                                                    
                                                        <?php if ($row['estado_doc']==0) { ?>
                                                            <div style="font-size: 16px;" class="bg-danger p-xxs "><small><b>NO ENVIADO</b></small></div> 
                                                        <?php } ?>
                                                        
                                                        <?php if ($row['estado_doc']==1) { ?>
                                                            <div style="font-size: 16px;" class="bg-info p-xxs"><small><b>ENVIADO</b></small></div>
                                                        <?php } ?>
                                                        
                                                        <?php if ($row['estado_doc']==2) { ?>
                                                            <div style="font-size: 16px;" class="bg-warning p-xxs "><small><b>OBSERVACION</b></small></div>
                                                        <?php } ?>
                                                        
                                                        <?php if ($row['estado_doc']==3) { ?>
                                                            <div style="font-size: 16px;" class="bg-success p-xxs "><small><b>VALIDADO</b></small></div>
                                                        <?php } ?>
                                                        
                                                    </td>       
                                                                                                                
                                                  
                                               
                                             <?php # si archivo no existe  
                                             } else  {
                                                    # reenviado
                                                    $estado='1';  ?>
                                                    <!-- cargado
                                                    <td style="text-align:center"><i style="color: #FF0000;font-size: 20px;" class="fa fa-window-close" aria-hidden="true"></i></td> -->
                                                    
                                                    <!-- documento -->
                                                    <td  style=""><?php echo $row['documento'] ?></td>
                                                    
                                                    <td  style=""><?php echo $nombre ?></td>

                                                    <td  style=""><?php echo $rut ?></td>
                                                   
                                                    <!-- observaciones -->
                                                    <td>
                                                        <div class="btn-group"> 
                                                            <textarea cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                            <button class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                        </div>
                                                    </td>

                                                    <td tyle="text-align:center">
                                                            <button style="background: #292929;color:#fff" class="btn btn-md btn-primary btn-block" onclick="simultanea(<?php echo $row['tipo'] ?>,<?php echo $mandante ?>,<?php echo $contratista ?>,<?php echo $row['estado_doc'] ?>,<?php echo $row['id_de'] ?>,<?php echo $row['trabajador'] ?>,<?php echo $row['contrato'] ?>)" >Seleccionar</button>
                                                    </td> 
                                                
                                                    <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row['id_de']?>,<?php echo $i ?>,'<?php echo $row['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,'<?php echo $rut ?>',2,<?php echo $row['trabajador'] ?>,<?php echo $row['contrato'] ?>)"  value="<?php echo $row  ?>"  /></td>
                                                
                                                    
                                                  
                                                   <!-- esTado -->
                                                    <td style="text-align:center">
                                                        <div style="font-size: 16px;" class="bg-danger p-xxs"><small><b>NO ENVIADO</b></small></div>
                                                    </td>
                                                    
                                            </tr> 
                                                   
                                            <?php }  ?> 
                                            
                                     <?php                                      
                                      echo '<input type="hidden" name="cadena_doc[]" id="cadena_doc'.$i.'" value="'.$row['id_de'].'" />';
                                      echo '<input type="hidden" name="comentario[]" id="comentario'.$i.'" value="'.$result_com['id_dcom'].'" />';
                                      echo '<input type="hidden" name="estado[]" id="estado'.$i.'" value="'.$estado.'" />';
                                      echo '<input type="hidden" name="tipo[]" id="tipo'.$i.'" value="'.$row['tipo'].'" />';
                                      $i++; 
                                        }  ?>
                                      
                                            
                                            <tr>
                                                <td colspan="5">
                                                   
                                                </td>                                             
                                                <td colspan="5">
                                                </td>
                                            </tr>
                                        <?php } ?>                                       
                                  </tbody>
                                  
                                 <?php } else { ?> 
                                 
                                    <tr>
                                        <td colspan="6"><strong>Sin Documentos Extras</strong> </td>
                                    </tr>
                                 <?php }  ?>
                                  
                               </table>
                             </div>  
                          </div> 
                          
                          <?php if ($cantidad_de!=0) { ?>
                              <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                    <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" ><span style="color: #F8AC59;font-weight: bold;">NOTA IMPORTANTE: </span> Documento cargado sustituye al anterior. </label>
                                </div>
                              </div>   
                          <?php } ?>    
                          
                          <input type="hidden" name="doc" value="<?php echo $result_doc['doc'] ?>" />    
                          
                          
                          
                                                
                        </div>
                      </div>
                   </div> 
                 </div>
               <!--</form>-->
               
                        <script>
                        
                             
                               
                               function adjuntar_doc_empresa(doc,contratista,com,condicion) {
                                  //alert(doc);
                                   $('.body').load('selid_documentos_contratistas.php?doc='+doc+'&contratista='+contratista+'&com='+com+'&condicion='+condicion,function(){
                                         $('#modal_archivos_empresa').modal({show:true});
                                   });
                               }
                               
                               function modal_ver_obs(id) {
                                     //alert(id);
                                      $('.body').load('selid_ver_obs_doc_extra.php?doc='+id,function(){
                                                $('#modal_ver_obs').modal({show:true});
                                    });
                                } 
                         
                                function simultanea(tipo,mandante,contratista,estado,doc,trabajador,contrato) {                                      
                                      $('.body').load('selid_simultaneo_extra.php?tipo='+tipo+'&mandante='+mandante+'&contratista='+contratista+'&estado='+estado+'&doc='+doc+'&trabajador='+trabajador+'&contrato='+contrato,function(){
                                         $('#modal_simultaneo').modal({show:true});
                                     });   
                                }     

                                function modal_no_aplica(id_doc,num,doc,contratista,mandante,rut,tipo,trabajador,contrato) {     
                                    //alert(id_doc+'-'+num+'-'+doc+'-'+contratista+'-'+mandante+'-'+rut);                                  
                                    if ($('#aplica'+num).is(':checked')) {                                        
                                        document.getElementById("doc_text").innerText=doc;
                                        $('#modal_no_aplica #doc_na').val(id_doc);  
                                        $('#modal_no_aplica #contratista_na').val(contratista)
                                        $('#modal_no_aplica #mandante_na').val(mandante)
                                        $('#modal_no_aplica #documento_na').val(doc)
                                        $('#modal_no_aplica #num_na').val(num); 
                                        $('#modal_no_aplica #tipo_na').val(tipo);
                                        $('#modal_no_aplica #trabajador_na').val(trabajador);
                                        $('#modal_no_aplica #contrato_na').val(contrato);
                                        $('#modal_no_aplica').modal({show:true});
                                    } else {

                                        
                                        swal({
                                            title: "Retirar Documento No Aplica",
                                            //text: "You will not be able to recover this imaginary file!",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: "Si, retirar",
                                            closeOnConfirm: false
                                        }, function () {                                            
                                            $.ajax({
                                                        method: "POST",
                                                        url: "add/addquitarnoaplica_extra.php",
                                                        data:'contratista='+contratista+'&mandante='+mandante+'&documento='+doc+'&rut='+rut+'&tipo='+tipo+'&trabajador='+trabajador+'&contrato='+contrato, 
                                                        success: function(data){
                                                            if (data==0) {                    
                                                                
                                                                swal({
                                                                    title: "Documento Contraista No Aplica Retirado",
                                                                    //text: "Un Documento no validado esta sin comentario",
                                                                    type: "success"
                                                                })
                                                                
                                                                setTimeout(() => {
                                                                    window.location.href='gestion_doc_extraordinarios_contratista_contrato.php';
                                                                }, 1000);
                                                                
                                                            } else {
                                                                swal({
                                                                    title:"Disculpe, Error de Sistema",
                                                                    text: "Vuelva a intentar",
                                                                    type: "warning"
                                                                })
                                                            }
                                                        }   
                                                    });
                                        });
                                        $("#aplica"+num).prop("checked", true);
                                                                           
                                   }
                                }
                                   
                        
                        </script>

                            <div class="modal fade" id="modal_no_aplica" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Documento No Aplica</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>                                    
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                        <h3 id="doc_text" class="form-label"></h3>                                                        
                                                        </div>            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                        <input class="form-control" id="mensaje_na" name="mensaje_na" type="text"  />
                                                        </div>            
                                                    </div>
                                            </div>
                                            
                                            <input type="hidden" id="contratista_na" name="contratista_na" >
                                            <input type="hidden" id="mandante_na" name="mandante_na" >
                                            <input type="hidden" id="doc_na" name="doc_na" >
                                            <input type="hidden" id="documento_na" name="documento_na" >
                                            <input type="hidden" id="num_na" name="num_na" >
                                            <input type="hidden" id="tipo_na" name="tipo_na" >
                                            <input type="hidden" id="trabajador_na" name="trabajador_na" >
                                            <input type="hidden" id="contrato_na" name="contrato_na" >
                                            
                                            <div class="modal-footer">        
                                                        <a style="color: #282828;" class="btn btn-default btn-sm"  onclick="cerrar_no_aplica()" >Cancelar</a>    
                                                        <a style="color: #fff;" class="btn btn-success btn-sm" onclick="guardar_no_aplica(<?php echo $mandante ?>)" >Enviar Documento</a>
                                            </div>                            
                                   </div>
                                </div>
                            </div> 

                        <!-- MODAL CARGA SIMULTANEA -->
                        <div class="modal fade" id="modal_simultaneo" tabindex="-1" role="dialog" aria-hidden="true">
                            
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documentos Extraordinarios   </h3>
                                                    <button style="color: #FFFFFF;" type="button" class="close"  data-dismiss="modal" ><span aria-hidden="true">x</span></button>
                                                </div>
                                                
                                                <div class="body">
                                                </div>    
                                        </div>
                                    </div>
                           </div>  
                        
                        
                        
                        <div class="modal  fade" id="modal_archivos_empresa" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Adjuntar Documento Contratista</h3>
                                          <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="body">
                                        </div> 
                                        <div class="modal-footer">
                                           <button style="color: #fff;" class="btn btn-danger" value="" onclick="window.location.href='gestion_documentos.php'" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            
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
                        
                        <div class="modal fade bd-example-modal-lg" id="modal_cargar1" data-backdrop="static" data-keyboard="false" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="width: 100%">
                                    <span style="color: #FFFFFF;" class="fa fa-spinner fa-spin fa-3x"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Cargando Archivos, por favor espere un momento</h3>
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




</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
