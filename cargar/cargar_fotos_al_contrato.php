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
 
    $query_t=mysqli_query($con,"select o.razon_social, c.nombre_contrato, t.url_foto as foto, t.*, a.* from trabajador as t Left Join trabajadores_asignados as a On a.trabajadores=t.idtrabajador left join contratos as c On c.id_contrato=a.contrato left join contratistas as o On o.id_contratista=a.contratista where t.idtrabajador='$trabajador' and a.contrato='$contrato' ");
    $result_t=mysqli_fetch_array($query_t);

    

    if ($query_t) {
        $origen='../doc/trabajadores/'.$contratista.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
        $destino='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
        $carpeta='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/';
        $url='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }
        $copiar=copy($origen,$destino);
        if ($copiar) {
            mysqli_query($con,"update trabajadores_asignados set verificados='2',  url_foto='".$url."' where trabajadores='$trabajador' and contrato='$contrato'  ");            
            $nom_contratista=$result_t['razon_social'];
            $nom_contrato=$result_t['nombre_contrato'];
            $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            $item='Foto Trabajador Recibido';                 
            $nivel=3;
            $tipo=2;
            $envia=$contratista;
            $recibe=$_SESSION['mandante'];
            $mensaje="El contratista <b>$nom_contratista</b> adjunto la foto del trabajador <b>$nom_trabajador</b>, contrato <b>$nom_contrato</b> para ser revisada.";
            $usuario=$_SESSION['usuario'];
            $accion="Revisar documento de contratista";
            $url="verificar_documentos_trabajador_mandante.php";
            
            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,trabajador,documento,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','Foto del trabajador','$contrato','$trabajador','Foto del trabajador','$cargo','$perfil') ");

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