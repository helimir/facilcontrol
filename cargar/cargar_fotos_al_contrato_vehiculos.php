<?php
session_start();
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');

    $trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
    $contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';
    $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
    $mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
    $cargo=isset($_POST['cargo']) ? $_POST['cargo']: '';
    $perfil=isset($_POST['perfil']) ? $_POST['perfil']: '';
    $rut=isset($_POST['rut']) ? $_POST['rut']: '';
 
    $query_t=mysqli_query($con,"select o.razon_social, c.nombre_contrato, t.*, a.* from autos as t Left Join vehiculos_asignados as a On a.vehiculos=t.id_auto left join contratos as c On c.id_contrato=a.contrato left join contratistas as o On o.id_contratista=a.contratista where t.id_auto='$trabajador' and a.contrato='$contrato' ");
    $result_t=mysqli_fetch_array($query_t);
      

    if ($query_t) {
        $origen='../doc/vehiculos/'.$contratista.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
        $destino='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
        $carpeta='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/';
        $url='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $copiar=copy($origen,$destino);
        if ($copiar) {
            mysqli_query($con,"update vehiculos_asignados set  url_foto='".$url."', verificados='2' where vehiculos='$trabajador' and contrato='$contrato'  ");            
            $nom_contratista=$result_t['razon_social'];
            $nom_contrato=$result_t['nombre_contrato'];
            $item='Foto Vehiculo Recibido';                 
            $nivel=3;
            $tipo=3;
            $envia=$contratista;
            $recibe=$_SESSION['mandante'];
            $mensaje="El contratista <b>$nom_contratista</b> adjunto la foto del vehiculo con siglas <b>$rut</b>, contrato <b>$nom_contrato</b> para ser revisada.";
            $usuario=$_SESSION['usuario'];
            $accion="Revisar documento de contratista";
            $url="verificar_documentos_vehiculos_mandante.php";
            
            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,trabajador,documento,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','Foto del vehiculo','$contrato','$trabajador','Foto del vehiculo','$cargo','$perfil') ");

            echo 0;
        } else {
            echo 1;
        }
    } else {
        echo 1;
    }

    
                             
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>