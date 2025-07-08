<?php
session_start();
if (isset($_SESSION['usuario'])) { 

if ($_POST['condicion']==0) {
  $_SESSION['contratista']=$_POST['contratista'];
  $_SESSION['contrato']=$_POST['contrato'];
} else {
  $_SESSION['contrato']=$_POST['contrato'];  
}  

 } else { 
echo "<script> window.location.href='index.php'; </script>";
}

?>