<?php 
session_start();
if (isset($_SESSION['usuario']) ) {

include('config/config.php');
$_SESSION['idperfil']=$_POST['idperfil'];
    
    if ($_POST['accion']=="actualizar") {
        
        date_default_timezone_set('America/Santiago');        
        $date = date('Y-m-d H:m:s', time());
        $nombre=$_POST['nombre_perfil'];
        $doc=serialize($_POST['doc']);
        $sql=mysqli_query($con," update perfiles set nombre_perfil='$nombre', doc='$doc' where id_perfil='".$_POST['idperfil']."' ");
        
        if ($sql) {
            echo 0;
        } else {
            echo 1;
        }      
   }

} else {
    echo '<script> window.location.href="index.php"; </script>';
}    

?>