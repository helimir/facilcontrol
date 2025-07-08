<?php
	     	/*Datos de conexion a la base de datos*/
	define("DB_HOST", "seforacl.domaincommysql.com");//DB_HOST:  generalmente suele ser "127.0.0.1"
	define("DB_USER", "sefora");//Usuario de tu base de datos
	define("DB_PASS", "Servicios2021!");//Contraseña del usuario de la base de datos
	define("DB_NAME", "sefora");//Nombre de la base de datos
	$con=@mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if(!$con){
        @die("<h2 style='text-align:center'>Imposible conectarse a la base de datos en este instante! </h2>".mysqli_error($con));
    } else {
        echo 'conectado';
    }
    if (@mysqli_connect_errno()) {
       @die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error()); 
    }
?>