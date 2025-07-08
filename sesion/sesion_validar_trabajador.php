<?php

session_start();

$_SESSION['trabajador']=$_POST['trabajador'];
$_SESSION['cargo']=$_POST['cargo'];
$_SESSION['perfil']=$_POST['perfil'];

?>