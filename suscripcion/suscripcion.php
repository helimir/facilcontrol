<?php
session_start();
include('config/config.php');

if (empty($_SESSION['email']) ) { 
    $sesion=0;
} else {
    $query=mysqli_query($con,"select * from registro where email='".$_SESSION['email']."' ");
    $result=mysqli_fetch_array($query);
    $sesion=1;
    $usuario='@'.explode(" ",$result['nombre'])[0];
    $cliente=$result['nombre'].' '.$result['apellido'];
    $estado=$result['estado'];
}

if ($estado==1) { 
    include('estado_1.php');
} else {
    include('estado_2.php');

} ?>