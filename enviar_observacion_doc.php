<?php
 session_start();
if (isset($_SESSION['usuario'])) { 
    include('config/config.php');

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
    
    
    function agregar_zip($dir, $zip) {
      //verificamos si $dir es un directorio
      $dir_f='documentos/';
      if (is_dir($dir)) {
        //abrimos el directorio y lo asignamos a $da
        if ($da = opendir($dir)) {
          //leemos del directorio hasta que termine
    	  
          while (($archivo = readdir($da)) !== false) {
            /*Si es un directorio imprimimos la ruta
             * y llamamos recursivamente esta funci�n
             * para que verifique dentro del nuevo directorio
             * por mas directorios o archivos
             */
            if (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
              $zip->addFile($dir.$archivo, $dir_f.$archivo);
            }
          }
          //cerramos el directorio abierto en el momento
          closedir($da);
        }
      }
    }
    
   
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    $fecha=date('Y-m-d');
   
   $user=$_SESSION['usuario']; 
   $mandante=$_SESSION['mandante'];
   $contratista=$_SESSION['contratista'];

   // documentos seleccionados para verificar   
   $veri=serialize(json_decode(stripslashes($_POST['data'])));
   
   // mensajes de observacion
   $obs=serialize(json_decode(stripslashes($_POST['data2'])));
   $total=count(json_decode(stripslashes($_POST['data2'])));      
   $com=json_decode(stripslashes($_POST['data2']));   
   
   // nombres de documentos
   $doc=json_decode(stripslashes($_POST['data3']));
   $total_doc=count(json_decode(stripslashes($_POST['data3'])));

   $estado=json_decode(stripslashes($_POST['estado']));
   
   $serial_estado=serialize(json_decode(stripslashes($_POST['estado'])));
   
   $veri2=json_decode(stripslashes($_POST['data'])); 
   for ($i=0;$i<=$total-1;$i++) {
      $contador=$contador+$veri2[$i];
   }
   if ($contador==$total) { 
       $estado=1;       
   } else {
       $estado=0;
   }
   
   $ruta_creada=false;
   
   
   $query_m=mysqli_query($con,"select razon_social from mandantes where id_mandante='".$_SESSION['mandante']."' ");
   $result_m=mysqli_fetch_array($query_m);
   $nom_mandante=$result_m['razon_social'];
    
   $query=mysqli_query($con,"select * from doc_observaciones where contratista='$contratista' and mandante='$mandante' and estado=0 ");
   $result=mysqli_fetch_array($query);   
   $existe=mysqli_num_rows($query);
    
   # sino no hay  doc_observacions
   if ($existe==0) { 
                 
        # si estan todos verificado
        if ($estado==1) {
            $query_contratista=mysqli_query($con,"select c.*, d.doc_contratista, m.razon_social as nom_mandante from contratistas as c LEFT JOIN contratistas_mandantes as d On d.contratista=c.id_contratista LEFT JOIN mandantes as m On m.id_mandante=d.mandante where d.contratista='$contratista' and d.mandante='$mandante' ");
            $result_contratista=mysqli_fetch_array($query_contratista);
            $documentos=unserialize($result_contratista['doc_contratista']);
          
          
            $ruta1='doc/temporal/'.$mandante.'/'.$contratista.'/';
            $ruta2='doc/validados/'.$mandante.'/'.$contratista.'/';
            $rutazip='doc/validados/'.$mandante.'/'.$contratista.'/zip/';
         
          
            if ($mandante!='' and $contratista!='') {      
                if (!file_exists($ruta2)) {
                    mkdir($ruta2, 0777, true);
                    $ruta_creada=true;
                }
                if (!file_exists($rutazip)) {
                    mkdir($rutazip, 0777, true);
                    $ruta_creada=true;
                }
            }


            $d=0;
            foreach ($documentos as $row) {  
                $query_doc=mysqli_query($con,"select * from doc_subidos_contratista where id_documento='$row' and mandante='$mandante' and contratista='$contratista' ");
                $result_doc=mysqli_fetch_array($query_doc);
                
                $archivo=$result_doc['url'];
                $urls[$d]=str_replace('doc/temporal/','doc/validados/',$result_doc['url']);

                $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);                            
                $copiado=copy($archivo, $archivo_copiar);
                $d=$d+1;
            }
          
         
         if ($copiado) {
            
              $urls_serial=serialize($urls);   
              mysqli_query($con,"insert into doc_observaciones (contratista,mandante,verificados,estado,creado,user,fecha,urls) values ('$contratista','$mandante','$veri','$estado','$date','$user','$date','$urls_serial')   ");
              mysqli_query($con,"update contratistas set acreditada=1 where id_contratista='$contratista' ");              
              mysqli_query($con,"update contratistas_mandantes set acreditada=1 where contratista='$contratista' and mandante='$mandante' ");
          
              # procesada. control nombre del documento
              #mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' "); 
              mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Verificado' ");                                      
              mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' ");                       
              mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' ");
              mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' ");
                
              $nom_contratista=$result_contratista['razon_social'];    
              $nom_mandante=$result_contratista['nom_mandante'];
              $rut=$result_contratista['rut'];
             
              $zip = new ZipArchive();
              # crea archivo zip
              $archivoZip = "documentos_validados_contratista_$rut.zip";
                           
              
              if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                  agregar_zip($ruta2, $zip);
                  $zip->close();
                
                  #Muevo el archivo a una ruta
                  #donde no se mezcle los zip con los demas archivos
                  $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
              }
              
             
              echo 0;
         } else {
              echo 1;
         }
        
        # sino estan todos verificados   
        }  else {        
        
            $sql=mysqli_query($con,"insert into doc_observaciones (contratista,mandante,verificados,estado,creado,user,control,fecha) values ('$contratista','$mandante','$veri','$estado','$date','$user','2','$date')   ");        
            if ($sql) {    

                #$query_doc_very=mysqli_query($con,"select verificados from doc_observaciones where contratista='$contratista' and mandante='$mandante' ");
                #$result_doc_very=mysqli_fetch_array($query_doc_very);

                #y=unserialize($veri); 
            
                # actualizar doc_observaciones
                #mysqli_query($con,"update doc_observaciones set verificados='$veri', estado='$estado', control='2', editado='$date' where id_dobs='".$result['id_dobs']."' ");
                    
                $cont_doc=count(json_decode(stripslashes($_POST['data']))); ;
                $arreglo_doc=unserialize($veri);
                $contador=0;
                    
                // seleccionar id de documento
                $query_doc_contratista=mysqli_query($con,"select doc_contratista from contratistas_mandantes where contratista='$contratista' and mandante='$mandante' ");
                $result_doc_contratista=mysqli_fetch_array($query_doc_contratista);
                $doc_contratista=unserialize($result_doc_contratista['doc_contratista']);
                    
                // consulta sobre contratita 
                $query_contratista=mysqli_query($con,"select c.*, o.id_contrato from contratistas as c left join contratos as o On o.contratista=c.id_contratista where c.id_contratista='$contratista' ");
                $result_contratista=mysqli_fetch_array($query_contratista);
                $nom_contratista=$result_contratista['razon_social'];
                $contrato=$result_contratista['id_contrato'];
                              
                for ($contador=0;$contador<=$cont_doc-1;$contador++) { 
                        
                        $query_tipo_doc=mysqli_query($con,"select documento from doc_contratistas where id_cdoc='".$doc_contratista[$contador]."' ");
                        $result_tipo_doc=mysqli_fetch_array($query_tipo_doc);
                        $nombre_doc=$result_tipo_doc['documento'];
                                        
                        // si el dccumento es estaoo verificado
                        if ($arreglo_doc[$contador]==1 and $doc_very[$contador]==0 ) {                           
                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$nombre_doc' "); 
                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' and control='$nombre_doc'  "); 
                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' and control='$nombre_doc'  ");                            
                        }
                }    

               
                    
                $query_obs=mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'doc_observaciones' ");
                $auto= mysqli_fetch_array($query_obs); 
                $id_dobs=$auto['AUTO_INCREMENT']-1; 
                    
                for ($i=0;$i<=$total-1;$i++) {       
                      if ($estado!=1) {
                          if ($doc[$i]!="" and $com[$i]!=""  ) {        
                                $query_com=mysqli_query($con,"insert into doc_comentarios (id_dobs,doc,comentarios,creado,user,mandante,contratista) values ('".$id_dobs."','".$doc[$i]."','".$com[$i]."','$date','$user','$mandante','$contratista') ");
                                // notificacion de observacion. control nombre del documento. requiere accion.    
                                $item='Observacion de Documento';
                                $nivel=2; 
                                $tipo=1;
                                $usuario=$_SESSION['usuario']; 
                                $envia=$mandante;
                                $recibe=$contratista; 
                                $mensaje="El mandante <b>".$nom_mandante."</b> envio una observacion del documento <b>$doc[$i]</b>.";
                                $accion="Revisar documento";
                                $url="gestion_documentos.php";
                                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$doc[$i]','$contrato') ");
                                
                                # pasar a procesada notificacion de ese documento recibido
                                mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' and control='$doc[$i]' "); 
                                mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$doc[$i]'  "); 
                          }
                    }
                }

               
                echo 0;
            } else {
                echo 1;
            }
      }      
    
################################################ si ya hay  doc_observacions ####################################################################
    } else { 
        
        # si documentos estan verificados
        if ($estado==1) {        
                                             
                   $query_contratista=mysqli_query($con,"select d.doc_contratista, c.* from contratistas as c LEFT JOIN contratistas_mandantes as d On d.contratista=c.id_contratista where d.contratista='$contratista' and d.mandante='$mandante'  ");
                   $result_contratista=mysqli_fetch_array($query_contratista);
                   $documentos=unserialize($result_contratista['doc_contratista']); 
                  
                  $ruta1='doc/temporal/'.$mandante.'/'.$contratista.'/';
                  $ruta2='doc/validados/'.$mandante.'/'.$contratista.'/';
                  $rutazip='doc/validados/'.$mandante.'/'.$contratista.'/zip/';
                                   
                  
                  if ($mandante!='' and $contratista!='') {      
                      if (!file_exists($ruta2)) {
                          mkdir($ruta2, 0777, true);
                          $ruta_creada=true;
                      }
                      if (!file_exists($rutazip)) {
                        mkdir($rutazip, 0777, true);
                        $ruta_creada=true;
                    }
                  }
                  
                    $d=0;
                foreach ($documentos as $row) {  
                    $query_doc=mysqli_query($con,"select * from doc_subidos_contratista where id_documento='$row' and mandante='$mandante' and contratista='$contratista' ");
                    $result_doc=mysqli_fetch_array($query_doc);
                            
                    $archivo=$result_doc['url'];
                    $urls[$d]=str_replace('doc/temporal/','doc/validados/',$result_doc['url']);
                            
                    $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);                            
                    $copiado=copy($archivo, $archivo_copiar);
                    $d=$d+1;
                }
                 
                $urls_serial=serialize($urls);
                mysqli_query($con,"update contratistas set acreditada=1 where id_contratista='$contratista' ");                      
                mysqli_query($con,"update contratistas_mandantes set acreditada=1 where contratista='$contratista' and mandante='$mandante' ");
                    
                # actualizar doc_observaciones
                mysqli_query($con,"update doc_observaciones set verificados='$veri', estado='$estado', editado='$date', urls='$urls_serial' where id_dobs=".$result['id_dobs']." ");                     
                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and documento='$row' "); 
                #mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and documento='$row' "); 
                      
                # actualizar notificacion cuando documentos de contratista estan verificados
                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Verificado' ");                                      
                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' ");                       
                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' ");
                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' ");
                      
                $rut=$result_contratista['rut']; 
                                 
                $zip = new ZipArchive();
                # crea archivo zip
                $archivoZip = "documentos_validados_contratista_$rut.zip";
                if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                          agregar_zip($ruta2, $zip);
                          $zip->close();
                        
                          #Muevo el archivo a una ruta
                          #donde no se mezcle los zip con los demas archivos
                          rename($archivoZip, "$rutazip/$archivoZip");
                }    
                echo 0;               

        # sino estan todos verificados 
        } else {
        
                $query_doc_very=mysqli_query($con,"select verificados from doc_observaciones where contratista='$contratista' and mandante='$mandante' ");
                $result_doc_very=mysqli_fetch_array($query_doc_very);
                $doc_very=unserialize($result_doc_very['verificados']); 
            
                # actualizar doc_observaciones
                $sql=mysqli_query($con,"update doc_observaciones set verificados='$veri', estado='$estado', control='2', editado='$date' where id_dobs='".$result['id_dobs']."' ");
                
                if ($sql) {
                    
                    $cont_doc=count(json_decode(stripslashes($_POST['data']))); ;
                    $arreglo_doc=unserialize($veri);
                    $contador=0;
                    
                    // seleccionar id de documento
                    $query_doc_contratista=mysqli_query($con,"select doc_contratista from contratistas_mandantes where contratista='$contratista' and mandante='$mandante' ");
                    $result_doc_contratista=mysqli_fetch_array($query_doc_contratista);
                    $doc_contratista=unserialize($result_doc_contratista['doc_contratista']);
                    
                    // consulta sobre contratita 
                    $query_contratista=mysqli_query($con,"select c.*, o.id_contrato from contratistas as c left join contratos as o On o.contratista=c.id_contratista where c.id_contratista='$contratista' ");
                    $result_contratista=mysqli_fetch_array($query_contratista);
                    $nom_contratista=$result_contratista['razon_social'];
                    $contrato=$result_contratista['id_contrato'];
                              
                    for ($contador=0;$contador<=$cont_doc-1;$contador++) { 
                        
                        $query_tipo_doc=mysqli_query($con,"select documento from doc_contratistas where id_cdoc='".$doc_contratista[$contador]."' ");
                        $result_tipo_doc=mysqli_fetch_array($query_tipo_doc);
                        $nombre_doc=$result_tipo_doc['documento'];
                                        
                        // si el dccumento es estaoo verificado
                        if ($arreglo_doc[$contador]==1 and $doc_very[$contador]==0 ) {                           
                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$nombre_doc' "); 
                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' and control='$nombre_doc'  "); 
                            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' and control='$nombre_doc'  ");                            
                        }
                    }    
                    
                    
                   for ($i=0;$i<=$total-1;$i++) {                      
                      $sql_estado_comentario=mysqli_query($con,"select * from doc_comentarios where id_dobs='".$result['id_dobs']."' and doc='".$doc[$i]."' and leer_mandante=0 ");
                      $result_estado_comentario=mysqli_fetch_array($sql_estado_comentario);
                      
                      $existe_estado_comentario=mysqli_num_rows($sql_estado_comentario);                       
                      
                      if ($existe_estado_comentario==0 and $estado!=1) {

                          if ($doc[$i]!="" and $com[$i]!=""  ) {                
                          
                                $query_com=mysqli_query($con,"insert into doc_comentarios (id_dobs,doc,comentarios,creado,user,mandante,contratista) values ('".$result['id_dobs']."','".$doc[$i]."','".$com[$i]."','$date','$user','$mandante','$contratista') ");
                                    
                                // notificacion de observacion. control nombre del documento. requiere accion.    
                                $item='Observacion de Documento';
                                $nivel=2; 
                                $tipo=1;
                                $usuario=$_SESSION['usuario']; 
                                $envia=$mandante;
                                $recibe=$contratista; 
                                $mensaje="El mandante <b>".$nom_mandante."</b> envio una observacion del documento <b>$doc[$i]</b>.";
                                $accion="Revisar documento";
                                $url="gestion_documentos.php";
                                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$doc[$i]','$contrato') ");
                                
                                # pasar a procesada notificacion de ese documento recibido
                                mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento Recibido' and control='$doc[$i]' "); 
                                mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$doc[$i]'  "); 
                                
                          }
                     }  
                    }
                    
                    echo 0;
                } else {
                    echo 1;
                }
        }
    }    
        

} else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
