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

$aql_mandantes=mysqli_query($con,"select r.Region, c.Comuna, m.* from mandantes as m Left Join regiones as r On r.IdRegion=m.dir_comercial_region Left Join comunas as c On c.IdComuna=m.dir_comercial_comuna where m.eliminar=0 ");

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">


<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Mandantes </title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

    
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
                    <h2 style="color: #010829;font-weight: bold;">Reporte de Mandantes  <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        
                        
                        <div class="ibox-content">
                                <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-2 col-sm-12" href="crear_mandante.php" class="" type="button">NUEVO MANDANTE</a>
                                        <!--<a  class="btn btn-sm btn-success btn-submenu" href="list_contratistas.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i><b>Reporte de Contratistas</b></a>-->
                                    </div>
                                </div> 
                                <?php include('resumen.php') ?>                                
                                <hr>
                            
                         <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Mandante">
                          <div class="table-repsonsive">
                            <table class="footable table table-stripped" data-page-size="25" data-filter="#filter">
                               <thead>
                                <tr>
                                    <th style="width: 5%;" ></th>
                                    <th style="width: 8%;border-right:1px #fff solid">Estado</th>                                   
                                    <th style="width: 20%;border-right:1px #fff solid">Razon Social</th>
                                    <th style="width: 12%;border-right:1px #fff solid" data-hide="table,phone">RUT Empresa</th>
                                    <th style="width: 20%;border-right:1px #fff solid" data-hide="table,phone">Rep.Legal</th>
                                    <th style="width: 15%;border-right:1px #fff solid" data-hide="table,phone">Adminisrador</th>
                                    <th style="width: 10%;border-right:1px #fff solid" data-hide="table,phone">Fono</th>
                                    <th style="width: 5%;border-right:1px #fff solid" data-hide="table,phone">Editar</th>
                                    <th style="width: 5%;border-right:1px #fff solid" data-hide="table,phone">Dual</th>
                                    
                                    <th data-hide="all">Nombre Fantasia</th>
                                    <th data-hide="all" style="width: ;">Giro</th>
                                    <th data-hide="all" style="width: ;">Descripcion Giro</th>
                                    <th data-hide="all" style="width: ;">Rut Rep.Legal</th>
                                    <th data-hide="all" style="width: ;">Email</th>
                                    <th data-hide="all" style="width: ;">Region Comercial</th>
                                    <th data-hide="all" style="width: ;">Comuna Comercial</th>
                                    <th data-hide="all" style="width: ;">Region Matriz</th>
                                    <th data-hide="all" style="width: ;">Comuna Matriz</th>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                  $i=1;
                                  $condicion=4;
                                  foreach ($aql_mandantes as $row) { ?>
                                    <tr>
                                    <?php
                                        $_SESSION['id_mandante']=$row['id_mandante'];
                                        echo '<td data-toggle="true"></td>';
                                        if ($row['estado']==1) {
                                            echo '<td><button  class="btn-md" onclick="accion(0,'. $_SESSION['id_mandante'].',1)" title="Habilitado"><i style="font-size:20px" class="fa fa-toggle-on" aria-hidden="true"></i></button>';
                                        } else {
                                            echo '<td><button  class="btn-md" onclick="accion(1,'. $_SESSION['id_mandante'].',1)" title="Deshabilitado"><i style="font-size:20px"  class="fa fa-toggle-off" aria-hidden="true"></i></button>';
                                        }    
                                        
                                       
                                        echo '<td>'.$row['razon_social'].'</td>';
                                        echo '<td>'.$row['rut_empresa'].'</td>';
                                        echo '<td>'.$row['representante_legal'].'</td>';                                        
                                        echo '<td>'.$row['administrador'].'</td>';
                                        echo '<td>'.$row['fono'].'</td>';
                                        echo '<td ><button title="Editar" class="btn btn-success btn-md " type="button" onclick="edit_mandante('.$row['id_mandante'].')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>';
                                        echo '<td ><button title="Editar" class="btn btn-primary btn-md " type="button" onclick="agregar('.$i.',1)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>';
                                        
                                        echo '<td>'.$row['nombre_fantasia'].'</td>';
                                        echo '<td>'.$row['giro'].'</td>';
                                        echo '<td>'.$row['descripcion_giro'].'</td>';
                                        echo '<td>'.$row['rut_representante'].'</td>';
                                        echo '<td>'.$row['email'].'</td>';
                                        echo '<td>'.$row['Region'].'</td>';
                                        echo '<td>'.$row['Comuna'].'</td>';
                                        echo '<td>'.$row['dir_matriz_region'].'</td>';
                                        echo '<td>'.$row['dir_matriz_comuna'].'</td>'; ?>                                                
                                    </tr>
                                    <input type="hidden" name="rut_mandante" id="rut_mandante<?php echo $i ?>" value="<?php echo $row['rut_empresa'] ?>" >
                                <?php 
                                $i++;} ?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
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
            
            <?php include('footer.php') ?>

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

function agregar(i,opcion) {
    var usuario=$('#rut_mandante'+i).val();
    swal({
        title: "¿Desea Agregar como Contratista?",
        //text: "Desea Agregarla",
        type: "success",
        showCancelButton: true,
        confirmButtonColor: "#1AB394",
        confirmButtonText: "Si, Agregar!",
        cancelButtonText: "No, Agregar!",
        closeOnConfirm: false,
        closeOnCancel: false },
        function (isConfirm) {
            if (isConfirm) { 
                $.ajax({
                    method: "POST",
                    url: "add/agregar_dual.php",
                    data: 'rut='+usuario+'&opcion='+opcion,
                    success: function(data) {
                        alert(data)
                        if (data==0) {
                            swal({
                                title: "Contratista Agregada",
                                //text: "You clicked the button!",
                                type: "success"
                          });
                          setTimeout(window.location.href='list_contratistas.php', 3000);                            
                        } else {
                            swal("Disculpe Error de Sistema", "Vuelva a intentar", "error");
                        }
                    },
                });     
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        }); 
}

function edit_mandante(id){
    window.location.href='edit_mandante.php?id='+id;
}

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
