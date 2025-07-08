<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
              
    $trabajador=$_POST["trabajador"];
    $condicion=$_POST["condicion"];
                
    $contratista=$_SESSION["contratista"];
    
    $arr_doc=serialize(json_decode(stripslashes($_POST['doc'])));    
    $doc=unserialize($arr_doc);
    $cantidad=count(unserialize($arr_doc));
    $i=0;    
    for ($i=0;$i<=$_POST["cant"]-1;$i++) {   
        
        $query=mysqli_query($con,"select * from doc where id_doc='".$doc[$i]."' ");
        $result=mysqli_fetch_array($query);
              
            $arch = $_FILES["carga"]["name"][$i];
            $extension = pathinfo($arch, PATHINFO_EXTENSION);
            $carpeta = 'doc/trabajadores/'.$contratista.'/'.$_POST['rut'].'/';
            if ($condicion==1) {
                $nombre=$result['documento'].'_'.$_POST['rut'].'.pdf';
            } else {
                $nombre=$result['documento'].'_'.$_POST['rut'].'.pdf';
            }    
            
            if (!file_exists($carpeta)) { 
                mkdir($carpeta, 0777, true);
            } 
                       
           $archivo=$carpeta.$nombre;  

           $query_tdc=mysqli_query($con,"select documento from documentos_trabajador_contratista where trabajador='$trabajador' and  contratista='$contratista' and documento='".$doc[$i]."' ");
           $existe_tdc=mysqli_num_rows($query_tdc);
              
           
            // Cargando el fichero en la carpeta "subidas"
           if ($doc[$i]!="") {  
                if (@move_uploaded_file($_FILES["carga"]["tmp_name"][$i], $archivo)) {
                    # si documento no existe agregar
                    if ($existe_tdc==0) {
                        $query=mysqli_query($con,"insert into documentos_trabajador_contratista (trabajador,contratista,documento,fecha,usuario) values ('$trabajador','".$_SESSION['contratista']."','$doc[$i]','$date','".$_SESSION['usuario']."') ");
                    # si existe actualizar fecha edicion y usuario    
                    } else {
                        $query=mysqli_query($con,"update documentos_trabajador_contratista set fecha_editado='$date', usuario='".$_SESSION['usuario']."' where contratista='$contratista' and documento='$doc[$i]' and trabajador='$trabajador' ");
                    }    

                    echo 0;
                
                } else {
                    echo 1;
                }  
            }         
   }         
   
   #$query_tdc=mysqli_query($con,"select documentos from trabajador_documentos_contratista where contratista='$contratista' ");
   #$result_tdc=mysqli_fetch_array($query_tdc);
   #$existe_contratista=mysqli_num_rows($query_tdc);

   #if ($existe_contratista==0) {
        #$query=mysqli_query($con,"insert into trabajador_documentos_contratista (trabajador,contratista,documentos,cantidad,fecha,usuario) values ('$trabajador','".$_SESSION['contratista']."','$arr_doc','$cantidad','$date','".$_SESSION['usuario']."') ");        
   #} else {
   #     $k=0;
   #     $arreglo_documentos=unserialize($result_tdc['documentos']);
   #     $cantidad_doc_existente=count($arreglo_documentos);
   #     $posicion_final=$cantidad_doc_existente-1;
   #     for ($j=$posicion_final;$cantidad-1;$j++) {
   #         $arreglo_documentos[$j]=$doc[$k];
   #         $k++;    
   #     }
   #     $doc_serialize=serialize($arreglo_documentos);
   #     $update=mysqli_query($con,"update trabajador_documentos_contratista set documentos=$doc_serialize where contratista='$contratista' ");
   # }    
    

} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
?>