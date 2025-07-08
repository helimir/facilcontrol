<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
              
    $vehiculo=isset($_POST['vehiculo']) ? $_POST['vehiculo']: '';
    $patente=isset($_POST['patente']) ? $_POST['patente']: '';
    $contratista=$_SESSION["contratista"];
    
    $arr_doc=serialize(json_decode(stripslashes($_POST['doc'])));    
    $doc=unserialize($arr_doc);
    $cantidad=count(unserialize($arr_doc));
    $i=0;    
    for ($i=0;$i<=$_POST["cant"]-1;$i++) {   
        
        $query=mysqli_query($con,"select * from doc_autos where id_vdoc='".$doc[$i]."' ");
        $result=mysqli_fetch_array($query);
              
            $arch = $_FILES["carga"]["name"][$i];
            $extension = pathinfo($arch, PATHINFO_EXTENSION);
            $carpeta = 'doc/vehiculos/'.$contratista.'/'.$patente.'/';
            $nombre=$result['documento'].'_'.$patente.'.pdf';                
            
            if (!file_exists($carpeta)) { 
                mkdir($carpeta, 0777, true);
            } 
                       
           $archivo=$carpeta.$nombre;  

           $query_tdc=mysqli_query($con,"select documento from documentos_vehiculo_contratista where vehiculo='$vehiculo' and contratista='$contratista' and documento='".$doc[$i]."' ");
           $existe_tdc=mysqli_num_rows($query_tdc);
              
           
            // Cargando el fichero en la carpeta "subidas"
           if ($doc[$i]!="") {  
                if (@move_uploaded_file($_FILES["carga"]["tmp_name"][$i], $archivo)) {                    
                    # si documento no existe agregar
                    if ($existe_tdc==0) {
                        $query=mysqli_query($con,"insert into documentos_vehiculo_contratista (vehiculo,contratista,documento,fecha,usuario) values ('$vehiculo','".$_SESSION['contratista']."','$doc[$i]','$date','".$_SESSION['usuario']."') ");
                    # si existe actualizar fecha edicion y usuario    
                    } else {
                        $query=mysqli_query($con,"update documentos_vehiculo_contratista set fecha_editado='$date', usuario='".$_SESSION['usuario']."' where contratista='$contratista' and documento='$doc[$i]' and vehiculo='$vehiculo' ");
                    }    

                    echo 0;
                
                } else {
                    echo 1;
                }  
            }         
   }         
   
    

} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
?>