<?php
session_start();

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2  ) { 
    include "../config/config.php";
    
    $query_m=mysqli_query($con,"select razon_social from mandantes where id_mandante='".$_POST['mandante']."' ");
    $result_m=mysqli_fetch_array($query_m);
    
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    
    #tipo contratista
    if ($_POST['tipo']==1) {
    
        $arreglo_contratistas=serialize(json_decode(stripslashes($_POST['contratistas'])));
        $contratistas=unserialize($arreglo_contratistas);
        $i=0;
        for ($i=0;$i<=$_POST['cantidad_c']-1;$i++) {
            $query=mysqli_query($con,"insert into documentos_extras (contratista,mandante,documento,creado,usuario,tipo,tipo_doc) values ('".$contratistas[$i]."','".$_POST['mandante']."','".$_POST['nombre_doc']."','$date','".$_SESSION['usuario']."','".$_POST['tipo']."','".$_POST['tipo_doc']."') ");
            
            if ($query) {
                
                // notificacion asignar perfiles a contrato
                $item='Documento Extraordinario Solicitado'; 
                $nivel=2; 
                $tipo=1;
                $envia=$_SESSION['mandante'];
                $recibe=$contratistas[$i];
                $mensaje="El Mandante <b>".$result_m['razon_social']."</b> ha solicitado el documento extraordinario <b>".$_POST['nombre_doc']."</b> a la Contratista.";
                $accion="Gestionar Documento Extraordinario";
                $url="gestion_doc_extraordinarios_contratista.php";
                $query_notificaciones3=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contratista,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','".$_SESSION['usuario']."','$url','$tipo','".$_POST['nombre_doc']."','".$_SESSION['mandante']."','$contratistas[$i]','".$_POST['nombre_doc']."') "); 
                    
                
                echo 0;
            } else {
                echo 1;
            }
         }
    
    } 
    
    # trabajadores todos de un contrato
    if ($_POST['tipo']==2) {
        
        $arreglo_contratos=serialize(json_decode(stripslashes($_POST['contratos'])));
        
        $contratos=unserialize($arreglo_contratos);
        $i=0;
        for ($i=0;$i<=$_POST['cantidad_t']-1;$i++) {
            
            $query_contratos=mysqli_query($con,"select * from contratos where id_contrato='$contratos[$i]' ");
            $result_contratos=mysqli_fetch_array($query_contratos);

            $query_t=mysqli_query($con,"select trabajador from trabajadores_acreditados where contrato='$contratos[$i]' ");
            $t=0;
            foreach ($query_t as $row) {
                $trabajadores_acreditados[$t]=$row['trabajador'];
                $t++;
            }
            
            $lista_trabajadores=serialize($trabajadores_acreditados);
            for ($x=0;$x<=$t-1;$x++) {
                    
                    #$prueba=mysqli_query($con,"insert into prueba (valor,valor2,valor3) values ('$x','".$t."','".$trabajadores_acreditados[$x]."') ");
                    $query=mysqli_query($con,"insert into documentos_extras (contratista,contrato,mandante,documento,creado,usuario,tipo,tipo_doc,trabajador) values ('".$result_contratos['contratista']."','".$contratos[$i]."','".$_POST['mandante']."','".$_POST['nombre_doc']."','$date','".$_SESSION['usuario']."','".$_POST['tipo']."','".$_POST['tipo_doc']."','".$trabajadores_acreditados[$x]."' ) ");
                    if ($query) {
                        
                        $query_trabajador=mysqli_query($con,"select nombre1,apellido1 from trabajador where idtrabajador='".$trabajadores_acreditados[$x]."'  ");
                        $result_trabajador=mysqli_fetch_array($query_trabajador);
                        $trabajador=$result_trabajador['nombre1'].' '.$result_trabajador['apellido1'];
                        // notificacion asignar perfiles a contrato
                        $item='Documento Extraordinario Solicitado'; 
                        $nivel=2; 
                        $tipo=2;
                        $envia=$_SESSION['mandante'];
                        $recibe=$result_contratos['contratista'];
                        $mensaje="El Mandante <b>".$result_m['razon_social']."</b> ha solicitado un documento extraordinario para el trabajador <b>$trabajador</b> del Contrato <b>".$result_contratos['nombre_contrato']."</b>.";
                        $accion="Gestionar Documento Extraordinario";
                        $url="gestion_doc_extraordinarios_contratista_contrato.php";                        
                        $query_notificaciones3=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contratista,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','".$_SESSION['usuario']."','$url','$tipo','".$_POST['nombre_doc']."','".$_SESSION['mandante']."','".$result_contratos['contratista']."','".$trabajadores_acreditados[$x]."','".$contratos[$i]."') "); 
                                        
                        echo 0;

                    } else {
                        echo 1;
                    }
            }        
         }
        
    }
    
    # trabajadores individuales
    if ($_POST['tipo']==3) {
        $arreglo_t=json_decode(stripslashes($_POST['trabajadores']));
        $i=0;
        for ($i=0;$i<=$_POST['cantidad_r']-1;$i++) {
            
            $query_contratos=mysqli_query($con,"select * from contratos where id_contrato='".$_POST['contrato_r']."' ");
            $result_contratos=mysqli_fetch_array($query_contratos);

            $query_t=mysqli_query($con,"select t.nombre1, t.apellido1 from trabajadores_acreditados as a Left Join trabajador as t On t.idtrabajador=a.trabajador where a.trabajador='".$arreglo_t[$i]."' and a.contrato='".$_POST['contrato_r']."' ");
            $result_t=mysqli_fetch_array($query_t);
            
            $query=mysqli_query($con,"insert into documentos_extras (contratista,contrato,mandante,documento,creado,usuario,tipo,trabajador) values ('".$_POST['contratista']."','".$_POST['contrato_r']."','".$_POST['mandante']."','".$_POST['nombre_doc']."','$date','".$_SESSION['usuario']."','".$_POST['tipo']."','". $arreglo_t[$i]."' ) ");
            if ($query) {
                        $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
                        // notificacion asignar perfiles a contrato
                        $item='Documento Extraordinario Solicitado'; 
                        $nivel=2; 
                        $tipo=2;
                        $envia=$_SESSION['mandante'];
                        $recibe=$result_contratos['contratista'];
                        $mensaje="El Mandante <b>".$result_m['razon_social']."</b> ha solicitado un documento extraordinario para el trabajador <b>$trabajador</b> del Contrato <b>".$result_contratos['nombre_contrato']."</b>.";
                        $accion="Gestionar Documento Extraordinario";
                        $url="gestion_doc_extraordinarios_contratista_trabajador.php";
                        $query_notificaciones3=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,control,mandante,contratista,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','".$_SESSION['usuario']."','$url','$tipo','".$_POST['nombre_doc']."','".$_SESSION['mandante']."','".$_POST['contratista']."','".$arreglo_t[$i]."','".$_POST['contrato_r']."') "); 
                                        
                        echo 0;

            } else {
                echo 1;
            }
         }
    }
        
    #}


} else { 
    echo '<script> window.location.href="../admin.php"; </script>';
}
?>