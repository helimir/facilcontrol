<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2) { 

    include('../config/config.php');
    date_default_timezone_set('America/Santiago');
    function make_date(){
            return strftime("%Y-%m-%d H:m:s", time());
    }
    $fecha =make_date();

    $date = date('Y-m-d H:m:s', time());
    
    $nombre=$_POST['nombre_perfil'] ?? '';
    $mandante=$_POST['idmandante'] ?? ''; 
    $doc=serialize($_POST['doc']); 

    $query_existe_perfil=mysqli_query($con,"select * from perfiles where nombre_perfil='$nombre' and id_mandante='$mandante'  ");
    $existe_perfiles=mysqli_num_rows($query_existe_perfil);

    if ($existe_perfiles==0) {
        $sql=mysqli_query($con,"insert into perfiles (nombre_perfil,id_mandante,doc,creado_perfil) values ('$nombre','$mandante','$doc','$date') ");
        
        if ($sql) {
            mysqli_query($con,"delete from notificaciones where item='Crear Perfiles Cargos' and mandante='$mandante' ");
            echo 0;
        } else {
            echo 1;
        } 
    } else {
        echo 2;
    }    
    
} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}    

?>