<?php
include('../config/config.php');
date_default_timezone_set('America/Santiago');


$date = date('Y-m-d H:m:s', time());
 
$id=$_POST['id'];
$fecha_val=$_POST['fecha_val'];

$dia=substr($fecha_val,-2);
$mes=substr($fecha_val,5,2);
$ano=substr($fecha_val,0,4);
$fecha=$dia.'-'.$mes.'-'.$ano;

$query=mysqli_query($con,"update contratistas set fecha_fin_plan='$fecha' where id_contratista='$id' ");

if ($query) {
    echo 1;
     
} else {
    echo 1;
}    
    
    

?>