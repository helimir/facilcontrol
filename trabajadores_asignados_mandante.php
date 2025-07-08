<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2 ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');
 
$contrato=$_SESSION['contrato'];
$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante']; 

$query_contrato=mysqli_query($con,"SELECT * from contratos where id_contrato='$contrato' ");
$result_contrato=mysqli_fetch_array($query_contrato);

$query_contratista=mysqli_query($con,"SELECT * from contratistas where id_contratista='$contratista' ");
$result_contratista=mysqli_fetch_array($query_contratista);


?>



<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">
<head>

  <title>Facil Control | Trabajadores Asignados</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

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

        .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
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
                    <h2 style="color: #010829;font-weight: bold;">Trabajadores Asignados al Contrato <span></span> [<?php echo $result_contrato['nombre_contrato']  ?>]</h2>
                    <label class="label label-warning encabezado">Contratista: <?php echo $result_contratista['razon_social'].' - '.$result_contratista['rut'] ?></label>
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
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="trabajadores_acreditados.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajadores Acreditados</a>
                                    </div>
                                </div>
                             </div>
                             <?php include('resumen.php') ?>
                         </div>  
                                                 
                         <div class="ibox-content">
                              <div class="row">
                                  <div class="col-lg-12"> 
                                  
                                   
                                        <table class="table ">
                                           <thead class="cabecera_tabla">
                                            <tr>
                                                <th>#</th>
                                                <th>Trabajador</th>
                                                <th>RUT</th>
                                                <th>Cargo</th>
                                                <th width="12%">Estado</th>
                                            </tr>
                                            </thead>
                                            
                                           <tbody>
                                            
                                            <?php
                                                 
                                                
                                                 #$asignados=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$contrato."' and mandante='".$mandante."' ");
                                                  
                                                 #$result_asignados=mysqli_fetch_array($asignados);
                                                 #$lista_trab=unserialize($result_asignados['trabajadores']);
                                                 #$lista_cargos=unserialize($result_asignados['cargos']);
                                                 #$existe_trabajadores=mysqli_num_rows($asignados);
                                                 
                                                 $asignados=mysqli_query($con,"select a.cargos as cargos_t, a.*, t.*, c.*, a.estado as estado_asignado from trabajadores_asignados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajadores LEFT JOIN cargos as c ON c.idcargo=a.cargos  where a.contrato='".$contrato."' and a.estado!=2 and t.estado=0 and mandante='".$mandante."' ");
                                                 $existe_trabajadores=mysqli_num_rows($asignados);                                                 
                                                 
                                                 
                                                 $i=0;    
                                                 if ($existe_trabajadores>0) {          
                                                    foreach ($asignados as $row) {                        
                                                          
                                                              $query_trab=mysqli_query($con,"select * from trabajador where idtrabajador='".$row."' and contratista='".$contratista."' ");
                                                              $result_trab=mysqli_fetch_array($query_trab);
                                                              
                                                              $query_cargos=mysqli_query($con,"select * from cargos where idcargo='".$lista_cargos[$i]."'  ");
                                                              $result_cargos=mysqli_fetch_array($query_cargos);
                                                              
                                                              $query_verificado=mysqli_query($con,"select * from observaciones where mandante='$mandante' and contrato='$contrato' and trabajador='$row' and estado=1 ");
                                                              $result_verificados=mysqli_num_rows($query_verificado);
                                                              
                                                             
                                                              $num=$i+1;
                                                              
                                                              echo '<tr>
                                                                  <td style="">'.$num.'</td>                                                                  
                                                                  <td style="">'.$row['nombre1'].' '.$row['apellido1'].'</td>
                                                                  <td style="">'.$row['rut'].'</td>
                                                                  <td>'.$row['cargo'].'</td>';                                               
                                                                  if ($result_verificados==0) {
                                                                    echo '<td><div class="bg-danger p-xxs b-r-lg text-mute text-center">No Acreditado</div></td>';
                                                                  } else {
                                                                    echo '<td><div class="bg-success p-xxs b-r-lg text-mute text-center">Acreditado</div></td>';
                                                                  }
                                                                echo '</tr>';
                                                                
                                                                echo '<input type="hidden" name="trabajadores[]" id="trabajadores'.$i.'" value="'.$row['idtrabajador'].'" />';
                                                                echo '<input type="hidden" name="cargos[]" id="cargos'.$i.'" value="'.$row['cargos'].'" />';
                                                     $i++;};
                                                               echo'<input type="hidden" name="total" id="total" value="'.$i.'" />';
                                                } else {
                                                    echo '<tr><td colspan="6"><h2>SIN TRABAJADORES ASIGNADOS</h2></td></tr>';      
                                                }
                                                    ?>            
                                          </tbody>
                                       </table>
                                            
                                     
                                  </div>
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
    
    <script>
    
        
   function retirar(contrato,contratista,mandante,id) {
        var total=$('#total').val();
        var atrab=[];
        var acargo=[];
        for (i=0;i<=total-1;i++) {
            var tvalor=$('#trabajadores'+i).val();
            atrab.push(tvalor);
            
            var cvalor=$('#cargos'+i).val();
            acargo.push(cvalor);
        } 
        var trabajadores=JSON.stringify(atrab);
        var cargos=JSON.stringify(acargo);
        //var trabajadores=$('#trabajadores').val();
        //alert(trabajadores);
        //alert(cargos);        
        swal({
            title: "Confirmar Retiro de Trabajador",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Retirar!",
            cancelButtonText: "No, Retirar!",
            closeOnConfirm: false,
            closeOnCancel: false },
            function (isConfirm) {
            if (isConfirm) {   
                
                $.ajax({
       			  method: "POST",
                  url: "add/retirar_contrato.php",
                  data: 'contrato='+contrato+'&mandante='+mandante+'&contratista='+contratista+'&id='+id+'&trabajadores='+trabajadores+'&cargos='+cargos,
       			  success: function(data){
          			  if (data==0) {   
      			        swal("Retirado!", "Trabajador retirado del Contrato.", "success"); 
                        setTimeout(window.location.href='trabajadores_asignados.php?contrato='+contrato+'&contratista='+contratista+'&mandante='+mandante, 12000);                             
                      } else {
                        swal("Error!", "Vuelva a intentar.", "error");
                      }   
                  }                
                });
            } else {
                swal("Cancelado", "Accion Cancelada", "error"); 
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
