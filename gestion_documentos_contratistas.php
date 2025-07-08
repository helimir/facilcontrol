<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario']) and $_SESSION['nivel']==2) { 
include('config/config.php');

$query_gestion_doc_contratista=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='1' order by n.idnoti desc    ");
$cant_gestion_doc_contratista=mysqli_num_rows($query_gestion_doc_contratista);

$query_gestion_doc_trabajador=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='2' order by n.idnoti desc    ");
$cant_gestion_doc_trabajador=mysqli_num_rows($query_gestion_doc_trabajador);

$query_gestion_doc_vehiculo=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='3' order by n.idnoti desc    ");
$cant_gestion_doc_vehiculo=mysqli_num_rows($query_gestion_doc_vehiculo);

$query_gestion_doc_mensuales=mysqli_query($con,"select n.*, m.razon_social as remitente from notificaciones as n left join mandantes as m On m.id_mandante=n.recibe where m.rut_empresa='".$_SESSION['usuario']."' and procesada=0 and tipo='4' order by n.idnoti desc    ");
$cant_gestion_doc_mensuales=mysqli_num_rows($query_gestion_doc_mensuales);


setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');

$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];

//$contratistas=mysqli_query($con,"SELECT c.* from contratistas as c Left Join mandantes as m On m.id_mandante=c.mandante left join contratistas_mandantes as d On d.mandante=m.id_mandante where m.rut_empresa='".$_SESSION['usuario']."' group by c.id_contratista ");
$contratistas=mysqli_query($con,"select c.* from contratistas as c LEFT JOIN contratistas_mandantes as m ON m.contratista=id_contratista where m.mandante='".$_SESSION['mandante']."'");
$num_c=mysqli_num_rows($contratistas);

$query_contratista=mysqli_query($con,"select d.cant_doc, d.doc_contratista, d.acreditada, c.*, m.estado as habilitado from contratistas as c left join mensuales as m On m.contratista=c.id_contratista left join contratistas_mandantes as d On d.contratista=c.id_contratista where d.mandante='$mandante' and c.id_contratista='$contratista' ");
$result_contratista=mysqli_fetch_array($query_contratista); 

$acreditada=$result_contratista['acreditada'];

$doc=unserialize($result_contratista['doc_contratista']);
$doc_mensuales=unserialize($result_contratista['doc_contratista_mensuales']);


$query_obs=mysqli_query($con,"select * from doc_observaciones where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs=mysqli_fetch_array($query_obs);
$list_veri=unserialize($result_obs['verificados']);

$query_obs_m=mysqli_query($con,"select * from mensuales where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs_m=mysqli_fetch_array($query_obs_m);
$list_veri_m=unserialize($result_obs_m['verificados']);

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FacilControl | Documentos Contratisya</title>
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

    
<script>

function selcontratista(id,mandanate){
    //alert(id); 
    if (id==0) {
        swal({
            title: "Selecciona una Contratista a consultar",
            //text: "Un Documento no validado esta sin comentario",
            type: "warning"
         });  
    } else {
        $.post("sesion/doc_contratos.php", { id: id }, function(data){
            window.location.href='gestion_documentos_contratistas.php';
        }); 
    }    
} 

 function deshabilitar(i) {
        var isChecked = $('#verificar_doc'+i).prop('checked');
        if  (isChecked) {
             //document.getElementById("mensaje"+i).value ="";
            //document.getElementById("mensaje"+i).disabled = true;
             $("#mensaje"+i).attr("readonly","readonly");
        } else {
            //document.getElementById("mensaje"+i).disabled = false;
            $("#mensaje"+i).removeAttr("readonly");
        }    
 }
 
function deshabilitar_m(i) {
        var isChecked = $('#verificar_doc_m'+i).prop('checked');
        if  (isChecked) {
             $("#mensaje_m"+i).attr("readonly","readonly");
        } else {
            $("#mensaje_m"+i).removeAttr("readonly");
        }    
 }
       
 function enviar(total) {
        var control=$('#control').val();
        var arreglo=[];
        var arreglo2=[];
        var arreglo3=[];
         var arreglo_est=[];
        var falta_revisar=false;
        var no_chequeado=0;
        var mensaje=0;
        for (i=0;i<=total-1;i++) {
            //si verificado esta seleccionado
            var isChecked = $('#verificar_doc'+i).prop('checked');
            if (isChecked) {
                var valor=document.getElementById("verificar_doc"+i).value = "1";
                var valor2=$('#mensaje'+i).val();
                arreglo.push(valor);
                arreglo2.push(valor2);
                
                var valor3=$('#doc'+i).val();
                arreglo3.push(valor3); 
                
                if (valor2!='') {
                    mensaje++;
                }
                
            } else {
                var valor=document.getElementById("verificar_doc"+i).value = "0";
                var valor2=$('#mensaje'+i).val();
                var isDisabled = $('#verificar_doc'+i).prop('disabled');
                //if (valor==0 && valor2=="" && isDisabled==false) {
                if (valor==0) {
                    var falta_revisar=true;
                }
                var valor3=$('#doc'+i).val();
                arreglo3.push(valor3); 
                
                arreglo.push(valor);
                arreglo2.push(valor2);
            
                no_chequeado++;
                
                if (valor2!='') {
                    mensaje++;
                }
                
            }
            
        }
        
        if (no_chequeado==total && mensaje==0) { 
            swal({ 
                title:"Seleccionar al menos un Documentos o Enviar una Observacion.",
                //text: "Debe selecionar al menos un documento",
                type: "warning"
            });          
        
        } else {    
                // verificados         
                var json=JSON.stringify(arreglo);
                // com
                var json2=JSON.stringify(arreglo2);
                //doc
                var json3=JSON.stringify(arreglo3);
                // estado
                var json4=JSON.stringify(arreglo_est);
                
                $.ajax({
      			    method: "POST",
                    url: "enviar_observacion_doc.php",
         		    data: {data:json,data2:json2,data3:json3,estado:json4},
                    cache: false,
          			beforeSend: function(data){                       
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
          			success: function(data) { 
                         $('#modal_cargar').modal('hide');
                         if (data==0) {
           	                
                            // si faltan documentos por revisar
                            if (falta_revisar==true) {
                                swal({
                                    title: "Documentos Procesados",
                                    //text: "Documentos sin validar",
                                    type: "success"
                                });
                                setTimeout(function(){
                                    window.location.href='gestion_documentos_contratistas.php' 
                                },2000); 
                            // si todos esta revisados
                            } else {
                                swal({
                                    title: "Todos los Documentos Validados.",
                                    //text: "Todos han sido validados",
                                    type: "success"
                                });
                                setTimeout(function(){
                                    window.location.href='gestion_documentos_contratistas.php' 
                                },2000); 
                            }               
                         } 
                         if (data==1) {
                              swal({ 
                                    title: "Error de Sistema",
                                    text: "Por favor Vuelva a intentar",
                                    type: "error"
                               });
                         }
                     },
                     complete:function(data){
                        $('#modal_cargar').modal('hide');
                        
                     }, 
                     error: function(data){
                        alert(data);
                        $('#modal_cargar').modal('hide');
                     }
                }); 
          } 
            
      }
      
    function enviar_mensuales(total) {        
        var arreglo=[];
        var arreglo2=[];
        var arreglo3=[];
        var falta_revisar=false;
      
        for (i=0;i<=total-1;i++) {
            //si verificado esta seleccionado
            var isChecked = $('#verificar_doc_m'+i).prop('checked');
            if (isChecked) {
                var valor=document.getElementById("verificar_doc_m"+i).value = "1";
                var valor2=$('#mensaje_m'+i).val();
                arreglo.push(valor);
                arreglo2.push(valor2);
                
                var valor3=$('#doc_m'+i).val();
                arreglo3.push(valor3);
             
            } else {
                var valor=document.getElementById("verificar_doc_m"+i).value = "0";
                var valor2=$('#mensaje_m'+i).val();
                var isDisabled = $('#verificar_doc_m'+i).prop('disabled');
                if (valor==0) {
                    var falta_revisar=true;
                }
                var valor3=$('#doc_m'+i).val();
                arreglo3.push(valor3); 
                
                arreglo.push(valor);
                arreglo2.push(valor2);
                
            }
            
        }
        
            var json=JSON.stringify(arreglo);
            var json2=JSON.stringify(arreglo2);
            var json3=JSON.stringify(arreglo3);
            $.ajax({
  			    method: "POST",
                url: "add/enviar_observacion_doc_mensuales.php",
     		    data: {data:json,data2:json2,data3:json3},
                cache: false,
                beforeSend: function(){
                    $('#modal_cargar_mensuales').modal('show');						
      			},
      			success: function(data){
    	            if (data==0) {
    	                
                        if (falta_revisar==true) {
                            swal({
                                    title: "Procesado",
                                    text: "Documentos sin validar",
                                    type: "warning"
                             });
                              setTimeout(function(){
                                window.location.href='gestion_documentos_contratistas.php' 
                             },2000); 
                        } else {
                            swal({
                                    title: "Procesado",
                                    text: "Documentos validados",
                                    type: "success"
                             });
                              setTimeout(function(){
                                window.location.href='gestion_documentos_contratistas.php' 
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
                                window.location.href='gestion_documentos_contratistas.php' 
                             },2000); 
                        } else {
                           //alert('aqui');  
                           swal({
                                    title: "Actualizado",
                                    text: "Documentos validados",
                                    type: "success"
                             });
                             setTimeout(function(){
                                window.location.href='gestion_documentos_contratistas.php' 
                             },2000); 
                       }      
                    }                
      			},
                complete:function(data){
                    $('#modal_cargar_mensuales').modal('hide');
                }, 
                error: function(data){
                } 
            });
      }   
      
   function poner_cero(id){
      $("#verificar_doc"+id).prop('checked', true);
      document.getElementById("verificar_doc"+id).value = "0";
      
   }      
   
   $(document).ready(function() {

            $('#menu-tareas').attr('class','active');
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

</script>

   <style>
        .estilo {
            display: inline-block;
        	content: "";
        	width: 20px;
        	height: 20px;
        	margin: 0.5em 0.5em 0 0;
            background-size: cover;
        }
        .estilo:checked  {
        	content: "";
        	width: 20px;
        	height: 20px;
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

</head>



<body>

    <div id="wrapper">

        <?php include('nav.php') ?>

        <div id="page-wrapper" class="gray-bg">
       
           <?php include('superior.php') ?> 
        
       
            <div style="" class="row wrapper white-bg ">
                <div class="col-lg-10">
                    <h2 style="color: #010829;font-weight: bold;">DOCUMENTOS CONTRATISTA <?php  ?></h2>
                </div>
            </div>
      
        <div class="wrapper wrapper-content animated fadeIn">
        
        
               
               
             <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                             <div class="form-group row">
                               <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                       <a style="background: #E957A5;border: #E957A5" class="btn btn-sm btn-success" href="list_contratistas_mandantes.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratistas</a>
                                       <a style="background: #E957A5;border: #E957A5" class="btn btn-sm btn-success" href="list_contratos.php" class="" ><i class="fa fa-chevron-right" aria-hidden="true"></i> Reporte de Contratos</a>
                                       
                                 </div>
                              </div>  
                              
                              <?php include('resumen.php') ?>
                                   
                        </div>   
                        
                        
                        <div class="ibox-content">
                       
                            <div class="row">
                              <div class="col-12">
                                
                                <!-- select de contratistas --> 
                                <div class="row">                                                                    
                                    <label class="col-2 col-form-label fondo"><b>Contratista</b></label>
                                    <div class="col-sm-6">   
                                       <?php 
                                          
                                          if ($num_c>1) { ?>
                                            <select name="contratista" id="contratista" class="form-control"  onchange="selcontratista(this.value)">
                                                <?php                                           
                                                    if ($_SESSION['doc_contratista']=="") {
                                                        echo '<option value="0" selected="" >'.$result_contratista['razon_social'].'</option>';
                                                    } else {
                                                        $query=mysqli_query($con,"select * from contratistas where id_contratista='".$_SESSION['doc_contratista']."' ");
                                                        $result=mysqli_fetch_array($query);
                                                        echo '<option value="" selected="" >'.$result['razon_social'].'</option>';
                                                        echo '<option value="0" >Seleccionar Contratista</option>';
                                                    }                                           
                                                    foreach ($contratistas as $row) {
                                                        echo '<option value="'.$row['id_contratista'].'" >'.$row['razon_social'].'</option>';
                                                    }                                                
                                            } else {  ?>
                                            
                                            <label  class="col-form-label"><?php echo $result_contratista['razon_social'] ?></label>  
                                            
                                      <?php }   ?>                                           
                                            </select>
                                    </div> 
                                </div>   
                                                          
                                                                      
                                <div style="padding-top:0.5%" class="row">
                                    <label  class="col-2 col-form-label fondo"><b>RUT</b></label>
                                    <div class="col-sm-2"><label class="col-form-label"><?php echo $result_contratista['rut']?></label></div>
                                </div>
                                
                                <div style="padding-top:0.5%" class="row">
                                    <label class="col-2 col-form-label fondo"><b> Estado</b></label>
                                    <div style="" class="col-3">
                                        <?php if ($result_contratista['acreditada']==1) { ?> 
                                                <label class="col-form-label font-bold badge badge-success">ACREDITADA</label>
                                        <?php } else { ?>
                                                <label class="col-form-label font-bold badge badge-danger">NO ACREDITADA</label>
                                        <?php } ?>       
                                    </div>
                                </div>
                                
                                <?php if ($result_contratista['acreditada']==1) { ?> 
                                        <div  style="padding-top:0.5%" class="row">
                                            <label class="col-2 col-form-label fondo"><b>Documentos</b></label>
                                            <?php 
                                                $url ='doc/validados/'.$mandante.'/'.$_SESSION['contratista'].'/zip/';
                                                        if ($result_contratista['cant_doc']>0) { ?>   
                                                            <div style="padding-top:0.5%" class="col-sm-6"><a class="font-bold" href="descargar.php?url=<?php echo $url ?>&rut=<?php echo $result_contratista['rut'] ?>" ><u>Descargar Documentos</u></a></label></div>
                                                <?php  } else { ?>
                                                            <div class="col-sm-10"><label class="col-form-label font-bold">Sin documentos</label></div>
                                                <?php  }  ?>     
                                        </div>
                                 
                                <?php }
                                
                                    if ($acreditada!=1) { ?>

                                        <div style="margin-top: 2%;" class="row"> 
                                            <div class="col-12">                       
                                                        <form  method="post" id="frmObs">                   
                                                                <div class="row">                            
                                                                        <!--<input class="form-control form-control-sm m-b-xs" id="filter" placeholder="Buscar un Trabajador">-->
                                                                    <div class="table table-responsive">  
                                                                        <table class="table table-stripped">
                                                                        <thead class="cabecera_tabla">
                                                                            <tr>
                                                                                <!--<th style="width: 2%;border-right:1px #fff solid" >Cargado</th>-->
                                                                                <th style="width: 30%;border-right:1px #fff solid">Documentos para Revisi&oacute;n</th>
                                                                                <th style="width: 5%;text-align: center;border-right:1px #fff solid">Verificado</th>
                                                                                <th style="width: 20%;border-right:1px #fff solid">Observaciones</th>
                                                                                <th style="width: 10%;text-align: center;">Estado</th>
                                                                                
                                                                            </tr>
                                                                            </thead>
                                                                            
                                                                        <tbody>
                                                                            
                                                                            <?php          
                                                                                $i=0; 
                                                                                $cont_veri=0;
                                                                                $cont_doc=0;
                                                                                $estado=array();
                                                                                foreach ($doc as $row) {
                                                                                    $cont_doc=$cont_doc+1;
                                                                                    
                                                                                    $sql=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$row' ");  
                                                                                    $result=mysqli_fetch_array($sql);    
                                                                                    
                                                                                    //$sql2=mysqli_query($con,"select * from doc_observaciones where contratista='$contratista' and mandante='$mandante' and documento='$row' ");
                                                                                    //$result2=mysqli_fetch_array($sql2);   
                                                                                    
                                                                                    $query_com=mysqli_query($con,"select * from doc_comentarios where id_dobs='".$result_obs['id_dobs']."' and doc='".$result['documento']."' and estado=0 order by id_dcom desc ");
                                                                                    $result_com=mysqli_fetch_array($query_com);
                                                                                    $list_com=($result_com['comentarios']);

                                                                                    $query_d=mysqli_query($con,"select * from doc_subidos_contratista where id_documento='$row' and mandante='$mandante' and contratista='$contratista' ");
                                                                                    $result_d=mysqli_fetch_array($query_d);

                                                                                    $query_noaplica=mysqli_query($con,"select * from noaplica where documento='$row' and contratista='$contratista' and mandante='$mandante' ");
                                                                                    $resul_noaplica=mysqli_num_rows($query_noaplica);
                                                                                    
                                                                                
                                                                                    if ($result_contratista['acreditada']==1) {
                                                                                            $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$result_contratista['rut'].'.pdf';
                                                                                    } else { 
                                                                                        $carpeta_e=file_exists($result_d['url']);
                                                                                        $carpeta=$result_d['url'];
                                                                                        
                                                                                    
                                                                                    }  
                                                                                                        
                                                                                    if ($carpeta_e) {
                                                                                        $archivo_existe=TRUE;
                                                                                    } else {
                                                                                        $archivo_existe=FALSE;
                                                                                    }
                                                                                    
                                                                                    
                                                                                    
                                                                                    # si el archivo existe
                                                                                    if ($archivo_existe) {   ?>
                                                                                    
                                                                                    <tr>
                                                                                        <!--<td style="text-align:center"><i style="color: #000080;font-size: 20px;" class="fa fa-file" aria-hidden="true"></i></td>-->
                                                                                        
                                                                                        <?php if ($resul_noaplica>0) { ?>
                                                                                            <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?>&nbsp;&nbsp;<small><label style="border-radius:5px;color:#000;padding: 0% 3%" class="badge-warning">&nbsp;NO APLICA&nbsp;</label><small></a></td>
                                                                                        <?php } else { ?>
                                                                                            <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>
                                                                                        <?php } ?>
                                                                                        
                                                                                        <input type="hidden" id="doc<?php echo $i ?>" value="<?php echo $result['documento'] ?>" />
                                                                                    
                                                                                    <?php # verificacion 0
                                                                                            if ($list_veri[$i]==0 ) { ?>
                                                                                                <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>" onclick="deshabilitar(<?php echo $i ?>) "  /></td>
                                                                                                <td>
                                                                                                    <div class="btn-group"> 
                                                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" ><?php echo $list_com ?></textarea>
                                                                                                        <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row ?>,<?php echo $result_obs['id_dobs'] ?>,0)"><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                                    </div>
                                                                                                </td>
                                                                                            <?php  if  ($result_com['doc']==$result['documento']) {        
                                                                                                        if ($result_com['leer_mandante']==1 and $result_com['leer_contratista']==1) { 
                                                                                                            $estado='2'; ?>
                                                                                                            <td style="text-align:center;font-size:14px"><div class="bg-info p-xxs"><b>EN PROCESO</b></div></td>
                                                                                                <?php  }     
                                                                                                        if ($result_com['leer_mandante']==0 and $result_com['leer_contratista']==0) { 
                                                                                                            $estado='3'; ?>
                                                                                                            <td style="text-align:center;font-size:14px"><div class="bg-info p-xxs"><b>OBSERVACION</b></div></td>
                                                                                                <?php  }     
                                                                                                } else { 
                                                                                                            $estado='4';?>
                                                                                                            <td style="text-align:center;font-size:14px"><div style="color: #FFFFFF;" class="bg-info p-xxs"><b>RECIBIDO</b></div></td>
                                                                                            <?php    }
                                                                                        
                                                                                        # verificacion 1
                                                                                        } else {
                                                                                                $estado='5';
                                                                                                $cont_veri=$cont_veri+1;
                                                                                                // si trabajador esta verificado deshabilitar checkbos verificacion
                                                                                                if ($result_contratista['acreditada']!=1) { ?>
                                                                                                    <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>"  checked="" disabled="" onclick="deshabilitar(<?php echo $i ?>)" /></td>
                                                                                        <?php } else { ?>
                                                                                                    <td style="text-align: center;"><input class="estilo" type="checkbox" name="verificar[]" id="verificar_doc<?php echo $i ?>"  checked="" disabled="" /></td>
                                                                                        <?php } ?>
                                                                                        
                                                                                                <td>
                                                                                                    <div class="btn-group"> 
                                                                                                        <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly="" ></textarea>
                                                                                                        <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" onclick="modal_ver_obs(<?php echo $row ?>,<?php echo $result_obs['id_dobs'] ?>,0)" ><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                                    </div>
                                                                                                </td>
                                                                                                <td style="text-align:center;font-size:14px"><div class="bg-success p-xxs"><b>VALIDADO</b></div></td>
                                                                                                
                                                                                        <?php }
                                                                                            
                                                                                    
                                                                                    # si archi no existe       
                                                                                    } else { 
                                                                                            $estado='1';?>
                                                                                                <!--<td style="text-align:center"><i style="color: #FF0000;font-size: 20px;" class="fa fa-window-close" aria-hidden="true"></i></td>-->
                                                                                                <td style=""><?php echo $result['documento'] ?></td>
                                                                                                    <td style="text-align: center;"><input class="estilo" name="verificar[]" id="verificar_doc<?php echo $i ?>" type="checkbox" disabled=""/></td>   
                                                                                                    <td>
                                                                                                        <div class="btn-group"> 
                                                                                                            <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" disabled=""></textarea>
                                                                                                            <button title="Historial de Observaciones" class="btn btn-sm btn-success" type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td style="text-align:center;font-size:14px"><div class="bg-danger p-xxs"><b>NO RECIBIDO</b></div></td>
                                                                                                
                                                                                        
                                                                                    <?php $cont_doc=$cont_doc+1;                                                                                   
                                                                                    }  ?>  
                                                                                </tr>
                                                                        <?php   
                                                                                echo '<input type="hidden" name="estado[]" id="estado'.$i.'" value="'.$estado.'" />';
                                                                                $i++; }
                                                                                
                                                                            if ($cont_doc==$i) {
                                                                                $sin_archivos=true;
                                                                            } else {
                                                                                $sin_archivos=false;
                                                                            }
                                                                            ?>
                                                                            <tr style="margin-top:2%;padding: 0.5% 0%;border-radius:5px;border:2px #c0c0c0 solid">
                                                                                <td colspan="2"></td>
                                                                                <td colspan="2">
                                                                                            <?php if ($result_contratista['acreditada']!=1) { ?>
                                                                                                    <button style="font-size:14px" id="btnenviar" class="btn btn-md btn-success font-bold btn-block" type="button" onclick="enviar(<?php echo $i ?>)" >PROCESAR DOCUMENTOS</button>
                                                                                            <?php } ?>                                                                        
                                                                                </td>
                                                                            <tr>
                                                                            
                                                                        </tbody>
                                                                    </table>  
                                                                    </div>   
                                                                    </div> 
                                                                <input type="hidden"  name="doc" value="<?php echo $result_doc['doc'] ?>" />
                                                                <input type="hidden" id="control" value="<?php echo $result_obs['control'] ?>" />                                                                 
                                                            </form>  
                                                    </div>        
                                                    </div>           
                                    
                                            </div>
                                        </div> 
                                        
                                <?php } else { ?>

                                            <div style="margin-top: 3%;" class="row">  
                                                <div class="table table-responsive">
                                                        <table class="table table-stripped" data-page-size="15" data-filter="#filter">
                                                            <thead>
                                                                <tr style="background:#e9eafb;color:#282828;font-weight:bold">
                                                                    <th style="width: 3%;" >#</th>
                                                                    <th style="width: 97%;">Documentos de la Contratista</th>
                                                                </tr>
                                                            </thead>
                                                                
                                                            <tbody>

                                                            <?php 
                                                                $i=1;
                                                                foreach ($doc as $row) {
                                                                    
                                                                    $sql=mysqli_query($con,"select  s.* from doc_subidos_contratista as s  where s.id_documento='$row' and s.mandante='$mandante' and s.contratista='$contratista' ");  
                                                                    $result=mysqli_fetch_array($sql);  
                                                            
                                                                    $carpeta=str_replace('doc/temporal/','doc/validados/',$result['url']);

                                                                    
                                                                    #if ($row!=13) {
                                                                    #    $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$result_contratista['rut'].'.pdf';
                                                                    #} else {
                                                                    #    $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$result_contratista['rut'].'.xlsx';
                                                                    #}    
                                                                ?>        
                                                                <tr>
                                                                    <td style="font-weight:700"><?php echo $i ?></td>
                                                                    <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $result['documento'] ?></a></td>

                                                                </tr> 
                                                                <?php $i++;} ?>
                                                        
                                                                <!-- documentos extras --->    
                                                                <?php
                                                                    $query_de=mysqli_query($con,"select d.estado as estado_doc, d.*, c.rut from documentos_extras as d left join contratistas as c On c.id_contratista=d.contratista where d.contratista='".$contratista."' and d.tipo=1 and d.estado=3 ");
                                                                    $result_de=mysqli_fetch_array($query_de);
                                                                    $cantidad=mysqli_num_rows($query_de);

                                                                    $j=$i;    
                                                                    # si hat documentos extras                                                
                                                                    if ($cantidad>0) {

                                                                        foreach ($query_de as $row) {

                                                                            

                                                                            # si doc esta acreditado
                                                                            if ($row['estado_doc']==3) {
                                                                                $carpeta = 'doc/validados/'.$_SESSION['mandante'].'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf'; 
                                                                            } else {
                                                                                $carpeta = 'doc/temporal/'.$_SESSION['mandante'].'/'.$contratista.'/'.$row['documento'].'_'.$row['rut'].'.pdf';      
                                                                            }

                                                                ?>
                                                                            <tr>                                            
                                                                                
                                                                                <td><?php echo $j ?></td>
                                                                                            
                                                                                <!-- documento  -->
                                                                                <td style=""><a href="<?php echo $carpeta ?>" target="_blank"><?php echo $row['documento'] ?></a></td>

                                                                            </tr>
                                                                <?php   $j++;}
                                                                    }
                                                                ?>  
                                                            
                                                            </tbody>
                                                        </table>
                                                </div>    
                                            </div>        



                                        <?php }  ?>    
                                        
                             </div>
                        </div>
                      </div>
                   </div> 
                 </div>
                 
                 
                                                        <script>
                                                               function modal_ver_obs(id_doc,id_obs,condicion) {
                                                                     // alert(id_doc+' '+id_obs);
                                                                      //var condicion=0;
                                                                      $('.body').load('selid_ver_obs_doc.php?doc='+id_doc+'&id_dobs='+id_obs+'&condicion='+condicion,function(){
                                                                                $('#modal_ver_obs').modal({show:true});
                                                                    });
                                                                } 
                                                        </script> 
                                                        
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
                                                        
                                                        <!-- modal cargando--->
                                                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                                                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-body text-center">
                                                                <div class="loader"></div>
                                                                  <h3>Procesando documentos, por favor espere un momento</h3>
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
    
       <!-- Ladda -->
    <script src="js\plugins\ladda\spin.min.js"></script>
    <script src="js\plugins\ladda\ladda.min.js"></script>
    <script src="js\plugins\ladda\ladda.jquery.min.js"></script>



</body>


</body>

</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
