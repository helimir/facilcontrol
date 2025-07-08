<?php
session_start();
$_SESSION['contratista_acreditada']=$_POST['contratista'];

if ($_POST['contratista']==0) {
    $_SESSION['contrato_acreditados']=0;
}

?>