<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    
 
$query=mysqli_query($con,"select c.* from doc_observaciones as o Left Join contratistas as c On c.id_contratista=o.contratista where c.id_contratista='".$_GET['id']."' "); 
$result=mysqli_fetch_array($query);
$contratista=$result['razon_social'];
$ruta='doc/contratistas/acreditadas/'.$_SESSION['doc_contratista'].'/';
$url ='doc/contratistas/acreditadas/bajar_doc_acreditados_contratistas.php?contratista='.$contratista.'&id='.$_GET['id']; 
?>
    
   <div class="modal-body">
     <div class="row">
        <table class="table ">            
           <tbody>
                 <?php 
                  if ($handler = opendir($ruta)) {
                        $i=1;
                        while (false !== ($file = readdir($handler))) {
                          if ($file!="." && $file!="..") {
                          echo '<tr>
                                  <td>'.$i.'</td>
                                  <td><a style="color:#282828;text-decoration: underline;" href="'.$ruta.$file.'" " target="_black">'.$file.'</a></td>
                               </tr>';
                           $i++;    
                          }     
                        }
                        closedir($handler);
                    }
                
                 
                 ?> 
                 
           </tbody>
       </table>
     </div>
     
     <!--<div class="row">
        <a class="btn btn-success btn-sm" href="<?php echo $url ?>"><i class="fa fa-upload"></i> Descargar Documentos</a>
     </div>-->
                    
   </div>
   
   <div class="modal-footer">        
           <!--<button style="color: #fff;" class="btn btn-success" href="" onclick="asignar()"  >Asignar</button>-->   
            <a class="btn btn-success btn-sm" href="<?php echo $url ?>"><i class="fa fa-upload"></i> Descargar Documentos</a>  
            <a style="color: #fff;" class="btn btn-danger btn-sm" data-dismiss="modal" >Cerrar</a>
   </div>
   
