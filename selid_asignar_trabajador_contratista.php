<?php
session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$contrato=$_GET['contrato'];
$contratista=$_GET['contratista'];
$mandante=$_GET['mandante'];

$query=mysqli_query($con,"select t.* from trabajador as t where t.contratista='$contratista' ");
$result=mysqli_fetch_array($query);


 
?>  <link href="css\bootstrap.min.css" rel="stylesheet" />
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet" />
    <link href="css\animate.css" rel="stylesheet" />
    <link href="css\style.css" rel="stylesheet" />
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
    
    </style>

   <form  method="post" id="frmAsignar"> 
    <div class="modal-body">
    
      <div class="row">
            <table class="table ">
            
               <thead>
                <tr>
                    <th>ID<?php  ?></th>
                    <th>Trabajador</th>
                    <th>RUT</th>
                    <th>Cargo</th>
                    <!--<th>Seleccion Cargo</th>-->
                    <th>Quitar</th>
                </tr>
                </thead>
                
               <tbody>
                
                <?php
                     $i=0;
                     $asignados=mysqli_query($con,"select * from trabajadores_asignados where contrato='$contrato' ");
                     $result=mysqli_fetch_array($asignados);
                     $trabajadores=unserialize($result['trabajadores']);
                     $cargos2=unserialize($result['cargos']);
                                    
                     foreach ($query as $row) {                        
                                $query_cargos=mysqli_query($con,"select cargos from perfiles_cargos where contrato='$contrato' ");
                                $fila2=mysqli_fetch_array($query_cargos);
                                $cargos=unserialize($fila2['cargos']);
                                $condicion=false;   
                                
                                
                                ?>
                               <tr>
                                  <td style=""><?php echo $row['idtrabajador'] ?></td>  
                                  <td style=""><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>
                                  <td style=""><?php echo $row['rut'] ?></td>
                                            <?php                                               
                                               
                                                   $query3=mysqli_query($con,"select * from cargos where idcargo=$cargos2[$i] ");
                                                   $fila3=mysqli_fetch_array($query3);
                                                   if ($fila3['cargo']=="") {
                                                        //echo '<td style="color:#FF0000">Sin Cargo2</td>';
                                                         echo '<td><select name="cargos[]" id="cargos'.$i.'" class="form-control" onchange="selcargos(this.value,'.$i.')">';
                                                            if ($fila3['idcargo']==0) {
                                                                echo '<option value="-1" >Seleccionar Cargo</option>';
                                                            } else {
                                                                echo '<option value="'.$fila3['idcargo'].'" >Seleccionar Cargo</option>';
                                                            }                                                    
                                                            
                                                            foreach ($cargos as $row3) {
                                                               $query4=mysqli_query($con,"select * from cargos where idcargo=$row3 ");
                                                               $fila4=mysqli_fetch_array($query4);
                                                                    echo '<option value="'.$fila4['idcargo'].'" >'.$fila4['cargo'].'</option>';
                                                              
                                                                 
                                                            }                                            
                                                        echo ' </select></td>';
                                                        
                                                        
                                                   } else { 
                                                       //echo '<td style="">'.$fila3['cargo'].'</td>';
                                                       $condicion2=false;  
                                                       foreach ($trabajadores as $row3) {
                                                           if ($row3==$row['idtrabajador']) {  
                                                             echo '<td style="">'.$fila3['cargo'].'</td>';
                                                              $condicion2=true;
                                                           }
                                                      }
                                                      if ($condicion2==false) {   
                                                              echo '<td><select name="cargos[]" id="cargos'.$i.'" class="form-control" onchange="selcargos(this.value,'.$i.')">';
                                                                if ($fila3['idcargo']==0) {
                                                                    echo '<option value="-1" >Seleccionar Cargo</option>';
                                                                } else {
                                                                    echo '<option value="'.$fila3['idcargo'].'" >Seleccionar Cargo</option>';
                                                                }                                                    
                                                                
                                                                foreach ($cargos as $row3) {
                                                                   $query4=mysqli_query($con,"select * from cargos where idcargo=$row3 ");
                                                                   $fila4=mysqli_fetch_array($query4);
                                                                        echo '<option value="'.$fila4['idcargo'].'" >'.$fila4['cargo'].'</option>';
                                                                  
                                                                     
                                                                }                                            
                                                            echo ' </select></td>';
                                                           }  
                                                        
                                                   } 
                                              ?>
                                  
                                  <!--<td style="">
                                        <select name="cargos[]" id="cargos<?php echo $i ?>" class="form-control" onchange="selcargos(this.value,<?php echo $i ?>)">
                                                <?php
                                                
                                                //if ($fila3['idcargo']==0) {
                                                  //  echo '<option value="-1" >Seleccionar Cargo</option>';
                                                //} else {
                                                  //  echo '<option value="'.$fila3['idcargo'].'" >Seleccionar Cargo</option>';
                                                //}                                                    
                                                
                                                //foreach ($cargos as $row3) {
                                                  // $query4=mysqli_query($con,"select * from cargos where idcargo=$row3 ");
                                                   //$fila4=mysqli_fetch_array($query4);
                                                       // echo '<option value="'.$fila4['idcargo'].'" >'.$fila4['cargo'].'</option>';
                                                  
                                                     
                                                //}  ?>                                           
                                        </select>
                                  </td>-->
                                  
                                   <?php 
                                      
                                      foreach ($trabajadores as $row2) { 
                                        if ($row2==$row['idtrabajador']) {                                               
                                            //echo '<td><input class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'"  onclick="prueba(this.value,'.$mandante.','.$contrato.','.$i.')" checked="" /></td>';
                                            echo '<td><input class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'"  onclick="" checked="" /></td>';
                                            $condicion=true;
                                          }
                                       }
                                       if ($condicion==false) {      
                                            echo '<td><input class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'" disabled=""   /></td>';
                                       } ?>
                              </tr>
                         
                 <?php $i++; } ?>                     
                  <input type="hidden" name="contrato" value="<?php echo $contrato ?>" />
                  <input type="hidden" name="mandante" value="<?php echo $mandante ?>" />
                
              </tbody>
           </table>
      </div>
   </div>
   <div class="modal-footer">
            <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</a>
            <a style="color: #fff;" class="btn btn-success" href="" onclick="asignar_contrato()" ><i class="fa fa-user-plus" aria-hidden="true"></i> Confirmar Acci&oacute;n</a>
  </div>
  </form> 

<!-- Mainly scripts -->
    
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>
    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>


<!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
<!-- iCheck -->
    
    <script>
    
     function selcargos(id,valor) {
        //alert(id+' '+valor);
        if (id==-1) {
            $('#trabajador'+valor).prop('disabled',true);
            $('#trabajador'+valor).prop('checked',false);
        } else {
            $('#trabajador'+valor).prop('disabled',false);
            $('#trabajador'+valor).prop('checked',true);
        }    
        
     }
     
     function quitar(id,item) {
         var valor=document.getElementById("cargos"+id).value =-1
         alert(valor+' '+item)
     }
      
      function prueba(id,mandante,contrato,valor) {  
        //alert(valor);
        var isChecked =$('#trabajador'+valor).prop('checked');
        if(isChecked){
            //alert('checkbox esta seleccionado');
        } else {
            swal({
                title: "Retirar Trabajador?",
                //text: "Your will not be able to recover this imaginary file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, Retirar",
                cancelButtonText: "No, Retirar",
                closeOnConfirm: false,
                closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
               			  method: "POST",
                          url: "add/quitar_cargo_trabajador.php",
                          data: 'id='+id+'&mandante='+mandante+'&contrato='+contrato,
               			  success: function(data){
               			      swal("Retirado!", "Trabajador retirado del Contrato.", "success");
                              delay(3000);
                              //window.location.href='list_contratos_contratistas.php';
                          }                
                        });
                    } else {
                        swal("Cancelado", "Trabajador No retirado", "error");
                        $('#trabajador'+valor).prop("checked", true);
                    }
                });
        }          
      }
              
          
       function asignar_contrato() {
         //alert('hola');
          var valores=$('#frmAsignar').serialize();
            $.ajax({
    			method: "POST",
                url: "add/asignar_contrato.php",
                data: valores,
    			success: function(data){
                 if (data==0) {         
                    swal({
                        title: "Trabajadores Asignados",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                    setTimeout(window.location.href='list_contratos_contratistas.php',3000);
    			  } 
                  if (data==1) {
                     swal({
                        title: "Trabajadores No Asignados",
                        text: "Vuelva a Intentar",
                        type: "error"
                    });
                    setTimeout(window.location.href='list_contratos_contratistas.php',3000)
    			  }
                  if (data==2) {
                    swal({
                        title: "Asignacion Actualizada",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                    setTimeout(window.location.href='list_contratos_contratistas.php',3000)
    			  }
                  if (data==3) {
                    swal({
                        title: "Asignacion No Actualizada",
                        text: "Vuelva a Intentar",
                        type: "error"
                    });
                   setTimeout(window.location.href='list_contratos_contratistas.php',3000)
                                                    
    			  }
    			}                
           });
         }


</script>

        
        