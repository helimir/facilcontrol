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

    $Name = 'Reporte_vehiculos_maquinaria_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Tipo;Marca;Modelo;Año;Patente;Siglas;Chasis;Motor;Color;Puestos;Fecha_Revisión;Propietario;Rut_Propietario;Fono_Propietario;Email_Propietario';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    $sSQL = "select * from autos where contratista='".$_SESSION['contratista']."' order by id_auto desc";
    $RsSql = mysqli_query($con,$sSQL);

$i=1;

foreach ($RsSql as $oRow) {
    $nombre1=isset($oRow['nombre1']) ? $oRow['nombre1']: '';
    $apellido1=isset($oRow['apellido1']) ? $oRow['apellido1']: '';
    $direccion1=isset($oRow['direccion1']) ? $oRow['direccion1']: '';
    $direccion2=isset($oRow['direccion2']) ? $oRow['direccion2']: '';
    $region=isset($oRow['region']) ? $oRow['region']: '';
    $comuna=isset($oRow['comuna']) ? $oRow['comuna']: '';
    $dia=isset($oRow['dia']) ? $oRow['dia']: '';
    $mes=isset($oRow['mes']) ? $oRow['mes']: '';
    $year=isset($oRow['year']) ? $oRow['year']: '';

    $trabajador=$nombre1.' '.$apellido1;
    $direccion=$direccion1.' '.$direccion2.' Region '.$region.' Comuna '.$comuna;
    $fecha_nac=$dia.'-'.$mes.'-'.$year;

    $Datos .= $oRow['id_auto'].";".$oRow['tipo'].";".$oRow['marca'].";".$oRow['modelo'].";".$oRow['year'].";".$oRow['patente'].";".$oRow['siglas'].";".$oRow['chasis'].";".$oRow['motor'].";".$oRow['color'].";".$oRow['puestos'].";".$oRow['revision'].";".$oRow['propietario'].";".$oRow['rut_propietario'].";".$oRow['fono_propietario'].";".$oRow['email_propietario'];
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>