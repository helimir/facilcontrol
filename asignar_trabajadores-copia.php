<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) ) { 
include('config/config.php');

session_destroy($_SESSION['active']);
$_SESSION['active']=33;


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');
 
$contrato=$_GET['contrato'];
$contratista=$_GET['contratista'];
$mandante=$_GET['mandante'];

//$contratos=mysqli_query($con,"SELECT c.* from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista where o.rut='".$_SESSION['usuario']."' ");
//$result_contratos=mysqli_fetch_array($contratos);



?>



<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">
<head>

    <link href="css\bootstrap.min.css" rel="stylesheet" />
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet" />
    <link href="css\animate.css" rel="stylesheet" />
    <link href="css\style.css" rel="stylesheet" />
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
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

</head>
<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;"><i class="fa fa-users" aria-hidden="true"></i> Asignar Trabajadores a Contrato <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                         <div class="ibox-title">
                              <div class="row">
                                  <div class="col-lg-12"> 
                                  
                                     <form  method="post" id="frmAsignar">
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
                                                 
                                                 $query=mysqli_query($con,"select t.* from trabajador as t where t.contratista='".$contratista."' ");
                                                 $result=mysqli_fetch_array($query);
                                                 
                                                 $asignados=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$contrato."' ");
                                                 $result=mysqli_fetch_array($asignados);
                                                 $trabajadores=unserialize($result['trabajadores']);
                                                 $cargos2=unserialize($result['cargos']);
                                                               
                                                 foreach ($query as $row) {                        
                                                            $query_cargos=mysqli_query($con,"select cargos from perfiles_cargos where contrato='".$contrato."' ");
                                                            $fila2=mysqli_fetch_array($query_cargos);
                                                            $cargos=unserialize($fila2['cargos']);
                                                              
                                                            $condicion=0;  
                                                            
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
                                                                                   
                                                                                   if ($condicion==1) {
                                                                                            echo '<td><select name="cargos[]" id="cargos'.$i.'" class="form-control" onchange="selcargos(this.value,'.$i.')">';
                                                                                               
                                                                                                echo '<option value="-1" >Seleccionar Cargo</option>';
                                                                                                                                             
                                                                                                
                                                                                                foreach ($cargos as $row3) {
                                                                                                   $query4=mysqli_query($con,"select * from cargos where idcargo=$row3 ");
                                                                                                   $fila4=mysqli_fetch_array($query4);
                                                                                                        echo '<option value="'.$fila4['idcargo'].'" >'.$fila4['cargo'].'</option>';
                                                                                                     
                                                                                                }                                            
                                                                                          echo ' </select></td>';   
                                                                                   } else {
                                                                                       foreach ($trabajadores as $row3) {
                                                                                           if ($row3==$row['idtrabajador']) {  
                                                                                             echo '<td style="">'.$fila3['cargo'].'</td>';
                                                                                             echo '<input type="hidden" name="cargos[]" id="cargos'.$i.'" value="'.$fila3['idcargo'].'"  /> '; 
                                                                                             break;
                                                                                           }
                                                                                      }
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
                                                                        $condicion=1;
                                                                        $check=1;
                                                                      }
                                                                   }
                                                                   if ($condicion==0) {      
                                                                        echo '<td><input class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'" disabled=""   /></td>';
                                                                        $condicion=0;
                                                                        $check=0;
                                                                   } ?>
                                                          </tr>
                                                     
                                             <?php $i++; } ?>                     
                                              <input type="hidden" name="contrato" value="<?php echo $contrato ?>" />
                                              <input type="hidden" name="mandante" value="<?php echo $mandante ?>" />
                                            
                                          </tbody>
                                       </table>
                                   </form>         
                                     
                                  </div>
                             </div>  
                             
                              <div class="row">
                                <div class="col-12">
                                    <div class="form-wrap">
                                        <button style="" class="btn btn-primary"  onclick="window.location.href='list_contratos_contratistas.php'" ><i class="fa fa-chevron-left" aria-hidden="true"></i> Volver Listado Contratos</button>
                                        <button style="" class="btn btn-success"  onclick="asignar_contrato()" ><i class="fa fa-user-plus" aria-hidden="true"></i> Confirmar Acci&oacute;n</button>
                                    </div>
                                </div>
                             </div>
                             
                                         
                         </div>
                            
                        <div class="ibox-content">
                        
                     
                                                    
                        </div>
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

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
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
                closeOnCancel: false ,
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
               			  method: "POST",
                          url: "add/quitar_cargo_trabajador.php",
                          data: 'id='+id+'&mandante='+mandante+'&contrato='+contrato,
               			  success: function(data){
               			   if (data==0) {   
               			      swal("Retirado!", "Trabajador retirado del Contrato.", "success");                              
                           } else {
                              swal("Cancelado!", "Trabajador retirado del Contrato.", "error");
                           }   
                          }                
                        });
                    } else {
                        swal("Cancelado", "Trabajador No retirado", "error");
                        $('#trabajador'+valor).prop("checked", true);
                    }
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


</body>

</html>
<?php } else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>
