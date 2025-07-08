<?php
session_start();
include('config/config.php');
date_default_timezone_set('America/Santiago');
$fecha = date('Y-m-d H:m:s', time());

$query=mysqli_query($con,"select * from plan_suscripcion where plan='".$_POST['plan']."' ");
$result=mysqli_fetch_array($query);

mysqli_query($con,"update registro set plan='".$_POST['plan']."', monto='".$result['monto']."', editado='$fecha' where email='".$_POST['email']."' ");
$_SESSION['plan']=$_POST['plan'];

?>