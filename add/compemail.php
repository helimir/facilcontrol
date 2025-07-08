<?php
session_start();
include "../config/config.php";

$email=$_POST['email'];

$sql=mysqli_query($con,"select * users from email_user='$email' ");

if ($sql) {
    echo 1;
} else {
    echo 0;
}



?>