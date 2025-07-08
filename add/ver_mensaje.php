<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
    include('../config/config.php');

    $_SESSION['mensaje']=$_POST['id'];
    $query=mysqli_query($con,"update mensajes set estado=1 where id_mensaje='".$_POST['id']."'  ");
    

} else { 
echo "<script> window.location.href='index.php'; </script>";
}

?>