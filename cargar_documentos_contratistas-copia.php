<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());    
    $mes_doc=date('m');
        
    $contratista=$_SESSION["contratista"];
    $arreglo_doc=serialize($_POST['cadena_doc']);
    $arreglo_com=serialize($_POST['comentario']);
    $cadena=unserialize($arreglo_doc);
    $comentario=unserialize($arreglo_com);
    $cantidad=$_POST['cantidad'];
    
    $query_contratista=mysqli_query($con,"select * from contratistas where id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
    $i=0;
    foreach($_FILES["carga_doc"]['tmp_name'] as $key => $tmp_name ) {    
        
        # si archivo existe
       	if($_FILES["carga_doc"]["name"][$key]) { 
        
            
            
            switch ($mes_actual) {
                case '01';$mes='enero';break;
                case '02';$mes='febrero';break;
                case '03';$mes='marzo';break;
                case '04';$mes='abril';break;
                case '05';$mes='mayo';break;
                case '06';$mes='junio';break;
                case '07';$mes='julio';break;
                case '08';$mes='agosto';break;
                case '09';$mes='septiembre';break;
                case '10';$mes='octubre';break;
                case '11';$mes='noviembre';break;
                case '12';$mes='diciembre';break;
            }
                             
            $query_doc=mysqli_query($con,"select * from doc_contratistas where id_cdoc='".$cadena[$i]."' ");
            $result_doc=mysqli_fetch_array($query_doc);
                
            
            #$extension = pathinfo($arch, PATHINFO_EXTENSION);
                
            $carpeta = 'doc/contratistas/'.$contratista.'/';
            $nombre=$result_doc['documento'].'_'.$result_contratista['rut'].'.pdf';
                
            
                           
                
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }
                           
                $archivo=$carpeta.$nombre;   
               
                
                if (file_exists($archivo)) {
                    $condicion=TRUE;
                } else {
                    $condicion=FALSE;
                }
                 
                // Cargando el fichero en la carpeta "subidas"
                if (@move_uploaded_file($_FILES["carga_doc"]["tmp_name"][$key], $archivo)) {
                    if ($condicion) {
                    
                    $nom_documento=$result_doc['documento'];
                    # pasar a procesada notificacion de ese documento recibido
                    $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Documento Recibido' and control='$nom_documento' ");
                    
                    # pasar a procesada notificacion de ese observacion de documento
                    $update_noti=mysqli_query($con,"update notificaciones set procesada=1 where contratista='$contratista' and item='Observacion de Documento' and control='$nom_documento' ");
                } 
                    // notificacion que falta perfiles. accion. control: nombre del documento
                    $nom_contratista=$result_contratista['razon_social'];
                    $nom_documento=$result_doc['documento'];
                    $item='Documento Recibido';                 
                    $nivel=3;
                    $tipo=1;
                    $envia=$contratista;
                    $recibe=$result_contratista['mandante'];
                    $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$nom_documento</b> para ser revisado. ";
                    $usuario=$_SESSION['usuario'];
                    $accion="Revisar documento de contratista";
                    $url="gestion_documentos_contratistas.php";
                    $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$result_contratista['mandante']."','$contratista','$nom_documento') ");
                    
                    $query=mysqli_query($con,"update doc_comentarios set leer_contratista=1, leer_mandante=1 where id_dcom='".$comentario[$i]."' and doc='".$result_doc['documento']."' ");  
                      
                    
                
                    
                } else {
                  
                }
                
        
     }
     $i++;
  };
  
  //header('Location: http://tuweb.com/pagina.html');
  echo '<script> window.location.href="gestion_documentos.php"; </script>';

    
    
} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
?>