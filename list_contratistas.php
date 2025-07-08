<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and  $_SESSION['nivel']==1  ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');
$plan='';
$sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
$result=mysqli_fetch_array($sql_mandante);
if (isset($result['id_mandante'])) {$mandante=$result['id_mandante'];} 

if ($_SESSION['nivel']==1)  {
   $sql_contratistas=mysqli_query($con,"select r.Region, o.Comuna, d.acreditada, c.estado as estado_contratista, c.*, p.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista left join contratistas_mandantes as d On d.contratista=c.id_contratista Left Join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On o.IdComuna=c.dir_comercial_comuna GROUP by c.id_contratista");
} else {    
   $sql_contratistas=mysqli_query($con,"select c.estado as estado_contratista, r.Region, o.Comuna, c.*, p.* from contratistas as c Left Join pagos as p On p.idcontratista=c.id_contratista Left Join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On o.IdComuna=c.dir_comercial_comuna where c.mandante='$mandante' and c.eliminar=0 ");
}    

?>

<!DOCTYPE html>
<html>
<html translate="no">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | Reporte de Contratistas</title>
     <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">

</head>


    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;"><i class="fa fa-list-ul" aria-hidden="true"></i> Reporte de Contratistas <?php ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a href="crear_contratista.php" class="btn btn-sm btn-success btn-submenu" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contratistas</a>
                                        <a href="crear_contrato.php" style="" class="btn btn-sm btn-success btn-submenu" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contrato</a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                            </div>
                        
                        
                        <div class="ibox-content">
                            
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una Contratista" />
                            <table style="width: 100%;" class="footable table" data-page-size="25" data-filter="#filter">
                               <thead>
                                <tr style="font-size: 12px;">
                                    <th style="width: ;"></th>
                                    <th style="width: ;">Acciones</th>
                                    <th data-hide="phone" style="width:  ;">Razon Social</th>
                                    <th data-hide="phone" style="width: ;">RUT</th>
                                    <th data-hide="phone" style="width: ;">Adminisrador</th>
                                    <th style="width:">Plan</th>
                                    <!--<th Style="width:15%;text-align: center;">Acreditacion</th>
                                    <th width="10%" style="text-align: center;">Editar</th>
                                    <th width="10%" style="text-align: center;">Gesti&oacute;n</th>
                                    <th style="width:15%;text-align: center;">Documentos</th>-->
                                    
                                    
                                    <th data-hide="all" style="width: ;">Nombre Fantasia</th>
                                    <th data-hide="all" style="width: ;">Email</th>
                                    <th data-hide="all" style="width: ;">Fono</th>
                                    <th data-hide="all" style="width: ;">Region Comercial</th>
                                    <th data-hide="all" style="width: ;">Comuna Comercial</th>
                                    <th data-hide="all" style="width: ;">Plan</th>
                                    <th data-hide="all" style="width: ;">Inicio Plan</th>
                                    <th data-hide="all" style="width: ;">Fin Plan</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                  $i=1;
                                  $condicion=0;
                                  foreach ($sql_contratistas as $row) { 
                                    
                                    switch ($row['plan']) {
                                        case '0';$plan="Prueba";break;
                                        case '1';$plan="Mensual";break;
                                        case '2';$plan="Semestral";break;
                                        case '3';$plan="Anual";break;
                                    } 
                                    
                                    $url ='doc/validados/'.$row['mandante'].'/'.$row['id_contratista'].'/zip/';
                                    
                                    ?>
                                        <tr>
                                          <td data-toggle="true"></td>
                                            <?php  if ($row['estado_contratista']==0) {
                                                        $habilitar=0;
                                                        $deshabilitar=1;
                                                        # si esta deshabilitada por admin
                                                        if ($row['habilitada']==1) { ?>
                                                            <td>
                                                                <div class="btn-group"> 
                                                                    <button onclick="accion(<?php echo $habilitar ?>,<?php echo $row['id_contratista'] ?>,2)" title="Deshabilitada"><i style="font-size:20px"  class="fa fa-toggle-off" aria-hidden="true"></i></button>
                                                                    <button style="width:100%" title="Editar Contratista" type="button"  onclick="edit_contratista(<?php echo $row['id_contratista'] ?>)"><i style="font-size:20px" class="fa fa-pencil-square-o"></i></button>
                                                                    <!--<button onclick="modal_fecha_plan(<?php echo $row['id_contratista'] ?>,'<?php echo $row['fecha_fin_plan'] ?>')" title="Cambiar Fecha Plan" type="button" ><i style="font-size:20px" class="fa fa-calendar" aria-hidden="true"></i></button>
                                                                    <button onclick="facil_pro(<?php echo $row['id_contratista'] ?>)" title="FacilPro" type="button" ><i style="font-size:20px" class="fa fa-credit-card-alt" aria-hidden="true"></i></button>-->
                                                                </div>
                                                            </td>
                                                    <?php  } else { ?>    
                                                            <td>
                                                                <div class="btn-group"> 
                                                                    <button onclick="accion(<?php echo $deshabilitar ?>,<?php echo $row['id_contratista'] ?>,2)" title="Habilitada"><i style="font-size:20px" class="fa fa-toggle-on" aria-hidden="true"></i></button>                                                
                                                                    <button style="width:100%" title="Editar Contratista" type="button"  onclick="edit_contratista(<?php echo $row['id_contratista'] ?>)"><i style="font-size:20px" class="fa fa-pencil-square-o"></i></button>
                                                                    <!--<button onclick="modal_fecha_plan(<?php echo $row['id_contratista'] ?>,'<?php echo $row['fecha_fin_plan'] ?>')" title="Cambiar Fecha Plan" type="button" ><i style="font-size:20px" class="fa fa-calendar" aria-hidden="true"></i></button>
                                                                    <button onclick="facil_pro(<?php echo $row['id_contratista'] ?>)" title="FacilPro" type="button" ><i style="font-size:20px" class="fa fa-credit-card-alt" aria-hidden="true"></i></button>-->
                                                                </div>
                                                            </td>    
                                                        
                                                    <?php } ?>

                                            <?php  } else { 
                                                    
                                                    $habilitar=2;
                                                    $deshabilitar=0;
                                                    # si esta habilitada por admin
                                                    if ($row['habilitada']==2) { ?>
                                                            <td>
                                                                <div class="btn-group"> 
                                                                    <button onclick="accion2(<?php echo $deshabilitar ?>,<?php echo $row['id_contratista'] ?>,2)" title="Habilitada"><i style="font-size:20px" class="fa fa-toggle-on" aria-hidden="true"></i></button>                                                
                                                                    <button style="width:100%" title="Editar Contratista" type="button"  onclick="edit_contratista(<?php echo $row['id_contratista'] ?>)"><i style="font-size:20px" class="fa fa-pencil-square-o"></i></button>
                                                                    <!--<button onclick="modal_fecha_plan(<?php echo $row['id_contratista'] ?>,'<?php echo $row['fecha_fin_plan'] ?>')" title="Cambiar Fecha Plan" type="button" ><i style="font-size:20px" class="fa fa-calendar" aria-hidden="true"></i></button>
                                                                    <button onclick="facil_pro(<?php echo $row['id_contratista'] ?>)" title="FacilPro" type="button" ><i style="font-size:20px" class="fa fa-credit-card-alt" aria-hidden="true"></i></button>-->
                                                                </div>
                                                            </td> 
                                                    <?php  
                                                        # si esta inactiva y no habilitada por admin
                                                        } else { ?>
                                                        <td>
                                                            <div class="btn-group">
                                                                <button onclick="accion2(<?php echo $habilitar ?>,<?php echo $row['id_contratista'] ?>,2)" title="Deshabilitada"><i style="font-size:20px"  class="fa fa-toggle-off" aria-hidden="true"></i></button>
                                                                <button style="width:100%" title="Editar Contratista" type="button"  onclick="edit_contratista(<?php echo $row['id_contratista'] ?>)"><i style="font-size:20px" class="fa fa-pencil-square-o"></i></button>
                                                                <!--<button disabled="" onclick="" title="Cambiar Fecha Plan" type="button" ><i style="font-size:20px" class="fa fa-calendar" aria-hidden="true"></i></button>
                                                                <button disabled="" onclick="" title="FacilPro" type="button" ><i style="font-size:20px" class="fa fa-credit-card-alt" aria-hidden="true"></i></button>-->
                                                            </div>
                                                        </td>

                                                    <?php  }  ?>
                                            <?php } ?>
                                       
                                       <?php if ($row['estado_contratista']==0) { ?>
                                            <?php 
                                                # si esta inhabilitada por admin
                                                if ($row['habilitada']==2 and $row['estado_contratista']==1) { ?>    
                                                <td><i style="color:#FF6600" title="INHABILITADA" class="fa fa-circle" aria-hidden="true"></i> <?php echo $row['razon_social'] ?></td>
                                            <?php } else { ?>        
                                                <td><i style="color:#0000FF" title="ACTIVA" class="fa fa-circle" aria-hidden="true"></i> <?php echo $row['razon_social'] ?></td>
                                            <?php }  ?>        

                                        <?php } else { ?>
                                                <td><i style="color:#FF0000" title="INACTIVA" class="fa fa-circle" aria-hidden="true"></i> <?php echo $row['razon_social'] ?></td> 
                                        <?php } ?>

                                            
                                            <td><?php echo $row['rut'] ?></td>                                
                                            <td><?php echo $row['administrador']?></td>
                                            <td><?php echo $plan ?></td>

                                            <!--<?php if ($row['acreditada']==1) { ?>
                                                  <td><span style="width: 100%" class="badge badge-success">Acreditada</span></td>  
                                            <?php } else { ?>    
                                                <td><span style="width: 100%" class="badge badge-danger">No Acreditada</span></td>      
                                            <?php }  ?>    -->

                                       <?php   
                                              
                                              $query_con_contrato=mysqli_query($con,"select contratista from contratos where contratista='".$row['id_contratista']."' ");
                                              $result_con_contrato=mysqli_num_rows($query_con_contrato);  ?>
                                            
                                            <!--<div class="btn-group">
                                                <td style="background:;text-align: center;" ><button style="width:100%" title="Editar Contratista" class="btn btn-success btn-xs" type="button"  onclick="edit_contratista(<?php echo $row['id_contratista'] ?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                                                    
                                                    <?php if ($result_con_contrato>0) { ?>                                                        
                                                    <td style="background:;text-align: center;" ><button style="background:#5635B9;width:100%;border: 1px #5635B9 solid; " title="Gestionar Contratos" class="btn btn-warning btn-xs" type="button" onclick="gestion()" ><i class="fa fa-cog" aria-hidden="true"></i></button></td>
                                                <?php } else { ?>
                                                         <td style="background:;text-align: center;" ><button style="background:#5635B9;width:100%;border: 1px #5635B9 solid; " title="Sin Contratos" class="btn btn-warning btn-xs" type="button" onclick="gestion()"><i class="fa fa-cog" aria-hidden="true"></i></button></td>    
                                                <?php } ?>
                                                           
                                                <td style="background:;text-align: center;" ><span style="width: 100%;" class="badge badge-muted"><a style="color:#282828" class="" href="descargar.php?url=<?php echo $url ?>&rut=<?php echo $row['rut'] ?>" ><u><i class="fa fa-download" aria-hidden="true"></i> Descargar</u></a></span></td>
                                            </div>-->     
                                             
                                        
                                            <td><?php echo $row['nombre_fantasia'] ?></td>           
                                            <td><?php echo $row['email'] ?></td>
                                            <td><?php echo $row['fono'] ?></td>
                                            <td><?php echo $row['Region'] ?></td>
                                            <td><?php echo $row['Comuna'] ?></td>
                                            <td><?php echo $plan ?></td>
                                            <td><?php echo $row['fecha_inicio_plan'] ?></td>
                                            <td><?php echo $row['fecha_fin_plan'] ?></td>
                                        
                                        </tr>
                                    
                                 <?php } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="8">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                          
                        </div>
                        
                        
                        
                      </div>
                   </div>
               </div>
               
               
           </div>
             <?php include('footer.php') ?>

        </div>
        </div>
        
                      <script> 
                            function modal_fecha_plan(id,fecha) {
                                //alert(fecha);
                                $('.body').load('selid_fecha_plan.php?id='+id+'&fecha='+fecha,function(){
                                    $('#modal_fecha_plan').modal({show:true});
                                });
                            }
                            
                            function facil_pro(id) {
                                window.location.href='facil_pro.php?id='+id;
                            }
                            
                        </script>
        
        
                            <div class="modal fade" id="modal_fecha_plan" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Actualizar Fecha Finalizacion del Plan</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
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

<script>

function edit_contratista(id){
     $.ajax({
			method: "POST",
            url: "sesion/sesion_contratistas.php",
			data:'id='+id,
			success: function(data){
                window.location.href='edit_contratista.php';
			}
       });
}


function gestion(){
    window.location.href='gestion_contratos.php';
}

function gestion_documentos(contratista){
    
     $.ajax({
         method: "POST",
         url: "cambiar_doc_contratista.php",
         data: 'contratista='+contratista,
         success: function(data){			  
          if (data==0) {
             window.location.href='gestion_documentos_contratistas.php';
          } else {
             swal("Cancelado", "No se pudo procesar. Vuelva a Intentar.", "error");
    	  }
         }                
    });
}

function eliminar(id,condicion){
           //alert(id+' '+condicion);
    
            swal({
            title: "Confirmar Eliminar Contratista",
            //text: "Your will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, Eliminar",
            cancelButtonText: "No, Eliminar",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "add/eliminar.php",
                    data: 'id='+id+'&condicion='+condicion,
        			success: function(data){			  
                     if (data==0) {
                         swal({
                                title: "Contratista Eliminada",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  } else {
                         swal("Cancelado", "Contratista No Eliminada. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
}

function accion(valor,id,accion){
        //alert(id+' '+valor+' '+accion);
        if (valor===1) {
            swal({
            title: "Confirmar deshabilitar Contratista",
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
                                title: "Contratista Deshabilitada",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  } else {
                         swal("Cancelado", "Contratista No Deshabilitada. Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Contratista",
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
                                title: "Contratista Habilitada",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  } else {
                         swal("Cancelado", "Contratista No Hbilitada. Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } 
}

function accion2(valor,id,accion){
        //alert(id+' '+valor+' '+accion);
        if (valor===0) {
            swal({
            title: "Confirmar deshabilitar Contratista",
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
                                title: "Contratista Deshabilitada",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  } else {
                         swal("Cancelado", "Contratista No Deshabilitada. Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Contratista",
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
                                title: "Contratista Habilitada",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  } else {
                         swal("Cancelado", "Contratista No Hbilitada. Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_contratistas.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } 
}


    
 $(document).ready(function() {

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
</script>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
