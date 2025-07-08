<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3 ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$sql_contratistas=mysqli_query($con,"select c.* from contratistas as c where  c.rut='".$_SESSION['usuario']."' ");
$result_contratistas=mysqli_fetch_array($sql_contratistas);
$contratista=$_SESSION['contratista'];
?>
<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | Reporte Vehiculos</title>
     <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    
    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">

<style>

    .estilo {
        display: inline-block;
        content: "";
        width: 25px;
        height: 25px;
        margin: 0.5em 0.5em 0 0;
        background-size: cover;
    }
    .estilo:checked  {
        content: "";
        width: 25px;
        height: 25px;
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

$(document).ready(function () {
    
    $('#menu-vehiculos').attr('class','active');
})
 
 function editar(idtrabajador,editar) {
        $.ajax({
			method: "POST",
            url: "sesion/sesion_vehiculo.php",
			data:'id='+idtrabajador+'&editar='+editar,
			success: function(data){
			    
               window.location.href='edit_vehiculo.php';
			}
            
            
       });
    }

function eliminar(id,condicion){
           //alert(id+' '+condicion);
    
            swal({
            title: "Confirmar Eliminar Contrato",
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
                                title: "Contrato Eliminado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } else {
                         swal("Cancelado", "Contrato No Eliminado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
}


    
 $(document).ready(function() {

            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });

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
                                        setTimeout(window.location.href='list_contratos.php', 3000);
                                    } else {
                                        swal("Cancelado", "Accion Cancelada", "error");
                                        setTimeout(window.location.href='list_contratos.php', 3000);
                                    }
                    });
                            
                                
                });
                
                
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

</head>


  

<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
        <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Reporte Vehiculos <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                          
                        <div class="ibox-title">
                              <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background:#217346;border:1px #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_vehiculos.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Vehículos</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="crear_auto.php"  type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Crear Vehículo/Maquinaria</a>
                                        <a class="btn btn-sm btn-success btn-submenu"  href="list_contratos_contratistas.php"  type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>                                        
                                    </div>
                              </div>
                              <?php include('resumen.php') ?>
                        </div>
                        
                        
                        <div class="ibox-content">
                        
                        
                         <div class="row" >
                           <div class="col-lg-12"> 
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Vehiculo/Maquinaria">
                            <br>
                                <table style="width: 100%;" class="footable table table-responsive" data-page-size="25" data-filter="#filter">
                                       <thead class="cabecera_tabla">
                                        <tr style="font-size: 12px;">
                                            <th style="width: 3%;border-right:1px #fff solid"></th>
                                            <th style="width: 7%;text-align: center;border-right:1px #fff solid;" >Editar</th>                                                
                                            <th style="width: 7%;text-align: center;border-right:1px #fff solid;" >&nbsp;&nbsp;Docs&nbsp;&nbsp;</th>
                                            <th style="width: 7%;text-align: center;border-right:1px #fff solid;font-size:10px" >Bajar</th>
                                            <th style="width: 10%;border-right:1px #fff solid" >Tipo</th>
                                            <th style="width: 15%;border-right:1px #fff solid" >Propietario</th>
                                            <th style="width: 10%;border-right:1px #fff solid" >Patente</th>                                            
                                            <th style="width: 10%;border-right:1px #fff solid" >Siglas</th>
                                            <th style="width: 10%;border-right:1px #fff solid" >Marca</th>
                                            <th style="width: 15%;border-right:1px #fff solid" >Modelo</th>

                                            <th data-hide="all">Revision</th>           
                                            <th data-hide="all">Chasis</th>
                                            <th data-hide="all">Motor</th>
                                            <th data-hide="all">Año</th>
                                            <th data-hide="all">Color</th>
                                            <th data-hide="all">Puestos</th>     
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            
                                          $query_vehiculos=mysqli_query($con,"select * from autos where contratista='".$result_contratistas['id_contratista']."' ");
                                          
                                          foreach ($query_vehiculos as $row) { 
                                            
                                            if ($row['color']=="seleccionar") {
                                                $color="N/A";
                                            } else {
                                                $color=$row['color'];
                                             } 
                                             $siglas=$row['siglas'].'-'.$row['control'];
                                             ?>
                                            
                                            <tr>
                                                <td data-toggle="true"></td>

                                                <?php if ($row['estado']==0) { ?>                                            
                                                        <!-- acciones si estado de trabajaro es 0  -->
                                                        <td style="background: ;text-align: center;"><button title="Editar Vehiculo" class="btn btn-xs btn-success btn-block" name="editar" id="editar" onclick="editar('<?php echo $row['id_auto']?>',1)" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td> 
                                                        <td style="background: ;text-align: center;"><button title="Documentos del Vehículo" class="btn btn-xs btn-primary btn-block" name="editar" id="editar" onclick="editar('<?php echo $row['id_auto']?>',2)" ><i class="fa fa-archive" aria-hidden="true"></i></button></td>                                           
                                            
                                                <?php } else { ?>                                                
                                                        <!-- acciones  -->
                                                        <td style="background: ;text-align: center;"><button title="Editar Vehículo" class="btn btn-xs btn-default btn-block" name="editar" id="editar" disabled="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td> 
                                                        <td style="background: ;text-align: center;"><button title="Documentos Vehículo" class="btn btn-xs btn-default btn-block" name="editar" id="editar" disabled="" ><i class="fa fa-archive" aria-hidden="true"></i></button></td>
                                                        <!--<td style="background: ;text-align: center;"><button title="Desvincular" class="btn btn-xs btn-danger btn-block" name="desvincular" id="desvincular" onclick="desvincular('<?php echo $row['idtrabajador']?>',1)" ><i class="fa fa-sign-out" aria-hidden="true"></i> </button></td>-->
                                                <?php }                                                  
                                               
                                                $carpeta='doc/vehiculos/'.$row['contratista'].'/'.$siglas.'/';
                                                if (file_exists($carpeta)) { ?>
                                                    <td style="text-align: center;"><button style="background:#282828;border:1px #282828 solid;color:#fff;" title="Descargar Documentos" class="btn btn-xs btn-default btn-block" name="Descargar" id="Descargar" onclick="descargar('<?php echo $siglas ?>',<?php echo $contratista ?>)" ><i class="fa fa-download" aria-hidden="true"></i></button></td>    
                                                <?php
                                                } else { ?>
                                                    <td style="text-align: center;"><button style="background:#282828;border:1px #282828 solid;color:#fff;" title="Descargar Documentos" class="btn btn-xs btn-default btn-block" name="Descargar" id="Descargar" disabled ><i class="fa fa-download" aria-hidden="true"></i></button></td>    
                                                <?php 
                                                }
                                                
                                                ?> 


                                                

                                                <td><?php echo $row['tipo'] ?></td>
                                                <td><?php echo $row['propietario'] ?></td>
                                                <td><?php echo $row['patente'] ?></td>
                                                <td><?php echo $row['siglas'].'-'.$row['control'] ?></td>
                                                <td><?php echo $row['marca'] ?></td>
                                                <td><?php echo $row['modelo'] ?></td>


                                                <td ><?php echo $row['revision'] ?></td>            
                                                <td><?php echo $row['chasis'] ?></td>
                                                <td><?php echo $row['motor'] ?></td>
                                                <td><?php echo $row['year'] ?></td>     
                                                <td><?php echo $color ?></td>
                                                <td><?php echo $row['puestos'] ?></td>                                                                                                
                                          </tr>
                                                                                
                                            
                                            
                                        <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="10">
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

function descargar (siglas,contratista) {
    $.ajax({
        method: "POST",
        url: "add/descargar_vehiculo.php",
        data: 'siglas='+siglas,
        success: function(data){			  
            if (data==0) {
                var url='doc/vehiculos/'+contratista+'/'+siglas+'/zip/documentos_vehiculo_'+contratista+'_'+siglas+'.zip';    
                window.open(url, 'Download');
        	} else {
                swal("Disculpe", "Error de Sistema. Vuelva a Intentar.", "error");
        	}
        }                
    });
}
</script>

</body>
</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
