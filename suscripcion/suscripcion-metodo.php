<?php
session_start();
include('config/config.php');
date_default_timezone_set('America/Santiago');
$fecha = date('Y-m-d H:m:s', time());

if ($_POST['metodo']=="Tarjeta") {
    $_SESSION['metodo']='Tarjeta';
    echo 1;
}

if ($_POST['metodo']=="Paypal") {
    $_SESSION['metodo']='Paypal';
    echo 1;
}



?>