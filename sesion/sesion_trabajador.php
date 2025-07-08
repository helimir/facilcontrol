<?php

session_start();

$_SESSION['idtrabajador']=$_POST['id'];

if ($_POST['editar']==1) {
    $_SESSION['active_edit']='personal';
} else {
    $_SESSION['active_edit']='documentos';
}

?>