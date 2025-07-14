<?php
session_start();
/**
 * @author helimir lopez
 * @copyright 2022
 */

include "../config/config.php";  

$rut=$_POST['rut'] ?? '';


$query_contratista=mysqli_query($con,"SELECT c.* from contratistas as c  where c.rut='$rut' ");
$result_contratista=mysqli_fetch_array($query_contratista);
   
echo json_encode($result_contratista);


?>