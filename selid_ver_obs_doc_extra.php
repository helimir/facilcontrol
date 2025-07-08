<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    


    
    $query=mysqli_query($con,"select * from doc_comentarios_extra where  id_doc='".$_GET['doc']."' order by id_dcome desc ");
   
    
?>    
     <div class="modal-body">
        <div class="row">
            <table class="table ">
                <tbody>
                   <thead>
                       <tr>
                        <th>#</th>
                        <th>Comentario <?php echo $_GET['condicion'] ?></th>
                        <th>Fecha</th>
                       </tr> 
                   </thead> 
                 <?php 
                  $i=1;
                     if ($query=="") {
                          echo '<tr><td>Sin Observaciones</td></tr>';
                     } else {  
                     foreach ($query as $row) {   ?>
                        
                        <tr>
                            <td style="width: 2%"><?php echo $i ?></td>
                            <td style="width: 30%"><?php echo $row['comentarios']?></td>
                            <td style="width: 30%"><?php echo $row['creado']?></td>
                        </tr>  
                      <?php 
                         
                      $i++;}   
                     } ?>
                </tbody>
               </table>
            </div>
   
   </div>
   
   <div class="modal-footer">        
           <!--<button style="color: #fff;" class="btn btn-success" href="" onclick="asignar()"  >Asignar</button>-->     
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
   </div>
