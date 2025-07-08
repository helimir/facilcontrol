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

    $Name = 'Reporte_trabajadores_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Trabajador;RUT;Direccion;Email;Telefono;Fecha_Nac;Estado_Civil;Pantalon;Polera;Zapatos;Licencia;Tipo_Licencia;Banco;Tipo_Cuenta;Cuenta;AFP;Salud';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    #header('Content-Length: ' . filesize($Name));
    
    $sSQL="select t.* , r.Region, c.Comuna, b.banco, f.afp, s.institucion, o.razon_social 
    from trabajador t 
    LEFT JOIN regiones r ON r.IdRegion=t.region 
    LEFT JOIN comunas c ON c.IdComuna=t.comuna
    LEFT JOIN bancos b ON b.idbanco=t.banco
    LEFT JOIN afp f ON f.idafp=t.afp
    LEFT JOIN salud s ON s.idsalud=t.salud 
    LEFT JOIN contratistas o On o.id_contratista=t.contratista
    LEFT JOIN mandantes m On m.id_mandante=o.mandante
    where t.contratista='".$_SESSION['contratista']."' and t.estado=0  order by t.idtrabajador";
    $RsSql=mysqli_query($con,$sSQL);

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
    $year=isset($oRow['ano']) ? $oRow['ano']: '';
    $pantalon=isset($oRow['tpantalon']) ? $oRow['tpantalon']: '';
    
    $trabajador=$nombre1.' '.$apellido1;
    $direccion=$direccion1.' '.$direccion2.' Region '.$region.' Comuna '.$comuna;
    $fecha_nac=$dia.'-'.$mes.'-'.$year;

    $Datos .= $oRow['idtrabajador'].";".utf8_decode($trabajador).";".$oRow['rut'].";".utf8_decode($direccion).";".$oRow['email'].";".$oRow['telefono'].";".$fecha_nac.";".$oRow['estadocivil'].";".$pantalon.";".$oRow['tpolera'].";".$oRow['tzapatos'].";".$oRow['licencia'].";".$oRow['tipolicencia'].";".$oRow['banco'].";".$oRow['tipocuenta'].";".$oRow['cuenta'].";".$oRow['afp'].";".$oRow['salud'];
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>