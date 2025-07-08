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

    $Name = 'Reporte_mandantes_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Razon_Social;RUT;Giro;Descripcion_Giro;Nombre_Fantasia;Direccion;Administrador;Telefono;Email;Representante_Legal;RUT_Representante';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    $sSQL = "select r.Region, u.Comuna, m.*, c.*, o.* from contratistas_mandantes as c 
    LEFT JOIN mandantes as m ON m.id_mandante=c.mandante 
    LEFT JOIN contratos as o ON o.contratista=c.contratista
    LEFT JOIN regiones r ON r.IdRegion=m.dir_comercial_region 
    LEFT JOIN comunas u ON u.IdComuna=m.dir_comercial_comuna
    where c.contratista='".$_SESSION['contratista']."' group by c.idcm";
    $RsSql = mysqli_query($con,$sSQL);

$i=1;

foreach ($RsSql as $oRow) {
    $razon_social=isset($oRow['razon_social']) ? $oRow['razon_social']: '';
    $rut=isset($oRow['rut_empresa']) ? $oRow['rut_empresa']: '';
    $giro=isset($oRow['giro']) ? $oRow['giro']: '';
    $descripcion_giro=isset($oRow['descripcion_giro']) ? $oRow['descripcion_giro']: '';
    $nombre_fantasia=isset($oRow['nombre_fantasia']) ? $oRow['nombre_fantasia']: '';
    $direccion_empresa=isset($oRow['direccion']) ? $oRow['direccion']: '';
    $region=isset($oRow['Region']) ? $oRow['Region']: '';
    $comuna=isset($oRow['Comuna']) ? $oRow['Comuna']: '';
    $administrador=isset($oRow['administrador']) ? $oRow['administrador']: '';
    $fono=isset($oRow['fono']) ? $oRow['fono']: '';
    $email=isset($oRow['email']) ? $oRow['email']: '';
    $representante=isset($oRow['representante_legal']) ? $oRow['representante_legal']: '';
    $rut_rep=isset($oRow['rut_representante']) ? $oRow['rut_representante']: '';

    $direccion=$direccion_empresa.' Región '.$region.' Comuna '.$comuna;

    if ($oRow['acreditada']==0) {
        $acreditada='NO';
    } else {
        $acreditada='SI';
    }

    $Datos .= $oRow['id_mandante'].";".$razon_social.";".$rut.";".$giro.";".$descripcion_giro.";".$nombre_fantasia.";".$direccion.";".$administrador.";".$fono.";".$email.";".$representante.";".$rut_rep;
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>