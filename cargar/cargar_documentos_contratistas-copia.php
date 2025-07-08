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
    
    //$query_contratista=mysqli_query($con,"select d.mandante as idmandante, c.* from contratistas as c LEFT JOIN contratistas_mandantes as d On d.contratista=d.contratista where c.id_contratista='$contratista' ");

    $query_contratista=mysqli_query($con,"select razon_social, rut from contratistas where id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
    $i=0;
    $contador=0;
    $index=0;
    $cantidad=$_POST['cant'];
    $doc_ya_existe=false;
    
    #foreach($_FILES["carga_doc"]['tmp_name'] as $key => $tmp_name ) {
    for ($i=0;$i<=$_POST['cant']-1;$i++) {    


       # si documento no aplica 
       if ($aplica[$i]!=0) {

                $query_doc2=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$aplica[$i]."' ");
                $result_doc2=mysqli_fetch_array($query_doc2); 

                // notificacion que falta perfiles. accion. control: nombre del documento
                $nom_contratista=$result_contratista['razon_social'];
                $nom_documento=$result_doc2['documento'];
                $item='Documento No Aplica';                 
                $nivel=3;
                $tipo=1;
                $envia=$contratista;
                $recibe=$_SESSION['mandante']; 
                $mensaje="El contratista <b>$nom_contratista</b> indica que el <b>$nom_documento</b> no aplica.";
                $usuario=$_SESSION['usuario'];
                $accion="Revisar documento de contratista";
                $url="gestion_documentos_contratistas.php";


                $query_na=mysqli_query($con,"select id_na from noaplica where contratista='$contratista' and mandante='$mandante' and documento='".$aplica[$i]."' ");
                $result_na=mysqli_fetch_array($query_na);
                $no_aplica=$result_na['id_na'];

                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','$no_aplica') ");
                          
                
                $nombre=$result_doc2['documento'].'_'.$result_contratista['rut'].'.pdf';
                $url='doc/temporal/'.$mandante.'/'.$contratista.'/'.$nombre;        
                $query_a=mysqli_query($con,"insert into doc_subidos_contratista (documento,contratista,mandante,url,id_documento) values ('$nom_documento','$contratista','$mandante','$url','".$aplica[$i]."') ");

                echo 0;

       }  
        
       if ($_FILES["carga_doc"]["name"][$i]!= null) {    

            $query_doc=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$doc[$i]."' ");
            $result_doc=mysqli_fetch_array($query_doc); 
          
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
                     $query_noti_existe=mysqli_query($con,"select * from notificaciones where procesada='0' and item='Documento Recibido' and control='".$result_doc['documento']."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."'  ");
                     $existe_noti=mysqli_num_rows($query_noti_existe);

                     $query_noti_existe_o=mysqli_query($con,"select * from notificaciones where procesada='0' and item='Observacion de Documento' and control='".$result_doc['documento']."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."'  ");
                     $existe_noti_o=mysqli_num_rows($query_noti_existe_o);

                     
                     if ($existe_noti=='0' or $existe_noti_o=='0') {

                            
                            // notificacion que falta perfiles. accion. control: nombre del documento
                            $nom_contratista=$result_contratista['razon_social'];
                            $nom_documento=$result_doc['documento'];
                            $item='Documento Recibido';                 
                            $nivel=3;
                            $tipo=1;
                            $envia=$contratista;
                            $recibe=$_SESSION['mandante'];
                            $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$nom_documento</b> para ser revisado.";
                            $usuario=$_SESSION['usuario'];
                            $accion="Revisar documento de contratista";
                            $url="gestion_documentos_contratistas.php";
                            
                           
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento') ");
                           
                            $url='doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/'.$nombre;        
                            $query_a=mysqli_query($con,"insert into doc_subidos_contratista (documento,contratista,mandante,url,id_documento) values ('$nom_documento','$contratista','$mandante','$url','".$doc[$i]."') ");
                            
                            $query=mysqli_query($con,"update doc_comentarios set leer_contratista=1, leer_mandante=1, estado=1 where id_dcom='".$com[$i]."' and doc='$nom_documento' and contratista='$contratista' and mandante='$mandante' ");  
                            
                            $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and mandante='$mandante' and item='Gestion Documentos de Contratista' and control='$nom_documento'  ");
                            $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and mandante='$mandante' and item='Observacion de Documento' and control='$nom_documento'  ");
                    }    
                    
                    
                    
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