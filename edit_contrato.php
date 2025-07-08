<?php
session_start();
if (isset($_SESSION['usuario']) ) { 
    
session_destroy($_SESSION['active']);
$_SESSION['active']=23;

$idcontrato=$_SESSION['contrato'];    
include('config/config.php');
$sql_mandante=mysqli_query($con,"select * from mandantes where email='".$_SESSION['usuario']."'  ");
$result=mysqli_fetch_array($sql_mandante);
$mandante=$result['id_mandante'];

$perfiles=mysqli_query($con,"select * from perfiles where estado=1 and id_mandante='$mandante' ");

$contratistas=mysqli_query($con,"Select * from contratistas where mandante='$mandante' ");
$cargos=mysqli_query($con,"SELECT * from cargos where estado=1");

$contrato=mysqli_query($con,"Select c.id_contrato, c.cargos, o.id_contratista, o.razon_social, c.nombre_contrato, c.id_contrato from contratos as c Left Join contratistas as o On o.id_contratista=c.contratista where c.id_contrato='$idcontrato' ");
$fcontrato=mysqli_fetch_array($contrato);
$cargos2=$fcontrato['cargos'];
$cargos_contrato=unserialize($cargos2);


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

?>
<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Editar Contrato</title>
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
    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
    
    <link href="css\plugins\dropzone\basic.css" rel="stylesheet">
    <link href="css\plugins\dropzone\dropzone.css" rel="stylesheet">
    <link href="css\plugins\jasny\jasny-bootstrap.min.css" rel="stylesheet">
    <link href="css\plugins\codemirror\codemirror.css" rel="stylesheet">


<script src="js\jquery-3.1.1.min.js"></script>
<script>

$('#select').selectpicker();
    
</script>

</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
      <div style=";color: #010829;" class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                   <h2 style="color: #010829;font-weight: bold;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Contrato <?php  ?></h2>
                </div>
                <div class="col-lg-2">

                </div>
        </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                        </div>
                        <div class="ibox-content">
                            <form  method="post" id="frmContratos" enctype="multipart/form-data">
                                
                                 <div class="row"> 
                                    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label class="col-form-label" for="quantity">Contratista</label> 
                                    </div>                  
                                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <select id="contratista" name="contratista" class="form-control">
                                           <option value="<?php echo $fcontrato['id_contratista'] ?>" selected=""><?php echo $fcontrato['razon_social'] ?></option>
                                           <?php                                            
                                            foreach ($contratistas as $row){                                                
                                                echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                            }    
                                           ?>     
                                        </select>
                                    </div>                                
                                </div>  
                                
                                 <div class="row">
                                    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label class="col-form-label" for="quantity">Cargos</label> 
                                    </div>                  
                                    <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-8">
                                        <button class="btn btn-outline btn-success btn-block" type="button" onclick="cargos()">Seleccionar Cargos</button>
                                        <!--<select   name="cargos[]" id="cargos" multiple="" class="selectpicker form-control" onchange="activar()" >
                                          <?php
                                             $i=0;
                                            foreach ($cargos as $row) {
                                                $condicion=true;
                                                foreach ($cargos_contrato as $row2) {
                                                    if ($row2==$row['idcargo']) {
                                                        echo '<option value="'.$row['idcargo'].'" selected="" >'.$row['cargo'].'</option>';
                                                        $condicion=false;
                                                    }
                                                }   
                                               if ($condicion==true) { 
                                                 echo '<option value="'.$row['idcargo'].'" >'.$row['cargo'].'</option>';
                                               }  
                                               
                                              $i++;  
                                            }    
                                           ?> 
                                        </select>
                                        <br /><br />
                                        <div id="btnsel"  style="display: none;">
                                            <button type="button"  class="btn btn-primary btn-block " >Click al seleccionar</button>
                                         </div>   -->
                                    </div>                                
                                </div>
                                
                                <div class="row"> 
                                    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label class="col-form-label" for="quantity">Contrato</label> 
                                    </div>                  
                                    <div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                       <input class="form-control" type="text" name="nombre_contrato" id="nombre_contrato" placeholder="" value="<?php echo $fcontrato['nombre_contrato'] ?>" />
                                    </div>                                
                                </div>  
                                 
                                <div class="row"> 
                                    <div class="form-group col-lg-1 col-md-2 col-sm-2 col-xs-2">
                                        <label class="col-form-label" for="quantity">Adjuntar</label> 
                                    </div> 
                                    <div style="background: #eeeeee; padding-top: 0.5%;" class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                            <div style="width: 100%;"  class="fileinput fileinput-new" data-provides="fileinput">
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Seleccione Archivo</span>
                                                <span class="fileinput-exists">Cambiar</span><input type="file" name="contrato" id="contrato" /></span>
                                                <span class="fileinput-filename"></span>
                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                            </div>                          
                                    </div>                             
                                </div> 
                                 
                                
                                <input type="hidden" name="crearcontrato" id="crearcontrato" value="actualizar" />
                                <input type="hidden" name="mandante" id="mandante" value="<?php echo $mandante ?>" />
                                <input type="hidden" name="id_contrato" id="id_contrato" value="<?php echo $idcontrato ?>" />
                                
                                <div class="hr-line-dashed"></div>
                                <div class="form-group row">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <!--<button style="background:#010829;color:#fff" class="btn btn-white btn-md" type="button">Cambiar</button>-->
                                        <button class="btn btn-success btn-md" name="actualizar" type="button" onclick="editar_contrato()"><i class="fa fa-refresh" aria-hidden="true"></i> Actualizar Contrato</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function cargos() {
               
                    $('#modal_cargos').modal({show:true})
            }                    
        </script>
        
        <div class="modal fade" id="modal_cargos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg ">
                <div class="modal-content">
                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Seleccionar Cargos No Asignados</h3>
                        <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <?php

                    session_start();
                    include('config/config.php');
                    $query=mysqli_query($con,"select * from cargos  ");
                    $cargos_contrato=mysqli_query($con,"select * from contratos where id_contrato='".$_SESSION['contrato']."'  ");
                    $result_contrato=mysqli_fetch_array($cargos_contrato);
                    $cargos=unserialize($result_contrato['cargos']);
                    
                    ?>        
                    <form method="post" id="frmCargos">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        <?php $i=1; 
                                            foreach ($query as $row) {    
                                              $cargo_asignado=false;
                                              $j=0;
                                              foreach ($cargos as $row2 ) {
                                                if ($row2==$row['idcargo']) {
                                                    $cargo_asignado=true;
                                                }
                                               $j++; 
                                              }
                                              if ($cargo_asignado==false) {
                                                    ?>
                                                <tr>                            
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="cargo" name="cargos[]" type="checkbox" value="<?php echo $row['idcargo'] ?>" /> </div></td>
                                                    <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['cargo']  ?></label></td>
                                                    
                                                </tr>
                                        <?php 
                                                }   
                                        $i++;} ?>
                                        </tbody>
                                    </table>
                                    <!--<select  name="cargos[]" id="cargos" multiple="" class=" form-control"  >
                                    <?php
                                         while($row = mysqli_fetch_assoc($query)) { ?>
                                         <option value="0"><?php echo $row['cargo'] ?></option>                             
                                        <?php  } ?> 
                                    </select>-->
                                </div>                    
                            </div>
                        
                    </div>
                    <input type="hidden" name="asignar" value="edit_contrato" />   
                    <div class="modal-footer">
                        <a style="color: #fff;" class="btn btn-danger" data-dismiss="modal" >Cerrar</a>
                        <button style="color: #fff;" class="btn btn-success" type="button" name="asignar" onclick="asignar_cargos()">Asignar</button>
                    </div>
                    </form>    
                    <script>
                        function asignar_cargos() {
                           var valores=$('#frmCargos').serialize();
                           //alert(valores);
                          $.ajax({
                    			method: "POST",
                                url: "session_cargos.php",
                                data: valores,
                    			success: function(data){
                    			   $('#modal_cargos').modal('hide')
                                   //window.location.href='edit_contrato.php';
                    			}                
                            });
                        }
                    </script>                 
                </div>
            </div>
        </div>
        
        
        <?php include('footer.php') ?>

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
            $(document).ready(function () {
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
                
               
                
                
            });
    
    function activar() {
      $('#btnsel').css("display","block")
    }

    
    function editar_contrato(){
      //alert('hola');
      
      var contratista=$('#contratista').val();
      var mandante=$('#mandante').val();
      var nombre_contrato=$('#nombre_contrato').val();
      var cargos=$('#cargos').val();
      
      var formData = new FormData(); 
      var files= $('#contrato')[0].files[0];                   
      formData.append('contrato',files);
      formData.append('nombre_contrato', nombre_contrato );
      formData.append('mandante', mandante );
      
       if (contratista!="0") {   
         if (cargos!="") {
            if (nombre_contrato!="") {
              var valores=$('#frmContratos').serialize();
              $.ajax({
            			method: "POST",
                        url: "add/contratos.php",
                        data: valores,
            			success: function(data){
                			//alert(data); 
                             if (data==2) {
                                 $.ajax({
                                    url: 'cargar_ficheros_contratos.php',
                                    type: 'post',
                                    data:formData,
                                    contentType: false,
                                    processData: false,
                                    success: function(response) {
                                        swal({
                                            title: "Contrato Actualizado",
                                            //text: "You clicked the button!",
                                            type: "success"
                                        });
                                        setTimeout(function() { window.location.href='list_contratos.php'}, 4000);                             
                                    }
                                 });
                			  } else {
                			    
                                    swal("Cancelado", "Contrato No Actualizado. Vuelva a Intentar.", "error");                        
                                    //setTimeout(window.location.href='list_contratos.php', 3000);
                               }                                                      
          			   }         
                   });
          } else {
                    swal({
                        title: "Nombre del Contrato",
                        //text: "",
                        type: "warning"
                        
                    });
              }          
                       
        } else {
                    swal({
                        title: "Cargos del Contrato",
                        //text: "",
                        type: "warning"
                        
                    });
              }                 
      } else {
            swal({
                title: "Seleccionar Contratista",
                //text: "",
                type: "warning"
                
            });
      }           
            
           
  }

    </script>
</body>

</html><?php } else { 

echo '<script> window.location.href="index.php"; </script>';
}

?>
