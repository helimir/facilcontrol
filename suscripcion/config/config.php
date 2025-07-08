<?php
    /*Datos de conexion a la base de datos*/    
    if (!defined('DB_HOST')) define('DB_HOST', 'localhost');
    if (!defined('DB_USER')) define('DB_USER', 'clubicl');
    if (!defined('DB_PASS')) define('DB_PASS', 'Arielg12345678!!');
    if (!defined('DB_NAME')) define('DB_NAME', 'clubicl_proyecto');
       $con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        @die("<h2 style='text-align:center'>Imposible conectarse a la base de datos en este instante! </h2>".mysqli_error($con));
    }

    if (@mysqli_connect_errno()) {
       @die("Conexi�n fall�: ".mysqli_connect_errno()." : ". mysqli_connect_error()); 
    }

?>