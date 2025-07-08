<?php
include "../config/config.php"; 


$id=$_POST['id'];
    $sql_accion=mysqli_query($con,"update contratos set aviso=0 where contratista='$id' ");
    if ($sql_accion) {
        echo 1;
    } else {
        echo 0;
    }



?>