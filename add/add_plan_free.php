<?php

/**
 * @author lolkittens
 * @copyright 2022
 */

session_start(); 
include('../config/config.php');

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());
$fecha_actual = date("Y-m-d");

$dia=date('d');
$mes=date('m');
$year=date('Y');

$query_contratista=mysqli_query($con,"select d.mandante as idmandante, c.estado as estado_contratista, c.*, p.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista left join contratistas_mandantes as d On d.contratista=c.id_contratista where c.id_contratista='".$_POST['id']."' and d.eliminar=0 "); 
$result_contratista=mysqli_fetch_array($query_contratista);

# cambia la contratista a estado activo
$update_query_e=mysqli_query($con,"update contratistas set estado=0 where id_contratista='".$result_contratista['id_contratista']."' ");

if ($update_query_e) {

    # actualiza plan y monto de pago
    $update_query_p=mysqli_query($con,"update pagos set plan=1, monto=0 where idcontratista='".$result_contratista['id_contratista']."' ");

    $_SESSION['contratista']=$result_contratista['id_contratista'];
    $_SESSION['estado']=$result_contratista['estado_contratista'];
                            
                            
    if ($result_contratista['multiple']==0) {
        $_SESSION['mandante']=$result_contratista['idmandante'];
    } else {
        $_SESSION['multiple']=$result_contratista['multiple'];
        $_SESSION['mandante']=0; 
    };   
    
    echo 0;

} else {
    echo 1;
}

?>