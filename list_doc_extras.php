
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
$query_de=mysqli_query($con,"select d.estado as estado_doc, d.estado as estado_doc, d.*,c.* from contratistas as c left join documentos_extras as d On d.contratista=c.id_contratista where d.mandante='$mandante' order by d.id_de DESC ");
    

?>

<!DOCTYPE html>
<html>
<html translate="no">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | Reporte de Documentos Extraordinarios</title>
     <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">

<script>

function gestion_documentos_de(id){
     //alert(contratista)
     
     $.post("sesion/doc_contratos.php", { id: id }, function(data){
            window.location.href='gestion_doc_extradordinarios_mandante.php';
        });
     
     
}

</script>

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
                    <h2 style="color: #010829;font-weight: bold;">Reporte Documentos Extraordinarios <?php ?></h2>                    
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_contratos.php"    ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="crear_doc_extra.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Documento Extrairdinario</a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                            </div>
                        
                        
                        <div class="ibox-content">
                            
                        <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una Documento" />
                         <div class="table table-responsive">
                            <table style="width: 100%;" class="footable table" data-page-size="25" data-filter="#filter">
                               <thead>
                                <tr>
                                    <th style="width: ;">#</th>
                                    <th data-hide="phone" style="width: ;">Contratista</th>
                                    <th data-hide="phone" style="width: ;">RUT Empresa</th>
                                    <th data-hide="phone" style="width: ;">Documento</th>
                                    <th data-hide="phone" style="width: ;">Tipo</th>
                                    <th data-hide="phone" style="width: ;">Gestionar</th>
                                    <th style="text-align: center;">Estado</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                  $i=1;
                                  $condicion=0;
                                  foreach ($query_de as $row) {  
                                    
                                    if ($row['estado_doc']==3) {
                                        $carpeta='doc/validados/'.$mandante.'/'.$row['contratista'].'/'.$row['documento'].'_'.$row['rut'].'.pdf';
                                    } else { 
                                        $carpeta='doc/temporal/'.$mandante.'/'.$row['contratista'].'/'.$row['documento'].'_'.$row['rut'].'.pdf';
                                    }
                                     
                                    $archivo_existe=file_exists($carpeta); 
                                    
                                    switch ($row['tipo']) {
                                        case 1: $tipo='Contratista';break;
                                        case 2: $tipo='Trabajadores Contratos';break;
                                    }
                                    
                                    ?>
                                        <tr>
                                            <td><?php echo $i ?></td>
                                            <td><?php echo $row['razon_social'] ?></td>
                                            <td><?php echo $row['rut'] ?></td>                                
                                            
                                            <?php if ($archivo_existe) { ?>
                                                <td><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>
                                            <?php } else { ?>
                                                <td><?php echo $row['documento'] ?></td>
                                            <?php }  ?>
                                            
                                            <td><?php echo $tipo ?></td>
                                          
                                           <?php  
                                                # doc no enviado
                                                if ($row['estado_doc']==0) {?>
                                                    <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-primary btn-xs" type="button" onclick="gestion_documentos_de(<?php echo $row['id_contratista'] ?>)" disabled="" ><small>DOCUMENTACION</small></button></td>
                                                    <td><label style="padding: 5%;text-align: center;" class="label bg-danger block b-r-xl">NO ENVIADO</label></td>  
                                           <?php } ?>
                                           
                                           <?php  
                                                # recibido
                                                if ($row['estado_doc']==1) {?>
                                                    <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-primary btn-xs" type="button" onclick="gestion_documentos_de(<?php echo $row['id_contratista'] ?>)" ><small>DOCUMENTACION</small></button></td>
                                                    <td><label style="padding: 5%;text-align: center;" class="label bg-info block b-r-xl">RECIBIDO</label></td>  
                                           <?php } ?>
                                           
                                            <?php  
                                                # obseervacion
                                                if ($row['estado_doc']==2) {?>
                                                    <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-primary btn-xs" type="button" onclick="gestion_documentos_de(<?php echo $row['id_contratista'] ?>)" ><small>DOCUMENTACION</small></button></td>
                                                    <td><label style="padding: 5%;text-align: center;" class="label bg-warning block b-r-xl">OBSERVACION</label></td>  
                                           <?php } ?>
                                           
                                           <?php  
                                                # acreditado
                                                if ($row['estado_doc']==3) {?>
                                                    <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-primary btn-xs" type="button" onclick="gestion_documentos_de(<?php echo $row['id_contratista'] ?>)" disabled="" ><small>DOCUMENTACION</small></button></td>
                                                    <td><label style="padding: 5%;text-align: center;" class="label bg-success block b-r-xl">ACREDITADO</label></td>  
                                           <?php } ?>
                                            
                                        </tr>
                                    
                                 <?php $i++; } ?>
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






</script>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
