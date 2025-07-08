<?php

session_start();
if (isset($_SESSION['usuario'])) { 
    
   include('../config/config.php');    
   date_default_timezone_set('America/Santiago');
   $date = date('Y-m-d H:m:s', time());
   $fecha = date('Y-m-d');
     
   $user=$_SESSION['usuario'];              
    
   
   $query=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$_POST['contrato']."' ");
   $result=mysqli_fetch_array($query); 
   
   $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='".$_POST['trabajador']."' ");
   $result_t=mysqli_fetch_array($query_t);
   $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
   
   $query_c=mysqli_query($con,"select c.nombre_contrato, o.razon_social from contratos as c INNER JOIN contratistas as o On o.id_contratista=c.contratista where c.id_contrato='".$_POST['contrato']."' ");
   $result_c=mysqli_fetch_array($query_c);
   
   # obtener extension de archivo  
   $arch = $_FILES["archivo"]["name"];
   $extension = pathinfo($arch, PATHINFO_EXTENSION);
   
   $carpeta = '../doc/desvinculados/'.$_SESSION['contratista'].'/'.$_POST['contrato'].'/'.$_POST['rut'].'/';
   $nombre='documento_desvinculante_'.$_POST['rut'].'.'.$extension;
   
   $url='doc/desvinculados/'.$_SESSION['contratista'].'/'.$_POST['contrato'].'/'.$_POST['rut'].'/';
                    
   if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
   } 
                               
    $archivo=$carpeta.$nombre;    
                    
    if (file_exists($archivo)) { 
        $existe=TRUE;
    } else {
        $existe=FALSE;
    }
    
    
   $trab=unserialize($result['trabajadores']);
   $car=unserialize($result['cargos']); 
   
   # sacar el trabajadore del arreglo
   $j=0;
   foreach ($trab as $row) {
    if ($row!=$_POST['trabajador']) {
        $lista_trabajadores[$j]=$row;
        //$lista_cargos[$j]=$cargos[$j];
        $j++;
    } else {
        $insert_d=mysqli_query($con,"insert into trabajador_desvinculado_detalle (trabajador,contrato,contratista,usuario,creado,url,comentarios) values ('".$_POST['trabajador']."','".$_POST['contrato']."','".$_SESSION['contratista']."','".$_SESSION['usuario']."','$fecha','$url','".$_POST['comentarios']."') ");
        $posicion_cargo=$j;
    }   
   } 
   
   # saca el cargo del arreglog de cargos
   $i=0;
   $condicion=FALSE;
   foreach ($car as $row) {
      if ($i!=$posicion_cargo ) {
        $lista_cargos[$i]=$row;
          $i++;
      } else {
        $posicion_cargo=-1;
      } 
   }
    
                    
    // Cargando el fichero en la carpeta "subidas"
    if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
        
        $trabajadores=serialize($lista_trabajadores);
        $cargos=serialize($lista_cargos);
            
        #$sql=mysqli_query($con,"update trabajadores_asignados set trabajadores='$trabajadores', cargos='$cargos', editado='$date' where contrato='".$_POST['contrato']."' ");
        
         #$item='Desvincular Trabajador'; 
         #$nivel=3; 
         #$tipo=1;
         #$envia=$_SESSION['lt_contratista'];
         #$recibe=$_SESSION['lt_mandante'];
         #$mensaje="Revsisar documento desvinculante del trabajador <b>$trabajador</b> del contrato <b>".$result['nombre_contrato']."</b>. Contratista <b>".$result_c['razon_social']."</b>";
         #$accion="Revisar Documento";
         #$url="trabajadores_desvinculado.php?contratista=".$_SESSION['contratista']."&contrato=".$_POST['contrato']." ";
         #$query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$_POST['trabajador']."','".$_SESSION['lt_mandante']."','".$_SESSION['lt_contratista']."','$tipo','".$_POST['contrato']."','documento_desvinculante') ");
                            
        
        echo 0;
          
    } else{
        echo 1;
    }    
    

} else { 

echo "<script> window.location.href='index.php'; </script>";
}

    
    

?>