<?php
session_start();
if (isset($_SESSION['usuario'])) { 
    include('../config/config.php');
    
    $cargo=isset($_POST['cargo']) ? $_POST['cargo']: '';
    $mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';

    $query=mysqli_query($con,"insert into cargos_asignados (cargo,mandante) values ($cargo,$mandante) ");
    if ($query) {
        echo 0;
    } else {
        echo 1;
    }


} else { 
    echo "<script> window.location.href='admin.php'; </script>";
}
?>