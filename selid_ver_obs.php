<?php
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    
 
$sql=mysqli_query($con,"select * from doc where id_doc='".$_GET['doc']."' "); 
$result=mysqli_fetch_array($sql);
       
 
 $query=mysqli_query($con,"select * from comentarios where contrato='".$_GET['contrato']."' and doc='".$result['documento']."' and trabajador='".$_GET['id']."' and tipo='0' order by id_com desc ");
 $existe=mysqli_num_rows($query);
    
    
    
?>    
     <div class="modal-body">
        <div class="row">
            <table class="table ">
                <tbody>
                   <thead>
                       <tr>
                        <th>#</th>
                        <th>Comentario</th>
                        <th>Fecha</th>
                       </tr> 
                   </thead> 
                 <?php 
                  if ($existe>0) {
                     $i=1;                         
                        foreach ($query as $row) {   ?>
                           
                           <tr>
                              <td style="width: 2%"><?php echo $i ?></td>
                              <td style="width: 30%"><?php echo $row['comentarios']?></td>
                              <td style="width: 30%"><?php echo $row['creado']?></td>
                           </tr>  
                        <?php 
                           
                        $i++;}   
                         
                     } else { ?>
                        <tr>
                           <td style="font-size:16px;font-weight:bold" colspan="3">Sin observaciones</td>
                        </tr>
                     <?php
                     }
                     ?>
                </tbody>
               </table>
            </div>
   
   </div>
   
   <div class="modal-footer">        
           <!--<button style="color: #fff;" class="btn btn-success" href="" onclick="asignar()"  >Asignar</button>-->     
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
   </div>
