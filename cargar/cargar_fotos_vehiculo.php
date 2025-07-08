<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');
    $vehiculo=isset($_POST['vehiculo']) ? $_POST['vehiculo']: '';
    $siglas=isset($_POST['siglas']) ? $_POST['siglas']: '';

    
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
            if(!$_FILES["foto"]["error"]>0) {
                        $permitidos = array('image/jpeg', 'image/png', 'image/jpg');
                        $limite_kb = 1000;                		
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);                        
                        if(in_array($_FILES["foto"]["type"], $permitidos) ) {
                         
                        $extension="jpg";                      
                     
                        $carpeta ='../doc/vehiculos/'.$_SESSION['contratista'].'/'.$siglas.'/';
                        $nombre='foto_'.$_SESSION['contratista'].'_'.$siglas.'.'.$extension;
                        $url='doc/vehiculos/'.$_SESSION['contratista'].'/'.$siglas.'/'.$nombre;
                        
                    
                  		$archivo = $carpeta.$nombre;
                  		if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }
                  		
                        $resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo);
                  		if($resultado) {                  		    
                            mysqli_query($con,"update autos set  url_foto='$url' where id_auto='".$vehiculo."'   ");
                            echo $url;   
                        } else {
                            // no se pudo guardar archivo
                          echo 1;              
                        }
                    }  else {
                        // archivo no permitido
                     echo 2;  
                    }                   
                }
      // }          
    
      
                
                    
                        
                
                    
                      
        

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>