<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    $year = date('Y');
              
    $usuario=$_SESSION['usuario'];          
    
    $trabajador=$_POST["trabajador"];
    $documento=$_POST["doc"];
    $contrato=$_POST["contrato"];
    $mensual=$_POST["mensual"];
    $mes=$_POST["mes"];
    
    $query=mysqli_query($con,"select m.*, c.nombre_contrato from mensuales_trabajador as m INNER JOIN contratos as c ON c.id_contrato=m.contrato where m.mensuales='$mensual' and trabajador='$trabajador' ");
    $result=mysqli_fetch_array($query);
    
    $query_d=mysqli_query($con,"select documento from doc_mensuales where id_dm='$documento' ");
    $result_d=mysqli_fetch_array($query_d);
    
    $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajador' ");
    $result_t=mysqli_fetch_array($query_t);   
             
    # obtener extension de archiv  
    $arch = $_FILES["archivo"]["name"];
    $extension = pathinfo($arch, PATHINFO_EXTENSION);
            
    $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            
    $carpeta = 'doc/mensuales/'.$result['contratista'].'/'.$contrato.'/trabajadores/'.$mes.'-'.$year.'/'.$result_t['rut'].'/';
    $nombre=$documento.'_'.$result_t['rut'].'.'.$extension;
    
    # $carpeta = 'doc/mensuales/'.$result['contratista'].'/'.$result['contrato'].'/trabajadores/'.$mes.'-'.$year.'/'.$result_t['rut'].'/';
    # $nombre=$result_d['documento'].'_'.$result_t['rut'].'.'.$extension;
    
    
                        
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    } 
                               
    $archivo=$carpeta.$nombre;    
                    
    if (file_exists($archivo)) { 
        $existe=TRUE;
    } else {
        $existe=FALSE;
    }
                    
    // Cargando el fichero en la carpeta "subidas"
    if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
                        
                         
                         # si documento del trabajador es reenviado
                         #if ($existe) {
                            # pasar a procesada notificacion de ese documento recibido
                            #$update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Documento Trabajador' and documento='$doc' and contrato='$contrato' and control='$trabajador'  ");
                            
                            # pasar a procesada notificacion de ese observacion de documento
                            #$update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Observacion Documento Trabajador' and documento='$doc' and contrato='$contrato' and control='$trabajador' ");
                        #} 
                            // notificacion documento de trabajador enviado. requiere accion. control id del trabajador
                            #$item='Documento Mensual'; 
                            #$nivel=3; 
                            #$tipo=1;
                            #$envia=$result['contratista'];
                            #$recibe=$result['mandante'];
                            #$mensaje="Revsisar documento <b>".$result_d['documento']."</b> del contrato <b>".$result['nombre_contrato']."</b>. Trabajador <b>$trabajador</b>.";
                            #$accion="Revisar Documento Mensual";
                            #$url="gestion_contratos.php?contratista=".$result['contratista']."&contrato=".$result['contrato']." ";
                            #$query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$result_t['idtrabajador']."','".$result['mandante']."','".$result['contratista']."','$tipo','".$result['contrato']."','".$result_d['documento']."') ");
                            
                            
                            #$query=mysqli_query($con,"update comentarios set leer_contratista=1, leer_mandante=1 where id_com='$com' and doc='".$doc."' ");
                            
              echo 0; 
            } else {
              echo 1;
            }
       
  
     
} else { 

echo '<script> window.location.href="index.php"; </script>';
}
?>