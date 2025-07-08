<?php

/**
 * @author helimir e. lopez
 * @copyright 2019
 */
 session_start();
include "config/config.php";

date_default_timezone_set('America/Santiago');
setlocale(LC_MONETARY,"es_CL");
$dia_actual=date('d');
$mes_actual=date('m');
$year_actual=date('Y');

$date = date('Y-m-d H:m:s', time());
$fecha_actual = date("Y-m-d");
$mes=date('m')+1;


    

 $query_mensual=mysqli_query($con,"SELECT m.*, a.razon_social as nombre_mandante from contratistas as c Left Join  mensuales as m On m.contratista=c.id_contratista left join mandantes  as a On a.id_mandante=m.mandante where c.rut='".$_SESSION['usuario']."' and m.contrato='".$_POST['contrato']."' ORDER by m.mes DESC limit 1 ");
 $result_mensual=mysqli_fetch_array($query_mensual);

 $_SESSION['mes']=$result_mensual['mes'];
 $_SESSION['mensual']=$result_mensual['id_m'];   
 $_SESSION['contrato']=$_POST['contrato'];
   
    # si hay contratos con documentos mensuales
    $existe=mysqli_num_rows($query_mensual);
    if ($existe>0) {
        if ($result_mensual['mes']!=$mes_actual) {
        
            $query_add_mensual=mysqli_query($con,"insert into mensuales (doc_contratista_mensuales,dia,mes,year,contratista,mandante,creado,user,contrato,mes_registro,trabajadores) values
            ('".$result_mensual['doc_contratista_mensuales']."','".$result_mensual['dia']."','".$mes_actual."','".$result_mensual['year']."','".$result_mensual['contratista']."','".$result_mensual['mandante']."','$fecha_actual','".$_SESSION['usuario']."','".$result_mensual['contrato']."','".$result_mensual['mes_registro']."','".$result_mensual['trabajadores']."') ");
           
            if ($query_add_mensual) { 
                
                $query_t=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$result_mensual['contrato']."' ");
                $result_t=mysqli_fetch_array($query_t);     
                $num_trabajadores=count(unserialize($result_t['trabajadores']));
                $trabajadores_unse=unserialize($result_t['trabajadores']);
                
                $i=0;
                for ($i=0;$i<=$num_trabajadores-1;$i++) {
                    $query=mysqli_query($con,"insert into mensuales_trabajador (trabajador,doc_contratista_mensuales,dia,mes,year,contratista,mandante,creado,user,contrato,mes_registro) values ('".$trabajadores_unse[$i]."','".$result_mensual['doc_contratista_mensuales']."','".$result_mensual['dia']."','$mes_actual','".$result_mensual['year']."','".$result_mensual['contratista']."','".$result_mensual['mandante']."','$fecha_actual','".$_SESSION['usuario']."','".$result_mensual['contrato']."','".$result_mensual['mes']."') ");
                } 
            }    
       }     
    } 
      	

?>