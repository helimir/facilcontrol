<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3  ) {    
    include('../config/config.php');
    $contratista=$_SESSION['contratista'];
    $mandante=$_SESSION['mandante'];
    $contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';
    $perfil=isset($_POST['perfil']) ? $_POST['perfil']: '';
    $rut=isset($_POST['rut']) ? $_POST['rut']: '';
    $trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
    
    $image = getimagesize($_FILES["foto"]["tmp_name"]);
    $maximum = array(
        'width' => '400',
        'height' => '400'
    );
    $minimum = array(
        'width' => '200',
        'height' => '200'
    );
    $image_width = $image[0];
    $image_height = $image[1];
   // if (  $image_width > $maximum['width'] || $image_height > $maximum['height'] ||  $image_width < $minimum['width'] || $image_height < $minimum['height']  ) {
      //  echo 2;
    //} else {    
            if(!$_FILES["foto"]["error"]>0){
                        $permitidos = array('image/jpeg', 'image/png', 'image/jpg');
                        $limite_kb = 1000;                		
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);                        
                        if(in_array($_FILES["foto"]["type"], $permitidos) ) {
                        
                        #if ($extension=="jfif") {
                        #    $extension="jpg";
                        #}    
                        $extension="jpg";
                        $carpeta_contratista = '../doc/trabajadores/'.$contratista.'/'.$rut.'/';   
                        $nombre_contratista='foto_'.$contratista.'_'.$rut.'.'.$extension; 

                        $archivo_contratista = $carpeta_contratista.$nombre_contratista;
                  		
                  		$resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo_contratista);
                  		if($resultado){
                  		    
                            # actualiza la tabla trabajador en la contratista
                            #mysqli_query($con,"update trabajador set  url_foto='$url_contratista' where rut='".$rut."' and contratista='$contratista'  ");
                                    
                            $origen_c='../doc/trabajadores/'.$contratista.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            $destino_c='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            
                            if (copy($origen_c,$destino_c)) {    
                                $query_comentario=mysqli_query($con,"select * from comentarios where leer_contratista=0 and leer_mandante=0 and doc='Foto del trabajador' and contratista='$contratista' and mandante='$mandante' and trabajador='$trabajador' and contrato='$contrato' ");
                                $existe_comentario=mysqli_num_rows($query_comentario);
                                #enviar notificacion de documento al mandante si existe un comentario
                                if ($existe_comentario>0) {
                                    $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$trabajador' and contratista='$contratista' ");
                                    $result_t=mysqli_fetch_array($query_t);
                                    $nom_trabajador=$result_t['tipo'].' '.$result_t['marca'].' '.$result_t['modelo'].' '.$result_t['year'];

                                    $query_contrato=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='$contrato' ");
                                    $resul_contrato=mysqli_fetch_array($query_contrato);
                                    $nom_contrato=$resul_contrato['nombre_contrato'];

                                    $query_contratista=mysqli_query($con,"select razon_social from contratistas where id_contratista='$contratista' ");
                                    $resul_contratista=mysqli_fetch_array($query_contratista);
                                    $nom_contratista=$resul_contrato['razon_social'];

                                    
                                    $item='Documento Trabajador Recibido';                
                                    $nivel=3;
                                    $tipo=2;
                                    $envia=$contratista;
                                    $recibe=$_SESSION['mandante'];
                                    $mensaje="El contratista <b>$nom_contratista</b> envio el documento <b>$nom_documento</b> del trabajador <b>$nom_trabajador</b>, contrato <b>$nom_contrato</b> para ser revisado.";
                                    $usuario=$_SESSION['usuario'];
                                    $accion="Revisar foto de vehiculo reenviada";
                                    $url="verificar_documentos_trabajador_mandante.php";
                                    
                                    mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,trabajador,documento,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','".$_SESSION['mandante']."','$contratista','Foto del trabajador','$contrato','".$trabajador."','Foto del trabajador','$perfil') ");
                                }                        

                                mysqli_query($con,"update comentarios set leer_contratista=1,leer_mandante=1, estado='1' where  doc='Foto del trabajador' and contratista='$contratista' and trabajador='$trabajador' and contrato='$contrato' ");
                                mysqli_query($con,"delete from notificaciones  where contrato='$contrato' and contratista='$contratista' and item='Observacion Documento Trabajador' and control='Foto del trabajador' and trabajador='$trabajador' ");  
                                echo 0;   
                            } else {
                                echo 1;
                            }
                        } else {
                            // no se pudo guardar archivo
                          echo 1;              
                        }
                    }  else {
                        // archivo no permitido
                     echo 2;  
                    }                   
                }
      // }          
    
      
                
                    
                        
                
                    
                      
        

} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>