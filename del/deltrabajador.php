<?php

include "../config/config.php";
  
	$idtrabajador = $_POST['idtrabajador'];
    $estado = $_POST['estado'];
	mysqli_query($con,"update trabajador set estado='$estado' WHERE idtrabajador = '".$idtrabajador."' ");
    echo $estado;
?>