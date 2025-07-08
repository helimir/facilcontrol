<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */

session_start(); 
if (isset($_SESSION['usuario']) ) { 
    
include "../config/config.php";	
	
	$id = $_POST['id'];	
	$queryC = mysqli_query($con,"select cm.*, c.* from contratistas_mandantes as cm Left Join contratistas as c On c.id_contratista=cm.contratista  where cm.mandante='".$_SESSION['mandante']."'     ");
		
	
    
    $html= "<option value='0'>Seleccionar Contratista</option>";	
	foreach ($queryC as $row) {	    
		$html.= "<option value='".$row['id_contratista']."'>".$row['razon_social']."</option>";
	}	
	echo $html;

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}    
?>