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
$documento=isset($_POST['documento']) ? $_POST['documento']: ''; 
$rut=isset($_POST['rut']) ? $_POST['rut']: ''; 
$tipo=isset($_POST['tipo']) ? $_POST['tipo']: '';

if ($tipo==1) {
        $query_na=mysqli_query($con,"select id_na from noaplica where contratista='".$_POST['contratista']."' and mandante='".$_POST['mandante']."' and extra='".$_POST['documento']."' ");
        $result_na=mysqli_fetch_array($query_na);
        $no_aplica=$result_na['id_na']; 

        #borrar no aplica
        $query=mysqli_query($con,"delete from noaplica where contratista='".$_POST['contratista']."' and mandante='".$_POST['mandante']."' and extra='".$_POST['documento']."' ");

        if ($query) {

            #borrar notificacion de no aplica extra
            $query_tarea=mysqli_query($con,"delete from notificaciones where contratista='".$_POST['contratista']."' and id_noaplica='$no_aplica' ");
            mysqli_query($con,"delete from doc_subidos_contratista where  contratista='".$_POST['contratista']."' and mandante='".$_POST['mandante']."' and documento='".$_POST['documento']."' ");

            $carpeta = '../doc/temporal/'.$_POST['mandante'].'/'.$_POST['contratista'].'/';

            $archivo=$carpeta.$documento.'_'.$_POST['rut'].'.pdf';
            unlink($archivo); 
            echo 0 ;
        } else {
            echo 1;
        }    
}    

if ($tipo==2) {
    $trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
    $contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';

    $query_na=mysqli_query($con,"select id_na from noaplica where contratista='$contratista' and mandante='$mandante' and extra='$documento' and contrato='$contrato' and trabajador='$trabajador' ");
    $result_na=mysqli_fetch_array($query_na);
    $no_aplica=$result_na['id_na'];

    #borrar no aplica
    $query=mysqli_query($con,"delete from noaplica where contratista='".$_POST['contratista']."' and mandante='".$_POST['mandante']."' and extra='".$_POST['documento']."' and contrato='$contrato' and trabajador='$trabajador' ");

    if ($query) {

        #borrar notificacion de no aplica extra
        $query_tarea=mysqli_query($con,"delete from notificaciones where contratista='".$_POST['contratista']."' and id_noaplica='$no_aplica' ");
        mysqli_query($con,"delete from doc_subidos_contratista where  contratista='".$_POST['contratista']."' and mandante='".$_POST['mandante']."' and documento='".$_POST['documento']."' and contrato='$contrato' and trabajador='$trabajador' ");

        $query_trab=mysqli_query($con,"select c.nombre_contrato, a.codigo, t.rut, t.nombre1, t.apellido1 from trabajadores_acreditados as a LEFT JOIN trabajador as t On t.idtrabajador=a.trabajador Left join contratos as c On c.id_contrato=a.contrato where a.trabajador='$trabajador' and a.contrato='$contrato' and a.estado!='2' ");
        $result_trab=mysqli_fetch_array($query_trab);
        
        $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/';

        $archivo=$carpeta.$documento.'_'.$result_trab['rut'].'.pdf';
        unlink($archivo); 
        echo 0 ;
    } else {
        echo 1;
    }  

}

?>