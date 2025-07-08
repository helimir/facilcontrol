<?php
session_start();
/**
 * @author lolkittens
 * @copyright 2022
 */
error_reporting(0);
include('config/config.php');
$date = date('Y-m-d H:m:s', time());

    	
        
        $usuario=mysqli_real_escape_string($con,(strip_tags($_POST["rut"],ENT_QUOTES)));
        $password=mysqli_real_escape_string($con,(strip_tags($_POST["pass"],ENT_QUOTES)));
        
        $query_usuario = mysqli_query($con,"SELECT * FROM users WHERE usuario =\"$usuario\" ");
        $result=mysqli_fetch_array($query_usuario);
        $hash=$result['pass'];
        $pass=password_verify($password,$hash );


                
        //if ($result['pass']!=NULL) {
            if ($query_usuario and $pass) {  // si rut y pass son correctos          
            
                if ($result['estado']!=0) {                    
                    $_SESSION['usuario']=$usuario;
                    $_SESSION['nivel']=$result['nivel'];
                    
                    // administrador
                    if ($_SESSION['nivel']==1) { // admin
                      //echo '<script>window.location.href="https://facilcontrol.cl/list_mandantes.php"</script>';
                      echo 1;
                    }
                    
                    if ($_SESSION['nivel']==2) { // mandanye
                      $query_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='$usuario' "); 
                      $result_mandante=mysqli_fetch_array($query_mandante);  
                      $_SESSION['mandante']=$result_mandante['id_mandante'];
                      //echo '<script>window.location.href="https://facilcontrol.cl/list_contratos.php"</script>';
                      echo 2;
                    }
                    
                    # contratistas
                    if ($_SESSION['nivel']==3) { // contratistas
                        $query_contratista=mysqli_query($con,"select d.mandante as idmandante, c.estado as estado_contratista, c.* from contratistas as c left join contratistas_mandantes as d On d.contratista=c.id_contratista where c.rut='$usuario' and d.eliminar=0 "); 
                        $result_contratista=mysqli_fetch_array($query_contratista); 
                            
                        date_default_timezone_set('America/Santiago');
                          
                        #$fecha_actual = date("10-06-2023");
                        $fecha_actual = date('d-m-Y');
                        $fecha_fin=$result_contratista['fecha_fin_plan'];
                          
                        $datetime1 = date_create($fecha_actual);
                        $datetime2 = date_create($fecha_fin);
                        $contador = date_diff($datetime1, $datetime2);
                        $differenceFormat = '%a';
                        $dias=$contador->format($differenceFormat);


                        $query_estado=mysqli_query($con,"select estado from contratistas where id_contratista='".$result_contratista['id_contratista']."'  ");
                        $result_estado=mysqli_fetch_array($query_estado);

                        # si contratista esta activa 
                        if ($result_estado['estado']==0 ) {
                              
                              # si esta deshabilitada por admin
                              if ($result_contratista['habilitada']==1) {
                                  echo 8;
                              } else {
                                    $_SESSION['contratista']=$result_contratista['id_contratista'];
                                    $_SESSION['estado']=$result_estado['estado']; 
                                    
                                    if ($dias==0 or $dias<=0) {
                                      $_SESSION['dias']=0;
                                    }  else {
                                      $_SESSION['dias']=$total_dias;
                                    }
                                    
                                    if ($result_contratista['multiple']==0) {
                                        $_SESSION['mandante']=$result_contratista['idmandante'];
                                    } else {
                                        $_SESSION['multiple']=$result_contratista['multiple'];
                                        $_SESSION['mandante']=0; 
                                    }
                                    $_SESSION['prueba']=$fecha_fin; 


                                    # proceso para saber si es 1ero del mes
                                    $fecha=date("2024-10-01");
                                    $dia='01';   


                                    # si dia es 01
                                    if ($dia=='01') {  
                                        # consultar si hay contrato con mensuales
                                        $query_mensuales=mysqli_query($con,"select * from contratos where contratista='".$result_contratista['id_contratista']."' and mensuales='1' ");
                                        $contrato_mensuales=mysqli_num_rows($query_mensuales);
                                    

                                        # si tiene contrato con mensuales no iniciado
                                        if ($contrato_mensuales>0) {

                                          $query_o=mysqli_query($con,"select * from mensuales where contratista='".$result_contratista['id_contratista']."' and estado='0'  ");
                                          $result_o=mysqli_fetch_array($query_o);

                                            # resta un mes a la fecha anterior
                                            $fecha_eva = strtotime('-1 months', strtotime($fecha));
                                            $fecha_eva = date('Y-m' , $fecha_eva);

                                            $mes=substr($fecha_eva,5,2);
                                            $year=substr($fecha_eva,0,4);

                                            #$prueba=mysqli_query($con,"insert into prueba (valor) values ('".$fecha."') ");
                                          
                                            # recorrer arreglo de contratos conseguidos
                                            foreach ($query_o as $row) { 

                                              $documentos=unserialize($row['documentos']);
                                              $cant_d=count(unserialize($row['documentos']));

                                              # selecciona lista de trabajadores del contrato que no esten desvinculado, del mes anterior
                                              #$query_t=mysqli_query($con,"select * from trabajadores_acreditados where contrato='".$row['contrato']."' and creado like'%$fecha_eva%' ");
                                              $query_t=mysqli_query($con,"select * from trabajadores_acreditados where contrato='".$row['contrato']."' and estado!='2' ");
                                              $result_t=mysqli_fetch_array($query_t);
                                              $cant_trab=mysqli_num_rows($query_t);

                                              # seleccionar nombre del mandante
                                              $query_m=mysqli_query($con,"select * from mandantes where id_mandante='".$row['mandante']."' and estado='1' ");
                                              $result_m=mysqli_fetch_array($query_m);

                                              # seleccionar nombre del contrato
                                              $query_c=mysqli_query($con,"select nombre_contrato from contratos where id_contrato='".$row['contrato']."' and estado='1' ");
                                              $result_c=mysqli_fetch_array($query_c);

                                              //$prueba=mysqli_query($con,"insert into prueba (valor,valor2) values ('$dia','$contrato_mensuales')");
      
                                              if ($cant_trab>0) {
                                                
                                                      # recorrer lista de trabajadores 
                                                      foreach ($query_t as $row_t) {
                                                          $query_ta=mysqli_query($con,"select * from trabajador where idtrabajador='".$row_t['trabajador']."' ");
                                                          $result_ta=mysqli_fetch_array($query_ta);
                                                          $trabajador=$result_ta['nombre1'].' '.$result_ta['apellido1'];

                                                        
                                                        # recorrer documento para cada trabajador
                                                        for ($d=0;$d<=$cant_d-1;$d++) {
                                                          
                                                          $query_doc_existe=mysqli_query($con,"select count(*) as total from mensuales_trabajador where trabajador='".$row_t['trabajador']."' and doc='".$documentos[$d]."' and contratista='".$result_contratista['id_contratista']."' and mandante='".$row['mandante']."' and contrato='".$row['contrato']."' and mes='$mes' and year='$year' and codigo='".$row_t['codigo']."' ");
                                                          $result_doc_existe=mysqli_fetch_array($query_doc_existe);

                                                          if ($result_doc_existe['total']==0) { 
                                                              
                                                                  $query_d=mysqli_query($con,"select * from doc_mensuales where id_dm='".$documentos[$d]."'  ");
                                                                  $result_d=mysqli_fetch_array($query_d);
                                                                  
                                                                  
                                                                  $item='Gestion Documento Mensual';  
                                                                  $nivel=2; 
                                                                  $tipo=1;
                                                                  $envia=$row['mandante'];
                                                                  $recibe=$result_contratista['id_contratista'];
                                                                  $mensaje="El mandante <b>".$result_m['razon_social']."</b> ha solicitado el documento mensual <b>".$result_d['documento']."</b>, trabajador <b>".$trabajador."</b> del contrato <b>".$result_c['nombre_contrato']."</b>";
                                                                  $accion="Gestionar Documento Mensual";
                                                                  $url="gestion_doc_mensuales_contratista.php";
                                                                  $query_notificaciones=mysqli_query($con,"insert into notificaciones (item,nivel,envia,recibe,mensaje,accion,fecha,usuario,url,control,mandante,contratista,contrato,documento,trabajador) values ('$item','$nivel','$envia','$recibe','$mensaje','$accion','$date','$usuario','$url','".$mes."','".$row['mandante']."','".$result_contratista['id_contratista']."','".$row['contrato']."','".$result_d['documento']."','".$row_t['trabajador']."') ");
                                                  
                                                                  $query_noti =mysqli_query($con,"SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'clubicl_proyecto' AND TABLE_NAME = 'notificaciones' ");
                                                                  $result_noti= mysqli_fetch_array($query_noti); 
                                                                  $idnoti=$result_noti['AUTO_INCREMENT']-1;

                                                                  mysqli_query($con,"insert into mensuales_trabajador (id_m,trabajador,doc,contratista,mandante,contrato,id_noti,creado,mes,year,codigo) values ('".$row['id_m']."','".$row_t['trabajador']."','".$documentos[$d]."','".$result_contratista['id_contratista']."','".$row['mandante']."','".$row['contrato']."','$idnoti','$date','$mes','$year','".$row_t['codigo']."') ");                                                                  
                                                              }

                                                          } # for $d       
                                                      } # for query_t
                                                    # cambiar a iniciado tabla mensuales del contrato contrabajadores acreditados  
                                                    #$update=mysqli_query($con,"update mensuales set estado='1' where contrato='".$row['contrato']."' ");
                                                }
                                                
                                            }
                                        }
                                     }  
                                        echo 3;
                              }   
                        
                        # si contratista esta inactiva        
                        } else {
                            
                          # activa por admin
                            if ($result_contratista['habilitada']==2) {
                                $_SESSION['contratista']=$result_contratista['id_contratista'];
                                $_SESSION['estado']=$result_estado['estado'];
                                
                                if ($dias==0 or $dias<=0) {
                                  $_SESSION['dias']=0;
                                }  else {
                                  $_SESSION['dias']=$total_dias;
                                }
                                
                                if ($result_contratista['multiple']==0) {
                                    $_SESSION['mandante']=$result_contratista['idmandante'];
                                } else {
                                    $_SESSION['multiple']=$result_contratista['multiple'];
                                    $_SESSION['mandante']=0; 
                                }
                                $_SESSION['prueba']=2;
                                echo 3;
                            # sino esta activa por admin mostrar actualizar plan    
                            } else {
                                echo 7;
                            };  
                        }
                    }
                    
                    if ($_SESSION['nivel']==4) { // mandante y contratista
                          $_SESSION['usuario']=$usuario;
                          echo 4;
                    } 
                    
                    
                } else { // cuenta no validada
                    echo 5;
                }   
                  
    
            } else { // rut y/o pass incorrectos
                echo 6 ;
            }
            
       // } else {/
       //    echo 7;
      //  }           


?>