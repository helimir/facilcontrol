<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];
$contrato=$_SESSION['contrato'];

if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}

$query_contrato=mysqli_query($con,"select * from contratos where id_contrato='".$_SESSION['contrato']."' ");
$result_contrato=mysqli_fetch_array($query_contrato);

?>



<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Asignar Vehiculos</title>    

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet" />
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet" />
    <link href="css\animate.css" rel="stylesheet" />
    <link href="css\style.css" rel="stylesheet" />
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

    <script src="js\jquery-3.1.1.min.js"></script> 

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

    .loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #1C84C6;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
}  

.cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }


@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

    
</style>
    
    <script>
    
    $(document).ready(function(){
        $('#menu-contratos').attr('class','active');       
             
    });

     function selcargos(id,valor) {
        //alert(id);
        if (id==0) {
            $('#vehiculo'+valor).prop('disabled',true);
            $('#vehiculo'+valor).prop('checked',false);
        } else {
            $('#vehiculo'+valor).prop('disabled',false);
            $('#vehiculo'+valor).prop('checked',true);
        }    
        
     }
     
         
    function asignar_contrato(cant) {
        var chequeado=false;
        //alert(cant)
        for (i=0;i<=cant-1;i++) {
          if ( $('#vehiculo'+i).prop('checked') ) {            
            var chequeado=true;
          }            
        }    
        if (chequeado) {
            var valores=$('#frmAsignar').serialize();
            $.ajax({
    			method: "POST",
                url: "add/asignar_vehiculo.php",
                data: valores,
                beforeSend: function() {
                         const progressBar = document.getElementById('myBar');
                        const progresBarText = progressBar.querySelector('.progress-bar-text');
                        let percent = 0;
                        progressBar.style.width = percent + '%';
                        progresBarText.textContent = percent + '%';
                                            
                        let progress = setInterval(function() {
                            if (percent >= 100) {
                                clearInterval(progress);                                                                                                       
                            } else {
                                percent = percent + 1; 
                                progressBar.style.width = percent + '%';
                                progresBarText.textContent = percent + '%';
                            }
                        }, 100);
                    $('#modal_cargar').modal('show');						
    			},
    			success: function(data){
                 $('#modal_cargar').modal('hide');
                 if (data==0) {         
                    swal({
                        title: "Vehiculos Asignados",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                    window.location.href='vehiculos_asignados_contratista.php';
    			  } 
                  if (data==1) {
                     swal({
                        title: "Disculpe, Error de Sistema",
                        text: "Vuelva a Intentar",
                        type: "error"
                    });
                    
    			  }
                  if (data==2) {
                    swal({
                        title: "Asignacion Actualizada",
                        //text: "You clicked the button!",
                        type: "success"
                    });
                    window.location.href='vehiculos_asignados_contratista.php';
    			  }
                  if (data==3) {
                    swal({
                        title: "Asignacion No Actualizada",
                        text: "Vuelva a Intentar",
                        type: "error"
                    });
                   
                                                    
    			  }
    			},
                complete:function(data){
                    $('#modal_cargar').modal('hide');
                }, 
                error: function(data){
                }                
           });
        } else {
            swal({
                title: "Por favor, seleccione al menos un Vehículo/Maquinaria",
                //text: "You clicked the button!",
                type: "warning"
            });
        }
    }


</script>

</head>
<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Asignar Vehiculo/Maquinaria al Contrato: [<?php echo $result_contrato['nombre_contrato'] ?>]</h2>
                    <label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                         
                          <div class="ibox-title">
                             <div class="row">
                                <div class="col-12">
                                    <div class="form-wrap">                                        
                                        <a class="btn btn-sm btn-success btn-submenu" href="crear_auto.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Vehículos/Maquinarias</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="vehiculos_asignados_contratista.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Gestión Vehículos/Maquinarias</a>
                                    </div>
                                </div>
                             </div>
                             <?php include('resumen.php') ?>
                         </div>  
                                                 
                         <div class="ibox-content">
                              <div class="row">
                                  <div class="col-lg-12">
                                     <form  method="post" id="frmAsignar">
                                        <table class="table ">
                                           <thead class="cabecera_tabla">
                                            <tr>
                                                <th style="width:2%;border-right:1px #fff solid">#</th>
                                                <th style="width:30%;border-right:1px #fff solid">Vehículo/Maquinaria</th>
                                                <th style="width:10%;border-right:1px #fff solid">Patente</th> 
                                                <th style="width:10%;border-right:1px #fff solid">Sigla</th> 
                                                <th style="width:30%">Función</th>
                                                <!--<th>Asignar</th>-->
                                            </tr>
                                            </thead>
                                            
                                           <tbody>
                                            
                                            <?php
                                                 $i=0;
                                                 $num=1;
                                                 
                                                 $query_perfiles=mysqli_query($con,"select * from perfiles_vehiculos where contrato='".$contrato."' ");
                                                 $fila=mysqli_fetch_array($query_perfiles);
                                                 $vehiculos=unserialize($fila['vehiculos']);
                                                 $perfiles=unserialize($fila['perfiles']);
                                                 
                                                 $query=mysqli_query($con,"select t.* from autos as t where t.contratista='".$contratista."' and t.eliminar=0  ");
                                                 $result=mysqli_fetch_array($query);
                                                 $cantidad=mysqli_num_rows($query);
                                                 
                                                 $asignados=mysqli_query($con,"select vehiculos from vehiculos_asignados where contrato='".$contrato."' and estado=0  ");
                                                           
                                                         foreach ($query as $row) {                         
                                                                  $excluir=false; 
                                                                  foreach ($asignados as $vehi_asig) {
                                                                    if ($vehi_asig['vehiculos']==$row['id_auto']) {
                                                                        $excluir=true;
                                                                    }                                                                  
                                                                   }
                                                                  if ($excluir==false) {      
                                                                      
                                                                      echo '<tr> 
                                                                          <td style="">'.$num.'</td>  
                                                                          <td style="">'.$row['tipo'].' '.$row['marca'].' '.$row['modelo'].' año: '.$row['year'].' </td>
                                                                          <td style="">'.$row['patente'].'</td>
                                                                          <td style="">'.$row['siglas'].'-'.$row['control'].'</td>
                                                                          <td><select name="cargos[]" id="cargos'.$i.'" class="form-control" onchange="selcargos(this.value,'.$i.')">
                                                                          <option value="0" >Seleccionar Función</option>';
                                                                          foreach ($vehiculos as $row_v) {
                                                                                $query_auto=mysqli_query($con,"select * from tipo_autos where id_ta='$row_v' ");
                                                                                $result_auto=mysqli_fetch_array($query_auto); 
                                                                                echo '<option value="'.$result_auto['id_ta'].'" >'.$result_auto['auto'].'</option>';
                                                                          }                                           
                                                                          echo '</select></td>'; 
                                                                          echo '<input style="display:none" class="estilo" type="checkbox" name="vehiculo[]" id="vehiculo'.$i.'" value="'.$row['id_auto'].'"    />';
                                                                          #echo '<td><input class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'" disabled="" onclick="cargo('.$i.')"   /></td>';
                                                                          
                                                                         
                                                                  echo '</tr>';
                                                                  $num++;   
                                                                  $i++;           
                                                                }                                                                        
                                                                 
                                                       }; 
                                                       echo '<input type="hidden" name="total_trab"  value="'.$i.'"    />';
                                                         ?>                                                                
                                                        <input type="hidden" name="cantidad" value="<?php echo $i ?>" />
                                                          
                                                         <tr>

                                                         <?php if ($num==1) { ?>
                                                                    <td colspan="5"><h3>No hay vehículos para asignar a este contrato</h3></td>
                                                            <?php } else { ?> 
                                                                    <td colspan="5" style="border:1px #c0c0c0 solid;border-radius:20px;text-align:right"><button type="button" class="btn btn-success btn-lg col-4"  onclick="asignar_contrato(<?php echo $num ?>)" > <strong>ASIGNAR SELECCI&Oacute;N</strong></button></td>
                                                            <?php }  ?>
                                                         </tr>       
                                            
                                          </tbody>
                                       </table>
                                   </form>         
                                     
                                  </div>
                             </div> <!-- 
                             <?php if ($num==1) { ?>
                                  <div class="row">
                                    <div class="col-12">
                                        <div class="form-wrap">
                                            <td><b>No hay trabajadores para asignar a este contrato</b></td>
                                        </div>
                                    </div>
                                 </div>  
                             
                             <?php } else { ?>
                                  <div class="row">
                                    <div class="col-12">
                                        <div class="form-wrap">
                                            <button style="" class="btn btn-success btn-sm"  onclick="asignar_contrato()" > Asignar Selecci&oacute;n</button>
                                        </div>
                                    </div>
                                 </div>
                             <?php }  ?>
                                         
                         </div>-->
                        
                      </div>
                   </div>
              </div>               
        </div>
            
                    <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Asignado Trabajadores al Contrato, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Espere hasta que cierre esta ventana</h3> 
                                                <div class="progress"> 
                                                    <div id="myBar" class="progress-bar" style="width:0%;">
                                                        <span class="progress-bar-text">0%</span>
                                                    </div>
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
    
    


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
