<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('../config/config.php');

    $query_config=mysqli_query($con,"select * from configuracion ");
    $result_config=mysqli_fetch_array($query_config);

    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d');
    $year = date('Y');
    $mes = date('m');
    $dia = date('d');

    $fecha=$dia.'-'.$mes.'-'.$year;
    
    $mesyyear=$mes.'_'.$year;
              
    $usuario=$_SESSION['usuario'];          
    $contratista=$_SESSION['contratista'];
    
    $rut=$_POST['rut'];
    $idtrabajador=$_POST['trabajador'];
    $tipo=$_POST['tipo'];  
   
    $contrato=$_POST['contrato'];

        
    # obtener extension de archivo  
    $arch = $_FILES["archivo_desvincular"]["name"];
    $extension = pathinfo($arch, PATHINFO_EXTENSION);
    
    $size = $_FILES["archivo_desvincular"]["size"];
      
    $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='".$idtrabajador."' ");
    $result_t=mysqli_fetch_array($query_t);

    $query_con=mysqli_query($con,"select * from contratistas where id_contratista='".$contratista."' ");
    $result_con=mysqli_fetch_array($query_con);
            
    $query_ta=mysqli_query($con,"select * from trabajadores_acreditados where trabajador='$idtrabajador' and contratista='$contratista' and estado=0  ");
    $result_ta=mysqli_fetch_array($query_ta);
    $acreditados=mysqli_num_rows($query_ta);

    $codigo=$result_ta['codigo'];
                    
    $trabajador=$result_t['nombre1'].' '.$result_t['apellido1']; 
    
    $enviado=0;
    $contador=0;
    if ($acreditados>1) {
        foreach ($query_ta as $row_ta) {
            $lista_contratos[$contador]=$row_ta['contrato'];
            $lista_codigos[$contador]=$row_ta['codigo'];
            $lista_mandantes[$contador]=$row_ta['mandante'];
            #$prueba=mysqli_query($con,"insert into prueba (valor,valor2,valor3,valor4,valor5) values ('$contador','".$row_ta['contrato']."','".$lista_contratos[$contador]."','".$row_ta['codigo']."','".$lista_codigos[$contador]."') ");
            $contador++;
            
        };
    }       

    # desvincular contratista
    if ($tipo==1)  {


        # si esta acreditado en vario contratos
        if ($acreditados>1) {

            $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            $carpeta='../doc/validados/'.$lista_mandantes[0].'/'.$_SESSION['contratista'].'/contrato_'.$lista_contratos[0].'/'.$result_t['rut'].'/'.$lista_codigos[0].'/';
            $nombre='documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';
            $archivo=$carpeta.$nombre; 
            
            if (@move_uploaded_file($_FILES["archivo_desvincular"]["tmp_name"], $archivo)) {                
                $enviado=1;
            };

            
            if ($enviado==1) {                        
                    
                    #copiar al resto de los contratos                    
                    for ($num=1;$num<=$acreditados-1;$num++) {
                        $carpeta2='../doc/validados/'.$lista_mandantes[$num].'/'.$_SESSION['contratista'].'/contrato_'.$lista_contratos[$num].'/'.$result_t['rut'].'/'.$lista_codigos[$num].'/';;
                        $archivo2=$carpeta2.$nombre;
                        
                        if (copy($archivo,$archivo2)) {
                            $copiado=1;
                        } else {
                            $copiado=0;
                        }
                    }
                    
                    #si archivos fueron copiados en otras carpetas
                    if ($copiado==1) {
                        
                        for ($cont=0;$cont<=$acreditados-1;$cont++) {

                            # seleccionar nombre del contrato correspondinte al mandante
                            $query_o=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$lista_contratos[$cont]."' and mandante='".$lista_mandantes[$cont]."' ");
                            $result_o=mysqli_fetch_array($query_o);
                            $nombre_contrato=$result_o['nombre_contrato'];
                                
                            $query_ed=mysqli_query($con,"select * from desvinculaciones where mandante='".$lista_mandantes[$cont]."' and contratista='$contratista' and verificado='0' and tipo='1'   ");
                            $existe_desvinculacion=mysqli_num_rows($query_ed);

                            if ($existe_desvinculacion==0) {
                                $query=mysqli_query($con,"insert into desvinculaciones (trabajador,mandante,contratista,creado,usuario,tipo,contrato) values ('$idtrabajador','".$lista_mandantes[$cont]."','$contratista','$date','$usuario','$tipo','".$lista_contratos[$cont]."') ");
                                
                                // seleccionar ultimo id de desvinculacion
                                $query_id_d =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'desvinculaciones' ");
                                $result_id_d= mysqli_fetch_array($query_id_d); 
                                $id_d=$result_id_d['AUTO_INCREMENT']-1;
                                
                                # notificacion desvinculaciono de trabajador de una contratista 
                                $item='Desvinculacion de Contratista'; 
                                $nivel=3; 
                                $tipo=1;
                                $envia=$contratista;
                                $recibe=$lista_mandantes[$cont];
                                $mensaje="El contratista <b>".$result_con['razon_social']."</b> ha enviado la desvinculacion del trabajador <b>".$trabajador."</b> vinculado al contrato <b>".$nombre_contrato."</b>.";
                                $accion="Revisar Documento";
                                $url="desvinculaciones_mandante.php";
                                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,control,mandante,contratista,tipo,documento,trabajador,url,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$id_d','".$lista_mandantes[$cont]."','$contratista','$tipo','$nombre','$idtrabajador','$url','".$lista_contratos[$cont]."') ");
                            }    
                        };        
                        
                        $query_d=mysqli_query($con,"update trabajador set estado=1 where trabajador='$idtrabajador' and contratista='$contratista'  ");
                        $query_tac=mysqli_query($con,"update trabajadores_acreditados set estado=1 where trabajador='$idtrabajador'  ");
                        $query_tag=mysqli_query($con,"update trabajadores_asignados set estado=1 where trabajadores='$idtrabajador'  ");
                        echo 0;
                    } else {
                        echo 1;
                    }
            }        
            
        # si esta en un solo contrato        
        } else {

            # seleccionar nombre del contrato correspondinte al mandante
            $query_o=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$contrato."' and mandante='".$mandante."' ");
            $result_o=mysqli_fetch_array($query_o);
            $nombre_contrato=$result_o['nombre_contrato'];

            $mandante=$_POST['mandante'];

            $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            $contrato=$result_ta['contrato'];
            $carpeta='../doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'.$contrato.'/'.$result_t['rut'].'/'.$codigo.'/';
            $nombre='documento_desvinculante_contratista_'.$result_t['rut'].'.pdf';
                      
            $archivo=$carpeta.$nombre;
            

            if (@move_uploaded_file($_FILES["archivo_desvincular"]["tmp_name"], $archivo)) {

                $query=mysqli_query($con,"insert into desvinculaciones (trabajador,mandante,contratista,creado,usuario,tipo,contrato) values ('$idtrabajador','$mandante','$contratista','$date','$usuario','$tipo','$contrato') ");
                
                // seleccionar ultimo id de desvinculacion
                $query_id_d =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'desvinculaciones' ");
                $result_id_d= mysqli_fetch_array($query_id_d); 
                $id_d=$result_id_d['AUTO_INCREMENT']-1;

                # notificacion desvinculaciono de trabajador de un contrato 
                $item='Desvinculacion de Contratista'; 
                $nivel=3; 
                $tipo=1;
                $envia=$contratista;
                $recibe=$mandante;
                $mensaje="El contratista <b>".$result_con['razon_social']."</b> ha enviado la desvinculacion del trabajador <b>".$trabajador."</b> vinculado al contrato <b>".$nombre_contrato."</b>.";
                $accion="Revisar Documento";
                $url="desvinculaciones_mandante.php";
                $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,documento,trabajador,contrato) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$id_d."','".$mandante."','".$contratista."','$tipo','".$nombre."','$idtrabajador','$contrato') ");
                
                $query_d=mysqli_query($con,"update trabajador set estado=1 where trabajador='$idtrabajador' and contratista='$contratista'  ");
                $query_tac=mysqli_query($con,"update trabajadores_acreditados set estado=1 where trabajador='$idtrabajador'  ");
                $query_tag=mysqli_query($con,"update trabajadores_asignados set estado=1 where trabajadores='$idtrabajador' ");
                echo 0;
            } else {
                echo 1;
            }


        }       
    } 
    # desvincular contrato
    if ($tipo==2) {
                
                $mandante=$_POST['mandante']; 
                #$prueba=mysqli_query($con,"insert into prueba (valor) values ('".$_POST['mandante']."') ");


                $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            
                $carpeta='../doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'. $contrato.'/'.$result_t['rut'].'/'.$codigo.'/';;

                $query_cont=mysqli_query($con,"select * from contratos where id_contrato='".$contrato."' ");
                $result_cont=mysqli_fetch_array($query_cont);
                $nombre='documento_desvinculante_contrato_'.$contrato.'_'.$result_t['rut'].'.pdf';

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0777, true);
                } 
                                        
                $archivo=$carpeta.$nombre;
                $url_d='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/contrato_'. $contrato.'/'.$result_t['rut'].'/'.$nombre;

                if (@move_uploaded_file($_FILES["archivo_desvincular"]["tmp_name"], $archivo)) {

                    $query=mysqli_query($con,"insert into desvinculaciones (trabajador,mandante,contratista,creado,usuario,tipo,url,contrato) values ('$idtrabajador','$mandante','$contratista','$date','$usuario','$tipo','$url_d','$contrato') ");
                    
                    // seleccionar ultimo id de desvinculacion
                    $query_id_d =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$result_config['bd_name']."' AND TABLE_NAME = 'desvinculaciones' ");
                    $result_id_d= mysqli_fetch_array($query_id_d); 
                    $id_d=$result_id_d['AUTO_INCREMENT']-1;

                    # notificacion desvinculaciono de trabajador de un contrato 
                    $item='Desvinculacion de Contrato'; 
                    $nivel=3; 
                    $tipo=1;
                    $envia=$contratista;
                    $recibe=$mandante;
                    $mensaje="El contratista <b>".$result_con['razon_social']."</b> ha enviado la desvinculacion del trabajador <b>".$trabajador."</b> del Contrato <b>".$result_cont['nombre_contrato']."</b>.";
                    $accion="Revisar Documento";
                    $url="desvinculaciones_mandante.php";
                    $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,documento,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$id_d."','".$mandante."','".$contratista."','$tipo','".$contrato."','".$nombre."','$idtrabajador') ");
                    #$query_d=mysqli_query($con,"update trabajadores_asignados set estado=1 where trabajadores='$idtrabajador' and contrato='$contrato'  ");
                    $query_tac=mysqli_query($con,"update trabajadores_acreditados set estado=1 where trabajador='$idtrabajador' and contrato='$contrato'  ");
                    $query_tag=mysqli_query($con,"update trabajadores_asignados set estado=1 where trabajadores='$idtrabajador' and contrato='$contrato'  ");
                    echo 0;
                } else {
                    echo 1;
                }

            } 
} else { 

echo '<script> window.location.href="../admin.php"; </script>';
}
?>