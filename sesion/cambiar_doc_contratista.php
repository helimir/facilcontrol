<?php
session_start();
if (isset($_SESSION['usuario'])) { 


  $_SESSION['contratista']=$_POST['contratista'];

 } else { 
echo "<script> window.location.href='admin.php'; </script>";
}

?>