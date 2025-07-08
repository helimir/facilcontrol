<?php
 session_start();
include "config/config.php";
include "funciones.php";

setlocale(LC_MONETARY,"es_CL");
setlocale(LC_ALL,"es_CL");

#$rut="26.342.101-9";
$rut=$_GET['rut'];

$query=mysqli_query($con,"select * from acreditaciones ");
$query_c=mysqli_query($con,"select c.*, p.* from contratistas as c left join pagos as p On p.idcontratista=c.id_contratista where c.rut='".$rut."' ");
$result_c=mysqli_fetch_array($query_c);

$query_a=mysqli_query($con,"select * from trabajadores_acreditados where contratista='".$result_c['id_contratista']."' ");
$num_acreditaciones=mysqli_num_rows($query_a);
#$num_acreditaciones=27;

$query_p=mysqli_query($con,"select * from acreditaciones ");

if ($num_acreditaciones<=3) {
    $id_plan=1;
    $plan="PLAN FREE";
    $pago=0;
    $acreditaciones=3;
} else {
    foreach ($query_p as $row) {
        if ($num_acreditaciones>3 and $num_acreditaciones<$row['acreditaciones']) {
            $id_plan=$row['id_a'];
            $plan=$row['plan'];
            $pago=$row['costo'];
            $acreditaciones=$row['acreditaciones'];
            break;
        } 
    }
}    

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Proyecto | Login</title>

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

.submenu {
    background: #E957A5;
    border: #E957A5;
}

    </style>    
    
   
<script>



                       

</script>       

</head>

<?php

/**
 * @author helimirlopez
 * @copyright 2022
 */

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

?>

<body style="background: #cecece;" class="gray-bg">
    <div style="justify-content: center;align-items: center;display: flex;" id="wrapper">  
        <div style="background: #cecece;"  id="page-wrapper" class="gray-bg">

            <!--<div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Crear Contratista <?php  ?></h2>
                </div>
            </div>-->


            <div style="background: #cecece;" class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                              <div  style="background: #333399;" class="ibox-title"> 
                              
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <h2 style="color: #fff;font-weight: bold;"><i class="fa fa-credit-card" aria-hidden="true"></i> Actualizar Plan FacilControl <?php  ?>&nbsp;&nbsp;|&nbsp;&nbsp; <a style="background:#E957A5;border: 1px #E957A5" class="btn btn-sm btn-success btn-submenu" href="admin.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Inicio del Sistema</a></h2>
                                    
                                    </div> 
                              
                                    <!--<div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratistas_mandantes.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratistas</a>
                                        <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                    </div> -->
                              </div>
                              
                        <div class="ibox-content">
                                
                        
                                <div style="font-size:18px" class="form-group  row">
                                    <label class="col-sm-4 col-form-label font-bold"><strong><i class="fa fa-square" aria-hidden="true"></i> Per&iacute;odo de Prueba:</strong></label>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> Contratista:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo $result_c['razon_social'].' ['.$result_c['rut'].']' ?></strong></label>
                                    </div>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> Fecha inicio:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo $result_c['fecha_inicio_plan'] ?></strong></label>
                                    </div>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> Fecha culminaci&oacute;n:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo $result_c['fecha_inicio_plan'] ?></strong></strong></label>
                                    </div>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> # Acreditaciones:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo $num_acreditaciones ?></strong></label>
                                    </div>
                                </div>

                                <div style="font-size:18px" class="form-group  row">
                                    <label class="col-sm-4 col-form-label font-bold"><strong><i class="fa fa-square" aria-hidden="true"></i> Plan que aplica:</strong></label>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> Plan:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo $plan ?></strong></label>
                                    </div>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> Acreditaciones:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo $acreditaciones ?></strong></label>
                                    </div>
                                </div>

                                <div style="margin-top:-25px;font-size:14px" class="form-group  row">
                                    <label class="col-sm-2 col-form-label font-bold"><i class="fa fa-angle-right" aria-hidden="true"></i> Pago mensual:</label>
                                    <div class="col-sm-4">
                                        <label><strong><?php echo money_format('%.0n',$pago)?></strong></label>
                                    </div>
                                </div>

                                <!--<div class="row">
                               <div style="font-size:14px" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Contratista: <strong><?php echo $result_c['razon_social'].' ['.$result_c['rut'].']' ?></strong></label><br>
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Fecha inicio: <strong><?php echo $result_c['fecha_inicio_plan'] ?></strong></label><br>
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Fecha culminaci&oacute;n: <strong><?php echo $result_c['fecha_fin_plan'] ?></strong></label><br>
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Numero de Acreditaciones: <strong><?php echo $num_acreditaciones ?></strong></label><br>
                                  <hr>
                               </div>
                                                               
                               <div style="font-size:14px" class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  >
                                  <h3><strong><i class="fa fa-square" aria-hidden="true"></i> Plan que aplica:</strong></h3>
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Plan: <strong><?php echo $plan ?></strong></label><br>
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Acreditaciones: <strong><?php echo $acreditaciones ?></strong></label><br>
                                  <label><i class="fa fa-angle-right" aria-hidden="true"></i> Pago: <strong><?php echo money_format('%.0n',$pago)?> mensual.</strong></label>
                               </div>-->
                               


                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                                   
                                       <table class="table" >
                                           
                                           <thead>
                                               <tr style="background: #333399; color:#fff">
                                                   <th style="text-align: ;">Plan</th>
                                                   <th style="text-align: center;">Acreditaciones</th>
                                                   <th style="text-align: center;">Mensualidad</th>
                                                   <th style="text-align: center;">Seleccionar</th>
                                                   
                                               </tr>
                                           </thead>
                                       
                                           <tbody>
                                              <?php 
                                               $i=0;
                                               foreach ($query as $row) {

                                                  #$query_d=mysqli_query($con,"select * from contratistas_mandantes where contratista='".$_GET['id']."' and mandante='".$_SESSION['mandante']."' and plan='".$row['id_a']."' ");
                                                  #$result_d=mysqli_fetch_array($query_d); ?>
                                                <tr>
                                                       <td style="color:#333399;font-weight: bold "><?php echo $row['plan'] ?></td>
                                                       <td style="text-align: center"><?php echo $row['acreditaciones'] ?></td>
                                                       <td style="text-align: center"><?php echo money_format('%.0n',$row['costo']) ?></td>
                                                       
                                                       <?php if ($id_plan==1) { ?>
                                                            <td class="text-center" style="width: "><input  class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>
                                                       <?php } else { ?> 

                                                            <?php if ($num_acreditaciones>3 and $num_acreditaciones<$row['acreditaciones']) { ?>
                                                                    
                                                                        <td class="text-center" style="width: "><input  class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>

                                                            <?php } else { ?>    
                                                                <td class="text-center" style="width: "><input disabled=""  class="form-control" type="radio" id="<?php echo $row['id_a'] ?>" value="<?php echo $row['id_a'] ?>" name="plan" ></td>        
                                                            <?php }  
                                                            } ?>        

                                                </tr>
                                                <?php $i++;  }  ?>
                                           </tbody>
                                       </table>
                                </div>   
                                <div class="form-group row">
                                    <div class="col-sm-12 col-sm-offset-12">
                                            <a style="background:#E957A5;border: 1px #E957A5" class="btn btn-sm btn-success btn-submenu" href="admin.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Inicio del Sistema</a>
                                            <button style="color: #fff;" class="btn btn-success btn-sm" type="button" name="asignar" onclick="pago_flow(<?php echo $result_c['id_contratista'] ?>)">Actualizar Plan FacilControl</button>
                                    </div>                    
                                </div>    
                                
                           </div>
                           
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>



                    

                    <div class="modal fade" id="modal_cargar" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Actualizado Plan, por favor espere un momento</h3>
                              </div>
                            </div>
                          </div>
                        </div>


                     <!-- iCheck -->
                    
                    <script>
                            $(document).ready(function () {
                                $('.i-checks').iCheck({
                                    checkboxClass: 'icheckbox_square-green',
                                    radioClass: 'iradio_square-green',
                                });
                            });

                            function pago_flow(id) {
                            var plan1=document.querySelector('input[name="plan"]:checked').value;
                            var plan=Number(plan1);      
                            alert(id+' '+plan);
                            if (plan!=1) {  
                                $.ajax({
                                    method: "POST",
                                    url: "flow/flow.php",
                                    data: 'id='+id+'&plan='+plan,
                                    success: function(data){			  
                                        if (data!=1) {
                                            window.open(data, '_blank');
                                        } else {
                                            swal("Error de Sistema", "Vuelva a Intentar.", "error");
                                            setTimeout(window.location.href='admin.php', 3000);
                                        }
                                    }                
                                });
                            } else {
                                $.ajax({
                                    method: "POST",
                                    url: "add/add_plan_free.php",
                                    data: 'id='+id+'&plan='+plan,
                                    success: function(data){			  
                                        if (data==0) {
                                            window.location.href="https://facilcontrol.cl/list_contratos_contratistas.php";
                                        } else {
                                            
                                        }
                                    }                
                                });
                            }    
                        }  
                            
                            function planxxx(id) {
                                var plan=document.querySelector('input[name="plan"]:checked').value;
                                //alert(plan);
                                $.ajax({
                                    method: "POST",
                                    url: "add/plan_acreditaciones.php",
                                    data: 'id='+id+'&plan='+plan,
                                    beforeSend: function(){
                                        $('#modal_cargar').modal('show');						
                                    },
                                    success: function(data){
                                        if (data==0) {         
                                            swal({
                                                title: "Plan Actualizado",
                                                //text: "You clicked the button!",
                                                type: "success"
                                            });
                                            window.location.href='list_contratistas_mandantes.php';
                                        } 
                                        if (data==1) {
                                            swal({
                                                title: "Plan No Actualizado",
                                                text: "Vuelva a Intentar",
                                                type: "error"
                                            });
                                            
                                        }
                                    },
                                    complete:function(data){
                                        $('#modal_cargar').modal('hide');
                                    }, 
                                    error: function(data){
                                    }                
                                });
                            }  
                                
                        
                    </script>

            
    
        
        </div>                     
    </div>
</body>


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
    

    
    
   

</html>