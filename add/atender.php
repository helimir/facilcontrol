<?php

session_start();
include "../config/config.php"; 
date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$id=isset($_POST['id']) ? $_POST['id']: '';
$tipo=isset($_POST['tipo']) ? $_POST['tipo']: '';
$url=isset($_POST['url']) ? $_POST['url']: '';

$id=$_POST['id'];
$tipo=$_POST['tipo'];

$_SESSION['contratista']=$_POST['contratista'];
$_SESSION['mandante']=$_POST['mandante'];
$_SESSION['perfil']=$_POST['perfil'];
$_SESSION['cargo']=$_POST['cargo'];
$_SESSION['contrato']=$_POST['contrato'];

if ($url=="verificar_documentos_vehiculos_mandante.php" or $url=="verificar_documentos_vehiculos_contratista.php") {
    $_SESSION['vehiculo']=$_POST['trabajador'];
} 
if ($url=="verificar_documentos_trabajador_mandante.php" or $url=="verificar_documentos_trabajador_contratista.php") {
    $_SESSION['trabajador']=$_POST['trabajador'];
}


$query=mysqli_query($con,"update notificaciones set leido=1, fecha_leida='$date' where idnoti='$id' ");

if ($query) {
    echo 1;
} else {
    echo 0;
}

?>