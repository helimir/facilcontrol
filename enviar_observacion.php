<?php
 session_start();
if (isset($_SESSION['usuario'])) { 
    include('config/config.php');

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
   
   date_default_timezone_set('America/Santiago');   
   $date = date('Y-m-d H:m:s', time());
   
   $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
   $control_foto=isset($_POST['control_foto']) ? $_POST['control_foto']: '';
   $rut=isset($_POST['rut']) ? $_POST['rut']: '';

   $user=$_SESSION['usuario']; 
   $id=$_SESSION['trabajador'];
   $cargo=$_SESSION['cargo'];
   $contrato=$_SESSION['contrato'];
   $mandante=$_SESSION['mandante'];
   $perfil=$_SESSION['perfil'];     
   $usuario=$_SESSION['usuario'];
    
   $query_m=mysqli_query($con,"select razon_social from mandantes where id_mandante='".$mandante."' ");
   $result_m=mysqli_fetch_array($query_m);
   $nom_mandante=$result_m['razon_social'];
   
   $query_c=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$contrato."' ");
   $result_c=mysqli_fetch_array($query_c);  
    
    function agregar_zip($dir, $zip,$rut_t) {
      //verificamos si $dir es un directorio
      $dir_f='documentos_validados_trabajador_'.$rut_t.'/';
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
         
   if ($_POST['fecha_val']=='') {
       $fecha_val='Indefinida';
   } else {
       $fecha_val=$_POST['fecha_val'];
   }
      
   $query_con=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
   $result_con=mysqli_fetch_array($query_con);
   $nom_contrato=$result_con['nombre_contrato'];
   
   $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$id' ");
   $result_t=mysqli_fetch_array($query_t);
   $trabajador=$result_t['nombre1'].' '.$result_t['apellido1']; 
   
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
    
   $query=mysqli_query($con,"select * from observaciones where trabajador='$id' and cargo='$cargo' and contrato='$contrato' and mandante='$mandante' and estado!='2' ");
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
              
              
             $query_rut=mysqli_query($con,"select t.url_foto as foto, t.* from trabajador as t Left Join trabajadores_asignados as a On a.trabajadores=t.idtrabajador where t.idtrabajador='$id' and a.contrato='$contrato' ");
             $result_rut=mysqli_fetch_array($query_rut);
              
             $query_contratista=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
             $result_contratista=mysqli_fetch_array($query_contratista);
            
             $ruta1='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/';
             $ruta2='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/'.$Hash.'/';
             $rutazip='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/'.$Hash.'/zip/';
                 
             if (!file_exists($ruta2)) {
                        mkdir($ruta2, 0777, true);
             } 

             if (!file_exists($rutazip)) {
               mkdir($rutazip, 0777, true);
             }
              foreach ($documentos as $row) {  
                $query_doc=mysqli_query($con,"select * from doc where id_doc='$row' ");
                $result_doc=mysqli_fetch_array($query_doc);
                $archivo=$ruta1.$result_doc['documento'].'_'.$result_rut['rut'].'.pdf';                                
                $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                copy($archivo, $archivo_copiar);                
              } 
              $archivo=$ruta1.'foto_'.$contratista.'_'.$result_rut['rut'].'.jpg'; 
              $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);              
              copy($archivo, $archivo_copiar);

              #mysqli_query($con,"insert into prueba (valor) values ('".$result_rut['rut']."') ");
              // actualizar notificacion cuando documentos de contratista estan verificados
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Trabajador Recibido' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Trabajador Recibido' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Observacion Documento Trabajador' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Foto Trabajador Recibido' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Trabajador No Aplica' and trabajador='$id' ");
                           
              mysqli_query($con,"insert into observaciones (trabajador,perfil,cargo,contrato,mandante,verificados,estado,creado,user,codigo_verificacion,fecha) values ('$id','$perfil','$cargo','$contrato','$mandante','$veri','$estado','$date','$user','$Hash','$date')   ");   

              $rut_t=$result_rut['rut'];
              $zip = new ZipArchive();
              # crea archivo zip
              $archivoZip = "documentos_validados_trabajador_$rut_t.zip";
                           
              
              if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                  agregar_zip($ruta2, $zip,$rut_t);
                  $zip->close();
                
                  #Muevo el archivo a una ruta
                  #donde no se mezcle los zip con los demas archivos
                  $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
              }
              
              if ($zip_creado) {
                  # cambiar estado en trabajadores asignados a 1 que es acreditado
                  mysqli_query($con,"update trabajadores_asignados set verificados=1 where trabajadores='$id' and contrato='$contrato' and estado!='2' ");
                  
                  # agregar a tabla de trabajador acreditado
                  $url_foto='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/'.$Hash.'/foto_'.$contratista.'_'.$result_rut['rut'].'.jpg';
                  mysqli_query($con,"insert into trabajadores_acreditados (trabajador,contratista,mandante,contrato,documentos,codigo,validez,creado,usuario,cargo,perfil,url_foto) values ('$id','$contratista','$mandante','$contrato','$lista_documentos','$Hash','$fecha_val','$date','$usuario','$cargo','$perfil','$url_foto') ");
              
                  #$dirname=$ruta1;
                  #$borrar_dir=borrar_directorio($dirname);
                  echo 0;   

              } else {
                  echo 1;
              }

        # sino estan todos verificados  
        } else {
            $Hash=0;           
                   
            $sql=mysqli_query($con,"insert into observaciones (trabajador,perfil,cargo,contrato,mandante,verificados,estado,creado,user,codigo_verificacion) values ('$id','$perfil','$cargo','$contrato','$mandante','$veri','$estado','$date','$user','$Hash')   ");        
           
            if ($sql) {            
               
               $query_obs=mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'observaciones' ");
               $auto= mysqli_fetch_array($query_obs); 
               $id_obs=$auto['AUTO_INCREMENT']-1;
                                              
                   for ($i=0;$i<=$total-1;$i++) {
                   
                      # si el documento esta verificado
                      if ($veri2[$i]==1 ) {  
                           mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Documento Trabajador Recibido' and control='$doc[$i]' and trabajador='$id' ");
                           mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Foto Trabajador Recibido' and control='$doc[$i]' and trabajador='$id' ");
                           $lista_verificados[$i]=$veri2[$i];
                      # no esta verificado                            
                      } else {
                           $lista_verificados[$i]=$veri2[$i];
                      }
                      
                      if ($existe_estado_comentario==0) {
                         if ($doc[$i]!="" and $com[$i]!="") {                 
                            
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Documento Trabajador Recibido'  and control='$doc[$i]' and trabajador='$id' ");
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Documento Trabajador No Aplica' and control='$doc[$i]' and trabajador='$id' ");
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Foto Trabajador Recibido' and trabajador='$id' ");
                            mysqli_query($con,"insert into comentarios (id_obs,doc,trabajador,comentarios,creado,user,contratista,mandante,contrato) values ('$id_obs','".$doc[$i]."','$id','".$com[$i]."','$date','$user','$contratista','$mandante','$contrato') ");

                            # notificacion documento con observacion. solo lectura.
                            $item='Observacion Documento Trabajador'; 
                            $nivel=2; 
                            $tipo=2;
                            $envia=$mandante;
                            $recibe=$contratista;
                            $mensaje="El documento <b>$doc[$i]</b> del trabajador <b>$trabajador</b> contrato <b>$nom_contrato</b> tiene una observacion.";
                            $accion="Revisar Observacion";
                            $url="verificar_documentos_trabajador_contratista.php";
                            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,contrato,documento,tipo,trabajador,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$doc[$i]','$mandante','$contratista','$contrato','$doc[$i]','$tipo','$id','$cargo','$perfil') ");
                          
                         }
                      } 
                  }
                
                  # actualizar lista verificados
                  $serial_veri=serialize($lista_verificados);
                  $query_act_veri=mysqli_query($con,"update observaciones set verificados='$serial_veri' where trabajador='$id' and contrato='$contrato' and estado!='1'  ");

                  # actualizar trabajadores_asignados a estado 2. en proceso.
                  $query_ta=mysqli_query($con,"update trabajadores_asignados set verificados=2, editado='$date' where trabajadores='$id' and contrato='$contrato' and estado!='2' ");
                    
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
              
             
             $query_rut=mysqli_query($con,"select a.url_foto as foto, t.* from trabajador as t Left Join trabajadores_asignados as a On a.trabajadores=t.idtrabajador where t.idtrabajador='$id' and a.contrato='$contrato' ");
             $result_rut=mysqli_fetch_array($query_rut);
              
             $query_contratista=mysqli_query($con,"select * from contratos where id_contrato='$contrato' ");
             $result_contratista=mysqli_fetch_array($query_contratista);
            
             $ruta1='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/';
             $ruta2='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/'.$Hash.'/';
             $rutazip='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/'.$Hash.'/zip/';
                 
             if (!file_exists($ruta2)) {
                        mkdir($ruta2, 0777, true);
             } 

             if (!file_exists($rutazip)) {
               mkdir($rutazip, 0777, true);
             }
              foreach ($documentos as $row) {  
                $query_doc=mysqli_query($con,"select * from doc where id_doc='$row' ");
                $result_doc=mysqli_fetch_array($query_doc);
                $archivo=$ruta1.$result_doc['documento'].'_'.$result_rut['rut'].'.pdf';                  
                $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                copy($archivo, $archivo_copiar);                
              } 
              $archivo=$ruta1.'foto_'.$contratista.'_'.$result_rut['rut'].'.jpg'; 
              $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);              
              copy($archivo, $archivo_copiar);


              // actualizar notificacion cuando documentos de contratista estan verificados
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Trabajador Recibido' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Trabajador Recibido' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Observacion Documento Trabajador' and trabajador='$id' ");
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Foto Trabajador Recibido' and trabajador='$id' ");     
              mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and contrato='$contrato' and item='Documento Trabajador No Aplica' and trabajador='$id' ");         
              mysqli_query($con,"update observaciones set codigo_verificacion='$Hash', verificados='$veri', estado='$estado', editado='$date', fecha='$fecha_val' where id_obs=".$result['id_obs']." ");
                            
              
              $rut_t=$result_rut['rut'];
              $zip = new ZipArchive();
              # crea archivo zip
              $archivoZip = "documentos_validados_trabajador_$rut_t.zip";
                           
              
              if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                  agregar_zip($ruta2, $zip,$rut_t);
                  $zip->close();
                
                  #Muevo el archivo a una ruta
                  #donde no se mezcle los zip con los demas archivos
                  $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
              }
              
              if ($zip_creado) {
                  # cambiar estado en trabajadores asignados a 1 que es acreditado
                  mysqli_query($con,"update trabajadores_asignados set verificados=1 where trabajadores='$id' and contrato='$contrato' and estado!='2' ");
                  
                  # agregar a tabla de trabajador acreditado
                  $url_foto='doc/validados/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_rut['rut'].'/'.$Hash.'/foto_'.$contratista.'_'.$result_rut['rut'].'.jpg';
                  mysqli_query($con,"insert into trabajadores_acreditados (trabajador,contratista,mandante,contrato,documentos,codigo,validez,creado,usuario,cargo,perfil,url_foto) values ('$id','$contratista','$mandante','$contrato','$lista_documentos','$Hash','$fecha_val','$date','$usuario','$cargo','$perfil','$url_foto') ");
              
                  #$dirname=$ruta1;
                  #$borrar_dir=borrar_directorio($dirname);
                  echo 0;   

              } else {
                  echo 1;
              }

              
      } else {
            $Hash=0;
          
            $query_obs=mysqli_query($con,"select verificados from observaciones where id_obs=".$result['id_obs']." ");
            $result_obs=mysqli_fetch_array($query_obs);
            $verificados=unserialize($result_obs['verificados']); 
            
            $query_con=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='$contrato' ");
            $result_con=mysqli_fetch_array($query_con);
            $nom_contrato=$result_con['nombre_contrato'];
          
            $sql=mysqli_query($con,"update observaciones set codigo_verificacion='$Hash', verificados='$veri', estado='$estado', editado='$date' where id_obs=".$result['id_obs']." ");
            if ($sql) {

               for ($i=0;$i<=$total-1;$i++) {
                   
                  # si el documento esta verificado
                  if ($veri2[$i]==1) {                      
                        mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Observacion Documento Trabajador' and control='$doc[$i]' and trabajador='$id' ");
                        mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Trabajador Recibido' and control='$doc[$i]' and trabajador='$id' ");
                        mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and item='Foto Trabajador Recibido' and control='$doc[$i]' and trabajador='$id' ");
                         $lista_verificados[$i]=$veri2[$i];
                  } else {
                      $lista_verificados[$i]=$veri2[$i];
                  }
                  
                  $sql_estado_comentario=mysqli_query($con,"select * from comentarios where id_obs='".$result['id_obs']."' and doc='".$doc[$i]."' and leer_mandante=0 "); 
                  $existe_estado_comentario=mysqli_num_rows($sql_estado_comentario); 
                  
                  if ($existe_estado_comentario==0) {
                      # si es un comentario  
                      if ($doc[$i]!="" and $com[$i]!=""  ) {                
                          
                            $query_com=mysqli_query($con,"insert into comentarios (id_obs,doc,comentarios,creado,user,trabajador,mandante,contratista,contrato) values ('".$result['id_obs']."','".$doc[$i]."','".$com[$i]."','$date','$user','$id','$mandante','$contratista','$contrato') ");
                            
                            # notificacion documento con observacion. solo lectura.
                            $item='Observacion Documento Trabajador';
                            $nivel=2; 
                            $tipo=2;
                            $envia=$mandante;
                            $recibe=$contratista;
                            $mensaje="El documento <b>$doc[$i]</b> del trabajador <b>$trabajador</b> contrato <b>$nom_contrato</b> tiene una observacion.";
                            $accion="Revisar Observacion";
                            $url="verificar_documentos_trabajador_contratista.php";
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,contrato,documento,tipo,trabajador,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$doc[$i]','$mandante','$contratista','$contrato','$doc[$i]','$tipo','$id','$cargo','$perfil') ");
                            
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Trabajador Recibido' and control='$doc[$i]' and trabajador='$id' "); 
                            mysqli_query($con,"delete from notificaciones where contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and item='Documento Trabajador No Aplica' and control='$doc[$i]' and trabajador='$id' "); 
                      }
                  }
                } # fin del for

                # actualizar lista verificados
                $serial_veri=serialize($lista_verificados);
                $query_act_veri=mysqli_query($con,"update observaciones set verificados='$serial_veri' where trabajador='$id' and contrato='$contrato' and estado!='1'  ");

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
