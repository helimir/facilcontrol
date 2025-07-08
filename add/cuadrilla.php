<?php

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3  ) { 
    include "../config/config.php"; 

    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    $fecha_actual = date("Y-m-d");

    $cuadrilla=$_POST['cuadrilla'];
    $contratista=$_POST['contratista'];
    $nombre_contrato=$_POST['nombre_contrato'];
    $contrato=$_POST['contrato'];
    $mandante=$_POST['mandante'];
    $lider=$_POST['lider'];
    
    $trabajadores=serialize(json_decode(stripslashes($_POST['trabajadores'])));
    $cantidad=count(json_decode(stripslashes($_POST['trabajadores'])));

    $query=mysqli_query($con,"insert into cuadrillas (cuadrilla,trabajadores,cantidad,lider,nombre_contrato,contrato,contratista,mandante,creado) values ('$cuadrilla','$trabajadores','$cantidad','$lider','$nombre_contrato','$contrato','$contratista','$mandante','$date') ");
    if ($query) {
        echo 0;
    } else {
        echo 1;
    }

} else {
    echo '<script> window.location.href="admin.php"; </script>';
}

?>