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

    $Name = 'Reporte_contratistas_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Razon_Social;RUT;Giro;Descripcion_Giro;Nombre_Fantasia;Direccion;Administrador;Telefono;Email;Representante_Legal;RUT_Representante;Direccioin_Representante;Acreditada';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    $sSQL = "select r2.Region as region_rep2, o2.Comuna as comuna_rep2, r.Region as region, o.Comuna as comuna, c.* from contratistas as c LEFT JOIN regiones as r On r.IdRegion=c.dir_comercial_region LEFT JOIN comunas as o On o.IdComuna=c.dir_comercial_comuna LEFT JOIN regiones as r2 On r2.Idregion=c.region_rep LEFT JOIN comunas as o2 On o2.IdComuna=c.comuna_rep where c.mandante='".$_SESSION['mandante']."' order by c.id_contratista desc";
    $RsSql = mysqli_query($con,$sSQL);

$i=1;

foreach ($RsSql as $oRow) {
    $razon_social=isset($oRow['razon_social']) ? $oRow['razon_social']: '';
    $rut=isset($oRow['rut']) ? $oRow['rut']: '';
    $giro=isset($oRow['giro']) ? $oRow['giro']: '';
    $descripcion_giro=isset($oRow['descripcion_giro']) ? $oRow['descripcion_giro']: '';
    $nombre_fantasia=isset($oRow['nombre_fantasia']) ? $oRow['nombre_fantasia']: '';
    $direccion_empresa=isset($oRow['direccion_empresa']) ? $oRow['direccion_empresa']: '';
    $region=isset($oRow['region']) ? $oRow['region']: '';
    $comuna=isset($oRow['comuna']) ? $oRow['comuna']: '';
    $administrador=isset($oRow['administrador']) ? $oRow['administrador']: '';
    $fono=isset($oRow['fono']) ? $oRow['fono']: '';
    $email=isset($oRow['email']) ? $oRow['email']: '';
    $representante=isset($oRow['representante']) ? $oRow['representante']: '';
    $rut_rep=isset($oRow['rut_rep']) ? $oRow['rut_rep']: '';
    $direccion_rep=isset($oRow['direccion_rep']) ? $oRow['direccion_rep']: '';
    $region_rep=isset($oRow['region_rep2']) ? $oRow['region_rep2']: '';
    $comuna_rep=isset($oRow['comuna_rep2']) ? $oRow['comuna_rep2']: '';

    $direccion=$direccion_empresa.' Región '.$region.' Comuna '.$comuna;
    $direccion2=$direccion_rep.' Region '.$region_rep.' Comuna '.$comuna_rep;

    if ($oRow['acreditada']==0) {
        $acreditada='NO';
    } else {
        $acreditada='SI';
    }

    $Datos .= $oRow['id_contratista'].";".$razon_social.";".$rut.";".$giro.";".$descripcion_giro.";".$nombre_fantasia.";".$direccion.";".$administrador.";".$fono.";".$email.";".$representante.";".$rut_rep.";".$direccion2.";".$acreditada;
    $Datos .= "\r\n"; 
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>