<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
session_start(); 
include "../config/config.php";	

    $query_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."' ");
    $result_mandante=mysqli_fetch_array($query_mandante);
	
    $_SESSION['mandante']=$_POST['id'];
	
    
?>