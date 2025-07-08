<?php
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');
    
    $vehiculo=isset($_POST['vehiculo']) ? $_POST['vehiculo']: '';
    $siglas=isset($_POST['vehiculo']) ? $_POST['siglas']: '';
    $control=isset($_POST['control']) ? $_POST['control']: '';
    $patente=isset($_POST['patente']) ? $_POST['patente']: '';
    $tipo=isset($_POST['tipo']) ? $_POST['tipo']: '';
    $motor=isset($_POST['motor']) ? $_POST['motor']: '';
    $chasis=isset($_POST['chasis']) ? $_POST['chasis']: '';
    $marca=isset($_POST['marca']) ? $_POST['marca']: '';
    $modelo=isset($_POST['modelo']) ? $_POST['modelo']: '';
    $year=isset($_POST['year']) ? $_POST['year']: '';
    $color=isset($_POST['color']) ? $_POST['color']: '';
    $puestos=isset($_POST['puestos']) ? $_POST['puestos']: '';
    $revision=isset($_POST['revision']) ? $_POST['revision']: '';
    $propietario=isset($_POST['propietario']) ? $_POST['propietario']: '';
    $rut_propietario=isset($_POST['rut_propietario']) ? $_POST['rut_propietario']: '';
    $fono_propietario=isset($_POST['fono_propietario']) ? $_POST['fono_propietario']: '';
    $email_propietario=isset($_POST['email_propietario']) ? $_POST['email_propietario']: '';

    $query=mysqli_query($con,"update autos set tipo='$tipo', siglas='$siglas', control='$control', motor='$motor', chasis='$chasis', year='$year', patente='$patente', marca='$marca', modelo='$modelo', color='$color', puestos='$puestos', revision='$revision', propietario='$propietario', rut_propietario='$rut_propietario', fono_propietario='$fono_propietario',email_propietario='$email_propietario', editado='$date' where id_auto='$vehiculo' ");
    if ($query) {
        echo 0;
    } else {
        echo 1;
    }

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}
?>