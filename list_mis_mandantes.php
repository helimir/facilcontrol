<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3 ) { 

    include('config/config.php');

    $contratista=$_SESSION['contratista'];
    $mandante=$_SESSION['mandante'];

    $query_man=mysqli_query($con,"select c.*, o.*, m.* from contratistas_mandantes as c LEFT JOIN mandantes as m ON m.id_mandante=c.mandante LEFT JOIN contratos as o ON o.contratista=c.contratista where c.contratista='$contratista' group by c.idcm ");
    $result_man=mysqli_fetch_array($query_man);

    $query_con=mysqli_query($con,"select * from contratistas where id_contratista='".$_SESSION['contratista']."' ");
    $result_con=mysqli_fetch_array($query_con);

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

    <title>FacilControl | Mis Mandantes </title>
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
                
    $('#menu-mis-mandantes').attr('class','active');
                
    });
    
   function gestion_t(mandante,contrato,accion) {
        alert(mandante+' '+contrato)
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

function agregar(usuario,opcion) {
    swal({
        title: "¿Desea Agregar como Mandante?",
        //text: "Desea Agregarla",
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#1AB394",
        confirmButtonText: "Si, Agregar!",
        cancelButtonText: "No, Agregar!",
        closeOnConfirm: false,
        closeOnCancel: false },
        function (isConfirm) {
            if (isConfirm) { 
                $.ajax({
                    method: "POST",
                    url: "add/agregar_dual.php",
                    data: 'rut='+usuario+'&opcion='+opcion,
                    success: function(data) {
                        alert(data)
                        if (data==0) {
                            swal({
                                title: "Mandante Agregado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                          setTimeout(window.location.href='list_mis_mandantes.php', 3000);                            
                        } else {
                            swal("Disculpe Error de Sistema", "Vuelva a intentar", "error");
                        }
                    },
                });     
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        }); 
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
                    <h2 style="color: #010829;font-weight: bold;">Mis Mandantes <?php #echo $_SESSION['contratista'] ?></h2>
                    
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                              
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background:#217346;border:1px  #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_mandantes.php"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Mandantes</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratista.php" class="" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="gestion_contratos.php" class="" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Gesti&oacute;n de Contratos</a>
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                             
                          </div>
                        <div class="ibox-content">

                            <div class="form-group row"> 
                                <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                    <?php if ($result_con['dualidad']==0) { ?>
                                        <a style="font-size:12px;color:#fff" class="btn btn-success btn-sm" onclick="agregar('<?php echo $_SESSION['usuario'] ?>',2)"><b>AGREGAR COMO MANDANTE</b></a>
                                    <?php } else {?>        
                                        <button style="font-size:12px;color:#fff" class="btn btn-secondary btn-sm" disabled ><b>AGREGAR COMO MANDANTE</b></button>
                                    <?php }  ?>                                    
                                </div>
                            </div>
                            <br>

                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Mandante">
                            
                            <div class="table-responsive">
                                <table class="table footable " data-page-size="10" data-filter="#filter">
                                   <thead class="cabecera_tabla">
                                    <tr >                                        
                                        <th style="width: 05%;border-right:1px #fff solid" >Mandante</th>
                                        <th style="width: 15%;border-right:1px #fff solid" >RUT</th>
                                        <th style="width: 20%;border-right:1px #fff solid" >Administrador</th>
                                        <th style="width: 15%;border-right:1px #fff solid" >Fono</th>
                                        <th style="width: 15%;border-right:1px #fff solid" >Email</th>
                                        <!--<th style="width: 15%;border-right:1px #fff solid" >Documentos</th>
                                        <th style="width: 10%;" >Acreditación</th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                      $i=1;
                                      foreach ($query_man as $row) {  ?>
                                         <tr>                                            
                                                                                     
                                            <!-- nombre del contrato -->
                                            <td><?php echo $row['razon_social'] ?></td>
                                      
                                            <td><?php echo $row['rut_empresa'] ?></td>
                                            <td><?php echo $row['administrador'] ?></td>
                                            <td><?php echo $row['fono'] ?></td>
                                            <td><?php echo $row['email'] ?></td>

                                            <!--
                                            <?php 
                                                # si contratista esta acreditada
                                                #if ($row['acreditada']==1) {                                                     
                                                #    $url ='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/zip/'; 
                                                #    if ($row['rut_empresa']!=$_SESSION['usuario']) { ?>
                                                        <td><a style="padding-top: 0.5%;;margin-left: 3%;margin-top: -0.5%;" class="font-bold" href="" ><u>Documentos</u></a></td>
                                                    <?php
                                                #    } else { ?>
                                                        <td>Mandante</td>
                                                    <?php 
                                                #    } ?>
                                                    <td><div style="font-size: 12px;text-align:center;" class="bg-success p-xxs"><small><b>ACREDITADA</b></small></div></td>             
                                            <?php# } else { ?>
                                                    <td><div style="font-size: 12px;text-align:center;" class="bg-danger p-xxs"><small><b>ACREDITADA</b></small></div></td>
                                                    <td><div style="font-size: 12px;text-align:center;" class="bg-danger p-xxs"><small><b>ACREDITADA</b></small></div></td>
                                            <?php #}  ?>
                                          </tr>-->
                                        
                                    <?php  $i++;} ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="5">
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
