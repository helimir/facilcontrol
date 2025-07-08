<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
              
    $trabajador=$_POST["trabajador"];
    $condicion=$_POST["condicion"];
    $documento=$_POST["documento"];
                
    $contratista=$_SESSION["contratista"];
    
    $arr_doc=serialize(json_decode(stripslashes($_POST['doc'])));    
    $doc=unserialize($arr_doc);
    $cantidad=count(unserialize($arr_doc));
    $i=0;    
    for ($i=0;$i<=$cantidad-1;$i++) {   
        
        $query=mysqli_query($con,"select * from doc where id_doc='$i' ");
        $result=mysqli_fetch_array($query);
              
            $arch = $_FILES["carga"]["name"][$i];
            $extension = pathinfo($arch, PATHINFO_EXTENSION);
            $carpeta = '../doc/trabajadores/'.$contratista.'/'.$_POST['rut'].'/';
            if ($condicion==1) {
                $nombre=$result['documento'].'_'.$_POST['rut'].'.pdf';
                #$doc=$result['documento'];
            } else {
                $nombre=$result['documento'].'_'.$_POST['rut'].'.pdf';
                #$doc=$documento;
            }    
            
            if (!file_exists($carpeta)) { 
                mkdir($carpeta, 0777, true);
            } 
                       
            $archivo=$carpeta.$nombre;  
              
           $query_p=mysqli_query($con,"insert into prueba (valor,valor2,valor3,valor4) values ('$i','".$result['id_doc']."','".$result['documento']."','$cantidad') "); 
            // Cargando el fichero en la carpeta "subidas"
            if (@move_uploaded_file($_FILES["carga"]["tmp_name"][$i], $archivo)) {
               echo 0;
               
            } else {
                echo 1;
            }   
   }         
   
   $query=mysqli_query($con,"insert into trabajador_documentos_contratista (trabajador,contratista,documentos,cantidad,fecha,usuario) values ('$trabajador','".$_SESSION['contratista']."','$arr_doc','$cantidad','$date','".$_SESSION['usuario']."') ");        
    

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>