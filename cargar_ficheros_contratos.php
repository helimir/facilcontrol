<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    
    
    $nombre_contrato=$_POST["nombre_contrato"];
    $mandante=$_POST["mandante"];
                
    $carpeta = 'contratos/'.$mandante.'/';
    $nombre=$nombre_contrato.".pdf";
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }
    $archivo=$carpeta.$nombre;
    @move_uploaded_file($_FILES["contrato"]["tmp_name"], $archivo);
        

} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
?>