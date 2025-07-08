<?php

/**
 * @author lolkittens
 * @copyright 2022
 */

include('config/config.php');

$pass=password_hash("helimir", PASSWORD_DEFAULT);
$sql_user=mysqli_query($con,"update users set pass='$pass' where id_user='7' ");

if ($sql_user) {
    echo 'actualizada';
} else {
    echo 'No actualizada';
}

?>