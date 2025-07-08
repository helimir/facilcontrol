<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();
if (isset($_SESSION['usuario'])) { 
include('config/config.php');
$contrato_des=isset($_SESSION['contrato_des']) ? $_SESSION['contrato_des']: '';
$contratista=isset($_SESSION['contratista']) ? $_SESSION['contratista']: '';
$contratos=mysqli_query($con,"select * from contratos where contratista='$contratista' ");
setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

    if  ($contrato_des=="" or $contrato_des==0) {
        $acreditados=mysqli_query($con,"select a.mandante as mandante_ta, m.razon_social as nombre_mandante, g.cargo as cargo_t, a.estado as estado_ta, a.*, t.*, c.razon_social, o.id_contrato, o.nombre_contrato from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato Left Join cargos as g On g.idcargo=a.cargo Left Join mandantes as m On m.id_mandante=a.mandante where a.contratista='".$contratista."' and t.estado=0 ");
    } else {
        $acreditados=mysqli_query($con,"select a.mandante as mandante_ta, m.razon_social as nombre_mandante, g.cargo as cargo_t, a.estado as estado_ta, a.*, t.*, c.razon_social, o.id_contrato, o.nombre_contrato from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato Left Join cargos as g On g.idcargo=a.cargo Left Join mandantes as m On m.id_mandante=a.mandante  where a.contratista='".$contratista."' and t.estado=0 and contrato='".$contrato_des."' ");
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

    <title>FacilControl | Trabajadores Acreditados</title> 
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
    
     <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">

    <script src="js\jquery-3.1.1.min.js"></script>

<script>

    function selcontrato(contrato){
      
        $.post("sesion/contrato_acreditados.php", { contrato: contrato }, function(data){
            window.location.href='trabajadores_acreditados.php';
        }); 
   }

   function selfiltro(opcion){
        var contratista =$('#contratista_m').val();
        //alert(contratista);
        $.post("sesion/filtro_acreditados.php", { filtro: filtro }, function(data){
            window.location.href='trabajadores_acreditados.php';
        }); 
   }

    function selcontratista(contratista){
        //alert(id);
        if (contratista==0) { 
            $.post("sesion/contratistas_acreditados_m.php", { contratista: contratista }, function(data){
                window.location.href='trabajadores_acreditados.php';
            }); 
        }    
    }
   
  function cargar_desvincular(){ 
               var tipo=$('input[name="tipo_desvincular"]:checked').val();
               var rut=$('#rut_desvincular').val();
               var trabajador=$('#trabajador_desvincular').val();
               var contrato=$('#contrato_desvincular').val();
               var mandante=$('#madante_desvincular').val();
               if (tipo!=1 && tipo!=2) {
                    swal("Seleccionar Tipo Desvinculacion","debe seleccionar una opcion","warning");
               } else {
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
                            //alert(mandante); 
                            var formData = new FormData();
                            var files= $('#archivo_desvincular')[0].files[0];
                                               
                            formData.append('archivo_desvincular',files);
                            formData.append('rut',rut);                   
                            formData.append('trabajador',trabajador);
                            formData.append('tipo', tipo);
                            formData.append('contrato', contrato);
                            formData.append('mandante', mandante);
                            $.ajax({
                                    url: 'cargar/cargar_desvincular.php',
                                    type: 'post',
                                    data:formData,
                                    contentType: false,
                                    processData: false,
                                    beforeSend: function(){
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
                            	            window.location.href='trabajadores_acreditados.php';
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
                                                window.location.href='trabajadores_acreditados.php';
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

            $('#menu-trabajadores').attr('class','active');
            $('.footable').footable();
            $('.footable2').footable();
            
            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });
            
            
            $("#contratista_m").change(function () {				
					$("#contratista_m option:selected").each(function () {
						idcontratista = $(this).val();
                        //alert(idcontratista);
						$.post("sel_contratistas_ta.php", { idcontratista: idcontratista }, function(data){
							$("#contrato_m").html(data);
						});            
					});
				})
                       


});
</script>

<style>

.checkboxtexto {
          /* Checkbox texto */
          font-size: 100%;
          display: inline;
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

</head>


<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
             <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Trabajadores Acreditados <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                            <div class="ibox-title">
                                <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                      <a style="background:#217346;border:1px #217346 solid;color:#fff" class="btn btn-sm" href="excel/excel_acreditados_t.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Descargar Acreditados</a>
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
                                           
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;color:#282828"  class="col-2 col-form-label"><b> Contratos</b></label>
                                           
                                                <div class="col-sm-6">    
                                                    <select name="contrato" id="contrato" class="form-control" onchange="selcontrato(this.value)">
                                                            <?php
                                                            if ($contrato_des==0 or $contrato_des=="") {
                                                                echo '<option value="0" selected="" >Todas los contratos</option>';
                                                                
                                                                //while($rowC = mysqli_fetch_assoc($contratos)) {
                                                                foreach ($contratos as $rowC) {     
                                                                    echo	'<option value="'.$rowC['id_contrato'].'">'.$rowC['nombre_contrato'].'</option>';
                                                                }
                                                            
                                                            } else {
                                                                $query=mysqli_query($con,"select * from contratos where id_contrato='".$contrato_des."' ");
                                                                $result=mysqli_fetch_array($query);
                                                                if (isset($result['id_contrato'])) {$id_contrato=$result['id_contrato'];}
                                                                if (isset($result['nombre_contrato'])) {$nombre_contrato=$result['nombre_contrato'];}
                                                                echo '<option value="'.$id_contrato.'" >'.$nombre_contrato.'</option>';
                                                                echo '<option value="0" >Todas los contratos</option>';                                                    
                                                                foreach ($contratos as $rowC) {    
                                                                echo	'<option value="'.$rowC['id_contrato'].'">'.$rowC['nombre_contrato'].'</option>';
                                                                }
                                                            }                                   
                                                        ?>
                                                    </select>
                                                </div>
                                        </div> 
                        
                        
                                        <div style="margin-top:2%" class="row">
                                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un trabajador" />
                                            <br>
                                            <div class="table-responsive">  
                                                <table style="" class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                                                <thead class="cabecera_tabla">
                                                    <tr>
                                                        <th style="width: 3%;border-right:1px #fff solid;"><i style="font-size: ;" class="fa fa-search-plus" aria-hidden="true"></i></th>
                                                        <th style="width: 10%;border-right:1px #fff solid;">Trabajador</th>
                                                        <th style="width: 8%;border-right:1px #fff solid;">RUT </th>
                                                        <th style="width: 12%;border-right:1px #fff solid;">Mandante</th>
                                                        <th style="width: 15%;border-right:1px #fff solid;">Contrato</th>
                                                        <th style="width: 8%;border-right:1px #fff solid;" >Credencial</th>
                                                        <th style="width: 8%;border-right:1px #fff solid;" >Documentos</th>
                                                        <th style="width: 5%;border-right:1px #fff solid;">Acci&oacute;n</th>

                                                        <th data-hide="all">Cargo</th>
                                                        <th data-hide="all">Codigo</th>
                                                        <th data-hide="all" >Vence</th>                                         
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                                <?php 
                                                                $i=1;
                                                                foreach ($acreditados as $row){  
                                                                
                                                                
                                                                
                                                                $documentos='doc/validados/'.$row['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/zip/documentos_validados_trabajador_'.$row['rut'].'.zip'; 
                                                                ?> 
                                                                    <tr>
                                                                    <td data-toggle="true"></td>
                                                                        <td><?php echo $row['nombre1'].' '.$row['apellido1'] ?></td>
                                                                        <td><?php echo $row['rut'] ?></td>
                                                                        <td><?php echo $row['nombre_mandante'] ?></td>
                                                                        <td><?php echo $row['nombre_contrato'] ?></td>
                                                                        <?php if ($row['url_foto']!="") { 
                                                                                    if ($row['estado_ta']==0 or $row['estado_ta']==1) {    ?>
                                                                                            <td><a style="text-decoration:underline"  href="credencial.php?codigo=<?php echo $row['codigo'] ?>" target="_blank"> Descargar</a></td>
                                                                        <?php       } else { ?>
                                                                                            <td>Desvinculado</td>
                                                                        <?php       }
                                                                            } else { ?>
                                                                            <td style="color: #FF0000;font-weight: bold;">Sin Foto</td>
                                                                            <!--<td><a class="" type="button" href="credencial.php?id=<?php echo $row['idtrabajador'] ?>&contratista=<?php echo $row['contratista'] ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> Descargar Credencial</a></td>-->
                                                                        <?php } ?>
                                                                        <td><a style="text-decoration:underline" href="<?php echo $documentos ?>" >Documentos</a></td>
                                                                        <td>
                                                                        <?php if ($row['estado_ta']==0) { ?> 
                                                                                <button title="Desvincular" class="btn btn-danger btn-xs btn-block" name="desvincular" id="desvincular" onclick="modal_desvincular('<?php echo $row['idtrabajador'] ?>','<?php echo $row['contrato'] ?>','<?php echo $row['mandante_ta'] ?>')" >Desvincular</button>
                                                                        <?php } else { 
                                                                                    if ($row['estado_ta']==1) {  ?>
                                                                                        <label style="padding: 9%; color:#fff;font-size:10px" class="label label-warning block text-dark">En Proceso</label>    
                                                                        <?php       } else { ?> 
                                                                                        <label style="padding: 9%; color:#fff;font-size:10px" class="label label-primary block">Desvinculado</label>
                                                                        <?php       }
                                                                            }     ?>         
                                                                        </td>

                                                                        <td><?php echo $row['cargo_t']  ?></td>
                                                                        <td><?php echo $row['codigo']  ?></td>
                                                                        <td><?php echo $row['validez']  ?></td>
                                                                    </tr>
                                                            <?php $i++; } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="8">
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

                
                                <script>
                                            
                                            function desvincular(rut,trabajador,contrato) {                                      
                                                $('#modal_desvincular input[name=rut]').val(rut);
                                                $('#modal_desvincular input[name=trabajador]').val(trabajador);
                                                $('#modal_desvincular input[name=contrato]').val(contrato);
                                                $('#modal_desvincular').modal({show:true});
                                            }   

                                        function modal_desvincular(id,contrato,mandante) {
                                            // alert(mandante);
                                            $('.body').load('selid_desvincular.php?id='+id+'&contrato='+contrato+'&mandante='+mandante,function(){
                                                $('#modal_desvincular').modal({show:true});
                                            });
                                        } 
                            
                            </script>
                            
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
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>            


                                <!-- MODAL desvincular -->
                                <div class="modal fade" id="modal_desvincularxxx" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                            <div class="i-checks"> <input name="tipo_desvincular" id="tipo_desvincular" type="radio" value="2"  /> <span style="font-weight: bold;font-size: 14px;">&nbsp;&nbsp;Contrato</span> </div>
                                                            <br />
                                                            <div class="i-checks"> <input name="tipo_desvincular" id="tipo_desvincular" type="radio" value="1"  /> <span style="font-weight: bold;font-size: 14px;">&nbsp;&nbsp;Contratista</span> </div> 
                                                        </div>   
                                                    </div>
                                                    
                                                    <div class="row">                                                  
                                                        <div class="form-group col-12">
                                                        <div style="width: 100%;display: inline-block;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                            <span  style="background:#282828; color: #fff;font-weight: bold;" class="btn btn-default btn-file"><span class="fileinput-new">&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Archivo&nbsp;&nbsp;&nbsp;&nbsp;</span>
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
                                                    <input type="text" name="rut" id="rut_desvincular" />
                                                    
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
                     
                     
                     <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Enviando desvinculaci&oacute;n, por favor espere un momento</h3>
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

    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    
       


</body>


</body>

</html>
<?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
