<?php
session_start();
if (isset($_SESSION['usuario']) ) {  
    include('../config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());    
    $mes_doc=date('m');
      
    $contratista=$_SESSION["contratista"];
    $mandante=$_SESSION["mandante"];
        
    $arr_doc=serialize(json_decode(stripslashes($_POST['doc'])));
    $arr_com=serialize(json_decode(stripslashes($_POST['com'])));
    $arr_aplica=serialize(json_decode(stripslashes($_POST['aplica'])));    

    $doc=unserialize($arr_doc);
    $com=unserialize($arr_com);
    $aplica=unserialize($arr_aplica);
    
    $query_contratista=mysqli_query($con,"select razon_social, rut from contratistas where id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
    $i=0;
    $contador=0;
    $index=0;
    $cantidad=$_POST['cant'];
    $doc_ya_existe=false;
    
    #foreach($_FILES["carga_doc"]['tmp_name'] as $key => $tmp_name ) {
    for ($i=0;$i<=$_POST['cant']-1;$i++) { 
        
       if ($_FILES["carga_doc"]["name"][$i]!= null) {    

            $query_doc=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$doc[$i]."' ");
            $result_doc=mysqli_fetch_array($query_doc); 

            $nom_documento=$result_doc['documento'];

            $query_na=mysqli_query($con,"select * from noaplica where documento='".$doc[$i]."' and contratista='$contratista' and mandante='$mandante'  ");
            $result_na=mysqli_num_rows($query_na);
                      
            $arch=$_FILES["carga_doc"]["name"][$i];
            $extension = pathinfo($arch, PATHINFO_EXTENSION); 
                    
            $carpeta = '../doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/';
            $nombre=$result_doc['documento'].'_'.$result_contratista['rut'].'.'.$extension;
                           
                
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
                           
            $archivo=$carpeta.$nombre;
                
            if (file_exists($archivo)) {
                $doc_ya_existe=true;
            }
                 
            #Cargando el fichero en la carpeta                
            if (@move_uploaded_file($_FILES["carga_doc"]["tmp_name"][$i], $archivo)) {                    
                    
                     # verificar si noti ya existe y no ha sido procesada
                     $query_noti_existe=mysqli_query($con,"select * from notificaciones where procesada='0' and item='Documento Recibido' and control='".$nom_documento."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."'  ");
                     $existe_noti=mysqli_num_rows($query_noti_existe);

                     $query_noti_existe_o=mysqli_query($con,"select * from notificaciones where procesada='0' and item='Observacion de Documento' and control='".$nom_documento."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."'  ");
                     $existe_noti_o=mysqli_num_rows($query_noti_existe_o);

                     $existe=$existe_noti+$existe_noti_o;


                     #existe un documento no aplica
                    if ($result_na>0) {
                        mysqli_query($con,"delete from noaplica where documento='".$doc[$i]."' and contratista='$contratista' and mandante='$mandante' ");                                              
                        mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' and control='$nom_documento'  ");
                        mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Gestion Documentos de Contratista' and control='$nom_documento'  ");
                        mysqli_query($con,"update doc_comentarios set leer_contratista=1, leer_mandante=1, estado=1 where  doc='$nom_documento' and contratista='$contratista' and mandante='$mandante' ");
                        mysqli_query($con,"delete from doc_subidos_contratista  where id_documento='".$doc[$i]."' and contratista='$contratista' and mandante='$mandante' and noaplica=1  ");
                    }
                    #mysqli_query($con,"delete from doc_subidos_contratista  where id_documento='".$doc[$i]."' and contratista='$contratista' and mandante='$mandante' and noaplica=1  ");
                                        
                    # si no hay una notificacion de observacion o recibido
                    if ($existe=='0') {
                            
                            $nom_contratista=$result_contratista['razon_social'];                            
                            $item='Documento Recibido';                 
                            $nivel=3;
                            $tipo=1;
                            $envia=$contratista;
                            $recibe=$_SESSION['mandante'];
                            $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$nom_documento</b> para ser revisado.";
                            $usuario=$_SESSION['usuario'];
                            $accion="Revisar documento de contratista";
                            $url="gestion_documentos_contratistas.php";
                           
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','$nom_documento') ");
                           
                            $url2='doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/'.$nombre;        
                            mysqli_query($con,"insert into doc_subidos_contratista (documento,contratista,mandante,url,id_documento,creado) values ('$nom_documento','$contratista','$mandante','$url2','".$doc[$i]."','$date') ");                                
                            mysqli_query($con,"update doc_comentarios set leer_contratista=1, leer_mandante=1, estado=1 where doc='$nom_documento' and contratista='$contratista' and mandante='$mandante' ");                              
                            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Documento No Aplica' and control='$nom_documento'  ");
                            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' and control='$nom_documento'  ");
                            mysqli_query($con,"delete from notificaciones where contratista='$contratista' and mandante='$mandante' and item='Gestion Documentos de Contratista' and control='$nom_documento'  ");
                    }

                    #$query_subidos=mysqli_query($con,"select * from doc_subidos_contratista where documento='".$nom_documento."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."'  ");
                    #$existe_subidos=mysqli_num_rows($query_subidos);
                    #if ($existe_subidos==0) {
                        
                    #}
                    
                echo 0;                     
            } else {
                echo 1;
            }
       }
  };
    
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>