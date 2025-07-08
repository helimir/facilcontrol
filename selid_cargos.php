<?php

session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");    
 
   

    $sql_mandante=mysqli_query($con,"select * from mandantes where email='".$_SESSION['usuario']."'  ");
    $result=mysqli_fetch_array($sql_mandante);
    $mandante=$result['id_mandante'];
       
    $query=mysqli_query($con,"select cargos from contratos where id_contrato='".$_GET['id']."' ");
    $fila=mysqli_fetch_array($query);
    $valor=unserialize($fila['cargos']);
    
    
    echo '<div class="modal-body"> ';
    
     //echo '<div class="row">';
       //echo '<h3 class=""><strong>Perfil: </strong> '.$fila['nombre_perfil'].' </h3> ';
      //echo '</div>';    
    
    echo '<div class="row">';
        echo '<table class="table ">';
            
                echo '<tbody>';
                 
                 foreach ($valor as $row) {
                       
                       $query2=mysqli_query($con,"select e.nombre_perfil, c.cargo, p.perfil from cargos as c Left Join perfiles_cargos as p On p.cargo=c.cargo Left Join perfiles as e On e.id_perfil=p.perfil where c.idcargo='$row'  ");
                       $fila2=mysqli_fetch_array($query2); 
                       
                       $queryperfil=mysqli_query($con,"select * from  perfiles where id_mandante='$mandante'"); 
                      
                       
                       //if ($fila2) {?>
                           <tr>
                                <td style="width: 30%"><?php echo $fila2['cargo']?></td>
                                <?php if (empty($fila2['perfil'])) { ?>
                                    <td style="width: 30%">SIN PERFIL</td>
                                <?php } else { ?>
                                    <td style="width: 30%"><?php echo $fila2['nombre_perfil']?></td>
                                <?php } ?>   
                                <td style="width: 40%">
                                            <select name="perfil" id="perfil" class="form-control" onchange="ShowSelected(this.value,'<?php echo $fila2['cargo'] ?>','<?php echo $mandante ?>','<?php echo $_GET['id'] ?>')">
                                                <?php  
                                                
                                                   echo '<option value="0" selected="">Seleccionar Perfil</option>'; 
                                                 
                                              
                                               while($row = mysqli_fetch_assoc($queryperfil)) {
                                                   echo '<option value="'.$row['id_perfil'].'">'.$row['nombre_perfil'].'</option>';  
                                                }  ?>                                           
                                            </select>
                                  </td>
                             </tr>
                             
                           
                  <?php }   ?> 
                 
                </tbody>
               </table>
            </div>
   
   </div>
   
   <div class="modal-footer">        
           <!--<button style="color: #fff;" class="btn btn-success" href="" onclick="asignar()"  >Asignar</button>-->     
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
   </div>
   
<script>
                  
                         
function ShowSelected(perfil,cargo,mandante,contrato) { 
          //alert(perfil+cargo+mandante+contrato);  
          $.ajax({
       			method: "POST",
                url: "add/perfil_cargo.php",
                data: 'perfil='+perfil+'&cargo='+cargo+'&mandante='+mandante+'&contrato='+contrato,
       			success: function(data){
                if (data==0) {
                    swal({
                        title: "Perfil Asignado",
                        type: "success"
                    });
                    //setTimeout(refresh, 1000);
                    //window.location.href='list_perfil.php';
    		      } else {
                      if (data==1) {     
                        swal("Cancelado", "Perfil No Asignado. Vuelva a Intentar.", "error");                       
                      } else {
                         swal({ 
                            title: "Perfil Actualizado",
                            type: "success" 
                         });   
                      } 
       			  }
   			  }                
           });
}

</script>
