<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');

if ($_SESSION['nivel']==3) {
    $_SESSION['active']=36;
    $query_obs=mysqli_query($con,"select d.documento, c.cargo, n.nombre_contrato, t.razon_social, o.observacion, o.creado, o.estado from observaciones as o Left Join doc as d On id_doc=o.documento Left Join cargos as c On c.idcargo=o.cargo Left join contratos as n On n.id_contrato=o.contrato Left Join contratistas as t On t.id_contratista=n.contratista where t.email='".$_SESSION['usuario']."' order by o.creado desc  ");
    $num_obs=mysqli_num_rows($query_obs);
    
} 
if ($_SESSION['nivel']==2) {
    $_SESSION['active']=29;
    $query_obs=mysqli_query($con,"select d.documento, c.cargo, n.nombre_contrato, t.razon_social, o.observacion, o.creado, o.estado from observaciones as o Left Join doc as d On id_doc=o.documento Left Join cargos as c On c.idcargo=o.cargo Left join contratos as n On n.id_contrato=o.contrato Left Join contratistas as t On t.id_contratista=n.contratista where o.user='".$_SESSION['usuario']."' order by o.creado desc  ");
    $num_obs=mysqli_num_rows($query_obs);
} 

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');



?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | <?php echo $_SESSION['titulo'] ?></title>

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



<script>

    
   

</script>

</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Observaciones</h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
                         <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5></h5>
                            <div class="ibox-tools">
                                <!--<a href="" class="btn btn-primary btn-xs">Add new issue</a>-->
                            </div>
                        </div>
                        <div class="ibox-content">

                            <div class="m-b-lg">
                                <div class="m-t-md">
                                    <!--<div class="float-right">
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-comments"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-user"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-list"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-pencil"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-print"></i> </button>
                                        <button type="button" class="btn btn-sm btn-white"> <i class="fa fa-cogs"></i> </button>
                                    </div>-->
                                    <strong>Total: <?php echo $num_obs ?> observaciones.</strong>
                                </div>
                            </div>

                            <div class="table-responsive">
                            <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar una observacion">
                            <table class="footable table table-hover" data-page-size="25" data-filter="#filter">
                                <thead>
                                    <tr>
                                        <th width="10%" >Estado</th>
                                        <th width="20%">Documento</th>
                                        <th width="30%">Observaci&oacute;n</th>
                                        <th width="20%">Contrato</th>
                                        <th width="20%">Creado</th>
                                        
                                    </tr>
                                </thead>
                                
                                <tbody>
                                <?php 
                                  foreach ($query_obs as $row) {
                                    if ($row['estado']==1) {
                                        $estado='btn btn-primary btn-sm';
                                        $estado2='Resuelto';
                                    } else {
                                        $estado='btn btn-danger btn-sm';
                                        $estado2='Pendiente';
                                    }
                                    $hora=substr($row['creado'],11,5);
                                    $fecha=substr($row['creado'],0,10);
                                    
                                    echo '<tr>';
                                        echo '<td><button style="width:70% " class="'.$estado.'"><small>'.$estado2.'</button></small></td>';
                                        echo '<td >'.$row['documento'].'</td>';
                                        echo '<td>'.$row['observacion'].'</td>';
                                        echo '<td>'.$row['nombre_contrato'].'<br/><small>'.$row['razon_social'].'</small></td>';
                                        echo '<td>'.$hora.' '.$fecha.'</td>';
                                    echo '</tr>';
                                 } ?>
                                </tbody>
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

<script>

$(document).ready(function() {

            $('.footable').footable();
            $('.footable2').footable();
                        
            
    });
                                        
function refresh_asignar(){
  window.location.href='list_trabajadores.php';
}   
         
           


function refresh(){
    window.location.href='list_trabajadores.php';
}

</script>

<?php 
 if ($_SESSION['sms']==5) {             
    echo '<script>swal("RUT Existe!", "Trabajador Ya Registrado.", "warning");</script>';
    $_SESSION['sms']=0;
 }
 if ($_SESSION['sms']==6) {             
    echo '<script>swal("Confirmado!", "Trabajador Registrado.", "success");</script>';
    $_SESSION['sms']=0;
 }
 if ($_SESSION['sms']==7) {             
     echo '<script>swal("Cancelado", "Trabajador Ya Registrado.", "error");;</script>';
    $_SESSION['sms']=0;
 } 
  if ($_SESSION['sms']==9) {             
     echo '<script>swal("Cancelado", "Trabajador No Actualizado. Vuelva a intentar.", "error");;</script>';
    $_SESSION['sms']=0;
 }
?>
</body>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>
