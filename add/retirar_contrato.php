<?php
session_start();
if (isset($_SESSION['usuario'])) { 
   include('../config/config.php');    
   date_default_timezone_set('America/Santiago');
   $date = date('Y-m-d H:m:s', time()); 

   $query=mysqli_query($con,"select rut from trabajador where idtrabajador='".$_POST['id']."' ");
   $result=mysqli_fetch_array($query);
   $rut=$result['rut'];

   $sql=mysqli_query($con,"delete from trabajadores_asignados where contrato='".$_POST['contrato']."' and trabajadores='".$_POST['id']."' ");  
    
   
   if ($sql) {
       mysqli_query($con,"delete from notificaciones where trabajador='".$_POST['id']."' and contrato='".$_POST['contrato']."' ");
       mysqli_query($con,"delete from observaciones where trabajador='".$_POST['id']."' and contrato='".$_POST['contrato']."' ");
       $files=glob('../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$rut.'/*.*');   
       foreach($files as $file){
          if(is_file($file))
          unlink($file);
      }
      $carpeta='../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$rut.'/';       
      rmdir($carpeta);
    echo 0;
   } else {
    echo 1;
   } ;
} else { 

echo "<script> window.location.href='index.php'; </script>";
}

    
    

?>