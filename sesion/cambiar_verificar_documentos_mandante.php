<?php
session_start();
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    $_SESSION['verificar_id']=$_POST['id'];
    $_SESSION['verificar_cargo']=$_POST['cargo'];
    $_SESSION['verificar_contrato']=$_POST['contrato'];
    $_SESSION['verificar_mandante']=$_POST['mandante'];
    $_SESSION['verificar_perfil']=$_POST['perfil'];
    

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>