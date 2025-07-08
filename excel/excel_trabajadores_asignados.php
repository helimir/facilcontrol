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

    $Name = 'Reporte_asignados_'.$_SESSION['contrato'].'_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Mandante;Contrato;Trabajador;RUT;Cargo;Estado';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    $sSQL = "select o.nombre_contrato, m.razon_social, a.cargos as cargos_t, a.*, t.*, c.*, a.estado as estado_asignado from trabajadores_asignados as a LEFT JOIN trabajador as t ON t.idtrabajador=a.trabajadores LEFT JOIN cargos as c ON c.idcargo=a.cargos Left Join mandantes as m On m.id_mandante=a.mandante Left Join contratos as o On o.id_contrato=a.contrato where a.contrato='".$_SESSION['contrato']."' and a.estado!=2 and t.estado=0 and a.contratista='".$_SESSION['contratista']."' ";
    $RsSql = mysqli_query($con,$sSQL);  

$i=1;

foreach ($RsSql as $oRow) {
    $mandante=isset($oRow['razon_social']) ? $oRow['razon_social']: '';
    $contrato=isset($oRow['nombre_contrato']) ? $oRow['nombre_contrato']: '';
    $nombre1=isset($oRow['nombre1']) ? $oRow['nombre1']: '';
    $apellido1=isset($oRow['apellido1']) ? $oRow['apellido1']: '';
    $rut=isset($oRow['rut']) ? $oRow['rut']: '';
    $cargo=isset($oRow['cargo']) ? $oRow['cargo']: '';
    $veri=isset($oRow['verificados']) ? $oRow['verificados']: '';

    switch ($veri) {
        case '0':$estado="GESTION DOCUMENTOS";break;
        case '1':$estado="VALIDADO";break;
        case '2':$estado="EN PROCESO";break;
    }
    $trabajador=$nombre1.' '.$apellido1;
    
    $Datos .= $mandante.";".$contrato.";".$trabajador.";".$rut.";".$cargo.";".$estado;      
    $Datos .= "\r\n"; 
    
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>