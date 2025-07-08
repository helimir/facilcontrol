<?php
session_start();
include('config/config.php');
setlocale(LC_MONETARY,"es_CL");

$valor=$_POST['valor'];

if ($valor==1) { // contratista
    $_SESSION['nivel']=3;
    $query_contratista=mysqli_query($con,"select id_contratista,mandante from contratistas  where rut='".$_POST['rut']."' and eliminar=0 "); 
    $result_contratista=mysqli_fetch_array($query_contratista); 
    $_SESSION['contratista']=$result_contratista['id_contratista'];                        
    $_SESSION['mandante']=$result_contratista['mandante'];                    
    header("Location: https://facilcontrol.cl/list_contratos_contratistas.php");
    die();
} else { // mandante
    $_SESSION['nivel']=2;
    $query_mandante=mysqli_query($con,"select id_mandante from mandantes  where rut_empresa='".$_POST['rut']."' and eliminar=0 "); 
    $result_mandante=mysqli_fetch_array($query_mandante); 
    $_SESSION['mandante']=$result_mandante['id_mandante'];
    header("Location: https://facilcontrol.cl/list_contratos.php");
    die();
}
?>