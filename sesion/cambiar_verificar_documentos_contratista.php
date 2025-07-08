<?php
session_start();
if (isset($_SESSION['usuario']) ) {   
    
    $_SESSION['verificar_id2']=$_POST['id'];
    $_SESSION['verificar_cargo2']=$_POST['cargo'];
    $_SESSION['verificar_contrato2']=$_POST['contrato'];
    $_SESSION['verificar_perfil2']=$_POST['perfil'];
    $_SESSION['verifica_contratista']=$_POST['contratista'];
    

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>