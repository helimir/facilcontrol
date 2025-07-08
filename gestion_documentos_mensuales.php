<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');


if ($_SESSION['nivel']==2) {    
    $contratistas=mysqli_query($con,"SELECT c.* from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where m.rut_empresa='".$_SESSION['usuario']."' ");
    $result_contratista=mysqli_fetch_array($contratistas);
    
    $sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
    $result=mysqli_fetch_array($sql_mandante);
    $mandante=$result['id_mandante'];
    
    $contratos=mysqli_query($con,"SELECT * from contratos where contratista='".$result_contratista['id_contratista']."' ");
    
} 
if ($_SESSION['nivel']==3) {
    //$contratos=mysqli_query($con,"SELECT c.*, o.* from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista where o.rut='".$_SESSION['usuario']."' ");
    $contratos=mysqli_query($con,"SELECT c.*, o.*, c.mandante as nom_mandante from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista where o.rut='".$_SESSION['usuario']."'and c.id_contrato='".$_GET['contrato']."'  ");
    $result_contratista=mysqli_fetch_array($contratos);
}

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


$contrato=$_GET['contrato'];
$contratista=$_GET['contratista'];



?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Documentos Mensuales</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
    
 
      <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">




<script>

    function editar(idtrabajador,editar) {
        $.ajax({
			method: "POST",
            url: "sesion_trabajador.php",
			data:'id='+idtrabajador+'&editar='+editar,
			success: function(data){
			     if (data==1) { 
                    window.location.href='edit_trabajador.php';
                 } else {
                    window.location.href='edit_documentos.php';
                 }                
			}
       });
    }
   
   function selcontratista(id){
    //alert(id); 
    $.post("contratos.php", { id: id }, function(data){
        $("#contrato").html(data);
    }); 
   } 
    
   function selcontrato(contrato,contratista){
    //alert(contrato); 
    $.post("contratos2.php", { contrato: contrato }, function(data){
        window.location.href='gestion_contratos.php?contratista='+contratista+'&contrato='+contrato;
    }); 
   }
       
         
  function recargar (url){
    window.location.href=url;
  }  
   

</script>

</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Gesti&oacute;n de Documentos Mensuales <?php   ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
              <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                    
                    
                        <div class="ibox-title">
                                <?php if ($_SESSION['nivel']==2 ) { ?>     
                                   <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="crear_contrato.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contrato</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_contratos.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                      </div>
                                   </div>
                                 <?php } 
                                    if ($_SESSION['nivel']==3) { ?>
                                     <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_contratos_contratistas.php"  ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="documentos_mensuales.php?contrato=<?php echo $_GET['contrato'] ?>"  ><i  class="fa fa-chevron-right" aria-hidden="true"></i>Documentos Mensuales</a>
                                      </div>
                                   </div>                                 
                                 <?php }  ?>    
                                 <?php include('resumen.php') ?>
                         </div>
                        
                        
                        <div class="ibox-content">     
                        
                                    <?php 
                                       # como mandante
                                       if ($_SESSION['nivel']==2) { ?>
                                    
                                         <div class="row">             
                                               
                                                <div class="col-1">             
                                                    <label class="col-form-label"><b>Contratistas</b></label>
                                                 </div>
                                                <div style="text-align: right;" class="col-6">   
                                                    <select name="contratista" id="contratista" class="form-control m-b"  onchange="selcontratista(this.value)">
                                                        <?php                                                
                                                        
                                                        if ($_GET['contratista']=="") {
                                                            echo '<option value="0" selected="" >Seleccionar Contratista</option>';
                                                        } else {
                                                            $query=mysqli_query($con,"select * from contratistas where id_contratista='".$_GET['contratista']."' ");
                                                            $result=mysqli_fetch_array($query);
                                                            echo '<option value="" selected="" >'.$result['razon_social'].'</option>';
                                                            echo '<option value="0" >Seleccionar Contratista</option>';
                                                        }    
                                                        
                                                        foreach ($contratistas as $row) {
                                                           echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                        }  
                                                             
                                                          ?>                                           
                                                    </select>
                                               </div> 
                                            </div> 
                                             
                                           <div class="form-group row">                                         
                                             <div class="col-1">  
                                                <label class="col-form-label"><b>Contratos</b></label>
                                             </div>
                                             <div style="text-align: right;" class="col-6">   
                                                <select name="contrato" id="contrato" class="form-control" onchange="selcontrato(this.value,<?php echo $_GET['contratista'] ?>)">
                                                <?php
                                                if ($_GET['contrato']=="") {
                                                    echo '<option value="0" selected="" >Seleccionar Contrato</option>';
                                                    $query=mysqli_query($con,"select * from contratos where contratista='".$_GET['contratista']."' ");
                                                    foreach ($query as $row) {
                                                	   echo	'<option value="'.$row['id_contrato'].'">'.$row['nombre_contrato'].'</option>';
                                                	
                                                    }
                                                    
                                                } else {
                                                    $query=mysqli_query($con,"select * from contratos where id_contrato='".$_GET['contrato']."' ");
                                                    $result=mysqli_fetch_array($query);
                                                    echo '<option value="'.$result['id_contrato'].'" selected="" >'.$result['nombre_contrato'].'</option>';
                                                    
                                                    foreach ($query as $row) {
                                                	   echo	'<option value="'.$row['id_contrato'].'">'.$row['nombre_contrato'].'</option>';
                                                	
                                                    }
                                               
                                                }  
                                                                                 
                                                ?>
                                                </select>
                                             </div>
                                            </div>    
                                            
                                          <?php } ?>  
                          
                           <?php if ($_SESSION['nivel']==3) { 
                                         $query=mysqli_query($con,"select c.*, m.*, a.razon_social as nom_mandante from contratos as c Left Join mensuales as m On m.contrato=c.id_contrato Left Join mandantes as a On id_mandante=m.mandante where c.id_contrato='".$_GET['contrato']."' ");
                                         $result=mysqli_fetch_array($query);
                                         
                                         switch ($result['mes']) {
                                            case '1': $mes_control='ENERO';break;
                                            case '2': $mes_control='FEBRERO';break;
                                            case '3': $mes_control='MARZO';break;
                                            case '4': $mes_control='ABRIL';break;
                                            case '5': $mes_control='MAYO';break;
                                            case '6': $mes_control='JUNIO';break;
                                            case '7': $mes_control='JULIO';break;
                                            case '8': $mes_control='AGOSTO';break;
                                            case '9': $mes_control='SEPTIEMBRE';break;
                                            case '10': $mes_control='OCTUBRE';break;
                                            case '11': $mes_control='NOVIEMBRE';break;
                                            case '12': $mes_control='DICIEMBRE';break;

                                        }    
                                         
                            ?>
                                          <div class="row"> 
                                            <h4 class="col-1 ">Contrato: </h4>
                                            <h3 class="col-6 "><b><?php echo $result['nombre_contrato'] ?></b></h3>
                                          </div>
                                          <div class="row"> 
                                            <h4 class="col-1 ">Mandante: </h4>
                                            <h3 class="col-6 "><b><?php echo $result['nom_mandante'] ?></b></h3>
                                          </div> 
                                          
                                           <div class="row"> 
                                            <h4 class="col-1 ">Mes: </h4>
                                            <h3 class="col-6 "><b><?php echo $mes_control ?></b></h3>
                                          </div>
                                          
                                          <div class="row"> 
                                            <h4 class="col-1 ">Dia: </h4>
                                            <h3 class="col-6 "><b><?php echo $result['dia'].' c/mes' ?></b></h3>
                                          </div>  
                                         
                            <?php } ?>                  
                         <hr />
                         <div class="row"> 
                           <div class="col-12"> 
                                          
                            <div class="table-responsive">
                                <!--<input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                                <table class="footable table table-stripped" data-page-size="20" data-filter="#filter">
                                   <thead>
                                    <tr>
                                        <th class="col-2" style="width: ;">Nombres</th>
                                        <th class="col-2" style="width: ;">Apellidos</th>
                                        <th class="col-2" style="width: ;">RUT</th>
                                        <th class="col-2" style="width: ;">Cargo</th>
                                        <th class="col-1" style="width: ;" >Validados</th>
                                        <th class="col-1" style="width: ;" >Documentos</th>
                                        
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    
                                    $query=mysqli_query($con,"select d.* from desvinculaciones as d LEFT JOIN trabajador as t On t.idtrabajador=d.trabajador where d.control!='2' ");
                                      
                                    $query_perfil_cargo=mysqli_query($con,"select * from perfiles_cargos where contrato='$contrato' ");
                                    $result_perfil_cargo=mysqli_fetch_array($query_perfil_cargo);
                                     
                                    $list_cargos=unserialize($result_perfil_cargo['cargos']);
                                    $perfiles=unserialize($result_perfil_cargo['perfiles']);
                                    
                                    foreach ($query as $fila) {                                          
                                        $trabajadores=unserialize($fila['trabajadores']);
                                        $cargos=unserialize($fila['cargos']);
                                        
                                        $i=0;
                                        foreach ($trabajadores as $row) { 
                                                                                    
                                           // para determinar numero de documentos por perfil 
                                           //$query_doc=mysqli_query($con,"select * from perfiles where id_perfil='".$perfiles[$i]."' ");
                                           //$result_doc=mysqli_fetch_array($query_doc); 
                                            
                                           //$documentos=unserialize($result_doc['doc']);
                                           //$num_doc_perfil=count($documentos);  
                                           
                                           // 
                                           $query_t=mysqli_query($con,"select * from trabajador where idtrabajador='$row' ");
                                           $result_t=mysqli_fetch_array($query_t);
                                           
                                           
                                           $query3=mysqli_query($con,"select * from cargos where idcargo='$cargos[$i]' ");
                                           $row3=mysqli_fetch_array($query3);
                                           $idcargo=$row3['idcargo'];
                                           
                                           $pos=0;
                                           foreach ($list_cargos as $row4) {
                                               if ($row4==$cargos[$i]) {
                                                   $perfil=$perfiles[$pos];
                                                   break;
                                               }
                                             $pos++;   
                                           }
                                           
                                           $query_mt=mysqli_query($con,"select * from mensuales_trabajador where trabajador='$row' and mensuales='".$_GET['mensual']."' ");
                                           $result_mt=mysqli_fetch_array($query_mt);
                                           
                                           $documentos=unserialize($result_mt['doc_contratista_mensuales']);                                           
                                           $num_doc_perfil=count(unserialize($result_mt['doc_contratista_mensuales']));
                                           
                                           $contador_doc=0;
                                           $j=0;
                                           foreach ($documentos as $row) {
                                                $query_d=mysqli_query($con,"select documento from doc_mensuales where id_dm='$row' ");
                                                $result_d=mysqli_fetch_array($query_d);
                                                $arreglo=array(".png",".jpg",".jpeg",".pdf");
                                                for ($j=0;$j<=3;$j++) {
                                                    $carpeta='doc/mensuales/'.$result_mt['contratista'].'/'.$result_mt['contrato'].'/trabajadores/'.$result_mt['mes'].'-'.$result_mt['year'].'/'.$result_t['rut'].'/'.$result_d['documento'].'_'.$result_t['rut'].$arreglo[$j];;
                                                    $archivo_existe=file_exists($carpeta);
                                                    if ($archivo_existe){
                                                        $contador_doc=$contador_doc+1;
                                                    } 
                                                }    
                                           }  
                                                                                    
                                             
                                           $very=unserialize($result_verificados['verificados']);
                                           $validados=0;
                                           for ($j=0;$j<=$num_doc_perfil-1;$j++){
                                                 $validados=$validados+$very[$j]; 
                                           }; 
                                           
                                           #$_GET
                                           #$query_verificados2=mysqli_query($con,"select * from observaciones where  trabajador='".$result_t['idtrabajador']."' and cargo=$cargos[$i] and contrato=$contrato and perfil='$perfil' ");
                                           #$result_verificados2=mysqli_fetch_array($query_verificados2);
                                                                                      
                                           #$query_com=mysqli_query($con,"select sum(leer_contratista) as total from comentarios where id_obs='".$result_verificados2['id_obs']."' ");
                                           #$result_com=mysqli_fetch_array($query_com);
                                           
                                           #$query_com2=mysqli_query($con,"select * from comentarios where id_obs='".$result_verificados2['id_obs']."' ");
                                           #$num_com=mysqli_num_rows($query_com2);
                                           #$result_com2=mysqli_fetch_array($query_com2);
                                           
                                           #if ($result_doc['nombre_perfil']=="") {
                                           # $sin_perfil=true;
                                           #} else {
                                           # $sin_perfil=false; 
                                           #}
                                                
                                        ?> 
                                        <tr> 
                                            <!-- nombre -->
                                            <td><?php echo $result_t['nombre1']." ".$result_t['nombre2']  ?></td>
                                            
                                            <!-- apellido -->
                                            <td><?php echo $result_t['apellido1']." ".$result_t['apellido2']  ?></td>
                                            
                                            <!-- rut -->
                                            <td><?php echo $result_t['rut'] ?></td>
                                            
                                            <!-- cargo -->
                                            <td><?php echo $row3['cargo'] ?></td>
                                            
                                            <!-- validados  -->
                                            <td> 
                                            <?php if ($sin_perfil==false) { ?>
                                                   <?php 
                                                      # si es contratista
                                                      if ($_SESSION['nivel']==3) { ?>
                                                      <?php if ($validados==0) {  ?>                                             
                                                                <button title="" class="btn btn-outline btn-xs btn-danger btn-block" name="" id="" onclick="doc_tra_mensual(<?php echo $result_t['idtrabajador'] ?>,<?php echo $_GET['contrato'] ?>,<?php echo $_GET['mensual'] ?>,<?php echo $_SESSION['mandante'] ?>)" ><span style="font-size: 14px;"><?php echo $validados ?> de <?php echo $num_doc_perfil ?></span></button>
                                                      <?php } 
                                                           if ($validados!=0 and $validados<$num_doc_perfil) {  ?>
                                                                <button title="" class="btn btn-outline btn-xs btn-warning btn-block" name="" id="" onclick="doc_tra_mensual(<?php echo $result_t['idtrabajador'] ?>,<?php echo $_GET['contrato'] ?>,<?php echo $_GET['mensual'] ?>,<?php echo $_SESSION['mandante'] ?>)" ><span style="font-size: 14px;"><?php echo $validados ?> de <?php echo $num_doc_perfil ?></span></button>
                                                      <?php }  
                                                           if ($validados==$num_doc_perfil) {  ?> 
                                                                <button title="Procesado" class="btn btn-outline btn-xs btn-primary btn-block" name="" id="" onclick="doc_tra_mensual(<?php echo $result_t['idtrabajador'] ?>,<?php echo  $_GET['contrato'] ?>,<?php echo  $_GET['mensual'] ?>,<?php echo $_SESSION['mandante'] ?>)" ><span style="font-size: 14px;"><?php echo $validados ?> de <?php echo $num_doc_perfil ?></span></button>
                                                      <?php } 
                                                   }     
                                                   
                                                   # si es mandante
                                                   if ($_SESSION['nivel']==2) { ?>  
                                                        <?php if ($validados==0) {  ?>                                             
                                                                <button title="" class="btn btn-outline btn-xs btn-danger btn-block" name="" id="" onclick="modal_ver(<?php echo $result_t['idtrabajador'] ?>,<?php echo $idcargo ?>,<?php echo $fila['id_contrato'] ?>,<?php echo $perfil ?>,<?php echo $mandante ?>,<?php echo $result_contratista['id_contratista'] ?>)" ><span style="font-size: 14px;"><?php echo $validados ?> de <?php echo $num_doc_perfil ?></span></button>
                                                      <?php } 
                                                           if ($validados!=0 and $validados<$num_doc_perfil) {  ?>
                                                                <button title="" class="btn btn-outline btn-xs btn-warning btn-block" name="" id="" onclick="modal_ver(<?php echo $result_t['idtrabajador'] ?>,<?php echo $idcargo ?>,<?php echo $fila['id_contrato'] ?>,<?php echo $perfil ?>,<?php echo $mandante ?>,<?php echo $result_contratista['id_contratista'] ?>)" ><span style="font-size: 14px;"><?php echo $validados ?> de <?php echo $num_doc_perfil ?></span></button>
                                                      <?php }  
                                                           if ($validados==$num_doc_perfil) {  ?> 
                                                                <button title="Procesado" class="btn btn-outline btn-xs btn-primary btn-block" name="" id="" onclick="modal_ver(<?php echo $result_t['idtrabajador'] ?>,<?php echo $idcargo ?>,<?php echo $fila['id_contrato'] ?>,<?php echo $perfil ?>,<?php echo $mandante ?>,<?php echo $result_contratista['id_contratista'] ?>)" ><span style="font-size: 14px;"><?php echo $validados ?> de <?php echo $num_doc_perfil ?></span></button>
                                                      <?php }  ?>
                                                   <?php }   
                                                   
                                               } else {    ?>
                                                    <div style="background:#eee;color:#000;padding: 4% 0%;text-align: center;"><span style="font-size: 14px;">0 de 0</span></div>
                                               
                                               <?php } ?>
                                            </td>
                                            
                                            <!-- num documentos del perfil  -->
                                           <?php if ($sin_perfil==false) { ?> 
                                                 <?php if ($contador_doc==0) { ?>
                                                         <td style="text-align: center;"><div style="background:#BB0000;color:#fff;padding: 4% 0%;"> <span style="font-size: 14px;"><?php echo $contador_doc ?> de <?php echo $num_doc_perfil ?></span></div> </td>
                                                 <?php } else {    
                                                        if ($contador_doc<$num_doc_perfil) { ?>
                                                         <td style="text-align: center;"><div style="background:#F8AC59;color:#fff;padding: 4% 0%;"><span style="font-size: 14px;"><?php echo $contador_doc ?> de <?php echo $num_doc_perfil ?></span></div> </td>
                                                      <?php } else { ?>
                                                         <td style="text-align: center;"><div style="background:#1C84C6;color:#fff;padding: 4% 0%;"><span style="font-size: 14px;"><?php echo $contador_doc ?> de <?php echo $num_doc_perfil ?></span></div> </td>
                                                      <?php }  ?>  
                                                 <?php }   
                                                   
                                               } else {    ?>
                                                    <td style="text-align: center;"><div style="background:#eee;color:#000;padding: 4% 0%;"><span style="font-size: 14px;">0 de 0</span></div> </td>
                                               
                                               <?php } ?>
                                            
                                        </tr>
                                       <?php $i++; } 
                                     }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <ul class="pagination float-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            
                            
                            
                            
                            <script>
                                 function modal_ver(id,cargo,contrato,perfil,mandante,contratista) {
                                    $.ajax({
                            			method: "POST",
                                        url: "cambiar_verificar_documentos_mandante.php",
                            			data:'id='+id+'&cargo='+cargo+'&contrato='+contrato+'&mandante='+mandante+'&perfil='+perfil,
                            			success: function(data){
                                           window.location.href='verificar_documentos_mandante.php?mandante='+mandante+'&contratista='+contratista;
                            			}
                                   });
                                 }
                                 
                                 function doc_tra_mensual(id,contrato,mensual,mandante) {   
                                      //alert(mandante);
                                      window.location.href='verificar_documentos_contratista_mensual.php?id='+id+'&contrato='+contrato+'&mensual='+mensual+'&mandante='+mandante;
                                  }
                                 
                            </script>
                            
                            </div>                    
                           </div> 
                         </div> 
                          
                        </div>
                      </div>
                   </div>
               </div>
               
               
           
           
                         <div class="modal  fade" id="modal_ver_archvivos_mandante" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle" aria-hidden="true"></i> Verificar Documentos del Trabajador</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                        <div class="body">
                                        </div> 
                                        <div class="modal-footer">
                                           <button style="color: #fff;" class="btn btn-danger" value="gestion_contratos.php" onclick="recargar(this.value)" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal  fade" id="modal_ver_archvivos_contratistas" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-plus-circle" aria-hidden="true"></i> Revisar Documentos del Trabajador</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                        <div class="modal-body">
    
                                        </div>
                                        <div class="modal-footer">
                                           <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</a>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="modal  fade" id="modal_contratistas" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Seleccionar Contratistas/Contrato</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                        <div class="modal-body">
                                          <div class="row">                                           
                                            <div class="col-12">            
                                            <select name="contratista" id="contratista" class="form-control">
                                                <?php                                                
                                                echo '<option value="0" selected="" >Seleccionar Contratista</option>';
                                                
                                                foreach ($contratistas as $row) {
                                                   echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                  
                                                     
                                                }  ?>                                           
                                            </select>
                                           </div> 
                                          </div>  
                                          <br /><br />
                                          <div class="row">
                                             
                                              <div class="col-12">  
                                                <select name="contrato" id="contrato" class="form-control" onchange="">
                                                     <option value="0" selected="" >Seleccionar Contrato</option>                                
                                                </select>
                                               </div> 
                                          </div>  
                                          
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-window-close" aria-hidden="true"></i> Cerrar</button>
                                            <button type="button" class="btn btn-success"><i class="fa fa-paper-plane" aria-hidden="true"></i> Gesti&oacute;n de Contratos</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
            
             
            <div class="footer">
                <div class="float-right">
                    Versi&oacute;n <strong>1.0</strong>
                </div>
                <div>
                    <strong>Copyright</strong> FacilControl &copy; <?php echo $year ?>
                </div>
            </div>

        </div>
</div>


    <!-- Mainly scripts -->
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>

    <!-- Jasny -->
    <script src="js\plugins\jasny\jasny-bootstrap.min.js"></script>

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
    
    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>

<script>

$(document).ready(function() {

            
            $('.footable').footable();
            $('.footable2').footable();
                        
            
    });

</script>

</body>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
