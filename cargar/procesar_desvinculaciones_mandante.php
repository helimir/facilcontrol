<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
   include('../config/config.php');
   date_default_timezone_set('America/Santiago');
   $date = date('Y-m-d H:m:s', time());   
   $mes_doc=date('m');

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
        
   $contratista=$_SESSION["contratista"];
   $mandante=$_SESSION['mandante'];
   $arr_verificados=serialize(json_decode(stripslashes($_POST['data'])));
   $arr_comentarios=serialize(json_decode(stripslashes($_POST['data2'])));
   $arr_trabajadores=serialize(json_decode(stripslashes($_POST['data3'])));
   $arr_contratista=serialize(json_decode(stripslashes($_POST['data4'])));   
   $arr_tipos=serialize(json_decode(stripslashes($_POST['data5'])));
   $arr_contratos=serialize(json_decode(stripslashes($_POST['data6'])));
   $arr_id_d=serialize(json_decode(stripslashes($_POST['data7'])));
   
   $total=count(json_decode(stripslashes($_POST['data3'])));  
  
   $verificados=unserialize($arr_verificados);
   $comentarios=unserialize($arr_comentarios);
   $trabajadores=unserialize($arr_trabajadores);
   $contratistas=unserialize($arr_contratista);
   $tipos=unserialize($arr_tipos);
   $contratos=unserialize($arr_contratos); 
   $id_d=unserialize($arr_id_d); 
     
  
   # obtener mandante 
   $query_m=mysqli_query($con,"select razon_social from mandantes where id_mandante='$mandante' ");
   $result_m=mysqli_fetch_array($query_m); 
   
   $i=0;
   $sin_trab=false;
            
   foreach ($trabajadores as $row_t) { 
      
      $query_t=mysqli_query($con,"select t.* from trabajador as t where t.idtrabajador='$row_t' ");
      $result_t=mysqli_fetch_array($query_t);
      $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];

     # si esta verificado
     if ($verificados[$i]==1) {        

         # si la desvinculacion es de una contratista
         if ($tipos[$i]==1) {
            
            # seleccionar contratos del trabajador que no este desvinculado
            $query_contratos=mysqli_query($con,"select * from trabajadores_acreditados where contratista='$contratistas[$i]' and trabajador='$row_t' and estado!='2' ");            
            
            # recorer los conratos para verificar si trabajador esta en alguno y retirarlo
            foreach ($query_contratos as $row_c) {

                        #cambiar a estado desvinculdo en trabajadores acreditados y asignados
                        $query_d1=mysqli_query($con,"update trabajadores_acreditados set estado=2 where trabajador='".$row_c['trabajador']."' and contrato='".$row_c['contrato']."' and estado!='2' and mandante='$mandante' ");
                        $query_d2=mysqli_query($con,"update trabajadores_asignados set estado=2 where trabajadores='".$row_c['trabajador']."' and contrato='".$row_c['contrato']."' and estado!='2' and mandante='$mandante'  ");
                        
                        $update_noti1=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$row_c['contrato']."' and mandante='$mandante' and contratista='".$row_c['contratista']."' and item='Desvinculacion de Contratista' and trabajador='".$row_c['trabajador']."' ");
                        $update_noti2=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$row_c['contrato']."' and mandante='$mandante' and contratista='".$row_c['contratista']."' and item='Observacion Desvinculacion Contratista' and trabajador='".$row_c['trabajador']."' ");
                        $update_noti3=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$row_c['contrato']."' and mandante='$mandante' and contratista='".$row_c['contratista']."' and item='Reenvio Desvinculacion de Contratista' and trabajador='".$row_c['trabajador']."' ");
              
                        $update_d=mysqli_query($con,"update desvinculaciones set verificado=1, control=2, estado=2,fecha_desvinculado='$date', editado='$date' where trabajador='".$row_c['trabajador']."' and mandante='$mandante' and contratista='".$row_c['contratista']."' and id_d='".$id_d[$i]."' ");
                        
                        # actualiza obsservaciones a desvinculado
                        #$update_o=mysqli_query($con,"update trabajador set estado=2 where idtrabajador='".$row_t."'");

                        $ruta2='../doc/validados/'.$_SESSION['mandante'].'/'.$row_c['contratista'].'/contrato_'.$row_c['contrato'].'/'.$result_t['rut'].'/'.$row_c['codigo'].'/';
                        $rutazip='../doc/validados/'.$_SESSION['mandante'].'/'.$row_c['contratista'].'/contrato_'.$row_c['contrato'].'/'.$result_t['rut'].'/'.$row_c['codigo'].'/zip/';

                        #$prueba=mysqli_query($con,"insert into prueba (valor,valor2,valor3,valor4,valor5) values ('".$row_c['trabajador']."','".$row_c['contrato']."','".$row_c['codigo']."','".$result_t['rut']."','".$id_d[$i]."' ) ");
                        $rut_t=$result_t['rut'];
                        $zip = new ZipArchive();
                        # crea archivo zip
                        $archivoZip = "documentos_validados_trabajador_$rut_t.zip";
                        
                        # crear nuevo zip de documentos
                        if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                                agregar_zip($ruta2, $zip);
                                $zip->close();
                    
                                #Muevo el archivo a una ruta
                                #donde no se mezcle los zip con los demas archivos
                                $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
                        }
                        echo 0;
                    #}
              }
         }
         
         # si desvinculacion es de un contrato
         if ($tipos[$i]==2) {

            $query_acreditados=mysqli_query($con,"select codigo from trabajadores_acreditados where trabajador='$row_t' and contrato='".$contratos[$i]."' and estado!='2' ");
            $result_acreditados=mysqli_fetch_array($query_acreditados);
            $codigo=$result_acreditados['codigo'];
            
            #$ruta1='../doc/temporal/'.$_SESSION['mandante'].'/'.$contratistas[$i].'/contrato_'.$contratos[$i].'/'.$result_t['rut'].'/';
            #$ruta2='../doc/validados/'.$_SESSION['mandante'].'/'.$contratistas[$i].'/contrato_'.$contratos[$i].'/'.$result_t['rut'].'/'.$codigo.'/'; 

            
                     
            #if (!file_exists($ruta2)) {
            #        mkdir($ruta2, 0777, true);
            #}   
            #$archivo=$ruta1.'documento_desvinculante_contrato_'.$contratos[$i].'_'.$result_t['rut'].'.pdf';
            #$archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
            #$copiado=copy($archivo, $archivo_copiar);

            #if (copy($archivo, $archivo_copiar)) {
               
               #$update_a=mysqli_query($con,"update trabajadores_asignados set estado='2', editado='$date' where trabajador='$row_t' and contrato='".$contratos[$i]."' ");
               #$update_ta=mysqli_query($con,"update trabajadores_asignados set estado='2', editado='$date' where trabajadores='$row_t' and contrato='".$contratos[$i]."' ");
               #$update_d=mysqli_query($con,"update desvinculaciones set verificado=1, control=2,  editado='$date', estado=2 where trabajador='".$row_t."' and mandante='$mandante' ");

               #cambiar a estado desvinculdo en trabajadores acreditados y asignados
               
               $query_d1=mysqli_query($con,"update trabajadores_acreditados set estado=2 where trabajador='$row_t' and contrato='$contratos[$i]' and estado!='2' and mandante='$mandante' ");
               $query_d2=mysqli_query($con,"update trabajadores_asignados set estado=2 where trabajadores='$row_t' and contrato='$contratos[$i]' and estado!='2' and mandante='$mandante'  ");
                
               $update_noti1=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$contratos[$i]."' and mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Desvinculacion de Contrato' and trabajador='$row_t' ");
               $update_noti2=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$contratos[$i]."' and mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Observacion Desvinculacion Contratio' and trabajador='$row_t' ");
               $update_noti3=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$contratos[$i]."' and mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Reenvio Desvinculacion de Contrato' and trabajador='$row_t' ");
      
               $update_d=mysqli_query($con,"update desvinculaciones set verificado=1, control=2, estado=2, fecha_desvinculado='$date',  editado='$date' where trabajador='".$row_t."' and mandante='$mandante' and contratista='".$contratistas[$i]."' and id_d='".$id_d[$i]."' ");

               $update_obs=mysqli_query($con,"update observaciones set estado=2 where trabajador='".$row_t."' and mandante='$mandante' and contrato='".$contratos[$i]."' ");

               $ruta2='../doc/validados/'.$_SESSION['mandante'].'/'.$contratistas[$i].'/contrato_'.$contratos[$i].'/'.$result_t['rut'].'/'.$codigo.'/';;
               $rutazip='../doc/validados/'.$_SESSION['mandante'].'/'.$contratistas[$i].'/contrato_'.$contratos[$i].'/'.$result_t['rut'].'/'.$codigo.'/zip/';

               $rut_t=$result_t['rut'];
               $zip = new ZipArchive();
               # crea archivo zip
               $archivoZip = "documentos_validados_trabajador_$rut_t.zip";
                
               # crear nuevo zip de documentos
               if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {
                  agregar_zip($ruta2, $zip);
                  $zip->close();
                  #Muevo el archivo a una ruta
                  #donde no se mezcle los zip con los demas archivos
                  $zip_creado=rename($archivoZip, "$rutazip/$archivoZip");
               }

                echo 0;
            #}
             
         } 

     # si es una observacion    
     } else {

            $query_d=mysqli_query($con,"select * from desvinculaciones where trabajador='$row_t' and contratista='$contratistas[$i]' and mandante='$mandante'  ");
            $result_d=mysqli_fetch_array($query_d);

            #$prueba=mysqli_query($con,"insert into prueba (valor,valor2,valor3,valor4,valor5) values ('$i','".$comentarios[$i]."','".$contratos[$i]."','".$result_d['control']."','".$tipo[$i]."')  ");

            # si hay un comentario
            if ($comentarios[$i]!=""  ) {
               
               # contratista
               if ($tipos[$i]==1 ) {                  
                        
                  # nueva observacion
                  if ($result_d['control']==0 ) {
                        # actualizar notificacion
                        $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Desvinculacion de Contratista' and trabajador='$row_t' ");
                        
                        # notificacion observacion
                        $item='Observacion Desvinculacion Contratista'; 
                        $nivel=3; 
                        $tipo=1;
                        $envia=$mandante;
                        $recibe=$contratistas[$i];
                        $mensaje="El mandante <b>".$result_m['razon_social']."</b> envio una observacion del documento Desvinculacion del trabajador <b>".$trabajador."</b>   .";
                        $accion="Revisar Documento";
                        $url="desvinculaciones_contratista.php";
                        $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$id_d[$i]."','$mandante','".$contratistas[$i]."','$tipo','$row_t','".$contratos[$i]."') ");
                     
                        $update_d=mysqli_query($con,"update desvinculaciones set  control='1' where id_d='".$id_d[$i]."' ");
                        $query_obs=mysqli_query($con,"insert into doc_comentarios_desvinculaciones (id_des,comentarios,mandante,contratista,creado,usuario) values ('$id_d[$i]','$comentarios[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."') ");
                  }   

                  # observacion a un reenvio   
                  if ($result_d['control']==3 ) {
                     # actualizar notificacion
                     $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Reenvio Desvinculacion de Contratista' and trabajador='$row_t' ");
                     
                     # notificacion observacion
                     $item='Observacion Desvinculacion Contratista'; 
                     $nivel=3; 
                     $tipo=1;
                     $envia=$mandante;
                     $recibe=$contratistas[$i];
                     $mensaje="El mandante <b>".$result_m['razon_social']."</b> envio una observacion del documento Desvinculacion del trabajador <b>".$trabajador."</b>   .";
                     $accion="Revisar Documento";
                     $url="desvinculaciones_contratista.php";
                     $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$id_d[$i]."','$mandante','".$contratistas[$i]."','$tipo','$row_t','".$contratos[$i]."') ");
                  
                     $update_d=mysqli_query($con,"update desvinculaciones set  control='1' where id_d='".$id_d[$i]."' ");
                     $query_obs=mysqli_query($con,"insert into doc_comentarios_desvinculaciones (id_des,comentarios,mandante,contratista,creado,usuario) values ('$id_d[$i]','$comentarios[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."') ");
               } 
                     
               } 

               
               if ($tipos[$i]==2 ) {
                  
                  # nueva observacion
                  if ($result_d['control']==0 ) {

                     # actualizar notificacion
                     $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Desvinculacion de Contrato' and trabajador='$row_t' ");
                     
                     # notificacion observacion
                     $item='Observacion Desvinculacion Contrato'; 
                     $nivel=3; 
                     $tipo=1;
                     $envia=$mandante;
                     $recibe=$contratistas[$i];
                     $mensaje="El mandante <b>".$result_m['razon_social']."</b> envio una observacion del documento Desvinculacion del trabajador <b>".$trabajador."</b>   .";
                     $accion="Revisar Documento";
                     $url="desvinculaciones_contratista.php";
                     $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$id_d[$i]."','$mandante','".$contratistas[$i]."','$tipo','$row_t','".$contratos[$i]."') ");
                  
                     $update_d=mysqli_query($con,"update desvinculaciones set  control='1' where id_d='".$id_d[$i]."' ");
                     $query_obs=mysqli_query($con,"insert into doc_comentarios_desvinculaciones (id_des,comentarios,mandante,contratista,creado,usuario) values ('$id_d[$i]','$comentarios[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."') ");

                  } 

                  # observacion a reenvio 
                  if ($result_d['control']==3 ) {

                     # actualizar notificacion
                     $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where mandante='$mandante' and contratista='".$contratistas[$i]."' and item='Reenvio Desvinculacion de Contrato' and trabajador='$row_t' ");
                     
                     # notificacion observacion
                     $item='Observacion Desvinculacion Contrato'; 
                     $nivel=3; 
                     $tipo=1;
                     $envia=$mandante;
                     $recibe=$contratistas[$i];
                     $mensaje="El mandante <b>".$result_m['razon_social']."</b> envio una observacion del documento Desvinculacion del trabajador <b>".$trabajador."</b>   .";
                     $accion="Revisar Documento";
                     $url="desvinculaciones_contratista.php";
                     $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$id_d[$i]."','$mandante','".$contratistas[$i]."','$tipo','$row_t','".$contratos[$i]."') ");
                  
                     $update_d=mysqli_query($con,"update desvinculaciones set  control='1' where id_d='".$id_d[$i]."' ");
                     $query_obs=mysqli_query($con,"insert into doc_comentarios_desvinculaciones (id_des,comentarios,mandante,contratista,creado,usuario) values ('$id_d[$i]','$comentarios[$i]','$mandante','$contratista','$date','".$_SESSION['usuario']."') ");

                  } 

                 
            } 
           }


     }
     $i=$i+1;
   };
    
    
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>