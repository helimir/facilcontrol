<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) ) { 
include('config/config.php');

session_destroy($_SESSION['active']);
$_SESSION['active']=33;


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');
 
$contrato=$_SESSION['lt_contrato'];
$contratista=$_SESSION['lt_contratista'];
$mandante=$_SESSION['lt_mandante'];


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
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
    
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet" />
    
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
    
    </style>

</head>
<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Trabajadores Asignados al Contrato <?php   ?></h2>
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
                                    <?php 
                                      if ($_SESSION['nivel']==3) {  ?>   
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_contratos_contratistas.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_trabajadores.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Trabajadores</a>
                                    <?php } else { ?>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_contratos_contratistas.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                    <?php } ?>   
                                    </div>
                                </div>
                             </div>
                             <?php include('resumen.php') ?>
                         </div>  
                                                 
                         <div class="ibox-content">
                              <div class="row">
                                  <div class="col-lg-12">
                                     <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Contrato">
                                     
                                     <div class="table-responsive">
                                        <table class="table footable" data-page-size="10" data-filter="#filter">
                                        
                                           <thead>
                                            <tr>
                                                <th style="width: 5%">#</th>
                                                <th style="width: 10%">Estado</th>
                                                <th style="width: 25%">Trabajador</th>
                                                <th style="width: 15%">RUT</th>
                                                <th style="width: 20%">Cargo</th>
                                                <th style="width: 10%">Desvincular</th>
                                            </tr>
                                            </thead>
                                            
                                           <tbody>
                                            
                                            <?php
                                                 
                                            if ($_SESSION['nivel']=="2") { 
                                                    $asignados=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$contrato."'  ");
                                                 } else {
                                                    $asignados=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$contrato."' and mandante='".$mandante."'  ");
                                                 }    
                                                 
                                                 $result_asignados=mysqli_fetch_array($asignados);
                                                 $lista_trab=unserialize($result_asignados['trabajadores']);
                                                 $lista_cargos=unserialize($result_asignados['cargos']);
                                                 $existe_trabajadores=mysqli_num_rows($asignados);
                                                 
                                                 
                                                 
                                                 $i=0;    
                                                 if ($existe_trabajadores>0) {          
                                                    foreach ($lista_trab as $row) {                        
                                                          
                                                              $query_trab=mysqli_query($con,"select * from trabajador where idtrabajador='".$row."' and contratista='".$contratista."' ");
                                                              $result_trab=mysqli_fetch_array($query_trab);
                                                              
                                                              $query_cargos=mysqli_query($con,"select * from cargos where idcargo='".$lista_cargos[$i]."'  ");
                                                              $result_cargos=mysqli_fetch_array($query_cargos);
                                                              
                                                              $query_verificado=mysqli_query($con,"select * from observaciones where mandante='$mandante' and contrato='$contrato' and trabajador='$row' and estado=1 ");
                                                              $result_verificados=mysqli_fetch_array($query_verificado);
                                                              $num_verificados=mysqli_num_rows($query_verificado);
                                                              
                                                              $query_d=mysqli_query($con,"select * from trabajador_desvinculado_detalle where trabajador='".$row."' ");
                                                              $result_d=mysqli_fetch_array($query_d);
                                                              
                                                              $query_e=mysqli_query($con,"select * from desvinculaciones where trabajador='".$row."' ");
                                                              $result_e=mysqli_fetch_array($query_e);
                                                              
                                                              
                                                              $num=$i+1;?>
                                                              
                                                              <tr>
                                                                  <!-- # trabajador -->  
                                                                  <td style=""><?php echo $num ?></td>
                                                                  
                                                                  <!--estado -->
                                                                 
                                                                   <?php 
                                                             
                                                                       # sino esta acreditado 
                                                                       if ($num_verificados==0) {
                                                                            # si es mandante informar si esta acreditado
                                                                            if ($_SESSION['nivel']=="2") { ?> 
                                                                                <td><div class="bg-danger p-xxs b-r-lg text-mute text-center">No Acreditado</div></td>
                                                                      <?php 
                                                                            #si es contratista    
                                                                            } else { 
                                                                                 # si el trabajdor esta en la tabla de desvinculados por aprobar
                                                                                 if ($result_d['trabajador']==$result_trab['idtrabajador']) { ?>
                                                                                    <td><button style="width:100%" class="btn btn-xs btn-danger text-left" disabled="" >Retirar</button></td>
                                                                           <?php } else { ?>  
                                                                                    <td><button style="width:100%" class="btn btn-xs btn-danger text-left" onclick="retirar(<?php echo $contrato ?>,<?php echo $mandante ?>,<?php echo $result_trab['idtrabajador'] ?>,<?php echo $lista_cargos[$i] ?>)">Retirar</button></td>
                                                                                    
                                                                           <?php } ?>         
                                                                                
                                                                                
                                                                      <?php } 
                                                                      
                                                                      # si esta acreditado
                                                                      } else { ?>
                                                                                <td><div class="bg-success p-xxs b-r-lg text-mute text-center">Acreditado</div></td>
                                                                <?php }  ?>
                                                                  
                                                                  <!-- trabajador -->  
                                                                  <td style=""><a href="" onclick="editar(<?php echo $result_trab['idtrabajador'] ?>,1)"><?php echo $result_trab['nombre1'].' '.$result_trab['apellido1'] ?></a></td>
                                                                  
                                                                  <!-- rut -->
                                                                  <td style=""><?php echo $result_trab['rut'] ?></td>
                                                                  
                                                                  <!-- cargo -->
                                                                  <td><?php echo $result_cargos['cargo'] ?></td>   
                                                                  
                                                                  <!-- desvincular --->
                                                                    <?php 
                                                                        # si el trabajador esta en proceso de desvincilar
                                                                        if ($result_e['estado']!=0) { ?>
                                                                            <td style="background: ;text-align: center;"><button style="width:100%;" title="Desvincular" class="btn btn-xs btn-warning" name="desvincular" id="desvincular"  ><small style="color: #282828;font-weight: bold;">EN PROCESO</small> </button></td>
                                                                    <?php } else { ?>
                                                                            <td style="background: ;text-align: center;"><button style="width:100%;" title="Desvincular" class="btn btn-xs btn-danger" name="desvincular" id="desvincular" onclick="desvincular('<?php echo $row ?>','<?php echo $contrato ?>',2)" ><small>DESVINCULAR</small> </button></td>
                                                                    <?php } ?>  
                                                                                                          
                                                            
                                                               </tr>
                                                                
                                                                <input type="hidden" name="trabajadores[]" id="trabajadores<?php echo $i ?>" value="<?php echo $result_trab['idtrabajador'] ?>" />
                                                                <input type="hidden" name="cargos[]" id="cargos<?php echo $i ?>" value="<?php echo $lista_cargos[$i] ?>" />
                                                                
                                                   <?php  $i++;} ?>
                                                                <input type="hidden" name="total" id="total" value="<?php echo $i ?>" />
                                                <?php } else { ?>
                                                     <tr><td colspan="6"><h2>SIN TRABAJADORES ASIGNADOS</h2></td></tr>      
                                            <?php    }
                                                    ?>            
                                          </tbody>
                                       </table>
                                     </div>       
                                     
                                  </div>
                             </div>  
                             
                              <div class="row">
                                <div class="col-12">
                                    <div class="form-wrap">
                                        <a style="" class="" type="button"  onclick="window.location.href='list_contratos_contratistas.php'" ><i class="fa fa-chevron-left" aria-hidden="true"></i> Volver Listado Contratos</a>
                                        <!--<button style="" class="btn btn-warning" type="reset" ><i class="fa fa-undo" aria-hidden="true"></i> Resetear</button>-->
                                    </div>
                                </div>
                             </div>      
                         </div>
                      </div>
                   </div>
              </div>
        </div>
            
            
                    <script>
                    
                         function desvincular(trabajador,contrato,tipo) {
                                      alert(tipo);
                                      $('#modal_desvincular input[name=trabajador]').val(trabajador);
                                      $('#modal_desvincular input[name=tipo]').val(tipo);
                                      $('#modal_desvincular input[name=contrato]').val(contrato);
                                      $('#modal_desvincular').modal({show:true});
                                  }   
                    
                    </script>
                    
                           <!-- MODAL desvincular -->
                            <div class="modal fade" id="modal_desvincular" tabindex="-1" role="dialog" aria-hidden="true">
                            <?php  session_start(); ?>
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Desvincular Trabajador del Contrato  </h3>
                                      <!--<button style="color: #FFFFFF;" type="button" class="close" onclick="window.location.href='list_trabajadores.php'" ><span aria-hidden="true">x</span></button>-->
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">x</span></button>
                                    </div>
                                     <div class="body">
                                       
                                        <div class="modal-body"> 

                                            <form  method="post" name="frmDesvincular" id="frmDesvincular" enctype="multipart/form-data" >    
                                             <div class="modal-body">
                                                <div style="text-align: center;" class="row">                                                  
                                                  <div class="form-group col-12">
                                                    <div style="width: 100%;display: inline-block;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span  style="background:#F8AC59; color: #282828;font-weight: bold;" class="btn btn-default btn-file"><span class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                            <span  class="fileinput-exists">Cambiar</span>
                                                            <input class="form-control"   type="file" id="archivo_desvincular" name="archivo_desvincular" accept="pdf" />
                                                        </span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                    </div>
                                                  </div>   
                                                </div>
                                                
                                                <!--<div class="row">
                                                  <div class="form-group col-12">
                                                        <textarea rows="4" class="form-control" name="obs_desvincular" id="obs_desvincular" placeholder="Observaciones (opcional)"></textarea>
                                                  </div>   
                                                </div>-->
                                                
                                                                                               
                                               </div>                      
                                               <div class="modal-footer">
                                                        <button class="btn btn-success btn-md" type="button" onclick="cargar_desvincular()" ><i class="fa fa-upload"></i> Enviar Desvinculacion</button>  
                                                        <button class="btn btn-danger btn-md" title="Cerrar Ventana" class="close" data-dismiss="modal" aria-label="Close"  ><i class="fa fa-window-close" ></i> Cancelar </button>
                                               </div> 
                                              
                                               <input type="hidden" name="trabajador" id="trabajador_desvincular" />
                                               <input type="hidden" name="tipo" id="tipo_desvincular" />
                                               <input type="hidden" name="contrato" id="contrato_desvincular" /> 
                                              
                                            </form>
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
    
    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <script>
  
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
  
   function cargar_desvincular(){ 
               
               var trabajador=$('#trabajador_desvincular').val();
               var tipo=$('#tipo_desvincular').val();
               var contrato=$('#contrato_desvincular').val();
               var comentarios=$('#obs_desvincular').val(); 
               //alert(comentarios);
               var fileInput = document.getElementById('archivo_desvincular');
               var filePath = fileInput.files.length;
               if (filePath>0) {
                   var filePath = fileInput.value;
                   //var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
                   var allowedExtensions =/(.pdf)$/i;
                   if(!allowedExtensions.exec(filePath)){
                        swal({
                            title: "Tipo No Permitido",
                            text: "Solo documentos PDF",
                            type: "warning"
                        });
                        return false;
                   } else {   
                       
                        var formData = new FormData();
                        var files= $('#archivo_desvincular')[0].files[0];
                                           
                        formData.append('archivo_desvincular',files);                   
                        formData.append('trabajador',trabajador);
                        formData.append('tipo', tipo);
                        formData.append('comentarios', comentarios);
                        formData.append('contrato', contrato);
                        $.ajax({
                                url: 'cargar_desvincular.php',
                                type: 'post',
                                data:formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response==0) {                                        
                                        swal({
                                                title: "Desvinculacion Enviada",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                            });
                                        setTimeout(
                                        function() {
                        	               window.location.href='trabajadores_asignados.php';
                                        },3000);
                                    } else {
                                        if (response==2) {
                                             swal({
                                                title: "Sin Documento",
                                                text: "Debe seleccionar un archivo",
                                                type: "warning"
                                            });
                                        } else {
                                            swal({
                                                title: "Documeto No Cargado",
                                                text: "Vuelva a intetar",
                                                type: "error"
                                            });
                                        }    
                                    }     
                                }
                        });
                    } 
               } else {
                    swal({
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF",
                        type: "warning"
                    });
               }     
                    
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
        
   function retirar(contrato,mandante,id,cargo) {
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
                  data: 'contrato='+contrato+'&mandante='+mandante+'&id='+id+'&trabajadores='+trabajadores+'&cargos='+cargos+'&idcargo='+cargo,
       			  success: function(data){
          			  if (data==0) {   
      			        swal("Retirado!", "Trabajador retirado del Contrato.", "success"); 
                        setTimeout(window.location.href='trabajadores_asignados.php?contrato='+contrato+'&mandante='+mandante, 12000);                             
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
     
     
 function desvincular2() {
    var contrato=$('#contrato').val();            
    var trabajador=$('#trabajador').val();
    var cargo=$('#cargo').val();
    var rut=$('#rut').val();
    var comentarios=$('#comentarios').val();

    var fileInput = document.getElementById('carga_desvincular');
    var filePath = fileInput.files.length;
    if (filePath>0) {
                   
        var filePath = fileInput.value;
        var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
        if(!allowedExtensions.exec(filePath)){
            swal({
                title: "Tipo No Permitido",
                text: "Solo documentos PDF",
                type: "warning"
            });
            return false;
        } else {        
            //
            var formData = new FormData();
            var files= $('#carga_desvincular')[0].files[0];
                                           
            formData.append('archivo',files);
            formData.append('contrato',contrato);
            formData.append('trabajador',trabajador);
            formData.append('cargo',cargo);
            formData.append('rut',rut);  
            formData.append('comentarios',comentarios);
            //alert('p');
            $.ajax({
                url: 'add/desvincular_trabajador.php',
                type: 'post',
                data:formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response==0) {                                        
                        swal({
                            title: "Trabajador Desvinculado",
                            //text: "Un Documento no validado esta sin comentario",
                            type: "success"
                        });
                        setTimeout(function() { window.location.href='trabajadores_asignados.php'; },3000);
                    } else {
                        swal({
                            title: "Documeto No Cargado",
                            text: "Vuelva a intetar",
                            type: "error"
                        });
                    }     
                }
            });
                    } 
        } else {
            swal({
                title: "Sin Documento",
                text: "Debe seleccionar un documento PDF/JPG/JPEG/PNG",
                type: "warning"
            });
        }  
 }    
    
    
    
   
</script>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
