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

?>

<!DOCTYPE html>
<html>
<html translate="no">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'/>
    <meta http-equiv='expires' content='0'/>
    <meta http-equiv='pragma' content='no-cache'/>

    <title>FacilControl | Contratistas Acreditadas </title> 
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    
      <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">
    
     <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">

<script>
function selcontratista(id,mandanate){
    //alert(id); 
    $.post("doc_contratos.php", { id: id }, function(data){
    window.location.href='contratistas_acreditadas.php';
        
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
                    <h2 style="color: #010829;font-weight: bold;">Contratistas Acreditadas <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                    
                         <div class="ibox-title">
                             <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu"  href="crear_contratista.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contratistas</a>&nbsp;
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_contratistas_mandantes.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i>Lista de Contratistas</a>
                                    </div>
                              </div>
                                  
                         </div> 
                        
                        
                        <div class="ibox-content">
                                 
                                 <?php
                                 
                                    # verificar cuantas contratistas tiene el mandante
                                    $query_cm=mysqli_query($con,"select * from contratistas_mandantes where mandante='".$_SESSION['mandante']."' and acreditada=1 ");
                                    $cant_c=mysqli_num_rows($query_cm);
                                    
                                    $contratistas=mysqli_query($con,"SELECT c.* from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante Left Join contratistas_mandantes as a On a.contratista=c.id_contratista where m.id_mandante='".$_SESSION['mandante']."' and a.acreditada=1 ");
                                    $result_c=mysqli_fetch_array($contratistas);
                                    
                                    # si mandante tiena mas de una contratista
                                    if ($cant_c>1) {    ?>
                                            <div class="row">           
                                                    <label  class="col-1 col-form-label"><b>Contratista </b></label>
                                                 
                                                <div style="text-align: right;" class="col-6">   
                                                    <select name="contratista" id="contratista" class="form-control m-b"  onchange="selcontratista(this.value)">
                                                        <?php                                                
                                                        
                                                        if ($_SESSION['contratista']=="") {
                                                            echo '<option value="0" selected="" >Seleccionar Contratista</option>';
                                                        } else {
                                                            $query=mysqli_query($con,"select * from contratistas where id_contratista='".$_SESSION['contratista']."' ");
                                                            $result=mysqli_fetch_array($query);
                                                            echo '<option value="" selected="" >'.$result['razon_social'].'</option>';
                                                            echo '<option value="0" >Seleccionar Contratista</option>';
                                                        }    
                                                        
                                                        foreach ($contratistas as $row) {
                                                           echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                        }  
                                                             
                                                          ?>                                           
                                                    </select>
                                               </div> 
                                             </div> 
                                             
                                             <div class="row">
                                                <label  class="col-1 col-form-label"><b>Nombre </b></label>
                                                <div style="" class="col-8"><label class="col-11 col-form-label"><?php echo $result_contratista['razon_social']?> </label></div>
                                            </div>                                        
                                            <div class="row">
                                                <label  class="col-1 col-form-label"><b> RUT: </b></label>
                                                <div style="" class="col-8"><label class="col-11 col-form-label"><?php echo $result_contratista['rut'] ;?> </label></div>
                                            </div>
                                <?php } ?>
                                        
                                           
                                
                                            
                        
                            <hr />
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una Contratista" />
                            <div class="table table-responsive"> 
                                <table style="width: 100%;" class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                                   <thead>
                                    <tr >
                                        <th>#</th>
                                        <th style="width: ;">Raz&oacute; Social</th>
                                        <th style="width: ;">RUT </th>
                                        <th style="width: ;">Representante </th>
                                        <th style="width: ;" >Documentos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                     if ($cant_c>0) {   
                                          $i=1;
                                          foreach ($contratistas as $row){  
                                          if ($row['vfecha']=='0000-00-00') {
                                            $fecha='Indefinido';                                        
                                          } else {
                                            $fecha=$row['vfecha'];
                                          } 
                                          $url ='doc/validados/'.$_SESSION['mandante'].'/'.$row['id_contratista'].'/zip/';
                                        ?> 
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $row['razon_social'] ?></td>
                                                <td><?php echo $row['rut'] ?></td>
                                                <td><?php echo $row['representante'] ?></td>
                                                <td><label class="col-form-label font-bold"><a class="" href="descargar.php?url=<?php echo $url ?>&rut=<?php echo $row['rut'] ?>" ><u>Descargar Documentos</u></a></label></td>
                                            </tr>
                                       <?php $i++; } 
                                       
                                       } else {?>
                                          <tr>
                                            <td colspan="4"><label class="col-form-label font-bold" >No hay contratistas acreditadas</label> </td>
                                          </tr>                                         
                                      <?php } ?>
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
                                 function modal_doc_acreditados(id) {
                                   //alert(id)
                                   $('.body').load('selid_doc_acreditados_contratistas.php?id='+id,function(){
                                     $('#modal_doc_acreditados').modal({show:true});
                                   });
                                 }
                            </script>
                         
                        
                        </div>
                      </div>
                   </div>
               </div>
               
               
           </div>
           
                    <div class="modal fade" id="modal_doc_acreditados" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                       <div class="modal-content">
                         <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documentos Acreditados Contratista</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                     </button>
                         </div>
                         <div class="body">
                                             
                                                  
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
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            });
        </script>
        
<?php if ($_GET['import_status']=='success') { ?>
         <script>
           $(document).ready(function () {
            swal({
                title: "Lista Importada",
                //text: "You clicked the button!",
                type: "success"
            });
           
           });
        </script>

<?php } 
     if ($_GET['import_status']=='error') { ?>        
         <script>
           $(document).ready(function () {
            swal({
                title: "Lista No Importada",
                text: "Vuelva a Intentar",
                type: "error"
            });
           
           });
        </script>

<?php } 
     if ($_GET['import_status']=='invalid_file') { ?> 
              <script>
           $(document).ready(function () {
            swal({
                title: "Archivo Invalido",
                text: "Tipo de archivo no permitido",
                type: "error"
            });
           
           });
        </script>

<?php } ?>

<script>

                                        
function refresh_asignar(){
  window.location.href='list_trabajadores.php';
}   
         
function editar(idtrabajador,editar) {
        $.ajax({
			method: "POST",
            url: "sesion_trabajador.php",
			data:'id='+idtrabajador+'&editar='+editar,
			success: function(data){
              window.location.href='edit_trabajador.php';
			}
       });
    }           


function refresh(){
    window.location.href='list_trabajadores.php';
}

function eliminar(id,condicion){
           //alert(id+' '+condicion);
    
            swal({
            title: "Confirmar Eliminar Trabajador",
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
                                title: "Trabajador Eliminado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_trabajadores.php', 3000);
        			  } else {
                         swal("Cancelado", "Trabajador No Eliminado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
}


function accion(valor,id,accion){
        //alert(id);
        if (valor===0) {
            swal({
            title: "Confirmar deshabilitar Trabajador",
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
                                title: "Trabajador Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(refresh, 1000);
        			  } else {
                         swal("Cancelado", "Trabajador No Deshabilitado. Vuelva a Intentar.", "error");
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
            title: "Confirmar Habilitar Trabajador",
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
                                title: "Trabajador Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(refresh, 1000);
        			  } else {
                         swal("Cancelado", "Trabajador No Hbilitado. Vuelva a Intentar.", "error");
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


 $(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();
                       


});
</script>

</body>


</body>

</html>
<?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
