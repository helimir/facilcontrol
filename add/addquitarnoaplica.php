<?php
include('../config/config.php');
date_default_timezone_set('America/Santiago');
function make_date(){
        return strftime("%Y-%m-%d H:m:s", time());
 }
$fecha =make_date();
$date = date('Y-m-d H:m:s', time());
 
$contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
$mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
$rut=isset($_POST['rut']) ? $_POST['rut']: '';
$doc=isset($_POST['doc']) ? $_POST['doc']: '';

$query_na=mysqli_query($con,"select id_na from noaplica where contratista='$contratista' and mandante='$mandante' and documento='$doc' ");
$result_na=mysqli_fetch_array($query_na);
$no_aplica=$result_na['id_na'];

$query=mysqli_query($con,"delete from noaplica where contratista='$contratista' and mandante='$mandante' and documento='$doc' ");

if ($query) {

    $query_doc=mysqli_query($con,"select documento from doc_contratistas where id_cdoc='$doc' ");
    $result_doc=mysqli_fetch_array($query_doc);
    $documento=$result_doc['documento'];
    
    #borra notificacion 
    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and id_noaplica='$no_aplica' ");
    #borrar documento subidos
    mysqli_query($con,"delete from doc_subidos_contratista where documento='$documento' and  contratista='$contratista' and mandante='$mandante' ");
        
    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/';

    $archivo=$carpeta.$documento.'_'.$rut.'.pdf';
    unlink($archivo); 
    echo 0 ;
} else {
    echo 1;
}
    
    
    

?>