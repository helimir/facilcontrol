<?php
include "../config/config.php"; 

$valor=$_POST['valor'];
$id=$_POST['id'];
$accion=$_POST['accion'];


if ($accion==1) {
    $sql_accion=mysqli_query($con,"update mandantes set estado='$valor' where id_contratista='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}

if ($accion==2) {
    $sql_accion=mysqli_query($con,"update contratistas set estado='$valor' where id_contratista='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}

if ($accion==3) {
    $sql_accion=mysqli_query($con,"update perfiles set estado='$valor' where id_contratista='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}    

?>