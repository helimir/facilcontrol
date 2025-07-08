<?php

session_start();
if (isset($_SESSION['usuario'])   ) {    
include "../config/config.php";
    
    # verificar que el trabajador este en su lista
    $query=mysqli_query($con,"select * from trabajador where rut='".$_POST['rut']."' and contratista='".$_SESSION['contratista']."' ");
    $result=mysqli_fetch_array($query);    
    
    # si esta el trabajador en la contratista
    if ($result['rut']!='') {
       echo 1;
    } else {
        # verificar que trabajador este en f<cil control
        $query2=mysqli_query($con,"select count(*) as total from trabajador where rut='".$_POST['rut']."'  ");
        $result2=mysqli_fetch_array($query2); 
        
        if ($result2['total']>0) {
            echo 0;
       } else {
            echo 2; 
       } 
    }
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
    

?>