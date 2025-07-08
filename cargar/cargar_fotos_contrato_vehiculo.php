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

    $query_t=mysqli_query($con,"select o.razon_social, c.nombre_contrato, t.*, a.* from autos as t Left Join vehiculos_asignados as a On a.vehiculos=t.id_auto left join contratos as c On c.id_contrato=a.contrato left join contratistas as o On o.id_contratista=a.contratista where t.id_auto='$trabajador' and a.contrato='$contrato' ");
    $result_t=mysqli_fetch_array($query_t);

    $carpeta='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/';
    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0777, true);
    }

    $carpeta2='../doc/vehiculos/'.$contratista.'/'.$rut.'/';
    if (!file_exists($carpeta2)) {
        mkdir($carpeta2, 0777, true);
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
            
                        $permitidos = array('image/jpeg', 'image/png', 'image/jpg');
                        $limite_kb = 1000;                		
                        $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);                        
                        if(in_array($_FILES["foto"]["type"], $permitidos) ) {
                        
                        #if ($extension=="jfif") {
                        #    $extension="jpg";
                        #}    
                        $extension="jpg";
                        $carpeta_contratista = '../doc/vehiculos/'.$contratista.'/'.$rut.'/';   
                        $nombre_contratista='foto_'.$contratista.'_'.$rut.'.'.$extension; 
                        $url_contratista='doc/vehiculos/'.$contratista.'/'.$rut.'/'.$nombre_contratista;

                        $archivo_contratista = $carpeta_contratista.$nombre_contratista;
                  		
                  		$resultado = @move_uploaded_file($_FILES["foto"]["tmp_name"], $archivo_contratista);
                  		if($resultado){        

                            # actualiza la tabla trabajador en la contratista
                            mysqli_query($con,"update autos set  url_foto='$url_contratista' where id_auto='".$trabajador."' and contratista='$contratista'  ");
                                    
                            $origen_c='../doc/vehiculos/'.$contratista.'/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            $destino_c='../doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            
                            copy($origen_c,$destino_c);

                            $url_contrato='doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/vehiculos/'.$rut.'/foto_'.$contratista.'_'.$rut.'.jpg';
                            mysqli_query($con,"update vehiculos_asignados set url_foto='$url_contrato', verificados='2' where vehiculos='".$trabajador."' and contrato='".$contrato."'  ");
                            

                            $nom_contratista=$result_t['razon_social'];
                            $nom_contrato=$result_t['nombre_contrato'];
                            $item='Foto Vehiculo Recibido';                 
                            $nivel=3;
                            $tipo=3;
                            $envia=$contratista;
                            $recibe=$mandante;
                            $mensaje="El contratista <b>$nom_contratista</b> adjunto la foto del vehiculo con siglas <b>$rut</b>, contrato <b>$nom_contrato</b> para ser revisada.";
                            $usuario=$_SESSION['usuario'];
                            $accion="Revisar documento de contratista";
                            $url="verificar_documentos_vehiculos_mandante.php";
                            
                            mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,tipo,mandante,contratista,control,contrato,trabajador,documento,cargo,perfil) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','$tipo','$mandante','$contratista','Foto del vehiculo','$contrato','$trabajador','Foto del vehiculo','$cargo','$perfil') ");

                               
                            echo 0;   
                        } else {
                            // no se pudo guardar archivo
                          echo 1;              
                        }
                    }  else {
                        // archivo no permitido
                     echo 2;  
                    }                   
        

    
                             
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>