<?php
session_start();
if (isset($_SESSION['usuario'])   ) {    
include "../config/config.php";
    
    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
    
    $query=mysqli_query($con,"select * from trabajador where rut='".$_POST['rut']."' ");
    $result=mysqli_fetch_array($query);
    if ($query) {
        
        $query=mysqli_query($con,"insert into trabajador (nombre1,nombre2,apellido1,apellido2,rut,direccion1,direccion2,region,comuna,telefono,email,dia,mes,ano,fnacimiento,estadocivil,tpantalon,tpolera,tzapatos,cargo,tipocargo,licencia,tipolicencia,fecha,observacion,banco,cuenta,tipocuenta,afp,salud,pcontrato1,pcontrato2,turno,contratista) values
        ('".$result['nombre1']."','".$result['nombre2']."','".$result['apellido1']."','".$result['apellido2']."','".$result['rut']."','".$result['direccion1']."','".$result['direccion2']."','".$result['region']."','".$result['comuna']."','".$result['telefono']."','".$result['email']."','".$result['dia']."','".$result['mes']."','".$result['ano']."','".$result['fnacimiento']."','".$result['estadocivil']."','".$result['tpantalon']."','".$result['tpolera']."','".$result['tzapatos']."','".$result['cargo']."','".$result['tipocargo']."','".$result['licencia']."','".$result['tipolicencia']."','".$result['fecha']."','".$result['observacion']."','".$result['banco']."','".$result['cuenta']."','".$result['tipocuenta']."','".$result['afp']."','".$result['salud']."','".$result['pcontrato1']."','".$result['pcontrato2']."','".$result['turno']."','".$_SESSION['contratista']."') ");
 
        $query=mysqli_query($con,"delete from notificaciones where item='Crear trabajadores' and contratista='".$_SESSION['contratista']."' ");
 
        $query_id=mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'trabajador' ");
        $result_id= mysqli_fetch_array($query_id); 
        $id=$result_id['AUTO_INCREMENT']-1;
 
        #$query=mysqli_query($con,"insert into trabajador_contratista (id_trabajador,id_contratista) values ('$id','".$_SESSION['contratista']."') ");
        
        $carpeta = '../doc/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/';
        mkdir($carpeta, 0777, true);
        
        
        echo 0; 
    } else {
        echo 1;
    }        

} else { 
echo '<script> window.location.href="../admin.php"; </script>';
}

?>