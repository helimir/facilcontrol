<?php
session_start();
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());    
    $mes_doc=date('m');
        
    $contratista=$_SESSION["contratista"];
    $contrato=$_SESSION['contrato'];
    $perfil=$_SESSION['perfil'];
    $cargo=$_SESSION['cargo'];
    
    $arr_doc=serialize(json_decode(stripslashes($_POST['doc'])));
    $arr_doc_e=serialize(json_decode(stripslashes($_POST['doc_e'])));
    $arr_com=serialize(json_decode(stripslashes($_POST['com'])));
    $arr_est=serialize(json_decode(stripslashes($_POST['estado'])));
    $arr_existe_doc=serialize(json_decode(stripslashes($_POST['existe_doc'])));
    

    $doc=unserialize($arr_doc);
    $doc_e=unserialize($arr_doc_e);
    $com=unserialize($arr_com);
    $estado=unserialize($arr_est);
    $existe_doc=unserialize($arr_existe_doc);
    
    $query_contratista=mysqli_query($con,"select d.mandante as idmandante, c.* from contratistas as c LEFT JOIN contratistas_mandantes as d On d.contratista=d.contratista where c.id_contratista='$contratista' ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    
    $rut_t=$_POST['rut_t'];
    $nom_contrato=$_POST['nom_contrato'];
    $trabajador=$_POST['trabajador'];
    
    $query_t=mysqli_query($con,"select * from autos where id_auto='$trabajador' and contratista='$contratista' ");
    $result_t=mysqli_fetch_array($query_t);
    $nom_trabajador=$result_t['tipo'].' '.$result_t['marca'].' '.$result_t['modelo'].' '.$result_t['year'];
    $siglas=$result_t['siglas'].'-'.$result_t['control'];
    $patente=$result_t['patente'];
    
    $procesada=0;
    $i=0;  
    foreach ($doc as $row) { 
        
        if ($_FILES["carga_doc_t"]["name"][$i]) {  
                        
          
           $query_doc=mysqli_query($con,"select * from doc_autos where id_vdoc='".$row."' ");
           $result_doc=mysqli_fetch_array($query_doc);

           $query_na=mysqli_query($con,"select * from noaplica_vehiculo where documento='".$row."' and contrato='$contrato' and vehiculo='$trabajador' ");
           $result_na=mysqli_num_rows($query_na);
           #existe un documento no aplica
           if ($result_na>0) {
               #borrar registro del documento en no apllica trabajar
               mysqli_query($con,"delete from noaplica_vehiculo where documento='".$row."' and contrato='$contrato' and vehiculo='$trabajador' ");
               #borrar la notidicacion no aplica
               mysqli_query($con,"delete from notificaciones where documento='".$row."' and contrato='$contrato' and item='Documento Vehiculo No Aplica' and trabajador='$trabajador' ");
           }
                        
           #$extension = pathinfo($arch, PATHINFO_EXTENSION);
                
           $carpeta = 'doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/';
           $nombre=$result_doc['documento'].'_'.$siglas.'.pdf';
                
                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                }
                           
                $archivo=$carpeta.$nombre;
                #Cargando el fichero en la carpeta                
                if (@move_uploaded_file($_FILES["carga_doc_t"]["tmp_name"][$i], $archivo)) {   

                    # verificar si noti ya existe y no ha sido procesada
                    $query_noti_existe=mysqli_query($con,"select * from notificaciones where procesada='0' and item='Documento Vehiculo Recibido' and control='".$result_doc['documento']."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."' and contrato='$contrato' and trabajador='$trabajador'  ");
                    $existe_noti=mysqli_num_rows($query_noti_existe);

                    $query_noti_existe_o=mysqli_query($con,"select * from notificaciones where procesada='0' and item='Observacion Documento Vehiculo' and control='".$result_doc['documento']."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."' and contrato='$contrato'  ");
                    $existe_noti_o=mysqli_num_rows($query_noti_existe_o);


                  
                    if ($existe_noti=='0') {
                   
                        $nom_contratista=$result_contratista['razon_social'];
                        $nom_documento=$result_doc['documento'];
                        $item='Documento Vehiculo Recibido';                 
                        $nivel=3;
                        $tipo=3;
                        $envia=$contratista;
                        $recibe=$_SESSION['mandante'];
                        $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$nom_documento</b> del vehiculo <b>$nom_trabajador</b> siglas <b>$siglas</b>, contrato <b>$nom_contrato</b> para ser revisado.";
                        $usuario=$_SESSION['usuario'];
                        $accion="Revisar documento de vehiculo";
                        $url="verificar_documentos_vehiculos_mandante.php";
                        
                        mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,perfil,cargo,trabajador,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nom_documento','$contrato','$perfil','$cargo','".$_POST['trabajador']."','$nom_documento') ");                                
                        mysqli_query($con,"update comentarios set leer_contratista=1,leer_mandante=1, estado='1' where id_com='".$com[$i]."' and doc='".$result_doc['documento']."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."' and trabajador='$trabajador' ");                        
                        mysqli_query($con,"delete from notificaciones  where contrato='$contrato' and contratista='$contratista' and item='Observacion Documento Vehiculo' and control='".$result_doc['documento']."' ");  
                        mysqli_query($con,"delete from notificaciones  where contrato='$contrato' and contratista='$contratista' and item='Documento vehiculo' and control='".$result_doc['documento']."' and trabajador='$trabajador' ");  
                        mysqli_query($con,"update vehiculos_asignados set verificados=2, editado='$date' where vehiculos='$trabajador' and contrato='$contrato' "); 
                      
                        echo  0 ;
                  }    
                } 

       # no hay documento adjuntado  
       }  
     $i++;  
    } 

    

    
    # si el documento ya existe en la bd de la contratista    
    $j=0;
    foreach ($doc_e as $row_e) {
        
        //if ($existe_doc[$i]==1) {
                
                    $query_doc_e=mysqli_query($con,"select * from doc_autos where id_vdoc='".$row_e."' ");
                    $result_doc_e=mysqli_fetch_array($query_doc_e);                                   
                                
                    $ruta1= 'doc/vehiculos/'.$contratista.'/'.$siglas.'/';
                    $ruta2= 'doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$siglas.'/';
                    
                               
                    if (!file_exists($ruta2)) {
                        mkdir($ruta2, 0777, true);
                    }                
                    
                    $nombre_e=$result_doc_e['documento'].'_'.$siglas.'.pdf';
                    $archivo=$ruta1.$nombre_e;
                    $archivof=$ruta2.$nombre_e;       
                    
                    $nombre_documento=$result_doc_e['documento'];
                    
                    $archivo_copiar= str_replace($ruta1, $ruta2, $archivo);
                    
                    if (copy($archivo,$archivo_copiar)) {
                    } else {
                      $copiado=0;  
                    } 
                    
                            $nom_contratista=$result_contratista['razon_social'];
                            $nom_documento=$result_doc['documento'];
                            $item='Documento Vehiculo Recibido';                 
                            $nivel=3;
                            $tipo=3;
                            $envia=$contratista;
                            $recibe=$_SESSION['mandante'];
                            $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$nombre_documento</b> del vehiculo <b>$nom_trabajador</b>, contrato <b>$nom_contrato</b> para ser revisado.";
                            $usuario=$_SESSION['usuario'];
                            $accion="Revisar documento de vehiculo";
                            $url="verificar_documentos_vehiculos_mandante.php";
                            
                            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,perfil,cargo,trabajador,documento) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','$nombre_documento','$contrato','$perfil','$cargo','".$_SESSION['trabajador']."','$nombre_documento') ");                                   
                            mysqli_query($con,"update comentarios set leer_contratista=1,leer_mandante=1, estado='1' where id_com='".$com[$i]."' and doc='".$result_doc['documento']."' and contratista='$contratista' and mandante='".$_SESSION['mandante']."' and trabajador='$trabajador' ");                            
                            mysqli_query($con,"delete from notificaciones  where contrato='$contrato' and contratista='$contratista' and item='Observacion Documento Trabajador' and control='".$result_doc['documento']."' ");                                  
                            mysqli_query($con,"update trabajadores_asignados set verificados=2, editado='$date' where trabajadores='$trabajador' and contrato='$contrato' ");  
                    echo 0;
      $j++;  
    }
  
} else { 

echo '<script> window.location.href="admin.php"; </script>';
}
?>