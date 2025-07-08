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

#$query_na=mysqli_query($con,"select id_na from noaplica_trabajador where contrato='$contrato' and documento='$doc' and trabajador='$trabajador' ");
#$result_na=mysqli_fetch_array($query_na);
#$no_aplica=$result_na['id_na'];

$query=mysqli_query($con,"delete from noaplica_trabajador where contrato='$contrato' and documento='$doc' and trabajador='$trabajador' ");

if ($query) {

    $query_tarea=mysqli_query($con,"select * from notificaciones where contrato='$contrato' and documento='$doc' and trabajador='$trabajador' and tipo='2' ");
    $result_tarea=mysqli_fetch_array($query_tarea);
    $perfil=$result_tarea['perfil'];
    $cargo=$result_tarea['cargo'];
    $nom_documento=$result_tarea['control'];

    $query_contrato=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
    $result_contrato=mysqli_fetch_array($query_contrato);

    $nom_contrato=$result_contrato['nombre_contrato'];

    #mysqli_query($con,"delete from notificaciones where contrato='$contrato' and id_noaplica='$no_aplica' ");  
    mysqli_query($con,"delete from notificaciones where contrato='$contrato' and item='Observacion Documento Trabajador' and trabajador='$trabajador' ");
    mysqli_query($con,"delete from notificaciones where contrato='$contrato' and item='Documento Trabajador No Aplica' and trabajador='$trabajador' ");  


    $query_doc=mysqli_query($con,"select documento from doc where id_doc='$doc' ");
    $result_doc=mysqli_fetch_array($query_doc);
    $documento=$result_doc['documento'];

    $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajador' and contratista='$contratista' ");
    $result_t=mysqli_fetch_array($query_t);
    $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'].' RUT: '.$result_t['rut'];

    # enviar notificacion de documento pendiente del trabajador
    $item='Documento trabajador';                 
    $nivel=3;
    $tipo=2;
    $envia=$contratista;
    $recibe=$contratista;
    $mensaje="Enviar el documento <b>$nom_documento</b> del trabajador <b>$nom_trabajador</b> asignado al contrato <b>$nom_contrato</b> ";
    $usuario=$_SESSION['usuario'];
    $accion="Revisar documento de trabajador";
    $url="verificar_documentos_trabajador_contratista.php";
                            
    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,trabajador,contrato,perfil,cargo) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$nom_documento','$doc','$trabajador','$contrato','$perfil','$cargo') ");

    mysqli_query($con,"update comentarios set leer_mandante='1', leer_contratista='1', estado='1' where contrato='$contrato'and doc='$documento' and trabajador='$trabajador' and contratista='$contratista' and tipo='0'  ");
    $carpeta = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/';

    $archivo=$carpeta.$documento.'_'.$rut.'.pdf';
    unlink($archivo); 
    echo 0 ;
} else {
    echo 1;
}
    
    
    

?>