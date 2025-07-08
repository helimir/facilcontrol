<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario']) ) { 
include('config/config.php');


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');
 
$contrato=$_SESSION['contrato'];
$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];

if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}

$query_contrato=mysqli_query($con,"select * from contratos where id_contrato='".$_SESSION['contrato']."' ");
$result_contrato=mysqli_fetch_array($query_contrato);
?>



<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">
<head>

    <title>FacilControl | Trabajadores Asignados</title>
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

    <script src="js\jquery-3.1.1.min.js"></script>
    
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
        
        .loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #1C84C6;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;      
}  

.cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }


@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}         
        
    
    </style>
    
    <script>
    
    $(document).ready(function() {
            $('#menu-contratos').attr('class','active');

            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });

            $('.footable').footable();
            $('.footable2').footable();
                                
        });
    
    function cargar_desvincular(){ 
               
               var rut=$('#rut_desvincular').val();
               var trabajador=$('#trabajador_desvincular').val();
               var tipo=$('#tipo_desvincular').val();
               var contrato=$('#contrato_desvincular').val();
               var comentarios=$('#obs_desvincular').val(); 
               var mandante=$('#mandante_desvincular').val();
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
                        formData.append('mandante', mandante);
                        $.ajax({
                                url: 'cargar/cargar_desvincular.php',
                                type: 'post',
                                data:formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function(){
                                    const progressBar = document.getElementById('myBar');
                                    const progresBarText = progressBar.querySelector('.progress-bar-text');
                                    let percent = 0;
                                    progressBar.style.width = percent + '%';
                                    progresBarText.textContent = percent + '%';
                                                                
                                    let progress = setInterval(function() {
                                        if (percent >= 100) {
                                            clearInterval(progress);                                                                                                       
                                        } else {
                                            percent = percent + 1; 
                                            progressBar.style.width = percent + '%';
                                            progresBarText.textContent = percent + '%';
                                        }
                                    }, 100);
                                    $('#modal_cargar').modal('show');						
                    			},
                                success: function(response) {
                                    if (response==0) {
                                        $('#modal_cargar').modal('hide');
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
                                        $('#modal_cargar').modal('hide');
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
                                },
                    			complete:function(data){
                                     $('#modal_cargar').modal('hide');
                                }, 
                                error: function(data){
                                    $('#modal_cargar').modal('hide');
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
            url: "sesion/sesion_trabajador.php",
			data:'id='+idtrabajador+'&editar='+editar,
			success: function(data){
              window.location.href='edit_trabajador.php';
			}
       });
    }  
        
   function retirar(contrato,id) {
    
        swal({
            title: "Retirar Trabajador del Contrato",
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
                  data: 'contrato='+contrato+'&id='+id,
       			  success: function(data){
          			  if (data==0) {   
      			        swal("Retirado!", "Trabajador retirado del Contrato.", "success"); 
                        window.location.href='trabajadores_asignados_contratista.php';                             
                      } else {
                        swal("Error!", "Vuelva a intentar.", "error");
                      }   
                  }                
                });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      //}
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
                        window.location.href='trabajadores_asignados_contratista.php';
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
 
    function doc_validar(trabajador,cargo,perfil) {
        //alert(trabajador+'-'+cargo+'-'+perfil)
        $.post("sesion/sesion_validar_trabajador.php", { trabajador: trabajador, cargo: cargo,perfil:perfil }, function(data){
            window.location.href='verificar_documentos_trabajador_contratista.php';
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
                    <h2 style="color: #010829;font-weight: bold;">Trabajadores Asignados al Contrato: <?php echo $result_contrato['nombre_contrato'] ?></h2>
                    <label class="label label-warning encabezado">Mandante: <?php echo$result_m['razon_social'].' - '.$result_m['rut_empresa'] ?></label>
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
                                        <a style="background:#217346;border:1px  #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_trabajadores_asignados.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Asignados</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos_contratistas.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="asignar_trabajadores.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Asignar Trabajadores</a>
                                    </div>
                                </div>
                             </div>
                             <?php include('resumen.php') ?>
                         </div>  
                                                 
                         <div class="ibox-content">
                              <div class="row">
                                  <div class="col-lg-12">
                                     <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">
                                     
                                     <div class="table-responsive">
                                        <table class="table footable" data-page-size="10" data-filter="#filter">
                                        
                                           <thead class="cabecera_tabla">
                                            <tr>
                                                <th style="width: 5%;border-right:1px #fff solid;">#</th>
                                                <th style="width: 5%;border-right:1px #fff solid;">Accion</th>
                                                <th style="width: 23%;border-right:1px #fff solid;">Trabajador</th>
                                                <th style="width: 15%;border-right:1px #fff solid;">RUT</th>
                                                <th style="width: 20%;border-right:1px #fff solid;">Cargo</th>
                                                <th style="width: 17%;border-right:1px #fff solid;">Acreditaci&oacute;n</th>
                                                <th style="width: 15%;">Desvincular</th>
                                                
                                            </tr>
                                            </thead>
                                            
                                           <tbody>
                                            
                                            <?php
                                                 
                                                $asignados=mysqli_query($con,"select a.cargos as cargos_t, a.*, t.*, c.*, a.estado as estado_asignado from trabajadores_asignados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajadores LEFT JOIN cargos as c ON c.idcargo=a.cargos  where a.contrato='".$contrato."' and a.estado!=2 and t.estado=0 ");
                                                $existe_trabajadores=mysqli_num_rows($asignados);
                                                 
                                                 
                                                 
                                                 $i=0;  
                                                 $num=1;  
                                                 if ($existe_trabajadores>0) {    
                                                    
                                                    foreach ($asignados as $row) {  ?>
                                                              <tr>
                                                                  <!-- # trabajador -->  
                                                                  <td style=""><?php echo $num ?></td>
                                                                  
                                                                  <!-- # accion -->  
                                                                  <td >
                                                                    <?php if ($row['verificados']==0 or $row['verificados']==2 ) { ?>
                                                                        <button title="eliminar" onclick="retirar(<?php echo $_SESSION['contrato'] ?>,<?php echo $row['idtrabajador'] ?>)"><i class="fa fa-user-times"></i></button>
                                                                    <?php } else { ?>
                                                                        <button disabled="" title="trabajador acreditado" ><i class="fa fa-user-times"></i></button>
                                                                    <?php }  ?>    
                                                                  </td>
                                                                  
                                                                  <!-- trabajador -->  
                                                                  <td style=""><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>
                                                                  
                                                                  <!-- rut -->
                                                                  <td style=""><?php echo $row['rut'] ?></td>
                                                                  
                                                                  <!-- cargo -->
                                                                  <td><?php echo $row['cargo'] ?></td>   
                                                                  
                                                                  
                                                                  
                                                                       <!--estado -->
                                                                 
                                                                   <?php 
                                                             
                                                                       # sino esta acreditado 
                                                                       if ($row['verificados']==0) { ?>
                                                                           <td><button style="font-weight:bold" title="Trabajador No Acreditado" class="btn btn-danger btn-xs btn-block" onclick="doc_validar(<?php echo $row['idtrabajador'] ?>,<?php echo $row['cargos_t'] ?>,<?php echo $row['perfiles'] ?>)">GESTI&Oacute;N DOCUMENTOS</button></td>
                                                                   <?php # si esta acreditado
                                                                      } else { 
                                                                             if ($row['verificados']==1) {      ?>
                                                                                <td><button style="font-weight:bold" title="Trabajador No Acreditado" class="btn btn-success btn-xs btn-block" onclick="doc_validar(<?php echo $row['idtrabajador'] ?>,<?php echo $row['cargos_t'] ?>,<?php echo $row['perfiles'] ?>)">ACREDITADO</button></td>
                                                                    <?php    } else { ?>
                                                                                <td><button style="color:#282828;font-weight:bold" title="Acreditacion en Proceso" class="btn btn-warning btn-xs btn-block font-bold" onclick="doc_validar(<?php echo $row['idtrabajador'] ?>,<?php echo $row['cargos_t'] ?>,<?php echo $row['perfiles'] ?>)">PROCESO REVISI&Oacute;N</button></td>
                                                                    <?php    }                  
                                                                       }  ?>
                                                                  
                                                                  
                                                                  
                                                                  <!-- desvincular--->
                                                                    <?php 
                                                                        if ($row['verificados']==0 or $row['verificados']==2) { ?>
                                                                            <td><span style="padding: 4%;font-weight:bold" class="badge badge-default block">DESVINCULAR</span></td>
                                                                    <?php } else { 
                                                                            if ($row['estado_asignado']==0)  { ?>
                                                                                <td><button style="font-weight:bold" title="Desvincular" class="btn btn-danger btn-xs btn-block" name="desvincular" id="desvincular" onclick="desvincular('<?php echo $row['rut'] ?>','<?php echo $row['idtrabajador'] ?>','<?php echo $contrato ?>','<?php echo $_SESSION['mandante'] ?>',2)" >DESVINCULAR</button></td>
                                                                         <?php } else { ?>       
                                                                                <td><span style="padding: 6%;color:#282828;font-weight:bold" class="badge badge-warning block">EN PROCESO</span></td>
                                                                                
                                                                                
                                                                         <?php }  ?>       
                                                                            
                                                                    <?php } ?>   
                                                                                                          
                                                            
                                                               </tr>
                                                                
                                                                <input type="hidden" name="trabajadores[]" id="trabajadores<?php echo $i ?>" value="<?php echo $row['idtrabajador'] ?>" />
                                                                <input type="hidden" name="cargos[]" id="cargos<?php echo $i ?>" value="<?php echo $row['cargos'] ?>" />
                                                                
                                                   <?php  $i++;$num++;} ?>
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
                             
                                
                         </div>
                      </div>
                   </div>
              </div>
        </div>
            
            
                    <script>
                    
                         function desvincular(rut,trabajador,contrato,mandante,tipo) {
                                      $('#modal_desvincular input[name=rut]').val(rut);
                                      $('#modal_desvincular input[name=trabajador]').val(trabajador);
                                      $('#modal_desvincular input[name=tipo]').val(tipo);
                                      $('#modal_desvincular input[name=contrato]').val(contrato);
                                      $('#modal_desvincular input[name=mandante]').val(mandante);
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
                                                <div class="row">                                                  
                                                  <div class="col-12">
                                                    <div style="display: inline-block;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span style="background:#282828; color: #fff;font-weight: bold;" class="btn btn-default btn-file"><span class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                                            <span  class="fileinput-exists">Cambiar</span>
                                                            <input class="form-control"   type="file" id="archivo_desvincular" name="archivo_desvincular" accept="application/pdf" />
                                                        </span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                    </div>
                                                  </div>   
                                                </div>
                                                                                               
                                               </div>                      
                                               <div class="modal-footer">
                                                        <button class="btn btn-secondary btn-md" title="Cerrar Ventana" class="close" data-dismiss="modal" aria-label="Close"  >Cancelar</button>
                                                        <button class="btn btn-success btn-md" type="button" onclick="cargar_desvincular()" >Enviar Desvinculacion</button>  
                                                        
                                               </div> 
                                              
                                               <input type="hidden" name="trabajador" id="trabajador_desvincular" />
                                               <input type="hidden" name="tipo" id="tipo_desvincular" />
                                               <input type="hidden" name="contrato" id="contrato_desvincular" /> 
                                               <input type="hidden" name="rut" id="rut_desvincular" />
                                               <input type="hidden" name="mandante" id="mandante_desvincular" />
                                              
                                            </form>
                                        </div>
                                   </div>
                                </div>
                             </div>
                           </div> 
                           
                           
                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Enviando desvinculaci&oacute;n, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div> 

                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Espere hasta que cierre esta ventana</h3> 
                                                <div class="progress"> 
                                                    <div id="myBar" class="progress-bar" style="width:0%;">
                                                        <span class="progress-bar-text">0%</span>
                                                    </div>
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
    
  
</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
