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
    
    $arreglo_trabajador=serialize(json_decode(stripslashes($_POST['trabajadores'])));
    $arreglo_comentario=serialize(json_decode(stripslashes($_POST['comentarios'])));
    $arreglo_tipo=serialize(json_decode(stripslashes($_POST['tipos'])));
    $arreglo_id=serialize(json_decode(stripslashes($_POST['id'])));
    $arreglo_contratos=serialize(json_decode(stripslashes($_POST['contratos'])));
    
    $trabajadores=unserialize($arreglo_trabajador);
    $comentarios=unserialize($arreglo_comentario);
    $tipos=unserialize($arreglo_tipo);
    $id=unserialize($arreglo_id);
    $contratos=unserialize($arreglo_contratos);
    
    $cantidad=$total=count(json_decode(stripslashes($_POST['trabajadores'])));
    
    $query_contratista=mysqli_query($con,"select * from contratistas where id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
    
    for ($i=0;$i<=$cantidad-1;$i++) {     
        
        if ($_FILES["carga_doc_d"]["name"][$i]) {   
                
        $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='".$trabajadores[$i]."' ");
        $result_t=mysqli_fetch_array($query_t);
                  
            # si desvinculacion contratista
            if ($tipos[$i]==1)  {       
                
                $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='".$trabajadores[$i]."' and contratista='".$contratista."' and estado!='2'  ");
                $result_ta=mysqli_fetch_array($query_ta);
                $acreditados=mysqli_num_rows($query_ta);
                                
                $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
                
                $contador=0;
                # si esta en mas de un contrato
                if ($acreditados>1) {
                    
                    # formar arreglo de contratos del trabajador
                    foreach ($query_ta as $row_ta) {
                        $contratos[$contador]=$row_ta['contrato'];
                        $contador++;
                    };

                    $carpeta='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$contratos[0].'/'.$result_t['rut'].'/'.$result_ta['codigo'].'/';            
                    $nombre='documento_desvinculante_contratista'.$result_t['rut'].'.pdf';
                    $archivo=$carpeta.$nombre;
                    if (@move_uploaded_file($_FILES["carga_doc_d"]["tmp_name"][$i], $archivo)) {
                        for ($num=1;$num<=$acreditados-1;$num++) {
                            $carpeta2='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$contratos[$num].'/'.$result_t['rut'].'/'.$result_ta['codigo'].'/';
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
                        
                        # consultar si desvinculacion no ha sido revisada por el mandante control diferente de 0
                        $query_d=mysqli_query($con,"select * from desvinculaciones where id_d='".$id[$i]."' and control!='0' ");    
                        $result_d=mysqli_num_rows($query_d);

                        # si la desvinculacion ha sido atendida por el mandante
                        if ($result_d>0) {

                            $update_d=mysqli_query($con,"update desvinculaciones set control=3,  editado='$date' where trabajador='".$trabajadores[$i]."' and mandante='$mandante' ");
                            $update_n=mysqli_query($con,"update notificaciones set procesada=1 where item='Observacion Desvinculacion Contratista' and mandante='$mandante' and contratista='$contratista' and trabajador='".$trabajadores[$i]."' "); 
                            $query=mysqli_query($con,"update doc_comentarios_desvinculaciones set leer_contratista=1, leer_mandante=1, estado=1 where id_des='".$id[$i]."' and contratista='$contratista' and mandante='$mandante' ");

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
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,mandante,contratista,tipo,documento,trabajador,url,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','".$mandante."','".$contratista."','$tipo','".$nombre."','".$trabajadores[$i]."','$url','".$contratos[$i]."') ");
                                echo 0;
                            } else {
                                echo 0;
                            } 
                        }     
                
                # si esta en un solo contrato     

                } else {

                    $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='".$trabajadores[$i]."' and contratista='".$contratista."' and contrato='".$contratos[$i]."' and estado!='2'  ");
                    $result_ta=mysqli_fetch_array($query_ta); 

                    $carpeta='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$result_ta['contrato'].'/'.$result_t['rut'].'/'.$result_ta['codigo'].'/';            
                    $nombre='documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';
                    $archivo=$carpeta.$nombre;
                            
                    $archivo=$carpeta.$nombre;   
                
                    // Cargando el fichero en la carpeta "subidas"
                    if (@move_uploaded_file($_FILES["carga_doc_d"]["tmp_name"][$i], $archivo)) {
                    
                        
                    $update_d=mysqli_query($con,"update desvinculaciones set control=3, editado='$date' where trabajador='".$trabajadores[$i]."' and mandante='$mandante' ");
                    $update_n=mysqli_query($con,"update notificaciones set procesada=1 where item='Observacion Desvinculacion Contratista' and mandante='$mandante' and contratista='$contratista' and trabajador='".$trabajadores[$i]."' "); 
                    $query=mysqli_query($con,"update doc_comentarios_desvinculaciones set leer_contratista=1, leer_mandante=1, estado=1 where id_des='".$id[$i]."' and contratista='$contratista' and mandante='$mandante' ");
                    
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
                    $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,mandante,contratista,tipo,documento,trabajador,url,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','".$mandante."','".$contratista."','$tipo','".$nombre."','".$trabajadores[$i]."','$url','".$contratos[$i]."') ");

                    echo 0; 
                    } else {
                    echo 1; 
                    }

                }
            } 

            # si desvinculacion contrato  
            if ($tipos[$i]==2)  {

                $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='".$trabajadores[$i]."' and contratista='".$contratista."' and contrato='".$contratos[$i]."' and estado!='2' ");
                $result_ta=mysqli_fetch_array($query_ta); 

                $carpeta='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$result_ta['contrato'].'/'.$result_t['rut'].'/'.$result_ta['codigo'].'/';            
                $nombre='documento_desvinculante_contrato_'.$result_ta['contrato'].'_'.$result_t['rut'].'.pdf';
                $archivo=$carpeta.$nombre;
                           
                $archivo=$carpeta.$nombre;   
               
                // Cargando el fichero en la carpeta "subidas"
                if (@move_uploaded_file($_FILES["carga_doc_d"]["tmp_name"][$i], $archivo)) { 
                  
                      
                   $update_d=mysqli_query($con,"update desvinculaciones set control=3, editado='$date' where trabajador='".$trabajadores[$i]."' and mandante='$mandante' ");
                   $update_n=mysqli_query($con,"update notificaciones set procesada=1 where item='Observacion Desvinculacion Contrato' and mandante='$mandante' and contratista='$contratista' and trabajador='".$trabajadores[$i]."' "); 
                   $query=mysqli_query($con,"update doc_comentarios_desvinculaciones set leer_contratista=1, leer_mandante=1, estado=1 where id_des='".$id[$i]."' and contratista='$contratista' and mandante='$mandante' ");
                   
                   $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];

                   # notificacion desvinculaciono de trabajador de una contratista 
                   $item='Reenvio Desvinculacion de Contrato'; 
                   $nivel=3; 
                   $tipo=1;
                   $envia=$contratista;
                   $recibe=$mandante;
                   $mensaje="El contratista <b>".$result_contratista['razon_social']."</b> ha reenviado la desvinculacion del trabajador <b>".$nom_trabajador."</b>.";
                   $accion="Revisar Documento";
                   $url="desvinculaciones_mandante.php";
                   $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,mandante,contratista,tipo,documento,trabajador,url,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','".$mandante."','".$contratista."','$tipo','".$nombre."','".$trabajadores[$i]."','$url','".$contratos[$i]."') ");

                   echo 0; 
                } else {
                   echo 1; 
                }
        } 
    }    
  };
  
  //header('Location: http://tuweb.com/pagina.html');
  //echo '<script> window.location.href="desvinculaciones_contratista.php"; </script>';

    
    
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>