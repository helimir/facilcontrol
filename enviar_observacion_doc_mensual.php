<?php
 session_start();
if (isset($_SESSION['usuario'])) { 
    include('config/config.php');
   
    # $ruta3='doc/validados/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/'; 
    function agregar_zip($dir, $zip, $rut_t) {
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
              #if (is_dir($dir.$archivo) && $archivo != "." && $archivo != "..") {
              #  $dir='';
              #  agregar_zip($dir.$archivo."/", $zip,$rut_t);               
               /*si encuentra un archivo imprimimos la ruta donde se encuentra
               * y agregamos el archivo al zip junto con su ruta 
               */
              #} elseif (is_file($dir.$archivo) && $archivo != "." && $archivo != "..") {
              #  $zip->addFile($dir.$archivo, $dir.$archivo);
              #} 

              if (is_file($dir.$archivo) && $archivo != "." && $archivo != "..") {
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

   $query_c=mysqli_query($con,"select * from contratos where id_contrato='".$contrato."'  ");  
   $result_c=mysqli_fetch_array($query_c);
   
   $query_contratista=mysqli_query($con,"select c.*, m.razon_social as nom_mandante from contratistas as c LEFT JOIN documentos_extras as d On d.contratista=c.id_contratista LEFT JOIN mandantes as m On m.id_mandante=d.mandante where d.contratista='$contratista' and d.mandante='$mandante' ");
   $result_contratista=mysqli_fetch_array($query_contratista);
   
   # arreglo de id documentos
   $arreglo_doc=serialize(json_decode(stripslashes($_POST['doc']))); ;
   
   # arreglo de lista check
   $arreglo_verificados=serialize(json_decode(stripslashes($_POST['verificado']))); 
   
   # arreglo de observaciones
   $arreglo_observaciones=serialize(json_decode(stripslashes($_POST['obs'])));
   
   # arreglo de id mensuales
   $arreglo_id_mensual=serialize(json_decode(stripslashes($_POST['id_mensual'])));

   # arreglo trabajadores
   $arreglo_id_trabajador=serialize(json_decode(stripslashes($_POST['id_trabajador'])));

    # arreglo meses
    $arreglo_mes=serialize(json_decode(stripslashes($_POST['mes'])));
  
   $cant_doc=count(json_decode(stripslashes($_POST['doc'])));
   
   $doc=unserialize($arreglo_doc);
   $verificados=unserialize($arreglo_verificados);
   $observaciones=unserialize($arreglo_observaciones);
   $id_mensual=unserialize($arreglo_id_mensual);
   $id_trabajador=unserialize($arreglo_id_trabajador);
   $mes=unserialize($arreglo_mes);
   
   
   for ($i=0;$i<=$cant_doc-1;$i++) {

       # si esta verificado
       if ($verificados[$i]==1) { 

            $query_t=mysqli_query($con,"select m.*, r.rut from mensuales_trabajador as m Left Join trabajadores_acreditados as t On t.trabajador=m.trabajador Left Join trabajador as r On r.idtrabajador=m.trabajador  where m.trabajador='".$id_trabajador[$i]."' and m.doc='".$doc[$i]."' and m.mes='".$mes[$i]."' group by m.trabajador  ");
            $result_t=mysqli_fetch_array($query_t);

            $query_d=mysqli_query($con,"select documento from doc_mensuales where id_dm='".$doc[$i]."' ");
            $result_d=mysqli_fetch_array($query_d);

            #$prueba=mysqli_query($con,"insert into prueba (valor,valor2,valor3) values ('".$result_d['documento']."','".$result_t['rut']."','".$result_t['mes']."','".$result_t['year']."') ");

            #$ruta1='doc/temporal/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/mensuales/'.$result_t['year'].'/'.$result_t['mes'].'/'; 
            #$ruta2='doc/validados/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/mensuales/'.$result_t['year'].'/'.$result_t['mes'].'/'; 

            $ruta1='doc/temporal/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/'; 
            $ruta2='doc/validados/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/'; 
            
            
            
            if (!file_exists($ruta2)) { 
              mkdir($ruta2, 0777, true);
            }
                                          
            $nom_documento=$result_d['documento'].'_'.$result_t['rut'].'_'.$result_t['mes'].'_'.$result_t['year'].'.pdf'; 
            $nombre_documento=$result_d['documento'];
                      
            $archivo=$ruta1.$nom_documento;
            $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                              
            $copiado=copy($archivo, $archivo_copiar);
        
              if ($copiado) {
                          
                      # actualizar docxumento para acreditado
                      $query_v=mysqli_query($con,"update mensuales_trabajador set verificado=1, enviado=3 where doc='$doc[$i]' and trabajador='".$id_trabajador[$i]."' and mes='".$result_t['mes']."' and contrato='".$result_t['contrato']."' ");
                            
                      # procesada. control nombre del documento
                      $update_noti2=mysqli_query($con,"delete from notificaciones where contratista='".$result_t['contratista']."' and mandante='".$result_t['mandante']."' and item='Documento Mensual Recibido'    and documento='$nombre_documento' and trabajador='".$id_trabajador[$i]."' and control='".$result_t['mes']."' "); 
                      $update_noti3=mysqli_query($con,"delete from notificaciones where contratista='".$result_t['contratista']."' and mandante='".$result_t['mandante']."' and item='Observacion Documento Mensual' and documento='$nombre_documento' and trabajador='".$id_trabajador[$i]."' and control='".$result_t['mes']."' "); 
                      
                      $query=mysqli_query($con,"update doc_comentarios_mensual set leer_contratista=1, leer_mandante=1, estado=1 where id_doc='".$doc[$i]."' and documento='$nom_documento' and contratista='".$result_t['contratista']."' and mandante='".$result_t['mandante']."' and trabajador='".$id_trabajador[$i]."' and mes='".$result_t['mes']."' ");
                      
                      $ruta3='doc/validados/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/'; 
                      $rutazip='doc/validados/'.$result_t['mandante'].'/'.$result_t['contratista'].'/contrato_'.$result_t['contrato'].'/'.$result_t['rut'].'/'.$result_t['codigo'].'/zip/';
                      

                      $rut_t=$result_t['rut'];
                      $codigo=$result_t['codigo'];
                      $zip = new ZipArchive();
                      # crea archivo zip
                      $archivoZip = "documentos_validados_trabajador_$rut_t.zip";
                              
                      if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                          agregar_zip($ruta3, $zip,$rut_t);
                          $zip->close();
                          
                          #Muevo el archivo a una ruta
                          #donde no se mezcle los zip con los demas archivos
                          $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
                      }
                  echo 0;    
                } else {
                  echo 1;  
                }
       } else {
            
            if ($observaciones[$i]!='') {
                
                $query_doc=mysqli_query($con,"select * from doc_mensuales where id_dm='$doc[$i]' ");
                $result_doc=mysqli_fetch_array($query_doc); 
                $nom_documento=$result_doc['documento'];

                $query_t=mysqli_query($con,"select nombre1, apellido1 from trabajador where idtrabajador='".$id_trabajador[$i]."' ");
                $result_t=mysqli_fetch_array($query_t);
                $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
                
                # consultar que existe observacion sin ser atendida
                $query_existe=mysqli_query($con,"select * from notificaciones where item='Observacion Documento Mensual' and documento='$nom_documento' and contrato='$contrato' and contratista='$contratista' and mandante='$mandante' and trabajador='".$id_trabajador[$i]."' and control='".$mes[$i]."' and procesada='0'    ");
                $existe_noti_obs=mysqli_num_rows($query_existe);

                if ($existe_noti_obs==0) {
                   $query_obs=mysqli_query($con,"insert into doc_comentarios_mensual (id_doc,documento,comentarios,mandante,contratista,creado,usuario,contrato,trabajador,mes) values ('$doc[$i]','$nom_documento','$observaciones[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."','$contrato','".$id_trabajador[$i]."','".$mes[$i]."') ");
                
                  if ($query_obs) {
                      
                    
                    # actualiza el estado del documento a observacion
                      $query_v=mysqli_query($con,"update mensuales_trabajador set enviado=2 where id_tm='".$id_mensual[$i]."'  ");
                      
                      $nom_contratista=$result_contratista['razon_social'];    
                      $nom_mandante=$result_contratista['nom_mandante'];
                      
                      # notificacion que documento tiene una observacion
                      $item='Observacion Documento Mensual';                 
                      $nivel=3;
                      $tipo=1;
                      $envia=$mandante;
                      $recibe=$contratista;
                      $mensaje="El Mandante <b>$nom_mandante</b> envio una observacion del documento <b>$nom_documento</b>, contrato <b>".$result_c['nombre_contrato']."</b> trabajador <b>$trabajador</b>.";
                      $usuario=$_SESSION['usuario'];
                      $accion="Observacion Documento mensual.";
                      $url="gestion_doc_mensuales_contratista.php";
                                      
                      $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,documento,control,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','$nom_documento','".$mes[$i]."','".$id_trabajador[$i]."','$contrato') ");
                      
                      $update_noti=mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Mensual Recibido' and documento='$nom_documento' and contrato='$contrato' and trabajador='".$id_trabajador[$i]."' and control='".$mes[$i]."'  ");  
                      
                      echo 2;
                      
                  } else {
                      echo 1;
                  }
            } else {
              echo 0;
            }
          }  
       }
        
   }
   
   
  
   
        

} else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
