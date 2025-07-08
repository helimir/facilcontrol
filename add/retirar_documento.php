<?php
session_start();
if (isset($_SESSION['usuario']) ) {  
    include('../config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time()); 

    $rut=isset($_POST['rut']) ? $_POST['rut']: '';
    $doc=isset($_POST['doc']) ? $_POST['doc']: '';
    $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
    $mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
    $documento=isset($_POST['documento']) ? $_POST['documento']: '';

    mysqli_query($con,"delete from doc_subidos_contratista where contratista='$contratista' and mandante='$mandante' and id_documento='$doc'  ");
    mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$documento' ");
    mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido'  and control='$documento' ");
    mysqli_query($con,"delete from noaplica where documento='$doc' and contratista='$contratista' and mandante='$mandante' ");

    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/';
    $archivo=$carpeta.$documento.'_'.$rut.'.pdf';
    unlink($archivo); 


} else { 

    echo '<script> window.location.href="../admin.php"; </script>';
    }
?>