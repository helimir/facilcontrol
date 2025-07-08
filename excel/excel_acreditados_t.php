<?php
session_start();
if (isset($_SESSION['usuario'])  ) { 
    require ('../config/config.php');
    
    ini_set('date.timezone','America/Santiago'); 
    $hora=date("H-i-s");

    function make_date(){
            return strftime("%d-%m-%Y", time());
    }
    $fecha =make_date();

    $Name = 'Reporte_trabajadores_acreditados_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Trabajador;RUT;Cargo;Codigo;Validez;Fecha_Acreditacion;Contrato;Mandante';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    #header('Content-Length: ' . filesize($Name));
    
    #$sSQL = "select t.* from trabajador as t LEFT JOIN contratistas_mandantes as cm On cm.mandante=t.mandante where t.contratista='".$_SESSION['contratista']."' order by t.idtrabajador desc";
    #$RsSql = mysqli_query($con,$sSQL);

    $sSQL="select a.mandante as mandante_ta, m.razon_social as nombre_mandante, g.cargo as cargo_t, a.estado as estado_ta, a.*, t.*, c.razon_social, o.id_contrato, o.nombre_contrato from trabajadores_acreditados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajador LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato Left Join cargos as g On g.idcargo=a.cargo Left Join mandantes as m On m.id_mandante=a.mandante where a.contratista='".$_SESSION['contratista']."' and t.estado=0";
    $RsSql=mysqli_query($con,$sSQL);

$i=1;

foreach ($RsSql as $oRow) {
    $id=isset($oRow['trabajador']) ? $oRow['trabajador']: '';
    $nombre1=isset($oRow['nombre1']) ? $oRow['nombre1']: '';
    $apellido1=isset($oRow['apellido1']) ? $oRow['apellido1']: '';
    $rut=isset($oRow['rut']) ? $oRow['rut']: '';
    $cargo=isset($oRow['cargo_t']) ? $oRow['cargo_t']: '';
    $codigo=isset($oRow['codigo']) ? $oRow['codigo']: '';
    $validez=isset($oRow['validez']) ? $oRow['validez']: '';
    $nombre_contrato=isset($oRow['nombre_contrato']) ? $oRow['nombre_contrato']: '';
    $mandante=isset($oRow['nombre_mandante']) ? $oRow['nombre_mandante']: '';
    $fecha=isset($oRow['creado']) ? $oRow['creado']: '';

    $fecha_a=substr($fecha,0,10);
    $trabajador=$nombre1.' '.$apellido1;
    

    $Datos .= $id.";".utf8_decode($trabajador).";".$rut.";".($cargo).";".$codigo.";".$validez.";".$fecha_a.";".$nombre_contrato.";".$mandante;
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>