<?php

session_start();
if (isset($_SESSION['usuario'])   ) {    

    include "config/config.php";      
    $rut=$_POST['rut'] ?? '';
    
    #verificar que no es solo mandante
    $query_user=mysqli_query($con,"select nivel from users where usuario='".$rut."' ");
    $result_user=mysqli_fetch_array($query_user);    
    $nivel=$result_user['nivel'];

    #si es solo mandante
    if ($nivel==2) {
        echo 2;
    } else {
        #es super admin
        if ($nivel==1) {
            echo 3;
        } else {
            $query=mysqli_query($con,"select * from contratistas where rut='".$rut."' ");
            $result=mysqli_fetch_array($query);    
      
    
            $query_c=mysqli_query($con,"select * from contratistas_mandantes where contratista='".$result['id_contratista']."' and mandante='".$_SESSION['mandante']."'  ");
            $rows=mysqli_num_rows($query_c);
            
            if ($rows==0) {
                #rut existe en la BD   
                if ($result['rut']!='' ) {
                    echo 0;
                }  else {
                    echo 4;
                }
            } else {
                echo 1; 
            }
        }
    }        
} else {
        echo '<script> window.location.href="../admin.php"; </script>';
}





    

?>