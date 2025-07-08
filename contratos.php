<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
session_start(); 
include "config/config.php";	
	
	$idcontratista = $_POST['id'];	
	$mandante = $_POST['mandante'];
	$queryC = "SELECT * from contratos WHERE contratista = '$idcontratista' and mandante='$mandante'"; 
	$resultadoC = mysqli_query($con,$queryC);	
	
    $html= "<option value='0'>Seleccionar Contrato</option>";	
	
    while($rowC = mysqli_fetch_assoc($resultadoC)) {
		$html.= "<option value='".$rowC['id_contrato']."'>".$rowC['nombre_contrato']."</option>";
	}	
	echo $html;
?>