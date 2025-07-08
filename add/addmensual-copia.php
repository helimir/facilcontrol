<?php

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2  ) { 
include "../config/config.php"; 

date_default_timezone_set('America/Santiago');
$date = date('Y-m-d H:m:s', time());
$fecha_actual = date("Y-m-d");

$mes = date("m");
$year = date("Y");


$contratista=$_POST['contratista_dm'];
$contrato=$_POST['contrato_dm'];
$mandante=$_POST['mandante_dm'];
$condicion=$_POST['condicion_dm'];
$mes_control=$mes;
# sumar un mes al me
$fecha_mensual=$_POST['fecha_mensual_dm'];
$doc=serialize($_POST['doc_mensuales_dm']);

$query=mysqli_query($con,"select * from mensuales where contratista='$contratista' ");
$result=mysqli_fetch_array($query);

$query_t=mysqli_query($con,"select trabajador from trabajadores_acreditados where contrato='$contrato' ");
$result_t=mysqli_fetch_array($query_t);
$num_trabajadores=mysqli_num_rows($query_t);

$query_m=mysqli_query($con,"select * from mandantes where id_mandante='$mandante' and estado='1' ");
$result_m=mysqli_fetch_array($query_m);

$query_c=mysqli_query($con,"select * from contratos where id_contrato='$contrato' and estado='1' ");
$result_c=mysqli_fetch_array($query_c);
 
$x=0;
foreach ($query_t as $row) {
    $list_trabajadores[$x]=$row['trabajador'];
    $x++;
}

$trabajadores_unse=unserialize($result_t['trabajador']);
$trabajadores_seri=serialize($list_trabajadores);


  // nuevo registro
  if ($condicion==0) {        
        
        # cantidad de documentos
        $cant_doc=count($_POST['doc_mensuales_dm']);
        $cant_tra=count($list_trabajadores);

        for ($d=0;$d<=$cant_doc-1;$d++) {
            $query=mysqli_query($con,"insert into mensuales (doc_mensual,trabajadores,mes,year,contratista,mandante,contrato,creado,user) values ('".$_POST['doc_mensuales_dm'][$d]."','".$trabajadores_seri."','$mes','$year','$contratista','$mandante','$contrato','$date','".$_SESSION['usuario']."') ");

            $query_id =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_proyecto' AND TABLE_NAME = 'mensuales' ");
            $result_id= mysqli_fetch_array($query_id); 
            $idmensual=$result_id['AUTO_INCREMENT']-1;

            $query_d=mysqli_query($con,"select * from doc_mensuales where id_dm='".$_POST['doc_mensuales_dm'][$d]."'  ");
            $result_d=mysqli_fetch_array($query_d);

            for ($t=0;$t<=$cant_tra-1;$t++) {
                                
                $query_ta=mysqli_query($con,"select * from trabajador where idtrabajador='".$list_trabajadores[$t]."' ");
                $result_ta=mysqli_fetch_array($query_ta);
                $trabajador=$result_ta['nombre1'].' '.$result_ta['apellido1'];
                
                $item='Gestion Documento Mensual';  
                $nivel=2; 
                $tipo=1;
                $envia=$mandante;
                $recibe=$contratista;
                $mensaje="El mandante <b>".$result_m['razon_social']."</b> ha solicitado el documento mensual <b>".$result_d['documento']."</b>, trabajador <b>".$trabajador."</b> del contrato <b>".$result_c['nombre_contrato']."</b>";
                $accion="Gestionar Documento Mensual";
                $url="gestion_doc_mensuales_contratista.php";
                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,contrato,documento,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$_POST['doc_mensuales_dm'][$d]."','".$mandante."','".$contratista."','".$contrato."','".$result_d['documento']."','".$list_trabajadores[$t]."') ");

                $query_noti =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_proyecto' AND TABLE_NAME = 'notificaciones' ");
                $result_noti= mysqli_fetch_array($query_noti); 
                $idnoti=$result_noti['AUTO_INCREMENT']-1;

                $query_t=mysqli_query($con,"insert into mensuales_trabajador (id_m,trabajador,doc,contratista,mandante,contrato,id_noti,creado,mes,year) values ('$idmensual','".$list_trabajadores[$t]."','".$_POST['doc_mensuales_dm'][$d]."','$contratista','$mandante','$contrato','$idnoti','$date','$mes','$year') ");
            }

            

        }

        $query=mysqli_query($con,"update contratos set  mensuales='1' where id_contrato='$contrato' ");
        echo 0;
   } 
   # deshabilitar registro
   if ($condicion==1) {
           $update=mysqli_query($con,"update contratistas set mensuales='0' where id_contratista='$contratista' ");
           echo 2;
   }
   # habilitar registro existente
   if ($condicion==2) {
           $update=mysqli_query($con,"update contratistas set mensuales='1' where id_contratista='$contratista' ");
           echo 2;
   }

} else { 

    echo "<script> window.location.href='admin.php'; </script>";
}

?>