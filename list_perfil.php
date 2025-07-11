<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
include('sesion_manager.php');
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

$sql_perfiles=mysqli_query($con,"select * from perfiles  where id_mandante='$mandante' and eliminar=0 ");

if ($_SESSION['nivel']==1)  {
   $sql_contratistas=mysqli_query($con,"select c.* from contratistas as c ");
} else {    
   $sql_contratistas=mysqli_query($con,"select c.* from contratistas as c where c.mandante='$mandante' ");
}    

?>

<!DOCTYPE html>
<html>
<html translate="no">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>FacilControl | Reporte de Perfiles</title>

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
    $(document).ready(function () {
                
                $('#menu-perfiles').attr('class','active');
               
            });
</script>
    
    

<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">REPORTE PERFILES</h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                       <div class="ibox-title"> 
                             <div class="form-group row">
                                    <div class="col-8 col-sm-offset-2">
                                        <a class="btn btn-md btn-success btn-submenu" href="crear_perfil.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Perfil Cargos</a>
                                        <a class="btn btn-md btn-success btn-submenu" href="crear_perfil_vehiculos.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Perfil Vehiculos/Maquinarias</a>
                                    </div>
                              </div>  
                              <?php include('resumen.php') ?>                         
                        </div>
                        <div class="ibox-content">
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Perfil">
                               <div class="table-responsive"> 
                                    <table style="" class="table footable" data-page-size="10" data-filter="#filter">
                                       <thead class="cabecera_tabla">
                                            <tr style="font-size: 12px;">                                            
                                            <th style="width: 55%;border-right:1px #fff solid;">Nombre</th>
                                            <th style="width: 10%;border-right:1px #fff solid;">Tipo</th>
                                            <th style="width: 15%;border-right:1px #fff solid;">Creado</th>
                                            <th style="width: 20%;; text-align: center;">Documentos</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                          $i=1;
                                          $condicion=2;
                                          foreach ($sql_perfiles as $row) { 

                                                $query_perfil_a=mysqli_query($con,"select * from trabajadores_acreditados where perfil='".$row['id_perfil']."' ");
                                                $existe_perfil=mysqli_num_rows($query_perfil_a);
                                                echo '<tr>';
                                                //echo '<td data-toggle="true"></td>';
                                                if ($row['estado']==1) {
                                                    //echo '<button onclick="accion(0,'.$row['id_perfil'].',3)" title="Habilitada"><i style="font-size:20px" class="fa fa-toggle-on" aria-hidden="true"></i></button>';
                                                    //echo '<td><button onclick="eliminar('.$row['id_perfil'].','.$condicion.')" title="Eliminar" type="button" ><i style="font-size:20px" class="fa fa-trash" aria-hidden="true"></i></button></td>';
                                                } else {
                                                    //echo '<button onclick="accion(1,'.$row['id_perfil'].',3)" title="Deshabilitada"><i style="font-size:20px"  class="fa fa-toggle-off" aria-hidden="true"></i></button>';
                                                    //echo '<td><button onclick="eliminar('.$row['id_perfil'].','.$condicion.')" title="Eliminar" type="button" ><i style="font-size:20px" class="fa fa-trash" aria-hidden="true"></i></button></td>';
                                                }
                                                echo '<td>'.$row['nombre_perfil'].'</td>';                                        
                                               // echo '<td><button  class="btn btn-info btn-md" type="button" onclick="modal_ver_doc('.$row['id_perfil'].')">Ver Documentos</button></td>';
                                               if ($row['tipo']==0) {
                                                        echo '<td><label>CARGOS</label></td>';                                        
                                               } else {
                                                        echo '<td><label>VEHICULOS/MAQUINARIAS</label></td>';
                                               }

                                               echo '<td>'.$row['creado_perfil'].'</td>';
                                                    if ($existe_perfil==0) {                                         
                                                         
                                                         echo '<td style="background: ;text-align: center;"><button style="width:100%" title="Documentos del Perfil" class="btn btn-primary btn-sm" type="button" onclick="modal_ver_doc('.$row['id_perfil'].','.$row['tipo'].')">Ver Documentacion</button></td>';
                                                    } else {
                                                         
                                                         echo '<td style="background: ;text-align: center;"><button style="width:100%" title="Documentos del Perfil" class="btn btn-primary btn-sm" type="button" onclick="modal_ver_doc('.$row['id_perfil'].','.$row['tipo'].')">Ver Documentacion</button></td>';      
                                                    } 
                                              
                                                
                                            echo '</tr>';
                                            
                                         } ?>
                                        </tbody>
                                        <tfoot >
                                            <tr >
                                                <td style=""  colspan="4">
                                                     <ul class="pagination float-right"></ul>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                               </div>
                            <script>
                                 function modal_ver_doc(id,tipo) {
                                      $('.body').load('selid.php?id='+id+'&tipo='+tipo,function(){
                                                $('#modal_ver_doc').modal({show:true});
                                            });
                                    }
                                    
                                   function modal_ver_cargos(id) {
                                      $('.body').load('selid_cargos.php?id='+id,function(){
                                                $('#modal_ver_cargos').modal({show:true});
                                            });
                                    }  
                            </script>
                            
                                                    
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
                    <strong>Copyright</strong>FacilControl &copy; <?php echo $year ?>
                </div>
            </div>

        </div>
        </div>
                        <div id="modal_ver_doc" class="modal fade modal_ver_doc" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div class="modal-content " style="width: 130%;">
                                  <div style="background:#e9eafb;color: #282828" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel">Documentos del Perfil</h3>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                   <div class="body">
                                      
                                       
                                  </div>      
                                </div>  
                            </div>
                        </div>

                        <div id="modal_ver_cargos" class="modal fade modal_ver_cargos" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered">
                                <div  class="modal-content " style="width: 130%;">
                                  <div class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel">Cargos del Perfil</h3>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                   <div class="body">
                                      
                                       
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

<script>


function editar_perfil(idperfil){
    //alert(idperfil);
     $.ajax({
        method: "POST",
        url: "get_perfil.php",
        data: 'idperfil='+idperfil,
        success: function(data){
          window.location.href='editar_perfil.php';
        }                
     });
    
} 


function eliminar(id,condicion){
           //alert(id+' '+condicion);
    
            swal({
            title: "Confirmar Eliminar Perfil",
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
                                title: "Perfil Eliminado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_perfil.php', 3000);
        			  } else {
                         swal("Cancelado", "Perfil No Eliminado. Vuelva a Intentar.", "error");
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
            title: "Confirmar deshabilitar Perfil",
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
                                title: "Perfil Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_perfil.php', 3000);
        			  } else {
                         swal("Cancelado", "Perfil No Deshabilitado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Perfil",
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
                                title: "Perfil Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_perfil.php', 3000);
        			  } else {
                         swal("Cancelado", "Perfil No Hbilitado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } 
}

 function ver_doc(id) {
    alert(id);
 }

 
    
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





</script>

</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
