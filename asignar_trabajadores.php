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

     <title>FacilControl | Asignar Trabajadores</title>    

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

        $(document).ready(function() {
            $('#menu-contratos').attr('class','active');

            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });

            $('.footable').footable();
            $('.footable2').footable();
                                
        });
    
     function selcargos(id,valor) {
        //alert(id);
        if (id==0) {
            $('#trabajador'+valor).prop('disabled',true);
            $('#trabajador'+valor).prop('checked',false);
            //document.getElementById("trabajador"+valor).style.color = "#282828";
           // document.getElementById("rut"+valor).style.color = "#282828";
           // document.getElementById("orden"+valor).style.color = "#282828";
           // document.getElementById("trabajador"+valor).style.fontweight = "";
        } else {
            $('#trabajador'+valor).prop('disabled',false);
            $('#trabajador'+valor).prop('checked',true);
            //document.getElementById("trabajador"+valor).style.color = "#FF0000";
            //document.getElementById("orden"+valor).style.color = "#FF0000";
            //document.getElementById("rut"+valor).style.color = "#FF0000";
            //document.getElementById("trabajador"+valor).style.fontweight = "bold"; 
            
        }    
        
     }
     
     function cargo(valor) {
         $('#trabajador'+valor).prop('disabled',true);
         $('#cargos'+valor).val("0");
     }
    
       function asignar_contrato(cant) {
        
        var valores=$('#frmAsignar').serialize();
            $.ajax({
    			method: "POST",
                url: "add/asignar_contrato.php",
                data: valores,
                beforeSend: function(){
                    $('#modal_cargar').modal('show');				
    			},
    			success: function(data){
                    $('#modal_cargar').modal('hide');
                    if (data==0) {      
                        swal("Trabajadores Asignados","","success");
                        window.location.href='trabajadores_asignados_contratista.php';
                    } 
                    else {
                        swal({
                            title: "Disculpe!! Error de Sistema",
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
                    <h2 style="color: #010829;font-weight: bold;">Asignar Trabajadores al Contrato: [<?php echo $result_contrato['nombre_contrato'] ?>]</h2>
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
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="trabajadores_asignados_contratista.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajadores Asignandos</a>
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
                                                <th style="width:30%;border-right:1px #fff solid">Trabajador</th>
                                                <th style="width:10%;border-right:1px #fff solid">RUT</th> 
                                                <th style="width:30%">Cargo</th>
                                                <!--<th>Asignar</th>-->
                                            </tr>
                                            </thead>
                                            
                                           <tbody>
                                            
                                            <?php
                                                 $i=0;
                                                 $num=1;
                                                 
                                                 $query_cargos=mysqli_query($con,"select * from perfiles_cargos where contrato='".$contrato."' ");
                                                 $fila2=mysqli_fetch_array($query_cargos);
                                                 $cargos=unserialize($fila2['cargos']);
                                                 $perfiles=unserialize($fila2['perfiles']);
                                                 
                                                 $query=mysqli_query($con,"select t.* from trabajador as t where t.contratista='".$contratista."' and t.eliminar=0  ");
                                                 $result=mysqli_fetch_array($query);
                                                 $cantidad=mysqli_num_rows($query);
                                                 
                                                 $asignados=mysqli_query($con,"select trabajadores from trabajadores_asignados where contrato='".$contrato."' and estado=0  ");
                                                           
                                                         foreach ($query as $row) {                         
                                                                  $excluir=false; 
                                                                  foreach ($asignados as $trab_asig) {
                                                                    if ($trab_asig['trabajadores']==$row['idtrabajador']) {
                                                                        $excluir=true;
                                                                    }                                                                  
                                                                   }
                                                                  if ($excluir==false) {      
                                                                      
                                                                      echo '<tr> 
                                                                          <td style="">'.$num.'</td>  
                                                                          <td style="">'.$row['nombre1'].' '.$row['apellido1'].' '.$row['apellido2'].'</td>
                                                                          <td style="">'.$row['rut'].'</td>
                                                                          <td><select name="cargos[]" id="cargos'.$i.'" class="form-control" onchange="selcargos(this.value,'.$i.')">
                                                                          <option value="0" >Seleccionar Cargo</option>';
                                                                          foreach ($cargos as $row2) {
                                                                                $query_cargos_contrato=mysqli_query($con,"select * from cargos where idcargo=$row2 ");
                                                                                $result_cargos_contrato=mysqli_fetch_array($query_cargos_contrato);
                                                                                echo '<option value="'.$result_cargos_contrato['idcargo'].'" >'.$result_cargos_contrato['cargo'].'</option>';
                                                                          }                                           
                                                                          echo '</select></td>';
                                                                          echo '<input style="display: none" class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'"    />';
                                                                          #echo '<td><input class="estilo" type="checkbox" name="trabajador[]" id="trabajador'.$i.'" value="'.$row['idtrabajador'].'" disabled="" onclick="cargo('.$i.')"   /></td>';
                                                                          
                                                                         
                                                                  echo '</tr>';
                                                                  $num++;              
                                                                }                                                                        
                                                                 
                                                       $i++;}; 
                                                       echo '<input type="hidden" name="total_trab"  value="'.$i.'"    />';
                                                         ?>                                                                
                                                        <input type="hidden" name="cantidad" value="<?php echo $i ?>" />
                                                          
                                                         <tr>

                                                         <?php if ($num==1) { ?>
                                                                    <td colspan="4"><h3>No hay trabajadores para asignar a este contrato</h3></td>
                                                            <?php } else { ?>                                                                     
                                                                    <td style="border:1px #c0c0c0 solid;border-radius:5px;text-align:right;" colspan="4"><button style="padding:1% 0%"  class="btn btn-success btn-sm col-lg-5 col-sm-12"  onclick="asignar_contrato(<?php echo $num ?>)" ><strong> ASIGNAR SELECCI&Oacute;N</strong></button></td>
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
            
                    <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Asignado Trabajadores al Contrato, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
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
