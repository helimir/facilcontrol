<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
include "config/config.php";	
	
	$id = $_POST['id'];	
	$queryC = mysqli_query($con,"SELECT  cargos  FROM contratos WHERE id_contrato= '$id' and estado=1");
	$resultadoC = mysqli_fetch_array($queryC);	
	
    $cargos=unserialize($resultadoC['cargos']);
    $html= "<option value='0'>Seleccionar Cargo</option>";	
	foreach ($cargos as $row) {
	    $list=mysqli_query($con,"select cargo from cargos where idcargo='$row' "); 
        $flist=mysqli_fetch_array($list);
		$html.= "<option value='".$row."'>".$flist['cargo']."</option>";
	}	
	echo $html;
?>