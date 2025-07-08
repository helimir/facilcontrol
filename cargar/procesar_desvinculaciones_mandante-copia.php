<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
   include('../config/config.php');
   date_default_timezone_set('America/Santiago');
   $date = date('Y-m-d H:m:s', time());   
   $mes_doc=date('m');
        
   $contratista=$_SESSION["contratista"];
   $mandante=$_SESSION['mandante'];
      
   $arr_verificados=serialize(json_decode(stripslashes($_POST['data'])));
   $arr_comentarios=serialize(json_decode(stripslashes($_POST['data2'])));
   $arr_trabajadores=serialize(json_decode(stripslashes($_POST['data3'])));
   $arr_contratista=serialize(json_decode(stripslashes($_POST['data4'])));
   $arr_tipos=serialize(json_decode(stripslashes($_POST['data5'])));
   
   $total=count(json_decode(stripslashes($_POST['data3'])));  
  
   $verificados=unserialize($arr_verificados);
   $comentarios=unserialize($arr_comentarios);
   $trabajadores=unserialize($arr_trabajadores);
   $contratistas=unserialize($arr_contratista);
   $tipo=unserialize($arr_tipos); 
   
   $total=count($trabajadores);  
  
   # obtener mandante 
   $query_m=mysqli_query($con,"select razon_social from mandantes where id_mandante='$mandante' ");
   $result_m=mysqli_fetch_array($query_m); 
   
   $query_cont=mysqli_query($con,"select * from contratos where id_contrato='".$_SESSION['contrato']."' ");
   $result_cont=mysqli_fetch_array($query_cont);
   
   $i=0;
   foreach ($trabajadores as $row_t) {
    
      $query_t=mysqli_query($con,"select rut from trabajador where idtrabajador='$row_t' ");
      $result_t=mysqli_fetch_array($query_t);
    
     # si esta verificado
     if ($verificados[$i]==1) {        
         
         # si desvinculacion es de una contratista
         if ($tipo[$i]==1) {
            
            $query_contratos=mysqli_query($con,"select contrato from trabajadores_asignados where contratista='$contratista' and estado=1 ");
            
            # recorer los conratos para verificar si trabajador esta en alguno y retirarlo
            foreach ($query_contratos as $row_c) {
                    
                    $query_arreglos=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$row_c."' ");
                    $result_arreglos=mysqli_fetch_array($query_arreglos);
                    
                    # verificar si trabajador existe en un contrato para sacr del contrato
                    $trab=unserialize($result_arreglos['trabajadores']);
                    $car=unserialize($result_arreglos['cargos']);
                   
                    $j=0;  
                    foreach ($trab as $row) {
                        if ($row!=$row_t) {
                            $lista_trabajadores[$j]=$row;
                            $j++;
                        } else {
                            $posicion_cargo=$j;
                            $idtrabajador=$row;
                        }   
                    } 
                       
                    $x=0;
                    foreach ($car as $row) {
                          if ($x!=$posicion_cargo ) {
                            $lista_cargos[$x]=$row;
                            $x++;
                          } else {
                            $posicion_cargo=-1;
                          } 
                    }
                             
                    $trabajadores=serialize($lista_trabajadores);
                    $cargos=serialize($lista_cargos);
                       
                    if ($j!=0) {
                       $sql=mysqli_query($con,"update trabajadores_asignados set trabajadores='$trabajadores', cargos='$cargos', editado='$date' where contrato='".$row_c."' ");  
                    } 
                    
                    
                    
                    $ruta1='../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$row_c.'/'.$result_t['rut'].'/';
                    $ruta2='../doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$row_c.'/'.$result_t['rut'].'/';
                             
                    if (!file_exists($ruta2)) {
                            mkdir($ruta2, 0777, true);
                    }   
                    $archivo=$ruta1.'documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';
                    $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                    copy($archivo, $archivo_copiar);
              }
              
              $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where mandante='$mandante' and contratista='$contratista' and item='Desvinculacion de Contratista' and trabajador='$row_t' ");
              $update_d=mysqli_query($con,"update desvinculaciones set verificado=1, control=2,  editado='$date' where trabajador='".$row_t."' and mandante='$mandante' and contratista='$contratista' and tipo=1 ");
              $update_t=mysqli_query($con,"update trabajador set eliminar=1 where idtrabajador='".$row_t."'");
                
              # notificacion desvinculaciono de trabajador de una contratista 
              $item='Desvinculacion de Conttarista'; 
              $nivel=2; 
              $tipo=0;
              $envia=$mandante;
              $recibe=$contratista;
              $mensaje="El mandante <b>".$result_m['razon_social']."</b> ha validado la desvinculacion de la Contratista del trabajador <b>".$trabajador."</b>.";
              $accion="Revisar Documento";
              $url="desvinculaciones_contratista.php";
              $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$idtrabajador','$mandante','$contratista','$tipo','$idtrabajador') ");
                 
            
         # si la desvinculacion es de un contrato   
         } else {
            
            $query_arreglos=mysqli_query($con,"select * from trabajadores_asignados where contrato='".$_SESSION['contrato']."' ");
            $result_arreglos=mysqli_fetch_array($query_arreglos);
                        
            $update_d=mysqli_query($con,"update desvinculaciones set verificado=1, control=2, comentario='', editado='$date' where trabajador='".$row_t."' and mandante='$mandante' ");
            
            $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$row_t' ");
            $result_t=mysqli_fetch_array($query_t);
            $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            
            $ruta1='../doc/temporal/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$result_t['rut'].'/';
            $ruta2='../doc/validados/'.$_SESSION['mandante'].'/'.$_SESSION['contratista'].'/contrato_'.$_SESSION['contrato'].'/'.$result_t['rut'].'/';
                     
            if (!file_exists($ruta2)) {
                    mkdir($ruta2, 0777, true);
            }   
            $archivo=$ruta1.'documento_desvinculante_contrato_'.$_SESSION['contrato'].'_'.$result_t['rut'].'.pdf';
            $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
            copy($archivo, $archivo_copiar); 
            
            $trab=unserialize($result_arreglos['trabajadores']);
            $car=unserialize($result_arreglos['cargos']);
            
            $j=0;  
            foreach ($trab as $row) {
                if ($row!=$row_t) {
                    $lista_trabajadores[$j]=$row;
                    $j++;
                } else {
                    $posicion_cargo=$j;
                    $idtrabajador=$row;
                }   
            } 
               
            $x=0;
            foreach ($car as $row) {
                  if ($x!=$posicion_cargo ) {
                    $lista_cargos[$x]=$row;
                    $x++;
                  } else {
                    $posicion_cargo=-1;
                  } 
            }
                     
            $trabajadores=serialize($lista_trabajadores);
            $cargos=serialize($lista_cargos);
               
            if ($j!=0) {
               $sql=mysqli_query($con,"update trabajadores_asignados set trabajadores='$trabajadores', cargos='$cargos', editado='$date' where contrato='".$_SESSION['contrato']."' ");  
            } 
            
            $update_noti=mysqli_query($con,"update notificaciones set leido=1, procesada=1 where contrato='".$_SESSION['contrato']."' and mandante='$mandante' and contratista='$contratista' and item='Desvinculacion de Contrato' and trabajador='$idtrabajador' ");
            
            # notificacion desvinculaciono de trabajador de una contratista 
            $item='Desvinculacion de Contrado'; 
            $nivel=2; 
            $tipo=0;
            $envia=$mandante;
            $recibe=$contratista;
            $mensaje="El mandante <b>".$result_m['razon_social']."</b> ha validado la desvinculacion del trabajador <b>".$trabajador."</b> del Contrato <b>".$result_cont['nombre_contrato']."</b>.";
            $accion="Revisar Documento";
            $url="desvinculaciones_contratista.php";
            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$idtrabajador','$mandante','$contratista','$tipo','".$_SESSION['contrato']."','$idtrabajador') ");
            
         }   
                
     } else {
        
        # si no esta verificado y hay un comentario
        if ($comentarios[$i]!="") {
            $update_d=mysqli_query($con,"update desvinculaciones set comentario='$comentarios[$i]', control=1, editado='$date' where contrato='".$_SESSION['contrato']."' and contratista='$contratista' and trabajador='".$row_t."' and mandante='$mandante' ");
        }
        
     }
     
    
     
     
    $i++;
   };
    
    
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>