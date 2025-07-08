<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and  $_SESSION['nivel']==1 ) { 
include('config/config.php');

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$aql_solicitudes=mysqli_query($con,"select * from solicitudes where estado='0' ");

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Admin ?></title>

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="plugins\footable\footable.core.css" rel="stylesheet">

    
    <link href="css\style.css" rel="stylesheet">

<style>

.floatm1 {   
	position:fixed;
	width:20%;
	height:6%;
	bottom:32%;
	right:0%;
	background:#25d366;
	color:#FFFFFF !important;
	border-radius:0px;
	text-align:center;
    font-size:30px;
    padding-right: ;
    padding-left: ;
	/**box-shadow: 2px 2px 3px #999;**/
    z-index:100;
    border-radius: 10%;
}
.my-floatm1{
	margin-top:10%;
}

.floatm2 {   
	position:fixed;
	width:50px;
	height:50px;
	bottom:480px;
	right:0%;
	background:#000080;
	color:#FFFFFF !important;
	border-radius:0px;
	text-align:center;
    font-size:30px;
    padding-right: ;
    padding-left: ;
	/**box-shadow: 2px 2px 3px #999;**/
    z-index:100;
}
.my-floatm2{
	margin-top:12px;
}

.floatm3 {   
	position:fixed;
	width:50px;
	height:50px;
	bottom:430px;
	right:0%;
	background:#FF00FF;
	color:#FFFFFF !important;
	border-radius:0px;
	text-align:center;
    font-size:30px;
    padding-right: ;
    padding-left: ;
	/**box-shadow: 2px 2px 3px #999;**/
    z-index:100;
}
.my-floatm3{
	margin-top:14px;
}




</style>

</head>


    
    <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;"><i class="fa fa-user-plus" aria-hidden="true"></i> Reporte de Solicitudes <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                             <div class="ibox-title">
                              <!--<div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary btn-md" type="button">Descargar Base</button>
                                    </div>
                              </div>-->                           
                            </div>
                        
                        
                        <div class="ibox-content">
                            
                         <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una solicitud">
                          <div class="table-repsonsive">
                            <table class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                               <thead>
                                <tr>
                                    <th >#</th>
                                    <th >Cliente</th>
                                    <th >Empresa</th>
                                    <th >Telefono</th>
                                    <th data-hide="table,phone">Email</th>
                                    <th data-hide="table,phone">Tipo</th>
                                    <th data-hide="table,phone">Trabajadores</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                  $i=1;
                                  $condicion=4;
                                  foreach ($aql_solicitudes as $row) { 
                                    echo '<tr>';
                                                                               
                                        echo '<td>'.$i.'</td>';
                                        echo '<td>'.$row['nombre'].'</td>';
                                        echo '<td>'.$row['empresa'].'</td>';                                        
                                        echo '<td>'.$row['telefono'].'</td>';
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '<td>'.$row['tipo'].'</td>';
                                        echo '<td>'.$row['trabajadores'].'</td>';
                                       
                                       
                                        
                                    echo '</tr>';
                                    $i++;
                                 } ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <ul class="pagination float-rigth"></ul>
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
            
            <?php include('..\footer.php') ?>

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




 function eliminar(id,condicion){
            //alert(id+' '+condicion);
    
            swal({
            title: "Confirmar Eliminar Mandante",
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
                                title: "Mandante Eliminado",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                         setTimeout(window.location.href='list_contratos.php', 3000);
        			  } else {
                         swal("Cancelado", "Mandante No Eliminado. Vuelva a Intentar.", "error");
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
                $.ajax({
        			method: "POST",
                    url: "add/accion.php",
                    data: 'valor='+valor+'&id='+id+'&accion='+accion,
        			success: function(data){			  
                     if (data==1) {
                         swal({
                                title: "Mandante Deshabilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_mandantes.php', 3000);
        			  } else {
                         swal("Cancelado", "Mandante No Deshabilitado. Vuelva a Intentar.", "error");
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      } else {
        swal({
            title: "Confirmar Habilitar Mandante",
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
                                title: "Mandante Habilitado",
                                //text: "You clicked the button!",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='list_mandantes.php', 3000);
        			  } else {
                         swal("Cancelado", "Mandante No Hbilitado. Vuelva a Intentar.", "error");
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
                                        setTimeout(window.location.href='list_mandantes.php', 3000);
                                    } else {
                                        swal("Cancelado", "Accion Cancelada", "error");
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
