<?php

$files=glob('../doc/temporal/66/207/contrato_53/10.018.245-9/*.*');
foreach($files as $file){
    if(is_file($file))
    unlink($file); //elimino el fichero
}

$carpeta='../doc/temporal/66/207/contrato_53/10.018.245-9/';
rmdir($carpeta);


?>
