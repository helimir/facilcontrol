<?php

/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');

date_default_timezone_set('America/Santiago');
setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m')+1;
$year=date('Y');

$date = date('Y-m-d H:m:s', time());
$fecha_actual = date("Y-m-d");

session_destroy($_SESSION['active']);
$_SESSION['active']="gestion_contratos";
if ($_SESSION['nivel']==2) {    
    
    $contratos=mysqli_query($con,"SELECT * from contratos where contratista='".$result_contratista['id_contratista']."' ");
    
    $contratistas=mysqli_query($con,"SELECT c.* from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante where m.rut_empresa='".$_SESSION['usuario']."' ");
    $result_contratista=mysqli_fetch_array($contratistas);
    
    $sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
    $result=mysqli_fetch_array($sql_mandante);
    $mandante=$result['id_mandante'];
} 

if ($_SESSION['nivel']==3) {
    $contratos=mysqli_query($con,"SELECT c.*, o.* from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista where o.rut='".$_SESSION['usuario']."' ");   
    $query_mensual=mysqli_query($con,"SELECT m.*, a.razon_social as nombre_mandante, d.documento from contratistas as c Left Join  mensuales as m On m.contratista=c.id_contratista left join mandantes  as a On a.id_mandante=m.mandante left join doc_mensuales as d On id_dm=m.doc_mensual where c.rut='".$_SESSION['usuario']."' and m.contrato='".$_GET['contrato']."' ");
} 

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
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">

    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">
    
    
    
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>



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
    
   function selcontrato(contrato){
    $.post("contratos2.php", { contrato: contrato }, function(data){
        window.location.href='documentos_mensuales.php?contrato='+contrato;
    }); 
   }
       
         
  function recargar (url){
    window.location.href=url;
  }  
   
  function cargar_simultaneo(mes,mensual,contrato,total){ 
               var arreglo=[];
               //var documento=$('#doc_simultaneo').val();
               var documento=document.getElementById('doc_simultaneo').value;
               var fileInput = document.getElementById('carga_doc_simultaneo');
               var filePath = fileInput.files.length;
               var num=0;
               if (filePath>0) {
                   for (i=0;i<=total-1;i++) {
                        var isChecked = $('#trabajadores'+i).prop('checked');
                        if (isChecked) {
                            var valor=document.getElementById("trabajadores"+i).value;
                            arreglo.push(valor);
                            num=num+1;
                        } 
                   }
                   
                   var filePath = fileInput.value;
                   var allowedExtensions =/(.jpg|.jpeg|.png|.pdf)$/i;
                   if(!allowedExtensions.exec(filePath)){
                        swal({
                            title: "Tipo No Permitido",
                            text: "Solo documentos PDF",
                            type: "warning"
                        });
                        return false;
                   } else {   
                       
                        var formData = new FormData();
                        var files= $('#carga_doc_simultaneo')[0].files[0];
                                           
                        formData.append('archivo',files);                   
                        formData.append('mes', mes );
                        formData.append('mensual', mensual);
                        formData.append('contrato', contrato );
                        formData.append('documento', documento );
                        formData.append('total',num );
                        formData.append('arreglo',JSON.stringify(arreglo));
                        //alert(arreglo+' '+num);
                        $.ajax({
                                url: 'cargar_ficheros_simultaneos.php',
                                type: 'post',
                                data:formData,
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    if (response==0) {                                        
                                        swal({
                                                title: "Documento Enviado",
                                                //text: "Un Documento no validado esta sin comentario",
                                                type: "success"
                                            });
                                        setTimeout(
                                        function() {
                        	               window.location.href='documentos_mensuales.php?contrato='+contrato;
                                        },3000);
                                    } else {
                                        if (response==2) {
                                             swal({
                                                title: "Sin Documento",
                                                text: "Debe seleccionar un archivo",
                                                type: "warning"
                                            });
                                        } else {
                                            swal({
                                                title: "Documeto No Cargado",
                                                text: "Vuelva a intetar",
                                                type: "error"
                                            });
                                        }    
                                    }     
                                }
                        });
                    } 
               } else {
                    swal({
                        title: "Sin Documento",
                        text: "Debe seleccionar un documento PDF/JPG/JPEG/PNG",
                        type: "warning"
                    });
               }     
                    
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
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="crear_contrato.php" ><i  class="fa fa-chevron-right" aria-hidden="true"></i> Crear Contrato</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_contratos.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                      </div>
                                   </div>
                                 <?php } 
                                    if ($_SESSION['nivel']==3) { ?>
                                     <div class="form-group row">
                                      <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_contratos_contratistas.php" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                        <a style="background: #E957A5;border: #E957A5" class="btn btn-md btn-success" href="list_trabajadores.php" ><i  class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Trabajadores</a>
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
                          
                                     <?php if ($_SESSION['nivel']==3) { ?>
                                          <div class="row">                                          
                                          
                                            <label class="col-sm-2 col-form-label"><b>Contratos</b></label>
                                           
                                           <div style="text-align: right;" class="col-sm-4">     
                                                <select name="contrato" id="contrato" class="form-control m-b" onchange="selcontrato(this.value)">
                                                <?php
                                                    if ($_GET['contrato']=="") {
                                                        echo '<option value="0" selected="" >Seleccionar Contrato</option>'; 
                                                    foreach ($contratos as $rowC) {     
                                                        echo	'<option value="'.$rowC['id_contrato'].'">'.$rowC['nombre_contrato'].'</option>';
                                                        }
                                                        
                                                    } else {
                                                        $query=mysqli_query($con,"select * from contratos where id_contrato='".$_GET['contrato']."' ");
                                                        $result=mysqli_fetch_array($query);
                                                        echo '<option value="'.$result['id_contrato'].'" >'.$result['nombre_contrato'].'</option>';
                                                        foreach ($contratos as $rowC) {    
                                                        echo	'<option value="'.$rowC['id_contrato'].'">'.$rowC['nombre_contrato'].'</option>';
                                                        }
                                                    }                                   
                                                ?>
                                                </select>
                                               </div> 
                                          </div>  
                                         
                                         <?php } ?>                  
                        
                                          
                         <div class="table-responsive">
                                <table class="footable table table-stripped" data-page-size="20" data-filter="#filter">
                                   <thead style="background:#010829;color:#fff">
                                    <tr>
                                    <th class="" style="width: 5%;border-right:1px #fff solid">Estado</th>
                                        <th class="" style="width: 15%;border-right:1px #fff solid">Documento</th>
                                        <th class="" style="width: 10%;border-right:1px #fff solid">Dia Entrega</th>
                                        <th class="" style="width: 30%;border-right:1px #fff solid">Mandante</th>
                                        <th class="" style="width: 15%;border-right:1px #fff solid">Carga Simult&aacute;nea</th>
                                        <th class="" style="width: 15%;">Carga Individual</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php       

                                    foreach ($query_mensual as $row) {
                                        
                                        switch ($row['mes']) {
                                            case '1': $mes_control='ENERO';break;
                                            case '2': $mes_control='FEBRERO';break;
                                            case '3': $mes_control='MARZO';break;
                                            case '4': $mes_control='ABRIL';break;
                                            case '5': $mes_control='MAYO';break;
                                            case '6': $mes_control='JUNIO';break;
                                            case '7': $mes_control='JULIO';break;
                                            case '8': $mes_control='AGOSTO';break;
                                            case '9': $mes_control='SEPTIEMPRE';break;
                                            case '10': $mes_control='OCTUBRE';break;
                                            case '11': $mes_control='NOVIEMBRE';break;
                                            case '12': $mes_control='DICIEMBRE';break;
                                        }    
                                                
                                        ?> 
                                        <tr> 
                                            
                                            <?php if ($row['estado']==0) { ?>
                                                <td><label class="label label-danger block">No Enviado</label></td>
                                            <?php }  ?>

                                            <?php if ($row['estado']==1) { ?>
                                                <td><label class="label label-success block">Enviado</label></td>
                                            <?php }  ?>
                                                
                                             <!-- documento --->    
                                             <td><?php echo $row['documento']  ?></td>
                                            
                                             <!-- mes control  
                                            <td><?php echo $mes_control  ?></td>--->   
                                            
                                             <!-- dia control --->    
                                            <td><?php echo $row['dia'].' C/Mes'  ?></td>
                                            
                                             <!-- cmandante --->    
                                            <td><?php echo $row['nombre_mandante'] ?></td>
                                            
                                            <!-- carga simultanea --->    
                                            <td>
                                                <button class="btn btn-xs btn-success btn-block" onclick="simultanea(<?php echo $row['mes'] ?>,<?php echo $row['id_m'] ?>,<?php echo $_GET['contrato'] ?>)" >SIMUNTANEA</button>
                                            </td>
                                            
                                            <!-- carga  --->
                                            <?php if ($row['entregados']==0) { ?>
                                                <td><button class="btn btn-xs btn-primary btn-block" onclick="procesar_mensuales(<?php echo $_GET['contrato'] ?>,<?php echo $row['id_m'] ?>)" disabled="" >INDIVIDUAL</button> </td>
                                            <?php } else { ?>
                                                <td><button class="btn btn-xs btn-success btn-block">ENTREGADO </button> </td>
                                            <?php }  ?>                                             
                                            
                                            
                                                                           
                                        </tr>
                                       <?php $i++; }  ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="8">
                                            <ul class="pagination float-right"></ul>
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                           
                         </div> 
                          
                        </div>
                      </div>
                   </div>
               </div>
               
              <script>
                                  function procesar_mensuales(contrato,mensual) {   
                                     //alert(contratista);
                                           window.location.href='gestion_documentos_mensuales.php?contrato='+contrato+'&mensual='+mensual;
                                   }
                                   
                                   function simultanea(mes,mensual,contrato) {
                                      //alert(mes+' '+mensual);
                                      $.post("sesion_simultaneo.php", { mes: mes,mensual: mensual }, function(data){
                                            $('#modal_simultaneo').modal({show:true});
                                      });      
                                    } 
                                    
                                   function simultanea2(mes,mensual,contrato) {
                                     // alert(id_doc+' '+id_obs);
                                      $('.body').load('selid_simultaneo.php?mes='+mes+'&mensual='+mensual+'&contrato='+contrato,function(){
                                                $('#modal_simultaneo').modal({show:true});
                                           });
                                 }  
                                   
              
              </script> 
              
                            <!-- MODAL CARGA SIMULTANEA 
                            <div class="modal fade" id="modal_simultaneo" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Carga Simult&aacute;nea <?php echo $_SESSION['mensual'].' '.$_SESSION['mes'] ?>  </h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" onclick="window.location.href='documentos_mensuales.php?contrato=<?php echo $_GET['contrato'] ?>'" ><span aria-hidden="true">x</span></button>
                                    </div>
                                     <div class="body">
                                      
                                   </div>
                                </div>
                             </div>
                           </div> -->
           
                            <!-- MODAL CARGA SIMULTANEA -->
                            <div class="modal fade" id="modal_simultaneo" tabindex="-1" role="dialog" aria-hidden="true">
                            <?php  session_start(); ?>
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                      <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Documentos Simult&aacute;nea   </h3>
                                      <button style="color: #FFFFFF;" type="button" class="close" onclick="window.location.href='documentos_mensuales.php?contrato=<?php echo $_GET['contrato'] ?>'" ><span aria-hidden="true">x</span></button>
                                    </div>
                                     <div class="body">
                                        <style>
                                            .estilo {
                                                    display: inline-block;
                                                	content: "";
                                                	width: 25px;
                                                	height: 25px;
                                                	margin: 0.5em 0.5em 0 0;
                                                    background-size: cover;
                                                }
                                                .estilo:checked  {
                                                	content: "";
                                                	width: 25px;
                                                	height: 25px;
                                                	margin: 0.5em 0.5em 0 0;
                                                }
                                        </style>
                                        <div class="modal-body"> 

                                            <form  method="" name="f1" id="frmSimultaneo" enctype="multipart/form-data"> 
                                             <div class="modal-body">
                                               
                                                <div class="row">
                                                  <div class="col-12">
                                                     <select name="doc_simultaneo" id="doc_simultaneo" class="form-control">
                                                        <option value="0" selected="">Seleccionar Documento </option>
                                                        
                                                        <?php 
                                                            
                                                            $query_t=mysqli_query($con,"select t.* from trabajador as t INNER JOIN trabajadores_acreditados as a ON a.trabajador=t.idtrabajador WHERE a.contrato='".$_SESSION['contrato']."' and a.estado!='2' ");
                                                            $cantidad_t=mysqli_num_rows($query_t);
                                                            
                                                            $query_doc=mysqli_query($con,"select doc_contratista_mensuales from mensuales as m where contrato='".$_SESSION['contrato']."' ");
                                                            
                                                            foreach ($query_doc as $row)  { 
                                                              $query=mysqli_query($con,"select documento from doc_mensuales where id_dm='".$row['doc_contratista_mensuales']."' ");  
                                                              $result=mysqli_fetch_array($query) ?>
                                                              <option value="<?php echo $row['doc_contratista_mensuales'] ?>"><?php echo $result['documento'] ?></option>   
                                                        <?php } ?>
                                                     </select>
                                                  </div>   
                                                </div>
                                                <br />
                                                <div class="row">
                                                  <div class="form-group col-12">
                                                    <div  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span  style="background: #282828;color: #000;border:#969696;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                        <span  class="fileinput-exists">Cambiar</span><input class="form-control block"  type="file" id="carga_doc_simultaneo" name="carga_doc_simultaneo" accept="application/pdf" /></span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                    </div>
                                                  </div>   
                                                </div>
                                               
                                                
                                               
                                                <div class="row" style="margin-top: 5%;" >
                                                    <div class="col-12">
                                                        <table style="overflow-y: auto;" class="table">
                                                            <thead style="background:#010829;color:#fff">
                                                                <tr>
                                                                    <th style="width: 1%;border-right:1px #fff solid">#</th>
                                                                    <th style="width: 20%;border-right:1px #fff solid">Trabajador</th>
                                                                    <th class="text-rigth" style="width: 10%;"><a onclick="seleccionarTodo()"><u>Seleccionar Todos</u></a></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $i=0;
                                                                foreach ($query_t as $row) {  ?>
                                                                <tr>
                                                                    <td><?php echo $i+1 ?></td> 
                                                                    <td><label class="col-form-label"><?php echo $row['nombre1'].' '.$row['apellido1'] ?></label></td>
                                                                    <td style="text-align:center" >
                                                                         <input class="estilo" id="trabajadores<?php echo $i ?>" name="trabajadores[]" type="checkbox" value="<?php echo $row['idtrabajador'] ?>" /> 
                                                                    </td>
                                                                        
                                                                 </tr>
                                                                <?php $i++; } ?>
                                                            </tbody>
                                                        </table>
                                                        
                                                        <script>
                                                                function seleccionarTodo() {
                                                                    var isChecked = $('#trabajadores0').prop('checked');
                                                                    if (isChecked) {
                                                                        for (let i=0; i < document.f1.elements.length; i++) {
                                                                            if(document.f1.elements[i].type === "checkbox") {
                                                                                document.f1.elements[i].checked = false;
                                                                            }
                                                                        }
                                                                    } else {    
                                                                        for (let i=0; i < document.f1.elements.length; i++) {
                                                                            if(document.f1.elements[i].type === "checkbox") {
                                                                                document.f1.elements[i].checked = true;
                                                                            }
                                                                        }
                                                                     }   
                                                                    }
                                                            
                                                        
                                                        </script>
                                                     </div>   
                                                </div>                                                  
                                               </div>                      
                                               <div class="modal-footer">
                                               <button class="btn btn-success btn-sm" type="button" onclick="cargar_simultaneo(<?php echo $_SESSION['mes'] ?>,<?php echo $_SESSION['mensual']?>,<?php echo $_GET['contrato'] ?>,<?php echo $i ?>)" >Cargar Documentos</button>  
                                                    <button style="color: #FFFFFF;" type="button" class="btn btn-danger btn-sm" onclick="window.location.href='documentos_mensuales.php?contrato=<?php echo $_GET['contrato'] ?>'" ><span aria-hidden="true">Cerrar</span></button>
                                               </div> 
                                           </form>
                                        </div>
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
    
    <!-- iCheck -->
    <script src="js\plugins\iCheck\icheck.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

<script>

$(document).ready(function() {
    
            $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
            });

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
