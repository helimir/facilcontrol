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
    
    $sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
    $result=mysqli_fetch_array($sql_mandante);
    $mandante=$result['id_mandante'];
    
    if ($_SESSION['contratista_des']=='' or $_SESSION['contratista_des']==0) {
        $acreditados=mysqli_query($con,"select t.nombre1, t.apellido1, t.rut, d.* from desvinculaciones as d Left Join trabajador as t On t.idtrabajador=d.trabajador where d.mandante='".$_SESSION['mandante']."' and d.control='2' and d.verificado='1' ");
        $hay_desvinculados=mysqli_num_rows($acreditados);
    } else {
        #$acreditados=mysqli_query($con,"select t.nombre1, t.apellido1, t.rut, d.* from desvinculaciones as d Left Join trabajador as t On t.idtrabajador=d.trabajador where d.mandante='".$_SESSION['mandante']."' and d.contratista='".$_SESSION['contratista_des']."' and d.contrato='".$_SESSION['contrato_des']."' and d.control='2' and d.verificado='1' ");    
        if ($_SESSION['contrato_des']==0) {
            $acreditados=mysqli_query($con,"select t.nombre1, t.apellido1, t.rut, d.* from desvinculaciones as d Left Join trabajador as t On t.idtrabajador=d.trabajador where d.mandante='".$_SESSION['mandante']."' and d.contratista='".$_SESSION['contratista_des']."' and d.control='2' and d.verificado='1' ");
            $hay_desvinculados=mysqli_num_rows($acreditados);
        } else {
            $acreditados=mysqli_query($con,"select t.nombre1, t.apellido1, t.rut, d.* from desvinculaciones as d Left Join trabajador as t On t.idtrabajador=d.trabajador where d.mandante='".$_SESSION['mandante']."' and d.contratista='".$_SESSION['contratista_des']."' and contrato='".$_SESSION['contrato_des']."' and d.control='2' and d.verificado='1' ");
            $hay_desvinculados=mysqli_num_rows($acreditados);
        }
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


function selcontrato(contrato){
    var contratista=$('#contratista').val();
    $.post("sesion/contrato_acreditados.php", { contrato:contrato}, function(data){
        window.location.href='trabajadores_desvinculados_mandantes.php';
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
        window.location.href='trabajadores_desvinculados_mandantes.php'; 
    } 
}   

   $(document).ready(function() {
        $('#menu-trabajadores').attr('class','active');

        $('.footable').footable();
        $('.footable2').footable();

        $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            })


            //$("#contratista").change(function (id) {				
              //  $("#contratista option:selected").each(function () {
               //     idcontratista = $(this).val();
               //     alert(id);
               //     $.post("sel_contratistas_ta.php", { idcontratista: idcontratista }, function(data){
               //         $("#contrato").html(data);
               //     });            
               // });
                //window.location.href='trabajadores_desvinculados_mandantes.php';
            //})  
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
                                            <label style="background:#eee;border-bottom: #fff 2px solid;"  class="col-2 col-form-label"><b>Contratistas </b></label>
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
                                             
                                           <div class="form-group row">                                         
                                                <label style="background:#eee;border-bottom: #fff 2px solid;"  class="col-2 col-form-label"><b> Contratos </b></label>
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
     
                             <div class="table-responsive">  
                                <table class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                                   <thead class="cabecera_tabla">
                                    <tr>
                                        <th style="width: 5%;border-right:1px #fff solid;">#</th>
                                        <th style="width: 15%;border-right:1px #fff solid;">Nombres</th>
                                        <th style="width: 15%;border-right:1px #fff solid;">Apellidos</th>
                                        <th style="width: 10%;border-right:1px #fff solid;">RUT </th>
                                        <th style="width: 15%;border-right:1px #fff solid;" >Contratista</th>
                                        <th style="width: 15%;border-right:1px #fff solid;" >Fecha Desvinculado</th>
                                        <th style="width: 15%;border-right:1px #fff solid;" >Documentos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            if ($hay_desvinculados==0) {
                                        ?>
                                            <tr><td colspan="9"><h3>Si trabajadores desvinculados</h3></td></tr>
                                        <?php 
                                            } else {  
                                                $i=1;
                                                foreach ($acreditados as $row){  
                                                
                                                $url='img/trabajadores/'.$row['id_contratista'].'/'.$row['trut'].'/foto_'.$row['trut'].'.jpeg';
                                                
                                                $query_ta=mysqli_query($con,"select codigo from trabajadores_acreditados where trabajador='".$row['trabajador']."' and mandante='".$row['mandante']."' and contratista='".$row['contratista']."' and contrato='".$row['contrato']."'  and estado='2' ");
                                                $result_ta=mysqli_fetch_array($query_ta);
                                                
                                                $query_o=mysqli_query($con,"select razon_social from contratistas where id_contratista='".$row['contratista']."' ");
                                                $result_o=mysqli_fetch_array($query_o);
                                                
                                                
                                                $dia=substr($row['fecha_desvinculado'],8,2);
                                                $mes=substr($row['fecha_desvinculado'],5,2);
                                                $year=substr($row['fecha_desvinculado'],0,4); 
                                                $fecha=$dia.'-'.$mes.'-'.$year;
                                                
                                                $documentos='doc/validados/'.$row['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_ta['codigo'].'/zip/documentos_validados_trabajador_'.$row['rut'].'.zip'; 
                                                ?> 
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $row['nombre1'] ?></td>
                                                        <td><?php echo $row['apellido1'] ?></td>
                                                        <td><?php echo $row['rut'] ?></td>
                                                        <td><?php echo $result_o['razon_social']  ?></td>
                                                        <td><?php echo $fecha  ?></td>
                                                        <td><a href="<?php echo $documentos ?>" target="_blank" ><u> Documentos</u> </a></td>
                                                        
                                                    </tr>
                                            <?php $i++; } 
                                        }?>
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
