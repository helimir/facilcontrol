<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');
    $contratista=$_POST['contratista'];
    $rut=$_POST['rut'];
    
    $image = getimagesize($_FILES["foto"]["tmp_name"]);
    $maximum = array(
        'width' => '400',
        'height' => '400'
    );
    $minimum = array(
        'width' => '200',
        'height' => '200'
    );
    $image_width = $image[0];
    $image_height = $image[1];
   // if (  $image_width > $maximum['width'] || $image_height > $maximum['height'] ||  $image_width < $minimum['width'] || $image_height < $minimum['height']  ) {
      //  echo 2;
    //} else {    
            if(!$_FILES["foto"]["error"]>0){
                        $permitidos = array('image/jpeg', 'image/png', 'image/jpg');
                        $limite_kb = 1000;                		
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);                        
                        if(in_array($_FILES["foto"]["type"], $permitidos) ) {
                        
                        #if ($extension=="jfif") {
                        #    $extension="jpg";
                        #}    
                        $extension="jpg";
                        if ($_POST['opcion']==1) {
                            $carpeta = '../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/';
                            $nombre='foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.'.$extension;
                            $url='doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/'.$nombre;
                        } else {

                            $carpeta = '../img/trabajadores/'.$contratista.'/'.$rut.'/';   
                            $nombre='foto_'.$contratista.'_'.$rut.'.'.$extension; 
                            $url='img/trabajadores/'.$contratista.'/'.$rut.'/'.$nombre;

                        }    
                  		$archivo = $carpeta.$nombre;
                  		if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }
                  		$resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo);
                  		if($resultado){
                  		       if ($_POST['opcion']==1) {
                                    $sqla=mysqli_query($con,"update trabajadores_asignados set  url_foto='$url' where trabajadores='".$_POST['trabajador']."' and contrato='".$_POST['contrato']."'  ");
                               } else {
                                    $sqla=mysqli_query($con,"update trabajador set  url_foto='$url' where rut='".$rut."' and contratista='$contratista'  ");
                            
                                }
                            # si no habia en la contratista       
                            if ($_POST['control']==1) {
                                $url_c='img/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.jpg';
                                $query_c=mysqli_query($con,"update trabajador set url_foto='$url_c' where idtrabajador='".$_POST['trabajador']."'  ");

                                $origen_c='../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.jpg';
                                $destino_c='../img/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.jpg';
                                $carpeta='../img/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/';
                                if (!file_exists($carpeta)) {
                                    mkdir($carpeta, 0777, true);
                                }
                                copy($origen_c,$destino_c);
                            }   
                            echo 5;   
                        } else {
                            // no se pudo guardar archivo
                          echo 4;              
                        }
                    }  else {
                        // archivo no permitido
                     echo 3;  
                    }                   
                }
      // }          
    
      
                
                    
                        
                
                    
                      
        

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>