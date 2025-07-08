<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
include "config/config.php";	
	
	$IdRegion = $_POST['IdRegion'];	
	$queryC = "SELECT IdComuna, Comuna  FROM comunas WHERE IdRegion = '$IdRegion' ORDER BY IdComuna";
	$resultadoC = mysqli_query($con,$queryC);	
	$html= "<option value='0'>Seleccionar Comuna</option>";	
	while($rowC = mysqli_fetch_assoc($resultadoC))
	{   //$comuna=utf8_encode($rowC['Comuna']);
		$html.= "<option value='".$rowC['IdComuna']."'>".$rowC['Comuna']."</option>";
	}	
	echo $html;
?>