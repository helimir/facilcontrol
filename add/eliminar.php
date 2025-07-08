<?php
session_start();
if (isset($_SESSION['usuario'])) { 
include "../config/config.php"; 

$id=$_POST['id'];
$condicion=$_POST['condicion'];

// eliminar contratista
if ($condicion==0) {
    $query=mysqli_query($con,"update contratistas set eliminar=1 where id_contratista='$id' ");
    if ($query) {
         $query2=mysqli_query($con,"update contratos set eliminar=1 where contratista='$id' ");
         echo 0;
    } else {
         echo 1;
    }
}

if ($condicion==1) {
    $query=mysqli_query($con,"update contratos set eliminar=1 where id_contrato='$id' ");
    if ($query) {
         echo 0;
    } else {
         echo 1;
    }
}

if ($condicion==2) {
    $query=mysqli_query($con,"update perfiles set eliminar=1 where id_perfil='$id' ");
    if ($query) {
         echo 0;
    } else {
         echo 1;
    }
}

# borrar un trabajador
if ($condicion=='trabajadores') {
    $query=mysqli_query($con,"update trabajador set eliminar=1 where idtrabajador='$id' ");
    if ($query) {
         echo 0;
    } else {
         echo 1; 
    }
}

if ($condicion==4) {
    $query=mysqli_query($con,"update mandantes set eliminar=1 where id_mandante='$id' ");    
    if ($query) {
         $delete_m=mysqli_query($con,"update notificaciones set eliminar=1 where mandante='$id' ");
         $delete_m=mysqli_query($con,"update contratistas_mandantes set eliminar=1 where mandante='$id' ");
         
         
         echo 0;
    } else {
         echo 1;
    }
}           

} else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>