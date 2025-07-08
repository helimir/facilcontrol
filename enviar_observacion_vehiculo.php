
<?php
 session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2) { 
   

    include('config/config.php');

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
   
  date_default_timezone_set('America/Santiago');
  $date = date('Y-m-d H:m:s', time());
  
  $fecha_val='';  
  $user=isset($_SESSION['usuario']) ? $_SESSION['usuario']: '';
  $id=isset($_SESSION['vehiculo']) ? $_SESSION['vehiculo']: '';
  $cargo=isset($_SESSION['cargo']) ? $_SESSION['cargo']: '';
  $contrato=isset($_SESSION['contrato']) ? $_SESSION['contrato']: '';
  $mandante=isset($_SESSION['mandante']) ? $_SESSION['mandante']: '';
  $perfil=isset($_SESSION['perfil']) ? $_SESSION['perfil']: '';
  $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';   
  $usuario=isset($_SESSION['usuario']) ? $_SESSION['usuario']: '';

  $fecha_val_post=isset($_POST['fecha_val']) ? $_POST['fecha_val']: '';
    
  $query_m=mysqli_query($con,"select razon_social from mandantes where id_mandante='".$_SESSION['mandante']."' ");
  $result_m=mysqli_fetch_array($query_m);
  if (isset($result_m['razon_social'])) { $nom_mandante=$result_m['razon_social']; } 
   
   $query_c=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$_SESSION['contrato']."' ");
   $result_c=mysqli_fetch_array($query_c);  
  
    
    function agregar_zip($dir, $zip,$siglas) {
      //verificamos si $dir es un directorio
      $dir_f='documentos_validados_vehiculos_'.$siglas.'/';
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

    function borrar_directorio($dirname) {
      //si es un directorio lo abro
             if (is_dir($dirname))
               $dir_handle = opendir($dirname);
            //si no es un directorio devuelvo false para avisar de que ha habido un error
       if (!$dir_handle)
            return false;
            //recorro el contenido del directorio fichero a fichero
       while($file = readdir($dir_handle)) {
             if ($file != "." && $file != "..") {
                       //si no es un directorio elemino el fichero con unlink()
                  if (!is_dir($dirname."/".$file))
                       unlink($dirname."/".$file);
                  else //si es un directorio hago la llamada recursiva con el nombre del directorio
                       borrar_directorio($dirname.'/'.$file);
             }
       }
       closedir($dir_handle);
      //elimino el directorio que ya he vaciado
       rmdir($dirname);
       return true;
    }
         
   if ($fecha_val_post=='') {
       $fecha_val='Indefinida';
   } else {
       $fecha_val=$fecha_val_post;
   }
      
   $query_con=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
   $result_con=mysqli_fetch_array($query_con);
   $nom_contrato=$result_con['nombre_contrato'];
   
   $query_t=mysqli_query($con,"select * from autos where id_auto='$id' and contratista='$contratista' ");
   $result_t=mysqli_fetch_array($query_t);
   $trabajador=$result_t['tipo'].' '.$result_t['marca'].' '.$result_t['modelo'].' '.$result_t['year'].' '.$result_t['siglas'].'-'.$result_t['control']; 
     
   # data2 mensajes
   $obs=serialize(json_decode(stripslashes($_POST['data2'])));
      
   # data verificados
   $veri=serialize(json_decode(stripslashes($_POST['data'])));
      
   # total de mensajes
   $total=count(json_decode(stripslashes($_POST['data2'])));
   # total de documentos
   $total_doc=count(json_decode(stripslashes($_POST['data3'])));   
         
   $veri2=json_decode(stripslashes($_POST['data']));
   $com=json_decode(stripslashes($_POST['data2']));
   $doc=json_decode(stripslashes($_POST['data3']));
   $id_doc=json_decode(stripslashes($_POST['id_doc']));
   
   $lista_documentos=serialize(json_decode(stripslashes($_POST['id_doc'])));
     
   $total_verificados=false;
   
   $contador=0;
   for ($i=0;$i<=$total-1;$i++) {
        $contador=$contador+$veri2[$i]; 
   }
   
   # si el total de verificados es igual al total de item
   if ($contador==$total) {
       # todos verificados
       $estado=1;       
   } else {
       # no estan todos verificados
       $estado=0;
   }
    
   $query=mysqli_query($con,"select * from observaciones_vehiculo where vehiculo='$id' and cargo='$cargo' and contrato='$contrato' and mandante='$mandante' and estado!='2' ");
   $result=mysqli_fetch_array($query);   
   $existe=mysqli_num_rows($query);
    
    if ($existe==0) { // nuevo
        
        if ($estado==1) { // si todos los docuemtnos fueron verificados            
          $Caracteres = '0123456789';
          $ca = strlen($Caracteres);
          $ca--;
          $Hash = '';
          for ($x = 1; $x <= 6; $x++) {
              $Posicao = rand(0, $ca);
              $Hash .= substr($Caracteres, $Posicao, 1);
          }
        
           $query_doc=mysqli_query($con,"select * from perfiles where id_perfil='$perfil' ");
           $result_doc=mysqli_fetch_array($query_doc);
           $documentos=unserialize($result_doc['doc']);  
            
            
           #$query_rut=mysqli_query($con,"select siglas,control from autos where id_auto='$id' ");
           #$result_rut=mysqli_fetch_array($query_rut);

           $query_rut=mysqli_query($con,"select t.url_foto as foto, t.* from autos as t Left Join vehiculos_asignados as a On a.vehiculos=t.id_auto where t.id_auto='$id' and a.contrato='$contrato' ");
           $result_rut=mysqli_fetch_array($query_rut);
           $patente=$result_rut['patente']; 
           $siglas=$result_rut['siglas'].'-'.$result_rut['control'];

            
           $query_contratista=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
           $result_contratista=mysqli_fetch_array($query_contratista);
          
           $ruta1='doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/';
           $ruta2='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/'.$Hash.'/';
           $rutazip='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/'.$Hash.'/zip/';
               
           if (!file_exists($ruta2)) {
                      mkdir($ruta2, 0777, true);
           } 

           if (!file_exists($rutazip)) {
             mkdir($rutazip, 0777, true);
           }
            foreach ($documentos as $row) {  
              $query_doc=mysqli_query($con,"select * from doc_autos where id_vdoc='$row' ");
              $result_doc=mysqli_fetch_array($query_doc);
              $archivo=$ruta1.$result_doc['documento'].'_'.$siglas.'.pdf';
              $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
              copy($archivo, $archivo_copiar);              
            } 
            $archivo=$ruta1.'foto_'.$contratista.'_'.$siglas.'.jpg'; 
            $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);              
            copy($archivo, $archivo_copiar);

            // actualizar notificacion cuando documentos de contratista estan verificados
            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Vehiculo Recibido'");
            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Vehiculo No Aplica'");
            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Observacion Vehiculo Recibido'");
            mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Foto Vehiculo Recibido'");
            
            mysqli_query($con,"insert into observaciones_vehiculo (vehiculo,perfil,cargo,contrato,mandante,verificados,estado,creado,user,codigo_verificacion,fecha) values ('$id','$perfil','$cargo','$contrato','$mandante','$veri','$estado','$date','$user','$Hash','$date')   ");   
          
            $zip = new ZipArchive();
            # crea archivo zip
            $archivoZip = "documentos_validados_vehiculos_$siglas.zip";
                         
            
            if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                agregar_zip($ruta2, $zip,$siglas);
                $zip->close();
              
                #Muevo el archivo a una ruta
                #donde no se mezcle los zip con los demas archivos
                $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
            }
            
            if ($zip_creado) {
                # cambiar estado en trabajadores asignados a 1 que es acreditado
                mysqli_query($con,"update vehiculos_asignados set verificados=1 where vehiculos='$id' and contrato='$contrato' and estado!='2' ");
                
                # agregar a tabla de trabajador acreditado
                $url_foto='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/'.$Hash.'/foto_'.$contratista.'_'.$siglas.'.jpg';
                mysqli_query($con,"insert into vehiculos_acreditados (vehiculo,contratista,mandante,contrato,documentos,codigo,validez,creado,usuario,cargo,perfil,url_foto) values ('$id','$contratista','$mandante','$contrato','$lista_documentos','$Hash','$fecha_val','$date','$usuario','$cargo','$perfil','$url_foto') ");
            
                #$dirname=$ruta1;
                #$borrar_dir=borrar_directorio($dirname);
                echo 0;   

            } else {
                echo 1;
            }

        # sino estan todos verificados  
        } else {
            $Hash=0;           
                   
            $sql=mysqli_query($con,"insert into observaciones_vehiculo (vehiculo,perfil,cargo,contrato,mandante,verificados,estado,creado,user,codigo_verificacion) values ('$id','$perfil','$cargo','$contrato','$mandante','$veri','$estado','$date','$user','$Hash')   ");        
           
            if ($sql) {            
               
               $query_obs=mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'observaciones_vehiculo' ");
               $auto= mysqli_fetch_array($query_obs); 
               $id_obs=$auto['AUTO_INCREMENT']-1;
                                              
                   for ($i=0;$i<=$total-1;$i++) {
                   
                      # si el documento esta verificado
                      if ($veri2[$i]==1 ) {  
                           mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Documento Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' ");
                           $lista_verificados[$i]=$veri2[$i];
                      # no esta verificado                            
                      } else {
                           $lista_verificados[$i]=$veri2[$i];
                      }

                      mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Documento Vehiculo Recibido'  and control='$doc[$i]' and trabajador='$id' ");
                      mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Documento Vehiculo No Aplica' and control='$doc[$i]' and trabajador='$id' ");
                      mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Foto Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' ");
                      
                      if ($existe_estado_comentario==0) {
                         if ($doc[$i]!="" and $com[$i]!="") {                 
                            
                            
                            mysqli_query($con,"insert into comentarios (id_obs,doc,trabajador,comentarios,creado,user,contratista,mandante,tipo,contrato) values ('$id_obs','".$doc[$i]."','$id','".$com[$i]."','$date','$user','$contratista','$mandante','1','$contrato') ");

                            # notificacion documento con observacion. solo lectura.
                            $item='Observacion Documento Vehiculo'; 
                            $nivel=2; 
                            $tipo=3;
                            $envia=$mandante;
                            $recibe=$contratista;
                            $mensaje="El documento <b>$doc[$i]</b> del vehiculo <b>$trabajador</b> contrato <b>$nom_contrato</b> tiene una observacion.";
                            $accion="Revisar Observacion";
                            $url="verificar_documentos_vehiculos_contratista.php";
                            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,contrato,documento,tipo,trabajador,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$doc[$i]','$mandante','$contratista','$contrato','$doc[$i]','$tipo','$id','$cargo','$perfil') ");
                          
                         }
                      } 
                  }
                
                  # actualizar lista verificados
                  $serial_veri=serialize($lista_verificados);
                  $query_act_veri=mysqli_query($con,"update observaciones_vehiculo set verificados='$serial_veri' where vehiculo='$id' and contrato='$contrato' and estado!='1'  ");

                  # actualizar trabajadores_asignados a estado 2. en proceso.
                  $query_ta=mysqli_query($con,"update vehiculos_asignados set verificados=2, editado='$date' where vehiculos='$id' and contrato='$contrato' and estado!='2' ");
                    
                echo 0;
            } else {
                echo 1;
            }
       }

    } else { // si ya existe
    
       # si todos los docuemtnos fueron verificados 
       if ($estado==1) { 
           
        $Caracteres = '0123456789';
        $ca = strlen($Caracteres);
        $ca--;
        $Hash = '';
        for ($x = 1; $x <= 6; $x++) {
            $Posicao = rand(0, $ca);
            $Hash .= substr($Caracteres, $Posicao, 1);
        }
      
         $query_doc=mysqli_query($con,"select * from perfiles where id_perfil='$perfil' ");
         $result_doc=mysqli_fetch_array($query_doc);
         $documentos=unserialize($result_doc['doc']);  
          
          
         #$query_rut=mysqli_query($con,"select siglas,control from autos where id_auto='$id' ");
         #$result_rut=mysqli_fetch_array($query_rut);

         $query_rut=mysqli_query($con,"select t.url_foto as foto, t.* from autos as t Left Join vehiculos_asignados as a On a.vehiculos=t.id_auto where t.id_auto='$id' and a.contrato='$contrato' ");
         $result_rut=mysqli_fetch_array($query_rut);
         $siglas=$result_rut['patente']; 
         $siglas=$result_rut['siglas'].'-'.$result_rut['control'];

          
         $query_contratista=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
         $result_contratista=mysqli_fetch_array($query_contratista);
        
         $ruta1='doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/';
         $ruta2='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/'.$Hash.'/';
         $rutazip='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/'.$Hash.'/zip/';
             
         if (!file_exists($ruta2)) {
                    mkdir($ruta2, 0777, true);
         } 

         if (!file_exists($rutazip)) {
           mkdir($rutazip, 0777, true);
         }
          foreach ($documentos as $row) {  
            $query_doc=mysqli_query($con,"select * from doc_autos where id_vdoc='$row' ");
            $result_doc=mysqli_fetch_array($query_doc);
            $archivo=$ruta1.$result_doc['documento'].'_'.$siglas.'.pdf';
            $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
            copy($archivo, $archivo_copiar);              
          } 
          $archivo=$ruta1.'foto_'.$contratista.'_'.$siglas.'.jpg'; 
          $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);              
          copy($archivo, $archivo_copiar);

          // actualizar notificacion cuando documentos de contratista estan verificados
          mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Vehiculo Recibido'");
          mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Vehiculo No Aplica'");
          mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Observacion Vehiculo Recibido'");
          mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Foto Vehiculo Recibido'");
          mysqli_query($con,"update observaciones_vehiculo set codigo_verificacion='$Hash', verificados='$veri', estado='$estado', editado='$date', fecha='$fecha_val' where id_obs=".$result['id_obs']." ");
        
          $zip = new ZipArchive();
          # crea archivo zip
          $archivoZip = "documentos_validados_vehiculos_$siglas.zip";
                       
          
          if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
              agregar_zip($ruta2, $zip,$siglas);
              $zip->close();
            
              #Muevo el archivo a una ruta
              #donde no se mezcle los zip con los demas archivos
              $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
          }
          
          if ($zip_creado) {
              # cambiar estado en trabajadores asignados a 1 que es acreditado
              mysqli_query($con,"update vehiculos_asignados set verificados=1 where vehiculos='$id' and contrato='$contrato' and estado!='2' ");
              
              # agregar a tabla de trabajador acreditado
              $url_foto='doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/'.$Hash.'/foto_'.$contratista.'_'.$siglas.'.jpg';
              mysqli_query($con,"insert into vehiculos_acreditados (vehiculo,contratista,mandante,contrato,documentos,codigo,validez,creado,usuario,cargo,perfil,url_foto) values ('$id','$contratista','$mandante','$contrato','$lista_documentos','$Hash','$fecha_val','$date','$usuario','$cargo','$perfil','$url_foto') ");
          
              #$dirname=$ruta1;
              #$borrar_dir=borrar_directorio($dirname);
              echo 0;   

          } else {
              echo 1;
          }

              
      } else {
            $Hash=0;
          
            $query_obs=mysqli_query($con,"select verificados from observaciones_vehiculo where id_obs=".$result['id_obs']." ");
            $result_obs=mysqli_fetch_array($query_obs);
            $verificados=unserialize($result_obs['verificados']); 
            
            $query_con=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='$contrato' ");
            $result_con=mysqli_fetch_array($query_con);
            $nom_contrato=$result_con['nombre_contrato'];
          
            $sql=mysqli_query($con,"update observaciones_vehiculo set codigo_verificacion='$Hash', verificados='$veri', estado='$estado', editado='$date' where id_obs=".$result['id_obs']." ");
            if ($sql) {

               for ($i=0;$i<=$total-1;$i++) {
                   
                  # si el documento esta verificado
                  if ($veri2[$i]==1) {  
                      if ($doc[$i]=='Foto del vehiculo') {
                          mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Observacion Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' ");
                      } else {
                          mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' ");
                          mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Vehiculo No Aplica' and control='$doc[$i]' and trabajador='$id' ");
                          mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Observacion Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' ");
                      }
                      
                      $lista_verificados[$i]=$veri2[$i];
                  } else {
                      $lista_verificados[$i]=$veri2[$i];
                  }
                  
                  $sql_estado_comentario=mysqli_query($con,"select * from comentarios where id_obs='".$result['id_obs']."' and doc='".$doc[$i]."' and leer_mandante=0 "); 
                  $existe_estado_comentario=mysqli_num_rows($sql_estado_comentario); 
                  
                  if ($existe_estado_comentario==0) {
                      # si es un comentario  
                      if ($doc[$i]!="" and $com[$i]!=""  ) {                
                          
                            mysqli_query($con,"insert into comentarios (id_obs,doc,comentarios,creado,user,trabajador,mandante,contratista,tipo,contrato) values ('".$result['id_obs']."','".$doc[$i]."','".$com[$i]."','$date','$user','$id','$mandante','$contratista','1','$contrato') ");
                            
                            # notificacion documento con observacion. solo lectura.
                            $item='Observacion Documento Vehiculo';
                            $nivel=2; 
                            $tipo=3;
                            $envia=$mandante;
                            $recibe=$contratista;
                            $mensaje="El documento <b>$doc[$i]</b> del vehículo <b>$trabajador</b> contrato <b>$nom_contrato</b> tiene una observacion.";
                            $accion="Revisar Observacion";
                            $url="verificar_documentos_vehiculos_contratista.php";
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,contrato,documento,tipo,trabajador,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$doc[$i]','$mandante','$contratista','$contrato','$doc[$i]','$tipo','$id','$cargo','$perfil') ");
                            
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' "); 
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Vehiculo No Aplica' and control='$doc[$i]' and trabajador='$id' "); 
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Foto Vehiculo Recibido' and control='$doc[$i]' and trabajador='$id' "); 
                      }
                  }
                } # fin del for

                # actualizar lista verificados
                $serial_veri=serialize($lista_verificados);
                $query_act_veri=mysqli_query($con,"update observaciones_vehiculo set verificados='$serial_veri' where vehiculo='$id' and contrato='$contrato' and estado!='1'  ");

                # actualizar trabajadores_asignados a estado 2. en proceso.
                #$query_ta=mysqli_query($con,"update trabajadores_asignados set verificados=2, editado='$date' where trabajadores='$id' and contrato='$contrato' and estado!='2' ");

                echo 2;
            } else {
                echo 3;
            }
          
        } 
    }    
        

} else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>