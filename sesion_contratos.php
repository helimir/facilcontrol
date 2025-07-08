<?php

session_start();
include('config/config.php');
session_destroy($_SESSION['contrato']);
$_SESSION['contrato']=$_POST['id'];

?>