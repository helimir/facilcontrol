<?php
session_start();
if (isset($_SESSION['usuario'])   ) {    
include "../config/config.php"; 
date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$query_config=mysqli_query($con,"select * from configuracion ");
$result_config=mysqli_fetch_array($query_config);


function make_date(){
    return strftime("%d-%m-%Y H:i:s", time());
}

$fecha =make_date();
$id=$_POST['id'];

$query_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='$id'  ");
$result_mandante=mysqli_fetch_array($query_mandante);

$crear_contratista=mysqli_query($con,"insert into contratistas (giro,descripcion_giro, nombre_fantasia, razon_social, rut, representante, rut_rep, creado_contratista, mandante) values ('".$result_mandante['giro']."', '".$result_mandante['descripcion_giro']."', '".$result_mandante['nombre_fantasia']."', '".$result_mandante['razon_social']."', '".$result_mandante['rut_empresa']."', '".$result_mandante['representante_legal']."', '".$result_mandante['rut_representante']."', '$date', '".$result_mandante['id_mandante']."') ");

if ($crear_contratista) {
    $resultado =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'contratistas' ");
    $auto= mysqli_fetch_array($resultado); 
    $_SESSION['contratista']=$auto['AUTO_INCREMENT']-1;
    
    $query_user=mysqli_query($con,"update users set nivel=4 where usuario='$id' ");
    echo 0;
} else {
    echo 1;
}

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}

?>