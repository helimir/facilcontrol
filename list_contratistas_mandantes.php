<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and  $_SESSION['nivel']==2  ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$mandante=$_SESSION['mandante'];  
$sql_contratistas=mysqli_query($con,"select  d.acreditada, c.estado as estado_contratista, r.Region, o.Comuna, c.*, p.* from contratistas as c Left Join pagos as p On p.idcontratista=c.id_contratista Left Join regiones as r On r.IdRegion=c.dir_comercial_region Left Join comunas as o On o.IdComuna=c.dir_comercial_comuna LEFT JOIN contratistas_mandantes as d ON d.contratista=c.id_contratista where d.mandante='$mandante' and c.eliminar=0  ");
$existe_contratistas=mysqli_num_rows($sql_contratistas);
    

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

    <script src="js\jquery-3.1.1.min.js"></script>


    <script>

            $(document).ready(function() {

                $('#menu-contratistas').attr('class','active');

            });
    </script>

    <style>
        .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }

    </style>

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
                    <h2 style="color: #010829;font-weight: bold;">Reporte Contratistas <?php ?></h2>                    
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        
                        <div class="ibox-content">
                            <div class="form-group row">
                                    <div class="col-lg-12">
                                        <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-2 col-sm-12"  href="crear_contratista.php" >NUEVA CONTRATISTA</a>
                                        <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-2 col-sm-12"  href="list_contratos.php"    >CONTRATOS</a>
                                        <a style="margin-top:1%;background:#217346;border:1px #217346 solid;color:#fff" class="btn btn-sm col-lg-3 col-sm-12" href="excel/excel_contratistas.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Contratistas</a>
                                    </div>
                            </div>
                            <br>
                            <?php include('resumen.php') ?>

                        <div class="row">                    
                        </div>
                        <br>    
                        <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una Contratista" />
                        <br>
                         <div class="table table-responsive">
                            <table style="width: 100%;" class="footable table" data-page-size="25" data-filter="#filter">
                               <thead>
                                <tr>
                                    <th></th>
                                    <th>Razon Social</th>
                                    <th>RUT Empresa</th>
                                    <th data-hide="phone" >Adminisrador</th>
                                    <th style="text-align: center;" data-hide="phone">Plan</th>
                                    <th style="text-align: center;" data-hide="phone">Documentaci&oacute;n</th>
                                    <th style="text-align: center;" data-hide="phone">Estado</th>                                    
                                    
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

                                    if ($existe_contratistas==0) { ?>
                                        <tr>
                                            <td colspan="7">No hay registros que mostrar</td>                                                                   
                                        </tr>

                                    <?php } else { 
                                        $i=1;
                                        $condicion=0;
                                        foreach ($sql_contratistas as $row) { 
                                            
                                            switch ($row['plan']) {
                                                case '0';$plan="Prueba";break;
                                                case '1';$plan="Mensual";break;
                                                case '2';$plan="Semestral";break;
                                                case '3';$plan="Anual";break;


                                            } ?>
                                                <tr>
                                                    <td data-toggle="true"></td>                                                                   
                                                    <td><?php echo $row['razon_social'] ?></td>
                                                    <td><?php echo $row['rut'] ?></td>                                
                                                    <td><?php echo $row['administrador']?></td>
                                                    <td><?php echo $plan ?></td>
                                                    
                                                <?php   if ($row['estado_contratista']==0) {
                                                    
                                                    $query_con_contrato=mysqli_query($con,"select contratista from contratos where contratista='".$row['id_contratista']."' ");
                                                    $result_con_contrato=mysqli_num_rows($query_con_contrato);  ?>
                                                        
                                                        <?php if ($row['dualidad']==0) { ?>
                                                                <td style="background:;text-align: center;" ><button style="background:#5635B9;border: none;" title="Documentos" class="btn btn-primary btn-xs btn-block" type="button" onclick="gestion_documentos(<?php echo $row['id_contratista'] ?>)" ><small style="font-weight:bold;font-size:12px">GESTIONAR</small></button></td>
                                                        <?php } else { ?>
                                                                <td style="background:;text-align: center;" ><button title="Documentos" class="btn btn-secondary btn-xs btn-block" type="button" disabled ><small style="font-weight:bold;font-size:12px">GESTIONAR</small></button></td>
                                                        <?php }  ?>
                                                                
                                                        <?php if ($row['acreditada']==0) { ?>
                                                                <td><label style="padding: 5%;text-align: center;font-weight:bold;font-size:11px" class="label bg-danger block">NO ACREDITADA</label></td>
                                                        <?php } else  { ?>
                                                                <td><label style="padding: 5%;text-align: center;font-weight:bold;font-size:11px" class="label bg-success block">ACREDITADA</label> </td>
                                                        <?php }  ?>      
                                                            
                                                    <?php } else { ?>
                                                        <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-primary btn-xs" type="button" disabled="" onclick="gestion_documentos(<?php echo $row['id_contratista'] ?>)" ><small>GESTIONAR</small></button></td>
                                                        <td><label style="padding: 6%;text-align: center;color:#282828" class="label bg-warning b-r-xl block">DESHABILITADA</label> </td>
                                                            
                                                <?php } ?>       
                                                    
                                                    
                                                
                                                    <td><?php echo $row['nombre_fantasia'] ?></td>           
                                                    <td><?php echo $row['email'] ?></td>
                                                    <td><?php echo $row['fono'] ?></td>
                                                    <td><?php echo $row['Region'] ?></td>
                                                    <td><?php echo $row['Comuna'] ?></td>
                                                    <td><?php echo $plan ?></td>
                                                    <td><?php echo $row['fecha_inicio_plan'] ?></td>
                                                    <td><?php echo $row['fecha_fin_plan'] ?></td>
                                                
                                                </tr>
                                            
                                    <?php   }
                                        } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="9">
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

                            function acreditaciones (id) {
                               // alert(id+' '+contratista);
                                $('.body').load('selid_acreditaciones.php?id='+id,function(){
                                    $('#modal_acreditaciones').modal({show:true});
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


                             <div class="modal fade" id="modal_acreditaciones" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Plan de Acreditaciones</h3>
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
    window.location.href='gestion_contratos_mandantes.php';
}

function gestion_documentos(contratista){
     
     $.ajax({
         method: "POST",
         url: "sesion/cambiar_doc_contratista.php",
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
        //Salert(id);
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
