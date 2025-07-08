<?php
// Usamos el comando "unlink" para borrar el fichero
$carpeta=$_POST['archivo'];
unlink($carpeta);

// Redirigiendo hacia atrás
//header("Location: " . $_SERVER["HTTP_REFERER"])
?>