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
$contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';
$trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
$control=isset($_POST['control']) ? $_POST['control']: '';
$siglas=$rut.'-'.$control;

#$query_na=mysqli_query($con,"select id_na from noaplica_vehiculo where contrato='$contrato' and documento='$doc' and vehiculo='$trabajador' ");
#$result_na=mysqli_fetch_array($query_na);
#$no_aplica=$result_na['id_na'];

$query=mysqli_query($con,"delete from noaplica_vehiculo where contrato='$contrato' and documento='$doc' and vehiculo='$trabajador' ");

if ($query) {

    $query_tarea=mysqli_query($con,"select * from notificaciones  where contrato='$contrato' and documento='$doc' and trabajador='$trabajador' and tipo='3' ");
    $result_tarea=mysqli_fetch_array($query_tarea);
    $perfil=$result_tarea['perfil'];
    $cargo=$result_tarea['cargo'];
    $nom_documento=$result_tarea['control'];

    $query_contrato=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
    $result_contrato=mysqli_fetch_array($query_contrato);

    $nom_contrato=$result_contrato['nombre_contrato'];

    mysqli_query($con,"delete from notificaciones where contrato='$contrato' and item='Observacion Documento Vehiculo' and trabajador='$trabajador' ");
    mysqli_query($con,"delete from notificaciones where contrato='$contrato' and item='Documento Vehiculo No Aplica' and trabajador='$trabajador' ");
    

    $query_doc=mysqli_query($con,"select documento from doc_autos where id_vdoc='$doc' ");
    $result_doc=mysqli_fetch_array($query_doc);
    $documento=$result_doc['documento'];

    $query_veh=mysqli_query($con,"select * from autos where id_auto='$trabajador' and contratista='$contratista' ");
    $result_veh=mysqli_fetch_array($query_veh);
    $vehiculo=$result_veh['tipo'].' '.$result_veh['marca'].' '.$result_veh['modelo'].' '.$result_veh['year'].' '.$result_veh['siglas'].'-'.$result_veh['control'];  

    # enviar notificacion de documento pendiente del trabajador
    $item='Documento vehiculo';                 
    $nivel=3;
    $tipo=3;
    $envia=$contratista;
    $recibe=$contratista;
    $mensaje="Enviar el documento <b>$nom_documento</b> del vehiculo/maquinaria <b>$vehiculo</b> asignado al contrato <b>$nom_contrato</b> ";
    $usuario=$_SESSION['usuario'];
    $accion="Revisar documento de vehiculo";
    $url="verificar_documentos_vehiculos_contratista.php";
                    
    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,trabajador,contrato,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$nom_documento','$doc','$trabajador','$contrato','$perfil') ");

    mysqli_query($con,"update comentarios set leer_mandante='1', leer_contratista='1', estado='1' where contrato='$contrato'and doc='$documento' and trabajador='$trabajador' and contratista='$contratista' and tipo='1'  ");
    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/';

    $archivo=$carpeta.$documento.'_'.$siglas.'.pdf';
    unlink($archivo); 
    echo 0 ;
} else {
    echo 1;
}
    
    
    

?>