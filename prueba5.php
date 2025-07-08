
<?php
include ('config/config.php');

$fecha=date("2023-09-01");
                                        
$nuevafecha = strtotime('-1 months', strtotime($fecha));
$nuevafecha = date('Y-m' , $nuevafecha);
$mes=substr($nuevafecha,5,2);
$year=substr($nuevafecha,0,4);



$query_t=mysqli_query($con,"select trabajador from trabajadores_acreditados where contrato='33' and estado!='2' and creado like'%$nuevafecha%' ");
$result_t=mysqli_fetch_array($query_t);
$cant_trab=mysqli_num_rows($query_t);

foreach ($query_t as $row) {
                                
    $query_ta=mysqli_query($con,"select * from trabajador where idtrabajador='".$row['trabajador']."' ");
    $result_ta=mysqli_fetch_array($query_ta);
    $trabajador=$result_ta['nombre1'].' '.$result_ta['apellido1'];
    echo $trabajador.'<br>';
    
}

$query_o=mysqli_query($con,"select c.*, m.documentos from contratos as c left join mensuales as m On m.contratista=c.contratista where c.mensuales='1' and c.contratista='191' ");
$result_o=mysqli_fetch_array($query_o);
$documento=unserialize($result_o['documentos']);
$num_d=count(unserialize($result_o['documentos']));

echo '<br>';
echo 'Fecha Actual:'.$fecha.'<br>';
echo 'Mes anterior:'.$nuevafecha.'<br>';
echo 'trabajadores: '.$cant_trab.'<br>';
echo '# doc: '.$num_d.'<br>';
echo 'my y año anterio: '.$mes.'-'.$year.'<br>';


?>