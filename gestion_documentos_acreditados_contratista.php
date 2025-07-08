<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];

if ($_SESSION['mandante']==0) {
   $razon_social="NO SELECCIONADO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}

$query_contratista=mysqli_query($con,"select d.doc_contratista, d.acreditada, d.cant_doc, c.* from contratistas as c left join contratistas_mandantes as d On d.contratista=c.id_contratista where d.contratista='$contratista' and c.id_contratista='$contratista' and d.mandante='".$_SESSION['mandante']."' ");
$result_contratista=mysqli_fetch_array($query_contratista); 
$doc=unserialize($result_contratista['doc_contratista']);
$doc_mensuales=unserialize($result_contratista['doc_contratista_mensuales']);

$rut_contratista=$result_contratista['rut'];
$acreditada=$result_contratista['acreditada'];
$cant_doc=$result_contratista['cant_doc'];

$query_obs=mysqli_query($con,"select * from doc_observaciones where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs=mysqli_fetch_array($query_obs);
$list_veri=unserialize($result_obs['verificados']);

$query_obs_m=mysqli_query($con,"select * from mensuales where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs_m=mysqli_fetch_array($query_obs_m);
$list_veri_m=unserialize($result_obs_m['verificados'])

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
    

    <title>FacilControl | Documentos Contratista</title>
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
            window.location.href='gestion_documentos.php';
        });
    }     
}   

    
 $(document).ready(function (){
       
      

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


    $("#frmDocContratista").on('submit', function(e){
        e.preventDefault();
        alert('p');
        $.ajax({
            type: 'POST',
            url: 'cargar_documentos_contratistas.php',
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
     }); 
    
   
    });   
   
    function cargar_doc_contratista(cant){
          
          var extension=true;
          var contador=0;
          
          for (i=0;i<=cant-1;i++) {
                var filename = $('#carga_doc'+i).val()
                if (filename!='') {
                    contador++;    
                }
          }
                       
          if (contador>0) {                        
                        var arreglo_doc=[];
                        var arreglo_com=[];
                        var arreglo_fil=[];
                        var arreglo_est=[];
                        var formData = new FormData();                        
                                               
                        for (i=0;i<=cant-1;i++) {                            
                            var filename = $('#carga_doc'+i).val();
                            if (filename!='') {
                                var valor_doc=$('#cadena_doc'+i).val();
                                arreglo_doc.push(valor_doc);
                                
                                var valor_com=$('#comentario'+i).val();
                                arreglo_com.push(valor_com);                               
                                formData.append('carga_doc[]',$('#carga_doc'+i)[0].files[0]);                                  
                            } 
                        }
                        
                        var doc=JSON.stringify(arreglo_doc);
                        formData.append('doc', doc );
                        
                        var com=JSON.stringify(arreglo_com);
                        formData.append('com', com );
                        
                        var estado=JSON.stringify(arreglo_est);
                        formData.append('estado', estado );
                        
                        formData.append('cant', cant );
                        
                        $.ajax({
                                url: 'cargar/cargar_documentos_contratistas.php',
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
                         	             window.location.href='gestion_documentos.php';
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
            title: "Sin Documento(s) Seleccionado",
            text: "Debe adjuntar al menos un Documento",
            type: "warning"
         });
      }                 
                    
    }
   

</script>

   <style>
        .estilo {
            display: inline-block;
        	content: "";
        	width: 20px;
        	height: 20px;
        	margin: 0.5em 0.5em 0 0;
            background-size: cover;
        }
        .estilo:checked  {
        	content: "";
        	width: 20px;
        	height: 20px;
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
                    <h2 style="color: #010829;font-weight: bold;">Documentos Contratista <?php  ?></h2>
                    <label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>     
                </div>
            </div>
      
            <div class="wrapper wrapper-content animated fadeIn">
               
                <form id="frmDocContratista" enctype="multipart/form-data">   
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
                                                            echo '<option value="0" >Seleccionar Mandante</option>';
                                                        }                                           
                                                        foreach ($mandantes as $row) {
                                                            echo '<option value="'.$row['mandante'].'" >'.$row['razon_social'].'</option>';
                                                        }                                                
                                                    ?>                                           
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="row">                                                                    
                                            <label  class="col-1 col-form-label"><b>Estado: </b></label>
                                            <?php if ($acreditada==1) { ?> 
                                                <p style="margin-top: 0.5%;margin-left: 1%;"><span class="badge badge-success">Acreditada</span></p>
                                            <?php } else { ?>
                                                <p style="margin-top: 0.5%;margin-left: 1%;"><span class="badge badge-danger">No Acreditada</span></p>    
                                            <?php }  ?>
                                        </div> 
                                        
                                        <div class="row">   
                                                 <label  class="col-1 col-form-label"><b>Documentos:</b></label>
                                        <?php 
                                                $url ='doc/validados/contratistas/bajar_documentos_contratista.php?contratista='.$_SESSION['contratista'].'&rut='.$rut_contratista;
                                                if ($acreditada==1) {   
                                                    if ($cant_doc>0) {               ?>
                                                        <a style="margin-left: 3%;padding-top: 0.5%;font-weight: bold;" href="bajar.php?mandante=<?php echo $mandante ?>&contratista=<?php echo $contratista ?>&rut=<?php echo $rut_contratista ?>" >Descargar Documentos</a>
                                                    <?php } else { ?>
                                                        <label style="font-weight: bold;margin-left: 0.5%;"  class="col-3 col-form-label text-warning">Sin Documentos</label>
                                                    <?php }   
                                                } else { ?>    
                                                    <label style="margin-left: 1%;"  class="col-3 col-form-label text-danger font-bold">No Acreditada</label>
                                                <?php } ?>                                                
                                            
                                        </div> 
                                    
                                        
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
                                        <div class="row">                                                                    
                                            <label  class="col-1 col-form-label"><b>Estado: </b></label>
                                            <?php if ($acreditada==1) { ?> 
                                                <p style="margin-top: 0.5%;margin-left: 1%;"><span class="badge badge-success">Acreditada</span></p>
                                            <?php } else { ?>
                                                <p style="margin-top: 0.5%;margin-left: 1%;"><span class="badge badge-danger">No Acreditada</span></p>   
                                            <?php }  ?>
                                        </div> 
                                        
                                        <div class="row">   
                                                <label style="margin-top: -0.5%;"  class="col-1 col-form-label"><b>Documentos:</b></label>
                                        <?php 
                                                $url ='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/';
                                                if ($acreditada==1) {   
                                                    if ($cant_doc>0) {               ?>
                                                        <a style="padding-top: 0.5%;;margin-left: 3%;margin-top: -0.5%;" class="font-bold" href="descargar.php?url=<?php echo $url ?>&rut=<?php echo $result_contratista['rut'] ?>" ><u>Descargar Documentos</u></a>
                                                    <?php } else { ?>
                                                        <label style="margin-left: 1%;"  class="col-3 col-form-label text-warning font-bold">Sin Documentos</label>
                                                    <?php }   
                                                } else { ?>    
                                                    <label style="margin-left: 1%;"  class="col-3 col-form-label text-danger font-bold">No Acreditada</label>
                                                <?php } ?>                                                
                                            
                                        </div> 
                                        
                                <?php } ?>      
                                        
                            
                                <div style="margin-top: 3%;" class="row">  
                                    <div class="table table-responsive">
                                        <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;" >Cargado</th>
                                                <th style="width: 25%;">Documentos para Revisi&oacute;n</th>
                                                <th style="width: 5%;text-align: center;">Verificado</th>
                                                <th style="width: 32%;">Observaciones</th> 
                                                <th style="width: 23%;text-align: center">Adjuntar</th>
                                                <th style="width: 10%;text-align: center">Estado</th>
                                                
                                            </tr>
                                            </thead>
                                            
                                        <tbody>
                                            
                                            <?php          
                                            
                                            if ($_SESSION['mandante']!=0 ) {    
                                                
                                                $i=0; 
                                                $cont_veri=0;
                                                $cont_doc=0;
                                                $comentario=array();
                                                $cadena=array();
                                                $estado=array();
                                                
                                                foreach ($doc as $row) {
                                                    $cont_doc=$cont_doc+1; 
                                                    $sql=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$row' ");  
                                                    $result=mysqli_fetch_array($sql);  
                                                    
                                                    $query_com=mysqli_query($con,"select * from doc_comentarios where id_dobs='".$result_obs['id_dobs']."' and doc='".$result['documento']."'  order by id_dcom desc  ");
                                                    $result_com=mysqli_fetch_array($query_com);
                                                    $list_com=$result_com['comentarios'];
                                                
                                                    #$carpeta='doc/contratistas/'.$contratista.'/'.$result['documento'].'_'.$rut_contratista.'.pdf';
                                                    
                                                    $query_v=mysqli_query($con,"select estado from doc_observaciones where contratista='$contratista' and mandante='$mandante' ");
                                                    $result_v=mysqli_fetch_array($query_v);
                                                    
                                                    if ($acreditada==1) {
                                                        $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$rut_contratista.'.pdf';
                                                    } else { 
                                                        $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$rut_contratista.'.pdf';
                                                    } 
                                                    
                                                    
                                                    $archivo_existe=file_exists($carpeta); 
                                                    
                                                    $cadena[$i]=$result['id_cdoc'];
                                                    $comentario[$i]=$result_com['id_dcom'];
                                                    
                                                    ?>
                                                    
                                                    <tr>                    
                                                    <?php 
                                                    
                                                    # si archivo existe 
                                                    if ($archivo_existe) { ?>
                                                            <!-- cargado -->
                                                            <td style="text-align:center"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></td>
                                                            
                                                            <!-- documento  -->
                                                            <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>
                                                    <?php 
                                                        
                                                        # sino esta verificado  
                                                        if ($list_veri[$i]==0 ) { ?>
                                                        
                                                        <!-- verificado -->     
                                                        <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>"  disabled="" /></td>
                                                        
                                                        <!--  observaciones  -->     
                                                        <td>
                                                            <div class="btn-group"> 
                                                                    <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com ?></textarea>
                                                                    <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo  $row ?>','<?php echo $result_obs['id_dobs'] ?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                            </div>
                                                            </td>
                                                            
                                                            
                                                            
                                                            
                                                            <!-- estado  --->     
                                                                <?php if ($result_com['doc']==$result['documento']) {
                                                                        if ($result_com['leer_mandante']==1 and $result_com['leer_contratista']==1) { 
                                                                            
                                                                            # reenviado
                                                                            $estado='2'; ?>
                                                                            
                                                                            <!-- adjuntar  obs atendida -->
                                                                        <td  style="text-align:center">
                                                                                <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc<?php echo $i ?>" name="carga_doc[]" multiple="" accept="application/pdf"   /></span>
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div>
                                                                        </td> 
                                                                            
                                                                            
                                                                        
                                                                            <td style="text-align:center;"><div style="background: #82BFAA;" class="bg-info p-xxs b-r-lg text-mute">Reenviado</div></td>
                                                                    <?php  }      
                                                                        if ($result_com['leer_mandante']==0 and $result_com['leer_contratista']==0) { 
                                                                            
                                                                            # observacion
                                                                            $estado='3'; ?>
                                                                            
                                                                            <!-- adjuntar con observacion -->
                                                                            <td  style="text-align:center">
                                                                                <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc<?php echo $i ?>" name="carga_doc[]" multiple="" accept="application/pdf"   /></span>
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div>
                                                                        </td>
                                                                        
                                                                        
                                                                        
                                                                            <td style="text-align:center"><div class="bg-warning p-xxs b-r-lg text-mute">OBSERVACION</div></td>
                                                                    <?php }
                                                                    } else {
                                                                    
                                                                            # enviado
                                                                            $estado='4'; ?>
                                                                    
                                                                            <!-- adjuntar  enviado -->
                                                                            <td  style="text-align:center">
                                                                                <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                    <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                                    <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc<?php echo $i ?>" name="carga_doc[]" multiple="" accept="application/pdf"   /></span>
                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                </div>
                                                                        </td>
                                                                            
                                                                            
                                                                            
                                                                            <td style="text-align:center"><div style="color: #FFFFFF;" class="bg-primary p-xxs b-r-lg text-mute">ENVIADO</div></td>
                                                                <?php }      
                                                                                                                        
                                                        # si esta verificado
                                                        } else {
                                                                    # verificado
                                                                    $estado='5';    
                                                                    $cont_veri=$cont_veri+1; ?>
                                                                    
                                                                    <!-- verificado --> 
                                                                    <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" checked="" disabled=""  /></td>
                                                                    
                                                                    <!--  observaciones  -->
                                                                    <td>
                                                                    <div class="btn-group"> 
                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                        <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo $row ?>','<?php echo $result_obs['id_dobs']?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                    </div>
                                                                </td>
                                                                
                                                                    <!-- adjuntar  -->
                                                                <td  style="text-align:center">
                                                                        <div style="width: 100%;background: #969696;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Documento Validado</span>
                                                                            <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc<?php echo $i ?>" name="carga_doc[]" multiple="" accept="application/pdf"  /></span>                                                                     
                                                                            <span class="fileinput-filename"></span>                                                             
                                                                            <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                        </div>
                                                                </td>
                                                                
                                                                <!--<td>
                                                                    <button disabled="" id="btn_reenviar" style="background: #282828;color: #000;border:#282828;color:#fff"  title="Cargar Archivo" class="ladda-button btn-success btn btn-md" data-style="zoom-in"   type="button" onclick="cargar_doc_contratista('<?php echo $result['id_cdoc']  ?>','<?php echo $contratista  ?>','<?php echo $result_com['id_dcom']  ?>',0,<?php echo $i ?>)"><i class="fa fa-upload" aria-hidden="true"></i> Enviar</button>
                                                                </td>-->
                                                                
                                                                <!-- estado  --->  
                                                                <td style="text-align:center"><div class="bg-success p-xxs b-r-lg text-mute">VALIDADO</div></td>
                                                                        
                                                    <?php }
                                                    
                                                    # si archivo no existe  
                                                    } else  {
                                                            
                                                            # reenviado
                                                            $estado='1';  ?>
                                                            <!-- cargado -->
                                                            <td style="text-align:center"><i style="color: #FF0000;font-size: 20px;" class="fa fa-window-close" aria-hidden="true"></i></td>
                                                            
                                                            <!-- documento -->
                                                            <td  style=""><?php echo $result['documento'] ?></td>
                                                            
                                                            <!-- verificado -->
                                                            <td style="text-align: center;"><input class="estilo" name="verificar[]" id="verificar_doc<?php echo $i ?>" type="checkbox" disabled=""/></td>
                                                            
                                                            <!-- observaciones -->
                                                            <td>
                                                                <div class="btn-group"> 
                                                                    <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                    <button class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                </div>
                                                            </td>
                                                            
                                                        <!-- adjuntar --> 
                                                        <td  style="text-align:center">
                                                                <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                    <span  class="fileinput-exists">Cambiar</span><input class="archivo"  type="file" id="carga_doc<?php echo $i ?>" name="carga_doc[]" accept="application/pdf"   /></span>
                                                                    <span class="fileinput-filename"></span>                                                             
                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                </div>
                                                        </td>
                                                        
                                                        
                                                        <!-- esTado -->
                                                            <td style="text-align:center">
                                                                <!--<button  style="background: #F8AC59;border: #F8AC59; color:#000" style="width:100%" class="btn btn-sm  btn-dark btn-block" type="button"><small>ENVIAR</small></button>-->
                                                                <div style="font-size: 12px;" class="bg-danger p-xxs b-r-sm text-mute b-r-xl">NO ENVIADO</div>
                                                            </td>
                                                            
                                                    </tr> 
                                                        
                                                    <?php } ?> 
                                                    
                                            <?php                                      
                                            echo '<input type="hidden" name="cadena_doc[]" id="cadena_doc'.$i.'" value="'.$result['id_cdoc'].'" />';
                                            echo '<input type="hidden" name="comentario[]" id="comentario'.$i.'" value="'.$result_com['id_dcom'].'" />';
                                            echo '<input type="hidden" name="estado[]" id="estado'.$i.'" value="'.$estado.'" />';
                                            $i++;} ?>
                                            
                                                    <!-- documentos extras --->    
                                                    <?php
                                                        $query_de=mysqli_query($con,"select d.estado as estado_doc, d.*, c.rut from documentos_extras as d left join contratistas as c On c.id_contratista=d.contratista where d.contratista='".$contratista."' and d.tipo=1 and d.estado=3 ");
                                                        $result_de=mysqli_fetch_array($query_de);
                                                        $cantidad=mysqli_num_rows($query_de);

                                                        $query_obs=mysqli_query($con,"select * from doc_observaciones_extra where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
                                                        $result_obs=mysqli_fetch_array($query_obs);
                                                        $list_veri=unserialize($result_obs['verificados']);
                                                        
                                                        # si hat documentos extras                                                
                                                        if ($cantidad>0) {

                                                            foreach ($query_de as $row) {

                                                                

                                                                # si doc esta acreditado
                                                                if ($row['estado_doc']==3) {
                                                                    $carpeta = 'doc/validados/'.$_SESSION['mandante'].'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf'; 
                                                                } else {
                                                                    $carpeta = 'doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf';      
                                                                } 

                                                                $archivo_existe=file_exists($carpeta); 

                                                    ?>
                                                                <tr>                                            
                                                                    <?php if ($archivo_existe) { ?>
                                                                        <td style="text-align:center"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></td>
                                                                                
                                                                        <!-- documento  -->
                                                                        <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>

                                                                        <?php if ($row['estado_doc']==3) { ?>
                                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="" id=""  disabled="" checked="" /></td>
                                                                        <?php } else { ?>    
                                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="" id=""  disabled="" /></td>
                                                                        <?php }  ?>    

                                                                        <!--  observaciones  -->     
                                                                        <td>
                                                                            <div class="btn-group"> 
                                                                                    <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com ?></textarea>
                                                                                    <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo  $row ?>','<?php echo $result_obs['id_dobs'] ?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                            </div>
                                                                            </td>

                                                                        <td colspan="2"><?php echo $cantidad ?></td>
                                                                    
                                                                <?php } else { ?>     

                                                                        <td style="text-align:center"><i style="color: #FF0000;font-size: 20px;" class="fa fa-window-close" aria-hidden="true"></i></td>
                                                                                    
                                                                        <!-- documento  -->
                                                                        <td style=""><?php echo $row['documento'] ?></td>

                                                                        <td style="text-align: center;"><input class="estilo" type="checkbox" name="" id=""  disabled="" /></td>

                                                                        <!--  observaciones  -->     
                                                                        <td>
                                                                            <div class="btn-group"> 
                                                                                    <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com ?></textarea>
                                                                                    <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo  $row ?>','<?php echo $result_obs['id_dobs'] ?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                            </div>
                                                                            </td>
                                                                        
                                                                        <td colspan=23"><?php echo $cantidad ?></td>

                                                                    <?php }  ?> 

                                                                </tr>
                                                    <?php   }
                                                        }
                                                    ?>    

                                                    <tr>
                                                        <td colspan="4">
                                                        </td>
                                                        <td colspan="2">
                                                            <?php  if ($acreditada!=1) { ?>
                                                                <button id="" style="" title="Cargar Archivo" class="btn-success btn btn-md btn-block font-bold" type="button" onclick="cargar_doc_contratista(<?php echo $i ?>)" >Procesar Documentos <?php  ?></button>
                                                            <?php }  ?>   
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                    </tr>                                   
                                        </tbody>
                                        
                                        <?php } ?> 
                                        
                                    </table>
                                    </div>  
                                </div> 
                                
                                <?php  if ($acreditada!=1) { ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                            <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" ><span style="color: #F8AC59;font-weight: bold;">NOTA IMPORTANTE: </span> Documento cargado sustituye al anterior. </label>
                                        </div>
                                    </div>  
                                    <?php }  ?>     
                                
                                <input type="hidden" name="doc" value="<?php echo $result_doc['doc'] ?>" />    
                                
                                
                                
                                                        
                                </div>
                            </div>
                        </div> 
                    </div>
                </form>
               
                        <script>
                        
                             
                               
                               function adjuntar_doc_empresa(doc,contratista,com,condicion) {
                                  //alert(doc);
                                   $('.body').load('selid_documentos_contratistas.php?doc='+doc+'&contratista='+contratista+'&com='+com+'&condicion='+condicion,function(){
                                         $('#modal_archivos_empresa').modal({show:true});
                                   });
                               }
                               
                               function modal_ver_obs(id_doc,id_obs,condicion) {
                                     // alert(id_doc+' '+id_obs);
                                      //var condicion=0;
                                      $('.body').load('selid_ver_obs_doc.php?doc='+id_doc+'&id_dobs='+id_obs+'&condicion='+condicion,function(){
                                                $('#modal_ver_obs').modal({show:true});
                                    });
                                } 
                         
                                   
                        
                        </script>
                        
                        
                        
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
