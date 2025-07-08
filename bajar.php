<?php

function agregar_zip($dir_doc, $zip) {
  //verificamos si $dir es un directorio
  if (is_dir($dir_doc)) {
    //abrimos el directorio y lo asignamos a $da
    if ($da = opendir($dir_doc)) {
      //leemos del directorio hasta que termine
	  
      while (($archivo = readdir($da)) !== false) {
        /*Si es un directorio imprimimos la ruta
         * y llamamos recursivamente esta función
         * para que verifique dentro del nuevo directorio
         * por mas directorios o archivos
         */
        if (is_file($dir_doc . $archivo) && $archivo != "." && $archivo != "..") {
          $zip->addFile($dir_doc . $archivo, $dir_doc . $archivo);
        }
      }
      //cerramos el directorio abierto en el momento
      closedir($da);
    }
  }
}

//fin de la función
//creamos una instancia de ZipArchive
$zip = new ZipArchive();

/*directorio a comprimir
 * la barra inclinada al final es importante
 * la ruta debe ser relativa no absoluta
 */
$rut=$_GET['rut'];

$mandante=$_GET['mandante'];
$contratista=$_GET['contratista'];

#$dir = 'doc/validados/'.$mandante.'/'.$contratista.'/';

//ruta donde guardar los archivos zip, ya debe existir
$rutaFinal = 'doc/validados/'.$mandante.'/'.$contratista.'/';
$rutaFinal2 = 'documentos';
 
if(!file_exists($rutaFinal)){
  mkdir($rutaFinal);
}

$archivoZip = "documentos_validados_contratista_$rut.zip";
$dir_doc='documentos';
if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
  agregar_zip($dir_doc, $zip);
  $zip->close();

  //Muevo el archivo a una ruta
  //donde no se mezcle los zip con los demas archivos
  rename($archivoZip, "$rutaFinal/$archivoZip");

  //Hasta aqui el archivo zip ya esta creado
  //Verifico si el archivo ha sido creado 
  #if (file_exists($rutaFinal. "/" . $archivoZip)) {
  #  echo "<hr>Proceso Finalizado!! <br/><br/>
  #              Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a>";
  #} else { 
  #  echo "Error, archivo zip no ha sido creado!!";
  #}
  
  if (file_exists($rutaFinal."/".$archivoZip)) {
	//Definimos el primer header como un archivo binario generico
    header("Content-type: application/octet-stream");
	
	//Este header indica un archivo adjunto el cual tendra un nombre
	header("Content-Disposition: attachment; filename=\"".$archivoZip."\"");
	
	//leemos el archivo de la ruta para enviarlo al navegador
	readfile("$rutaFinal/$archivoZip");
  } else {
    echo "Error, archivo zip no ha sido creado!!";
  }
  
}
?>