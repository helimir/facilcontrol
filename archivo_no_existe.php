<?php
/**
 * @author helimirlopez
 * @copyright 2021
 */
session_start();

if (isset($_SESSION['usuario'])) { 
include('config/config.php');

#header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
#header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado

   

setlocale(LC_MONETARY,"es_CL");
$dia=date('d');
$mes=date('m');
$year=date('Y');


$contratista=$_SESSION['contratista'];
$mandante=$_SESSION['mandante'];

if ($_SESSION['mandante']==0) {
   $razon_social="NO SELECCIONADO";     
} else {
    $query_m=mysqli_query($con,"select * from mandantes where id_mandante=$mandante ");
    $result_m=mysqli_fetch_array($query_m);
    $razon_social=$result_m['razon_social'];
}



$query_contratista=mysqli_query($con,"select d.acreditada as acreditacion, d.*, c.* from contratistas as c Left Join contratistas_mandantes as d On d.contratista=c.id_contratista where c.id_contratista='$contratista' and d.mandante='".$_SESSION['mandante']."' ");
$result_contratista=mysqli_fetch_array($query_contratista); 


$query_cm=mysqli_query($con,"select * from contratistas_mandantes where contratista='$contratista' and mandante='".$_SESSION['mandante']."' ");
$result_cm=mysqli_fetch_array($query_cm);

$doc=unserialize($result_contratista['doc_contratista']);
$doc_mensuales=unserialize($result_contratista['doc_contratista_mensuales']);

$rut_contratista=$result_contratista['rut'];
$acreditada=$result_contratista['acreditacion'];

$cant_doc=$result_cm['cant_doc'];

$query_obs=mysqli_query($con,"select * from doc_observaciones where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs=mysqli_fetch_array($query_obs);
$list_veri=unserialize($result_obs['verificados']);

$query_obs_m=mysqli_query($con,"select * from mensuales where mandante='".$_SESSION['mandante']."' and contratista='".$_SESSION['contratista']."' ");
$result_obs_m=mysqli_fetch_array($query_obs_m);
if(isset($result_obs_m['verificados'])){
    $list_veri_m=unserialize( $result_obs_m['verificados']);
}
#$list_veri_m=unserialize( $result_obs_m['verificados'])

?>

<!DOCTYPE html>
<meta name="google" content="notranslate" />    
<html lang="es-ES">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    
    
    <title>FacilControl | Gestión Documentos</title>
    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/icono2_fc.png" rel="apple-touch-icon">

    <link href="css\bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome\css\font-awesome.css" rel="stylesheet">
    <link href="css\plugins\iCheck\custom.css" rel="stylesheet">
    <link href="css\animate.css" rel="stylesheet">
    <link href="css\style.css" rel="stylesheet">    

    <link href="css\plugins\awesome-bootstrap-checkbox\awesome-bootstrap-checkbox.css" rel="stylesheet">

    <!-- FooTable -->
    <link href="css\plugins\footable\footable.core.css" rel="stylesheet">

    <script src="js\jquery-3.1.1.min.js"></script>


<script>

  function selmandante(id){
    //alert(id); 
    if (id==0) {
         swal({
            title: "Selecciona un Mandante a consultar",
            //text: "Un Documento no validado esta sin comentario",
            type: "warning"
         });  
    } else {
        $.post("sesion/doc_contratistas_mandantes.php", { id: id }, function(data){
            window.location.href='gestion_documentos.php';
        });
    }     
}   

    
 $(document).ready(function (){
    
    $('.footable').footable();
    $('.footable2').footable();

    $('#menu-gestion').attr('class','active');
       
    $("#modal_no_aplica").on('hidden.bs.modal', function () {        
        var num=$("#num_na").val();        
        $("#aplica"+num).prop("checked", false);
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
   
    function cargar_doc_contratista(cant){
        alert('p')
          
          var extension=true;
          var contador=0;
         
          for (i=0;i<=cant-1;i++) {
                var filename = $('#carga_doc'+i).val()
                if (filename!='') {
                    contador++;    
                }
          }
                      
          if (contador>0) {                        
                        var arreglo_doc=[];
                        var arreglo_com=[];
                        var arreglo_fil=[];
                        var arreglo_est=[];
                        var formData = new FormData();                        
                                  
                        for (i=0;i<=cant-1;i++) {                            
                            var filename = $('#carga_doc'+i).val();
                            if (filename!='') {
                                var valor_doc=$('#cadena_doc'+i).val();
                                arreglo_doc.push(valor_doc);
                                
                                var valor_com=$('#comentario'+i).val();
                                arreglo_com.push(valor_com);                               
                                formData.append('carga_doc[]',$('#carga_doc'+i)[0].files[0]);                                  
                            } 
                        }
                        
                        var doc=JSON.stringify(arreglo_doc);
                        formData.append('doc', doc );
                        
                        var com=JSON.stringify(arreglo_com);
                        formData.append('com', com );
                        
                        formData.append('cant', cant );
                         
                        //alert(doc+'/'+com+'/'+'/'+cant)
                        $.ajax({
                                url: 'cargar/cargar_documentos_contratistas.php',
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
                                success: function(data) {
                                    $('#modal_cargar').modal('hide');
                                    if(data== 0){                                        
                                        //swal({
                                        //        title: "Documento Enviado",
                                                //text: "Un Documento no validado esta sin comentario",
                                        //        type: "success"
                                        //      });
                         	             window.location.href='gestion_documentos.php';
                                    } else {
                                          
                                          swal({
                                                title: "Documeto No Cargado",
                                                text: "Vuelva a intetar",
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
            title: "Sin Documento(s) Seleccionado",
            text: "Debe adjuntar al menos un Documento",
            type: "warning"
         });
      }                 
    }

    function cerrar_no_aplica() {
        var num=$("#num_na").val();        
        $("#modal_no_aplica").modal('hide');
        $("#aplica"+num).prop("checked", false);
    }

    function guardar_no_aplica(mandante) {        
      var num=$("#num_na").val();
      var doc=$("#doc_na").val();  
      var documento=$("#documento_na").val();  
      var rut=$("#rut_na").val();  
      var contratista=$("#contratista_na").val();    
      var mensaje_nax=$("#mensaje_na").val(); 
      var estado=$("#estado_doc"+num).val(); 
      //alert(doc)
      if (mensaje_nax=='') {
            swal({
               title: "Debe ingresar un mensaje",
               //text: "Un Documento no validado esta sin comentario",
               type: "warning"
            })
      } else {
        
         $.ajax({
            method: "POST",
            url: "add/addnoaplica.php",
            data:'contratista='+contratista+'&doc='+doc+'&mensaje='+mensaje_nax+'&mandante='+mandante, 
            success: function(data){
                  if (data==0) {
                        swal({
                            title: "Documento Enviado",
                            //text: "Un Documento no validado esta sin comentario",
                            type: "success"
                        });

                        $("#modal_no_aplica").modal('hide');
                        $("#modal_no_aplica").on('hidden.bs.modal', function () {   
                            $("#aplica"+num).prop("checked", true);
                        });
                        
                        //sin documento
                        if (estado==1) {
                            var url='doc/temporal/'+mandante+'/'+contratista+'/'+documento+'_'+rut+'.pdf';
                            $('#td_documento'+num).attr('href', url);
                            document.getElementById('td_documento'+num).innerHTML='<a target="_BLACK" href="'+url+'">'+documento+'</a>';                        
                            document.getElementById('span_seleccionar'+num).style.background='#282828';
                            
                            $('#carga_doc'+num).attr('type', 'button');
                            var funcion='prueba('+num+')';
                            $('#carga_doc'+num).attr('onclick', funcion);

                            $('#estado'+num).removeAttr('class');
                            $('#estado'+num).attr('class','bg-info p-xxs');                                                                
                            document.getElementById('estado'+num).innerHTML='<b style="font-14px">EN PROCESO</b>';

                            // proceso de cambiar el noaplica de una vez si es un error y se debe subir archivo
                            document.getElementById('div_seleccionar2'+num).remove();
                            document.getElementById('div_seleccionar'+num).style.display='block';

                        }    

                        // documento en observacion
                        if (estado==3) {                            
                            // cambiar estado a EN PROCESO                                                  
                            $('#estado'+num).removeAttr('class');
                            $('#estado'+num).attr('class','bg-info p-xxs');                                                                
                            document.getElementById('estado'+num).innerHTML='<b style="font-14px">EN PROCESO</b>';
                            // quitar mensaje 
                            document.getElementById('mensaje'+num).innerHTML='';
                            document.getElementById('span_seleccionar'+num).style.background='#282828';
                        }  
                        
                  } else {
                    swal({
                        title: "Disculpe, Error de Sistema",
                        text: "Vuelva a Intentar",
                        type: "warning"
                    })
                  }
            }   
         });
      }
   }  

   function retirar (doc,contratista,mandante,rut,nombre_doc) {
    //alert(doc+' '+contratista+' '+mandante+' '+rut+' '+nombre_doc)
    swal({
        title: "Retirar Documento",
        //text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, retirar",
        closeOnConfirm: false
    }, function () {
        $.ajax({
            method: "POST",
            url: "add/retirar_documento.php",
            data:'contratista='+contratista+'&doc='+doc+'&mandante='+mandante+'&rut='+rut+'&documento='+nombre_doc, 
            success: function(data){
                if (data==0) {                    
                    window.location.href='gestion_documentos.php';
                }
                if (data==1) {                    
                    swal({
                        title:"Disculpe, Error de Sistema",
                        text: "Vuelva a intentar",
                        type: "warning"
                        })
                }
            }  
         });
    });
   }


   function prueba(num,opcion) {
    var estado=$("#estado_doc"+num).val();
    swal({
                title: "Sustituir Documento No Aplica",
                text: "El nuevo documento sustituye al anterior",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Si, sustituir",
                closeOnConfirm: false
            }, function () {

                if (opcion==1) {
                    alert(opcion)
                    document.getElementById('div_seleccionar'+num).remove();
                    document.getElementById('div_seleccionar3'+num).style.display='block';
                }

                if (opcion==4 || opcion==3 || opcion==2) {
                    alert(opcion)
                    //$('#input_na'+num).attr('type', 'file');
                    //$('#input_na'+num).removeAttr('onclick');
                    document.getElementById('div_seleccionar'+num).remove();
                    document.getElementById('div_seleccionar2'+num).style.display='block';
                    document.getElementById('span_seleccionar'+num).style.backgroundColor='#282828';
                    document.getElementById('span_seleccionar'+num).style.border='none';
                    document.getElementById('span_seleccionar'+num).style.color='#fff';
                    document.getElementById('span_seleccionar'+num).style.innerHTML='Sustituir Archivo';
                    
                    //$('#carga_doc'+num).removeAttr('onclick');
                    //('#carga_doc'+num).removeAttr('type');
                    //$('#carga_doc'+num).Attr('type','file');
                    //$('#estado'+num).attr('class','bg-danger p-xxs');                                                                
                    //document.getElementById('estado'+num).innerHTML='<b style="font-14px">NO ENVIADO</b>';
                    // quitar enlace en nombre de documento
                    //$('#td_documento'+num).removeAttr('href');
                } 
                

                swal("Confirmado, continuar con Seleccion de Archivo", "", "success");
            });
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
        border-bottom:2px #fff solid;
    }   
     
    .hidden {
         display: none; /* Oculta la celda */
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
                    <h2 style="color: #010829;font-weight: bold;">DOCUMENTOS DE LA CONTRATISTA <?php   ?></h2>
                    <label class="label label-warning encabezado">Mandante: <?php echo $razon_social ?></label>     
                </div>
            </div>
      
            <div class="wrapper wrapper-content animated fadeIn">
               
                <form id="frmDocContratista" enctype="multipart/form-data">   
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox ">
                                <div class="ibox-content">

                                     <div class="form-group row">
                                            <div class="col-lg-12 col-sm-12 col-sm-offset-2">
                                                <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-2 col-sm-12"  href="list_contratos_contratistas.php" class="" >CONTRATOS</a>
                                                <a style="margin-top:1%;font-weight:bold" class="btn btn-sm btn-success btn-submenu col-lg-3 col-sm-12"  href="gestion_contratos_contratistas.php" class="" >GESTION DE CONTRATOS</a>
                                                <!--<button class="ladda-button ladda-button-demo btn btn-primary" data-style="zoom-in">Submit</button>-->
                                            </div>
                                        </div>                                                    
                                       <?php include('resumen.php') ?>
                                       <br>
                              
                                                                   <?php $estado='1';  ?>

                                                                        <div style="margin-top: 3%;" class="row">  
                                                                            <div class="table table-responsive">
                                                                                <table style="width: 100%;" class="footable table" data-page-size="25" data-filter="#filter">
                                                                                    <thead >
                                                                                        <tr>
                                                                                            <th style="width: 3%;"></th>
                                                                                            <th style="width: 3%;" ></th>                                                        
                                                                                            <th style="width: 25%;">Documentos para Revisi&oacute;n</th>
                                                                                            <th style="width: 28%;" data-hide="">Observaciones</th>
                                                                                            <th style="width: 10%;" data-hide="">Verificado</th>
                                                                                            <th style="width: 15%;text-align: center" data-hide="">Adjuntar</th>

                                                                                            <th data-hide="all" style="width: 6%;text-align: center">N/A</th>                                                                                            
                                                                                            <th data-hide="all" style="width: 10%;text-align: center">Estado</th>
                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>     

                                                                                        <?php                                                                                                                                                                                                                        
                                                                                            $i=0; 
                                                                                            $cont_veri=0;
                                                                                            $cont_doc=0;
                                                                                            $comentario=array();
                                                                                            $cadena=array();
                                                                                            $estado=array();
                                                                        
                                                                                            foreach ($doc as $row) {
                                                                                                $cont_doc=$cont_doc+1; 
                                                                                                $sql=mysqli_query($con,"select * from doc_contratistas where id_cdoc='$row' ");  
                                                                                                $result=mysqli_fetch_array($sql);  
                                                                                                
                                                                                                $query_com=mysqli_query($con,"select * from doc_comentarios where id_dobs='".$result_obs['id_dobs']."' and doc='".$result['documento']."' and estado=0  order by id_dcom desc  ");
                                                                                                $result_com=mysqli_fetch_array($query_com);
                                                                                                $list_com=$result_com['comentarios'];

                                                                                                $query_noaplica=mysqli_query($con,"select * from noaplica where documento='$row' and contratista='$contratista' and mandante='$mandante' ");
                                                                                                $resul_noaplica=mysqli_fetch_array($query_noaplica);
                                                                                            
                                                                                                #$carpeta='doc/contratistas/'.$contratista.'/'.$result['documento'].'_'.$rut_contratista.'.pdf';
                                                                                                
                                                                                                $query_v=mysqli_query($con,"select estado from doc_observaciones where contratista='$contratista' and mandante='$mandante' ");
                                                                                                $result_v=mysqli_fetch_array($query_v);
                                                                                                
                                                                                                if ($acreditada==1) {
                                                                                                    $carpeta='doc/validados/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$rut_contratista.'.pdf';
                                                                                                } else { 
                                                                                                    $carpeta='doc/temporal/'.$mandante.'/'.$contratista.'/'.$result['documento'].'_'.$rut_contratista.'.pdf';
                                                                                                } 
                                                                                                
                                                                                                
                                                                                                $archivo_existe=file_exists($carpeta); 
                                                                                                
                                                                                                $cadena[$i]=$result['id_cdoc'];
                                                                                                $comentario[$i]=$result_com['id_dcom'];
                                                                                                
                                                                                                ?>
                                                                                                    <tr>
                                                                                                        <td data-toggle="true"></td>

                                                                                                        <!-- borrar -->
                                                                                                        <input type="hidden" id="estado_doc<?php echo $i ?>" value="1">                                                                        
                                                                                                        <td style="text-align:center;"><button style="background:#969696;border: 1px solid #969696" class="btn btn-sm btn-success" disabled > <i style="color: #fff;font-size: 15px;" class="fa fa-trash"  aria-hidden="true"></i></button></td>   

                                                                                                        <!-- documento -->
                                                                                                        <td id="td_documento<?php echo $i ?>" ><?php echo $result['documento'] ?></td>
                                                                                                        
                                                                                                        <!-- observaciones -->
                                                                                                        <td>
                                                                                                            <div class="btn-group"> 
                                                                                                                <textarea cols="50" rows="1" name="mensaje[]" id="mensaje<?php echo $i ?>" class="form-control" readonly=""></textarea>
                                                                                                                <button class="btn btn-sm btn-success " type="button" disabled=""><i style="color: ;font-size: 20px;" class="fa fa-search-plus" aria-hidden="true"></i></button>
                                                                                                            </div>
                                                                                                        </td>
                                                                                                        
                                                                                                        <!-- verificado -->
                                                                                                        <td style="text-align: center;"><input class="estilo" name="verificar[]" id="verificar_doc<?php echo $i ?>" type="checkbox" disabled=""/></td>
                                                                                                        
                                                                                                        <!-- adjuntar -->
                                                                                                        <td id="div_seleccionar2<?php echo $i ?>"  style="text-align:center;">
                                                                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                                                                    <span id="span_seleccionar<?php echo $i ?>" style="background: #282828;color: #000;border:##282828;color:#fff;width:100%" class="btn btn-default btn-file "><span class="fileinput-new">Archivo</span>
                                                                                                                    <span class="fileinput-exists">Cambiar</span><input id="carga_doc<?php echo $i ?>" name="carga_doc[]" type="file" accept="application/pdf"   /></span>
                                                                                                                    <span class="fileinput-filename"></span>                                                             
                                                                                                                    <a title="Quitar" href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none"> <i class="fa fa-times-circle" aria-hidden="true"></i></a>
                                                                                                                </div>
                                                                                                        </td>                                                                                                        


                                                                                                        <!-- no aplica -->
                                                                                                        <td style="text-align: center;"><input class="estilo" name="aplica[]" id="aplica<?php echo $i ?>" type="checkbox" onclick="modal_no_aplica(<?php echo $row ?>,<?php echo $i ?>,'<?php echo $result['documento'] ?>',<?php echo $contratista ?>,<?php echo $mandante ?>,'<?php echo $rut_contratista ?>' )" value="<?php echo $row  ?>"  /></td>
                                                                                                    
                                                                                                        <!-- esTado -->
                                                                                                        <td style="text-align:center"><span class="badge badge-danger p-xxs">NO ENVIADO</span></td>
                                                                                                        
                                                                                                    </tr> 
                                                                                                </tbody>            
                                                                                    <?php } ?> 
                                                                        
                                                                                    <?php                                      
                                                                                    echo '<input type="hidden" name="cadena_doc[]" id="cadena_doc'.$i.'" value="'.$result['id_cdoc'].'" />';
                                                                                    echo '<input type="hidden" name="comentario[]" id="comentario'.$i.'" value="'.$result_com['id_dcom'].'" />';
                                                                                    echo '<input type="hidden" name="estado[]" id="estado'.$i.'" value="'.$estado.'" />';
                                                                                    $i++; ?>  
                                                            
                                                                            <?php  ?> 
                                                
                                                                        </table>
                                                                    </div>  
                                                                </div>              
                                        
                                                    <hr>                               
                                                    <div style="" class="form-group row">
                                                        <div class="col-lg- col-sm-12 col-xs-12">
                                                            <?php if ($result_contratista['acreditada']!=1) { ?>
                                                                        <button style="font-size:14px" title="Cargar Archivo" class="btn-success btn btn-md btn-block font-bold" type="button" onclick="cargar_doc_contratista(<?php echo $i ?>)" >PROCESAR DOCUMENTOS SOLICITADOS <?php  ?></button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                            <!--<tr style="margin-top:2%;padding: 0.5% 0%;border-radius:5px;border:2px #c0c0c0 solid">
                                                                <td  colspan="4">  
                                                                        <label style="background: #333;color:#fff;padding: 0% 2% 0% 2%;border-radius: 10px;" ><span style="color: #F8AC59;font-weight: bold;">NOTA IMPORTANTE: </span> Documento cargado sustituye al anterior. </label>                                                                  
                                                                </td>                                                                
                                                            </tr>-->                                   
                                          
                                        
                                        <input type="hidden" name="doc" value="<?php echo $result_doc['doc'] ?>" />    
                                
                            
                                                        
                                </div>
                            </div>
                        </div> 
                    </div>
                </form>
               
                        <script>
                        
                             
                               
                               function adjuntar_doc_empresa(doc,contratista,com,condicion) {
                                  //alert(doc);
                                   $('.body').load('selid_documentos_contratistas.php?doc='+doc+'&contratista='+contratista+'&com='+com+'&condicion='+condicion,function(){
                                         $('#modal_archivos_empresa').modal({show:true});
                                   });
                               }
                               
                               function modal_ver_obs(id_doc,id_obs,condicion) {
                                     // alert(id_doc+' '+id_obs);
                                      //var condicion=0;
                                      $('.body').load('selid_ver_obs_doc.php?doc='+id_doc+'&id_dobs='+id_obs+'&condicion='+condicion,function(){
                                                $('#modal_ver_obs').modal({show:true});
                                    });
                                } 

                                function modal_no_aplica(id_doc,num,doc,contratista,mandante,rut) { 
                                    //document.getElementById("estado_na"+num).innerHTML="<small>N/A<small>";                                                                   
                                    if ($('#aplica'+num).is(':checked')) {                                        
                                        document.getElementById("doc_text").innerText=doc;
                                        $('#modal_no_aplica #doc_na').val(id_doc);   
                                        $('#modal_no_aplica #num_na').val(num); 
                                        $('#modal_no_aplica #contratista_na').val(contratista)
                                        $('#modal_no_aplica #mandante_na').val(mandante)
                                        $('#modal_no_aplica #documento_na').val(doc)
                                        $('#modal_no_aplica #rut_na').val(rut)
                                        $('#modal_no_aplica').modal({show:true});
                                    } else {

                                        swal({
                                            title: "Retirar Documento No Aplica",
                                            //text: "You will not be able to recover this imaginary file!",
                                            type: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText: "Si, retirar",
                                            closeOnConfirm: false
                                        }, function () {
                                            $.ajax({
                                                        method: "POST",
                                                        url: "add/addquitarnoaplica.php",
                                                        data:'contratista='+contratista+'&doc='+id_doc+'&mandante='+mandante+'&rut='+rut, 
                                                        success: function(data){
                                                            if (data==0) {     
                                                                
                                                                // poner boto seleccionar en negro
                                                                document.getElementById('span_seleccionar'+num).style.backgroundColor='#282828';
                                                                
                                                                // quitar enlace en nombre de documento
                                                                $('#td_documento'+num).removeAttr('href');                                                                
                                                                
                                                                // cambiar estado a EN PROCESO                                                  
                                                                $('#estado'+num).removeAttr('class');
                                                                $('#estado'+num).attr('class','bg-danger p-xxs');                                                                
                                                                document.getElementById('estado'+num).innerHTML='<b style="font-13px">NO ENVIADO</b>';
                                                                
                                                                // quitar mensaje 
                                                                document.getElementById('mensaje'+num).innerHTML='';

                                                                $("#aplica"+num).prop("checked", false);

                                                                document.getElementById('div_seleccionar'+num).style.display='none';
                                                                document.getElementById('div_seleccionar2'+num).style.display='block';
                                                                document.getElementById('span_seleccionar'+num).style.backgroundColor='#b3992e';
                                                                
                                                                swal({
                                                                    title: "Documento Contraista No Aplica Retirado",
                                                                    //text: "Un Documento no validado esta sin comentario",
                                                                    type: "success"
                                                                })
                                                                
                                                                
                                                                
                                                            } else {
                                                                swal({
                                                                    title:"Disculpe, Error de Sistema",
                                                                    text: "Vuelva a intentar",
                                                                    type: "warning"
                                                                })
                                                            }
                                                        }   
                                                    });
                                        });
                                        $("#aplica"+num).prop("checked", true);
                                                                           
                                   }
                                }  


                                function modal_contratistas(opcion) {
                                        $('.body').load('sel/selid_resumen_contratistas.php?opcion='+opcion,function(){
                                            $('#modal_contratistas').modal('show');
                                    });
                                }
                        
                        </script>

                            <div class="modal inmodal" id="modal_contratistaszzzzz" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content animated fadeIn">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                            <h4 class="modal-title">Documentos relacionados con la Contratista</h4>
                                            <p>Reporte de tareas pendientes por atender sobre la Contratista</p>
                                        </div>
                                        <div class="body">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        <div class="modal inmodal" id="modal_no_aplica" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content animated fadeIn">
                                            <div style="background:#e9eafb;color:#282828;text-align:center" class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>                                           
                                                <h4 style="font-weight:bold;" id="titulo" class="modal-title">Docs. No Aplica Contratista</h4>
                                            </div>                                   
                                            <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label>Documento:</label>
                                                        </div>            
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <h3 id="doc_text" class="form-label"></h3>                                                        
                                                        </div>            
                                                    </div>                                                    
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <textarea rows="3" class="form-control" id="mensaje_na" name="mensaje_na" type="text" placeholder="escriba un mensaje"></textarea>
                                                        </div>            
                                                    </div>
                                            </div>
                                            <input type="hidden" id="num_na" name="num_na" >
                                            <input type="hidden" id="contratista_na" name="contratista_na" >
                                            <input type="hidden" id="mandante_na" name="mandante_na" >
                                            <input type="hidden" id="doc_na" name="doc_na" >
                                            <input type="hidden" id="documento_na" name="documento_na" >
                                            <input type="hidden" id="rut_na" name="rut_na" >
                                            
                                            <div class="modal-footer">        
                                                        <a style="color: #fff;" class="btn btn-secondary btn-sm"  onclick="cerrar_no_aplica()" >Cancelar</a>    
                                                        <a style="color: #fff;" class="btn btn-success btn-sm" onclick="guardar_no_aplica(<?php echo $mandante ?>)" >Enviar Solicitud</a>
                                            </div>                            
                                   </div>
                                </div>
                            </div> 
                        
                        
                        <div class="modal  fade" id="modal_archivos_empresa" tabindex="-1" role="dialog" aria-hidden="true">
                                <div  class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div style="background: #010829;color: #FFFFFF;" class="modal-header">
                                          <h3 class="modal-title" id="exampleModalLabel"><i class="fa fa-info-circle" aria-hidden="true"></i> Adjuntar Documento Contratista</h3>
                                          <button style="color: #FFFFFF;" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="body">
                                        </div> 
                                        <div class="modal-footer">
                                           <button style="color: #fff;" class="btn btn-danger" value="" onclick="window.location.href='gestion_documentos.php'" ><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
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
                        
                        <div class="modal fade bd-example-modal-lg" id="modal_cargar1" data-backdrop="static" data-keyboard="false" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content" style="width: 100%">
                                    <span style="color: #FFFFFF;" class="fa fa-spinner fa-spin fa-3x"></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal fade" id="modal_cargar2" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
                          <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-body text-center">
                                <div class="loader"></div>
                                  <h3>Cargando Archivos, por favor espere un momento</h3>
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

    
    <!-- FooTable -->
    <script src="js\plugins\footable\footable.all.min.js"></script>
    
    <!-- Sweet alert -->
    <script src="js\plugins\sweetalert\sweetalert.min.js"></script>

</body>




</html>
<?php } else { 

echo "<script> window.location.href='admin.php'; </script>";
}

?>
