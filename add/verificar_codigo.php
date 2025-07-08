<?php
     session_start();
    include('../config/config.php');
    $codigo_p=isset($_POST['codigo']) ? $_POST['codigo']:'';
    $tipo=isset($_POST['tipo']) ? $_POST['tipo']:'';

    if ($tipo==1) {
        $codigo_valor=substr($codigo_p,0,3).substr($codigo_p,-3);
        $query=mysqli_query($con,"select codigo from trabajadores_acreditados where codigo='$codigo' ");
        $result=mysqli_fetch_array($query);
          
        if ($result!="") { // existe
          echo $codigo;
        } else { // actualizar verificacion
          echo 1;  
        }    
    }

    if ($tipo==2) {
      $codigo=substr($codigo_p,0,3).substr($codigo_p,-3);
      $query=mysqli_query($con,"select codigo from vehiculos_acreditados where codigo='$codigo' ");
      $result=mysqli_fetch_array($query);
        
      if ($result!="") { // existe
        echo $codigo;
      } else { // actualizar verificacion
        echo 1;  
      }    
  }

?>