<?php
session_start();
if (isset($_SESSION['usuario'])  ) { 

    $rut=isset($_POST['rut']) ? $_POST['rut']: '';

    include "../config/config.php";
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);

    # contratista
    if ($_POST['opcion']==1) {
            $query_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$rut."' ");
            $resul_mandante=mysqli_fetch_array($query_mandante);

            if ($query_mandante) {
                $query_contratista=mysqli_query($con,"insert into contratistas 
                (giro,nombre_fantasia,razon_social,rut,rut_rep,representante,direccion_empresa,dir_comercial_region,dir_comercial_comuna,administrador,fono,email,creado_contratista,mandante,descripcion_giro,dualidad,acreditada,usuario) values 
                ('".$resul_mandante['giro']."','".$resul_mandante['nombre_fantasia']."','".$resul_mandante['razon_social']."','".$resul_mandante['rut_empresa']."','".$resul_mandante['rut_representante']."','".$resul_mandante['representante_legal']."','".$resul_mandante['direccion']."','".$resul_mandante['dir_comercial_region']."','".$resul_mandante['dir_comercial_comuna']."','".$resul_mandante['administrador']."','".$resul_mandante['fono']."','".$resul_mandante['email']."','$date','".$resul_mandante['id_mandante']."','".$resul_mandante['descripcion_giro']."','1','1','".$rut."') ");

                if ($query_contratista) {

                    $resultado_c =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'contratistas' ");           
                    $auto_c= mysqli_fetch_array($resultado_c); 
                    $id_contratista=$auto_c['AUTO_INCREMENT']-1;

                    mysqli_query($con,"insert into contratistas_mandantes (contratista,mandante,creado,acreditada) values ('$id_contratista','".$resul_mandante['id_mandante']."' ,'$date','1') ");
                    mysqli_query($con,"update mandantes set dualidad='1', multiple='1' where id_mandante='".$resul_mandante['id_mandante']."' ");
                    mysqli_query($con,"update users set nivel='4' where usuario='".$rut."' ");

                    echo 0;
                } else {
                    echo 1;
                }

            } else {
                echo 1;
            }
    }

    # mandante
    if ($_POST['opcion']==2) {
        $query_contratista=mysqli_query($con,"select * from contratistas where rut='".$rut."' ");
        $resul_contratista=mysqli_fetch_array($query_contratista);

        if ($query_contratista) {
            $query_mandante=mysqli_query($con,"insert into mandantes 
            (giro,descripcion_giro,nombre_fantasia,razon_social,rut_empresa,rut_representante,representante_legal,dir_comercial_region,dir_comercial_comuna,direccion,administrador,fono,email,dualidad,creado_mandante,usuario) values 
            ('".$resul_contratista['giro']."','".$resul_contratista['descripcion_giro']."','".$resul_contratista['nombre_fantasia']."','".$resul_contratista['razon_social']."','".$resul_contratista['rut']."','".$resul_contratista['rup_rep']."','".$resul_contratista['representante']."','".$resul_contratista['dir_comercial_region']."','".$resul_contratista['dir_comercial_comuna']."','".$resul_contratista['direccion_empresa']."','".$resul_contratista['administrador']."','".$resul_contratista['fono']."','".$resul_contratista['email']."','1','$date','".$rut."') ");

            if ($query_mandante) {

                $resultado_c =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'mandantes' ");           
                $auto_c= mysqli_fetch_array($resultado_c); 
                $id_mandante=$auto_c['AUTO_INCREMENT']-1;

                mysqli_query($con,"insert into contratistas_mandantes (contratista,mandante,creado,acreditada) values ('".$resul_contratista['id_contratista']."','$id_mandante' ,'$date','1') ");
                mysqli_query($con,"update contratistas set dualidad='1', multiple='1' where id_contratista='".$resul_contratista['id_contratista']."' ");
                mysqli_query($con,"update users set nivel='4' where usuario='".$rut."' "); 

                echo 0;
            } else {
                echo 1;
            }

        } else {
            echo 1;
        }
}

} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}

?>