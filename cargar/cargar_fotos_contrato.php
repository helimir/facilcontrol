<?php
session_start();
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');

    $trabajador=isset($_POST['trabajador']) ? $_POST['trabajador']: '';
    $contrato=isset($_POST['contrato']) ? $_POST['contrato']: '';
    $contratista=isset($_POST['contratista']) ? $_POST['contratista']: '';
    $mandante=isset($_POST['mandante']) ? $_POST['mandante']: '';
    $cargo=isset($_POST['cargo']) ? $_POST['cargo']: '';
    $perfil=isset($_POST['perfil']) ? $_POST['perfil']: '';
    $rut=isset($_POST['rut']) ? $_POST['rut']: '';

    $query_t=mysqli_query($con,"select o.razon_social, c.nombre_contrato, t.url_foto as foto, t.*, a.* from trabajador as t Left Join trabajadores_asignados as a On a.trabajadores=t.idtrabajador left join contratos as c On c.id_contrato=a.contrato left join contratistas as o On o.id_contratista=a.contratista where t.idtrabajador='$trabajador' and a.contrato='$contrato' ");
    $result_t=mysqli_fetch_array($query_t);

    $carpeta=$carpeta='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/';
                            if (!file_exists($carpeta)) {
                                mkdir($carpeta, 0777, true);
                            }

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
                        $url_contratista='doc/trabajadores/'.$contratista.'/'.$rut.'/'.$nombre_contratista;

                        $archivo_contratista = $carpeta_contratista.$nombre_contratista;
                  		
                  		$resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo_contratista);
                  		if($resultado){
                            # actualiza la tabla trabajador en la contratista
                            mysqli_query($con,"update trabajador set  url_foto='$url_contratista' where rut='".$rut."' and contratista='$contratista'  ");
                                    
                            $origen_c='../doc/trabajadores/'.$contratista.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            $destino_c='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            
                            copy($origen_c,$destino_c);

                            $url_contrato='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            mysqli_query($con,"update trabajadores_asignados set verificados='2',  url_foto='$url_contrato' where trabajadores='".$trabajador."' and contrato='".$contrato."'  ");

                            $nom_contratista=$result_t['razon_social'];
                            $nom_contrato=$result_t['nombre_contrato'];
                            $nom_trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
                            $item='Foto Trabajador Recibido';                 
                            $nivel=3;
                            $tipo=2;
                            $envia=$contratista; 
                            $recibe=$mandante;
                            $mensaje="El contratista <b>$nom_contratista</b> adjunto la foto del trabajador <b>$nom_trabajador</b>, contrato <b>$nom_contrato</b> para ser revisada.";
                            $usuario=$_SESSION['usuario'];
                            $accion="Revisar documento de contratista";
                            $url="verificar_documentos_trabajador_mandante.php";
                            
                            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,trabajador,documento,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','Foto del trabajador','$contrato','$trabajador','Foto del trabajador','$cargo','$perfil') ");

                               
                            echo 0;   
                        } else {
                            // no se pudo guardar archivo
                          echo 1;              
                        }
                    }  else {
                        // archivo no permitido
                     echo 2;  
                    }                   
        }

    
                             
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>