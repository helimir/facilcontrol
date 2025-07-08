<?php
 session_start();
 
include('../config/config.php');
date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$fecha_val=$_POST['fecha_val'];

$_SESSION['fecha_val']=$_POST['fecha_val'];

$id=$_SESSION['trabajador'];
$idcargo=$_SESSION['cargo'];
$contrato=$_SESSION['contrato'];
$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];
$usuario=$_SESSION['usuario'];

$documentos=unserialize($_POST['documentos']);
$codigo=$_POST['codigo'];

if ($fecha_val=="") {
    $fecha_val='0000-00-00';
}

$query=mysqli_query($con,"update observaciones set fecha='$fecha_val' where trabajador='$id' ");

if ($query) {
    
    # agregar a tabla de trabajador acreditado
    $query_a=mysqli_query($con,"insert into trabajadores_acreditados (trabajador,contratista,mandante,contrato,documentos,codigo,validez,creado,usuario) value ('$id','$contratista','$mandante','$contrato','$documentos','$codigo','$validez','$date','$usuario' ");
    
    echo 0;
     
} else {
    echo 1;
}    
    
    

?>