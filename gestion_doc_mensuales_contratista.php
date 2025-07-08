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
    

    <title>FacilControl | Gestión Documentos Mensuales</title>
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
            window.location.href='gestion_doc_mensuales_contratista.php';
        });
    }     
}   

    
 $(document).ready(function (){
       
      
        $('#menu-gestion').attr('class','active');  
        
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

       
    function cargar_simultaneo(contrato,total,doc,mes){ 
               //alert(mes);
               var arreglo=[];
               var fileInput = document.getElementById('carga_doc_simultaneo');
               var filePath = fileInput.files.length;
               var num=0;
               if (filePath>0) {
                   for (i=0;i<=total-1;i++) {
                        var isChecked = $('#trabajadores'+i).prop('checked');
                        if (isChecked) {
                            var valor=document.getElementById("trabajadores"+i).value;
                            arreglo.push(valor);
                            num=num+1;
                        } 
                   }
                   
                   //var filePath = fileInput.value;
                   //var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
                   //if(!allowedExtensions.exec(filePath)){
                   //     swal({
                   //         title: "Tipo No Permitido",
                   //         text: "Solo documentos PDF",
                   //         type: "warning"
                   //     });
                   //     return false;
                   //} else {   
                       
                        var formData = new FormData();
                        var files= $('#carga_doc_simultaneo')[0].files[0]; 
                                           
                        formData.append('archivo',files);
                        formData.append('contrato', contrato );
                        formData.append('total',num );
                        formData.append('doc',doc );
                        formData.append('mes',mes );
                        formData.append('arreglo',JSON.stringify(arreglo));
                       
                        //alert(contrato);
                        $.ajax({
                                url: 'cargar_ficheros_simultaneos.php',
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
                                        swal({
                                                title: "Documento Enviado",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                            });
                                        setTimeout(
                                        function() {
                        	               window.location.href='gestion_doc_mensuales_contratista.php';
                                        },1000);
                                    } else {
                                        if (response==2) {
                                             swal({
                                                title: "Sin Documento",
                                                text: "Debe seleccionar un archivo",
                                                type: "warning"
                                            });
                                        } else {
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
                                            $('#modal_cargar').modal('hide');
                                        }
                        });
                        
                    //} 
               } else {
                    swal({
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF/JPG/JPEG/PNG",
                        type: "warning"
                    });
               }     
                    
    }

    
    function seleccionarTodo1() {
        var isChecked = $('#trabajadores1').prop('checked');
        if (isChecked) {
            //alert('true');
            for (let i=1; i < document.f1.elements.length; i++) {
                if(document.f1.elements[i].type === "checkbox") {
                    document.f1.elements[i].checked = true;
                }
            }
            alert('true');    
        } else {    
            //alert('false')
            for (let i=1; i < document.f1.elements.length; i++) {
                if(document.f1.elements[i].type === "checkbox") {
                    document.f1.elements[i].checked = true;
                }
            }
            alert('false');
        }   
    }
   

    </script>

   <style>

.estilo {
                                                    display: inline-block;
                                                	content: "";
                                                	width: 10px;
                                                	height: 10px;
                                                	margin: 0.5em 0.5em 0 0;
                                                    background-size: cover;
                                                }
                                                .estilo:checked  {
                                                	content: "";
                                                	width: 10px;
                                                	height: 10px;
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
              <h2 style="color: #010829;font-weight: bold;">Documentos Mensuales <?php   ?></h2>
              <label class="label label-warning encabezado"><strong>Mandante: <?php echo $razon_social ?></strong></label>     
          </div>
       </div>
       
        <div class="wrapper wrapper-content animated fadeIn">
               
          
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
                                    <label  class="col-1 col-form-label"><b>Mandantes </b></label>
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
                                                }                                           
                                                foreach ($mandantes as $row) {
                                                    echo '<option value="'.$row['mandante'].'" >'.$row['razon_social'].'</option>';
                                                }                                                
                                            ?>                                           
                                        </select>
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
                                 
                                
                            
                                
                        <?php 
                            # contratista con un solo mandante
                            } else { ?>
                        
                                <div class="row">                                                                    
                                    <label  class="col-1 col-form-label"><b>Mandante</b></label>
                                            <?php
                                                $query=mysqli_query($con,"select razon_social,id_mandante from mandantes where id_mandante='".$_SESSION['mandante']."' ");
                                                $result=mysqli_fetch_array($query);     
                                            ?>
                                            <label  class="col-6 col-form-label"><?php echo $result['razon_social'] ?></label>
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
                                
                                        
                         <div style="margin-top: 3%;" class="row">  
                             <div class="table table-responsive">
                                <table class="table table-stripped" data-page-size="25" data-filter="#filter">
                                   <thead style="background:#e9eafb;color:#282828;font-weight:bold">
                                    <tr>
                                       
                                        <th style="width: 25%;border-right:1px #fff solid">Documento</th>
                                        <th style="width: 18%;border-right:1px #fff solid">Trabajador</th>
                                        <th style="width: 10%;border-right:1px #fff solid">Rut</th>
                                        <th style="width: 5%;border-right:1px #fff solid">Mes</th>
                                        <th style="width: 22%;border-right:1px #fff solid">Observaciones</th> 
                                        <th style="width: 10%;text-align: center;border-right:1px #fff solid">Gestion</th>
                                        <th style="width: 10%;text-align: center;border-right:1px #fff solid">Estado</th>
                                        
                                    </tr>
                                    </thead>
                                    
                                   <tbody>
                                    
                                    <?php          
                                    
                                    $query_doc=mysqli_query($con,"select m.mes as mes_dm, m.*, t.nombre1, t.apellido1, t.rut, t.idtrabajador, d.documento from mensuales_trabajador as m left join trabajador as t On t.idtrabajador=m.trabajador left join doc_mensuales as d On d.id_dm=m.doc left join mensuales as e On e.id_m=m.id_m where m.contratista='$contratista' and m.mandante='".$_SESSION['mandante']."' and m.verificado=0 ");
                                    $result_doc=mysqli_fetch_array($query_doc); 
                                    $cantidad_de=mysqli_num_rows($query_doc);

                                    if ($cantidad_de!=0) {

                                        
                                        $query_obs=mysqli_query($con,"select * from doc_observaciones_extra where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
                                        $result_obs=mysqli_fetch_array($query_obs);
                                        $list_veri=unserialize($result_obs['verificados']);
                                     
                                     if ($_SESSION['mandante']!=0 ) {    
                                         
                                         $i=0; 
                                         $num=1;
                                         $cont_veri=0;
                                         $comentario=array();
                                         $cadena=array();
                                         $estado=array();                                       

                                         foreach ($query_doc  as $row) {

                                          switch ($row['mes']) {
                                            case '01':$mes='Enero';break;
                                            case '02':$mes='Febrero';break;
                                            case '03':$mes='Marzo';break;
                                            case '04':$mes='Abril';break;
                                            case '05':$mes='Mayo';break;
                                            case '06':$mes='Junio';break;
                                            case '07':$mes='Julio';break;
                                            case '08':$mes='Agosto';break;                                            
                                            case '09':$mes='Septiembre';break;
                                            case '10':$mes='Octubre';break;
                                            case '11':$mes='Noviembre';break;
                                            case '12':$mes='Diciembre';break;
                                          }   
                                          
                                          if ($row['estado_doc']!=3) {
                                            
                                            $query_com=mysqli_query($con,"select * from doc_comentarios_mensual where id_doc='".$row['doc']."' and documento='".$row['documento']."' and estado=0 order by id_cm desc ");
                                            $result_com=mysqli_fetch_array($query_com);
                                            
                                            $query_t=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='".$row['trabajador']."' and contrato='".$row['contrato']."' ");
                                            $result_t=mysqli_fetch_array($query_t);

                                            $query_d=mysqli_query($con,"select * from doc_mensuales where id_dm='".$row['doc']."' ");
                                            $result_d=mysqli_fetch_array($query_d);
                                           
                                            # doc no acreditado 
                                            if ($row['verificado']==0) {
                                                $carpeta = 'doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$row['rut'].'_'.$row['mes'].'_'.$row['year'].'.pdf';
                                                //$carpeta = 'doc/mensuales/'.$row['year'].'/'.$row['mes'].'/'.$mandante.'/'.$contratista.'/'.$row['contrato'].'/'.$row['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$row['rut'].'.pdf';; 
                                            # doc acreditado  
                                            } else {
                                                $carpeta = 'doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$row['rut'].'.pdf';; 
                                            }
                                               # $carpeta = 'doc/mensuales/'.$row['year'].'/'.$row['mes'].'/'.$mandante.'/'.$contratista.'/'.$row['contrato'].'/'.$row['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$row['rut'].'.pdf';;
                                                                                                                                   
                                            ?>
                                            
                                             <tr>                    
                                            <?php 
                                            
                                               # si archivo existe 
                                               if ($row['enviado']==1 || $row['enviado']==2 || $row['enviado']==3) { ?>
                                                     
                                                     <!-- documento -->
                                                    <td  style="font-weight:bold"><a href="<?php echo $carpeta ?>" target="_black" ><?php echo $row['documento'] ?></a></td>
                                                    
                                                     <!-- trabajador -->
                                                    <td style=""><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>

                                                    <!-- trabajador -->
                                                    <td style=""><?php echo $row['rut'] ?></td>

                                                    <!-- mes -->
                                                    <td style=""><?php echo $mes  ?></td>
                                                   
                                                   <!--  observaciones  -->     
                                                   <td>
                                                       <div class="btn-group">
                                                            <?php if ($row['enviado']==2) { ?>
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $result_com['comentarios'] ?></textarea>
                                                             <?php } else { ?>
                                                                 <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                              <?php }  ?>
                                                              
                                                            <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row['id_de'] ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                       </div>
                                                    </td>
                                                                    
                                                    <!-- adjuntar  obs atendida 
                                                    <td  style="text-align:center">
                                                            <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccionar</span>
                                                                <span  class="fileinput-exists">Cambiar</span>
                                                                    <input  type="file" id="carga_doc<?php echo $i ?>" name="carga_doc[]" multiple="" accept="application/pdf"  />
                                                                </span>
                                                                <span class="fileinput-filename"></span>                                                             
                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                            </div>
                                                    </td> -->

                                                    <td tyle="text-align:center">
                                                        <?php if ($row['enviado']!=3) { ?>
                                                                <button style="background: #292929;color:#fff" class="btn btn-xs btn-primary btn-block" onclick="simultanea(<?php echo $row['idtrabajador'] ?>,<?php echo $row['contrato'] ?>,<?php echo $row['doc'] ?>,'<?php echo $row['mes_dm'] ?>',<?php echo $row['enviado'] ?>)" ><strong>ARCHIVO</strong></button>
                                                        <?php } else { ?>    
                                                                <button style="background: #292929;color:#fff" class="btn btn-xs btn-primary btn-block" disabled="" ><strong>ARCHIVO</strong></button>
                                                        <?php }  ?>
                                                    </td>
                                                    
                                                    <td style="text-align:center">
                                                    
                                                        <?php if ($row['enviado']==0) { ?>
                                                            <div style="font-size: 12px;" class="bg-danger p-xxs text-default "><b>NO ENVIADO</b></div> 
                                                        <?php } ?>
                                                        
                                                        <?php if ($row['enviado']==1) { ?>
                                                            <div style="font-size: 12px;" class="bg-warning p-xxs text-default "><b>EN PROCESO</b></div>
                                                        <?php } ?>
                                                        
                                                        <?php if ($row['enviado']==2) { ?>
                                                            <div style="font-size: 12px;" class="bg-warning p-xxs text-default "><b>EN PROCESO</b></div>
                                                        <?php } ?>
                                                        
                                                        <?php if ($row['enviado']==3) { ?>
                                                            <div style="font-size: 12px;" class="bg-success p-xxs text-default "><b>VALIDADO</b></div>
                                                        <?php } ?>
                                                        
                                                    </td>       
                                                                                                                
                                                  
                                               
                                             <?php # si archivo no existe  
                                             } else  {
                                                    
                                                   
                                                    $estado='1';  ?>

                                                     <!-- documento -->
                                                    <td  style=""><?php echo $row['documento'] ?></td>
                                                    
                                                     <!-- trabajador -->
                                                    <td style=""><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>

                                                    <!-- trabajador -->
                                                    <td style=""><?php echo $row['rut'] ?></td>

                                                     <!-- mes -->
                                                     <td style=""><?php echo $mes  ?></td>
                                                                                                     
                                                    <!-- observaciones -->
                                                    <td>
                                                        <div class="btn-group"> 
                                                            <textarea cols="70" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                            <button class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                        </div>
                                                    </td>

                                                   <td tyle="text-align:center">
                                                    <button style="background: #292929;color:#fff;font-size: 10px;" class="btn btn-sms btn-primary btn-block" onclick="simultanea(<?php echo $row['idtrabajador'] ?>,<?php echo $row['contrato'] ?>,<?php echo $row['doc'] ?>,'<?php echo $row['mes_dm'] ?>',<?php echo $row['enviado'] ?>)" ><strong>ARCHIVO</strong></button>
                                                   </td>
                                                   
                                                  
                                                   <!-- esTado -->
                                                    <td style="text-align:center">
                                                        <div style="font-size: 12px;" class="bg-danger p-xxs text-default"><strong>NO ENVIADO</strong></div>
                                                    </td>
                                                    
                                            </tr> 
                                                   
                                            <?php }  ?> 
                                            
                                     <?php                                      
                                      echo '<input type="hidden" name="cadena_doc[]" id="cadena_doc'.$i.'" value="'.$row['id_de'].'" />';
                                      echo '<input type="hidden" name="comentario[]" id="comentario'.$i.'" value="'.$result_com['id_dcom'].'" />';
                                      echo '<input type="hidden" name="estado[]" id="estado'.$i.'" value="'.$estado.'" />';
                                      echo '<input type="hidden" name="tipo[]" id="tipo'.$i.'" value="'.$row['tipo'].'" />';
                                      $i++;$num++;} 
                                        }  ?>
                                      
                                            
                                            <tr>
                                                <td colspan="4">
                                                  
                                                </td>
                                                
                                                <td colspan="2">
                                                    <?php  if ($cantidad_de!=0) { ?>
                                                        <!--<button id="" style="" title="Cargar Archivo" class="btn-success btn btn-md btn-block font-bold" type="button" onclick="cargar_doc_extra(<?php echo $i ?>)" >Enviar Documentos <?php  ?></button>-->
                                                    <?php }  ?>  
                                                </td>
                                                
                                                <td colspan="5">
                                                </td>
                                            </tr>
                                        <?php } ?>                                       
                                  </tbody>
                                  
                                 <?php } else { ?> 
                                 
                                    <tr>
                                        <td colspan="6"><strong>Sin Documentos Mensuales</strong> </td>
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
               
                        <script>
                                 function simultanea(trabajador,contrato,doc,mes,enviado) {
                                   // $.post("sesion_simultaneo.php", { mes: mes,mensual: mensual,doc:doc }, function(data){
                                   //         $('#trabajador').html(trabajador);
                                   //         $('#nom_doc').html(nom_doc);
                                   //        $('#modal_simultaneo').modal({show:true});
                                   //   });  
                                   //alert(enviado);    
                                      $('.body').load('selid_simultaneo.php?trabajador='+trabajador+'&contrato='+contrato+'&doc='+doc+'&mes='+mes+'&enviado='+enviado,function(){
                                         $('#modal_simultaneo').modal({show:true});
                                     });  
                                }
                                                              
                               function modal_ver_obs(id) {
                                     //alert(id);
                                      $('.body').load('selid_ver_obs_doc_extra.php?doc='+id,function(){
                                                $('#modal_ver_obs').modal({show:true});
                                    });
                                } 
                         
                                   
                        
                        </script>


                        <!-- MODAL CARGA SIMULTANEA -->
                        <div class="modal fade" id="modal_simultaneo" tabindex="-1" role="dialog" aria-hidden="true">
                            
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                                <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">Documentos Mensuales   </h3>
                                                    <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" ><span aria-hidden="true">x</span></button>
                                                </div>
                                                
                                                <div class="body">
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
