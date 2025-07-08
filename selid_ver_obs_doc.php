<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    


       
 if ($_GET['condicion']==0) {
    $sql=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$_GET['doc']."' "); 
    $result=mysqli_fetch_array($sql);
    
    $query=mysqli_query($con,"select * from doc_comentarios where  id_dobs='".$_GET['id_dobs']."' and doc='".$result['documento']."' order by id_dcom desc ");
 } else {
    $sql=mysqli_query($con,"select * from doc_mensuales where id_dm='".$_GET['doc']."' "); 
    $result=mysqli_fetch_array($sql);
    
    $query=mysqli_query($con,"select * from doc_comentarios_mensuales where  id_dobs='".$_GET['id_dobs']."' and doc='".$result['documento']."' order by id_dcom desc ");
 }  
    
    
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
