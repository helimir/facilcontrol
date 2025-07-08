<?php

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2  ) { 
include "../config/config.php"; 

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());
$fecha_actual = date("Y-m-d");

$contratista=$_POST['contratista_dm'];
$contrato=$_POST['contrato_dm'];
$mandante=$_POST['mandante_dm'];
$condicion=$_POST['condicion_dm'];
$documentos=serialize($_POST['doc_mensuales_dm']);

  // nuevo registro
  if ($condicion==0) {  
        
        $query=mysqli_query($con,"insert into mensuales (documentos,contratista,mandante,contrato,creado,user) values ('".$documentos."','$contratista','$mandante','$contrato','$date','".$_SESSION['usuario']."') ");

        $query=mysqli_query($con,"update contratos set  mensuales='1' where id_contrato='$contrato' ");
        echo 0;
   } 
   # deshabilitar registro
   if ($condicion==1) {
           $update=mysqli_query($con,"update contratistas set mensuales='0' where id_contratista='$contratista' ");
           echo 2;
   }
   # habilitar registro existente
   if ($condicion==2) {
           $update=mysqli_query($con,"update contratistas set mensuales='1' where id_contratista='$contratista' ");
           echo 2;
   }

   // actualizar registro
  if ($condicion==3) {  
    $query=mysqli_query($con,"update mensuales set documentos='$documentos' where contrato='$contrato' ");
    if ($query) {
        echo 4;
    } else {
        echo 1;
    } 
} 

} else { 

    echo "<script> window.location.href='admin.php'; </script>";
}

?>