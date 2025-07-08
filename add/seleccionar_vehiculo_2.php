<?php
session_start();
if (isset($_SESSION['usuario'])) { 
    include('../config/config.php');    
    
    $mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
    $query_c=mysqli_query($con,"select  COUNT(*) as total from autos_asignados where mandante='".$_SESSION['mandante']."' ");
    $result_c=mysqli_fetch_array($query_c);
    if ($result_c['total']>0) {
        echo 1;
    } else {
        echo 0;
    }


} else { 
    echo "<script> window.location.href='admin.php'; </script>";
}
?>