<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


$contratista=$_SESSION['contratista'];


if ($_SESSION['mandante']==0) {
   $razon_social="no se ha seleccionado";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante='".$_SESSION['mandante']."' ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}

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

    <title>FacilControl | Desvinculaciones</title>
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


<script>

    $(document).ready(function (){
   
        $('#menu-gestion').attr('class','active');
    });

    function cargar_doc(cant){
                var contador=0;
                
                
                for (i=0;i<=cant-1;i++) {
                    var filename = $('#carga_doc_d'+i).val()
                    if (filename!='') {
                        contador++;    
                    }
                }
                                
               if (contador>0) {

                        var arreglo_trabajadores=[];
                        var arreglo_tipo=[];
                        var arreglo_comentarios=[];
                        var arreglo_id=[];
                        var arreglo_contratos=[];
                        var formData = new FormData();

                        for (j=0;j<=cant-1;j++) {
                            var archivo = $('#carga_doc_d'+j).val();
                           // alert(archivo);            
                            if (archivo!='') {

                                var valor_trabajadores=$('#trabajador'+j).val();
                                arreglo_trabajadores.push(valor_trabajadores);

                                var valor_tipos=$('#tipo'+j).val();
                                arreglo_tipo.push(valor_tipos);

                                var valor_comentarios=$('#comentario'+j).val();
                                arreglo_comentarios.push(valor_comentarios);

                                var valor_id=$('#id_d'+j).val();
                                arreglo_id.push(valor_id);

                                var valor_contratos=$('#contratos'+j).val();
                                arreglo_contratos.push(valor_contratos);

                                formData.append('carga_doc_d[]',$('#carga_doc_d'+j)[0].files[0]); 
                                //alert(valor_trabajadores+' '+valor_tipos+' '+valor_comentarios+' '+valor_id);
                            }
                        };  

                        var trabajadores=JSON.stringify(arreglo_trabajadores);
                        formData.append('trabajadores', trabajadores );
                        
                        var tipo=JSON.stringify(arreglo_tipo);
                        formData.append('tipos', tipo );
                        
                        var comentarios=JSON.stringify(arreglo_comentarios);
                        formData.append('comentarios', comentarios );

                        var id=JSON.stringify(arreglo_id);
                        formData.append('id', id ); 

                        var contratos=JSON.stringify(arreglo_contratos);
                        formData.append('contratos', contratos ); 
                        
                        formData.append('cant', cant );

                        //alert(id);
                        $.ajax({
                                url: 'cargar_documentos_desvinculante.php',
                                type: 'post',
                                data:formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function(){
                                    $('#modal_cargar').modal('show');						
                    			},
                                success: function(response) {
                                    if (response==0) {                                        
                                        swal({
                                                title: "Documento Enviado",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                            });
                        	            window.location.href='desvinculaciones_contratista.php';
                                    } else {                                       
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
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF",
                        type: "warning"
                    });
               }     
                    
    }
   
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
            window.location.href='desvinculaciones_contratista.php';
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

        .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
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
                    <h2 style="color: #010829;font-weight: bold;">Desvinculaciones de Trabajadores <?php   ?></h2>
                    <label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
            <!--<form  method="post" action="cargar_documentos_desvinculante.php" enctype="multipart/form-data">   -->
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                             <div class="ibox-title">
                                 <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_contratos_contratistas.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="gestion_contratos_contratistas.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Gestion de Contratos</a>                                           
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
                                        
                                <?php } ?>     
                       
                     
                         <div class="row">                            
                                <!--<input type="hidden" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                            <div class="table-responsive">    
                                <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                
                                   <thead class="cabecera_tabla">
                                    <tr>
                                        <th style="width: 5%;border-right:1px #fff solid" >Documento</th>
                                        <th style="width: 20%;border-right:1px #fff solid">Trabajador</th>
                                        <th style="width: 8%;border-right:1px #fff solid">Desvinculacion</th> 
                                        <th style="width: 30%;border-right:1px #fff solid">Observaciones</th> 
                                        <th style="width: 28%;text-align: center;border-right:1px #fff solid">Adjuntar</th>
                                        <th style="width: 10%;text-align: center">Estado</th>
                                        
                                    </tr>
                                    </thead>
                                    
                                   <tbody>
                                    
                                    <?php  
                                     $query_desvinculaciones=mysqli_query($con,"select d.*, t.nombre1, t.apellido1, t.rut from desvinculaciones as d LEFT JOIN trabajador as t On t.idtrabajador=d.trabajador LEFT JOIN contratistas as c On c.id_contratista=d.contratista where d.estado!='2' and d.mandante='".$_SESSION['mandante']."' and d.contratista='".$_SESSION['contratista']."' ");
                                     $existe_d=mysqli_num_rows($query_desvinculaciones);
                                    
                                     if ($existe_d==0) { ?> 
                                            <tr>
                                                <td colspan="6"><span style="font-weight: bold;">No hay documentos de desvinculaciones</span></td>
                                            </tr>
                                    
                                   <?php } else {      
                                    
                                             
                                         $i=0; 
                                         $cont_veri=0;
                                         $cont_doc=0;
                                         $comentario=array();
                                         $cadena=array();
                                         
                                         #$query_desvinculaciones=mysqli_query($con,"select a.codigo, d.*, t.nombre1, t.apellido1, t.rut from desvinculaciones as d LEFT JOIN trabajador as t On t.idtrabajador=d.trabajador LEFT JOIN trabajadores_acreditados as a On a.trabajador=t.idtrabajador where d.estado!='2' and d.mandante='".$_SESSION['mandante']."' and d.contratista='".$_SESSION['contratista']."'   ");
                                         #$query_desvinculaciones=mysqli_query($con,"select d.*, t.nombre1, t.apellido1, t.rut from desvinculaciones as d LEFT JOIN trabajador as t On t.idtrabajador=d.trabajador LEFT JOIN contratistas as c On c.id_contratista=d.contratista where d.estado!='2' and d.mandante='".$_SESSION['mandante']."' and d.contratista='".$_SESSION['contratista']."' ");
                                         #$num_desvinculaciones=mysqli_num_rows($query_desvinculaciones);
                                         
                                         
                                         foreach ($query_desvinculaciones as $row) {
                                            
                                           if ($row['tipo']==1) {
                                            $tipo='Contratista';
                                           } else {
                                            $tipo='Contrato';
                                           }
                                            
                                            
                                            
                                            $cont_doc=$cont_doc+1;
                                            $sql=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$row' ");  
                                            $result=mysqli_fetch_array($sql);  
                                            
                                            $sql_o=mysqli_query($con,"select * from doc_comentarios_desvinculaciones where id_des='".$row['id_d']."' and estado=0 ");  
                                            $result_o=mysqli_fetch_array($sql_o);

                                            $query_codigo=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='".$row['trabajador']."' and estado!='2' and mandante='".$_SESSION['mandante']."' ");
                                            $result_codigo=mysqli_fetch_array($query_codigo);

                                           
                                            #$query_v=mysqli_query($con,"select estado from doc_observaciones where contratista='$contratista' ");
                                            #$result_v=mysqli_fetch_array($query_v);
                                            
                                            # desvinculacion contratista
                                            #if ($row['estado']==1) {
                                                # desvinculacion de contratista
                                            #         if ($row['tipo']==1) {   
                                            #            $carpeta='doc/temporal/'.$_SESSION['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/documento_desvinculante_contratista_'.$row['rut'].'.pdf';
                                                     # desvilculacion de un contrato                                                        
                                            #         } else {
                                            #            $carpeta='doc/temporal/'.$_SESSION['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/documento_desvinculante_contrato_'.$row['contrato'].'_'.$row['rut'].'.pdf';
                                            #         }   
                                            
                                            # desvinculacion contrato    
                                            #} else { 
                                               # desvinculacion de contratista
                                                    if ($row['tipo']==1) {   
                                                        $carpeta='doc/validados/'.$_SESSION['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_codigo['codigo'].'/documento_desvinculante_contratista_'.$row['rut'].'.pdf';
                                                     # desvilculacion de un contrato                                                        
                                                     } else {
                                                        $carpeta='doc/validados/'.$_SESSION['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_codigo['codigo'].'/documento_desvinculante_contrato_'.$row['contrato'].'_'.$row['rut'].'.pdf';
                                                     } 
                                            #} 
                                            
                                            
                                            $archivo_existe=file_exists($carpeta); 
                                            
                                            $cadena[$i]=$result['id_cdoc'];
                                            $comentario[$i]=$result_com['id_dcom'];
                                            
                                            ?>
                                            
                                             <tr> 
                                                <!-- documento  -->
                                                <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> Mostrar</a></td>
                                            
                                                <!-- trabajador -->                   
                                                <td style="text-align:left"><?php echo $row['nombre1'].' '.$row['apellido1']  ?></td>
                                                
                                                <!-- tipo -->                   
                                                <td style="text-align:left"><?php echo $tipo  ?></td>
                                            
                                               
                                             <?php
                                                  # si no esta verificado  
                                                  if ($row['verificado']== 0) { ?>
                                                   
                                                   <!-- verificado     
                                                   <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>"  disabled="" value="0" /></td>--> 
                                                   
                                                   <!--  observaciones  -->     
                                                   <td>
                                                       <div class="btn-group"> 
                                                            <textarea cols="50" rows="1" name="comentario[]" id="comentario<?php echo $i ?>" class="form-control" readonly=""><?php echo $result_o['comentarios'] ?></textarea>
                                                            <!--<button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo  $row ?>','<?php echo $result_obs['id_dobs'] ?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>-->
                                                       </div>
                                                    </td>
                                                    
                                                    <!-- estado  --->     
                                                          
                                                    <?php 
                                                            # sino esta validad
                                                            if ($row['control']!=2) {
                                                                
                                                                
                                                                # documento enviado
                                                                if ($row['control']==0) { ?>
                                                                    
                                                                   <!-- adjuntar  obs atendida -->
                                                                   <td  style="text-align:center">
                                                                         <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                             <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                             <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_d<?php echo $i ?>" name="carga_doc_d[]"  multiple="" accept="application/pdf" /></span>
                                                                             <span class="fileinput-filename"></span>                                                             
                                                                             <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                         </div>
                                                                   </td> 
                                                                    
                                                                    
                                                                 
                                                                    <td style="text-align:center;"><div style="background: #82BFAA;" class="bg-primary p-xxs text-center"><small>ENVIADO</small></div></td>
                                                            <?php  } 
                                                            
                                                                    if ($row['control']==1) { ?>
                                                                     <!-- adjuntar con observacion -->
                                                                    <td  style="text-align:center">
                                                                         <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                             <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                                <span  class="fileinput-exists">Cambiar</span>
                                                                                <input  type="file" id="carga_doc_d<?php echo $i ?>" name="carga_doc_d[]"  multiple=""  accept="application/pdf" />
                                                                            </span>
                                                                             <span class="fileinput-filename"></span>                                                             
                                                                             <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                         </div>
                                                                   </td>
                                                                 
                                                                    <td style="text-align:center:"><div class="bg-warning p-xxs text-center"><small style="color:#282828;font-weight: bold;">OBSERVACION</small></div></td>
                                                                    
                                                            
                                                            <?php } 
                                                            
                                                                  if ($row['control']==3) { ?>
                                                                     <!-- adjuntar con observacion -->
                                                                    <td  style="text-align:center">
                                                                         <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                             <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                             <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_d<?php echo $i ?>" name="carga_doc_d[]"  multiple=""  accept="application/pdf" /></span>
                                                                             <span class="fileinput-filename"></span>                                                             
                                                                             <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                         </div>
                                                                   </td>
                                                                 
                                                                    <td style="text-align:center"><div class="bg-info p-xxs text-center"><small>REENVIADO<small></div></td>
                                                            
                                                            
                                                            <?php }  
                                                            
                                                            
                                                            } else { ?>
                                                              
                                                                    <!-- adjuntar  enviado -->
                                                                    <td  style="text-align:center">
                                                                         <div style="width: 100%;background: #292929;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                             <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento</span>
                                                                             <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_d<?php echo $i ?>" name="carga_doc_d[]"  multiple=""  /></span>
                                                                             <span class="fileinput-filename"></span>                                                             
                                                                             <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                         </div>
                                                                   </td>
                                                                    
                                                                    
                                                                    
                                                                    <td style="text-align:center"><div style="color: #FFFFFF;" class="bg-primary p-xxs text-center"><small>ENVIADO</small></div></td>
                                                           <?php }      
                                                                                                                
                                                  # si esta verificado
                                                  } else {
                                                            $cont_veri=$cont_veri+1; ?>
                                                            
                                                            <!-- verificado 
                                                            <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" checked="" disabled="" value="1"  /></td>--> 
                                                            
                                                            <!--  observaciones  -->
                                                            <td>
                                                               <div class="btn-group"> 
                                                                  <textarea cols="50" rows="1" name="comentario[]" id="comentario<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                  <!--<button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo $row ?>','<?php echo $result_obs['id_dobs']?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>-->
                                                               </div>
                                                           </td>
                                                           
                                                            <!-- adjuntar  -->
                                                           <td  style="text-align:center">
                                                                 <div style="width: 100%;background: #969696;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                     <span  style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Documento Validado</span>
                                                                     <span  class="fileinput-exists">Cambiar</span><input type="file" id="carga_doc_d<?php echo $i ?>" name="carga_doc_d[]" multiple="" /></span>
                                                                     <span class="fileinput-filename"></span>                                                             
                                                                     <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                 </div>
                                                           </td>
                                                           
                                                           <!--<td>
                                                             <button disabled="" id="btn_reenviar" style="background: #282828;color: #000;border:#282828;color:#fff"  title="Cargar Archivo" class="ladda-button btn-success btn btn-md" data-style="zoom-in"   type="button" onclick="cargar_doc_contratista('<?php echo $result['id_cdoc']  ?>','<?php echo $contratista  ?>','<?php echo $result_com['id_dcom']  ?>',0,<?php echo $i ?>)"><i class="fa fa-upload" aria-hidden="true"></i> Enviar</button>
                                                           </td>-->
                                                           
                                                           <!-- estado  --->  
                                                           <td style="text-align:center"><div class="bg-success p-xxs text-center"><small>VALIDADO</small></div></td>
                                                                
                                               <?php }
                            
                                        echo '<input type="hidden" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['trabajador'].'" />';
                                        echo '<input type="hidden" name="comentarios[]" id="comentarios'.$i.'" value="'.$row['comentario'].'" />';
                                        echo '<input type="hidden" name="id_d[]" id="id_d'.$i.'" value="'.$row['id_d'].'" />';
                                        echo '<input type="hidden" name="tipo[]" id="tipo'.$i.'" value="'.$row['tipo'].'" />';
                                        echo '<input type="hidden" name="contratos[]" id="contratos'.$i.'" value="'.$row['contrato'].'" />';
                                        
                                      $i++;} ?>
                                            
                                            <tr>
                                                <td colspan="4"></td>
                                                <td colspan="2">
                                                    <button style="" title="Cargar Archivo" class="btn-success btn btn-md btn-block" type="button" onclick="cargar_doc(<?php echo $i ?>)" > Procesar Documentos <?php  ?></button>
                                                </td>
                                                <td>
                                                    
                                                </td>
                                            </tr>
                                            
                                            
                                      
                                   <?php } ?>                                    
                                  </tbody>
                               </table>
                             </div>  
                          </div> 
                          
                          <?php if ($existe_d!=0) { ?> 
                               <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                    <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" ><span style="color: #F8AC59;font-weight: bold;">NOTA IMPORTANTE: </span> Documento cargado sustituye al anterior. </label>
                                </div>
                              </div>                  
                          <?php } ?> 
                                                
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
