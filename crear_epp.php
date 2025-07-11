<?php
include('sesion_manager.php');
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==3  ) {     
    
include('config/config.php');

$query_tipo_epp=mysqli_query($con,"select * from tipo_epp where estado=0  ");



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

    <title>FacilControl | Crear EPPs</title>

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
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link rel="stylesheet" href="loader.css">

    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

    <script src="js\jquery-3.1.1.min.js"></script> 

   <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<style>

        .tags {
          display: inline;
          position: relative;
        }
        
        .tags:hover:after {
          /*background: rgba(54, 165, 170, .9);*/
          background: rgba(248, 172, 89, .9);*/
          border-radius: 5px;
          bottom: -34px;
          color: #000;
          content: attr(gloss);
          left: 20%;
          padding: 5px 15px;
          position: absolute;
          z-index: 98;
          width: 350px;
        }
        
        .tags:hover:before {
          border: solid;
          border-color: #333 transparent;
          border-width: 0 6px 6px 6px;
          bottom: -4px;
          content: "";
          left: 50%;
          position: absolute;
          z-index: 99;
        }
        
        
        .tags2 {
          display: inline;
          position: relative;
        }
        
        .tags2:hover:after {
          background: #333;
          background: #F8AC59;
          opacity: 0.9;
          border-radius: 5px;
          bottom: -44px;
          color: #000;
          content: attr(gloss);
          left: 20%;
          padding: 5px 15px;
          position: absolute;
          z-index: 98;
          width: 150px;
        }
        
        .tags2:hover:before {
          border: solid;
          border-color: #333 transparent;
          border-width: 0 6px 6px 6px;
          bottom: -4px;
          content: "";
          left: 50%;
          position: absolute;
          z-index: 99;
        }        

    .loader {
      position: relative;
      text-align: center;
      margin: 15px auto 35px auto;
      z-index: 9999;
      display: block;
      width: 80px;
      height: 80px;
      border: 10px solid rgba(0, 0, 0, .3);
      border-radius: 50%;
      border-top-color: #1C84C6;
      animation: spin 1s ease-in-out infinite;
      -webkit-animation: spin 1s ease-in-out infinite;
    }  

    .fondo {
        background:#e9eafb;
        color:#292929;
    }

    .cabecera_tabla {
            background:#e9eafb;
            color:#282828;
            font-weight:bold"
        }

@keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  to {
    -webkit-transform: rotate(360deg);
  }
}

</style>

<script>

$(document).ready(function () {
    $('#menu-epp').attr('class','active');          
    $('.footable').footable();
    $('.footable2').footable();
});

        
    
    function crear_epp(contratista){
      var epp=$('#nombre_epp').val();
      var tipo=$('#tipo_epp').val();
      var marca=$('#marca_epp').val();
      var modelo=$('#modelo_epp').val();      
      
      var formData = new FormData(); 
      var files= $('#archivo')[0].files[0];                   
      formData.append('archivo',files);
      formData.append('epp',epp);
      formData.append('tipo', tipo);
      formData.append('marca', marca);
      formData.append('modelo', modelo );
      formData.append('contratista', contratista );
     
      if (epp!="") {
        if (tipo!="0") {   
            if (marca!="") {
                if (modelo!="") {
                           //alert(contratista+' '+epp+' '+tipo+' '+marca+' '+modelo) 
                       	   $.ajax({
                                    url: 'add/epp.php',
                                    type: 'post',
                                    data:formData,
                                    contentType: false,
                                    processData: false,
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
                                             swal({
                                                 title: "EPP Creado",
                                                 //text: "You clicked the button!",
                                                 type: "success"
                                             });
                                             window.location.href='crear_epp.php';
                                                                          
                                        } else {                                             
                                                swal({
                                                    title: "Disculpe Error de Sistema",
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
                        
                } else {
                    swal({
                        title: "Modelo del EPP",
                        text: "Falta Modelo del EPP",
                        type: "warning"
                        
                    });
                }        
            } else {
                    swal({
                        title: "Marca del EPP",
                        text: "Falta Marca del EPP",
                        type: "warning"
                        
                    });
              }                 
        } else {
            swal({
                title: "Seleccionar Tipo EPP",
                text: "Falta tipo de EPP",
                type: "warning"
                
            });
        }        
    } else {
        swal({
            title: "Nombre del EPP",
            text: "Falta nombre epp",
            type: "warning"                
        });
    }  
}


function borrar_epp(epp,contratista) {
    swal({
        title: "Confirmar Borrar EPP",
        //text: "El nuevo documento sustituye al anterior",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, borrar",
        closeOnConfirm: false
        }, function () {              
            $.ajax({
            method: "POST",
            url: "del/del_epp.php",
            data: 'contratista='+contratista+'&epp='+epp,
            success: function(data){			
                if (data==0)  {
                    swal({
                        title: "EPP ha sido borrado",
                        //text: "Falta nombre epp",
                        type: "success"                
                    });
                    window.location.href='crear_epp.php';
                } else {
                   
                }                
            }
        }); 
            swal("Confirmado, continuar con Seleccion de Archivo", "", "success");
        });
}



</script>

</head>

<body>

  <div id="wrapper">
       <?php include('nav.php'); ?> 


    <div id="page-wrapper" class="gray-bg">
         
      <?php include('superior.php'); ?>
      
      <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">Crear Contrato <?php #echo $_SESSION['mandante'] ?></h2>
                </div>
            </div>
        
        <div class="wrapper wrapper-content animated fadeInRight">           
          
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="form-group row">
                                    <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                       <a class="btn btn-sm btn-success btn-submenu" href="list_contratos.php" class="" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                       <a class="btn btn-sm btn-success btn-submenu" href="gestion_contratos.php" class="" type="button"><i  class="fa fa-chevron-right" aria-hidden="true"></i> Gesti&oacute;n de Contrato</a>
                                    </div>
                            </div>
                            <?php include('resumen.php') ?>
                         
                        </div>
                        <div class="ibox-content">

                            <div class="row">
                                <div class="col-12">                            
                                        

                                        <div class="row"> 
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Nombre del EPP </b></label>                 
                                            <div class="col-lg-5 col-sm-5">
                                                <input style="border:1px solid #969696" class="form-control" type="text" name="nombre_epp" id="nombre_epp" placeholder="" value="" />
                                            </div>                                
                                        </div>
                                        
                                        <div style="padding-top:0.5%" class="row"> 
                                            <label class="col-lg-3 col-form-label fondo"><b>Tipo</b></label>
                                            <div class="col-lg-5 col-sm-9">
                                                <select style="border:1px solid #969696" id="tipo_epp" name="tipo_epp" class="form-control">
                                                <option value="0" selected="">Seleccionar Tipo</option>
                                                <?php
                                                    foreach ($query_tipo_epp as $row){
                                                        echo '<option value="'.$row['id_tipo'].'" >'.$row['nombre_epp'].'</option>';
                                                    }    
                                                ?>     
                                                </select>
                                                
                                            </div>                                
                                        </div>  
                                        
                                        <div style="padding-top:0.5%" class="row">
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Marca </b></label>                                 
                                            <div class="col-lg-5 col-sm-5">
                                                <input style="border:1px solid #969696" class="form-control" type="text" name="marca_epp" id="marca_epp" placeholder="" value="" />
                                            </div>                                
                                        </div>

                                        <div style="padding-top:0.5%" class="row">
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Modelo </b></label>                                 
                                            <div class="col-lg-5 col-sm-5">
                                                <input style="border:1px solid #969696" class="form-control" type="text" name="modelo_epp" id="modelo_epp" placeholder="" value="" />
                                            </div>                               
                                        </div>
                                        
                                                                        
                                        <div style="padding-top:1.5%" style="margin-top:2%" class="row">                                     
                                            <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Documento</b></label>                                     
                                            <div style="" class="col-lg-5 col-sm-5">
                                                    <div style="width: 100%;background: #292929;color:#fff;padding: 1% 0%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento (opcional)</span>
                                                        <span  class="fileinput-exists">Cambiar</span><input  type="file" name="archivo" id="archivo" accept="application/pdf"  /></span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                </div>                    
                                            </div>
                                        </div>
                                    
                                        <div style="margin-top:2%;" class="row">
                                            <div class="col-lg-3 col-sm-12">
                                                <button style="padding:3% 0%;font-size:14px;border-radius:5px"  class="btn btn-success btn-md btn-block" type="button" onclick="crear_epp(<?php echo $_SESSION['contratista'] ?>)"><strong>CREAR EPP</strong></button>
                                            </div>
                                        </div>
                                    
                                </div>                            
                            </div>
                            <hr>
                            <div class="row form-group" >
                                <div class="col-lg-12"> 
                                    <h3 style="color:#282828" class="form-label">Reporte de EPPs</h3>
                                </div>
                            </div>                        
                            <div class="row form-group" >
                            <div class="col-lg-12"> 
                                    <input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un EPP">
                                    <div class="table-responsive">
                                        <table style="100%;"  class="footable table" data-page-size="15" data-filter="#filter">
                                        <thead class="cabecera_tabla">
                                                <tr style="font-size: 12px;">
                                                    <th colspan="2" style="width: 10%;border-right:1px #fff solid;text-align:center" >ACCION</th>
                                                    <th style="width: 20%;border-right:1px #fff solid" >EPP</th>
                                                    <th style="width: 20%;border-right:1px #fff solid" >TIPO</th>
                                                    <th style="width: 15%;border-right:1px #fff solid" >MARCA</th>
                                                    <th style="width: 10%;border-right:1px #fff solid" >MODELO</th>
                                                    <th style="width: 10%;border-right:1px #fff solid" >DOCUMENTO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query=mysqli_query($con,"select t.nombre_epp, e.* from epp as e Left Join tipo_epp as t On t.id_tipo=e.tipo where e.contratista='$contratista' ");
                                                $existe=mysqli_num_rows($query);        
                                                if ($existe>0) {  
                                                    foreach ($query as $row) {                                                         
                                                       
                                                        $fecha=substr($row['creado'],0,10);

                                                        ?>   
                                                        <tr>                                                            
                                                            <td style="background:;text-align: center;" ><button title="Editar EPP" style="width:100%; " title="Documentos" class="btn btn-success btn-xs" type="button" onclick="editar_epp(<?php echo $row['id_epp'] ?>,<?php echo $row['contratista'] ?>,'<?php echo $row['epp'] ?>','<?php echo $row['nombre_epp'] ?>','<?php echo $row['marca'] ?>','<?php echo $row['modelo'] ?>')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>                                                            
                                                            <td style="background:;text-align: center;" ><button title="Borrar EPP" style="width:100%; " title="Documentos" class="btn btn-danger btn-xs"  type="button" onclick="borrar_epp(<?php echo $row['id_epp'] ?>,<?php echo $row['contratista'] ?>,<?php echo $row['tipo'] ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></button></td>                                                                   
                                                            
                                                            <td><?php echo $row['epp'] ?></td>
                                                            <td><?php echo $row['nombre_epp'] ?></td>                                                                
                                                            <td><?php echo $row['marca'] ?></td>                                                                  
                                                            <td><?php echo $row['modelo'] ?></td>
                                                            
                                                            <?php if (empty($row['url_epp'])) { ?>
                                                                    <td>Sin Documento</td>
                                                            <?php } else { ?>
                                                                    <td><a href="<?php echo $row['url_epp'] ?>" target="_BLACK">Documento</a></td>
                                                            <?php } ?>
                                                            
                                                            
                                                        </tr>


                                                <?php
                                                    } 
                                                } else { ?>    

                                                    <td colspan="6">No hay EPPs creados</td>
                                                <?php
                                                }  ?>        
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
                </div>
            </div>
        </div>
        
        <script>
            function editar_epp(epp,contratista,nombre,tipo,marca,modelo) {               
                //$('.body').load('sel/selid_editar_epp.php?epp='+epp+'&contratista='+contratista,function(){
                        $('#modal_editar_epp #nombre_epp_e').val(nombre)
                        $('#modal_editar_epp #tipo_epp_e').val(tipo)
                        $('#modal_editar_epp #marca_epp_e').val(marca)
                        $('#modal_editar_epp #modelo_epp_e').val(modelo)
                        
                        $('#modal_editar_epp').modal({show:true})
                //}); 
            } 

            function seleccionar_cargo(cargo,mandante) {               
                $.ajax({
                    method: "POST",
                    url: "add/seleccionar_cargo.php",
                    data: 'cargo='+cargo+'&mandante='+mandante,
                    success: function(data){
                        if (data==0) {
                            
                        } else {
                            
                        }
                    }                
                });
            } 

            
        </script>
        
                                <div class="modal inmodal" id="modal_editar_epp" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content animated fadeIn">
                                            <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                                <h4  class="modal-title">Editar EPP</h4>
                                            </div>                    
                                            <div class="modal-body">  
                        
                                                <div class="row from-group"> 
                                                    <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Nombre</b></label>                 
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input style="border:1px solid #969696" class="form-control" type="text" name="nombre_epp_e" id="nombre_epp_e" />
                                                    </div>                                
                                                </div>
                                                
                                                <div style="margin-top:1.5%" class="row from-group"> 
                                                    <label class="col-lg-3 col-form-label fondo"><b>Tipo</b></label>
                                                    <div class="col-lg-9 col-sm-9">
                                                        <select style="border:1px solid #969696" id="tipo_epp_e" name="tipo_epp_e" class="form-control">
                                                        <option value="<?php echo $result['id_epp']  ?>" selected=""><?php echo $result['nombre_epp']  ?></option>
                                                        <?php
                                                            foreach ($query_tipo_epp as $row){
                                                                echo '<option value="'.$row['id_tipo'].'" >'.$row['nombre_epp'].'</option>';
                                                            }    
                                                        ?>     
                                                        </select>
                                                        
                                                    </div>                                
                                                </div>  
                                                
                                                <div style="margin-top:1.5%" class="row">
                                                    <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Marca </b></label>                                 
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input style="border:1px solid #969696" class="form-control" type="text" name="marca_epp_e" id="marca_epp_e" placeholder="" value="<?php echo $result['marca']  ?>" />
                                                    </div>                                
                                                </div>

                                                <div style="margin-top:1.5%" class="row">
                                                    <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Modelo </b></label>                                 
                                                    <div class="col-lg-9 col-sm-9">
                                                        <input style="border:1px solid #969696" class="form-control" type="text" name="modelo_epp_e" id="modelo_epp_e" placeholder="" value="<?php echo $result['modelo']  ?>" />
                                                    </div>                               
                                                </div>

                                                <div style="margin-top:1.5%" class="row">
                                                    <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Documento </b></label>                                 
                                                    <div class="col-lg-9 col-sm-9">
                                                        <?php if (empty($result['url_epp'])) { ?>
                                                            <span>SIN DOCUMENTO EPP</span>
                                                        <?php } else { ?>
                                                            <a href="<?php echo $result['url_epp'] ?>" target="_BLACK">Documento EPP</a>
                                                            
                                                        <?php } ?>
                                                    </div>                               
                                                </div>
                                                
                                                                                
                                                <div style="margin-top:4%" style="margin-top:2%" class="row">                                     
                                                    <label class="col-lg-3 col-sm-3 col-form-label fondo"><b>Nuevo</b></label>                                     
                                                    <div style="" class="col-lg-9 col-sm-9">
                                                            <div style="width: 100%;background: #292929;color:#fff;padding: 1% 0%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                                <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento (opcional)</span>
                                                                <span  class="fileinput-exists">Cambiar</span><input  type="file" name="archivo_nuevo" id="archivo_nuevo" accept="application/pdf"  /></span>
                                                                <span class="fileinput-filename"></span>                                                             
                                                                <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                        </div>                    
                                                    </div>
                                                </div>
                                        
                                        </div>  
                            
                                        <div class="modal-footer">
                                            <a style="color: #fff;" class="btn btn-secondary btn-md" data-dismiss="modal" >Cerrar</a>
                                            <button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="editar(<?php echo $_GET['epp'] ?>,<?php echo $_GET['contratista'] ?>)">Editar EPP</button>
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

                                <div class="modal fade" id="modal_cargar222" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                        <div class="modal-body text-center">
                                            <div class="loader"></div>
                                            <h3>Creando Trabajador, por favor espere un momento</h3>
                                        </div>
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
   
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
   
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
