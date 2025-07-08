<?php
session_start();
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());    
    $mes_doc=date('m');
        
    $contratista=$_SESSION["contratista"];
    $mandante=$_SESSION["mandante"];
    $contrato=$_POST["contrato"];

    $query_contratista=mysqli_query($con,"select * from contratistas  where id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
   
    for ($i=0;$i<=$_POST['cant']-1;$i++) { 
            
                $arch = $_FILES["archivo"]["name"];
                $extension = pathinfo($arch, PATHINFO_EXTENSION);

                if ($_POST['tipo']==1) {
                    $query_doc=mysqli_query($con,"select * from documentos_extras where mandante='".$_POST['mandante']."' and contratista='$contratista' and id_de='".$_POST['doc']."' and tipo='1' and estado!='3' ");
                    $result_doc=mysqli_fetch_array($query_doc);

                    $carpeta = '../doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/';
                    $nombre=$result_doc['documento'].'_'.$result_contratista['rut'].'.pdf';
                    $url="gestion_doc_extradordinarios_mandante.php";
                    $url_extra='doc/temporal/'.$mandante.'/'.$contratista.'/'.$nombre;

                }    

                if ($_POST['tipo']==2) {
                    $query_doc=mysqli_query($con,"select * from documentos_extras where trabajador='".$_POST['trabajador']."' and contrato='$contrato' and tipo='2' and estado!='3' ");
                    $result_doc=mysqli_fetch_array($query_doc);

                    $query_trab=mysqli_query($con,"select c.nombre_contrato, a.codigo, t.rut, t.nombre1, t.apellido1 from trabajadores_acreditados as a LEFT JOIN trabajador as t On t.idtrabajador=a.trabajador Left join contratos as c On c.id_contrato=a.contrato where a.trabajador='".$result_doc['trabajador']."' and a.contrato='$contrato' and a.estado!='2' ");
                    $result_trab=mysqli_fetch_array($query_trab);
                    $trabajador=$result_trab['nombre1']." ".$result_trab['apellido1'];
                    $nombre_contrato=$result_trab['nombre_contrato'];

                    $carpeta = '../doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/contrato_'.$result_doc['contrato'].'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/';
                    $nombre=$result_doc['documento'].'_'.$result_trab['rut'].'.pdf';
                    $url="gestion_doc_extradordinarios_mandante_contrato.php";
                } 

                if ($_POST['tipo']==3) {
                    $query_doc=mysqli_query($con,"select * from documentos_extras where trabajador='".$arreglo_trabajadores[$i]."' and contrato='$contrato' and tipo='3' and estado!='3' ");
                    $result_doc=mysqli_fetch_array($query_doc);

                    $carpeta = '../doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/contrato_'.$result_doc['contrato'].'/'.$result_trab['codigo'].'/';
                    $query_trab=mysqli_query($con,"select c.nombre_contrato, a.codigo, t.rut, t.nombre1, t.apellido1 from trabajadores_acreditados as a LEFT JOIN trabajador as t On t.idtrabajador=a.trabajador Left join contratos as c On c.id_contrato=a.contrato where a.trabajador='".$result_doc['trabajador']."' and a.contrato='$contrato' and a.estado!='2' ");
                    $result_trab=mysqli_fetch_array($query_trab);
                    $trabajador=$result_trab['nombre1']." ".$result_trab['apellido1'];
                    $nombre_contrato=$result_trab['nombre_contrato'];

                    $carpeta = '../doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/contrato_'.$result_doc['contrato'].'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/';
                    $nombre=$result_doc['documento'].'_'.$result_trab['rut'].'.pdf';
                    $url="gestion_doc_extradordinarios_mandante.php";
                } 
                                
                                
                if (!file_exists($carpeta)) {
                  mkdir($carpeta, 0777, true);
                }
                
                $archivo=$carpeta.$nombre;                
                                    
                # si tipo contratista   
                if ($_POST['tipo']==1) {       
                        if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) { 

                            $nom_documento=$result_doc['documento'];
                            $nom_contratista=$result_contratista['razon_social'];
                            if ($result_doc['estado']==0) { 
                                # notificacion si doc extra contratista                                                                
                                $item='Documento Extraordinario Recibido';                 
                                $nivel=3;
                                $tipo=1;
                                $envia=$contratista; 
                                $recibe=$_POST['mandante'];
                                $mensaje="El contratista <b>$nom_contratista</b> envio el documento extraordinario <b>$nom_documento</b> para ser revisado.";
                                $usuario=$_SESSION['usuario'];
                                $accion="Revisar documento de contratista";

                                mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_POST['mandante']."','$contratista','$nom_documento','$nom_documento') ");

                                #ingresa a documentos subidos
                                mysqli_query($con,"insert into doc_subidos_contratista (documento,contratista,mandante,url,id_documento) values ('$nom_documento','$contratista','$mandante','$url_extra','".$_POST['doc']."') ");

                                     
                            } 

                            $query_noaplica=mysqli_query($con,"select * from noaplica where contratista='$contratista' and mandante='$mandante' and extra='$nom_documento'  ");
                            $result_noaplica=mysqli_fetch_array($query_noaplica);
                            $existe_noalica=mysqli_num_rows($query_noaplica); 

                            # hay no aplica asociado al documento que se envia
                            if ($existe_noalica>0) { 
                                mysqli_query($con,"delete from noaplica where id_na='".$result_noaplica['id_na']."' ");    
                            }
                            
                            
                           # mysqli_query($con,"insert into prueba (valor,valor2,valor3) values ('".$result_doc['estado']."','$nom_documento','".$_POST['tipo']."') ");
                             # si el estado es observacion
                             if ($result_doc['estado']==2) {                                                
                                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Observacion Documento Extraordinario' and control='$nom_documento'  ");                                                        
                                mysqli_query($con,"update doc_comentarios_extra set leer_contratista=1, leer_mandante=1, estado=1 where mandante='".$_POST['mandante']."' and contratista='$contratista' and documento='$nom_documento' and tipo='1' ");
                                mysqli_query($con,"update documentos_extras set estado=1 where documento='$nom_documento' and mandante='".$_POST['mandante']."' and contratista='$contratista' and tipo='1' "); 

                                 # notificacion si doc extra contratista                                                                
                                 $item='Documento Extraordinario Recibido';                 
                                 $nivel=3;
                                 $tipo=1;
                                 $envia=$contratista; 
                                 $recibe=$_POST['mandante'];
                                 $mensaje="El contratista <b>$nom_contratista</b> envio el documento extraordinario <b>$nom_documento</b> para ser revisado.";
                                 $usuario=$_SESSION['usuario'];
                                 $accion="Revisar documento de contratista";
 
                                 mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_POST['mandante']."','$contratista','$nom_documento','$nom_documento') ");
                                                
                            } 
                            if ($result_doc['estado']==0 or $result_doc['estado']==1 ) {         
                                mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Extraordinario Solicitado' and control='$nom_documento'   "); 
                                mysqli_query($con,"update documentos_extras set estado=1 where documento='$nom_documento' and mandante='".$_POST['mandante']."' and contratista='$contratista' and tipo='1' ");                                             
                            }
                            echo 0; 
                        } else {
                            echo 1;
                        }
                
                # si es tipo trabajadores
                } 
                
                if ($_POST['tipo']==2 or $_POST['tipo']==3) {

                        if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
                        
                            $rut_inicial= $result_trab['rut'];
                            $codigo_inicial= $result_trab['codigo'];
                                
                            # si documento no ha sido enviado o no esta acreditado
                            if ($result_doc['estado']==0) { 

                                    # notificacion si doc extra todos contrato
                                    $nom_contratista=$result_contratista['razon_social'];
                                    $nom_documento=$result_doc['documento'];
                                    $item='Documento Extraordinario Recibido';                 
                                    $nivel=3;
                                    $tipo=1;
                                    $envia=$contratista;
                                    $recibe=$_SESSION['mandante'];
                                    $mensaje="El contratista <b>$nom_contratista</b> envio el documento extraordinario <b>$nom_documento</b> contrato <b>$nombre_contrato</b> trabajador <b>$trabajador</b> para ser revisado.";
                                    $usuario=$_SESSION['usuario'];
                                    $accion="Revisar documento de contratista";

                                    $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,trabajador,contrato,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','".$result_doc['trabajador']."','".$result_doc['contrato']."','$nom_documento') ");
                                            
                                # si el estado es observacion
                                if ($result_doc['estado']==2) {
                                                
                                    mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Observacion Documento Extraordinario' and control='$nom_documento' and trabajador='".$result_doc['trabajador']."' and contrato='$contrato'  ");                                                            
                                    mysqli_query($con,"update doc_comentarios_extra set leer_contratista=1, leer_mandante=1, estado=1 where contrato='".$contrato."' and documento='$nom_documento' and contratista='$contratista' and mandante='$mandante' ");
                                    mysqli_query($con,"update documentos_extras set estado=1 where trabajador='".$result_doc['trabajador']."' and contrato='$contrato'  "); 
                                                    
                                } else {
                                    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Extraordinario Solicitado' and control='$nom_documento' and trabajador='".$result_doc['trabajador']."' and contrato='$contrato'   "); 
                                    # estado recibido para el mandante
                                    mysqli_query($con,"update documentos_extras set estado=1 where trabajador='".$result_doc['trabajador']."' and contrato='$contrato' and documento='$nom_documento' "); 
                                }    
                            }       
                            echo 0;

                        } else {
                            $origen_extra  = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$result_doc['contrato'].'/'.$rut_inicial.'/'.$codigo_inicial.'/'.$result_doc['documento'].'_'.$rut_inicial.'.'.$extension;
                            $destino_extra = '../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$result_doc['contrato'].'/'.$result_trab['rut'].'/'.$result_trab['codigo'].'/'.$result_doc['documento'].'_'.$result_trab['rut'].'.'.$extension;

                            if (copy($origen_extra,$destino_extra)) {
                                $copiado=1;
                            } else {
                                $copiado=0;
                            }
                            # si documento no ha sido enviado o no esta acreditado
                            if ($result_doc['estado']!=1) {  
                                                    
                                       
                                # notificacion si doc extra todos contrato
                                $nom_contratista=$result_contratista['razon_social'];
                                $nom_documento=$result_doc['documento'];
                                $item='Documento Extraordinario Recibido';                 
                                $nivel=3;
                                $tipo=1;
                                $envia=$contratista;
                                $recibe=$_SESSION['mandante'];
                                $mensaje="El contratista <b>$nom_contratista</b> envio el documento extraordinario <b>$nom_documento</b> contrato <b>$nombre_contrato</b> trabajador <b>$trabajador</b> para ser revisado.";
                                $usuario=$_SESSION['usuario'];
                                $accion="Revisar documento de contratista";

                                mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','".$result_doc['trabajador']."','".$result_doc['contrato']."') ");
                                      
                                # si el estado es observacion
                                if ($result_doc['estado']==2) {                                                        
                                    mysqli_query($con,"delete from notificaciones  where contratista='$contratista' and mandante='$mandante' and item='Observacion Documento Extraordinario' and control='$nom_documento'  ");                                                                    
                                    mysqli_query($con,"update doc_comentarios_extra set leer_contratista=1, leer_mandante=1, estado=1 where contrato='".$contrato."' and documento='$nom_documento' and contratista='$contratista' and mandante='$mandante' ");
                                        
                                # si no es observacion
                                } else { 
                                    mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento Extraordinario Solicitado' and control='$nom_documento' and trabajador='".$result_doc['trabajador']."'  "); 
                                }    
                                                                                
                                # estado recibido para el mandante
                                mysqli_query($con,"update documentos_extras set estado=1 where trabajador='".$result_doc['trabajador']."' and contrato='$contrato' and documento='$nom_documento' "); 
                                                    
                            }       
                            echo 0;
                        }
                }
  };
    
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>