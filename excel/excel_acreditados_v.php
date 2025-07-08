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

    $Name = 'Reporte_vehiculos_acreditados_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Mandante;Contrato;Tipo;Marca;Modelo;Año;Patente;Siglas;Revision;Chasis;Motor;Puestos;Color;Propietario;Telf_Propietario;Email_Propietario';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    #header('Content-Length: ' . filesize($Name));
   
    $sSQL="select a.mandante as mandante_ta, m.razon_social as nombre_mandante, a.estado as estado_ta, a.contrato as contrato_ta, a.*, t.*, c.razon_social, o.id_contrato, o.nombre_contrato from vehiculos_acreditados as a LEFT JOIN autos as t ON t.id_auto=a.vehiculo LEFT JOIN contratistas as c ON c.id_contratista=a.contratista LEFT JOIN contratos as o ON o.id_contrato=a.contrato Left Join mandantes as m On m.id_mandante=a.mandante where a.contratista='".$_SESSION['contratista']."' and a.estado=0";
    $RsSql=mysqli_query($con,$sSQL);

$i=1;
foreach ($RsSql as $oRow) {
    $id=isset($oRow['vehiculo']) ? $oRow['vehiculo']: '';
    $mandante=isset($oRow['nombre_mandante']) ? $oRow['nombre_mandante']: '';
    $contrato=isset($oRow['nombre_contrato']) ? $oRow['nombre_contrato']: '';
    $tipo=isset($oRow['tipo']) ? $oRow['tipo']: '';
    $marca=isset($oRow['marca']) ? $oRow['marca']: '';
    $modelo=isset($oRow['modelo']) ? $oRow['modelo']: '';
    $year=isset($oRow['year']) ? $oRow['year']: '';
    $patente=isset($oRow['patente']) ? $oRow['patente']: '';
    $siglas=isset($oRow['siglas']) ? $oRow['siglas']: '';
    $revision=isset($oRow['revision']) ? $oRow['revision']: '';
    $chasis=isset($oRow['chasis']) ? $oRow['chasis']: '';
    $motor=isset($oRow['motor']) ? $oRow['motor']: '';
    $puestos=isset($oRow['puestos']) ? $oRow['puestos']: '';
    $color_v=isset($oRow['color']) ? $oRow['color']: '';
    $propietario=isset($oRow['propietario']) ? $oRow['propietario']: '';
    $fono=isset($oRow['fono_propietario']) ? $oRow['fono_propietario']: '';
    $email=isset($oRow['email_propietario']) ? $oRow['email_propietario']: '';
    
    if ($color_v="seleccionar") {
        $color="SC";
    } else {
        $color=$color;
    }

    $Datos .= $id.";".utf8_decode($mandante).";".utf8_decode($contrato).";".$tipo.";".$marca.";".$modelo.";".$year.";".$patente.";".$siglas.";".$revision.";".$chasis.";".$motor.";".$puestos.";".$color.";".$propietario.";".$fono.";".$email;
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>