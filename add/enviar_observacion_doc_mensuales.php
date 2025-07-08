<?php
 session_start();
if (isset($_SESSION['usuario'])) { 
    include('../config/config.php');
   
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
   
   $user=$_SESSION['usuario']; 
   $mandante=$_SESSION['mandante'];
   $contratista=$_SESSION['doc_contratista'];
      
   $veri=serialize(json_decode(stripslashes($_POST['data'])));
   $obs=serialize(json_decode(stripslashes($_POST['data2'])));
   $total=count(json_decode(stripslashes($_POST['data2'])));  
      
   $com=json_decode(stripslashes($_POST['data2']));   
   $doc=json_decode(stripslashes($_POST['data3']));
   $total_doc=count(json_decode(stripslashes($_POST['data3'])));
   
   $veri2=json_decode(stripslashes($_POST['data'])); 
   for ($i=0;$i<=$total-1;$i++) {
      $contador=$contador+$veri2[$i];
   }
   if ($contador==$total) { 
       $estado=1;       
   } else {
       $estado=0;
   }
    
   $query=mysqli_query($con,"select * from mensuales where contratista='$contratista' and mandante='$mandante' ");
   $result=mysqli_fetch_array($query);   
   $existe=mysqli_num_rows($query);
    
    if ($existe==0) { // nuevo
                 
        
        if ($estado==1) {
            $query_contratista=mysqli_query($con,"select * from contratistas where id_contratista='$contratista' ");
            $result_contratista=mysqli_fetch_array($query_contratista);
            $documentos=unserialize($result_contratista['doc_contratista']);
            
            $ruta1='../doc/contratistas/'.$contratista.'/';
            $ruta2='../doc/contratistas/acreditadas/'.$contratista.'/';
                 
            if (!file_exists($ruta2)) {
                        mkdir($ruta2, 0777, true);
            }
              
            foreach ($documentos as $row) {  
                $query_doc=mysqli_query($con,"select * from doc_mensuales where id_dm='$row' ");
                $result_doc=mysqli_fetch_array($query_doc);
                $archivo=$ruta1.$result_doc['documento'].'_'.$result_contratista['rut'].'.pdf';
                $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                copy($archivo, $archivo_copiar);                
           } 
           
          # actualizar notificacion cuando documentos de contratista estan verificados
          #$update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Gestion de Contratista' ");
          
          # procesada. control nombre del documento
          $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contratista='$contratista' and item='Documento Recibido' and control='$nombre_doc' "); 
         
          
           
        } else {
        
        
            $sql=mysqli_query($con,"insert into mensuales (contratista,mandante,verificados,estado,creado,user) values ('$contratista','$mandante','$veri','$estado','$date','$user')   ");        
            if ($sql) {    
                
                $cont_doc=count(json_decode(stripslashes($_POST['data']))); ;
                $arreglo_doc=unserialize($veri);
                $contador=0;
                $query_doc_contratista=mysqli_query($con,"select doc_contratista_mensuales from contratistas where id_contratista='$contratista' ");
                $result_doc_contratista=mysqli_fetch_array($query_doc_contratista);
                $doc_contratista=unserialize($result_doc_contratista['doc_contratista_mensuales']);
                
                
                    for ($contador=0;$contador<=$cont_doc-1;$contador++) {
                                        
                        $query_tipo_doc=mysqli_query($con,"select documento from doc_mensuales where id_dm='".$doc_contratista[$contador]."' ");
                        $result_tipo_doc=mysqli_fetch_array($query_tipo_doc);
                        $nombre_doc=$result_tipo_doc['documento'];
                        
                        if ($arreglo_doc[$contador]==1 and $estado!=1) {
                            
                            // notificacion documento verificado
                            $item='Documento Verificado';
                            $nivel=2;
                            $envia=$mandante;
                            $recibe=$contratista;
                            $mensaje="El documento <b>$nombre_doc</b> ha sido verificado.";
                            $accion="Revisar documentacion";
                            $url="gestion_documentos.php";
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url') ");
                          
                           // procesada. control nombre del documento
                            $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contratista='$contratista' and item='Documento Recibido' and control='$nombre_doc' "); 
                            
                        }
                    }           
                    
                    $query_obs=mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'mensuales' ");
                    $auto= mysqli_fetch_array($query_obs); 
                    $id_dobs=$auto['AUTO_INCREMENT']-1;            
                  
                    $cont_varificfos=0;
                    for ($i=0;$i<=$total-1;$i++) {
                      if ($doc[$i]!="" and $com[$i]!="") {                         
                        $query_com=mysqli_query($con,"insert into doc_comentarios_mensuales (id_dobs,doc,comentarios,creado,user) values ('$id_dobs','".$doc[$i]."','".$com[$i]."','$date','$user') ");
                        // notificacion de observacio     
                           $item='Observacion de Documento';
                           $nivel=2;
                           $envia=$mandante;
                           $recibe=$contratista;
                           $mensaje="Revisar el documento <b>$doc[$i]</b> tiene una observacion.";
                           $accion="Revisar documentacion";
                           $url="gestion_documentos.php";
                           $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url') ");
                        
                      }  
                    } 
                 
                echo 0;
            } else {
                echo 1;
            }
      }      
    
#### actualizar    
    } else { 
        
        # si documentos estan verificados
        if ($estado==1) {       
                                             
                 
                  # procesar notificacion de Observacion Enviada
                  $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Observacion de Documento' ");
                  
                  # actualizar notificacion cuando documentos de contratista estan verificados
                  # $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Gestion de Contratista' ");
         }
        
        $query_doc_very=mysqli_query($con,"select verificados from mensuales where contratista='$contratista' ");
        $result_doc_very=mysqli_fetch_array($query_doc_very);
        $doc_very=unserialize($result_doc_very['verificados']); 
    
        $sql=mysqli_query($con,"update mensuales set verificados='$veri', estado='$estado', editado='$date' where id_m=".$result['id_m']." ");
        if ($sql) {
            
            $cont_doc=count(json_decode(stripslashes($_POST['data']))); ;
            $arreglo_doc=unserialize($veri);
            $contador=0;
            
            // seleccionar id de documento
            $query_doc_contratista=mysqli_query($con,"select doc_contratista_mensuales from contratistas where id_contratista='$contratista' ");
            $result_doc_contratista=mysqli_fetch_array($query_doc_contratista);
            $doc_contratista=unserialize($result_doc_contratista['doc_contratista']);
            
            // consulta sobre contratita 
            $query_contratista=mysqli_query($con,"select c.*, o.id_contrato from contratistas as c left join contratos as o On o.contratista=c.id_contratista where c.id_contratista='$contratista' ");
            $result_contratista=mysqli_fetch_array($query_contratista);
            $nom_contratista=$result_contratista['razon_social'];
            $contrato=$result_contratista['id_contrato'];
                      
            for ($contador=0;$contador<=$cont_doc-1;$contador++) { 
                
                // seleccionar el nombre del docuemnto                
                $query_tipo_doc=mysqli_query($con,"select documento from doc_mensuales where id_dm='".$doc_contratista[$contador]."' ");
                $result_tipo_doc=mysqli_fetch_array($query_tipo_doc);
                $nombre_doc=$result_tipo_doc['documento'];
                                
                // si el item es estaoo verificado
                if ($arreglo_doc[$contador]==1 and $doc_very[$contador]==0 ) {                          
                   
                   // notificacion de documento verificado       
                   $item='Documento Verificado';
                   $nivel=2;
                   $envia=$mandante;
                   $recibe=$contratista;
                   $mensaje="El documento <b>$nombre_doc</b> ha sido verificado.";
                   $accion="Revisar documentacion";
                   $url="gestion_documentos.php";
                   $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url') ");
                   
                   // pasar a procesada notificacion Documento Recibido. Mandante
                   $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contratista='$contratista' and item='Documento Recibido' and control='$nombre_doc' ");  
                   
                   // pasar a procesada notificacion observacion de documento. Contratatista
                   $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contratista='$contratista' and item='Observacion de Documento' and control='$nombre_doc' ");
                }
            }    
            
            
           for ($i=0;$i<=$total-1;$i++) {
              
              $sql_estado_comentario=mysqli_query($con,"select * from doc_comentarios_mensuales where id_dobs='".$result['id_m']."' and doc='".$doc[$i]."' and leer_mandante=0 ");
              $existe_estado_comentario=mysqli_num_rows($sql_estado_comentario); 
              
              if ($existe_estado_comentario==0 and $estado!=1) {
                  if ($doc[$i]!="" and $com[$i]!=""  ) {                
                  
                   $query_com=mysqli_query($con,"insert into doc_comentarios_mensuales (id_dobs,doc,comentarios,creado,user) values ('".$result['id_m']."','".$doc[$i]."','".$com[$i]."','$date','$user') ");
                    
                   // notificacion de observacion. control nombre del documento. requiere accion.    
                   $item='Observacion de Documento';
                   $nivel=2;
                   $tipo=1;
                   $envia=$mandante;
                   $recibe=$contratista; 
                   $mensaje="Documento <b>$doc[$i]</b> de la Contratista <b>$nom_contratista</b> tiene una observacion.";
                   $accion="Revisar documento";
                   $url="gestion_documentos.php";
                   $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$user','$url','$tipo','$mandante','$contratista','$doc[$i]','$contrato') ");
                   
                   # pasar a procesada notificacion de ese documento recibido
                    $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Documento Recibido' and control='$doc[$i]' "); 
                  }
             }  
            }
            
            
            
             
            echo 2;
        } else {
            echo 3;
        }
    }    
        

} else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
