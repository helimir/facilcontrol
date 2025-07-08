<?php
session_start();

$_SESSION['contrato_acreditados']=$_POST['contrato'];
$_SESSION['contratista_acreditada']=$_POST['contratista'];

?>