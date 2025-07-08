<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    
 
$query=mysqli_query($con,"select o.*, c.*, t.*, t.rut as trut from observaciones as o Left Join contratos as c On c.id_contrato=o.contrato Left Join trabajador as t On t.idtrabajador=o.trabajador where o.trabajador='".$_GET['id']."' and c.id_contrato='".$_SESSION['contrato']."'  "); 
$result=mysqli_fetch_array($query);
$trabajador=$result['nombre1'].' '.$result['nombre2'].' '.$result['apellido1'].' '.$result['apellido2'];
$ruta='doc/acreditados/trabajadores/'.$_SESSION['contratista'].'/'.$_SESSION['contrato'].'/'.$result['trut'].'/';
$url ='doc/acreditados/trabajadores/'.$_SESSION['contratista'].'/'.$_SESSION['contrato'].'/bajar_doc_acreditados.php?trabajador='.$trabajador.'&contrato='.$result['nombre_contrato'].'&rut='.$result['trut']; 
?>
    
   <div class="modal-body">
     <!--<p><?php echo $_SESSION['contratista'].'/'.$_SESSION['contrato'] ?></p>-->
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
   
