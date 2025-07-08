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

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3 and $result_c['estado']==0 ) { 
    
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



?>



<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | <?php echo $_SESSION['titulo'] ?></title> 

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
    
    function gestion_t(mandante,contrato,accion) {
        $.post("sesion/sesion_asignar_t.php", { mandante: mandante, contrato: contrato }, function(data){
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

</head>
<body>

    <div id="wrapper">
 
        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Listado Contratos <?php ?></h2>
                    
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                              
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_trabajadores.php" class="" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i>Reporte Trabajadores</a>&nbsp;&nbsp;
                                        <a class="btn btn-sm btn-success btn-submenu" href="trabajadores_acreditados.php" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i>Trabajadores Acreditados</a>
                                    </div>
                              </div>  
                            
                              <div class="row">
                                  <div class="col-sm-12"> 
                                    <?php 
                                    
                                       #$sql_contratos=mysqli_query($con,"select g.trabajadores as trabajadores_ta, g.cargos as cargos_ta, g.contrato, m.razon_social as nom_mandante,m.id_mandante, c.estado as estado_contrato, c.*, o.* from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista Left Join mandantes as m On m.id_mandante=c.mandante Left Join trabajadores_asignados as g On g.contrato=c.id_contrato where c.contratista='$contratista' and c.estado=1 and c.eliminar=0 order by c.id_contrato desc ");
                                       $sql_contratos=mysqli_query($con,"select  c.*, m.* from contratos as c LEFT JOIN mandantes as m ON m.id_mandante=c.mandante where c.contratista='".$_SESSION['contratista']."' and c.mandante='".$_SESSION['mandante']."' ");
                                       $fcontratos=mysqli_fetch_array($sql_contratos); 
                                    
                                    
                                       foreach ($sql_contratos as $row) {  
                                          $sql_perfiles2=mysqli_query($con,"select c.nombre_contrato, p.* from perfiles_cargos as p Left Join contratos as c On c.id_contrato=p.contrato where p.contrato='".$row['id_contrato']."' ");
                                          $result_perfiles2=mysqli_fetch_array($sql_perfiles2);
                                          $existe_perfiles2=mysqli_num_rows($sql_perfiles2);
                                          
                                          if ($existe_perfiles2==0) {
                                              $sql_perfiles3=mysqli_query($con,"select * from contratos where id_contrato='".$row['id_contrato']."' ");
                                              $result_perfiles3=mysqli_fetch_array($sql_perfiles3);
                                       ?>
                                              <div class="alert alert-danger alert-dismissable">
                                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
                                                <b>Contrato <?php echo $result_perfiles3['nombre_contrato'] ?></b> sin perfiles asignados. <a class="alert-link" >Tarea del Mandante</a>.
                                              </div>
                                    <?php 
                                      }                                    
                                    }  ?>  
                                  </div>
                             </div>   
                          </div>
                        <div class="ibox-content">
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Contrato">
                            
                            <div class="table-responsive">
                                <table class="table footable " data-page-size="10" data-filter="#filter">
                                   <thead>
                                    <tr>
                                        <th style="width: 5%;">#</th>
                                        <th style="width: 20%;">Contrato</th>
                                        <th data-hide="phone,table;" style="width: 20%;" >Mandante</th>
                                        <th data-hide="phone,table;" style="width: 10%;" >Creado</th>
                                        <th style="width: 20%;text-align: center;" >Trabajadores</th>
                                        <th style="width: 20%;text-align: center;" >Gestiones</th>
                                        <th style="width: 20%;text-align: center;" >Asignacion</th>
                                        
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      $i=1;
                                      foreach ($sql_contratos as $row) { 
                                        $sql_perfiles=mysqli_query($con,"select * from perfiles_cargos where contrato='". $row['id_contrato']."' ");
                                        $existe_perfiles=mysqli_num_rows($sql_perfiles);
                                        
                                        $query_trab_asignados=mysqli_query($con,"select* from trabajadores_asignados where contratista='".$_SESSION['contratista']."' and contrato='". $row['id_contrato']."' and estado=1 ");
                                        $existe_trab_asignados=mysqli_num_rows($query_trab_asignados);
                                        
                                        $creado=$row['creado_contrato'];
                                                                            
                                        ?>
                                         <tr>
                                            <!-- nombre del contrato -->
                                            <td><?php echo $i ?></td>
                                            
                                            <!-- nombre del contrato -->
                                            <td><?php echo $row['nombre_contrato'] ?></td>
                                            
                                            <!-- mandante -->
                                            <td><?php echo $row['razon_social'] ?></td>
                                            
                                            <!-- creado -->
                                            <td><?php echo substr($creado,0,10) ?></td>
                                            
                                            
                                            <?php 
                                                 # si no existe un contrato
                                                 if ($row['contrato']=="") { 
                                                    
                                                        # si tiene trabajadores asignados el contrato
                                                        if ($existe_trab_asignados>0) {
                                                            
                                                            # si el contrato tiene perfiles
                                                            if ($existe_perfiles>0) {  ?>                                                      
                                                             <td><button  title="Asignar Trabajadores" class="btn btn-xs btn-warning btn-block" name="" id="" onclick="asignar_t(<?php echo $mandante ?>,<?php echo $row['id_contrato']?>)"  ><span style="font-size: 10px;">ASIGNAR</span></button></td> 
                                                      <?php } else { ?> 
                                                             <td><span style="padding: 6%;" class="badge badge-danger">Sin Perfiles</span></td>
                                                      <?php } 
                                                      
                                                        # sino tiene trabajadores
                                                        } else { ?>
                                                            <td><span style="padding: 6%;" class="badge badge-danger">Sin Trabajadores</span></td>
                                                  <?php }?> 
                                                            <td><button style="text-align: center;" title="Gestion Contratos" class="btn btn-xs btn-dark btn-block" name="" id="" disabled=""  ><span style="font-size: 12px;">Gestionar Contrato</span></button></td>
                                                            <td><button  title="Asignar Trabajadores" class="btn btn-xs btn-success btn-block"   name="" id="" onclick="gestion_t(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,2)" ><span style="font-size: 12px;">Asignar Trabajadores</span></button></td>
                                                           
                                                <?php } else { 
                                                          if ($existe_trab_asignados>0) { ?>
                                                            <td><button  title="Trabajadores Asignados" class="btn btn-xs btn-primary btn-block" name="" id="" onclick="gestion_t(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,1)" ><span style="font-size: 12px;"><small>TRABAJADORES ASIGNADOS</small> </span></button></td>
                                                      <?php } else { ?>      
                                                            <td><span style="padding: 6%;" class="badge badge-danger">Sin Trabajadores</span></td>
                                                      <?php }  ?>  
                                                   
                                                      <td><button style="background:#5635B9;border:none;text-align: center;" title="Gestion Contratos" class="btn btn-xs btn-warning btn-block" name="" id="" onclick="gestion_t(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,3)" ><span style="font-size: 10px;"><small>GESTIONAR CONTRATO</small> </span></button></td>
                                                      <td><button  title="Asignar Trabajadores" class="btn btn-xs btn-success btn-block"   name="" id="" onclick="gestion_t(<?php echo $row['id_mandante'] ?>,<?php echo $row['id_contrato']?>,2)" ><span style="font-size: 10px;"><small>ASIGNAR TRABAJADORES</small> </span></button></td>
                                                    
                                                <?php } ?>
                                                   
                                          </tr>
                                        
                                    <?php $i++; } ?>
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

    
<?php if ($fcontratos['aviso']==1) { ?>

    <script>
       
       $(document).ready(function() {                
                $('.body').load('selid_aviso.php',function(){
                    $('#modal_aviso').modal({show:true});
                 });
                //$('#modal_aviso').modal({show:true});
       });
    
     </script>
<?php } ?>



</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
