<?php
include "../config/config.php"; 

$valor=$_POST['valor'];
$id=$_POST['id'];
$accion=$_POST['accion'];


if ($accion==1) {
    $sql_accion=mysqli_query($con,"update mandantes set estado='$valor' where id_mandante='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}

# habilitar contratista
if ($accion==2) {
    $sql_accion=mysqli_query($con,"update contratistas set habilitada='$valor' where id_contratista='$id' ");
    if ($sql_accion) {
        ##$sql_accion2=mysqli_query($con,"update contratos set estado='$valor' where contratista='$id' ");
        echo 1;
    } else {
        echo 0;
    }
}

if ($accion==3) {
    $sql_accion=mysqli_query($con,"update perfiles set estado='$valor' where id_perfil='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}    

if ($accion==4) {
    $sql_accion=mysqli_query($con,"update trabajador set estado='$valor' where idtrabajador='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}

if ($accion==5) {
    $sql_accion=mysqli_query($con,"update contratos set estado='$valor' where id_contrato='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }
}

?>