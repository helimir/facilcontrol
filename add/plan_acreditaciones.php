<?php
session_start();
include "../config/config.php"; 

$query=mysqli_query($con,"update contratistas_mandantes set plan='".$_POST['plan']."' where contratista='".$_POST['id']."' and mandante='".$_SESSION['mandante']."' ");

if ($query) {
    echo 0;
} else {
    echo 1;
}


?>