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
    $Datos = 'Contratista;Contrato;Tipo;Patente;Siglas;Marca;Modelo;Año;Fecha_revision;Chasis;Motor;Color;Puestos;Propietario;Rut_Propietario;Fono_Propietario;Email_Propietario;Estado';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    $sSQL = "select c.razon_social,n.nombre_contrato, e.verificados,  a.* from autos as a Left Join contratistas as c On c.id_contratista=a.contratista Left Join mandantes as m On m.id_mandante=c.mandante Left Join vehiculos_asignados as e On e.vehiculos=a.id_auto Left Join vehiculos_acreditados as r On r.vehiculo=a.id_auto Left Join contratos as n On n.id_contrato=e.contrato  where c.mandante='".$_SESSION['mandante']."'";
    $RsSql = mysqli_query($con,$sSQL);

$i=1;

foreach ($RsSql as $oRow) {
    #$nombre1=isset($oRow['nombre1']) ? $oRow['nombre1']: '';

    if ($row['color']=="seleccionar") {
        $color="N/A";
    } else {
        $color=$row['color'];
    } 
    
    switch ($row['verificados']) {
        case '0':$estado="GESTIONAR";break;
        case '1':$estado="VALIDADO";break;
        case '2':$estado="EN PROCESO";break;
    }
    $siglas=$oRow['siglas'].'-'.$oRow['control'];
    $Datos .= $oRow['razon_social'].";".$oRow['nombre_contrato'].";".$oRow['tipo'].";".$oRow['patente'].";".$siglas.";".$oRow['marca'].";".$oRow['modelo'].";".$oRow['year'].";".$oRow['revision'].";".$oRow['chasis'].";".$oRow['motor'].";".$oRow['color'].";".$oRow['puestos'].";".$oRow['revision'].";".$oRow['propietario'].";".$oRow['rut_propietario'].";".$oRow['fono_propietario'].";".$oRow['email_propietario'].";".$estado;
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>