<?php
session_start();
if (isset($_SESSION['usuario'])) { 
     
    include('../config/config.php');    
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    
   $contratista=$_SESSION['contratista'];
   $mandante=$_SESSION['mandante'];
   $contrato=$_SESSION['contrato'];;
   $user=$_SESSION['usuario']; 
   
   # seleccionar perfiles del contrato
   $query_p=mysqli_query($con,"select * from contratos where id_contrato='".$contrato."' ");
   $resulr_p=mysqli_fetch_array($query_p);
   $perfiles=unserialize($resulr_p['perfiles_v']);
   $cargos=unserialize($resulr_p['vehiculos']);
              
   $cantidad=count($_POST['vehiculo']);
   $j=0; 

   $t=0; 
   for ($i=0;$i<=$_POST['total_trab']-1;$i++) {
        if ($_POST['cargos'][$i]!=0) {
            $lista_cargos[$t]=$_POST['cargos'][$i];
            $p=0;
            foreach ($cargos as $row) {
                if ($_POST['cargos'][$i]==$row) {
                    $lista_perfiles[$t]=$perfiles[$p];
                }
                $p++;
            }
            $t++;
        }
    }
   
    $query_contrato=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='$contrato' ");
    $result_contrato=mysqli_fetch_array($query_contrato);
    $nom_contrato=$result_contrato['nombre_contrato'];

    for ($i=0;$i<=$cantidad-1;$i++) {
        $sql=mysqli_query($con,"insert into vehiculos_asignados (vehiculos,cargos,perfiles,contrato,mandante,creado,user,contratista) values ('".$_POST['vehiculo'][$i]."','".$lista_cargos[$i]."','".$lista_perfiles[$i]."','$contrato','$mandante','$date','$user','$contratista') ");

        $query_doc_perfiles=mysqli_query($con,"select doc from perfiles where id_perfil='".$lista_perfiles[$i]."' ");
        $result_doc_perfiles=mysqli_fetch_array($query_doc_perfiles);
        $id_doc=unserialize($result_doc_perfiles['doc']);
        $cantidad_doc=count($id_doc);

        $query_veh=mysqli_query($con,"select * from autos where id_auto='".$_POST['vehiculo'][$i]."' and contratista='$contratista' ");
        $result_veh=mysqli_fetch_array($query_veh);        
        $vehiculo=$result_veh['tipo'].' '.$result_veh['marca'].' '.$result_veh['modelo'].' '.$result_veh['year'].' '.$result_veh['siglas'].'-'.$result_veh['control'];      
         
        for ($j=0;$j<=$cantidad_doc-1;$j++) {

            $query_doc=mysqli_query($con,"select documento from doc_autos where id_vdoc='".$id_doc[$j]."' ");
            $resul_doc=mysqli_fetch_array($query_doc);
            $nom_documento=$resul_doc['documento'];

            $nom_contratista=$result_contratista['razon_social'];                            
            $item='Documento vehiculo';                 
            $nivel=3;
            $tipo=3;
            $envia=$contratista;
            $recibe=$contratista;
            $mensaje="Enviar el documento <b>$nom_documento</b> del vehiculo/maquinaria <b>$vehiculo</b> asignado al contrato <b>$nom_contrato</b> ";
            $usuario=$_SESSION['usuario'];
            $accion="Revisar documento de vehiculo";
            $url="verificar_documentos_vehiculos_contratista.php";
                            
            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,trabajador,contrato,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','$id_doc[$j]','".$_POST['vehiculo'][$i]."','$contrato','$lista_perfiles[$i]') ");

        }
   }  
       
    if ($sql) {
        mysqli_query($con,"delete from notificaciones where item='Asignar Vehiculos' and contrato='$contrato' ");
        echo 0;
    } else {
        echo 1;
    } 
       
  
   
} else { 

echo "<script> window.location.href='../admin.php'; </script>";
}

    
    

?>
