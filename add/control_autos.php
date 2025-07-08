<?php
session_start();

if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==3)  ) { 

    include "../config/config.php";  

    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());

    $sigla=isset($_POST['sigla']) ? $_POST['sigla']: '';
    $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';

    $query=mysqli_query($con,"select count(*) as total from autos where contratista='$contratista' and siglas='$sigla' ");
    $result=mysqli_fetch_array($query);
    $total=$result['total']+1;
    echo $total;

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}


?>