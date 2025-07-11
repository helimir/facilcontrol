<?php
include('sesion_manager.php');
session_start();
if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2  ) { 
    
    
include('config/config.php');
$sql_mandante=mysqli_query($con,"select * from mandantes where rut_empresa='".$_SESSION['usuario']."'  ");
$result=mysqli_fetch_array($sql_mandante);
$mandante=$result['id_mandante'];

$perfiles=mysqli_query($con,"select * from perfiles where estado=1 and id_mandante='$mandante' ");

$contratistas=mysqli_query($con,"Select c.* from contratistas as c LEFT JOIN contratistas_mandantes as d  On d.contratista=c.id_contratista where d.mandante='$mandante' ");
$result_contratista=mysqli_fetch_array($contratistas);
$cargos=mysqli_query($con,"SELECT * from cargos where estado=1");

$query_c=mysqli_query($con,"select  COUNT(*) as total from cargos_asignados where mandante='".$_SESSION['mandante']."' ");
$result_c=mysqli_fetch_array($query_c);

$query_v=mysqli_query($con,"select  COUNT(*) as total from autos_asignados where mandante='".$_SESSION['mandante']."' ");
$result_v=mysqli_fetch_array($query_v);

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes1=date('m');
$year=date('Y');

if (empty($_SESSION['cargos'])) {
    $cont_cargos=0;
} else {
    $cont_cargos=1;
}

if (empty($_SESSION['vehiculos'])) {
    $cont_autos=0;
} else {
    $cont_autos=1;
}



?>
<!DOCTYPE html>
<meta name="google" content="notranslate" /> 
<html lang="es-ES">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Crear Contrato</title>

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

<script src="js\jquery-3.1.1.min.js"></script>

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


$('#menu-contratos').attr('class','active');          

    $("#modal_cargos").on('hidden.bs.modal', function () {
        var mandante=$('#mandante').val();                    
        $.ajax({
            method: "POST",
            url: "add/seleccionar_cargo_2.php",
            data: '&mandante='+mandante,
            success: function(data){
                if (data==1) {
                    document.getElementById("sel_cargos").style.background='#23aba8';
                    document.getElementById("sel_cargos").style.border='1px #23aba8 solid';
                    document.getElementById("sel_cargos").innerHTML='Cargos Seleccionados';
                    document.getElementById("sel_cargos").style.fontWeight='bold';
                } 
            }                
        });                
    });

    $("#modal_vehiculos").on('hidden.bs.modal', function () {
        var mandante=$('#mandante').val();                    
        $.ajax({
            method: "POST",
            url: "add/seleccionar_vehiculo_2.php",
            data: '&mandante='+mandante,
            success: function(data){
                if (data==1) {
                    document.getElementById("sel_autos").style.background='#23aba8';
                    document.getElementById("sel_autos").style.border='1px #23aba8 solid';
                    document.getElementById("sel_autos").innerHTML='Vehículo/Maquinaria Selecionados';
                    document.getElementById("sel_autos").style.fontWeight='bold';
                } 
            }                
        });                
    });
    

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    
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

        function cerrar_cargos() {
            var mandante=$('#mandante').val();                    
            $.ajax({
                method: "POST",
                url: "add/seleccionar_cargo_2.php",
                data: '&mandante='+mandante,
                success: function(data){
                    if (data==1) {
                        document.getElementById("sel_cargos").style.background='#23aba8';
                        document.getElementById("sel_cargos").style.border='1px #23aba8 solid';
                        document.getElementById("sel_cargos").innerHTML='Cargos Seleccionados';
                        document.getElementById("sel_cargos").style.fontWeight='bold';
                        $("#modal_cargos").modal('hide');
                    } else {
                        $("#modal_cargos").modal('hide');
                    }
                }                
            });            
        };

        function cerrar_autos() {
            var mandante=$('#mandante').val();                    
            $.ajax({
                method: "POST",
                url: "add/seleccionar_vehiculo_2.php",
                data: '&mandante='+mandante,
                success: function(data){
                    if (data==1) {
                        document.getElementById("sel_autos").style.background='#23aba8';
                        document.getElementById("sel_autos").style.border='1px #23aba8 solid';
                        document.getElementById("sel_autos").innerHTML='Vehículo/Maquinaria Selecionados';
                        document.getElementById("sel_autos").style.fontWeight='bold';
                        $("#modal_vehiculos").modal('hide');
                    } else {
                        $("#modal_vehiculos").modal('hide');
                    }
                }                
            });            
        };
       
    
    function activar() {
      $('#btnsel').css("display","block")
    };
            
    
    function refresh_contrato(){
        window.location.href='list_contratos.php';
    };
    
    function crear_contrato(){
      
      var arreglo_cargos=[];
      var arreglo_vehiculos=[];
      var contratista=$('#seleccion').val();
      var mandante=$('#mandante').val();
      var nombre_contrato=$('#nombre_contrato').val();
      var cantidad=$('#cant_cargos').val();
      var accion=$('#accion').val();
        
      var i=0;
      var chequeado=false;  
      for (i=0;i<=cantidad-1;i++) {
          if ( $('#cargo_perfil'+i).prop('checked') ) {
            var chequeado=true;
            var valor_cargos=$('#cargo_perfil'+i).val();
            arreglo_cargos.push(valor_cargos);
          } 
          if ( $('#vehiculos_perfil'+i).prop('checked') ) {
            var chequeado_v=true;
            var valor_vehiculos=$('#vehiculos_perfil'+i).val();
            arreglo_vehiculos.push(valor_vehiculos);
          } 
      }    
      
      var fileInput = document.getElementById('archivo');
      var filePath = fileInput.value;
      var allowedExtensions = /(.pdf)$/i;
      if(!allowedExtensions.exec(filePath)){
        var extension=0;
      } else {
        var extension=1;
      }
      
      //alert(extension);
      var haycontrato=(allowedExtensions.exec(filePath));
      //alert(haycontrato);
      var cargos=JSON.stringify(arreglo_cargos);
      var vehiculos=JSON.stringify(arreglo_vehiculos);
      
      var formData = new FormData(); 
      var files= $('#archivo')[0].files[0];                   
      formData.append('archivo',files);
      formData.append('contratista',contratista);
      formData.append('nombre_contrato', nombre_contrato );
      formData.append('mandante', mandante );
      formData.append('cargos', cargos );
      formData.append('vehiculos', vehiculos );
      formData.append('accion', accion );
     
      if (nombre_contrato!="") {
        if (contratista!="0") {   
            if (chequeado==true) {
                if (chequeado_v==true) {
                        if (nombre_contrato!="") {
                       	   $.ajax({
                                    url: 'add/contratos.php',
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
                                                 title: "Contrato Creado",
                                                 //text: "You clicked the button!",
                                                 type: "success"
                                             });
                                             window.location.href='list_contratos.php';
                                                                          
                                          } else {
                                             if (data==1) { 
                                                    swal({
                                                        title: "Contrato No Creado",
                                                        text: "Vuelva a Intentar",
                                                        type: "success"
                                                    });
                                             }
                                             if (data==2) { 
                                                    swal({
                                                        title: "Contrato Actualizado",
                                                        //text: "You clicked the button!",
                                                        type: "success"
                                                    });
                                             }  
                                             if (data==3) { 
                                                    swal({
                                                        title: "Contrato No Actualizado",
                                                        text: "Vuelva a Intentar",
                                                        type: "success"
                                                  });
                                             }     
                                             if (data==4) { 
                                                    swal({
                                                        title: "Contrato Actualizado",
                                                        text: "Documento No Cargado. Vuelva a intentar",
                                                        type: "warning"
                                                  });     
                                             }  
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
                                    title: "Nombre del Contrato",
                                    text: "Debe colocar un nombre",
                                    type: "warning"
                                    
                                });
                        }
                } else {
                    swal({
                        title: "Vehiculos/Maquinaria del Contrato",
                        text: "Debe seleccionar al menos un cargo",
                        type: "warning"
                        
                    });
                }        
            } else {
                    swal({
                        title: "Cargos del Contrato",
                        text: "Debe seleccionar al menos un cargo",
                        type: "warning"
                        
                    });
              }                 
        } else {
            swal({
                title: "Seleccionar Contratista",
                text: "Debe seleccionar una Contratista",
                type: "warning"
                
            });
        }        
    } else {
        swal({
            title: "Nombre del Contrato",
            text: "Escribir nombre al contrato",
            type: "warning"                
        });
    }  
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
                            
                                        <form  method="post" id="frmContratos" action="" enctype="multipart/form-data">

                                        <div class="row"> 
                                            <label class="col-3 col-form-label fondo"><b>Nombre del Contrato </b></label>                 
                                            <div class="col-5">
                                            <input style="border:1px solid #969696" class="form-control" type="text" name="nombre_contrato" id="nombre_contrato" placeholder="" value="" />
                                            </div>                                
                                        </div>
                                        
                                        <div style="padding-top:0.5%" class="row"> 
                                            <label class="col-3 col-form-label fondo"><b>Contratista</b></label>
                                            <div class="col-5">
                                                <select style="border:1px solid #969696" id="seleccion" name="contratista" class="form-control">
                                                <option value="0" selected="">Seleccionar Contratista</option>
                                                <?php
                                                    foreach ($contratistas as $row){
                                                        echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                    }    
                                                ?>     
                                                </select>
                                                
                                            </div>                                
                                        </div>  
                                        
                                        <div style="padding-top:0.5%" class="row">
                                            <label class="col-3 col-form-label fondo"><b>Cargos <a class="tags" gloss="Seleccionar todos los cargos que seran parte de la ejecución del contrato, como referencia deben ser como mínimo todos los cargos que aparecen en la matriz de riesgo "><sup  ><i style="font-size: 14px;" class="fa fa-info-circle" aria-hidden="true"></i></sup></a> </b></label>                                 
                                            <div class="col-5">
                                                <?php if ($result_c['total']>0) { ?>
                                                        <button style="background:#23aba8;border:1px #23aba8 solid" id="sel_cargos" class="btn btn-success btn-block" type="button" onclick="cargos()"><strong>Cargos Seleccionados</strong></button>
                                                <?php } else { ?>
                                                        <button id="sel_cargos" class="btn btn-success btn-block" type="button" onclick="cargos()"><strong>Seleccionar Cargos</strong></button>
                                                <?php }  ?>
                                            </div>                                
                                        </div>

                                        <div style="padding-top:0.5%" class="row">
                                            <label class="col-3 col-form-label fondo"><b>Vehículos/Maquinarias <a class="tags" gloss="Seleccionar todos los cargos que seran parte de la ejecución del contrato, como referencia deben ser como mínimo todos los cargos que aparecen en la matriz de riesgo "><sup  ><i style="font-size: 14px;" class="fa fa-info-circle" aria-hidden="true"></i></sup></a> </b></label>                                 
                                            <div class="col-5">
                                                    <?php if ($result_v['total']>0) { ?>
                                                            <button style="background:#23aba8;border:1px #23aba8 solid" id="sel_autos" class="btn btn-success btn-block" type="button" onclick="vehiculos()"><strong>Vehículo/Maquinarias Seleccionados</strong></button>
                                                    <?php } else { ?>
                                                            <button id="sel_autos" class="btn btn-success btn-block" type="button" onclick="vehiculos()"><strong>Seleccionar Vehículo/Maquinarias</strong></button>
                                                    <?php }  ?>
                                            </div>                                
                                        </div>
                                        
                                                                        
                                        <div style="padding-top:1.5%" style="margin-top:2%" class="row">                                     
                                            <label class="col-3 col-form-label fondo"><b>Adjuntar Respaldo del Contrato (solo PDF <i class="fa fa-file-pdf-o" aria-hidden="true"></i> )</b></label>                                     
                                            <div style="" class="col-5">
                                                    <div style="width: 100%;background: #292929;color:#fff;padding: 1% 0%"  class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span  style="background: #282828;color: #000;border:#282828;color:#fff" class="btn btn-default btn-file"><span class="fileinput-new"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Seleccione Documento (opcional)</span>
                                                        <span  class="fileinput-exists">Cambiar</span><input  type="file" name="archivo" id="archivo" accept="application/pdf"  /></span>
                                                        <span class="fileinput-filename"></span>                                                             
                                                        <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                </div>                    
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="crearcontrato" id="crearcontrato" value="crear" />
                                        <input type="hidden" name="mandante" id="mandante" value="<?php echo $mandante ?>" />
                                        <input type="hidden" name="accion" id="accion" value="crear_contrato" />
                                        
                                    
                                        <div style="margin-top:2%;padding: 0.5% 0%;border-radius:5px;border:1px #c0c0c0 solid" class="row">
                                            <div class="col-3">
                                                <button style="padding:3% 0%;font-size:14px;border-radius:5px"  class="btn btn-success btn-md btn-block" name="crear" type="button" onclick="crear_contrato()"><strong>CREAR NUEVO CONTRATO</strong></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        
        <script>
            function cargos() {               
                    $('#modal_cargos').modal({show:true})
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

            function seleccionar_vehiculo(vehiculo,mandante) {        
                $.ajax({
                    method: "POST",
                    url: "add/seleccionar_vehiculo.php",
                    data: 'vehiculo='+vehiculo+'&mandante='+mandante,
                    success: function(data){
                        if (data==0) {
                            
                        } else {
                            
                        }
                    }                
                });
            } 
            
            function vehiculos() {               
               $('#modal_vehiculos').modal({show:true})
            } 
        </script>
        
        <div class="modal fade" id="modal_cargos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Seleccionar Cargos del Contrato</br><small>Para cargos que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span></small></h3>
                        <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <?php

                    session_start();
                    include('config/config.php');
                    $query=mysqli_query($con,"select * from cargos order by cargo asc ");
                    
                    
                    ?>        
                    <form method="post" id="frmCargos">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        <?php $i=0; foreach ($query as $row) {    
                                               $query_cargo=mysqli_query($con,"select  COUNT(*) as total from cargos_asignados where mandante='".$_SESSION['mandante']."' and cargo='".$row['idcargo']."' "); 
                                               $result=mysqli_fetch_array($query_cargo); ?>
                                            <tr>                            
                                                <?php if ($result['total']>0) { ?>
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="cargo_perfil<?php echo $i ?>" name="cargos[]" type="checkbox" value="<?php echo $row['idcargo'] ?>" onclick="seleccionar_cargo(this.value,<?php echo $_SESSION['mandante'] ?>)" checked /> </div></td>
                                                <?php } else { ?>
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="cargo_perfil<?php echo $i ?>" name="cargos[]" type="checkbox" value="<?php echo $row['idcargo'] ?>" onclick="seleccionar_cargo(this.value,<?php echo $_SESSION['mandante'] ?>)" /> </div></td>
                                                <?php } ?>
                                                <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['cargo'] ?></label></td>
                                            </tr>
                                        <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>                    
                            </div>
                        
                    </div>
                    <input type="hidden" id="cant_cargos" value="<?php echo $i ?>" />   
                    
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="cerrar_cargos()">Aplicar Selección</button>
                        <!--<button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_cargos()">Seleccionar Cargos</button>-->
                    </div>
                    </form>    
                    <script>
                        function asignar_cargos() {
                           var valores=$('#frmCargos').serialize();
                           //alert(valores);
                          $.ajax({
                    			method: "POST",
                                url: "sesion/session_cargos.php",
                                data: valores,
                    			success: function(data){
                    			     $('#modal_cargos').modal('hide') 
                                     document.getElementById("sel_cargos").style.background='#23aba8';
                                     document.getElementById("sel_cargos").style.border='1px #23aba8 solid';
                                     document.getElementById("sel_cargos").innerHTML='Cargos Seleccionados';
                                     document.getElementById("sel_cargos").style.fontWeight='bold';
                    			}                
                            });
                        }
                    </script>                 
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal_vehiculos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div  class="modal-content">
                    <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-chevron-right" aria-hidden="true"></i> Seleccionar Vehiculos/Maquinarias</br><small>Para vehiculos/maquinarias que no se encuentre la lista favor comunicarte con <span style="color: #F8AC59;font-weight: bold;">soporte@facilcontrol.cl</span></small></h3>
                        <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                    </div>
                    <?php

                    session_start();
                    include('config/config.php');
                    $query=mysqli_query($con,"select * from  tipo_autos order by auto asc ");
                    
                    
                    ?>        
                    <form method="post" id="frmVehiculo">     
                    <div class="modal-body">
                          
                            <div style="overflow-y: auto;" class="row">
                               <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height: 380px;overflow-y:scroll">
                                    <table class="table" >
                                        <tbody>
                                        <?php $i=0; foreach ($query as $row) {    
                                             $query_cargo=mysqli_query($con,"select  COUNT(*) as total from autos_asignados where mandante='".$_SESSION['mandante']."' and vehiculo='".$row['id_ta']."' "); 
                                             $result=mysqli_fetch_array($query_cargo); ?> 
                                            <tr>                            
                                                <?php if ($result['total']>0) { ?>
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="vehiculos_perfil<?php echo $i ?>" name="vehiculos[]" type="checkbox" value="<?php echo $row['id_ta'] ?>" onclick="seleccionar_vehiculo(this.value,<?php echo $_SESSION['mandante'] ?>)" checked /> </div></td>
                                                <?php } else { ?>
                                                    <td style="width: 2%;"><div class=""> <input class="form-control" id="vehiculos_perfil<?php echo $i ?>" name="vehiculos[]" type="checkbox" value="<?php echo $row['id_ta'] ?>" onclick="seleccionar_vehiculo(this.value,<?php echo $_SESSION['mandante'] ?>)" /> </div></td>
                                                <?php } ?>
                                                
                                                <td class="text-rigth" style="width: 20%;"><label class="col-form-label"><?php echo $row['auto'] ?></label></td>
                                            </tr>
                                        <?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>                    
                            </div>
                    </div>
                    <input type="hidden" id="cant_cargos" value="<?php echo $i ?>" />   
                    <div class="modal-footer">                        
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal" onclick="cerrar_autos()">Aplicar Selección</button>
                        <!--<button style="color: #fff;" class="btn btn-success btn-md" type="button" name="asignar" onclick="asignar_vehiculos()">Seleccionar Vehiculos/Maquinarias</button>-->
                    </div>
                    </form>    
                    <script>
                        function asignar_vehiculos() {
                           var valores=$('#frmVehiculo').serialize();
                           //alert(valores);
                          $.ajax({
                    			method: "POST",
                                url: "sesion/session_vehiculos.php",
                                data: valores,
                    			success: function(data){
                    			     $('#modal_vehiculos').modal('hide') 
                                     document.getElementById("sel_autos").style.background='#23aba8';
                                     document.getElementById("sel_autos").style.border='1px #23aba8 solid';
                                     document.getElementById("sel_autos").innerHTML='Vehículo/Maquinaria Seleecionados';
                                     document.getElementById("sel_autos").style.fontWeight='bold';
                    			}                
                            });
                        }
                    </script>                 
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
    
       <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>
   
</body>

</html><?php } else { 

echo '<script> window.location.href="admin.php"; </script>';
}

?>
