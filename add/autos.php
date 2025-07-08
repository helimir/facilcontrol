<?php
session_start();
if (isset($_SESSION['usuario']) and ($_SESSION['nivel']==3)  ) { 
include "../config/config.php";  

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());
$fecha_actual = date("Y-m-d");


function make_date(){
    return strftime("%d-%m-%Y H:i:s", time());
}

$fecha =make_date();

$tipo=isset($_POST['tipo_auto']) ? $_POST['tipo_auto']: '';
$patente=isset($_POST['patente']) ? $_POST['patente']: '';
$siglas=isset($_POST['h_siglas']) ? $_POST['h_siglas']: '';
$motor=isset($_POST['motor']) ? $_POST['motor']: '';
$chasis=isset($_POST['chasis']) ? $_POST['chasis']: '';
$marca=isset($_POST['marca']) ? $_POST['marca']: '';
$modelo=isset($_POST['modelo']) ? $_POST['modelo']: '';
$color=isset($_POST['color']) ? $_POST['color']: '';
$year=isset($_POST['year']) ? $_POST['year']: '';
$puestos=isset($_POST['puestos']) ? $_POST['puestos']: '';
$propietario=isset($_POST['propietario']) ? $_POST['propietario']: '';
$rut_propietario=isset($_POST['rut_propietario']) ? $_POST['rut_propietario']: '';
$fono_propietario=isset($_POST['fono_propietario']) ? $_POST['fono_propietario']: '';
$email_propietario=isset($_POST['email_propietario']) ? $_POST['email_propietario']: '';
$revision=isset($_POST['revision']) ? $_POST['revision']: '';
$id_contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
$mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
$control=isset($_POST['control']) ? $_POST['control']: '';

$nivel_user=3;

if ($tipo=="Excavadora" or $tipo=="Retroexcavadora" or $tipo=="Cargador frontal" or $tipo=="Yale" or $tipo=="Grúa" or $tipo=="Buldozer" or $tipo=="Minicargador" or $tipo=="Perforadora" ) {
    $patente="SP";
}

if ($_POST['auto']=="crear") { 

     // validar que rut existe
     $query=mysqli_query($con,"select * from autos where siglas='$siglas' and control='$control' and contratista='$id_contratista' ");
     $result=mysqli_fetch_array($query);
     $existe=mysqli_num_rows($query);

     if ($existe==0) {

        if ($color=='seleccionar') {
            $color='S/C';
        }
                           
        $sql_auto=mysqli_query($con,"insert into autos (contratista,tipo,siglas,motor,chasis,year,propietario,revision,patente,marca,modelo,color,puestos,creado,control,rut_propietario,fono_propietario,email_propietario) values ('$id_contratista','$tipo','$siglas','$motor','$chasis','$year','$propietario','$revision','$patente','$marca','$modelo','$color','$puestos','$date','$control','$rut_propietario','$fono_propietario','$email_propietario') " ); 
                    
        if ($sql_auto) {
            mysqli_query($con,"delete from notificaciones where item='Crear Vehiculos' and contratista='$id_contratista' ");
            echo 0;
            
        # error no creo auto    
        } else {
            echo 1;
        }
    # auro ya existe
    } else {
        echo 5;
    }
}   
                
                
#if ($_POST['auto']=="actualizar") {
#            $query_documentos=mysqli_query($con,"select doc_contratista from contratistas_mandantes where contratista='".$_SESSION['contratista']."' and mandante='".$_SESSION['mandante']."' ");
#            $result_documentos=mysqli_fetch_array($query_documentos);
#            $documentos_actual=unserialize($result_documentos['doc_contratista']);                
#            $cant_actual=count($documentos_actual);               
            # $doc_fechas=serialize($fechas);
#            $sql=mysqli_query($con,"update contratistas set giro='$giro', descripcion_giro='$descripcion_giro', nombre_fantasia='$nombre_fantasia', direccion_empresa='$direccion_empresa', dir_comercial_region='$region_com', dir_comercial_comuna='$comuna_com', administrador='$administrador', fono='$fono', email='$email', representante='$representante', rut_rep='$rut_rep', direccion_rep='$direccion_rep', region_rep='$region_rep', comuna_rep='$comuna_rep', estado_civil='$estado_civil', editado_contratista='$date' where id_contratista='".$_SESSION['contratista']."' ");
#            if ($sql) {                
#                $update=mysqli_query("update contratistas_mandantes set doc_contratista='$doc', cant_doc='$total_doc' where contratista='".$_SESSION['contratista']."' and mandante='".$_SESSION['mandante']."'  ");                
#                echo 2;
#            } else {
#                echo 3;
#            }
#}

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}

?>