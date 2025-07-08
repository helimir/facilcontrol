<?php


    #$archivoZip='documentos_validados_contratista_27.069.177-3.zip';
    $archivoZip='documentos_validados_contratista_'.$_GET['rut'].'.zip';
    //ruta donde guardar los archivos zip, ya debe existir
    #$rutaFinal = 'doc/validados/31/140/';
    $rutaFinal = $_GET['url'];


	//Definimos el primer header como un archivo binario generico
    header("Content-type: application/octet-stream");
	
	//Este header indica un archivo adjunto el cual tendra un nombre
	header("Content-Disposition: attachment; filename=\"".$archivoZip."\"");
	
	//leemos el archivo de la ruta para enviarlo al navegador
	readfile("$rutaFinal/$archivoZip");
 
?>