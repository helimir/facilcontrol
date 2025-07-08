<?php
 session_start();
if (isset($_SESSION['usuario'])) { 
    include('config/config.php');
   
    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);
    
    function agregar_zip_c($dir, $zip) {
        //verificamos si $dir es un directorio
        $dir_f='documentos_contrtatista/';
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

      function agregar_zip_t($dir, $zip, $rut_t) {
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
      
   
   
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    $fecha=date('Y-m-d');
   
   $mandante=$_SESSION['mandante'];
   $contratista=$_SESSION['contratista'];
   $contrato=$_SESSION['contrato'];

   $query_m=mysqli_query($con,"select * from mandantes where id_mandante='".$mandante."'  ");  
   $result_m=mysqli_fetch_array($query_m);

   $query_contrato=mysqli_query($con,"select * from contratos where id_contrato='".$contrato."'  ");  
   $result_contrato=mysqli_fetch_array($query_contrato);
   $nom_contrato=$result_contrato['nombre_contrato'];
   
   $query_contratista=mysqli_query($con,"select c.*, m.razon_social as nom_mandante from contratistas as c LEFT JOIN documentos_extras as d On d.contratista=c.id_contratista LEFT JOIN mandantes as m On m.id_mandante=d.mandante where d.contratista='$contratista' and d.mandante='$mandante' ");
   $result_contratista=mysqli_fetch_array($query_contratista);
   
   # arreglo de id documentos
   $arreglo_doc=serialize(json_decode(stripslashes($_POST['doc']))); ;
   
   # arreglo de lista check
   $arreglo_verificados=serialize(json_decode(stripslashes($_POST['verificado']))); 
   
   # arreglo de observaciones
   $arreglo_observaciones=serialize(json_decode(stripslashes($_POST['obs'])));
   
   # arreglo de trabajadores
   $arreglo_trabajadores=serialize(json_decode(stripslashes($_POST['trabajadores'])));
  
   $cant_doc=count(json_decode(stripslashes($_POST['doc'])));

   $cant_trab_acre=$_POST['cant_trab_acre'];
   
   $doc=unserialize($arreglo_doc);
   $verificados=unserialize($arreglo_verificados);
   $observaciones=unserialize($arreglo_observaciones);
   $trabajadores=unserialize($arreglo_trabajadores);
   
   
   for ($i=0;$i<=$cant_doc-1;$i++) {

      # consulta de documentos extras
      $query_doc=mysqli_query($con,"select d.*, c.rut, c.razon_social from documentos_extras as d left join contratistas as c On c.id_contratista=d.contratista where d.id_de='$doc[$i]' ");
      $result_doc=mysqli_fetch_array($query_doc);
    
       # si esta verificado
       if ($verificados[$i]==1) {
                
        #if ($result_doc['estado']==1) {    
            
            # si documento es tipo contratista
            if ($result_doc['tipo']==1) {

                    $ruta1='doc/temporal/'.$mandante.'/'.$result_doc['contratista'].'/';
                    $ruta2='doc/validados/'.$mandante.'/'.$result_doc['contratista'].'/';
                    
                    $nom_documento=$result_doc['documento'];
                    
                    $archivo=$ruta1.$result_doc['documento'].'_'.$result_contratista['rut'].'.pdf';
                    $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                            
                    $copiado=copy($archivo, $archivo_copiar);
            
            }
             
            # si tipo documento es trabajadores contratos
            if ($result_doc['tipo']==2 or $result_doc['tipo']==3) {
                
                $query_trab_acre=mysqli_query($con,"select ta.*, t.rut from trabajadores_acreditados as ta Left Join trabajador as t On t.idtrabajador=ta.trabajador  where ta.contrato='".$result_doc['contrato']."' and ta.trabajador='".$trabajadores[$i]."'   ");
                
                foreach ($query_trab_acre as $row) {
                    $ruta1='doc/temporal/'.$mandante.'/'.$result_doc['contratista'].'/contrato_'.$result_doc['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/';
                    $ruta2='doc/validados/'.$mandante.'/'.$result_doc['contratista'].'/contrato_'.$result_doc['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/';
                    
                    $nom_documento=$result_doc['documento'];
                    
                    $archivo=$ruta1.$result_doc['documento'].'_'.$row['rut'].'.pdf';
                    $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                            
                    $copiado=copy($archivo, $archivo_copiar);

                    #$query_p=mysqli_query($con,"insert into prueba (valor,valor2,valor3,valor4,valor5) values ('".$result_doc['contratista']."','".$result_doc['contrato']."','$ruta1','$ruta2','".$result_doc['documento']."') ");
                }

            }
            
            # si el archivo fue copiado a carpeta validados
            if ($copiado) {
                    
                # actualizar docxumento para acreditado
                $query_v=mysqli_query($con,"update documentos_extras set estado=3 where id_de='$doc[$i]' ");
                      
                # procesada. control nombre del documento
                mysqli_query($con,"delete from notificaciones where contratista='".$result_doc['contratista']."' and mandante='$mandante' and item='Documento Extraordinario Recibido' and trabajador='".$trabajadores[$i]."'  "); 
                mysqli_query($con,"delete from notificaciones where contratista='".$result_doc['contratista']."' and mandante='$mandante' and item='Observacion de Documento Extraordinario' and trabajador='".$trabajadores[$i]."' "); 
                mysqli_query($con,"delete from notificaciones where contratista='".$result_doc['contratista']."' and mandante='$mandante' and item='Documento No Aplica'  "); 
                
                $query=mysqli_query($con,"update doc_comentarios_extra set leer_contratista=1, leer_mandante=1, estado=1 where id_doc='$doc[$i]' and documento='$nom_documento' and contratista='".$result_doc['contratista']."' and mandante='$mandante' and  trabajador='".$trabajadores[$i]."' ");
                        
                $nom_contratista=$result_doc['razon_social']; 
                $rut=$result_doc['rut'];
                             
                  if ($result_doc['tipo']==1) {
                        $rutazip='doc/validados/'.$mandante.'/'.$result_doc['contratista'].'/zip/';
                        $rut_c=$result_doc['rut'];
                        $zip = new ZipArchive();
                        # crea archivo zip
                        $archivoZip = "documentos_validados_contratista_$rut_c.zip";

                        if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                            agregar_zip_c($ruta2, $zip);
                            $zip->close();
                        
                            #Muevo el archivo a una ruta
                            #donde no se mezcle los zip con los demas archivos
                            $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
                        }
                        echo 0;
                  } 

                  if ($result_doc['tipo']==2 or $result_doc['tipo']==3) {
                    $query_trab_acre=mysqli_query($con,"select ta.*, t.rut from trabajadores_acreditados as ta Left Join trabajador as t On t.idtrabajador=ta.trabajador  where ta.contrato='".$result_doc['contrato']."'  ");
                
                    foreach ($query_trab_acre as $row) {
                        $ruta2='doc/validados/'.$mandante.'/'.$result_doc['contratista'].'/contrato_'.$result_doc['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/';
                        $rutazip='doc/validados/'.$mandante.'/'.$result_doc['contratista'].'/contrato_'.$result_doc['contrato'].'/'.$row['rut'].'/'.$row['codigo'].'/zip/';

                        $rut_t=$row['rut'];
                        $zip = new ZipArchive();
                        # crea archivo zip
                        $archivoZip = "documentos_validados_trabajador_$rut_t.zip";
                        
                        if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                                agregar_zip_t($ruta2, $zip,$rut_t);
                                $zip->close();
                    
                                #Muevo el archivo a una ruta
                                #donde no se mezcle los zip con los demas archivos
                                $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
                        }
                    }
                    echo 0;
                  }

               
            } else {
                echo 1;
            }
            
            #
         #}  
       # si es solo observacion 
       } else {
            
            if ($observaciones[$i]!='') {
                
                $query_doc=mysqli_query($con,"select * from documentos_extras where id_de='$doc[$i]' ");
                $result_doc=mysqli_fetch_array($query_doc); 
                $nom_documento=$result_doc['documento'];

                # observacion a documento contratistas
                if ($result_doc['tipo']==1) {
                
                      $query_obs=mysqli_query($con,"insert into doc_comentarios_extra (id_doc,documento,comentarios,mandante,contratista,creado,usuario,tipo) values ('$doc[$i]','$nom_documento','$observaciones[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."','".$result_doc['tipo']."') ");
                      
                      if ($query_obs) {
                          # actualiza el estado del documento a observacion
                          $query_v=mysqli_query($con,"update documentos_extras set estado=2 where id_de='$doc[$i]' ");
                          
                          $nom_contratista=$result_contratista['razon_social'];    
                          $nom_mandante=$result_contratista['nom_mandante'];
                          
                          # notificacion que documento tiene una observacion
                          $item='Observacion Documento Extraordinario';                 
                          $nivel=3;
                          $tipo=4;
                          $envia=$_SESSION['mandante'];
                          $recibe=$contratista;
                          $mensaje="El Mandante <b>$nom_mandante</b> envio una observacion del documento extradorinario <b>$nom_documento</b>.";
                          $usuario=$_SESSION['usuario'];
                          $accion="Observacion Documento extraordinario.";
                          $url="gestion_doc_extraordinarios_contratista.php";
                                          
                         mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','$nom_documento') ");                          
                         mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Extraordinario Recibido' and control='$nom_documento'  ");  
                         mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$nom_documento'  ");
                          
                          echo 0; 
                      } else {
                          echo 1;
                      }
                }

                # observacion a documento todos de un contrato
                if ($result_doc['tipo']==2 or $result_doc['tipo']==3) {
                
                  $query_obs=mysqli_query($con,"insert into doc_comentarios_extra (id_doc,documento,comentarios,mandante,contratista,creado,usuario,tipo,trabajador,contrato) values ('$doc[$i]','$nom_documento','$observaciones[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."','".$result_doc['tipo']."','".$trabajadores[$i]."','$contrato') ");
                  
                  if ($query_obs) {
                      # actualiza el estado del documento a observacion
                      $query_v=mysqli_query($con,"update documentos_extras set estado=2 where id_de='$doc[$i]' ");

                      #datos del trabajador
                      $query_trab=mysqli_query($con,"select * from trabajador where idtrabajador='".$trabajadores[$i]."'  ");
                      $result_trab=mysqli_fetch_array($query_trab);
                      $nom_trabajador=$result_trab['nombre1'].' '.$result_trab['apellido1'];
                      
                      $nom_contratista=$result_contratista['razon_social'];    
                      $nom_mandante=$result_contratista['nom_mandante'];
                      
                      # notificacion que documento tiene una observacion
                      $item='Observacion Documento Extraordinario';                 
                      $nivel=3;
                      $tipo=4;
                      $envia=$_SESSION['mandante'];
                      $recibe=$contratista;
                      $mensaje="El Mandante <b>$nom_mandante</b> envio una observacion del documento extradorinario <b>$nom_documento</b> contrato <b>$nom_contrato</b> trabajador <b>$nom_trabajador</b>.";
                      $usuario=$_SESSION['usuario'];
                      $accion="Observacion Documento extraordinario.";
                      $url="gestion_doc_extraordinarios_contratista_contrato.php";
                                      
                      mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','".$nom_documento."','".$trabajadores[$i]."','$contrato') ");
                      mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Extraordinario Recibido' and control='$nom_documento' and trabajador='".$trabajadores[$i]."' and contrato='$contrato'  ");  
                      mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$nom_documento' and trabajador='".$trabajadores[$i]."' and contrato='$contrato'  ");
                      
                      echo 0; 
                  } else {
                      echo 1;
                  }
            }



          }  
       }
        
   }
   
   
  
   
        

} else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
