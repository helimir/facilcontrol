<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');

$mandante=$_SESSION['mandante'];
if ($_SESSION['mandante']==0) {
   $razon_social="INACTIVO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$sms=$_GET['sms'];

$contratistas=mysqli_query($con,"SELECT id_contratista from contratistas where rut='".$_SESSION['usuario']."' ");
$fcontratista=mysqli_fetch_array($contratistas);

$sql_contratos=mysqli_query($con,"select * from contratos where contratista='".$fcontratista['id_contratista']."' ");

    $qtrabajador="select t.* , r.Region, c.Comuna, b.banco, f.afp, s.institucion, o.razon_social 
    from trabajador t 
    LEFT JOIN regiones r ON r.IdRegion=t.region 
    LEFT JOIN comunas c ON c.IdComuna=t.comuna
    LEFT JOIN bancos b ON b.idbanco=t.banco
    LEFT JOIN afp f ON f.idafp=t.afp
    LEFT JOIN salud s ON s.idsalud=t.salud 
    LEFT JOIN contratistas o On o.id_contratista=t.contratista
    LEFT JOIN mandantes m On m.id_mandante=o.mandante
    where o.mandante='".$_SESSION['mandante']."' and t.estado=0  order by t.idtrabajador";
    $ftrabajador=mysqli_query($con,$qtrabajador);
    

  

?>

<!DOCTYPE html>
<html>
<html translate="no">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Reporte Trabajadores</title> 
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
    
    <style>

.cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }


    </style>
 
</head>


    
  

<script>

$(document).ready(function() {
    $('#menu-trabajadores').attr('class','active');

});

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
    
   function cargar_desvincular(){ 
               
               var rut=$('#rut_desvincular').val();
               var trabajador=$('#trabajador_desvincular').val();
               var tipo=$('#tipo_desvincular').val();
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
                                        if (tipo==1) {
                        	                 window.location.href='list_trabajadores.php';
                                        } else {
                                            window.location.href='trabajadores_asignados_contratista.php';
                                         }
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
    
 
   

</script>


<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
             <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Reporte Trabajadores <?php #echo $_SESSION['usuario']  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                       <div class="ibox-title">
                             
                              <div class="row"> 
                                    <div class="col-12 col-sm-offset-2">
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-sm btn-success" href="trabajadores_acreditados_mandantes.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Trabajadores Acreditados</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-sm btn-success" href="list_contratos.php"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                    </div>
                             </div>
                             <?php include('resumen.php') ?>
               
                        </div>
                        
                        
                        
                        <div class="ibox-content">

                            <div class="row"> 
                                <div class="col-4 col-sm-offset-2">
                                    <a style="background:#217346;border:1px #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_trabajadores_mandante.php"> <strong><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Trabajadores</strong></a>
                                </div>                           
                            </div>
                            <br>
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un trabajador">
                            <br>
                          <div class="table-responsive">  
                            <table style="width: 100%;" class="footable table" data-page-size="25" data-filter="#filter">
                               <thead class="cabecera_tabla">
                                <tr style="font-size: 12px;">
                                    <th style="width: 3%;border-right:1px #fff solid"><i style="font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></th>
                                    <th style="width: 15%;border-right:1px #fff solid" >Nombres</th>
                                    <th style="width: 15%;border-right:1px #fff solid" >Apellidos</th>
                                    <th  data-hide="phone,table" style="width: 10%;border-right:1px #fff solid" >RUT</th>
                                    <th data-hide="phone,table" style="width: 10%;border-right:1px #fff solid" >Telefono</th>
                                    <th data-hide="phone,table" style="width: 15%;" >Contratista</th>
                                    
                                    
                                    <th data-hide="all">Turno</th>
                                    <th data-hide="all">Email</th>
                                    <th data-hide="all" >Fecha Nac</th>
                                    <th data-hide="all">Estado Civil</th>                                    
                                    <th data-hide="all">Cargo</th>
                                    <th data-hide="all">Licencia</th>
                                    <th data-hide="all" >Direccion</th>
                                    <th data-hide="all" >Regi&oacute;n</th>
                                    <th data-hide="all" >Comuna</th>
                                    <th data-hide="all" >Banco</th>
                                    <th data-hide="all" >Cuenta</th>
                                    <th data-hide="all" >Tipo</th>
                                    <th data-hide="all" >AFP</th>
                                    <th data-hide="all" >Salud</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php // echo '<td data-toggle="true"></td>';
                                  $condicion="trabajadores";
                                  foreach ($ftrabajador as $row){  
                                    
                                    switch ($row['mes']) {
                                    case 1: $mes="Enero";break;
                                    case 2: $mes="Febrero";break;
                                    case 3: $mes="Marzo";break;
                                    case 4: $mes="Abril";break;
                                    case 5: $mes="Mayo";break;
                                    case 6: $mes="Junio";break;
                                    case 7: $mes="Julio";break;
                                    case 8: $mes="Agosto";break;
                                    case 9: $mes="Septiembre";break;
                                    case 10: $mes="Octubre";break;
                                    case 11: $mes="Noviembre";break;
                                    case 12: $mes="Diciembre";break;  
                                    }
                                    
                                    $query_desvilcular=mysqli_query($con,"select * from desvinculaciones where trabajador='".$row['idtrabajador']."' and verificado=0 and tipo=1 ");
                                    $result_desvincular=mysqli_fetch_array($query_desvilcular);
                                    
                                
                                ?> 
                                <tr>
                                     
                                     <!-- toggle-->   
                                        <td></td>
                                  
                                        <!-- nombres  -->
                                        <td><?php echo $row['nombre1']." ".$row['nombre2'] ?></td>
                                        
                                        <!-- apellidos -->
                                        <td><?php echo $row['apellido1']." ".$row['apellido2']  ?></td>
                                        
                                        <!-- rut  -->
                                        <td><?php echo $row['rut'] ?></td>
                                        
                                        <!-- fono  -->
                                        <td><?php echo $row['telefono'] ?></td>
                                        
                                        <!-- contratista  -->
                                        <td><?php echo $row['razon_social'] ?></td>
                                    
                                    
                                    <td><?php echo $row['turno'] ?></td>
                                    <td><?php echo $row['email'] ?></td>
                                    <td><?php echo $row['dia']." ".$mes." ".$row['ano'] ?></td>
                                    <td><?php echo $row['estadocivil'] ?></td>
                                    <td><?php echo  utf8_encode($row['cargo'])." - Tipo: ".$row['tipocargo'] ?></td>
                                    <?php if ($row['licencia']=="NO") {  ?>
                                        <td><?php echo $row['licencia'] ?></td>
                                    <?php } else {  ?>    
                                         <td><?php echo $row['tipolicencia'] ?></td>
                                    <?php }  ?>
                                    
                                    <td><?php echo $row['direccion1']." ".$row['direccion2'] ?></td>                                    
                                    <td><?php echo utf8_encode($row['Region']) ?></td>
                                    <td><?php echo utf8_encode($row['Comuna']) ?></td>                                   
                                    <td><?php echo utf8_encode($row['banco']) ?></td>
                                    <td><?php echo utf8_encode($row['cuenta']) ?></td>
                                    <td><?php echo utf8_encode($row['tipocuenta']) ?></td>
                                    <td><?php echo utf8_encode($row['afp']) ?></td>
                                    <td><?php echo utf8_encode($row['institucion']) ?></td>
                                    
                                    
                                                                        
                                </tr>
                               <?php } ?>
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
                            <script>
                                 function desvincular(rut,trabajador,tipo) {                                      
                                      $('#modal_desvincular input[name=rut]').val(rut);
                                      $('#modal_desvincular input[name=trabajador]').val(trabajador);
                                      $('#modal_desvincular input[name=tipo]').val(tipo);
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
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Desvincular Trabajador de la Contratista  </h3>
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
                                               <input type="hidden" name="rut" id="rut_desvincular" />
                                              
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
    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
     <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

   
    
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
         
           


function refresh(){
    window.location.href='list_trabajadores.php';
}

function eliminar(id){
           //alert(id+' '+condicion);
     var condicion='trabajadores';  
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

echo "<script> window.location.href='admin.php'; </script>";
}

?>
