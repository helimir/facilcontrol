<?php
session_start();
if (isset($_SESSION['usuario'])   ) {    
    include "../config/config.php";      
    
    $query_u=mysqli_query($con,"select * from users where usuario='".$_POST['rut']."' and nivel!='3' ");
    $result_u=mysqli_fetch_array($query_u);

    if ($result_u['nivel']==4) {
            echo 5;
    } else {
        if ($_SESSION['usuario']==$_POST['rut']) {
            echo 4;
        } else {
    
            if ($result_u['usuario']=='') {
                $query=mysqli_query($con,"select * from contratistas where rut='".$_POST['rut']."' ");
                $result=mysqli_fetch_array($query);    
                        
                if ($result['id_contratista']=='') { 
                    echo 2;
                } else {
                    $query_c=mysqli_query($con,"select * from contratistas_mandantes where contratista='".$result['id_contratista']."' and mandante='".$_SESSION['mandante']."'  ");
                    $rows=mysqli_num_rows($query_c);
                            
                    if ($rows==0) {   
                        if ($result['rut']!='' ) {
                            echo 0;                  
                        } else {
                            echo 1; 
                        }
                    }
                }        
            } else {            
                $query_m=mysqli_query($con,"select count(*) as total from mandantes where rut_empresa='".$_POST['rut']."'  ");
                $resul_m=mysqli_fetch_array($query_m);
                if ($resul_m['total']>0) {
                    echo 3;
                } 
            }
        }
    }

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
    

?>