<?php
session_start();
if (isset($_SESSION['usuario'])) { 
   include('../config/config.php');    
   date_default_timezone_set('America/Santiago');
   $date = date('Y-m-d H:m:s', time()); 


   $id=isset($_POST['id']) ? $_POST['id']: '';
   $contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';

   $query=mysqli_query($con,"select * from autos where id_auto='$id' ");
   $result=mysqli_fetch_array($query);
   $siglas=$result['siglas'].'-'.$result['control'];

   $sql=mysqli_query($con,"delete from vehiculos_asignados where contrato='".$contrato."' and vehiculos='$id' ");  
    
   
   if ($sql) {
       mysqli_query($con,"delete from notificaciones where trabajador='$id' and contrato='".$contrato."' ");
       mysqli_query($con,"delete from observaciones where trabajador='$id' and contrato='".$contrato."' ");
       $files=glob('../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/*.*');   
       foreach($files as $file){
          if(is_file($file))
          unlink($file);
      }
      $carpeta='../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/';       
      rmdir($carpeta);
    echo 0;
   } else {
    echo 1;
   } ;
} else { 

echo "<script> window.location.href='index.php'; </script>";
}

    
    

?>