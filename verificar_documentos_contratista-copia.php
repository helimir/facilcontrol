<?php
session_start();
if (isset($_SESSION['usuario'])) {
    
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$id=$_SESSION['verificar_id2'];
$idcargo=$_SESSION['verificar_cargo2'];
$perfil=$_SESSION['verificar_perfil2'];

$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];
$contrato=$_SESSION['contrato'];

$query_trabajador=mysqli_query($con,"select * from trabajador where idtrabajador='".$_SESSION['verificar_id2']."' ");
$result_trabajador=mysqli_fetch_array($query_trabajador);
$rut=$result_trabajador['rut'];

$query_perfil_cargo=mysqli_query($con,"select * from perfiles_cargos where contrato='".$_SESSION['verificar_contrato2']."' ");
$result_perfil_cargo=mysqli_fetch_array($query_perfil_cargo);


$query_contrato=mysqli_query($con,"select o.razon_social, c.* from contratos as c LEFT JOIN contratistas as o On o.id_contratista=c.contratista where c.id_contrato='".$_SESSION['verificar_contrato2']."' ");
$result_contrato=mysqli_fetch_array($query_contrato);

$query_cargos=mysqli_query($con,"select * from cargos where idcargo='".$_SESSION['verificar_cargo2']."' ");
$result_cargo=mysqli_fetch_array($query_cargos);

#$query_obs=mysqli_query($con,"select * observaciones where contrato='".$_SESSION['verificar_contrato2']."' and trabajador='".$_SESSION['verificar_id2']."' ");
#$result_obs=mysqli_fetch_array($query_obs);
#$list_verificados=unserialize($result_obs['verificados']);

$cargos=unserialize($result_perfil_cargo['cargos']);
$perfiles=unserialize($result_perfil_cargo['perfiles']);

$query_obs=mysqli_query($con,"select o.*, t.url_foto from observaciones as o left join trabajador as t On t.idtrabajador=o.trabajador where o.contrato='".$_SESSION['verificar_contrato2']."' and o.trabajador='".$_SESSION['verificar_id2']."' ");
$result_obs=mysqli_fetch_array($query_obs);
$list_veri=unserialize($result_obs['verificados']);

$contrato=$result_contrato['id_contrato'];
$mandante=$result_contrato['mandante'];

$contador=0;
foreach ($cargos as $row) {    
    if ($row==$idcargo) {
            $posicion_cargo=$contador;
            break;
        }    
    $contador++;
}

$contador=0;
foreach ($perfiles as $row) {    
    if ($contador==$posicion_cargo) {
            //$perfil=$row;
            break;
        }    
    $contador++;
}


$query_doc=mysqli_query($con,"select * from perfiles where id_perfil='$perfil' ");
$result_doc=mysqli_fetch_array($query_doc); 

$documentos=unserialize($result_doc['doc']);

?>  

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Documentos Trabajador</title>
    
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
    
    
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
    

<script src="js\jquery-3.1.1.min.js"></script>
   
   <script>
   
   function regresar(url){
         window.location.href=url;
   }
   
   function cargar(trabajador,doc,com,id){
               //alert('si');  
               var condicion=1;
               var idnombre_t= 'carga_doc_trabajador'+id;
               var fileInput = document.getElementById(idnombre_t);
               var filePath = fileInput.files.length;
               
               if (filePath>0) {
                   
                   var filePath = fileInput.value;
                   var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
                   if(!allowedExtensions.exec(filePath)){
                        swal({
                            title: "Tipo No Permitido",
                            text: "Solo documentos PDF",
                            type: "warning"
                        });
                        return false;
                   } else {   
                        //alert(contratista); 
                        var formData = new FormData(); 
                        var idnombre_t= '#carga_doc_trabajador'+id;
                        var files= $(idnombre_t)[0].files[0];
                                           
                        formData.append('archivo',files);                   
                        formData.append('trabajador', trabajador );
                        formData.append('documento', doc );
                        //formData.append('contratista', contratista );
                        //formData.append('mandante', mandante );
                        //formData.append('contrato', contrato );
                        
                        formData.append('com', com );
                        formData.append('condicion', condicion );
                        $.ajax({
                                url: 'cargar_ficheros.php',
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
                        	               window.location.href='verificar_documentos_contratista.php';
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
          /* Doble-tamaño Checkboxes */
          -ms-transform: scale(2); /* IE */
          -moz-transform: scale(2); /* FF */
          -webkit-transform: scale(2); /* Safari y Chrome */
          -o-transform: scale(2); /* Opera */
          padding: 10px;
        }
        
        /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificación */
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
                    <h2 style="color: #010829;font-weight: bold;">Documentos del Trabajador <?php  ?></h2>
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
                                        <a  class="btn btn-md btn-success btn-submenu" href="gestion_contratos.php?contratista=<?php echo $_SESSION['contratista'] ?>&contrato=<?php echo $_SESSION['verificar_contrato2'] ?>" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i>Gestion de Contrato</a>&nbsp;
                                        <a  class="btn btn-md btn-success btn-submenu" href="trabajadores_acreditados.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i>Trabajadores Acreditados</a>
                                      </div>
                                   </div>    
                                       <hr /> 
                       
                                        <div class="row">
                                            <label  class="col-1 col-form-label"><b> Contrato: </b></label>
                                            <div class="col-11"><label class="col-11 col-form-label"><?php echo $result_contrato['nombre_contrato']?> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label"><b> Trabajador: </b></label>
                                            <div class="col-11"><label class="col-11 col-form-label"><?php echo $result_trabajador['nombre1'].' '.$result_trabajador['nombre2'].' '.$result_trabajador['apellido1'].' '.$result_trabajador['apellido2']  ;?> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label"><b> RUT: </b></label>
                                            <div class="col-11"><label class="col-11 col-form-label"><?php echo $result_trabajador['rut'] ;?> </label></div>
                                        </div>
                                        <div class="row">
                                            <label  class="col-1 col-form-label"><b> Cargo: </b></label>
                                            <div class="col-11"><label class="col-11 col-form-label"><?php echo $result_cargo['cargo'] ;?> </label></div>
                                        </div>
                                        
                                        <div class="row">
                                            <label  class="col-1 col-form-label"><b> Documentos: </b></label>
                                            <div style="padding: auto;" class="col-8">
                                              <?php 
                                                    $url ='doc/validados/contratistas/'.$mandante.'/'.$_SESSION['doc_contratista'].'/documentos_validados_contratista_'.$result_contratista['rut'].'.zip';
                                                    if ($result_obs['estado']==1) { ?>   
                                                   <label class="col-11 col-form-label"><a style="margin-left: 2%;" class="" href="bajar.php?mandante=<?php echo $mandante ?>&contratista=<?php echo $contratista ?>&rut=<?php echo $result_contratista['rut'] ?>" ><u>Descargar Documentos</u></a></label>
                                              <?php } else { ?>
                                                   <label class="col-11 col-form-label"><a style="margin-left: 2%;" class=""><u>Trabajador No Acreditado</u></a></label>
                                              <?php } ?>     
                                            </div>
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
                                        <th style="width: 25%;">Documento</th>
                                        <th style="width: 5%;text-align: center;">Verificado</th>
                                        <th style="width: 35%;">Observaciones</th> 
                                        <th style="width: 20%;text-align: center">Adjuntar</th>
                                        <th style="width: 10%;">Estado</th>
                                        
                                    </tr>
                                    </thead>
                                    
                                   <tbody>
                                    
                                    <?php          
                                         $i=0; 
                                         $cont_veri=0;
                                         $cont_doc=0;
                                         foreach ($documentos as $row) {
                                            $cont_doc=$cont_doc+1;
                                            $sql=mysqli_query($con,"select * from doc where id_doc='$row' "); 
                                            $result=mysqli_fetch_array($sql);  
                                            
                                            $query_com=mysqli_query($con,"select * from comentarios where id_obs='".$result_obs['id_obs']."' and doc='".$result['documento']."'  order by id_com desc  ");
                                            $result_com=mysqli_fetch_array($query_com);
                                            $list_com=$result_com['comentarios'];
                                              
                                            $arreglo=array(".png",".jpg",".jpeg",".pdf");
                                            for ($j=0;$j<=3;$j++) {
                                                $carpeta='doc/trabajadores/contratos/'.$mandante.'/'.$contratista.'/'.$rut.'/'.$result['documento'].'_'.$rut.$arreglo[$j];
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
                                                       <td style="text-align:center"><a href="<?php echo $carpeta ?>" target="_blank"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></a></td>
                                                       
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
                                                            <div style="width: 100%;background: #969696;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                 <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file btn-block"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Sustituir Archivo</span>
                                                                 <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_trabajador<?php echo $i ?>" name="carga_doc_trabajador[]" multiple="" accept="pdf" /></span>                                                             
                                                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                             </div>
                                                             <!--<button style="background: #1CB394;border:#1CB394;color: #000;" title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"><i class="fa fa-upload" aria-hidden="true"></i></button>-->   
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
                                                                    <td style="text-align:center"><div style="font-size: 12px;" class="bg-primary p-xxs b-r-sm text-white">ENVIADO</div></td>
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
                                                              <div style="width: 100%;background: #969696;color:#fff"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                 <span style="background: #969696;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file btn-block"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Archivo Validado</span>
                                                                 <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_trabajador<?php echo $i ?>" name="carga_doc_trabajador[]" multiple="" accept="pdf" /></span>                                                             
                                                                 <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                               </div>
                                                               <!--<button disabled=""  title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"><i class="fa fa-upload" aria-hidden="true"></i></button>-->
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
                                                        <div style="width: 100%;background: #969696;color:#fff" class="fileinput fileinput-new" data-provides="fileinput">
                                                             <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file btn-block"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo</span>
                                                             <span  class="fileinput-exists">Cambiar</span><input  type="file" id="carga_doc_trabajador<?php echo $i ?>" name="carga_doc_trabajador[]" multiple="" accept="pdf" /></span>                                                             
                                                             <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                         </div>
                                                         <!--<button style="background: #F8AC59;color: #000;border:#F8AC59" title="Cargar Archivo" class="ladda-button btn-success btn btn-md " data-style="expand-right" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"><i class="fa fa-upload" aria-hidden="true"></i></button>-->
                                                   </td> 
                                                   
                                                   <!-- estado -->
                                                   <td style="text-align:center"><div style="font-size: 12px;" class="bg-warning p-xxs b-r-sm text-primary">NO ENVIADO</div></td>
                                             <?php } ?> 
                                            </tr>
                                             
                                      <?php $i++;} ?>
                                      
                                            <tr>
                                                <td colspan="4"></td>
                                                <td >
                                                    <?php  if ($acreditada==1) { ?>
                                                        <button id="" style="" title="Cargar Archivo" class="btn-success btn btn-md btn-block" type="button" disabled="" ><i class="fa fa-upload" aria-hidden="true"></i> Enviar Documentos <?php  ?></button>
                                                    <?php } else { ?>
                                                        <button id="" style="" title="Cargar Archivo" class="btn-success btn btn-md btn-block" type="button" onclick="cargar('<?php echo $id ?>','<?php echo $result['id_doc']  ?>','<?php echo $result_com['id_com']  ?>','<?php echo $contratista  ?>','<?php echo $mandante  ?>','<?php echo $contrato  ?>','<?php echo $i ?>')"" ><i class="fa fa-upload" aria-hidden="true"></i> Procesar Documentos <?php  ?></button>
                                                    <?php } ?>   
                                                </td>
                                                <td></td>
                                            </tr>
                                      
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
                               
                               function adjuntar(id,doc,com,contratista,mandante,contrato) {
                                      $('.body').load('selid_ver_archivos_contratistas.php?trabajador='+id+'&doc='+doc+'&com='+com+'&contratista='+contratista+'&mandante='+mandante+'&contrato='+contrato,function(){
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
                                          <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Adjuntar Documento</h3>
                                          <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="body">
                                        </div> 
                                        <div class="modal-footer">
                                           <button style="color: #fff;" class="btn btn-danger" value="" onclick="window.location.href='verificar_documentos_contratista.php'" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
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
