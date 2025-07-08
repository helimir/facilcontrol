<?php 

session_start();
include('config/config.php');

$tabla=$_GET['tabla'];
    $query=mysqli_query($con,"select cargos from $tabla where id_contrato='56' ");
    $result=mysqli_fetch_array($query);
    $cargos=$result['cargos'];

?>