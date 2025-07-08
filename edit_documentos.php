<?php
session_start();
if (isset($_SESSION['usuario']) ) { 
$idtrabajador=$_SESSION['idtrabajador'];    
include('config/config.php');
//$regiones= consulta_general('regiones');
$regiones=mysqli_query($con,"Select * from regiones ");
$bancos=mysqli_query($con,"SELECT * from bancos");
$afps=mysqli_query($con,"SELECT * from afp");
$salud=mysqli_query($con,"SELECT * from salud");

$fcargos=mysqli_query($con,"SELECT * from cargos where estado=1");

$contratistas=mysqli_query($con,"SELECT id_contratista from contratistas where rut='".$_SESSION['usuario']."' ");
$fcontratista=mysqli_fetch_array($contratistas);

$contratos=mysqli_query($con,"SELECT * from contratos where estado=1 and contratista='".$fcontratista['id_contratista']."' ");

$asignados=mysqli_query($con,"SELECT contratos from trabajadores_asignados where id_trabajador='".$idtrabajador."' and estado=1");
$fasignados=mysqli_fetch_array($asignados);
$conasig=unserialize($fasignados['contratos']);

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

if (!empty($idtrabajador)) {
    $qconstancia=mysqli_query($con,"select * from constancia where idtrabajador='".$idtrabajador."' ");
    $fconstancia=mysqli_fetch_array($qconstancia);
    
    $qcarga=mysqli_query($con,"select * from carga where idtrabajador='".$idtrabajador."' ");
    $fcarga=mysqli_fetch_array($qcarga);
    
    $contcarga=mysqli_query($con,"select count(*) total from carga where idtrabajador='".$idtrabajador."' ");
    $totalcarga=mysqli_fetch_array($contcarga);
    
    $qtrabajador=mysqli_query($con,"select t.pcontrato1, t.pcontrato2, t.estado, t.idtrabajador, t.tpantalon, t.tpolera, t.tzapatos, t.banco as idbanco,t.afp as idafp, t.cargo as idcargo, t.region,t.comuna, t.rut, t.nombre1, t.nombre2, t.apellido1, t.apellido2, t.direccion1, t.direccion2, t.estadocivil, t.email, t.telefono, t.dia, t.mes, t.ano, t.tipocargo, t.licencia, t.tipolicencia, t.acreditacion, t.adia, t.ames, t.aano, t.observacion, t.cuenta, t.tipocuenta, r.Region, c.Comuna, a.cargo, b.banco, f.afp, s.institucion, s.idsalud  from trabajador t 
    LEFT JOIN regiones r ON r.IdRegion=t.region 
    LEFT JOIN comunas c ON c.IdComuna=t.comuna 
    LEFT JOIN cargos a ON a.idcargo=t.cargo 
    LEFT JOIN bancos b ON idbanco=t.banco
    LEFT JOIN afp f ON f.idafp=t.afp
    LEFT JOIN salud s ON s.idsalud=t.salud
    where t.idtrabajador=$idtrabajador and t.estado=1 and t.eliminar=0 ");
    $ftrabajador=mysqli_fetch_array($qtrabajador);
}

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Editar Documentos</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
    
    
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">
    

<script src="js\jquery-3.1.1.min.js"></script>
<script>


   
   function eliminar(carpeta) {
    
    swal({
        title: "Eliminar Documento",
        text: "Confirmar la solicitud",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Eliminar",
        closeOnConfirm: false
        }, function () {
            $.ajax({
    			method: "POST",
                url: "eliminar_fichero.php",
                data: 'archivo='+carpeta,
    			success: function(data){
                  //swal("Eliminado", "Documento ha sido eliminado", "success");   
                  window.location.href='edit_documentos.php'; 
    			}                
           });
            
        });
    
   } 

            function cargar_doc(doc,trabajador,id,contratista){
                  
               alert(doc);
               
                    
    }

    $(document).ready(function(){
                
           
				
                $("#region").change(function () {				
					$("#region option:selected").each(function () {
						IdRegion = $(this).val();
						$.post("comunas.php", { IdRegion: IdRegion }, function(data){
							$("#comuna").html(data);
						});            
					});
				})
                
                $("#contrato").change(function () {				
					$("#contrato option:selected").each(function () {
						id= $(this).val();
						$.post("cargos.php", { id: id }, function(data){
							$("#cargo").html(data);
						});            
					});
				})
                
                
                $("#doc").change(function () {
                    
					$("#doc option:selected").each(function () {
						doc = $(this).val();
                        if (doc=="0") {
                            $("#carga").prop('disabled', true);
                            $("#Subir").prop('disabled', true);
                        } else {
                            $("#carga").prop('disabled', false);
                            $("#Subir").prop('disabled', false);
                        }
						//$.post("comunas.php", { IdRegion: IdRegion }, function(data){
						//	$("#comuna").html(data);
						//});            
					});
				})
    });
    
 
  
 
function ShowSelected() {
var combo = document.getElementById("licencia");
var selected = combo.options[combo.selectedIndex].text;
  
  if (selected=='NO)') {
      $('#tipolicencia').prop('disabled',true);
  } else  {
      $('#tipolicencia').prop('disabled',false);
  }  
   
} 
 



</script>

<style>

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


</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
      <div style="background: #010829;color: #fff;" class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Crear Trabajador</h2>
                    <!--<ol style="background: #010829;" class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Forms</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Basic Form</strong>
                        </li>
                    </ol>-->
                </div>
                <div class="col-lg-2">

                </div>
        </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row" id="documentos">
                
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <!--<h5>All form elements <small>With custom checbox and radion elements.</small></h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                
                            </div>
                                <div class="form-wrap">
                                    <button type="button" class="btn-danger btn btn-md" name="borrar" id="borrar" onclick="eliminar(<?php echo $idtrabajador ?>,<?php echo $ftrabajador['rut'] ?>)">Desvincular</button>
                                    <button name="update" id="update" class="btn btn-info btn-md" type="submit" >Actualizar</button>
                                    <a style="" class="btn btn-success  btn-md" href="files/<?php echo $ftrabajador['rut'] ?>/bajar.php?rut=<?php echo $ftrabajador['rut'] ?>" >Descargar Archivos</a>
                                </div>-->
                             
                        </div>
                        <div class="ibox-content" >
                        
                        
                           <div class="col-lg-12">
                                <div class="tabs-container" >
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li><a class="nav-link active" data-toggle="tab" href="#tab-1"><h3>Documentaci&oacute;n</h3></h3> </a></li>
                                        <li><a class="nav-link " data-toggle="tab" href="#tab-2"><h3>Informaci&oacute;n del Trabajador</h3> </a></li>
                                       
                                    </ul>
                                    <div class="tab-content">
                                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                                           
                                           <div class="panel-body">
                                                   
                                                   <div class="panel panel-success">
                                                       <div class="panel-heading">
                                                            <h1 class="panel-title">Documentos Requeridos </h1>
                                                         </div>
                                                         <div class="panel-body">
                                                                <table class="table">
                                                                  <thead>
                                                                    <tr>
                                                                      
                                                                      <th width="20%">Documento</th>
                                                                      <th width="60%">Archivo</th>
                                                                      <th width="15%">Accion</th>
                                                                    </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                   
                                                                   <?php
                                                                    $i=0;
                                                                    $rut=$ftrabajador['rut'];
                                                                    $documentos=mysqli_query($con,"select * from doc where estado=1");
                                                                    foreach ($documentos as $row) {                                                                     
                                                                        $carpeta='doc/'.$fcontratista['id_contratista'].'/trabajadores/'.$rut.'/'.$row['documento'].'_'.$rut.'.pdf';
                                                                        $archivo_exitse=file_exists($carpeta);    
                                                                        
                                                                        $doc=$row['documento'];
                                                                      
                                                                                                                                        
                                                                        ?> 
                                                                       <tr>
                                                                          <?php if ($archivo_exitse) { ?> 
                                                                                
                                                                                <td><a style="" href="<?php echo $carpeta ?>" class="" title="Descargar Archivo" target="_blank" ><?php echo $row['documento'] ?>  </a>  </td>
                                                                           <?php } else { ?>  
                                                                                <td><?php echo $row['documento'] ?></td>
                                                                                    
                                                                           <?php } ?> 
                                                                          
                                                                          <td >
                                                                              <div style="background: #eeeeee;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                                                        <span class="fileinput-exists">Cambiar</span><input type="file" id="carga<?php echo $i ?>" name="carga[]" multiple="" accept="application/pdf" /></span>
                                                                                        <span class="fileinput-filename"></span>
                                                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                              </div>
                                                                              <button class="btn-success btn btn-sm " id="subir1" type="button" value="<?php echo $i ?>" onclick="cargar_doc('<?php echo $doc ?>',<?php echo $idtrabajador  ?>,<?php echo $i ?>,<?php echo $fcontratista['id_contratista']  ?>)"><i class="fa fa-upload" aria-hidden="true"></i> Procesar Documentos </button>&nbsp;
                                                                                
                                                                               
                                                                          </td>
                                                                          <td>
                                                                           <div class="form-group row">
                                                                                
                                                                                <?php if ($archivo_exitse) { ?>
                                                                                    <a style="color: #FFFFFF;" href="<?php echo $carpeta ?>" class="btn-success btn btn-md" title="Descargar Archivo" target="_blank" ><i class="fa fa-download" aria-hidden="true"></i>  </a>&nbsp;
                                                                                    <a style="color: #FFFFFF;" class="btn-danger btn btn-md" title="Eliminar Archivo" onclick="eliminar('<?php echo $carpeta ?>')" ><i class="fa fa-trash-o" aria-hidden="true"></i>  </a>&nbsp;
                                                                                <?php } else { ?>
                                                                                    <button type="button" class="btn-dark btn btn-md" title="Descargar Archivo" disabled=""><i class="fa fa-download" aria-hidden="true"></i>  </button>&nbsp;
                                                                                    <button type="button" class="btn-danger btn btn-md" title="Eliminar Archivo" disabled=""><i class="fa fa-trash-o" aria-hidden="true"></i>  </button>&nbsp;
                                                                                <?php } ?>    
                                                                            </div>
                                                                          </td>                                                                    
                                                                        <input type="hidden" id="trabajador" name="trabajador" value="<?php echo $idtrabajador ?>" />
                                                                        <input type="hidden" id="documento" value="<?php echo $doc ?>" />
                                                                        </tr>
                                                                   <?php $i++; } ?> 
                                                                 </tbody>
                                                               </table>
                                                                
                                                              
                                                        </div>
                                                     </div>    
                                                </div>                                           
                                        </div>
                                        
                                        <div role="tabpanel" id="tab-2" class="tab-pane">
                                                <div class="panel-body">
                                                <?php include('datos_trabajador.php') ?>
                                            </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Cargando Archivos, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                
                
            </div>
        </div>
        <div class="footer">
            <div class="float-right">
                Versi&oacute;n <strong>1.0</strong>.
            </div>
            <div>
                <strong>Copyright</strong> Proyecto Empresas &copy; <?php echo $year ?>
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

    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
     <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>

<script>

    $(document).ready(function (){

        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 2000 });

        // Bind progress buttons and simulate loading progress
        Ladda.bind( '.progress-demo .ladda-button',{
            callback: function( instance ){
                var progress = 0;
                var interval = setInterval( function(){
                    progress = Math.min( progress + Math.random() * 0.1, 1 );
                    instance.setProgress( progress );

                    if( progress === 1 ){
                        instance.stop();
                        clearInterval( interval );
                    }
                }, 200 );
            }
        });


        var l = $( '.ladda-button-demo' ).ladda();

        l.click(function(){
            // Start loading
            l.ladda( 'start' );

            // Timeout example
            // Do something in backend and then stop ladda
            setTimeout(function(){
                l.ladda('stop');
            },12000)


        });

    });

</script>    
    
    
</body>


</html><?php } else { 

echo '<script> window.location.href="index.php"; </script>';
}

?>
