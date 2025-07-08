<?php
include "../config/config.php";
  
	$epp = $_POST['epp'];
	$query=mysqli_query($con,"delete from epp WHERE id_epp = '".$epp."' ");
    if ($query) {
        echo 0;
    } else {
        echo 1;
    }
?>