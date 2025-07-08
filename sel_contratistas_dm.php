<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
 session_start();
include "config/config.php";	
	
	$idcontratista = $_POST['idcontratista'];	
	$_SESSION['contratista']=$_POST['idcontratista'];	
	$_SESSION['contrato']=$_POST['contrato'];
	
	$queryC = "SELECT id_contrato,nombre_contrato  FROM contratos WHERE contratista = ".$_POST['idcontratista']." and mandante='".$_SESSION['mandante']."' ";
	$resultadoC = mysqli_query($con,$queryC);	
	$hay_contratos=mysqli_num_rows($resultadoC);
	$_SESSION['sincontrato']=$hay_contratos;
	#if ($hay_contratos!=0) {		
	if ($_POST['idcontratista']==0) {
		$html= "<option value='0'>Seleccionar Contratista</option>";	
	} else {
		if ($hay_contratos==0) {
			$html= "<option value='0'>Sin contratos</option>";
		} else {
			$html= "<option value='0'>Seleccionar Contrato</option>";
		}	
	}
		while($rowC = mysqli_fetch_assoc($resultadoC))
		{   
			$html.= "<option value='".$rowC['id_contrato']."'>".$rowC['nombre_contrato']."</option>";
		}	
	#} else {
	#	$html.= "<option value="0">Sin Contratos</option>";
	#}	
	echo $html;
?>