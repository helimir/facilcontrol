<?php
session_start();

if ($_POST['tipo']==1) {
	$_SESSION['contratista']=$_POST['contratista'];
}

if ($_POST['tipo']==2) {
	$_SESSION['contratista']=$_POST['contratista'];
	$_SESSION['contrato']=$_POST['contrato'];
}

echo 0;
?>