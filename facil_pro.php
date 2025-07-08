<?php
session_start();
if (isset($_SESSION['usuario']) ) { 
    
include('config/config.php');


if ($_SESSION['nivel']==3) { 

    $query_contratista=mysqli_query($con,"select p.plan as tipoplan, c.*, p.*, a.*, v.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista left join control_pagos as a On a.idcontratista=c.id_contratista left join plan_valor as v On v.idplan=p.plan  where c.rut='".$_SESSION['usuario']."'  ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    $idcontratista=$result_contratista['id_contratista'];
} 

if ($_SESSION['nivel']==1 or $_SESSION['nivel']==2) { 

    $query_contratista=mysqli_query($con,"select c.* from contratista as c where c.id_contratista='".$_GET['id']."'  ");
    $result_contratista=mysqli_fetch_array($query_contratista);
    $idcontratista=$result_contratista['id_contratista'];
}   


setlocale(LC_MONETARY,"es_CL");
date_default_timezone_set('America/Santiago');
$dia=date('d');
$mes=date('m');
$year=date('Y');

$mensual=350;
$trimestral=400;
$semestral=450;
$anual=500;

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <title>FacilControl | FacilPro </title>

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">
    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">
     <!-- Sweet Alert -->
    <link href="css\plugins\sweetalert\sweetalert.css" rel="stylesheet">
    
    <!-- Toastr style -->
    <link href="css\plugins\toastr\toastr.min.css" rel="stylesheet">
    
    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>
    
    <!-- Ladda style -->
    <link href="css\plugins\ladda\ladda-themeless.min.css" rel="stylesheet">

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">
   
    
    

<script src="js\jquery-3.1.1.min.js"></script>

<style>


</style>

</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;"><i class="fa fa-credit-card" aria-hidden="true"></i> FacilContro PRO <?php  ?></h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <!--<div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <a href="list_perfil.php" class="btn btn-success btn-md"><i class="fa fa-list-ul" aria-hidden="true"></i> Listado de Perfiles</a>
                                    </div>
                              </div> --> 
                         
                        </div>
                        <div class="ibox-content">
                         
                         <!-- si el usuario es una contratista  --> 
                          <?php if ($_SESSION['nivel']==3) { 
                                   
                                   // si el plan es de prueba
                                   if ($result_contratista['tipoplan']==0) { 
                                                ?>  
                                    
                                    
                                    <div class="row">
                                          <div class="col-6">
                                                 <p style="font-size: 18px;">Contratista: <b><?php echo $result_contratista['razon_social'] ?></b></p>
                                                     
                                                <p style="font-size: 16px;">Actualmente Ud tiene el <b>Plan de Prueba</b> de los servicios de <b>FacilControl</b> que tiene una duraci&oacute;n de 30 d&iacute;as.<br /><br />
                                                Fecha inicio: <b><?php echo $result_contratista['fecha_inicio_plan'] ?>.</b><br />
                                                Fecha t&eacute;rmino: <b><?php echo $result_contratista['fecha_fin_plan'] ?>.</b><br /><br />
                                                Le invitamos a contratar algunos de planes pagos y disfrutar de todos los beneficios que tenemos para su empresa.<br /><br />
                                                <b>Equipo FacilControl.</b></p>
                                                
                                                
                                          </div>  
                                          
                                          <div class="col-6">      
                                                  <div class="panel-body">
                                                        <div class="panel-group" id="accordion">
                                                            
                                                            <!--  plan mensual -->
                                                            <div class="panel panel-default">
                                                                <div style="background: #1AB394;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h5  class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN MENSUAL</a>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $mensual ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 30 d&iacute;as<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 30 days")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                           
                                                                            <b><u>1) Flow</u> </b> <br />
                                                                            <button onclick="pago_flow(1,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $mensual ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--  plan trimestral -->
                                                            <div  class="panel panel-default">
                                                                <div style="background:#23C6C8;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h4  class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN TRIMESTRAL</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $trimestral ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 3 meses<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 3 month ")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                            
                                                                            <b><u>1) FLOW</u> </b> 
                                                                            <button onclick="pago_flow(2,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $trimestral ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--  plan semestral -->
                                                            <div class="panel panel-default">
                                                                <div style="background:#1C84C6;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN SEMESTRAL</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                         <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $semestral ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 6 meses<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 6 month ")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                            
                                                                            <b><u>1) FLOW</u> </b> 
                                                                            <button onclick="pago_flow(3,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $semestral ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--  plan anual -->
                                                            <div class="panel panel-default">
                                                                <div style="background:#F8AC59;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN ANUAL</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapse4" class="panel-collapse collapse"> 
                                                                    <div class="panel-body">
                                                                         <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $anual ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 1 a&ntilde;o<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 1 year ")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                            
                                                                            <b><u>1) FLOW</u> </b> 
                                                                            <button onclick="pago_flow(4,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $anual ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                          </div>  
                                      
                                    </div>
                          <?php   }  else { 
                                     
                                     switch ($result_contratista['tipoplan']) {
                                        case '0':$plan="Prueba";break;
                                        case '1':$plan="Mensual";break;
                                        case '2':$plan="Trimestral";break;
                                        case '3':$plan="Semestral";break;
                                        case '4':$plan="Anual";break;
                                      }   
                            
                                        
                                     ?>
                                    
                                    
                                   <div class="row">
                                          <div class="col-6">
                                                 <p style="font-size: 18px;">Contratista: <b><?php echo $result_contratista['razon_social'] ?></b></p>
                                                     
                                                <p style="font-size: 16px;">Actualmente Ud tiene el <b><?php echo $plan ?>.</b><br />
                                                Gracias por confiar y contratar los servicios de <b>FacilControl Pro</b><br /><br />
                                                Duraci&oacute;n:<b> <?php echo $result_contratista['duracion'] ?>.</b><br />
                                                Fecha inicio: <b><?php echo $result_contratista['fecha_inicio_plan'] ?>.</b><br />
                                                Fecha t&eacute;rmino: <b><?php echo $result_contratista['fecha_fin_plan'] ?>.</b><br /><br />
                                                <!--Le invitamos a contratar algunos de planes pagos y disfrutar de todos los beneficios que tenemos para su empresa.<br /><br />-->
                                                <b>Equipo FacilControl.</b></p>
                                                
                                                
                                          </div>  
                                          
                                          <div class="col-6">      
                                                  <div class="panel-body">
                                                        <div class="panel-group" id="accordion">
                                                            
                                                            <!--  plan mensual -->
                                                            <div class="panel panel-default">
                                                                <div style="background: #1AB394;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h5  class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN MENSUAL</a>
                                                                    </h5>
                                                                </div>
                                                                <div id="collapseOne" class="panel-collapse collapse in">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $mensual ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 30 d&iacute;as<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 30 days")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                           
                                                                            <b><u>1) Flow</u> </b> <br />
                                                                            <button onclick="pago_flow(1,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $mensual ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--  plan trimestral -->
                                                            <div  class="panel panel-default">
                                                                <div style="background:#23C6C8;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h4  class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN TRIMESTRAL</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                        <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $trimestral ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 3 meses<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 3 month ")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                            
                                                                            <b><u>1) FLOW</u> </b> 
                                                                            <button onclick="pago_flow(2,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $trimestral ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--  plan semestral -->
                                                            <div class="panel panel-default">
                                                                <div style="background:#1C84C6;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN SEMESTRAL</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                         <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $semestral ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 6 meses<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 6 month ")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                            
                                                                            <b><u>1) FLOW</u> </b> 
                                                                            <button onclick="pago_flow(3,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $semestral ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <!--  plan anual -->
                                                            <div class="panel panel-default">
                                                                <div style="background:#F8AC59;color:#fff;font-size: 20px;" class="panel-heading">
                                                                    <h4 class="panel-title">
                                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="fa fa-calendar" aria-hidden="true"></i> PLAN ANUAL</a>
                                                                    </h4>
                                                                </div>
                                                                <div id="collapse4" class="panel-collapse collapse">
                                                                    <div class="panel-body">
                                                                         <p>
                                                                            <span style="font-weight: bold;">Costo:</span> <?php echo $anual ?> clp. &nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Duraci&oacute;n:</span> 1 a&ntilde;o<br />
                                                                            <span style="font-weight: bold;">Inicio:</span> <?php echo $fecha_actual ?>&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">Termino:</span> <?php echo date("d-m-Y",strtotime($fecha_actual."+ 1 year ")); ?><br />
                                                                         </p>
                                                                         <p>
                                                                            <span style="font-weight: bold;">M&eacute;todos de Pago:</span><br /><br />
                                                                            
                                                                            <b><u>1) FLOW</u> </b> 
                                                                            <button onclick="pago_flow(4,<?php echo $result_contratista['id_contratista'] ?>,<?php echo $anual ?>)" style="width: 30%;" class="btn btn-xs btn-success" >Flow</button>
                                                                            
                                                                            <br /><br />
                                                                            
                                                                            <b><u>2) Transferencia Bancaria</u> </b> <br />
                                                                            Banco Estado.<br /> 
                                                                            Cuenta Corriente 12345678.<br />
                                                                            A Nombre de: facil control.
                                                                         </p>
                                                                         <p>Informar pago, adjuntando comprobantes al email: <b>pagos@facilcontrol.cl</b> En 24horas m&aacute;ximo validaremos tu pago.</b> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                          </div>  
                                      
                                    </div>
                                    
                                        
                          
                          <?php  } 
                             }  ?>   
                        </div>
                    </div>
                </div>
          </div>
      

          
          
       </div> <!-- wrapper comtent  -->
       
       <div class="footer">
            <div class="float-right">
                Versi&oacute;n <strong>1.0</strong>.
            </div>
            <div>
                <strong>Copyright</strong> FacilControl &copy; <?php echo $year ?>
            </div>
        </div>
       
    </div>
   </div>
 </body> 
                           <script>
                           
                               function modal_agregar_pago(id,plan) {
                                  //alert(doc);
                                   $('.body').load('selid_agregar_pago.php?id='+id+'&plan='+plan,function(){
                                         $('#modal_agregar_pago').modal({show:true});
                                   });
                               }
                               
                               function pago_flow(plan,id,valor) {
                                //alert(plan+' '+id);
                                $.ajax({
                            			method: "POST",
                                        url: "flow/flow.php",
                                        data: 'id='+id+'&plan='+plan+'&valor='+valor,
                            			success: function(data){			  
                                         if (data!=1) {
                                             //swal({
                                               //     title: "Plan Mensual",
                                                 //   text: "plan contratado",
                                                   // type: "success"
                                                //}
                                             //);
                                             //window.location.href=data;;
                                             window.open(data, '_blank');
                            			  } else {
                                             swal("Error de Sistema", "Vuelva a Intentar.", "error");
                                             setTimeout(window.location.href='facil_pro.php', 3000);
                            			 }
                            			}                
                                   });
                               }
                           
                           </script>  
 
                           <div class="modal  fade" id="modal_agregar_pago" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Agregar un Pago</h3>
                                          <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="body">
                                        </div> 
                                        <div class="modal-footer">
                                           <button style="color: #fff;" class="btn btn-danger btn-xs" class="close" data-dismiss="modal" aria-label="Close"  ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
                                      </div>                                    
                                   </div>
                                </div>
                            </div>
 
 
 <script>
 
  
        function xxxx(plan,id) {
            swal({
            title: "Confirmar Plan Mensual",
            //text: "Your will not be able to recover this imaginary file!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Si, confirmar",
            cancelButtonText: "No, confirmar",
            closeOnConfirm: false,
            closeOnCancel: false },            
            function (isConfirm) {
            if (isConfirm) {                
                $.ajax({
        			method: "POST",
                    url: "plan/flow.php",
                    data: 'id='+id,
        			success: function(data){			  
                     if (data==0) {
                         swal({
                                title: "Plan Mensual",
                                text: "plan contratado",
                                type: "success"
                            }
                         );
                         setTimeout(window.location.href='facil_pro.php', 3000);
        			  } else {
                         swal("Error de Sistema", "Vuelva a Intentar.", "error");
                         setTimeout(window.location.href='list_facil_pro.php', 3000);
        			  }
        			}                
               });
            } else {
                swal("Cancelado", "Accion Cancelada", "error");
            }
        });
      }
      
   
 </script>
 
   
 <!-- Mainly scripts -->
    <script src="js\jquery-3.1.1.min.js"></script>
    <script src="js\popper.min.js"></script>
    <script src="js\bootstrap.js"></script>
    <script src="js\plugins\metisMenu\jquery.metisMenu.js"></script>
    <script src="js\plugins\slimscroll\jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js\inspinia.js"></script>
    <script src="js\plugins\pace\pace.min.js"></script>

    
    <!-- Sweet alert -->
   <script src="js\plugins\sweetalert\sweetalert.min.js"></script>
   
    <!-- Peity -->
    <script src="js\plugins\peity\jquery.peity.min.js"></script>

    <!-- Peity demo data -->
    <script src="js\demo\peity-demo.js"></script>
    
    <!-- DROPZONE -->
    <script src="js\plugins\dropzone\dropzone.js"></script>

    <!-- CodeMirror -->
    <script src="js\plugins\codemirror\codemirror.js"></script>
    <script src="js\plugins\codemirror\mode\xml\xml.js"></script>
    
    <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script> 
    
   
        <script>
            $(document).ready(function () {
              
                
                
            });
  
    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
