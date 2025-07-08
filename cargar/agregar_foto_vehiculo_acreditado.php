<?php
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3  ) {    
    include('../config/config.php');
    $contratista=$_SESSION['contratista'];
    $mandante=$_SESSION['mandante'];
    $contrato=$_POST['contrato'];
    $rut=$_POST['rut'];
    $codigo=$_POST['codigo'];
    $trabajador=$_POST['trabajador'];

    

    function agregar_zip($dir, $zip,$rut) {
        //verificamos si $dir es un directorio
        $dir_f='documentos_validados_vehiculos_'.$rut.'/';
        if (is_dir($dir)) {
          //abrimos el directorio y lo asignamos a $da
          if ($da = opendir($dir)) {
            //leemos del directorio hasta que termine
            
            while (($archivo = readdir($da)) !== false) {
              /*Si es un directorio imprimimos la ruta
               * y llamamos recursivamente esta funci�n
               * para que verifique dentro del nuevo directorio
               * por mas directorios o archivos
               */
              if (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                $zip->addFile($dir.$archivo, $dir_f.$archivo);
              }
            }
            //cerramos el directorio abierto en el momento
            closedir($da);
          }
        }
      }
    
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
                        $carpeta_contratista = '../doc/vehiculos/'.$contratista.'/'.$rut.'/';   
                        $nombre_contratista='foto_'.$rut.'.'.$extension; 
                        $url_contratista='doc/vehiculos/'.$contratista.'/'.$rut.'/'.$nombre_contratista;

                        $archivo_contratista = $carpeta_contratista.$nombre_contratista;
                  		
                  		$resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo_contratista);
                  		if($resultado){
                  		    
                            # actualiza la tabla trabajador en la contratista
                            mysqli_query($con,"update autos set  url_foto='$url_contratista' where id_auto='".$trabajador."' and contratista='$contratista'  ");
                                    
                            $origen_c='../doc/vehiculos/'.$contratista.'/'.$rut.'/foto_'.$rut.'.jpg';
                            $destino_c='../doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/'.$codigo.'/foto_'.$rut.'.jpg';
                            $destino_t='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/foto_'.$rut.'.jpg';
                            
                            copy($origen_c,$destino_c);
                            copy($origen_c,$destino_t);

                            $url_contrato='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/foto_'.$rut.'.jpg';
                            mysqli_query($con,"update vehiculos_asignados set  url_foto='$url_contrato' where vehiculos='".$trabajador."' and contrato='".$contrato."'  ");

                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Vehiculo Sin Foto' and trabajador='$trabajador' " );


                            #crear zip con foto
                            $ruta='../doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/'.$codigo.'/';
                            $rutazip='../doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/'.$codigo.'/zip/';

                            
                            $zip = new ZipArchive();
                            # crea archivo zip
                            $archivoZip = "documentos_validados_vehiculos_$rut.zip";
                                        
                            #mysqli_query($con,"insert into prueba (valor,valor2,valor3,valor4,valor5) values ('$rut','$codigo','$mandante','$contratista','$contrato') ");

                            if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                                agregar_zip($ruta, $zip,$rut);
                                $zip->close();
                                
                                #Muevo el archivo a una ruta
                                #donde no se mezcle los zip con los demas archivos
                                $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
                            }
                            $url_foto='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/'.$codigo.'/foto_'.$rut.'.jpg';
                            mysqli_query($con,"update vehiculos_acreditados set url_foto='$url_foto' where vehiculo='$trabajador' ");   
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