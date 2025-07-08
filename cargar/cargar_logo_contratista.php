<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3  ) {    
    include('../config/config.php');
    $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
    
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

            if(!$_FILES["foto"]["error"]>0){
                        $permitidos = array('image/jpeg', 'image/png', 'image/jpg');
                        $limite_kb = 1000;                		
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);                        
                        if(in_array($_FILES["foto"]["type"], $permitidos) ) {
                        
                        #if ($extension=="jfif") {
                        #    $extension="jpg";
                        #}    
                        $extension="png";
                        $carpeta = '../img/contratista/'.$contratista.'/';   
                        $nombre='logo_'.$contratista.'.'.$extension; 
                        $url='img/contratista/'.$contratista.'/'.$nombre;

                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }

                        $archivo=$carpeta.$nombre;
                  		
                  		$resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo);
                  		if($resultado){                  		    
                            # actualiza la tabla trabajador en la contratista
                            mysqli_query($con,"update contratistas set  url_logo='$url' where id_contratista='".$contratista."' ");                                                                
                               
                            echo 0;   
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