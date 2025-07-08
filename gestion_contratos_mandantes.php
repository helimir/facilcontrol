<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
include('config/config.php');

$contratista=$_SESSION['contratista'];
$contrato=$_SESSION['contrato'];
$mandante=$_SESSION['mandante'];





if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2 ) { 
    
if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}    


date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time()); 
$dia=date('d');
$mes=date('m');
$year=date('Y');

$query_o=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$_SESSION['contrato']."' ");
$result_o=mysqli_fetch_array($query_o);



?>



<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Gestión de Contratos</title> 
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
   
   <script src="js\jquery-3.1.1.min.js"></script> 
   <script>
   
   $(document).ready(function(){
                
                $("#cargos").change(function () {
                    
					$("#cargos option:selected").each(function () {
						cargo = $(this).val();
                        if (cargo!=0) {
                            $('.body').load('selid_perfil.php?cargo='+cargo,function(){
                                $('#modal_perfil').modal({show:true});
                            });         
                        }    
					});
				})
                
             
              $('.footable').footable();
              $('.footable2').footable();
            
            
              $('.deshabilitar').click(function () {
                    swal({
                                title: "Confirmar deshabilitar Mandante",
                                //text: "Your will not be able to recover this imaginary file!",
                                type: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#DD6B55",
                                confirmButtonText: "Si, Deshabilitar!",
                                cancelButtonText: "No, Deshabilitar!",
                                closeOnConfirm: false,
                                closeOnCancel: false },
                                function (isConfirm) {
                                    if (isConfirm) {   
                                        
                                        
                                        swal("Confirmado!", "El Mandante ha sido deshabilitado.", "success");
                                        setTimeout(refresh, 1000);
                                    } else {
                                        swal("Cancelado", "Accion Cancelada", "error");
                                        setTimeout(refresh, 1000);
                                    }
                    });
                            
                                
                }); 
                
    });
    
    function asignar_t(mandante,contrato) {
        $.post("sesion/sesion_asignar_t.php", { mandante: mandante, contrato: contrato }, function(data){
            window.location.href='asignar_trabajadores.php';
        });
    }
    
     function doc_validar(trabajador,cargo,perfil) {
        $.post("sesion/sesion_validar_trabajador.php", { trabajador: trabajador, cargo: cargo,perfil:perfil }, function(data){
            window.location.href='verificar_documentos_trabajador_mandante.php';
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
                    <h2 style="color: #010829;font-weight: bold;">Gestion de Contrato: [<?php echo $result_o['nombre_contrato']  ?>]</h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                              
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="trabajadores_acreditados.php" class="" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Trabajadores Acreditados</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" class="" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                    </div>
                              </div>  
                              <?php include('resumen.php') ?>
                           
                          </div>
                        <div class="ibox-content">
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Contrato">
                            
                            <div class="table-responsive">
                                <table class="table footable " data-page-size="10" data-filter="#filter">
                                   <thead style="background:#010829;color:#fff">
                                    <tr style="font-size: 12px;">
                                        <th style="width: 5%;border-right:1px #fff solid;">#</th>
                                        <th style="width: 20%;border-right:1px #fff solid;">Trabajador</th>
                                        <th style="width: 10%;border-right:1px #fff solid;">RUT</th>
                                        <th style="width: 15%;border-right:1px #fff solid;" >Cargo</th>
                                        <th style="width: 15%;border-right:1px #fff solid;">Perfil de Cargos</th>
                                        <th style="width: 20%;text-align: center;" >Validaci&oacute;n Documentos</th>
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      $i=0;
                                      
                                      $query_ta=mysqli_query($con,"select a.*, t.*, c.cargo, p.cargos as cargos_perfil, o.perfiles from trabajadores_asignados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajadores LEFT JOIN cargos as c ON c.idcargo=a.cargos LEFT JOIN perfiles_cargos as p ON p.contrato=a.contrato LEFT JOIN contratos as o ON o.id_contrato=a.contrato  where a.contrato='".$_SESSION['contrato']."' and a.mandante='".$_SESSION['mandante']."' and a.estado!='2' ");
                                      $result_ta=mysqli_fetch_array($query_ta);
                                      $cargos=unserialize($result_ta['cargos_perfil']);
                                      $perfiles=unserialize($result_ta['perfiles']);
                                     
                                      foreach ($query_ta as $row) {
                                        
                                        # obtener perfil y numero de documentos
                                        $j=0;
                                        foreach ($cargos as $row_c) {
                                            # el cargo obnetido esta en la lista
                                            if ($row_c==$row['cargos']) {
                                                $query_pc=mysqli_query($con,"select * from perfiles where id_perfil='".$perfiles[$j]."' ");
                                                $result_pc=mysqli_fetch_array($query_pc);    
                                                $cant_doc_perfil=count(unserialize($result_pc['doc']));  
                                                break;                                                
                                            }
                                          $j++;    
                                        }
                                                                            
                                        ?>
                                         <tr>
                                            <!-- # -->
                                            <td><?php echo $i+1; ?></td>
                                            
                                            <!-- trabajador -->
                                            <td><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>
                                            
                                            <!-- rut -->
                                            <td><?php echo $row['rut']  ?></td>
                                   
                                            <!-- cargo -->
                                            <td><?php echo $row['cargo']  ?></td>
                                            
                                            <!-- perfil -->
                                            <td><?php echo $result_pc['nombre_perfil'] ?></td>
                                            
                                            <!-- validados -->
                                            <td style="text-align: center;">
                                             <?php if ($row['verificados']==0) { ?>    
                                                    <button style="font-weight:bold" title="Trabajador No Validado" class="btn btn-danger btn-xs btn-block" onclick="doc_validar(<?php echo $row['idtrabajador'] ?>,<?php echo $row['cargos'] ?>,<?php echo $result_pc['id_perfil'] ?>)">GESTIONAR DOCUMENTOS</button>
                                             <?php } else { 
                                                      if ($row['verificados']==1) { ?> 
                                                        <button style="font-weight:bold" title="Trabajador Validado" class="btn btn-success btn-xs btn-block" onclick="doc_validar(<?php echo $row['idtrabajador'] ?>,<?php echo $row['cargos'] ?>,<?php echo $result_pc['id_perfil'] ?>)">VALIDADO</button>
                                                <?php } else {   ?>
                                                        <button style="color:#292929;font-weight:bold" title="Trabajador Validado" class="btn btn-warning btn-xs btn-block" onclick="doc_validar(<?php echo $row['idtrabajador'] ?>,<?php echo $row['cargos'] ?>,<?php echo $result_pc['id_perfil'] ?>)">REVISION EN PROCESO</button>    
                                                <?php }    
                                                   } ?>
                                            </td>
                                                   
                                          </tr>
                                        
                                    <?php $i++;} ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6">
                                            <ul class="pagination float-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <script>
                                 function modal_asignar_trabajador(contrato,contratista,mandante) {
                                      $('.body').load('selid_asignar_trabajador_contratista.php?contrato='+contrato+'&contratista='+contratista+'&mandante='+mandante,function(){
                                                $('#modal_asignar_trabajador').modal({show:true});
                                           });
                                 }
                                   
                                 
                            </script>
                            
                                                    
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
        
                        <div class="modal fade" id="modal_asignar_trabajador" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Asignar Trabajadores al Contrato</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                            <div class="body">
                                             
                                                  
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
