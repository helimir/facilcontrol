<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
       
        
        $fichero = $_FILES["archivo"];
        $trabajador=$_POST["trabajador"];
        $documento=$_POST["documento"];
        $com=$_POST["com"];          
        $existe=false;
        
        $query=mysqli_query($con,"select * from doc where id_doc='$documento' ");
        $result=mysqli_fetch_array($query);
            
        $sqltra=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajador' ");
        $fsqltra=mysqli_fetch_array($sqltra);
                
        if ($fsqltra['rut']!="") {
            $arch = $_FILES["archivo"]["name"];
            $extension = pathinfo($arch, PATHINFO_EXTENSION);
            $carpeta = 'doc/trabajadores/'.$fsqltra['rut'].'/';
            $nombre=$result['documento'].'_'.$fsqltra['rut'].'.'.$extension;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            } else {
                $exite=true;
            }
                       
            $archivo=$carpeta.$nombre;    
        // Cargando el fichero en la carpeta "subidas"
            if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
                echo 0;
                $query=mysqli_query($con,"update comentarios set leer_contratista=1, leer_mandante=1 where id_com='$com' and doc='".$result['documento']."' ");
                
                if ($existe==true) {
                    $query_noti=mysqli_query($con,"insert into notificacion (doc,id_contrato,creado) values ('$documento','".$_SESSION['verificar_contrato2']."','$date'"); 
                }
                
            } else {
                echo 1;
            }
        } else {
            echo 2;
        }   
    
  

} else { 

echo '<script> window.location.href="index.php"; </script>';
}
?>