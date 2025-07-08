<?php
/**
 * @author lolkittens
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
    include "../config/config.php";

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);

    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());

    $contratista=$_POST['contratista'];
    $epp=$_POST['epp'];
    $tipo=$_POST['tipo'];
    $marca=$_POST['marca'];
    $modelo=$_POST['modelo'];
               
    $query_epp=mysqli_query($con,"insert into epp (contratista,epp,tipo,marca,modelo,creado) values ('$contratista','$epp','$tipo','$marca','$modelo','$date') ");
    
    $query =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'epp' ");
    $result= mysqli_fetch_array($query); 
    $id=$result['AUTO_INCREMENT']-1;
    
    if ($query_epp) {
                
        #subir el archivo
        if ($_FILES["archivo"]["name"]) { 
            $carpeta = '../doc/epp/'.$contratista.'/';
            $nombre=$epp."_".$contratista.".pdf";
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            $archivo=$carpeta.$nombre;
            if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo) ) {
                # guardar url contrato
                $url='doc/epp/'.$contratista.'/'.$nombre;
                $udapte_c=mysqli_query($con,"update epp set url_epp='$url' where id_epp='$id' ");
            }
        } #else {
                  # $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$idcontrato.'/';                   
                  # if (!file_exists($carpeta)) {
                  #      mkdir($carpeta, 0777, true);
                  #  } 
               # }
                
        echo 0;
    } else {
        echo 1;
    }
   
 


} else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>