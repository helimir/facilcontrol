<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
session_start(); 
include "../config/config.php";	

    $query_mandante=mysqli_query($con,"select * from mandantes where id_mandante='".$_POST['mandante']."' ");
    $result_mandante=mysqli_fetch_array($query_mandante);
	
    $_SESSION['contratista']=$_POST['id'];
    $_SESSION['mandante']=$result_mandante['id_mandante'];
	
    
?>