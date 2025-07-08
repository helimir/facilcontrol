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

    $Name = 'Reporte_contratos_'.$fecha.'_'.$hora.'.csv';
    $FileName = "./$Name";
    $Datos = 'Id;Contrato;Mandante;Docs_Mensual;Cargos;Vehiculos';
    $Datos .= "\r\n";

    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename='.basename($Name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    
    $sSQL = "select  c.*, m.* from contratos as c LEFT JOIN mandantes as m ON m.id_mandante=c.mandante where c.contratista='".$_SESSION['contratista']."' ";
    $RsSql = mysqli_query($con,$sSQL);  

$i=1;

foreach ($RsSql as $oRow) {
    $razon_social=isset($oRow['razon_social']) ? $oRow['razon_social']: '';
    $contrato=isset($oRow['nombre_contrato']) ? $oRow['nombre_contrato']: '';
    $cargos_o=isset($oRow['cargos']) ? $oRow['cargos']: '';
    $vehiculos_o=isset($oRow['vehiculos']) ?$oRow['vehiculos']: '';

    $arr_cargos="";
    $arr_vehi="";
    
    $cargos=unserialize($cargos_o);
    $cant_cargos=count($cargos);

    $vehi=unserialize($vehiculos_o);
    $cant_vehi=count($vehi);

    if ($oRow['mensuales']==0) {
        $mensual='NO';
    } else {
        $mensual='SI';
    }

    for ($j=0;$j<=$cant_cargos-1;$j++) {
        $query_cargo=mysqli_query($con,"select * from cargos where idcargo='".$cargos[$j]."' ");
        $result_cargo=mysqli_fetch_array($query_cargo);
        $existe_cargo=mysqli_num_rows($query_cargo);
        if ($existe_cargo>0) {
            if ($j==0) {    
                $arr_cargos=$arr_cargos.$result_cargo['cargo'];
            } else {
                $arr_cargos=$arr_cargos.','.$result_cargo['cargo'];
            }                
        }
    }

    for ($v=0;$v<=$cant_vehi-1;$v++) {
        $query_vehi=mysqli_query($con,"select * from tipo_autos where id_ta='".$vehi[$v]."' ");
        $result_vehi=mysqli_fetch_array($query_vehi);
        $existe_vehi=mysqli_num_rows($query_vehi);
        if ($existe_vehi>0) {
            if ($v==0) {    
                $arr_vehi=$arr_vehi.$result_vehi['auto'];
            } else {
                $arr_vehi=$arr_vehi.','.$result_vehi['auto'];
            }                
        }
    }

    $c=0;
    #foreach ($arr_cargos as $row ) {
        $Datos .= $oRow['id_contrato'].";".$razon_social.";".$contrato.";".$mensual.";".$arr_cargos.";".$arr_vehi;      
        $Datos .= "\r\n"; 
        $c++;
    #}
    
    $i=$i+1; 
    
}#end while

//readfile($Name);
echo $Datos;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>