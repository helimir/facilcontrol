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
   $perfiles=unserialize($resulr_p['perfiles']);
   $cargos=unserialize($resulr_p['cargos']);
              
   $cantidad=count($_POST['trabajador']);
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
    if (isset($result_contrato['nombre_contrato'])) {$nom_contrato=$result_contrato['nombre_contrato'];} 

    for ($i=0;$i<=$cantidad-1;$i++) {
        $sql=mysqli_query($con,"insert into trabajadores_asignados (trabajadores,cargos,perfiles,contrato,mandante,creado,user,contratista) values ('".$_POST['trabajador'][$i]."','".$lista_cargos[$i]."','".$lista_perfiles[$i]."','$contrato','$mandante','$date','$user','$contratista') ");

        $query_doc_perfiles=mysqli_query($con,"select doc from perfiles where id_perfil='".$lista_perfiles[$i]."' ");
        $result_doc_perfiles=mysqli_fetch_array($query_doc_perfiles);
        $id_doc=unserialize($result_doc_perfiles['doc']);
        $cantidad_doc=count($id_doc);

        $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='".$_POST['trabajador'][$i]."' and contratista='$contratista' ");
        $result_t=mysqli_fetch_array($query_t);
        $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'].' RUT: '.$result_t['rut'];       
         
        for ($j=0;$j<=$cantidad_doc-1;$j++) {

            $query_doc=mysqli_query($con,"select documento from doc where id_doc='".$id_doc[$j]."' ");
            $resul_doc=mysqli_fetch_array($query_doc);
            $nom_documento=$resul_doc['documento'];

            if (isset($result_contratista['razon_social'])) {$nom_contratista=$result_contratista['razon_social'];}                             
            $item='Documento trabajador';                 
            $nivel=3;
            $tipo=2;
            $envia=$contratista;
            $recibe=$contratista;
            $mensaje="Enviar el documento <b>$nom_documento</b> del trabajador <b>$trabajador</b> asignado al contrato <b>$nom_contrato</b> ";
            $usuario=$_SESSION['usuario'];
            $accion="Revisar documento de trabajador";
            $url="verificar_documentos_trabajador_contratista.php";
                            
            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento,trabajador,contrato,perfil,cargo) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','$id_doc[$j]','".$_POST['trabajador'][$i]."','$contrato','$lista_perfiles[$i]','$lista_cargos[$i]') ");

        }
    }  
       
    if ($sql) {
        mysqli_query($con,"delete from notificaciones where item='Asignar Trabajadores' and contrato='$contrato' ");
        echo 0;
    } else {
        echo 1;
    } 
       
  
   
} else { 

echo "<script> window.location.href='../admin.php'; </script>";
}

    
    

?>
