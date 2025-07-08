<?php
session_start();
error_reporting(-1);
if (isset($_SESSION['usuario']) ) {    
    include('config/config.php');
    date_default_timezone_set('America/Santiago');
    $date = date('Y-m-d H:m:s', time());
    $year = date('Y');
              
    $usuario=$_SESSION['usuario'];          
    $mandante=$_SESSION['mandante'];
    $contratista=$_SESSION['contratista'];
    
    $mensual=$_POST["mensual"];
    $contrato=$_POST["contrato"];
    $doc=$_POST["doc"];
    $mes=$_POST["mes"];
    $total=$_POST["total"];
    $arreglo=json_decode(stripslashes(($_POST["arreglo"])));
    
    $query=mysqli_query($con,"select m.*, c.nombre_contrato from mensuales_trabajador as m INNER JOIN contratos as c ON c.id_contrato=m.contrato where m.contrato='$contrato' and m.doc='$doc' and m.mes='$mes'  ");
    $result=mysqli_fetch_array($query);
    
    $query_d=mysqli_query($con,"select documento from doc_mensuales where id_dm='$doc' ");
    $result_d=mysqli_fetch_array($query_d);

    $query_c=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='$contrato' ");
    $result_c=mysqli_fetch_array($query_c);
    
    $query_o=mysqli_query($con,"select razon_social from contratistas where id_contratista='$contratista' ");
    $result_o=mysqli_fetch_array($query_o);
    
    $j=0;
    $y=0;
    
    for ($i=0;$i<=$total-1;$i++) {
        
            # obtener extension de archivo  
            $arch = $_FILES["archivo"]["name"];
            $extension = pathinfo($arch, PATHINFO_EXTENSION);
        
            #$query_t=mysqli_query($con,"select m.trabajador, t.nombre1, t.apellido1, t.rut, m.contrato, m.contratista, a.codigo  from trabajador as t LEFT JOIN mensuales_trabajador as m On m.trabajador=t.idtrabajador left join trabajadores_acreditados as a On a.trabajador=m.trabajador where t.idtrabajador='".$arreglo[$i]."' and contrato='$contrato' and a.vigente='0' and m.doc='$doc'  ");
            $query_t=mysqli_query($con,"select m.mes, m.codigo, m.trabajador, m.contrato, m.contratista, t.nombre1, t.apellido1, t.rut from mensuales_trabajador as m LEFT JOIN trabajador as t On t.idtrabajador=m.trabajador Left Join trabajadores_acreditados as a On a.trabajador=m.trabajador  where m.trabajador='".$arreglo[$i]."'  and a.vigente='0' and m.doc='$doc' and m.mes='$mes' group by m.trabajador  ");
            $result_t=mysqli_fetch_array($query_t);
            
            $trabajador=$result_t['nombre1'].' '.$result_t['apellido1'];
            
            
            //$carpeta = 'doc/mensuales/'.$year.'/'.$mes.'/'.$mandante.'/'.$contratista.'/'.$contrato.'/'.$result_t['rut'].'/'.$result_t['codigo'].'/';
            $carpeta = 'doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_t['rut'].'/'.$result_t['codigo'].'/';
            $nombre=$result_d['documento'].'_'.$result_t['rut'].'_'.$mes.'_'.$year.'.'.$extension;
                        
                    
            if (!file_exists($carpeta)) { 
                mkdir($carpeta, 0777, true);
            } 
                               
            $archivo=$carpeta.$nombre;    
            
             $query_n=mysqli_query($con,"select * from notificaciones where item='Documento Mensual Recibido'    and contratista='$contratista' and mandante='$mandante' and contrato='$contrato' and trabajador='".$arreglo[$i]."' and documento='".$result_d['documento']."' and procesada='0' and control='$mes'  ");
             $existe_n=mysqli_num_rows($query_n);

            $query_n2=mysqli_query($con,"select * from notificaciones where item='Observacion Documento Mensual' and contratista='$contratista' and mandante='$mandante' and contrato='$contrato' and trabajador='".$arreglo[$i]."' and documento='".$result_d['documento']."' and procesada='0' and control='$mes'  ");
            $existe_n2=mysqli_num_rows($query_n2);
                                
            // Cargando el fichero en la carpeta "subidas"
            if (@move_uploaded_file($_FILES["archivo"]["tmp_name"], $archivo)) {
                        $j++; 
                        $rut_inicial=$result_t['rut'];
                        $codigo_inicial=$result_t['codigo'];

                        if ($existe_n==0 || $existe_n2>0) {
                            #notificacion documento de trabajador enviado. requiere accion. control id del trabajador
                            $item='Documento Mensual Recibido'; 
                            $nivel=3; 
                            $tipo=1;
                            $envia=$contratista;
                            $recibe=$mandante;
                            $mensaje="El contratista <b>".$result_o['razon_social']."</b> ha enviado el documento mensual <b>".$result_d['documento']."</b> del contrato <b>".$result_c['nombre_contrato']."</b>, trabajador <b>$trabajador</b>.";
                            $accion="Revisar Documento Mensual";
                            $url="gestion_doc_mensuales_mandantes.php";
                        
                            $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,documento,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$mes."','".$mandante."','".$contratista."','$tipo','".$contrato."','".$result_d['documento']."','".$arreglo[$i]."') ");

                            # actualizar procesada noti que envio mandante
                            $update_noti=mysqli_query($con,"delete from notificaciones where trabajador='".$arreglo[$i]."' and contratista='$contratista' and mandante='$mandante' and item='Gestion Documento Mensual' and contrato='$contrato' and control='$mes' and documento='".$result_d['documento']."'  ");

                           # if ( $existe_n2>0) {
                                # actualizar procesada noti que envio mandante observacion
                                $update_noti=mysqli_query($con,"delete from notificaciones where trabajador='".$arreglo[$i]."' and contratista='$contratista' and mandante='$mandante' and item='Observacion Documento Mensual' and contrato='$contrato' and control='$mes' and documento='".$result_d['documento']."'  ");

                                # actualizar tabla documentos mensuales observacion atendida
                                 $update_dm=mysqli_query($con,"update doc_comentarios_mensual set leer_mandante='1', leer_contratista='1', estado='1' where documento='".$result_d['documento']."' and contrato='$contrato' and contratista='$contratista' and trabajador='".$arreglo[$i]."' and mes='$mes' ");
                            #}   

                            # actualizar que documento fue enviado
                            #$update_d=mysqli_query($con,"update mensuales set estado='1' where doc_mensuales='$doc' and contrato='".$contrato."' and contratista='".$contratista."'  and mandante='$mandante' ");
                            $update_d=mysqli_query($con,"update mensuales_trabajador set enviado='1' where trabajador='".$arreglo[$i]."' and  doc='$doc' and contrato='".$contrato."' and contratista='".$contratista."'  and mandante='$mandante' and mes='$mes' ");
                        }    
                            
                         echo 0; 
            } else {
              
              $origen  = 'doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$rut_inicial.'/'.$codigo_inicial.'/'.$result_d['documento'].'_'.$rut_inicial.'_'.$mes.'_'.$year.'.'.$extension;
              $destino = 'doc/temporal/'.$mandante.'/'.$contratista.'/contrato_'.$contrato.'/'.$result_t['rut'].'/'.$result_t['codigo'].'/'.$result_d['documento'].'_'.$result_t['rut'].'_'.$mes.'_'.$year.'.'.$extension;

              copy($origen,$destino); 
              
              if ($existe_n==0) {
                    $item='Documento Mensual Recibido'; 
                    $nivel=3; 
                    $tipo=1;
                    $envia=$contratista;
                    $recibe=$mandante;
                    $mensaje="El contratista <b>".$result_o['razon_social']."</b> ha enviado el documento mensual <b>".$result_d['documento']."</b> del contrato <b>".$result_c['nombre_contrato']."</b>, trabajador <b>$trabajador</b>.";
                    $accion="Revisar Documento Mensual";
                    $url="gestion_doc_mensuales_mandantes.php";
                    $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,tipo,contrato,documento,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$mes."','".$mandante."','".$contratista."','$tipo','".$contrato."','".$result_d['documento']."','".$arreglo[$i]."') ");

                    # actualizar procesada noti que envio mandante
                    $update_noti=mysqli_query($con,"delete from notificaciones where trabajador='".$arreglo[$i]."' and contratista='".$contratista."' and mandante='$mandante' and item='Gestion Documento Mensual' and contrato='".$contrato."' and control='$mes' and documento='".$result_d['documento']."'  ");

                    # if ( $existe_n2>0) {
                        # actualizar procesada noti que envio mandante observacion
                        $update_noti=mysqli_query($con,"delete from notificaciones where trabajador='".$arreglo[$i]."' and contratista='$contratista' and mandante='$mandante' and item='Observacion Documento Mensual' and contrato='$contrato' and documento='".$result_d['documento']."' and control='$mes'  ");

                        # actualizar tabla documentos mensuales observacion atendida
                        $update_dm=mysqli_query($con,"update doc_comentarios_mensual set leer_mandante='1', leer_contratista='1', estado='1' where documento='".$result_d['documento']."' and contrato='$contrato' and contratista='$contratista' and trabajador='".$arreglo[$i]."' and mes='$mes'  ");
                    #}   

                    # actualizar que documento fue enviado
                    #$update_d=mysqli_query($con,"update mensuales set estado='1' where doc_mensuales='$doc' and contrato='".$contrato."' and contratista='".$contratista."'  and mandante='$mandante' ");
                    $update_d=mysqli_query($con,"update mensuales_trabajador set enviado='1' where trabajador='".$arreglo[$i]."'and  doc='$doc' and contrato='".$contrato."' and contratista='".$contratista."'  and mandante='$mandante' and mes='$mes' ");
              }
            }

            # agregar informacion a mensuales trabajador
            #$query_ta=mysqli_query($con,"insert into mensuales_trabajador (mensuales,trabajador,contratista,mandante,contrato,creado) values ('$doc','".$arreglo[$i]."','".$result['contratista']."','$mandante','".$result['contrato']."','$date') ");            
    }    
  
     
} else { 

echo '<script> window.location.href="index.php"; </script>';
}
?>