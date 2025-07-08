<?php

$nombreDeArchivo = $_GET['pdf'];
$nombreDeArchivo = end(explode('/',$nombreDeArchivo));

$extension=substr($nombreDeArchivo,-3);

if ($extension=="pdf") {
    header('Content-Description: File Transfer');
    header("Content-type: application/pdf");
    header('Content-Disposition: inline; filename='.$nombreDeArchivo);
    readfile($nombreDeArchivo);
} else {
    header('Content-Description: File Transfer');
    header("Content-type: application/vnd.ms-word");
    header('Content-Disposition: inline; filename='.$nombreDeArchivo); 
    
}  
    
?>


