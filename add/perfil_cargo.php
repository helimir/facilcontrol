<?php
include "../config/config.php"; 
session_start();

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());

$arr_perfiles=$_POST['perfiles'] ?? '';
$arr_cargos=$_POST['cargos'] ?? '';

$perfiles=serialize($arr_perfiles);
$cargos=serialize($arr_cargos);
$mandante=$_POST['mandante'] ?? '';
$contrato=$_POST['contrato'] ?? '';

$cantidad=$_POST['cantidad'] ?? '';

$query=mysqli_query($con,"select * from perfiles_cargos where mandante='$mandante' and contrato='$contrato' ");
$result=mysqli_num_rows($query);

for ($i=0;$i<=$cantidad;$i++) {
    $lista[$i]=$_POST['perfil_lista'][$i];
}
$lista_perfil=serialize($lista);

# si hay perfil_cargos 
if ($result>0) {
    
    $add=mysqli_query($con,"update perfiles_cargos set perfiles='$lista_perfil', cargos='$cargos', editado='$date' where contrato='$contrato'  ");
    $add2=mysqli_query($con,"update contratos set perfiles='$lista_perfil', cargos='$cargos', editado_contrato='$date' where id_contrato='$contrato'  ");
    mysqli_query($con,"delete from notificaciones where item='Asignar Perfiles Cargos' and contrato='$contrato'  ");
     if ($add) {
       echo '<script> window.location.href="../list_contratos.php"; </script>';
    } else {
       echo '<script> window.location.href="../list_contratos.php"; </script>';     
    }
# si no hay perfiles de cargos
} else {    
    $add=mysqli_query($con,"insert into perfiles_cargos (perfiles,cargos,mandante,contrato,creado) values ('$lista_perfil','$cargos','$mandante','$contrato','$date') ");
    
    if ($add) {
        mysqli_query($con,"update contratos set perfiles='$lista_perfil', editado_contrato='$date' where id_contrato='$contrato' ");        
        mysqli_query($con,"delete from notificaciones where item='Asignar Perfiles Cargos' and contrato='$contrato'  ");
     
        echo '<script> window.location.href="../list_contratos.php"; </script>';
        //echo 0;
    } else {
       //echo 1; 
       echo '<script> window.location.href="../list_contratos.php"; </script>';
    }
}

    

?>