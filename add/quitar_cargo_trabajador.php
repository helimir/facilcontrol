<?php
include('../config/config.php');
session_start();
date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$id=$_POST['id'];
$mandante=$_POST['mandante'];
$contrato=$_POST['contrato'];
$accion=$_POST['accion'];


    $query=mysqli_query($con,"select * from trabajadores_asignados where contrato='$contrato' and mandante='$mandante' ");
    $result=mysqli_fetch_array($query);
    
    $trabajadores=unserialize($result['trabajadores']);
    $cargos=unserialize($result['cargos']);
    
    
    $contador1=0;
    foreach ($trabajadores as $row) {    
        if ($row==$id) {
            $posicion_trabajador=$contador1;
            break;
        }    
     $contador1++;
    }
    
    $contador2=0;
    foreach ($cargos as $row) {
        if ($contador2!=$posicion_trabajador) {
            $nuevo_cargos[$contador2]=$row;
        }
    $contador2++;
    }
    
    $contador3=0;
    foreach ($trabajadores as $row) {
        if ($row!=$id) {
            $nuevo_trabajador[$contador3]=$row;
        }
    $contador3++;
    }
    
    $nvo_cargos=serialize($nuevo_cargos);
    $nvo_trabajador=serialize($nuevo_trabajador);
    $sql=mysqli_query($con,"update trabajadores_asignados set cargos='$nvo_cargos', trabajadores='$nvo_trabajador' where contrato='$contrato' and mandante='$mandante' ");
    
    if ($sql) {
        echo 0;
    } else {
        echo 1;
    }



?>