<?php

session_start();
if (isset($_SESSION['usuario'])) { 
    
    include('../config/config.php');    
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    
   $contratista=$_SESSION['contratista'];
   $mandante=$_SESSION['mandante'];
   $contrato=$_SESSION['contrato'];;
   $user=$_SESSION['usuario']; 
              
   
   
         
   $query_existe=mysqli_query($con,"select * from trabajadores_asignados where contrato='$contrato'  ");   
   $result_existe=mysqli_fetch_array($query_existe);  
   $existe=mysqli_num_rows($query_existe);
   
   if ($existe==0) {
    
       $j=0; 
       foreach ($_POST['cargos'] as $row) {
        if ($row!="0") {
            $lista_cargos[$j]=$row;
            $j++;
        }    
       } 
       
       $trabajadores=serialize($_POST['trabajador']);
       $cargos=serialize($lista_cargos);
      
       $sql=mysqli_query($con,"insert into trabajadores_asignados (trabajadores,cargos,contrato,mandante,creado,user,contratista) values 
       ('$trabajadores','$cargos','$contrato','$mandante','$date','$user','$contratista') ");
       
       if ($sql) {
           $query=mysqli_query($con,"update notificaciones set procesada=1 where item='Contrato Asignado' and contratista='$contratista' and mandante='$mandante' ");
           echo 0;
       } else {
           echo 1;
       } 
       
   } else {
     
      $trabajadores_actual=unserialize($result_existe['trabajadores']);
      $cargos_actual=unserialize($result_existe['cargos']);
      
      $cant_trab_actual=count($trabajadores_actual);
      $cant_cargo_actual=count($cargos_actual);
      
      $trabajadores_nuevos=$_POST['trabajador'];
      $cargos_nuevos=$_POST['cargos'];
     
      $j=$cant_trab_actual; 
      foreach ($_POST['trabajador'] as $row) {
            $trabajadores_actual[$j]=$row;
            $j++;
      }
      
      $j=0; 
       foreach ($_POST['cargos'] as $row) {
        if ($row!="0") {
            $lista_cargos[$j]=$row;
            $j++;
        }    
       } 
      $j=$cant_trab_actual;  
      foreach ($lista_cargos as $row) {
            $cargos_actual[$j]=$row;
            $j++;
      }
      
      $trabajadores=serialize($trabajadores_actual);
      $cargos=serialize($cargos_actual);
      
      $sql=mysqli_query($con,"update trabajadores_asignados set trabajadores='$trabajadores', cargos='$cargos', estado=1 where contrato='$contrato' ");
      if ($sql) {
        echo 2;
       } else {
        echo 3;
       } ;  
   }    
   
} else { 

echo "<script> window.location.href='index.php'; </script>";
}

    
    

?>