<?php
 session_start();
if (isset($_SESSION['usuario'])) { 
    include('../config/config.php');
   
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    
    $id=$_POST['id'];
    $contrato=$_POST['contrato'];
    $mandante=$_POST['mandante'];
    $cargo=$_POST['cargo'];
    $doc=$_POST['doc'];
    $user=$_SESSION['usuario'];
    
    
    
    $query=mysqli_query($con,"select * from documentos_verificados where contrato='$contrato' and mandante='$mandante' and trabajador='$id' and doc='$doc' and cargo='$cargo' ");
    $result=mysqli_num_rows($query);
        
    if ($result==0) { // nueva verificacion
        $sql=mysqli_query($con,"insert into documentos_verificados (trabajador,contrato,mandante,doc,cargo,creado,user) values ('$id','$contrato','$mandante','$doc','$cargo','$date','$user')   ");        
        if ($sql) {
            echo 0;
        } else {
            echo 1;
        }
    } else { // actualizar verificacion
        
    }    

} else { 

echo "<script> window.location.href='index.php'; </script>";
}

?>