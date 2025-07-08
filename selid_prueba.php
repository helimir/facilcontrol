<?php

session_start();
include('config/config.php');
$_SESSION['cargos']=$_GET['id'];

?>