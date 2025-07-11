<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
include('sesion_manager.php');
session_start();

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2) { 
include('config/config.php');


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


#$result_contratista=mysqli_fetch_array($query_contratista); 
#$doc=unserialize($result_contratista['doc_contratista']);
#$doc_mensuales=unserialize($result_contratista['doc_contratista_mensuales']);
#$rut_contratista=$result_contratista['rut'];

$query_obs=mysqli_query($con,"select * from doc_desvinculaciones where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs=mysqli_fetch_array($query_obs);
$list_veri=unserialize($result_obs['verificados']);


?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Desvinculaciones</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

        <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet" />
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet" />
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">


<script>

   
    function enviar(total,sp) {
       // alert(sp);
        var total_doc=$('#total_doc').val(); 
        var j=0;
        var contador=0;
        var mensaje=0;
        var sin_mensaje=0;
        var lectura=0;
        for (j=0;j<=total_doc-1;j++) {
            var isChecked = $('#verificar'+j).prop('checked');
            if  (isChecked) {
                contador=contador+1;
            }   
            var valor_mensaje=$('#mensaje'+j).val();
            if (valor_mensaje!=''){
                mensaje=mensaje+1;
            } else {
                sin_mensaje=sin_mensaje+1;
            }

            var solo_lectura=document.getElementById('mensaje'+j).readOnly;
            if (solo_lectura==true) {
                lectura=1;
            }
        }
        //alert(lectura+' '+contador+' '+sin_mensaje);
        if (contador==0 && mensaje==0) {
            swal({ 
                title:"Seleccionar al menos un Documentos o Enviar una Observacion.",
                //text: "Debe selecionar al menos un documento",
                type: "warning"
            }); 
        } else {   
               
                var arreglo=[];
                var arreglo2=[];
                var arreglo3=[];
                var arreglo4=[];
                var arreglo5=[];
                var arreglo6=[];
                var arreglo7=[];
                var falta_revisar=false;
                
                for (i=0;i<=total-1;i++) {
                    //si verificado esta seleccionado
                    var isChecked = $('#verificar'+i).prop('checked');
                    if (isChecked) {
                        var valor=document.getElementById("verificar"+i).value = "1";
                        var valor2=$('#mensaje'+i).val();
                        arreglo.push(valor);
                        arreglo2.push(valor2);
                        
                        var isDisabled = $('#verificar'+i).prop('disabled');
                        if (!isDisabled) {
                            var valor3=$('#trabajador'+i).val();
                            arreglo3.push(valor3);
                        }    
                        
                        var valor4=$('#contratista'+i).val();
                        arreglo4.push(valor4);
                        
                        var valor5=$('#tipo'+i).val();
                        arreglo5.push(valor5);
                        
                        var valor6=$('#contrato'+i).val();
                        arreglo6.push(valor6);   
                     
                    } else {
                        var valor=document.getElementById("verificar"+i).value = "0";
                        var valor2=$('#mensaje'+i).val();
                        var isDisabled = $('#verificar'+i).prop('disabled');
                        
                        if (valor==0) {
                            var falta_revisar=true;
                        }
                        if (!isDisabled) {
                            var valor3=$('#trabajador'+i).val();
                            arreglo3.push(valor3);
                        }    
                        
                        var valor4=$('#contratista'+i).val();
                        arreglo4.push(valor4); 
                        
                        var valor5=$('#tipo'+i).val();
                        arreglo5.push(valor5);
                        
                        var valor6=$('#contrato'+i).val();
                        arreglo6.push(valor6); 
                        
                        arreglo.push(valor);
                        arreglo2.push(valor2);
                    }
                    var valor7=$('#id_d'+i).val();
                        arreglo7.push(valor7);
                        ;
                    
                }
                    //alert(total);
                    
                    // verificados
                    var json=JSON.stringify(arreglo);
                    
                    // mensajes
                    var json2=JSON.stringify(arreglo2);
                    
                    // trabajadores
                    var json3=JSON.stringify(arreglo3);
                    
                    // contratistas
                    var json4=JSON.stringify(arreglo4);
                    
                    // tipo de dinsvinculacion
                    var json5=JSON.stringify(arreglo5);
                    
                    // contratos
                    var json6=JSON.stringify(arreglo6);

                     // id desvinculacion
                     var json7=JSON.stringify(arreglo7);
                    
                    //alert(json5); 

                    $.ajax({
          			    method: "POST",
                        url: "cargar/procesar_desvinculaciones_mandante.php",
             		    data: {data:json,data2:json2,data3:json3,data4:json4,data5:json5,data6:json6,data7:json7},
                        cache: false,
                        beforeSend: function(){
                            const progressBar = document.getElementById('myBar');
                            const progresBarText = progressBar.querySelector('.progress-bar-text');
                            let percent = 0;
                            progressBar.style.width = percent + '%';
                            progresBarText.textContent = percent + '%';
                                            
                            let progress = setInterval(function() {
                                if (percent >= 100) {
                                    clearInterval(progress);                                                                                                       
                                } else {
                                    percent = percent + 1; 
                                    progressBar.style.width = percent + '%';
                                    progresBarText.textContent = percent + '%';
                                }
                            }, 100);
                            $('#modal_cargar').modal('show');						
                    	},
              			success: function(data){
                            $('#modal_cargar').modal('hide');
            	            if (data==0) {
            	                //alert(data);
                                if (falta_revisar==true) {
                                    swal({
                                            title: "Procesado",
                                            text: "Desvinculaciones sin Acreditar",
                                            type: "warning"
                                     });
                                      setTimeout(function(){
                                        window.location.href='desvinculaciones_mandante.php' 
                                     },2000); 
                                } else {
                                    swal({
                                            title: "Procesado",
                                            text: "Documentos validados",
                                            type: "success"
                                     });
                                      setTimeout(function(){
                                        window.location.href='desvinculaciones_mandante.php' 
                                     },2000); 
                                }                        
                            } else {
                                //alert(data);
                	            if (falta_revisar==true) {
                                    swal({
                                            title: "Actualizado",
                                            text: "Documentos sin validar",
                                            type: "warning"
                                     });
                                     setTimeout(function(){
                                        window.location.href='desvinculaciones_mandante.php' 
                                     },2000); 
                                } else {
                                   //alert('aqui');  
                                   swal({
                                            title: "Actualizado",
                                            text: "Documentos validados",
                                            type: "success"
                                     });
                                     setTimeout(function(){
                                        window.location.href='desvinculaciones_mandante.php' 
                                     },2000); 
                               }      
                            }                
              			},
                        omplete:function(data){
                            $('#modal_cargar').modal('hide');
                        }, 
                        error: function(data){
                        }
                    });
         } 
      }

</script>

   <style>
        .estilo {
            display: inline-block;
        	content: "";
        	width: 15px;
        	height: 15px;
        	margin: 0.5em 0.5em 0 0;
            background-size: cover;
        }
        .estilo:checked  {
        	content: "";
        	width: 15px;
        	height: 15px;
        	margin: 0.5em 0.5em 0 0;
        }
        
        input[type=checkbox]
        {
          /* Doble-tama�o Checkboxes */
          -ms-transform: scale(2); /* IE */
          -moz-transform: scale(2); /* FF */
          -webkit-transform: scale(2); /* Safari y Chrome */
          -o-transform: scale(2); /* Opera */
          padding: 10px;
        }
        
        /* Tal vez desee envolver un espacio alrededor de su texto de casilla de verificaci�n */
        .checkboxtexto
        {
          /* Checkbox texto */
          font-size: 80%;
          display: inline;
        }

        .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }

    
    </style>

</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Desvinculaciones de Trabajadores <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
               
            <form  method="post" id="frmDesvinculacionMandante" name="frmDesvinculacionMandante" action="procesar_desvinculaciones_mandante.php"  enctype="multipart/form-data">   
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                             <div class="ibox-title">
                                 <div class="form-group row">
                                   <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                           <a class="btn btn-md btn-success btn-submenu"  href="list_contratos.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                           <a class="btn btn-md btn-success btn-submenu" href="list_contratistas_mandantes.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratistas</a>
                                           <!--<button class="ladda-button ladda-button-demo btn btn-primary" data-style="zoom-in">Submit</button>-->
                                     </div>
                                  </div>
                                  <?php include('resumen.php') ?>
                                  
                             </div> 
                        
                        
                        <div class="ibox-content">
                       
                     
                         <div class="row">                            
                                <!--<input type="hidden" class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                            <div class="table-responsive">    
                                <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                
                                   <thead>
                                    <tr class="cabecera_tabla">
                                        <th style="width: 5%;border-right:1px #fff solid" >Documento</th>
                                        <th style="width: 15%;border-right:1px #fff solid">Trabajador</th>    
                                        <th style="width: 10%;border-right:1px #fff solid">Rut</th>                                     
                                        <th style="width: 20%;border-right:1px #fff solid">Contratista</th>                             
                                        <th style="width: 5%;text-align: center;border-right:1px #fff solid">Desvincular</th>
                                        <th style="width: 20%;border-right:1px #fff solid">Observaciones</th>
                                        <th style="width: 15%;text-align: center">Estado</th>
                                        
                                    </tr>
                                    </thead>
                                    
                                   <tbody>
                                       
                                  <?php 
                                  
                                        $query_desvinculaciones=mysqli_query($con,"select d.*, t.nombre1, t.apellido1, t.rut from desvinculaciones as d LEFT JOIN trabajador as t On t.idtrabajador=d.trabajador LEFT JOIN contratistas as c On c.id_contratista=d.contratista where d.estado='1' and d.mandante='".$_SESSION['mandante']."' and d.estado!=2 and d.control!='1' group by t.idtrabajador ");
                                        $existe_d=mysqli_num_rows($query_desvinculaciones);
                                  
                                        if ($existe_d==0) { ?> 
                                            <tr>
                                                <td colspan="6"><span style="font-weight: bold;">No hay documentos de desvinculaciones</span></td>
                                            </tr>
                                    
                                   <?php } else {        
                                             $i=0; 
                                             $cont_veri=0;
                                             $cont_doc=0;
                                             $comentario=array();
                                             $cadena=array();
                                             
                                             $existe_sin_precesar=0;
                                             foreach ($query_desvinculaciones as $row) {
                                                
                                                if ($row['tipo']==1) {
                                                    $tipo='Contratista';
                                                   } else {
                                                    $tipo='Contrato';
                                                   }
                                                
                                                $cont_doc=$cont_doc+1;
                                                
                                                $sql=mysqli_query($con,"select * from contratistas where id_contratista='".$row['contratista']."' ");  
                                                $result=mysqli_fetch_array($sql);  
                                                
                                                $sql_c=mysqli_query($con,"select * from contratos where id_contrato='".$row['contrato']."' ");  
                                                $result_c=mysqli_fetch_array($sql_c);
                                                
                                                $sql_o=mysqli_query($con,"select * from doc_comentarios_desvinculaciones where id_des='".$row['id_d']."' and estado='0' ");  
                                                $result_o=mysqli_fetch_array($sql_o);
                                                $sin_procesar=mysqli_num_rows($sql_o);

                                                $query_codigo=mysqli_query($con,"select codigo from trabajadores_acreditados where trabajador='".$row['trabajador']."' and mandante='".$_SESSION['mandante']."' ");
                                                $result_codigo=mysqli_fetch_array($query_codigo);

                                                if ($sin_procesar>0) {
                                                    $existe_sin_precesar=1;
                                                }
                                                
                                                
                                                # desvinculacion de contratista
                                                if ($row['tipo']==1) {   
                                                        $carpeta='doc/validados/'.$_SESSION['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_codigo['codigo'].'/documento_desvinculante_contratista_'.$row['rut'].'.pdf';
                                                     # desvilculacion de un contrato                                                        
                                                } else {
                                                        $carpeta='doc/validados/'.$_SESSION['mandante'].'/'.$row['contratista'].'/contrato_'.$row['contrato'].'/'.$row['rut'].'/'.$result_codigo['codigo'].'/documento_desvinculante_contrato_'.$row['contrato'].'_'.$row['rut'].'.pdf';
                                                }
                                                
                                                ?>
                                                
                                                 <tr> 
                                                     <!-- documento  -->
                                                     <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><i style="font-size:16px" class="fa fa-file f" aria-hidden="true"></i> Mostrar</a></td>
                                                
                                                    <!-- trabajador -->                   
                                                    <td style="text-align:left"><?php echo $row['nombre1'].' '.$row['apellido1']  ?></td>

                                                    <td style="text-align:left"><?php echo $row['rut']  ?></td>
                                                
                                                    <!-- tipo -->                   
                                                    <td style="text-align:left"><?php echo $result['razon_social']  ?></td>
                                                
                                                                                                       
                                                 <?php
                                                      # si no esta verificado  
                                                      if ($row['verificado']== 0) { ?>
                                                       
                                                       <!-- verificado -->     
                                                       <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar<?php echo $i ?>" onclick="check(<?php echo $i ?>)"  /></td>
                                                       
                                                       <!--  observaciones  -->     
                                                       <td>
                                                           <div class="btn-group"> 
                                                             <?php if ($row['control']==1) { ?>   
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" readonly="" class="form-control" ><?php echo $result_o['comentarios'] ?></textarea>
                                                            <?php } else { ?>    
                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ><?php echo $result_o['comentarios'] ?></textarea>
                                                            <?php }  ?>    

                                                           </div>
                                                        </td>
                                                        
                                                        <!-- estado  --->     
                                                              
                                                        <?php 
                                                                # sino esta validad
                                                                if ($row['control']!=2) {
                                                                    
                                                                      # documento enviado
                                                                      if ($row['control']==0) { ?>
                                                                            <td style="text-align:center;font-size:14px;;font-weight:bold"><div class="bg-warning p-xxs">EN PROCESO</div></td>
                                                                <?php  } 
                                                                
                                                                      if ($row['control']==1) {  ?>                                                                     
                                                                            <td style="text-align:center;font-size:14px;font-weight:bold"><div class="bg-warning p-xxs">EN PROCESO</div></td>
                                                                <?php }
                                                                      
                                                                      if ($row['control']==3) {  ?>
                                                                            <td style="text-align:center;font-size:14px;font-weight:bold"><div class="bg-warning p-xxs">EN PROCESO</div></td>
                                                                <?php }
                                                                
                                                                   } else { ?>
                                                                        <td style="text-align:center;font-size:14px;font-weight:bold"><div class="bg-primary p-xxs">VALIDADO</div></td>
                                                               <?php }      
                                                                                                                    
                                                      # si esta verificado
                                                      } else {
                                                                $cont_veri=$cont_veri+1; ?>
                                                                
                                                                <!-- verificado --> 
                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar<?php echo $i ?>" value="0" checked="" disabled=""  /></td>
                                                                
                                                                <!--  observaciones  -->
                                                                <td>
                                                                   <div class="btn-group"> 
                                                                      <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                      <!--<button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs('<?php echo $row ?>','<?php echo $result_obs['id_dobs']?>',0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>-->
                                                                   </div>
                                                               </td>
                                                              
                                                               
                                                               <!-- estado  --->  
                                                               <td style="text-align:center"><div class="bg-success p-xxs">VALIDADO</div></td>
                                                                    
                                                   <?php } ?>
                                          
                                        
                                                <input type="hidden" name="trabajador[]"  id="trabajador<?php echo $i ?>"  value="<?php echo $row['trabajador'] ?>" />
                                                <input type="hidden" name="contratista[]" id="contratista<?php echo $i ?>" value="<?php echo $row['contratista'] ?>" />
                                                <input type="hidden" name="tipo[]" id="tipo<?php echo $i ?>" value="<?php echo $row['tipo'] ?>" />
                                                <input type="hidden" name="contrato[]" id="contrato<?php echo $i ?>" value="<?php echo $row['contrato'] ?>" />
                                                <input type="hidden" name="id_d[]" id="id_d<?php echo $i ?>" value="<?php echo $row['id_d'] ?>" />
                                          <?php $i++;} ?>
                                          
                                                
                                                <input type="hidden" name="total_doc" id="total_doc" value="<?php echo $i ?>" /> 
                                                <tr>
                                                    <td colspan="4"><label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" ><span style="color: #F8AC59;font-weight: bold;">NOTA IMPORTANTE: </span> Documento cargado sustituye al anterior. </label></td>    
                                                    <td colspan="3">
                                                        <button style="font-size:16px" title="Procesar Desvinculaciones" class="btn-success btn btn-md btn-block" type="button" onclick="enviar(<?php echo $i ?>,<?php echo $existe_sin_precesar ?>)"  >PROCESAR DESVINCULACIONES <?php  ?></button>
                                                    </td>
                                                </tr>
                                         <?php } ?> 
                                                                                        
                                      </tbody>
                               </table>
                             </div>  
                          </div> 
                          
                           <script>
                            function check(item) {
                                  //alert('p');
                                  var isChecked = document.getElementById('verificar'+item).checked;
                                  if (isChecked) {
                                      var valor=document.getElementById('verificar'+item).value = "1";
                                      //alert(valor);
                                  } else {
                                      var valor=document.getElementById('verificar'+item).value = "0";
                                      //alert(valor);
                                  }  
                                  //var valor=$('#verificar'+item).val();
                                  //alert(valor;)
                               } 
                          
                          </script>
                          
                          
                          
                          
                           
                                                
                        </div>
                      </div>
                   </div> 
                 </div>
               </form>
               
                        <script>
                               
                               
                               
                               function modal_ver_obs(id_doc,id_obs,condicion) {
                                     // alert(id_doc+' '+id_obs);
                                      //var condicion=0;
                                      $('.body').load('selid_ver_obs_doc.php?doc='+id_doc+'&id_dobs='+id_obs+'&condicion='+condicion,function(){
                                                $('#modal_ver_obs').modal({show:true});
                                    });
                                } 
                         
                                   
                        
                        </script>


                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Procesando, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body text-center">
                                                <h3>Espere hasta que cierre esta ventana</h3> 
                                                <div class="progress"> 
                                                    <div id="myBar" class="progress-bar" style="width:0%;">
                                                        <span class="progress-bar-text">0%</span>
                                                    </div>
                                                </div>     
                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                      
                            
                         <div class="modal fade" id="modal_ver_obs" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Historial de Observaciones</h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                            <div class="body">
                                             
                                                  
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

    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

<script>


 
 $(document).ready(function (){
       
      

       // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 2000 });

        // Bind progress buttons and simulate loading progress
        Ladda.bind( '.progress-demo .ladda-button',{
            callback: function( instance ){
                var progress = 0;
                var interval = setInterval( function(){
                    progress = Math.min( progress + Math.random() * 0.1, 1 );
                    instance.setProgress( progress );

                    if( progress === 1 ){
                        instance.stop();
                        clearInterval( interval );
                    }
                }, 200 );
            }
        });


        var l = $( '.ladda-button-demo' ).ladda();

        l.click(function(){
            // Start loading
            l.ladda( 'start' );

            // Timeout example
            // Do something in backend and then stop ladda
            setTimeout(function(){
                l.ladda('stop');
            },12000)
        });


    });
 
 
 function regresar(url){
         window.location.href=url;
       }   

</script>

</body>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
