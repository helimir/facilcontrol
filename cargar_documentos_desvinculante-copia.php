<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());    
    $mes_doc=date('m');
        
    $contratista=$_SESSION["contratista"];
    $mandante=$_SESSION["mandante"];
    
    $arreglo_trabajador=serialize($_POST['trabajador']);
    $arreglo_comentario=serialize($_POST['comentario']);
    $arreglo_tipo=serialize($_POST['tipo']);
    
    $trabajadores=unserialize($arreglo_trabajador);
    $comentarios=unserialize($arreglo_comentario);
    $tipos=unserialize($arreglo_tipo);
    
    $cantidad=$_POST['cantidad'];
    
    $query_contratista=mysqli_query($con,"select * from contratistas where id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
    $i=0;
    foreach($_FILES["carga_doc"]['tmp_name'] as $key => $tmp_name ) {    
        
        $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajadores[$i]' ");
        $result_t=mysqli_fetch_array($query_t);
        
        
        
        
        # si archivo existe
       	if($_FILES["carga_doc"]["name"][$key]) { 
                        
            #$query_doc=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$cadena[$i]."' ");
            #$result_doc=mysqli_fetch_array($query_doc);
                
            
             #$extension = pathinfo($arch, PATHINFO_EXTENSION);
          
            # si desvinculacion contratista
            if ($tipos[$i]==1)  {       

                $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='$trabajadores[$i]' and contratista='$contratista'  ");
                $result_ta=mysqli_fetch_array($query_ta);
                $acreditados=mysqli_num_rows($query_ta);
                                
                $trabajador=$result_t['nombre1'].' '.$result_t['apellido1']; 
                
                $contador=0;
                if ($acreditados>1) {
                    foreach ($query_ta as $row_ta) {
                        $contratos[$contador]=$row_ta['contrato'];
                        $contador++;
                    };
                }
                #$prueba=mysqli_query($con,"insert into prueba (valor,valor2) values ('$trabajadores[$i]','".$acreditados."') ");
                if ($acreditados>1) {
                    $carpeta='doc/temporal/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$contratos[0].'/'.$result_t['rut'].'/';            
                    $nombre='documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';
                    $archivo=$carpeta.$nombre;
                    if (@move_uploaded_file($_FILES["carga_doc"]["tmp_name"][$key], $archivo)) {
                        for ($num=1;$num<=$acreditados-1;$num++) {
                            $carpeta2='doc/temporal/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$contratos[$num].'/'.$result_t['rut'].'/';
                            $archivo2=$carpeta2.$nombre;
                            
                            if (copy($archivo,$archivo2)) {
                                $contrato_1=$contratos[0];
                                $enviar=1;;
                            } else {
                                $enviar=0;
                            }
                        }    
        
                    } else { 
                        $enviar=0;
                    }
        
                    if ($enviar==1) {    
                        $update_d=mysqli_query($con,"update desvinculaciones set control=3, comentario='', editado='$date' where trabajador='".$trabajadores[$i]."' and mandante='$mandante' ");
                        $update_n=mysqli_query($con,"update notificaciones set procesada=1 where item='Observacion Desvinculacion Contratista' and mandante='$mandante' and contratista='$contratista' and trabajador='".$trabajadores[$i]."' "); 
                        
                        $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
     
                        # notificacion desvinculaciono de trabajador de una contratista 
                        $item='Reenvio Desvinculacion de Contratista'; 
                        $nivel=3; 
                        $tipo=1;
                        $envia=$contratista;
                        $recibe=$mandante;
                        $mensaje="El contratista <b>".$result_contratista['razon_social']."</b> ha reenviado la desvinculacion del trabajador <b>".$nom_trabajador."</b>.";
                        $accion="Revisar Documento";
                        $url="desvinculaciones_mandante.php";
                        $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,mandante,contratista,tipo,documento,trabajador,url) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','".$mandante."','".$contratista."','$tipo','".$nombre."','".$trabajadores[$i]."','$url') ");
                            echo 0;
                        } else {
                            echo 1;
                        }   
                # si esta en un solo contrato        
                } else {
                
                }

                #$carpeta = 'doc/desvinculados/contratista/'.$mandante.'/'.$contratista.'/'.$result_t['rut'].'/';
                #$nombre='documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';

            # si desvinculacion contrato        
            } else {

                $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='$trabajadores[$i]' and contratista='$contratista'  ");
                $result_ta=mysqli_fetch_array($query_ta); 

                $carpeta='doc/temporal/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$result_ta['contratos'].'/'.$result_t['rut'].'/';            
                $nombre='documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';
                $archivo=$carpeta.$nombre;
                           
                $archivo=$carpeta.$nombre;   
               
                 
                // Cargando el fichero en la carpeta "subidas"
                if (@move_uploaded_file($_FILES["carga_doc"]["tmp_name"][$key], $archivo)) {
                      
                   $update_d=mysqli_query($con,"update desvinculaciones set control=3, comentario='', editado='$date' where trabajador='".$trabajadores[$i]."' and mandante='$mandante' ");
                   $update_n=mysqli_query($con,"update notificaciones set procesada=1 where item='Observacion Desvinculacion Contratista' and mandante='$mandante' and contratista='$contratista' and trabajador='".$trabajadores[$i]."' "); 
                   
                   $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];

                   # notificacion desvinculaciono de trabajador de una contratista 
                   $item='Reenvio Desvinculacion de Contratista'; 
                   $nivel=3; 
                   $tipo=1;
                   $envia=$contratista;
                   $recibe=$mandante;
                   $mensaje="El contratista <b>".$result_contratista['razon_social']."</b> ha reenviado la desvinculacion del trabajador <b>".$nom_trabajador."</b>.";
                   $accion="Revisar Documento";
                   $url="desvinculaciones_mandante.php";
                   $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,mandante,contratista,tipo,documento,trabajador,url) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','".$mandante."','".$contratista."','$tipo','".$nombre."','".$trabajadores[$i]."','$url') ");

                } else {
                  
                }
        } 
     }
     $i++;
  };
  
  //header('Location: http://tuweb.com/pagina.html');
  echo '<script> window.location.href="desvinculaciones_contratista.php"; </script>';

    
    
} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
?>