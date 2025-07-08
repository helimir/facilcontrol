<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');


    function agregar_zip($dir, $zip,$rut_t) {
        //verificamos si $dir es un directorio
        $dir_f='documentos_validados_trabajador_'.$rut_t.'/';
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
    
        if(!$_FILES["foto"]["error"]>0) {
            $permitidos = array('image/jpeg', 'image/png', 'image/jpg');
            $limite_kb = 1000;                		
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);                        
            if(in_array($_FILES["foto"]["type"], $permitidos) ) {
                
                $extension="jpg";
                          
                $carpeta = '../doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/'.$_POST['codigo'].'/';
                $nombre='foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.'.$extension;                
                $url='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/'.$_POST['codigo'].'/'.$nombre;                            
                $archivo = $carpeta.$nombre;                
                $resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo);

                # si se movio el archivo
                if ($resultado) {                               
                    $query_foto1=mysqli_query($con,"update trabajadores_acreditados set  url_foto='$url' where trabajador='".$_POST['trabajador']."' and contrato='".$_POST['contrato']."'  ");                    
                    
                    # copiar foto de validados a trabajadores
                    $origen_c='../doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/'.$_POST['codigo'].'/foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.jpg';
                    $destino_c='../img/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.jpg';
                    $url_c='img/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/foto_'.$_SESSION['contratista'].'_'.$_POST['rut'].'.jpg';
                    $carpeta='../img/trabajadores/'.$_SESSION['contratista'].'/'.$_POST['rut'].'/';
                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0777, true);
                    }
                    $copiar=copy($origen_c,$destino_c);
                    
                    if ($copiar) {
                        $query_foto2=mysqli_query($con,"update trabajador set  url_foto='$url_c' where rut='".$rut."' and contratista='".$_SESSION['contratista']."'  ");   
                        $query_noti=mysqli_query($con,"update notificaciones set procesada='1' where item='Trabajador Sin Foto' and trabajador='".$_POST['trabajador']."' and contrato='".$_POST['contrato']."' ");

                        $ruta2  ='../doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/'.$_POST['codigo'].'/';
                        $rutazip='../doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_POST['contrato'].'/'.$_POST['rut'].'/'.$_POST['codigo'].'/zip/';

                        $rut_t=$rut;
                        $zip = new ZipArchive(); 
                        # crea archivo zip
                        $archivoZip = "documentos_validados_trabajador_$rut_t.zip";                                    
                        
                        if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                            agregar_zip($ruta2, $zip,$rut_t);
                            $zip->close();
                            
                            #Muevo el archivo a una ruta
                            #donde no se mezcle los zip con los demas archivos
                            $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
                        }
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
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>