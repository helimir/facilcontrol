<?php

session_start();
include('config/config.php');

$query=mysqli_query($con,"select id_contratista from contratistas where rut='".$_POST['rut']."' ");
$result=mysqli_fetch_array($query);

$_SESSION['contratista_agregada']=$result['id_contratista'];

?>