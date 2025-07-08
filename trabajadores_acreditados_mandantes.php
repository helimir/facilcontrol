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
   
    $sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
    $result=mysqli_fetch_array($sql_mandante);
    $mandante=$result['id_mandante'];
    
    $contratos=mysqli_query($con,"SELECT * from contratos where contratista='".$result_contratista['id_contratista']."' ");
    
    
    if ($_SESSION['contratista_des']=='' or $_SESSION['contratista_des']==0) {
        $acreditados=mysqli_query($con,"select o.nombre_contrato, a.contratista as contratista_a, a.*, t.*, c.razon_social, o.id_contrato from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato where a.mandante='".$_SESSION['mandante']."' and a.estado!=2 and t.estado=0 ");
        $hay_acreditados=mysqli_num_rows($acreditados);
    } else {
        if ($_SESSION['contrato_des']==0) {
            $acreditados=mysqli_query($con,"select o.nombre_contrato, a.contratista as contratista_a, a.*, t.*, c.razon_social, o.id_contrato from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato where a.mandante='".$_SESSION['mandante']."' and a.contratista='".$_SESSION['contratista_des']."'  and a.estado!=2 and t.estado=0 ");
            $hay_acreditados=mysqli_num_rows($acreditados);
        } else {
            $acreditados=mysqli_query($con,"select o.nombre_contrato, a.contratista as contratista_a, a.*, t.*, c.razon_social, o.id_contrato from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato where a.mandante='".$_SESSION['mandante']."' and a.contratista='".$_SESSION['contratista_des']."' and a.contrato='".$_SESSION['contrato_des']."'  and a.estado!=2 and t.estado=0 ");
            $hay_acreditados=mysqli_num_rows($acreditados);
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
    var contratista=$('#contratista').val();
    $.post("sesion/contrato_acreditados.php", { contrato:contrato}, function(data){
        window.location.href='trabajadores_acreditados_mandantes.php';
    }); 
   }

function selcontratista(id,id2) {
    var contrato=$('#contrato').val();
    if (id!="") {
        contratista=id;
    } else {
        contratista=id2;
    }
   // alert(contrato);
        $.post("sel_contratistas_ta.php", { idcontratista: contratista,contrato:contrato }, function(data){
            $("#contrato").html(data);
        }); 
    if (id==0) {
        window.location.href='trabajadores_acreditados_mandantes.php'; 
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
                                                <label style="background:#e9eafb;border-bottom: #fff 2px solid;"  class="col-2 col-form-label"><b> Contratistas </b></label>
                                                <div class="col-sm-6">
                                                    <select name="contratista" id="contratista" class="form-control" onchange="selcontratista(this.value,<?php echo $_SESSION['contratista_des'] ?>)">
                                                        <?php                                                
                                                        
                                                        if ($_SESSION['contratista_des']=="" or $_SESSION['contratista_des']==0) {
                                                            echo '<option value="0" selected="" >Todas las Contratista</option>';
                                                            $contratistas2=mysqli_query($con,"SELECT c.* from contratistas as c Left Join contratistas_mandantes as m On m.contratista=c.id_contratista  where m.mandante='".$_SESSION['mandante']."'  ");
                                                            foreach ($contratistas2 as $row) {
                                                                echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                            }

                                                        } else {
                                                            $query=mysqli_query($con,"select * from contratistas where id_contratista='".$_SESSION['contratista_des']."' ");

                                                            $contratistas=mysqli_query($con,"SELECT c.* from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where m.id_mandante='".$_SESSION['mandante']."' and c.id_contratista!='".$_SESSION['contratista_des']."' ");
                                                            
                                                            $result=mysqli_fetch_array($query);
                                                            echo '<option value="" selected="" >'.$result['razon_social'].'</option>';
                                                            echo '<option value="0" >Todas las contratistas</option>';
                                                        }    
                                                        
                                                        foreach ($contratistas as $row) {
                                                           echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                        }  
                                                             
                                                          ?>                                           
                                                    </select>
                                               </div> 
                                            </div> 
                                             
                                           <div class="row">                                         
                                              <label style="background:#e9eafb;border-bottom: #fff 2px solid;"  class="col-2 col-form-label"><b> Contratos </b></label>
                                             <div class="col-sm-6">   
                                                <select name="contrato" id="contrato" class="form-control" onchange="selcontrato(this.value)">
                                                    <?php
                                                        if ($_SESSION['contratista_des']=="" or $_SESSION['contratista_des']==0) {
                                                    ?>
                                                                <option value="0" selected="" >Todos los Contrato</option>;
                                                    <?php
                                                        } else {
                                                                $query_con=mysqli_query($con,"select * from contratos where contratista='".$_SESSION['contratista_des']."' and mandante='".$_SESSION['mandante']."' and id_contrato='".$_SESSION['contrato_des']."'  ");
                                                                $result_con=mysqli_fetch_array($query_con);
                                                                $hay_contratos=mysqli_num_rows($query_con);
                                                      
                                                                if ($_SESSION['contrato_des']!=0) {
                                                                    echo '<option value="'.$result_con['id_contrato'].'" select="" >'.$result_con['nombre_contrato'].'</option>';
                                                                    $query_con2=mysqli_query($con,"select * from contratos where contratista='".$_SESSION['contratista_des']."' and mandante='".$_SESSION['mandante']."' and id_contrato!='".$_SESSION['contrato_des']."'  ");    
                                                                    foreach ($query_con2 as $row) {                                                        
                                                                        echo '<option value="'.$row['id_contrato'].'" >'.$row['nombre_contrato'].'</option>';
                                                    
                                                                    }
                                                                } else {
                                                                    if ($_SESSION['sincontrato']!=0) {
                                                                        echo '<option value="0" select="" >Seleccionar contrato</option>';
                                                                        $query_con2=mysqli_query($con,"select * from contratos where contratista='".$_SESSION['contratista_des']."' and mandante='".$_SESSION['mandante']."' and id_contrato!='".$_SESSION['contrato_des']."'  ");    
                                                                        foreach ($query_con2 as $row) {                                                        
                                                                            echo '<option value="'.$row['id_contrato'].'" >'.$row['nombre_contrato'].'</option>';
                                                        
                                                                        }
                                                                    } else {
                                                                        echo '<option value="0" select="" >Sin contratos</option>';
                                                                    }    
                                                                }           
                                                    }
                                                    ?>

                                                </select>
                                             </div>
                                    
                                            </div>  

                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un trabajador" />
                            <br>                        
                              
                             <div class="table-responsive">  
                                <table class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                                   <thead class="cabecera_tabla">
                                        <tr style="font-size: 12px;">
                                            <th style="width: 5%;border-right:1px #fff solid;"></th>
                                            <th style="width: 10%;border-right:1px #fff solid;">Nombres</th>
                                            <th style="width: 10%;border-right:1px #fff solid;">Apellidos</th>
                                            <th style="width: 10%;border-right:1px #fff solid;">RUT </th>
                                            <th style="width: 23%;border-right:1px #fff solid;">Contratista</th>
                                            <th style="width: 15%;border-right:1px #fff solid;">Contrato</th>
                                            <th style="width: 10%;border-right:1px #fff solid;" >Fecha</th>
                                            <th style="width: 10%;border-right:1px #fff solid;" >Credencial</th>
                                            <th style="width: 17%;border-right:1px #fff solid;" >Descarga</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($hay_acreditados==0) {
                                        ?>
                                            <tr><td colspan="9"><h3>Si trabajadores acreditados</h3></td></tr>
                                        <?php 
                                            } else {                                        
                                                    $i=1;
                                                    foreach ($acreditados as $row){  
                                                    
                                                    $url='img/trabajadores/'.$row['id_contratista'].'/'.$row['trut'].'/foto_'.$row['trut'].'.jpeg';
                                                    
                                                    $query_d=mysqli_query($con,"select estado from trabajadores_asignados where trabajadores='".$row['idtrabajador']."' "); 
                                                    $result_d=mysqli_fetch_array($query_d);
                                                    
                                                    $documentos='doc/validados/'.$row['mandante'].'/'.$row['contratista_a'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/zip/documentos_validados_trabajador_'.$row['rut'].'.zip'; 
                                                    ?> 
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $row['nombre1'] ?></td>
                                                            <td><?php echo $row['apellido1'] ?></td>
                                                            <td><?php echo $row['rut'] ?></td>
                                                            <td><?php echo $row['razon_social']  ?></td>
                                                            <td><?php echo $row['nombre_contrato'] ?></td>
                                                            <td><?php echo $row['validez']  ?></td>
                                                            
                                                            <?php if ($row['url_foto']!="") { ?>
                                                                <td><a class="" type="button" href="credencial.php?codigo=<?php echo $row['codigo'] ?>" target="_blank"> Descargar</a></td>
                                                            <?php } else { ?>
                                                                <td style="color: #FF0000;font-weight: bold;">Sin Foto</td>
                                                                <!--<td><a class="" type="button" href="credencial.php?id=<?php echo $row['idtrabajador'] ?>&contratista=<?php echo $row['contratista'] ?>" target="_blank"><i class="fa fa-file" aria-hidden="true"></i> Descargar Credencial</a></td>-->
                                                            <?php } ?>
                                                            
                                                            <td><a href="<?php echo $documentos ?>" ><u> Documentos</u> </a></td>
                                                            
                                                        </tr>
                                                <?php $i++; } 
                                            }?>
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
