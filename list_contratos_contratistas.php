<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
include('config/config.php');
$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];

$query_c=mysqli_query($con,"select * from contratistas where id_contratista='$contratista' ");
$result_c=mysqli_fetch_array($query_c);

#if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3 and ($result_c['estado']==0 or $result_c['estado']==1) ) { 
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3  ) { 

      include('config/config.php');
    $contratista=$_SESSION['contratista'];
    $mandante=$_SESSION['mandante'];

    $query_c=mysqli_query($con,"select * from contratistas where id_contratista='$contratista' ");
    $result_c=mysqli_fetch_array($query_c);
    
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

    $sql_contratos=mysqli_query($con,"select  c.*, m.* from contratos as c LEFT JOIN mandantes as m ON m.id_mandante=c.mandante where c.contratista='$contratista'  ");
?>

<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Reporte Contratos</title> 
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

   <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
   <script>
   
   $(document).ready(function(){
    
          $('#menu-contratos').attr('class','active');

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
    
    function gestion_t(mandante,contrato,accion) {
       
        $.post("sesion/sesion_asignar_t.php", { mandante: mandante, contrato: contrato}, function(data){
              if (accion==1) {  
                window.location.href='trabajadores_asignados_contratista.php';
              }
              if (accion==2) {  
                window.location.href='asignar_trabajadores.php';
              }
              if (accion==3) {  
                window.location.href='gestion_contratos_contratistas.php';
              }  
        });
        
    }

    function gestion_v(mandante,contrato,accion) {
       
       $.post("sesion/sesion_asignar_v.php", { mandante: mandante, contrato: contrato}, function(data){
             if (accion==1) {  
               window.location.href='vehiculos_asignados_contratista.php';
             }
             if (accion==2) {  
               window.location.href='asignar_vehiculo.php';
             }
             if (accion==3) {  
               window.location.href='gestion_contratos_contratistas.php';
             }  
       });
       
   }


function cambiar_asignar(contrato,contratista,mandante) {
  window.location.href='asignar_trabajadores.php?contrato='+contrato+'&contratista='+contratista+'&mandante='+mandante;
}
function cambiar_asignados_d(contrato,contratista,mandante) {
  $.ajax({
        method: "POST",
        url: "sesion/session_trabajadores_asignados.php",
        data: 'contrato='+contrato+'&contratista='+contratista+'&mandante='+mandante,
        success: function(data){			  
           window.location.href='trabajadores_asignados_contratista.php';
 		}                
  });  
}

function cerrar_aviso() {
     $('#modal_aviso').modal('hide');
     var id=<?php echo $contratista; ?>;
     $.ajax({
        method: "POST",
        url: "add/aviso.php",
        data: 'id='+id,
        success: function(data){			  
        
 			}                
        });
      swal("Confirmado!", "Aviso Deshabilitado", "success");    
}

function refresh(){
    window.location.href='list_contratos_contratistas.php';
}

function accion(valor,id,accion){
        //alert(id);
        if (valor===0) {
            swal({
            title: "Confirmar deshabilitar Contrato",
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
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Contrato Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            });
                         setTimeout(refresh, 1000);
        			  } else {
                         swal("Cancelado", "Contrato No Deshabilitado. Vuelva a Intentar.", "error");
                         setTimeout(refresh, 1000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Contrato",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Habilitar!",
            cancelButtonText: "No, Habilitar!",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Contrato Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(refresh, 1000);
        			  } else {
                         swal("Cancelado", "Contrato No Hbilitado. Vuelva a Intentar.", "error");
                         setTimeout(refresh, 1000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } 
}

   
   </script>

   <style>
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
                    <h2 style="color: #010829;font-weight: bold;">Reporte de Contratos <?php  #echo $_SESSION['usuario'].'-'.$_SESSION['nivel'].'-'.$_SESSION['contratista'].'-'.$_SESSION['mandante'] ?> </h2> 
                    
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                              
                                  <div class="form-group row">
                                        <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                            <a style="background:#217346;border:1px  #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_contratos.php"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Contratos</a>
                                            <a class="btn btn-sm btn-success btn-submenu" href="crear_trabajador.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Trabajador</a>
                                            <a class="btn btn-sm btn-success btn-submenu" href="trabajadores_acreditados.php" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Trabajadores Acreditados</a>
                                        </div>
                                  </div>  
                                  <?php include('resumen.php') ?>                             
                             </div>  
                        <div class="ibox-content">
                            
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Contrato">
                            <br>
                            <div class="table-responsive">
                                <table class="table footable " data-page-size="25" data-filter="#filter">
                                   <thead class="cabecera_tabla">
                                    <tr>
                                        <th style="width: 5%;border-right:1px #fff solid"></th>
                                        <th style="width: 25%;border-right:1px #fff solid">CONTRATO</th>
                                        <th data-hide="phone,table;" style="width: 20%;border-right:1px #fff solid" >MANDANTE</th>
                                        <th colspan="2" style="width: 25%;text-align: center;border-right:1px #fff solid" >GESTION DE TRABAJADORES</th>
                                        <th colspan="2" style="width: 25%;text-align: center;" >GESTION DE VEHICULOS</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      $i=1;
                                      $j=0;
                                      $contratos_sin_perfiles_i=0;
                                      $contratos_sin_perfiles_i_v=0;
                                      foreach ($sql_contratos as $row) { 
                                     
                                        $query_ta=mysqli_query($con,"select count(*) total from trabajadores_asignados where contratista='$contratista' and contrato='".$row['id_contrato']."' and estado!='2' limit 1  ");
                                        $result_ta=mysqli_fetch_assoc($query_ta);

                                        $query_va=mysqli_query($con,"select count(*) total from vehiculos_asignados where contratista='$contratista' and contrato='".$row['id_contrato']."' and estado!='2' limit 1  ");
                                        $result_va=mysqli_fetch_assoc($query_va);
                                        
                                        $query_t=mysqli_query($con,"select count(*) total from trabajador where contratista='$contratista' limit 1  ");
                                        $result_t=mysqli_fetch_assoc($query_t);

                                        $query_v=mysqli_query($con,"select count(*) total from autos where contratista='$contratista' limit 1  ");
                                        $result_v=mysqli_fetch_assoc($query_v);
                                        
                                        $arr_perfiles=unserialize($row['perfiles']);
                                          
                                        $creado=$row['creado_contrato'];
                                                                            
                                        ?>
                                         <tr>
                                            <!-- nombre del contrato -->
                                            <td><?php echo $i ?></td>
                                            
                                            <!-- nombre del contrato -->
                                            <td><?php echo $row['nombre_contrato'] ?></td>
                                            
                                            <!-- mandante -->
                                            <td><?php echo $row['razon_social'] ?></td>
                                            
                                            <!-- creado
                                            <td><?php echo substr($creado,0,10) ?></td> -->
                                            
                                                <?php 
                                                   if ($contratos_sin_perfiles_i[$j]==$row['id_contrato'])  { ?>
                                                            <td><button  title="Contrato sin Perfil asignado" class="btn btn-xs btn-dark btn-block" name="" id=""  ><span style="font-size: 12px;font-weight:bold;">SIN PERFIL</span></button></td> 
                                                  <?php 
                                                  } else { ?>
                                                            <td><button  title="Asignar Trabajadores" class="btn btn-xs btn-success btn-block" name="" id="" onclick="gestion_t(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,2)" ><span style="font-size: 12px;">ASIGNAR </span></button></td> 
                                                  <?php 
                                                  }   
                                                    if ($result_ta['total']>0) { ?>                                                         
                                                            <td style="border-right:1px #eee solid"><button style="background:#5635B9;border: none;"  title="Trabajadores Asignados" class="btn btn-xs btn-primary btn-block" name="" id="" onclick="gestion_t(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,1)" ><span style="font-size: 12px;">TRABAJADORES  (<?php echo $result_ta['total'] ?>) </span></button></td>
                                                    <?php 
                                                    } else {     
                                                          if ($contratos_sin_perfiles_i[$j]==$row['id_contrato'] ) { ?>
                                                              <td><button  title="Contrato sin Perfil asignado" class="btn btn-xs btn-dark btn-block" name="" id=""  ><span style="font-size: 12px;font-weight:bold;">SIN PERFIL</span></button></td> 
                                                          <?php 
                                                          } else { ?>      
                                                              <td style="border-right:1px #eee solid"><button  title="Trabajadores No Asignados" class="btn btn-xs btn-secondary btn-block" name="" id="" ><span style="font-size: 12px;">GESTIONAR</button></td>
                                                          <?php 
                                                          }  ?>
                                                    <?php 
                                                    }   

                                                    # vehiculos                                                  
                                                    if (isset($contratos_sin_perfiles_i_v[$j])==isset($row['id_contrato']) ) { ?>
                                                          <td><button  title="Contrato sin Perfil asignado" class="btn btn-xs btn-dark btn-block" name="" id=""  ><span style="font-size: 12px;font-weight:bold;">SIN PERFIL</span></button></td> 
                                                    <?php 
                                                    } else { ?>
                                                            <td><button  title="Asignar Vehiculos" class="btn btn-xs btn-success btn-block" name="" id="" onclick="gestion_v(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,2)" ><span style="font-size: 12px;">ASIGNAR</span></button></td> 
                                                    <?php 
                                                    }   

                                                    if ($result_va['total']>0) { ?>                                                         
                                                            <td><button style="background:#5635B9;border: none;"  title="Vehiculos Asignados" class="btn btn-xs btn-primary btn-block" name="" id="" onclick="gestion_v(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,1)" ><span style="font-size: 12px;">VEHIC/MAQUI (<?php echo $result_va['total'] ?>) </span></button></td>
                                                    <?php 
                                                    } else {  
                                                        if ($contratos_sin_perfiles_i_v[$j]==$row['id_contrato'] ) { ?>    
                                                            <td style="border-right:1px #eee solid"><button  title="Contrato sin Perfil asignado" class="btn btn-xs btn-dark btn-block" name="" id=""  ><span style="font-size: 12px;">SIN PERFIL</span></button></td> 
                                                        <?php 
                                                        } else { ?>      
                                                            <td style="border-right:1px #eee solid"><button  title="Vehiculos No Asignados" class="btn btn-xs btn-secondary btn-block" name="" id=""  ><span style="font-size: 12px;">GESTIONAR</span></button></td>
                                                        <?php 
                                                      }  ?>   
                                                    <?php 
                                                    }   ?> 
                                          </tr>
                                        
                                    <?php $i++; $j++; } ?>
                                    </tbody>
                                    <tfoot>
                                      <tr>
                                          <td colspan="7">
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
                                   
                                 function modal_reporte_trabajadores(contrato) {
                                      $('.body').load('selid_reporte_trabajadores.php?contrato='+contrato,function(){
                                                $('#modal_reporte_trabajadores').modal({show:true});
                                           });
                                 }
                                 
                                 function modal_cargos(contrato) {
                                      $('.body').load('selid_cargos_contratos.php?contrato='+contrato,function(){
                                                $('#modal_cargos').modal({show:true});
                                           });
                                    }  
                                    
                            </script>
                            
                                                    
                        </div>
                      </div>
                   </div>
               </div>
               
               
           </div>
            
            
            
           <?php echo include('footer.php') ?>

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
                        
                        <div class="modal fade" id="modal_reporte_trabajadores" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajadores del Contrato</h3>
                                          <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="body">
                                     
                                        </div>

                                        <div class="modal-footer">
                                                <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</a>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                           <div class="modal fade" id="modal_cargos" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Cargos del Contrato</h3>
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
