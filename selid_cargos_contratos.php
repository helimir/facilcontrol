<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    

       
    $query=mysqli_query($con,"select cargos from contratos where id_contrato='".$_GET['contrato']."' ");
    $fila=mysqli_fetch_array($query);
    $valor=unserialize($fila['cargos']);
    
?>    
     <div class="modal-body">
        <div class="row">
            <table class="table ">
                <tbody>
                 <?php 
                  $i=1;
                  foreach ($valor as $row) {
                    
                    $query2=mysqli_query($con,"select * from cargos where idcargo='".$row."' ");
                    $fila2=mysqli_fetch_array($query2);   ?>
                    
                    <tr>
                        <td style="width: 2%"><?php echo $i ?></td>
                        <td style="width: 30%"><?php echo $fila2['cargo']?></td>
                    </tr>  
                  <?php $i++;}   ?>
                </tbody>
               </table>
            </div>
   
   </div>
   
   <div class="modal-footer">        
           <!--<button style="color: #fff;" class="btn btn-success" href="" onclick="asignar()"  >Asignar</button>-->     
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
   </div>
