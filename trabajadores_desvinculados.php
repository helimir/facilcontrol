<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

if ($_SESSION['nivel']==2) {    
    
    
    $contratistas=mysqli_query($con,"SELECT c.* from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where m.rut_empresa='".$_SESSION['usuario']."' ");
    $result_contratista=mysqli_fetch_array($contratistas);
    
    $sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
    $result=mysqli_fetch_array($sql_mandante);
    $mandante=$result['id_mandante'];
    
    $contratos=mysqli_query($con,"SELECT * from contratos where contratista='".$result_contratista['id_contratista']."' ");
    
    $acreditados=mysqli_query($con,"select o.*, t.*, c.*, n.*, o.fecha as vfecha, t.rut as trut from observaciones as o Left Join trabajador as t On t.idtrabajador=o.trabajador Left join contratos as c On c.id_contrato=o.contrato Left Join contratistas as n On n.id_contratista=c.contratista Left Join mandantes as m On id_mandante=c.mandante where n.id_contratista='".$_SESSION['contratista']."' and o.estado=1 and o.contrato='".$_SESSION['contrato']."' and m.rut_empresa='".$_SESSION['usuario']."' and t.eliminar=0  ");
    
} 
if ($_SESSION['nivel']==3) {
    $contratos=mysqli_query($con,"SELECT c.*, o.* from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista where o.rut='".$_SESSION['usuario']."' ");
    $result_contratista=mysqli_fetch_array($contratos);
    
    if  ($_SESSION['contrato_acreditados']==0) {
        $acreditados=mysqli_query($con,"select a.*, t.*, c.razon_social, a.editado as fecha_d from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista   where a.contratista='".$_SESSION['contratista']."' and a.estado=2 and t.estado=0 ");
    } else {
        $acreditados=mysqli_query($con,"select a.*, t.*, c.razon_social, a.editado as fecha_d from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista  where a.contratista='".$_SESSION['contratista']."' and a.estado=2 and t.estado=0 and contrato='".$_SESSION['contrato_acreditados']."' ");
    }    
    
}

?>

<!DOCTYPE html>
<html>
<html translate="no">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'/>
    <meta http-equiv='expires' content='0'/>
    <meta http-equiv='pragma' content='no-cache'/>

    <title>FacilControl | Trabajadores Desvinculados</title> 
    <meta content="" name="description">
    <meta content="" name="keywords">

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
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

    <script src="js\jquery-3.1.1.min.js"></script>
    
    

<script>

$(document).ready(function() {

        $('#menu-trabajadores').attr('class','active');
        $('.footable').footable();
        $('.footable2').footable();
        
        $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            })
                   


});
function selcontrato(contrato){
    //alert(contrato); 
    $.post("sesion/contrato_acreditados.php", { contrato: contrato }, function(data){
        window.location.href='trabajadores_desvinculados.php';
    }); 
   }

function selcontratista(id){
    //alert(id); 
    $.post("contratos.php", { id: id }, function(data){
        $("#contrato").html(data);
    }); 
   }
     
</script>

<style>

.checkboxtexto {
          /* Checkbox texto */
          font-size: 100%;
          display: inline;
        }

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
                    <h2 style="color: #010829;font-weight: bold;">Trabajadores Desvinculados <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                                 <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <?php if ($_SESSION['nivel']==2) { ?>
                                                <a  class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <?php } else { ?>
                                                <a  class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <?php } ?>      
                                            <a  class="btn btn-sm btn-success btn-submenu" href="list_trabajadores.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Trabajadores</a>
                                      </div>
                                </div>
                                <?php include('resumen.php') ?>
                            </div>
                        
                        
                        <div class="ibox-content">
                                    <div class="row">                                    
                                        <label style="background:#eee;border-bottom: #fff 2px solid;"  class="col-2 col-form-label"><b><i class="fa fa-caret-right" aria-hidden="true"></i> Contratos</b></label>
                                        <div class="col-sm-6">   
                                            <select name="contrato" id="contrato" class="form-control" onchange="selcontrato(this.value)">
                                                        <?php
                                                            if ($_SESSION['contrato_acreditados']==0) {
                                                                echo '<option value="0" selected="" >Todos los Desvinculados</option>';
                                                                
                                                                //while($rowC = mysqli_fetch_assoc($contratos)) {
                                                            foreach ($contratos as $rowC) {     
                                                                echo	'<option value="'.$rowC['id_contrato'].'">'.$rowC['nombre_contrato'].'</option>';
                                                                }
                                                                
                                                            } else {
                                                                $query=mysqli_query($con,"select * from contratos where id_contrato='".$_SESSION['contrato_acreditados']."' ");
                                                                $result=mysqli_fetch_array($query);
                                                                echo '<option value="'.$result['id_contrato'].'" >'.$result['nombre_contrato'].'</option>';
                                                                echo '<option value="0" >Todos los Desvinculados</option>';                                                    
                                                                //while($rowC = mysqli_fetch_assoc($contratos)) {
                                                                foreach ($contratos as $rowC) {    
                                                                echo	'<option value="'.$rowC['id_contrato'].'">'.$rowC['nombre_contrato'].'</option>';
                                                                }
                                                            }                                   
                                                        ?>
                                            </select>
                                        </div>
                                    </div>                             
                                                            
                                    <div style="margin-top:2%" class="row"> 
                                        <div class="col-12">
                                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un trabajador" />
                                            <div class="table-responsive">  
                                                <table class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                                                <thead>
                                                    <tr class="cabecera_tabla">
                                                        <th style="width: 5%;border-right:1px #fff solid;">#</th>
                                                        <th style="width: 15%;border-right:1px #fff solid;">Nombres</th>
                                                        <th style="width: 15%;border-right:1px #fff solid;">Apellidos</th>
                                                        <th style="width: 10%;border-right:1px #fff solid;">RUT </th>
                                                        <th style="width: 15%;border-right:1px #fff solid;" >Contrato</th>
                                                        <th style="width: 15%;border-right:1px #fff solid;" >Fecha</th>
                                                        <th style="width: 15%" >Documentos</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php 
                                                    $i=1;
                                                    foreach ($acreditados as $row){  
                                                    
                                                    $url='img/trabajadores/'.$row['id_contratista'].'/'.$row['trut'].'/foto_'.$row['trut'].'.jpeg';
                                                    
                                                    $query_d=mysqli_query($con,"select estado from trabajadores_asignados where trabajadores='".$row['idtrabajador']."' ");
                                                    $result_d=mysqli_fetch_array($query_d);
                                                    
                                                    $documentos='doc/validados/'.$row['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/zip/documentos_validados_trabajador_'.$row['rut'].'.zip'; 
                                                    ?> 
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row['nombre1'] ?></td>
                                                            <td><?php echo $row['apellido1'] ?></td>
                                                            <td><?php echo $row['rut'] ?></td>
                                                            <td><?php echo $row['razon_social']  ?></td>
                                                            <td><?php echo $row['fecha_d']  ?></td>
                                                            <td><a href="<?php echo $documentos ?>" ><i class="fa fa-file-archive-o"></i><u> Documentos</u> </a></td>
                                                            
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
                                    </div>
                               </div>
                            
                            
                            <script>
                                 function modal_doc_acreditados(id) {
                                   //alert(id)
                                   $('.body').load('selid_doc_acreditados.php?id='+id,function(){
                                     $('#modal_doc_acreditados').modal({show:true});
                                   });
                                 }

                                 function desvincular(rut,trabajador,contrato) {                                      
                                    $('#modal_desvincular input[name=rut]').val(rut);
                                    $('#modal_desvincular input[name=trabajador]').val(trabajador);
                                    $('#modal_desvincular input[name=contrato]').val(contrato);
                                    $('#modal_desvincular').modal({show:true});
                                }  
                            </script>
                         
                        
                        </div>
                      </div>
                   </div>
               </div>
               
               
           </div>
           
                                <!-- MODAL desvincular -->
                                <div class="modal fade" id="modal_desvincular" tabindex="-1" role="dialog" aria-hidden="true">
                                        <?php  session_start(); ?>
                                        <div class="modal-dialog modal-md">
                                            <div class="modal-content">
                                            <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                              <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Desvincular Trabajador  </h3>
                                              <!--<button style="color: #FFFFFF;" type="button" class="close" onclick="window.location.href='list_trabajadores.php'" ><span aria-hidden="true">x</span></button>-->
                                              <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close" ><span aria-hidden="true">x</span></button>
                                            </div>
                                             <div class="body">
                                                <div class="modal-body">
                                                  <form  method="post" name="frmDesvincular" id="frmDesvincular" enctype="multipart/form-data" >    
                                                     <div class="modal-body">
                                                     
                                                        <div class="row">                                                  
                                                          <div class="form-group col-12">
                                                             <div class="i-checks"> <input style="" class="" name="desvincular_tipo" id="desvincular_tipo" type="radio" value="1"  /> <span style="font-weight: bold;font-size: 14px;">&nbsp;&nbsp;Contrato</span> </div>
                                                             <br />
                                                             <div class="i-checks"> <input style="" class="" name="desvincular_tipo" id="desvincular_tipo" type="radio" value="2"  /> <span style="font-weight: bold;font-size: 14px;">&nbsp;&nbsp;Contratista</span> </div> 
                                                          </div>   
                                                        </div>
                                                     
                                                        <div class="row">                                                  
                                                          <div class="form-group col-12">
                                                            <div style="width: 100%;display: inline-block;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span  style="background:#F8AC59; color: #282828;font-weight: bold;" class="btn btn-default btn-file"><span class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                                    <span  class="fileinput-exists">Cambiar</span>
                                                                    <input class="form-control" type="file" id="archivo_desvincular" name="archivo_desvincular" accept="application/pdf"  />
                                                                </span>
                                                                <span class="fileinput-filename"></span>                                                             
                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                            </div>
                                                          </div>   
                                                        </div>
                                                                                                                                                              
                                                       </div>                      
                                                       <div style="text-align: left;" class="modal-footer">
                                                                <button class="btn btn-success btn-xs" type="button" onclick="cargar_desvincular()" ><i class="fa fa-upload"></i> Enviar Desvinculacion</button>  
                                                                <button class="btn btn-danger btn-xs" title="Cerrar Ventana" class="close" data-dismiss="modal" aria-label="Close"  ><i class="fa fa-window-close" ></i> Cancelar </button>
                                                       </div> 
                                                      
                                                       <input type="hidden" name="trabajador" id="trabajador_desvincular" />
                                                       <input type="hidden" name="contrato" id="contrato_desvincular" /> 
                                                       <input type="hidden" name="rut" id="rut_desvincular" />
                                                      
                                                   </form>
                                                </div>
                                           </div>
                                        </div>
                                     </div>
                                   </div>
           
           
                    <div class="modal fade" id="modal_doc_acreditados" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-md">
                       <div class="modal-content">
                         <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documentos Acreditados</h3>
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
    
    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
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

  function cargar_desvincular(){ 
               var tipo=$('input[name="desvincular_tipo"]:checked').val();
               var rut=$('#rut_desvincular').val();
               var trabajador=$('#trabajador_desvincular').val();
               var contrato=$('#contrato_desvincular').val();
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
                        formData.append('rut',rut);                   
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
                        	               window.location.href='trabajadores_asignados_contratista.php';
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



</script>

</body>


</body>

</html>
<?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
