<?php
session_start();
if (isset($_SESSION['usuario'])) {
    
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$contratista=$_SESSION['contratista'];
$contrato=$_GET['contrato'];
$mensual=$_GET['mensual'];
$id=$_GET['id'];

$query_mensual=mysqli_query($con,"select m.*, t.*, c.*, a.* from mensuales_trabajador as m Left Join contratos as c On c.id_contrato=m.contrato Left Join trabajador as t On t.idtrabajador=m.trabajador Left Join mandantes as a On a.id_mandante=m.mandante where m.id_m='".$_GET['mensual']."' ");
$result_mensual=mysqli_fetch_array($query_mensual);
$documentos=unserialize($result_mensual['doc_contratista_mensuales']);

switch ($result_mensual['mes']) {
    case '1': $mes_control='ENERO';break;
    case '2': $mes_control='FEBRERO';break;
    case '3': $mes_control='MARZO';break;
    case '4': $mes_control='ABRIL';break;
    case '5': $mes_control='MAYO';break;
    case '6': $mes_control='JUNIO';break;
    case '7': $mes_control='JULIO';break;
    case '8': $mes_control='AGOSTO';break;
    case '9': $mes_control='SEPTIEMPRE';break;
    case '10': $mes_control='OCTUBRE';break;
    case '11': $mes_control='NOVIEMBRE';break;
    case '12': $mes_control='DICIEMBRE';break;
}    

$mes_entrega=$result_mensual['mes']+1;
switch ($mes_entrega) {
    case '1': $mes_entrega='ENERO';break;
    case '2': $mes_entrega='FEBRERO';break;
    case '3': $mes_entrega='MARZO';break;
    case '4': $mes_entrega='ABRIL';break;
    case '5': $mes_entrega='MAYO';break;
    case '6': $mes_entrega='JUNIO';break;
    case '7': $mes_entrega='JULIO';break;
    case '8': $mes_entrega='AGOSTO';break;
    case '9': $mes_entrega='SEPTIEMPRE';break;
    case '10': $mes_entrega='OCTUBRE';break;
    case '11': $mes_entrega='NOVIEMBRE';break;
    case '12': $mes_entrega='DICIEMBRE';break;
} 


?>  


<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    
     <title>FacilControl | Documentos mensuales</title>
     <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
    
     <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
    
   
   <script src="js\jquery-3.1.1.min.js"></script>
   
   <script>
   
   function regresar(url){
         window.location.href=url;
   }
   
   function cargar_mensual(trabajador,doc,contratista,mandante,contrato,mensual,mes){
               //alert(contratista);  
               var condicion=1;
               var fileInput = document.getElementById('carga');
               var filePath = fileInput.files.length;
               alert(fileInput);
               if (filePath>0) {
                   alert(contratista);  
                   var filePath = fileInput2.value;
                   var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
                   if(!allowedExtensions.exec(filePath)){
                        swal({
                            title: "Tipo No Permitido",
                            text: "Solo documentos PDF",
                            type: "warning"
                        });
                        return false;
                   }else {   
                        
                        var formData = new FormData(); 
                        var files= $('#carga')[0].files[0];
                                           
                        formData.append('archivo',files);                   
                        formData.append('trabajador', trabajador );
                        formData.append('documento', doc );
                        formData.append('contratista', contratista );
                        formData.append('mandante', mandante );
                        formData.append('contrato', contrato );
                        formData.append('mensual', mensual );
                        formData.append('mes', mes );
                        
                        //formData.append('com', com );
                        formData.append('condicion', condicion );
                        $.ajax({
                                url: 'cargar_ficheros_mensual.php',
                                type: 'post',
                                data:formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response==0) {                                        
                                        swal({
                                                title: "Documento Enviado",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                            });
                                        setTimeout(
                                        function() {
                        	               window.location.href='verificar_documentos_contratista_mensual.php';
                                        },3000);
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
                                }
                        });
                    } 
               } else {
                    swal({
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF/JPG/JPEG/PNG",
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
    
    </style>
   
</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Documentos Mensuales del Trabajador <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
            
           <form  method="post" id="frmObs">   
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                               <div class="ibox-title">
                                       
                                    <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="gestion_contratos.php?contratista=<?php echo $_SESSION['contratista'] ?>&contrato=<?php echo $_SESSION['verificar_contrato2'] ?>" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Gestion de Contrato</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="gestion_documentos_mensuales.php?contrato=<?php echo $_GET['contrato'] ?>&mensual=<?php echo $_GET['mensual'] ?>" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Gestion Documentos Mensuales </a>
                                      </div>
                                   </div>    
                                   <?php include('resumen.php') ?>
                                       <hr /> 
                                        <div class="row">
                                            <label  class="col-1 col-form-label">Trabajador: </label>
                                            <div class="col-11"><label class="col-11 col-form-label"><b><?php echo $result_mensual['nombre1'].' '.$result_mensual['nombre2'].' '.$result_mensual['apellido1'].' '.$result_mensual['apellido2']  ;?></b> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label">RUT: </label>
                                            <div class="col-11"><label class="col-11 col-form-label"><b><?php echo $result_mensual['rut']  ;?></b> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label">Contrato: </label>
                                            <div class="col-11"><label class="col-11 col-form-label"><b><?php echo $result_mensual['nombre_contrato']  ;?></b> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label">Mandante:</label>
                                            <div class="col-11"><label class="col-11 col-form-label"><b><?php echo $result_mensual['razon_social']?></b> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label">Mes:</label>
                                            <div class="col-11"><label class="col-11 col-form-label"><b><?php echo $mes_control ?></b> </label></div>
                                        </div>
                                        
                                        <div class="row">
                                            <label  class="col-1 col-form-label">Entrega:</label>
                                            <div class="col-11"><label class="col-11 col-form-label"><b><?php echo $result_mensual['dia'].'-'.$mes_entrega ?></b> </label></div>
                                        </div>
                                        
                                        
                                       <?php if ($result_obs['estado']==1 ) { 
                                              
                                              if ($result_obs['fecha']=='0000-00-00') {
                                                $fecha='Indefinido';    
                                              } else {
                                                $fecha=$result_obs['fecha'];
                                              }
                                            ?>
                                         <div class="row">
                                            <label  class="col-1 col-form-label"><b> Vencimiento: </b></label>
                                            <div class="col-11"><label class="col-11 col-form-label"><?php echo $fecha ;?> </label></div>
                                        </div>   
                                        <div class="row">
                                            <label  class="col-1 col-form-label"><b>Credencial: </b></label>
                                            <?php if ($result_obs['url_foto']=="") { ?>
                                                <div class="col-11"><button class="btn btn-sm btn-success" type="button" disabled="" ><i class="fa fa-file" aria-hidden="true"></i> Credencial Sin Foto</button></div>
                                            <?php } else { ?>
                                                <div class="col-11"><a class="btn btn-sm btn-success" type="button" href="credencial.php?id=<?php echo $id ?>&contratista=<?php echo $contratista ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> Descargar Credencial</a></div>
                                            <?php } ?>    
                                        </div>   
                                            
                                        <?php } ?>
                                </div>
                        
                        
                        <div class="ibox-content">
                        
                         
                       
                         <div class="row">                            
                                <!--<input type="hidden" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                                
                                <table class="table table-stripped table-responsive" data-page-size="15" data-filter="#filter">
                                
                                   <thead>
                                    <tr>
                                        <th style="width: 5%;" >Cargado</th>
                                        <th style="width: 30%;">Documento</th>
                                        <th style="width: 5%;text-align: center;">Verificado</th>
                                        <th style="width: 30%;">Observaciones</th> 
                                        <th style="width: 25%;text-align: center">Adjuntar</th>
                                        <th style="width: 5%;">Estado</th>
                                        
                                    </tr>
                                    </thead>
                                    
                                   <tbody>
                                    
                                    <?php          
                                         $i=0; 
                                         $cont_veri=0;
                                         $cont_doc=0;
                                         foreach ($documentos as $row) {
                                            $cont_doc=$cont_doc+1;
                                            $sql=mysqli_query($con,"select * from doc_mensuales where id_dm='$row' "); 
                                            $result=mysqli_fetch_array($sql);  
                                            
                                            #$query_com=mysqli_query($con,"select * from comentarios where id_obs='".$result_obs['id_obs']."' and doc='".$result['documento']."'  order by id_com desc  ");
                                            #$result_com=mysqli_fetch_array($query_com);
                                            #$list_com=$result_com['comentarios'];
                                              
                                            $arreglo=array(".png",".jpg",".jpeg",".pdf");
                                            for ($j=0;$j<=3;$j++) {
                                                $carpeta='doc/'.$contratista.'/trabajadores/'.$rut.'/'.$result['documento'].'_'.$rut.$arreglo[$j];
                                                $archivo_existe=file_exists($carpeta);
                                                if ($archivo_existe){
                                                    break;
                                                }
                                            }  ?>      
                                            
                                            <tr>                    
                                        <?php 
                                            # si archivo existe
                                            if ($archivo_existe) { ?>
                                                       
                                                       <!-- cargado -->
                                                       <td style="text-align:center"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></td>
                                                       
                                                       <!-- documento -->
                                                       <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>
                                                       <?php  
                                                       # si esta verificado 
                                                       if ($list_veri[$i]==0 ) { ?>
                                                       
                                                         <!-- verificado --> 
                                                         <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i?>"  disabled="" /></td>
                                                         
                                                         <!-- observaciones -->
                                                         <td>
                                                            <div class="btn-group"> 
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""><?php echo $list_com ?></textarea>
                                                                <button class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row ?>,<?php echo $result_obs['id_obs'] ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                            </div>
                                                         </td>
                                                         
                                                        <!-- adjuntar --> 
                                                        <td style="text-align:center">
                                                           <!-- <button class="btn btn-sm btn-primary" type="button" onclick="adjuntar('<?php echo $id ?>','<?php echo $result['id_doc'] ?>','<?php echo $result_com['id_com']?>','<?php echo $contratista ?>','<?php echo $mandante ?>','<?php echo $contrato ?>')"><i style="color: ;font-size: 20px;" class="fa fa-paperclip" aria-hidden="true"></i></button>-->
                                                            <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                 <span  style="background: #1BB394;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new">Sustituir&nbsp;&nbsp;&nbsp; Archivo</span>
                                                                 <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_trabajador<?php echo $i ?>" name="carga_doc_trabajador<?php echo $i ?>" accept="pdf" /></span>                                                             
                                                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                             </div>
                                                             <button style="background: #1CB394;border:#1CB394;color: #000;" title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"><i class="fa fa-upload" aria-hidden="true"></i></button>   
                                                        </td>
                                                        
                                                        
                                                        <!-- estado -->         
                                                        <?php  if ($result_com['doc']==$result['documento']) {
                                                                if ($result_com['leer_mandante']==1 and $result_com['leer_contratista']==1) { ?>
                                                                    <td style="text-align:center"><button style="width:100%" class="btn btn-sm btn-danger btn-block" type="button" title="observacion Atendida"><small>OBS.ATENDIDA</small></button></td>
                                                        <?php   }     
                                                               if ($result_com['leer_mandante']==0 and $result_com['leer_contratista']==0) { ?>
                                                                    <td style="text-align:center"><button style="width:100%" class="btn btn-sm btn-warning btn-block" type="button" title="observacion Recibida"><small>OBS.RECIBIDA</small></button></td>
                                                        <?php  }
                                                            } else { ?>
                                                                    <td style="text-align:center;"><button style="width:100%" class="btn btn-sm btn-primary btn-block" type="button" title="Documento por Verificar"><small>ENVIADO</small></button></td>
                                                      <?php }    
                                                      
                                                    # sino documento no esta verificado                                                         
                                                    } else {
                                                          $cont_veri=$cont_veri+1;?>
                                                          
                                                          <!-- verificado -->
                                                          <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" checked="" disabled=""  /></td>
                                                          
                                                          <!-- observaciones -->
                                                          <td>
                                                            <div class="btn-group"> 
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row ?>,<?php echo $result_obs['id_obs'] ?>)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                            </div>
                                                          </td> 
                                                          
                                                          <!-- adjuntar -->
                                                          <td style="text-align:center">
                                                              <!--<button class="btn btn-sm btn-primary" type="button" onclick="" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-paperclip" aria-hidden="true"></i></button>-->
                                                              <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                                 <span style="background: #1E84C6;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new">Archivo&nbsp;&nbsp;&nbsp; Validado</span>
                                                                 <span  class="fileinput-exists">Cambiar</span><input disabled=""  type="file" id="carga_doc_trabajador<?php echo $i ?>" name="carga_doc_trabajador<?php echo $i ?>" accept="pdf" /></span>                                                             
                                                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                               </div>
                                                               <button disabled=""  title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                                          </td>
                                                          
                                                          <!-- estado -->
                                                          <td style="text-align:center"><button style="width:100%" class="btn btn-sm btn-success btn-block" type="button" title="Documento Verificado"><small>VALIDADO</small></button></td>
                                                                        
                                                     <?php  }
                                                     
                                             # si documento no existe        
                                             } else { ?>
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
                                                   <td style="text-align:center">
                                                    <!--<button class="btn btn-sm btn-primary" type="button" onclick="adjuntar('<?php echo $id ?>','<?php echo $result['id_doc'] ?>','<?php echo $result_com['id_com'] ?>','<?php echo $contratista ?>','<?php echo $mandante ?>','<?php echo $contrato ?>')"><i style="color: ;font-size: 20px;" class="fa fa-paperclip" aria-hidden="true"></i></button>-->
                                                    
                                                        <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                             <span  style="background: #F8AC59;" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                             <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_trabajador<?php echo $i ?>" name="carga_doc_trabajador<?php echo $i ?>" accept="pdf" /></span>                                                             
                                                             <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                         </div>
                                                         <button style="background: #F8AC59;color: #000;border:#F8AC59" title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"><i class="fa fa-upload" aria-hidden="true"></i></button>
                                                   </td>
                                                   
                                                   <!-- estado -->
                                                   <td style="text-align:center"><button style="background: #F8AC59;border:#F8AC59;color:#000" style="width:100%" class="btn btn-sm  btn-danger btn-block" type="button" title="ENVIAR DOCUMENTO"><small>ENVIAR</small></button></td>
                                             <?php } ?> 
                                            </tr>
                                             
                                      <?php $i++;} ?>
                                      
                                  </tbody>
                               </table>
                               
                          </div> 
                           <input type="hidden" name="doc" value="<?php echo $result_doc['doc'] ?>" /> 
                           <div class="form-group row">
                             <div class="col-12">
                               
                                <?php if ($cont_veri==$cont_doc) { ?>
                                   <!-- <a class="btn btn-sm btn-primary" type="button" href="certificado.php?id=<?php echo $id ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> Descargar Certificado</a>-->
                                <?php } ?>  
                            </div>
                          </div>
                        </div>
                        
                        
                        
                      </div>
                   </div>
                 </form>  
               </div>
                        <script>
                               
                               function adjuntar(id,doc,contratista,mandante,contrato,mensual,mes) {
                                      //alert(id+'-'+doc+'-'+contratista+'-'+mandante+'-'+contrato+'-'+mensual+'-'+mes);
                                      $('.body').load('selid_ver_archivos_contratistas_mensual.php?trabajador='+id+'&doc='+doc+'&contratista='+contratista+'&mandante='+mandante+'&contrato='+contrato+'&mensual='+mensual+'&mes='+mes,function(){
                                                $('#modal_archivos').modal({show:true});
                                           });
                               }
                               
                                function modal_ver_obs(id_doc,id_obs) {
                                     // alert(id_doc+' '+id_obs);
                                      var condicion=0;
                                      $('.body').load('selid_ver_obs.php?doc='+id_doc+'&id_obs='+id_obs+'&condicion='+condicion,function(){
                                                $('#modal_ver_obs').modal({show:true});
                                           });
                                 } 
                         
                                   
                        
                        </script>
            
                         <div class="modal  fade" id="modal_archivos" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Adjuntar Documento Mensual</h3>
                                          <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="body">
                                        </div> 
                                        <div class="modal-footer">
                                           <button style="color: #fff;" class="btn btn-danger" value="" onclick="window.location.href='verificar_documentos_contratista_mensual.php?id=<?php echo $_GET['id'] ?>&contrato=<?php echo $_GET['contrato'] ?>&mensual=<?php echo $_GET['mensual'] ?>'" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
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

<script>

    $(document).ready(function() {

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
                    },5000)
                });
            
    });
                                        

</script>


</div>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
