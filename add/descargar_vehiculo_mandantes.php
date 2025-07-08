<?php 
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3) {

    $patente=isset($_POST['patente']) ? $_POST['patente']: '';
    $contratista=$_SESSION['contratista'];

    $ruta='../doc/vehiculos/'.$contratista.'/'.$patente.'/';
    $rutazip='../doc/vehiculos/'.$contratista.'/'.$patente.'/zip/';

    if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true);
    } 

    if (!file_exists($rutazip)) {
    mkdir($rutazip, 0777, true);
    }

    function agregar_zip($dir,$zip,$patente,$contratista) {
        //verificamos si $dir es un directorio
        $dir_f='documentos_vehiculo_'.$contratista.'_'.$patente.'/';
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
    

    $zip = new ZipArchive();
    $archivoZip = 'documentos_vehiculo_'.$contratista.'_'.$patente.'.zip';                           
                
    if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
        agregar_zip($ruta,$zip,$patente,$contratista);
        $zip->close();                
        #Muevo el archivo a una ruta
        #donde no se mezcle los zip con los demas archivos
        $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
    }

    if ($zip_creado) {
        echo 0;        
    } else {
        echo 1;
    }

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}
 
?>