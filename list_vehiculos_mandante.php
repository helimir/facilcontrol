<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2 ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');
$mandante=$_SESSION['mandante'];
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

.cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }

        
</style>


<script> 

 
 function gestionar_veh(vehiculo,cargos,contrato,perfiles,contratista) {
    //alert(vehiculo+' '+cargos+' '+contrato+' '+perfiles+' '+contratista)
    $.ajax({
        method: "POST",
        url: "sesion/gestionar_vehiculos.php",
        data: 'vehiculo='+vehiculo+'&cargo='+cargos+'&contrato='+contrato+'&perfil='+perfiles+'&contratista='+contratista,
        success: function(data){			              
            window.location.href='verificar_documentos_vehiculos_mandante.php';        	
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
            $('#menu-vehiculos').attr('class','active');

            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });

            $('.footable').footable();
            $('.footable2').footable();
                                
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
                                        <a style="background:#217346;border:1px #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_vehiculos_mandantes.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Vehículos</a>
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
                                            <th style="width: 7%;text-align: center;border-right:1px #fff solid;font-size:10px" >Acción</th>
                                            <th style="width: 15%;text-align: center;border-right:1px #fff solid;font-size:10px" >Contratista</th>
                                            <th style="width: 15%;text-align: center;border-right:1px #fff solid;font-size:10px" >Contrato</th>
                                            <th style="width: 15%;border-right:1px #fff solid" >Propietario</th>
                                            <th style="width: 10%;border-right:1px #fff solid" >Tipo</th>                                            
                                            <th style="width: 10%;border-right:1px #fff solid" >Patente</th>                                            
                                            <th style="width: 10%;border-right:1px #fff solid" >Credencial</th>
                                            <th style="width: 10%;border-right:1px #fff solid" >Estado</th>


                                            <th data-hide="all">Codigo</th>    
                                            <th data-hide="all" >Siglas</th>
                                            <th data-hide="all">Marca</th>
                                            <th data-hide="all">Modelo</th>
                                            <th data-hide="all">Revision</th>           
                                            <th data-hide="all">Chasis</th>
                                            <th data-hide="all">Motor</th>
                                            <th data-hide="all">Año</th>
                                            <th data-hide="all">Color</th>
                                            <th data-hide="all">Puestos</th>     
                                            <th data-hide="all">Inf. Propietario</th>
                                            <th data-hide="all">RUT</th>
                                            <th data-hide="all">Fono</th>
                                            <th data-hide="all">Email</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            
                                            $query_vehiculos=mysqli_query($con,"select e.cargos, e.contrato as contrato_asignado,e.perfiles,e.contratista, c.razon_social,n.nombre_contrato, e.verificados, e.contrato as idcontrato,r.codigo,  a.* from autos as a Left Join contratistas as c On c.id_contratista=a.contratista Left Join mandantes as m On m.id_mandante=c.mandante Left Join vehiculos_asignados as e On e.vehiculos=a.id_auto Left Join vehiculos_acreditados as r On r.vehiculo=a.id_auto Left Join contratos as n On n.id_contrato=e.contrato  where c.mandante='".$_SESSION['mandante']."' and e.vehiculos=a.id_auto ");
                                            $existe_vehiculos=mysqli_num_rows($query_vehiculos);

                                            if ($existe_vehiculos==0) { ?>
                                                <tr>                                                    
                                                    <td colspan="9">Sin vehículos/maquinarias asignadas a un contratos</td>    
                                                </tr>
                                            <?php
                                            } else {
                                                foreach ($query_vehiculos as $row) { 
                                                
                                                    if ($row['color']=="seleccionar") {
                                                        $color="N/A";
                                                    } else {
                                                        $color=$row['color'];
                                                    } 
                                                    
                                                    switch ($row['verificados']) {
                                                        case '0':$estado="NO RECIBIDO";$clase="bg-danger block text-center pt-1 pb-1"; break;
                                                        case '1':$estado="VALIDADO";$clase="bg-success block text-center pt-1 pb-1"; break;
                                                        case '2':$estado="EN PROCESO";$clase="bg-info block text-center pt-1 pb-1"; break;
                                                    }

                                                    if ($row['codigo']=="") {
                                                        $codigo="NO VALIDADO";
                                                    } else {
                                                        $codigo=$row['codigo'];
                                                    }
                                                    
                                                    ?>
                                                    
                                                    <tr>
                                                        <td data-toggle="true"></td>

                                                    
                                                        <?php                                                        
                                                        # estado diferente a no iniciado
                                                        if ($row['verificados']==0 or $row['verificados']==1 ) { ?>
                                                                <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-secondary btn-xs" type="button" disabeld ><small>GESTIONAR</small></button></td>
                                                        <?php
                                                        } else { ?>
                                                                <td style="background:;text-align: center;" ><button style="width:100%; " title="Documentos" class="btn btn-success btn-xs" type="button" onclick="gestionar_veh(<?php echo $row['id_auto'] ?>,<?php echo $row['cargos'] ?>,<?php echo $row['contrato_asignado'] ?>,<?php echo $row['perfiles'] ?>,<?php echo $row['contratista'] ?>)"  ><small>GESTIONAR</small></button></td>
                                                            <?php
                                                        } ?> 
                                                        <td><?php echo $row['razon_social'] ?></td>     
                                                        <td><?php echo $row['nombre_contrato'] ?></td>
                                                        <td><?php echo $row['propietario'] ?></td>
                                                        <td><?php echo $row['tipo'] ?></td>                                                
                                                        <td><?php echo $row['patente'] ?></td>
                                                        <td>
                                                            <?php if ($codigo=="NO VALIDADO") {  ?>
                                                                No validado
                                                            <?php } else { ?>
                                                                <a style="margin-left: 2%;text-decoration:underline" class="" href="credencial_vehiculo.php?codigo=<?php echo $row['codigo'] ?>" target="_blank"><b>Descargar</b></a>
                                                            <?php }  ?>
                                                        </td>
                                                        <td><span style="font-weight:bold" class="<?php echo $clase ?>"><?php echo $estado ?></span></td>
                                                        
                                                        
                                                        <td><?php echo $codigo ?></td>
                                                        <td><?php echo $row['siglas'].'-'.$row['control'] ?></td>
                                                        <td><?php echo $row['marca'] ?></td>
                                                        <td><?php echo $row['modelo'] ?></td>
                                                        <td ><?php echo $row['revision'] ?></td>            
                                                        <td><?php echo $row['chasis'] ?></td>
                                                        <td><?php echo $row['motor'] ?></td>
                                                        <td><?php echo $row['year'] ?></td>     
                                                        <td><?php echo $color ?></td>
                                                        <td><?php echo $row['puestos'] ?></td>                                        
                                                        <td>----------------------------</td>                                                                                              
                                                        <td><?php echo $row['rut_propietario'] ?></td>
                                                        <td><?php echo $row['fono_propietario'] ?></td>
                                                        <td><?php echo $row['email_propietario'] ?></td>
                                                </tr>
                                                                                
                                            
                                            
                                        <?php }
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
                            
                            <script>
                                 
                                 
                                 function modal_cargos(contrato,cargos) {
                                      // alert(id+'-'+cargos)
                                      $('.body').load('selid_perfil.php?contrato='+contrato+'&cargos='+cargos,function(){
                                          $('#modal_cargos').modal({show:true});
                                          //$('#modal_cargos input[name=id]').val(id);
                                       });
                                  }
                                  
                                   function modal_reporte_trabajadores(contrato) {
                                      $('.body').load('selid_reporte_trabajadores.php?contrato='+contrato,function(){
                                                $('#modal_reporte_trabajadores').modal({show:true});
                                           });
                                    }
                                    
                                  function modal_mensual(contratista,mandante,condicion,contrato,nom_contratista,nom_contrato) {
                                        //alert(nom_contratista);
                                            $('#modal_doc_mensual input[name=contratista_dm]').val(contratista);
                                            $('#modal_doc_mensual input[name=mandante_dm]').val(mandante);
                                            $('#modal_doc_mensual input[name=condicion_dm]').val(condicion);
                                            $('#modal_doc_mensual input[name=contrato_dm]').val(contrato);
                                            $('#modal_doc_mensual input[name=nom_contratista]').val(nom_contratista);
                                            $('#modal_doc_mensual input[name=nom_contrato]').val(nom_contrato);
                                            $('#modal_doc_mensual').modal({show:true});
                                            
                                    }  
                                    
                            </script>
                            
                                            <div class="modal fade" id="modal_doc_mensual" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-md">
                                                    <div class="modal-content">
                                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documentos Mensuales</h3>
                                                    <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" ><span aria-hidden="true">x</span></button>
                                                    </div>
                                                    <div class="body">
                                                    <style>
                                                            .estilo2 {
                                                                    display: inline-block;
                                                                    content: "";
                                                                    width: 12px;
                                                                    height: 12px;
                                                                    margin: 0.5em 0.5em 0 0;
                                                                    background-size: cover;
                                                                }
                                                                .estilo2:checked  {
                                                                    content: "";
                                                                    width: 12px;
                                                                    height: 12px;
                                                                    margin: 0.5em 0.5em 0 0;
                                                                }
                                                        </style>
                                                        

                                                            <form  method="post" id="frmMensualDoc">    
                                                            <div class="modal-body">

                                                                <div class="row form-group">
                                                                    <label  class="col-4 col-form-label"><b><i class="fa fa-chevron-right" aria-hidden="true"></i>Contratista:</b></label>
                                                                    <input  class="col-8 col-form-control" type="text" id="nom_contratista" name="nom_contratista"  >
                                                                </div>
                                                                <div class="row form-group">
                                                                    <label  class="col-4 col-form-label"><b><i class="fa fa-chevron-right" aria-hidden="true"></i>Contrato:</b></label>
                                                                    <input  class="col-8 col-form-control" type="text" id="nom_contrato" name="nom_contrato"  >
                                                                </div>
                                                            
                                                                <div class="row" style="" >
                                                                    <div class="col-12">
                                                                        <table style="overflow-y: auto;" class="table table-stripped">
                                                                            <thead style="background:#010829;color:#fff">
                                                                                <tr>
                                                                                    <th style="width: ;border-right:1px #fff solid">Documento</th>
                                                                                    <th class="text-rigth" style="width: ;text-align:center">Seleccionar</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody> 
                                                                                <?php $i=0; 
                                                                                    $query=mysqli_query($con,"select * from doc_mensuales "); 
                                                                                    foreach ($query as $row) { ?>
                                                                                    <tr>
                                                                                        
                                                                                        <td><label class="col-form-label"><?php echo $row['documento'] ?></label></td>
                                                                                        <td style="text-align:center"><input class="estilo2" id="doc_mensuales_dm<?php echo $i ?>" name="doc_mensuales_dm[]" type="checkbox" value="<?php echo $row['id_dm'] ?>" /></td>
                                                                                    </tr>
                                                                                <?php $i++; } ?>
                                                                            </tbody>
                                                                        </table>
                                                                        
                                                                        <div class="row">
                                                                            <div class="col-lg-12 col-md-12 col-sm-12 ">  
                                                                                <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" >Documentos faltantes enviar a <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span> </label>
                                                                            </div>
                                                                        </div>   
                                                                        
                                                                    </div>   
                                                                </div>                                                  
                                                            </div>
                                                            
                                                                                                    
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary btn-sm" title="Cerrar Ventana" data-dismiss="modal"  >Cancelar </button>
                                                                <button class="btn btn-success btn-sm" type="button" onclick="crear_doc_mensual(<?php echo $i ?>)" >Solicitar</button>  
                                                            </div> 
                                                            
                                                            <input type="hidden" id="contratista_dm" name="contratista_dm"  />
                                                            <input type="hidden" id="mandante_dm" name="mandante_dm" />
                                                            <input type="hidden" id="condicion_dm" name="condicion_dm" />
                                                            <input type="hidden" id="contrato_dm" name="contrato_dm"  />
                                                                
                                                            </form>
                                                </div>
                                                </div>
                                            </div>
                                        </div>  

                            
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

function descargar (patente,contratista) {
    $.ajax({
        method: "POST",
        url: "add/descargar_vehiculo.php",
        data: 'patente='+patente,
        success: function(data){			  
            if (data==0) {
                var url='doc/vehiculos/'+contratista+'/'+patente+'/zip/documentos_vehiculo_'+contratista+'_'+patente+'.zip';    
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
