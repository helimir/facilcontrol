<?php
session_start();
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
              
        $trabajador=$_POST["trabajador"] ?? '';
        $com=$_POST["com"] ?? '';          
        $condicion=$_POST["condicion"] ?? '';
        $documento=$_POST["documento"] ?? '';
        
        #$contratista=$_POST["contratista"];
        #$mandante=$_POST["mandante"];
        #$contrato=$_POST["contrato"];
        
        $contratista=$_SESSION['contratista'] ?? '';
        $mandante=$_SESSION['mandante'] ?? '';
        $contrato=$_SESSION["contrato"] ?? '';          
        $usuario=$_SESSION['usuario'] ?? '';
               
        $query=mysqli_query($con,"select * from doc where id_doc='$documento' ");
        $result=mysqli_fetch_array($query);
            
        $sqltra=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajador' ");
        $fsqltra=mysqli_fetch_array($sqltra);
        
        $query_contrato=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
        $resul_contrato=mysqli_fetch_array($query_contrato);
        $nom_contrato=$resul_contrato['nombre_contrato'];
                
        if ($fsqltra['rut']!="") {
            $arch = $_FILES["archivo"]["name"];
            $extension = pathinfo($arch, PATHINFO_EXTENSION);
            $carpeta = '../doc/trabajadores/contratistas/'.$contratista.'/'.$contrato.'/'.$fsqltra['rut'].'/';
            if ($condicion==1) {
                $nombre=$result['documento'].'_'.$fsqltra['rut'].'.'.$extension;
                $doc=$result['documento'];
            } else {
                $nombre=$documento.'_'.$fsqltra['rut'].'.'.$extension;
                $doc=$documento;
            }    
            
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            } 
                       
            $archivo=$carpeta.$nombre;    
            
            if (file_exists($archivo)) { 
                $existe=TRUE;
            } else {
                $existe=FALSE;
            }
            
            // Cargando el fichero en la carpeta "subidas"
            if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
                
                 # si documento del trabajador es reenviado
                 #if ($existe) {
                    # pasar a procesada notificacion de ese documento recibido
                 #   $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Documento Trabajador' and documento='$doc' and contrato='$contrato' and control='$trabajador'  ");
                    
                    # pasar a procesada notificacion de ese observacion de documento
                 #   $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Observacion Documento Trabajador' and documento='$doc' and contrato='$contrato' and control='$trabajador' ");
                 #} 
                    // notificacion documento de trabajador enviado. requiere accion. control id del trabajador
                  #  $item='Documento Trabajador'; 
                  #  $nivel=3; 
                  #  $tipo=1;
                  #  $envia=$contratista;
                  #  $recibe=$mandante;
                  #  $mensaje="Revsisar documento <b>$doc</b> del contrato <b>$nom_contrato</b> ";
                  #  $accion="Revisar Documento de Trabajador";
                  #  $url="gestion_contratos.php?contratista=$contratista&contrato=$contrato";
                  #  $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$trabajador','$mandante','$contratista','$tipo','$contrato','$doc') ");
                    
                  #  $query=mysqli_query($con,"update comentarios set leer_contratista=1, leer_mandante=1 where id_com='$com' and doc='".$doc."' ");
            
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